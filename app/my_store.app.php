<?php

class My_storeApp extends StoreadminbaseApp {

    var $_store_id;
    var $_store_mod;
    var $_uploadedfile_mod;

    function __construct() {
        $this->My_storeApp();
    }

    function My_storeApp() {
        parent::__construct();
        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->_store_mod = & m('store');
        $this->_uploadedfile_mod = &m('uploadedfile');
    }

    function index() {
        $tmp_info = $this->_store_mod->get(array(
            'conditions' => $this->_store_id,
            'join' => 'belongs_to_sgrade',
            'fields' => 'domain, functions',
        ));
        $functions = $tmp_info['functions'] ? explode(',', $tmp_info['functions']) : array();
        $subdomain_enable = false;
        if (ENABLED_SUBDOMAIN && in_array('subdomain', $functions)) {
            $subdomain_enable = true;
        }
        if (!IS_POST) {
            //传给iframe参数belong, item_id
            $this->assign('belong', BELONG_STORE);
            $this->assign('id', $this->_store_id);

            $store = $this->_store_mod->get_info($this->_store_id);
            foreach ($functions as $k => $v) {
                $store['functions'][$v] = $v;
            }

            $this->assign('store', $store);
            $this->assign('editor_upload', $this->_build_upload(array(
                        'obj' => 'EDITOR_SWFU',
                        'belong' => BELONG_STORE,
                        'item_id' => $this->_store_id,
                        'button_text' => Lang::get('bat_upload'),
                        'button_id' => 'editor_upload_button',
                        'progress_id' => 'editor_upload_progress',
                        'upload_url' => 'index.php?app=swfupload',
                        'if_multirow' => 1,
            )));

            extract($this->_get_theme());
            $this->assign('build_editor', $this->_build_editor(array(
                        'name' => 'description',
                        'content_css' => SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}" . '/shop.css', // for preview
            )));

            $msn_active_url = 'http://settings.messenger.live.com/applications/websignup.aspx?returnurl=' .
                    SITE_URL . '/index.php' . urlencode('?app=my_store&act=update_im_msn') . '&amp;privacyurl=' . SITE_URL . '/index.php' . urlencode('?app=article&act=system&code=msn_privacy');
            $this->assign('msn_active_url', $msn_active_url);

            $region_mod = & m('region');
            $this->assign('regions', $region_mod->get_options(0));

            /* 属于店铺的附件 */
            $files_belong_store = $this->_uploadedfile_mod->find(array(
                'conditions' => 'store_id = ' . $this->visitor->get('manage_store') . ' AND belong = ' . BELONG_STORE . ' AND item_id =' . $this->visitor->get('manage_store'),
                'fields' => 'this.file_id, this.file_name, this.file_path',
                'order' => 'add_time DESC'
            ));
            /* 当前页面信息 */
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_store'));
            $this->_curitem('my_store');
            $this->_curmenu('my_store');
            $this->import_resource('jquery.plugins/jquery.validate.js,mlselection.js');
            $this->assign('files_belong_store', $files_belong_store);
            $this->assign('subdomain_enable', $subdomain_enable);
            $this->assign('domain_length', Conf::get('subdomain_length'));
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_store'));
            $this->display('my_store.index.html');
        } else {
            $subdomain = $tmp_info['domain'];
            if ($subdomain_enable && !$tmp_info['domain']) {
                $subdomain = empty($_POST['domain']) ? '' : trim($_POST['domain']);
                if (!$this->_store_mod->check_domain($subdomain, Conf::get('subdomain_reserved'), Conf::get('subdomain_length'))) {
                    $this->show_warning($this->_store_mod->get_error());

                    return;
                }
            }
            $data = $this->_upload_files();
            if ($data === false) {
                return;
            } else { //删除冗余图标
                if ($store['store_logo'] != '' && $data['store_logo'] != '') {
                    $store_logo_old = pathinfo($store['store_logo']);
                    $store_logo_new = pathinfo($data['store_logo']);
                    if ($store_logo_old['extension'] != $store_logo_new['extension']) {
                        unlink($store['store_logo']);
                    }
                }

                if ($store['store_banner'] != '' && $data['store_banner'] != '') {
                    $store_banner_old = pathinfo($store['store_banner']);
                    $store_banner_new = pathinfo($data['store_banner']);
                    if ($store_banner_old['extension'] != $store_banner_new['extension']) {
                        unlink($store['store_banner']);
                    }
                }
            }

            $data = array_merge($data, array(
                'store_name' => $_POST['store_name'],
                'region_id' => $_POST['region_id'],
                'region_name' => $_POST['region_name'],
                'description' => $_POST['description'],
                'address' => $_POST['address'],
                'tel' => $_POST['tel'],
                'im_qq' => $_POST['im_qq'],
                'im_ww' => $_POST['im_ww'],
                'service_begin' => $_POST['service_begin'],
                'service_end' => $_POST['service_end'],
                'service_arrive' => $_POST['service_arrive'],
                'service_consumption' => $_POST['service_consumption'],
                'domain' => $subdomain,
                'enable_groupbuy' => $_POST['enable_groupbuy'],
                'enable_radar' => $_POST['enable_radar'],
                'hot_search' => trim($_POST['hot_search']),
                'online_service' => trim($_POST['online_service']),
                'hotline' => trim($_POST['hotline']),
                'business_scope' => trim($_POST['business_scope']),
                    // end 
                'amount_for_free_fee' => intval($_POST['amount_for_free_fee']),
                'acount_for_free_fee' => intval($_POST['acount_for_free_fee']),
            ));
			
			$qrcode_image = $this->_upload_image2($this->_store_id);
			$qrcode_image['qrcode_image'] && $data['qrcode_image'] = $qrcode_image['qrcode_image'] ;
			
            $this->_store_mod->edit($this->_store_id, $data);

            $this->show_message('edit_ok');
        }
    }
	
	function _upload_image2($store_id) {
        import('uploader.lib');
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE);
        $uploader->allowed_size(SIZE_GOODS_IMAGE); // 2M

        $data = array();

            $file = $_FILES['qrcode_image'];
            if ($file['error'] == UPLOAD_ERR_OK) {
            
                $uploader->addFile($file);
                if (!$uploader->file_info()) {
                    $this->_error($uploader->get_error());
                    return false;
                }

                $uploader->root_dir(ROOT_PATH);
                $dirname = 'data/files/'.'store_' . $store_id .'/qrcode_image';
				$filename  ="qrcodeimg_".$store_id;
				// $filename  = $uploader->random_filename();
                // $filename = 'store_' . $store_id . '_' . $i;
                $data['qrcode_image'] = $uploader->save($dirname, $filename);
            }
        
        return $data;
    }

    function slides() {
        $store = $this->_store_mod->get(array('conditions' => 'store_id=' . $this->_store_id, 'fields' => 'pic_slides'));

        if (!IS_POST) {
            /* 当前页面信息 */
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_store'), 'index.php?app=my_store', LANG::get('slides'));
            $this->_curitem('my_store');
            $this->_curmenu('slides');

            $pic_slides = array();

            if ($store['pic_slides']) {
                $pic_slides_arr = json_decode($store['pic_slides'], true);

                foreach ($pic_slides_arr as $key => $slides) {
                    $pic_slides['pic_slides_url_' . $key] = $slides['url'];
                    $pic_slides['pic_slides_link_' . $key] = $slides['link'];
                    //$pic_slides['pic_slides_tit_'.$key] = urldecode($slides['tit']);
                }
                //print_r($my_slides);
            }

            $this->assign('slides', $pic_slides);

            $this->display('my_store.slides.html');
        } else {
            $pic_slides_arr = $this->_upload_slides();
            $all_slides = array();


            if (empty($store['pic_slides'])) {
                $all_slides = json_encode($pic_slides_arr);
            } else {
                $old_pic_slides_arr = json_decode($store['pic_slides'], true);
                foreach ($pic_slides_arr as $key => $slides) {
                    if (!empty($slides['url'])) {
                        $old_pic_slides_arr[$key]['url'] = $slides['url'];
                    }
                    if (!empty($slides['link'])) {
                        $old_pic_slides_arr[$key]['link'] = $slides['link'];
                    }
                    //if(!empty($slides['tit'])){
                    //$old_pic_slides_arr[$key]['tit'] = urlencode($slides['tit']);
                    //}
                }
                $all_slides = json_encode($old_pic_slides_arr);
            }
            $this->_store_mod->edit($this->_store_id, array('pic_slides' => $all_slides));

            $this->show_message('edit_ok', 'back_list', 'index.php?app=my_store&act=slides', 'back_home', 'index.php?app=member'
            );
        }
    }

    function _upload_slides() {
        import('uploader.lib');
        $data = array();

        /* pic_slides */
        for ($i = 1; $i <= 3; $i++) {
            $file = $_FILES['pic_slides_url_' . $i];
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
                $data[$i]['url'] = $uploader->save('data/files/store_' . $this->_store_id . '/pic_slides', 'pic_slides_' . $i);
            } else {
                $data[$i]['url'] = '';
            }

            $data[$i]['link'] = trim($_POST['pic_slides_link_' . $i]);
            //$data[$i]['tit']  = trim($_POST['pic_slides_tit_'.$i]);	
        }
        return $data;
    }

    function update_im_msn() {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        $this->_store_mod->edit($this->_store_id, array('im_msn' => $id));
        header("Location: index.php?app=my_store");
        exit;
    }

    function drop_im_msn() {
        $this->_store_mod->edit($this->_store_id, array('im_msn' => ''));
        header("Location: index.php?app=my_store");
        exit;
    }

    function _get_member_submenu() {
        return array(
            array(
                'name' => 'my_store',
                'url' => 'index.php?app=my_store',
            ),
            array(
                'name' => 'callcenter',
                'url'  => 'index.php?app=my_store&act=callcenter',
            ),
            array(
                'name' => 'slides',
                'url' => 'index.php?app=my_store&act=slides',
            ),
            array(
                'name' => 'location',
                'url' => 'index.php?app=my_store&amp;act=location',
            ),
        );
    }

    function location() {
        $store_mod = & m('store');

        if (!IS_POST) {
            $store_info = $store_mod->get($this->_store_id);

            if ($store_info['lng'] == '0' || $store_info['lat'] == '0') {
                //根据IP 获取经纬度
                $data = $this->get_ip_location();
                $store_info = array_merge($store_info, $data);
            }

            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('location'));
            /* 当前用户中心菜单 */
            $this->_curitem('my_profile');
            /* 当前所处子菜单 */
            $this->_curmenu('location');
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('location'));

            $this->assign('baidu_ak', Conf::get('baidu_ak'));
            $this->assign('store_info', $store_info);
            $this->display('my_store.location.html');
        } else {
            $data = array(
                'lng' => $_POST['lng'],
                'lat' => $_POST['lat'],
                'zoom' => $_POST['zoom'],
            );
            $store_mod->edit($this->_store_id, $data);
            $this->show_message('edit_ok');
        }
    }

    /**
     * 上传文件
     *
     */
    function _upload_files() {
        import('uploader.lib');
        $data = array();
        /* store_logo */
        $file = $_FILES['store_logo'];
        if ($file['error'] == UPLOAD_ERR_OK && $file != '') {
            $uploader = new Uploader();
            $uploader->allowed_type(IMAGE_FILE_TYPE);
            $uploader->allowed_size(SIZE_STORE_LOGO); // 20KB
            $uploader->addFile($file);
            if ($uploader->file_info() === false) {
                $this->show_warning($uploader->get_error());
                return false;
            }
            $uploader->root_dir(ROOT_PATH);
            $data['store_logo'] = $uploader->save('data/files/store_' . $this->_store_id . '/other', 'store_logo');
        }

        /* store_banner */
        $file = $_FILES['store_banner'];
        if ($file['error'] == UPLOAD_ERR_OK && $file != '') {
            $uploader = new Uploader();
            $uploader->allowed_type(IMAGE_FILE_TYPE);
            $uploader->allowed_size(SIZE_STORE_BANNER); // 200KB
            $uploader->addFile($file);
            if ($uploader->file_info() === false) {
                $this->show_warning($uploader->get_error());
                return false;
            }
            $uploader->root_dir(ROOT_PATH);
            $data['store_banner'] = $uploader->save('data/files/store_' . $this->_store_id . '/other', 'store_banner');
        }

        return $data;
    }

    /* 异步删除附件 */

    function drop_uploadedfile() {
        $file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;
        $file = $this->_uploadedfile_mod->get($file_id);
        if ($file_id && $file['store_id'] == $this->visitor->get('manage_store') && $this->_uploadedfile_mod->drop($file_id)) {
            $this->json_result('drop_ok');
            return;
        } else {
            $this->json_error('drop_error');
            return;
        }
    }
    
    function callcenter()
    {
        if (!IS_POST){
            $store = $this->_store_mod->get_info($this->_store_id);
            $store['pre_connects'] = json_decode($store['pre_connects'],true);
            if(!empty($store['pre_connects'])){
                foreach ($store['pre_connects'] as $key => $value) {
                    $store['pre_connects'][$key]['name'] = urldecode($value['name']);
                    $store['pre_connects'][$key]['num'] = urldecode($value['num']);
                }
            }
            $store['after_connects'] = json_decode($store['after_connects'],true);
            if(!empty($store['after_connects'])){
                foreach ($store['after_connects'] as $key => $value) {
                    $store['after_connects'][$key]['name'] = urldecode($value['name']);
                    $store['after_connects'][$key]['num'] = urldecode($value['num']);
                }
            }
            $this->assign('store', $store);
            $this->_curitem('my_store');
            $this->_curmenu('callcenter');
            $this->display('my_store.callcenter.html');
        }else{
            $pre = $_POST['pre'];
            if(!empty($pre)){
                foreach ($pre as $key => $value) {
                    if(empty($value['name'])||(!in_array($value['type'],array('1','2')))||empty($value['num'])){
                        unset($pre[$key]);
                    }else{
                        //存储为中文
                        $pre[$key]['name'] = urlencode($value['name']);
                        $pre[$key]['num'] = urlencode($value['num']);
                    }
                }
            }
            $data['pre_connects'] = ecm_json_encode($pre);
            $after = $_POST['after'];
            if(!empty($after)){
                foreach ($after as $key => $value) {
                    if(empty($value['name'])||(!in_array($value['type'],array('1','2')))||empty($value['num'])){
                        unset($after[$key]);
                    }else{
                        //存储为中文
                        $after[$key]['name'] = urlencode($value['name']);
                        $after[$key]['num'] = urlencode($value['num']);
                    }
                }
            }
            $data['after_connects'] = ecm_json_encode($after);
            $this->_store_mod->edit($this->_store_id, $data);
            $this->show_message('edit_ok');
        }
    }
    
    

}

?>
