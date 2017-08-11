<?php

class Channel_appliancesApp extends MallbaseApp {

    function index() {
        
        $this->assign('index', 1); // 标识当前页面是首页，用于设置导航状态

        $this->_config_seo(array(
            'title' => Conf::get('site_title'),
        ));
        $this->assign('page_description', Conf::get('site_description'));
        $this->assign('page_keywords', Conf::get('site_keywords'));

        $this->display('channel_appliances.index.html');
    }

}
?>