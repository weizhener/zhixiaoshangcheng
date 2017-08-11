<?php

/**
 * 手机版基本设置
 */
class Wap_settingApp extends BackendApp {

    function __construct() {
        $this->Wap_settingApp();
    }

    function Wap_settingApp() {
        parent::BackendApp();
        $_POST = stripslashes_deep($_POST);
    }
    
    function index()
    {
        $model_setting = &af('settings');
        $setting = $model_setting->getAll(); //载入系统设置数据
        if (!IS_POST) {
            $this->assign('setting', $setting);
            $this->display('wap_setting.index.html');
        }else{
            $images = array('wap_site_logo');
            $image_urls = $this->_upload_images($images);
            foreach ($images as $image) {
                isset($image_urls[$image]) && $data[$image] = $image_urls[$image];
            }
            $data['wap_site_name'] = $_POST['wap_site_name'];
            $data['wap_site_title'] = $_POST['wap_site_title'];
            $data['wap_site_description'] = $_POST['wap_site_description'];
            $data['wap_site_keywords'] = $_POST['wap_site_keywords'];
            $model_setting->setAll($data);
            $this->show_message('edit_ok');
        }
    }
    
    function _upload_images($images) {
        import('uploader.lib');
        $image_urls = array();

        foreach ($images as $image) {
            $file = $_FILES[$image];
            if ($file['error'] != UPLOAD_ERR_OK) {
                continue;
            }
            $uploader = new Uploader();
            $uploader->allowed_type(IMAGE_FILE_TYPE);
            $uploader->addFile($file);
            if ($uploader->file_info() === false) {
                continue;
            }
            $uploader->root_dir(ROOT_PATH);
            $image_urls[$image] = $uploader->save('data/files/mall/settings', $image);
        }
        return $image_urls;
    }

}