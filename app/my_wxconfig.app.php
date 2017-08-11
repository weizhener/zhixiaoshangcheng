<?php

/* 微公众平台接口管理控制器 */

class My_wxconfigApp extends StoreadminbaseApp {

    var $_store_id;
    var $my_wxconfig_mod;

    function __construct() {
        $this->My_wxconfig();
    }

    function My_wxconfig() {
        parent::__construct();
        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->my_wxconfig_mod = & m('wxconfig');
    }

    function index() {
        if (!IS_POST) {
            $wx_config = $this->my_wxconfig_mod->get_info_user($this->_store_id);
            
            if (empty($wx_config['token'])) {
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                for ($i = 0; $i < 8; $i++) {
                    $wx_config['token'] .= $chars[mt_rand(0, strlen($chars) - 1)];
                }
            }
            
            $wx_config['url'] = SITE_URL . '/index.php?app=weixin&id=' . $this->_store_id;
            $this->assign('wx_config', $wx_config);

            $this->import_resource('jquery.plugins/jquery.validate.js');
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_wxconfig'), 'index.php?app=my_wxconfig', LANG::get('my_wxconfig'));
            /* 当前用户中心菜单 */
            $this->_curitem('my_wxconfig');
            /* 当前所处子菜单 */
            $this->_curmenu('my_wxconfig');
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_wxconfig'));
			
			 $this->assign('type', array(
            '0' =>"订阅号和服务号",
           '1' =>"认证服务号",
        ));
            $this->display('my_wxconfig.index.html');
        } else {
            $data = array(
                'user_id' => $this->_store_id,
                'url' => $_POST['url'],
                'token' => $_POST['token'],
				'type' => $_POST['type'],
				'name' => $_POST['name'],
            );
            $w_id = $this->my_wxconfig_mod->unique($this->_store_id);
            if ($w_id) {
                $this->my_wxconfig_mod->edit($w_id, $data);
                if ($this->my_wxconfig_mod->has_error()) {
                    $this->show_warning($this->my_wxconfig_mod->get_error());

                    return;
                }
					$pic=$this->_upload_image2($this->_store_id);
				
				
				$this->my_wxconfig_mod->edit($w_id, $pic);
				
                $this->show_message('edit_wxconfig_successed');
            } else {
                $this->my_wxconfig_mod->add($data);
                if ($this->my_wxconfig_mod->has_error()) {
                    $this->show_warning($this->my_wxconfig_mod->get_error());
                    return;
                }
				
				$pic=$this->_upload_image2($this->_store_id);
				
				$this->my_wxconfig_mod->edit($w_id, $pic);
                $this->show_message('edit_wxconfig_successed');
            }
        }
    }
	
	function _upload_image2($store_id) {
        import('uploader.lib');
        $uploader = new Uploader();
       $uploader->allowed_type(IMAGE_FILE_TYPE);
        $uploader->allowed_size(2048000); // 2M
        $data = array();
         
            $file = $_FILES['pic'];
		
            if ($file['error'] == UPLOAD_ERR_OK) {
            
                $uploader->addFile($file);
                if (!$uploader->file_info()) {
                    $this->_error($uploader->get_error());
                    return false;
                }
				

                $uploader->root_dir(ROOT_PATH);
                $dirname = 'data/files/'.'store_' . $store_id .'/images';
				$filename  ="images";
				// $filename  = $uploader->random_filename();
               // $filename = 'store_' . $store_id . '_' . $i;
                $data['pic'] = $uploader->save($dirname, $filename);
            }
        
        return $data;
    }


    /**
     *    三级菜单
     *
     *    @author    Hyber
     *    @return    void
     */
    function _get_member_submenu() {
        $submenus = array(
            array(
                'name' => 'my_wxconfig',
                'url' => 'index.php?app=my_wxconfig',
            ),
        );
        return $submenus;
    }

}

?>