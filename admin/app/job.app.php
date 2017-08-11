<?php

class JobApp extends BackendApp{
    
    var $_job_mod;

    function __construct()
    {
        $this->JobApp();
    }

    function JobApp()
    {
        parent::BackendApp();
        $this->_job_mod =& m('job');
    }
    
    function index() {
        
        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'position',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'position',
                'type'  => 'string',
            ),
        ));
        
        
        
        
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
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->display('job.index.html');
    }
    
    
    function add()
    {
        if (!IS_POST){
            /* 显示新增表单 */
            $job = array(
                'sort_order' => 255,
            );
            $this->assign('job', $job);
            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js,change_upload.js'));
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'content',
                'content_css' => SITE_URL . "/themes/mall/{$template_name}/styles/{$style_name}/css/ecmall.css"
            )));
            $this->display('job.form.html');
        }else{
            
            $data = array(
                'position'=>$_POST['position'],
                'count'=>$_POST['count'],
                'place'=>$_POST['place'],
                'deal'=>$_POST['deal'],
                'add_time'=>gmtime(),
                'update_time'=>  gmtime(),
                'content'=>$_POST['content'],
                'sort_order'=>$_POST['sort_order'],
            );
            if (!$job_id = $this->_job_mod->add($data)) 
            {
                $this->show_warning($this->_job_mod->get_error());
                return;
            }
            
            $this->show_message('add_job_successed',
                'back_list',    'index.php?app=job',
                'continue_add', 'index.php?app=job&amp;act=add'
            );
        }
    }
    
    
    function edit()
    {
        $job_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        $job = $this->_job_mod->get($job_id);
        if (!$job)
        {
            $this->show_warning('no_such_job');
            return;
        }
        if (!IS_POST){
            $this->assign('job', $job);
            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js,change_upload.js'));
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'content',
                'content_css' => SITE_URL . "/themes/mall/{$template_name}/styles/{$style_name}/css/ecmall.css"
            )));
            $this->display('job.form.html');
        }else{
            
            
            $data = array(
                'position'=>$_POST['position'],
                'count'=>$_POST['count'],
                'place'=>$_POST['place'],
                'deal'=>$_POST['deal'],
                'update_time'=>  gmtime(),
                'content'=>$_POST['content'],
                'sort_order'=>$_POST['sort_order'],
            );
            
            $this->_job_mod->edit($job_id,$data);
            
            $this->show_message('edit_job_successed',
                'back_list',        'index.php?app=job',
                'edit_again',    'index.php?app=job&amp;act=edit&amp;id=' . $job_id);
        }
    }
    
    
    function drop()
    {
        $job_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$job_ids)
        {
            $this->show_warning('no_such_job');
            return;
        }
        $job_ids=explode(',',$job_ids);
        $this->_job_mod->drop($job_ids);
        if ($this->_job_mod->has_error())    //删除
        {
            $this->show_warning($this->_job_mod->get_error());

            return;
        }
        $this->show_message('drop_job_successed');
    }
    
    
    

}
