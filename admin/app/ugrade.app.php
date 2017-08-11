<?php

class UgradeApp extends BackendApp
{
    var $_grade_mod;

    function __construct()
    {
        $this->UgradeApp();
    }

    function UgradeApp()
    {
        parent::__construct();
        $this->_grade_mod =& m('ugrade');
    }

    function index()
    {
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'grade_name',
                'equal' => 'LIKE',
            ),
        ));
        $page = $this->_get_page();
        $ugrades = $this->_grade_mod->find(array(
            'conditions' => '1=1' . $conditions,
            'limit' => $page['limit'],
			'order'  =>'grade_id ASC',
            'count' => true,
        ));
        $this->assign('ugrades', $ugrades);
        $page['item_count'] = $this->_grade_mod->getCount();
        $this->_format_page($page);
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);

        $this->display('ugrade.index.html');
    }

    function add()
    {
        if (!IS_POST)
        {
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js')
			);
			$ugrade=$this->_grade_mod->get_option();
			$this->assign('ugrade',max($ugrade)+1);
            $this->display('ugrade.form.html');
        }
        else
        {
            /* 检查名称是否已存在 */
            if (!$this->_grade_mod->unique('grade_name',trim($_POST['grade_name'])))
            {
                $this->show_warning('name_exist');
                return;
            }
            $data = array(
                'grade_name'   => $_POST['grade_name'],
				'grade'   => $_POST['grade'],
				'growth_needed'   => $_POST['growth_needed'],
				'add_time'  =>gmtime()
            );
			$last_grade=$this->_grade_mod->get(array('conditions'=>'grade='.($_POST['grade']-1)));
			$data['floor_growth']=$_POST['growth_needed']+$last_grade['floor_growth'];
            $grade_id = $this->_grade_mod->add($data);
            if (!$grade_id)
            {
                $this->show_warning($this->_grade_mod->get_error());
                return;
            }
			$this->_grade_mod->edit($last_grade['grade_id'],array('top_growth'=>$data['floor_growth']));//修改上一等级的top_growth
			$grade_icon=$this->_upload_logo($grade_id);
			if ($grade_icon === false)
            {
                return;
            }
            $grade_icon && $this->_grade_mod->edit($grade_id, array('grade_icon' => $grade_icon)); //将icon地址记下
            $this->show_message('add_ok',
                'back_list',    'index.php?app=ugrade',
                'continue_add', 'index.php?app=ugrade&amp;act=add'
            );
        }
    }

    function check_grade_name()
    {
        $grade_name = empty($_GET['grade_name']) ? '' : trim($_GET['grade_name']);
        $grade_id   = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$grade_name)
        {
            echo ecm_json_encode(false);
            return ;
        }
        if ($this->_grade_mod->unique('grade_name',$grade_name, $grade_id))
        {
            echo ecm_json_encode(true);
        }
        else
        {
            echo ecm_json_encode(false);
        }
        return ;
    }
	function check_growth()
    {
        $growth_needed = empty($_GET['growth_needed']) ? '' : trim($_GET['growth_needed']);
        $grade = empty($_GET['grade']) ? 0 : intval($_GET['grade']);
        if (!$growth_needed)
        {
            echo ecm_json_encode(false);
            return ;
        }
        if ($this->_grade_mod->compare($grade, $growth_needed))
        {
            echo ecm_json_encode(true);
        }
        else
        {
            echo ecm_json_encode(false);
        }
        return ;
    }
	
    function edit()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {	
            $this->show_warning('Hacking Attempt');
            return;
        }

        if (!IS_POST)
        {
			$ugrade=$this->_grade_mod->get($id);
            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js'));
			$this->assign('ugrade',$ugrade);
            $this->display('ugrade.form.html');
        }
        else
        {
            $data = array(
                'grade_name'   => $_POST['grade_name'],
                'growth_needed'  => $_POST['growth_needed'],
            );
            $this->_grade_mod->edit($id, $data);
			$grade_icon=$this->_upload_logo($id);
			if ($grade_icon === false)
            {
                return;
            }
            $grade_icon && $this->_grade_mod->edit($id, array('grade_icon' => $grade_icon)); //将icon地址记下
            $this->show_message('edit_ok',
                'back_list',    'index.php?app=ugrade',
                'edit_again',   'index.php?app=ugrade&amp;act=edit&amp;id=' . $id
            );
        }
    }
	//会员的成长值设置
	function growth_value()
	{
		$model_growth = &af('growth');
        $growth = $model_growth->getAll(); 
		if(!IS_POST)
		{
			$this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js'));
			$this->assign('growth',$growth);
			$this->display('ugrade_growth.html');
		}else{
			$data['register_growth']=$_POST['register_growth'];
			$data['bought_growth']=$_POST['bought_growth'];
			$data['comment_growth']=$_POST['comment_growth'];
			$model_growth->setAll($data);
            $this->show_message('edit_ok');
		}
	}
    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_sgrade_to_drop');
            return;
        }

        $ids = explode(',', $id);
        $ids = array_diff($ids, array(1)); // 默认等级不能删除
        if (!$this->_grade_mod->drop($ids))
        {
            $this->show_warning($this->_grade_mod->get_error());
            return;
        }
		//全部删除后，会员积分清零
		$member_mod=&m('member');
		$member_mod->edit('',array('ugrade'=>1,'growth'=>0));
		//删掉商品的会员折扣
		$gradegoods_mod=&m('gradegoods');
		$gradegoods_mod->drop('1=1');
        $this->show_message('drop_ok');
    }
	 /**
     *    处理上传标志
     */
    function _upload_logo($grade_id)
    {
        $file = $_FILES['grade_icon'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE) // 没有文件被上传
        {
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['grade_icon']);//上传icon
        if (!$uploader->file_info())
        {
            $this->show_warning($uploader->get_error() , 'go_back', 'index.php?app=ugrade&amp;act=edit&amp;id=' . $grade_id);
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/mall/ugrade', $grade_id))   //保存到指定目录
        {
            return $file_path;
        }
        else
        {
            return false;
        }
    }

}
?>
