<?php

class Job_applyApp extends MallbaseApp {

    var $_job_mod;
    var $_job_apply_mod;

    function __construct() {
        $this->Job_applyApp();
    }

    function Job_applyApp() {
        parent::__construct();
        $this->_job_mod = & m('job');
        $this->_job_apply_mod = &m('job_apply');
    }

    function index() {
        
    }

    function add() {
        if (!IS_POST) {
            
            $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
            $this->assign('id', $id);
            
            
            //获取可以选择的职位
            $jobs = $this->_job_mod->find(
                    array(
                        'order' => "sort_order desc",
                        'count' => true
                    )
            );
            if(empty($jobs)){
                $this->show_warning('no_jobs');
                return;
            }
            
            $this->assign('jobs', $jobs);
            $this->display('job_apply.form.html');
        } else {
            
            $data = array(
                'job_id'=>$_POST['job_id'],
                'name'=>$_POST['name'],
                'sex'=>$_POST['sex'],
                'birthday'=>$_POST['birthday'],
                'native_place'=>$_POST['native_place'],
                'telephone'=>$_POST['telephone'],
                'zip_code'=>$_POST['zip_code'],
                'email'=>$_POST['email'],
                'education'=>$_POST['education'],
                'professional'=>$_POST['professional'],
                'school'=>$_POST['school'],
                'address'=>$_POST['address'],
                'awards'=>$_POST['awards'],
                'experience'=>$_POST['experience'],
                'hobbies'=>$_POST['hobbies'],
                'add_time'=>  gmtime(),
            );
            
            if (!$id = $this->_job_apply_mod->add($data)) 
            {
                $this->show_warning($this->_job_apply_mod->get_error());
                return;
            }
            
            $this->show_message('apply_successed',
                'back_list',    'index.php?app=job',
                'continue_add', 'index.php?app=job_apply&amp;act=add'
            );
            
        }
    }

}
