<?php

class Job_applyApp extends BackendApp {

    var $_job_mod;
    var $_job_apply_mod;

    function __construct() {
        $this->Job_applyApp();
    }

    function Job_applyApp() {
        parent::BackendApp();
        $this->_job_mod = & m('job');
        $this->_job_apply_mod = & m('job_apply');
    }

    function index() {

        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'state',
                'equal' => '=',
                'type' => 'numeric',
            ),
        ));
        
        if($_GET['job_id']){
            $conditions .=' AND job_apply.job_id = '.intval($_GET['job_id']);
        }

        $page = $this->_get_page(10);   //获取分页信息
        $job_applys = $this->_job_apply_mod->find(array(
            'fields'   => 'job_apply.*,job.position',
            'conditions' => '1=1' . $conditions,
            'limit' => $page['limit'],
            'order' => "add_time desc",
            'join'=>'belongs_to_job',
            'count' => true
        ));


        $states = array(
            '0' => LANG::get('unread'),
            '1' => LANG::get('read'),
        );
        $this->assign('states', $states);
        
        $jobs = $this->_job_mod->find(
                array(
                    'order' => "sort_order desc",
                    'count' => true
                )
        );
        $this->assign('jobs', $jobs);


        $page['item_count'] = $this->_job_apply_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('job_applys', $job_applys);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->display('job_apply.index.html');
    }
    
    
    function view()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        
        $job_apply = $this->_job_apply_mod->find(array(
            'fields'   => 'job_apply.*,job.position',
            'conditions' => 'id=' . $id,
            'join'=>'belongs_to_job',
        ));
        $job_apply = current($job_apply);
        
        //表示未已读
        if($job_apply){
            $this->_job_apply_mod->edit($id,array('state'=>1));
        }
        
        
        $this->assign('job_apply', $job_apply);
        $this->display('job_apply.view.html');
    }

    function drop()
    {
        $ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$ids)
        {
            $this->show_warning('no_such_job');
            return;
        }
        $ids=explode(',',$ids);
        $this->_job_apply_mod->drop($ids);
        if ($this->_job_apply_mod->has_error())    //删除
        {
            $this->show_warning($this->_job_apply_mod->get_error());
            return;
        }
        $this->show_message('drop_successed');
    }
    

}

?>