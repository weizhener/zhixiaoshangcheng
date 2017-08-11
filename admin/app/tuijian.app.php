<?php

class TuijianApp extends BackendApp {
    
    function __construct() {
        $this->TuijianApp();
    }

    function TuijianApp() {
        parent::BackendApp();
    }
    
    function setting()
    {
        $model_setting = &af('settings');
        $setting = $model_setting->getAll(); //载入系统设置数据
        if (!IS_POST) {
            $this->assign('setting', $setting);
            $this->display('tuijian.setting.html');
        } else {
            
            
            $data['tuijian_seller_status'] = $_POST['tuijian_seller_status']; #是否开启
            $data['tuijian_seller_ratio1'] = empty($_POST['tuijian_seller_ratio1']) ? 0 : intval($_POST['tuijian_seller_ratio1']);
            $data['tuijian_seller_ratio2'] = empty($_POST['tuijian_seller_ratio1']) ? 0 : intval($_POST['tuijian_seller_ratio2']);
            $data['tuijian_seller_ratio3'] = empty($_POST['tuijian_seller_ratio1']) ? 0 : intval($_POST['tuijian_seller_ratio3']);
            
            $data['tuijian_buyer_status'] = $_POST['tuijian_buyer_status']; #是否开启
            $data['tuijian_buyer_ratio1'] = empty($_POST['tuijian_buyer_ratio1']) ? 0 : intval($_POST['tuijian_buyer_ratio1']);
            $data['tuijian_buyer_ratio2'] = empty($_POST['tuijian_buyer_ratio2']) ? 0 : intval($_POST['tuijian_buyer_ratio2']);
            $data['tuijian_buyer_ratio3'] = empty($_POST['tuijian_buyer_ratio3']) ? 0 : intval($_POST['tuijian_buyer_ratio3']);
            
            $total_ratio = $data['tuijian_seller_ratio1']+$data['tuijian_seller_ratio2']+$data['tuijian_seller_ratio3']+$data['tuijian_buyer_ratio1']+$data['tuijian_buyer_ratio2']+$data['tuijian_buyer_ratio13'];
            if($total_ratio>100){
                $this->show_warning('greater_than_100', 'back_list' , 'index.php?app=tuijian&act=setting');
                return;
            }
            
            
            $model_setting->setAll($data);
            $this->show_message('edit_ok');
        }
        
        
    }
    
    
    
}
