<?php

class JobApp extends MallbaseApp {
    var $_job_mod;
    function __construct() {
        $this->JobApp();
    }

    function JobApp() {
        parent::__construct();
        $this->_job_mod = &m('job');
    }

    function index() {

        
        $page = $this->_get_page(10);   //获取分页信息
        $jobs = $this->_job_mod->find(array(
            'conditions' => '1=1' . $conditions,
            'limit' => $page['limit'],
            'order' => "sort_order desc",
            'count' => true
        ));
        $page['item_count'] = $this->_job_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('jobs', $jobs);
        $this->display('job.index.html');
    }
    
    
    function view()
    {
        $job_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        
        $job = $this->_job_mod->get($job_id);
        $this->assign('job', $job);
        $this->_config_seo('title', $job['position'] . ' - ' . Conf::get('site_title'));
        $this->display('job.view.html');
    }
    

}
