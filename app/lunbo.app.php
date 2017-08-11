<?php

class LunboApp extends StoreadminbaseApp
{
    
    var $_store_id;
    var $_store_mod;
    
    function __construct() {
        $this->LunboApp();
    }
    function LunboApp() {
        parent::__construct();
        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->_store_mod = & m('store');
    }
    
    function index()
    {
        $store = $this->_store_mod->get(array('conditions' => 'store_id=' . $this->_store_id, 'fields' => 'pic_slides_wap'));
        
        if (!IS_POST) {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('lunbo'));
            $this->_curitem('lunbo');
            
            $pic_slides_wap = array();

            if ($store['pic_slides_wap']) {
                $pic_slides_wap_arr = json_decode($store['pic_slides_wap'], true);
                
                foreach ($pic_slides_wap_arr as $key => $slides) {
                    $pic_slides_wap['pic_slides_wap_url_' . $key] = $slides['url'];
                    $pic_slides_wap['pic_slides_wap_link_' . $key] = $slides['link'];
                }
            }

            $this->assign('slides', $pic_slides_wap);

            $this->display('lunbo.index.html');
            
        } else {
            
            $pic_slides_wap_arr = $this->_upload_slides();
            
            if($pic_slides_wap_arr == FALSE){
                return;
            }
            
            $all_slides = array();


            if (empty($store['pic_slides_wap'])) {
                $all_slides = json_encode($pic_slides_wap_arr);
            } else {
                $old_pic_slides_wap_arr = json_decode($store['pic_slides_wap'], true);
                foreach ($pic_slides_wap_arr as $key => $slides) {
                    if (!empty($slides['url'])) {
                        $old_pic_slides_wap_arr[$key]['url'] = $slides['url'];
                    }
                    if (!empty($slides['link'])) {
                        $old_pic_slides_wap_arr[$key]['link'] = $slides['link'];
                    }
                }
                $all_slides = json_encode($old_pic_slides_wap_arr);
            }
            $this->_store_mod->edit($this->_store_id, array('pic_slides_wap' => $all_slides));

            $this->show_message('edit_ok', 'back_list', 'index.php?app=lunbo', 'back_home', 'index.php?app=member');
        }
    }
    
    function _upload_slides() {
        import('uploader.lib');
        $data = array();

        for ($i = 1; $i <= 3; $i++) {
            $file = $_FILES['pic_slides_wap_url_' . $i];
            if ($file['error'] == UPLOAD_ERR_OK && $file != '') {
                $uploader = new Uploader();
                $uploader->allowed_type(IMAGE_FILE_TYPE);
                $uploader->allowed_size(SIZE_GOODS_IMAGE); // 2M
                $uploader->addFile($file);
                if ($uploader->file_info() === false) {
                    $this->show_warning($uploader->get_error());
                    return false;
                }
                $uploader->root_dir(ROOT_PATH);
                $data[$i]['url'] = $uploader->save('data/files/store_' . $this->_store_id . '/pic_slides_wap', 'pic_slides_wap_' . $i);
            } else {
                $data[$i]['url'] = '';
            }

            $data[$i]['link'] = trim($_POST['pic_slides_wap_link_' . $i]);
        }
        return $data;
    }



}
?>
