<?php

/* 品牌旗舰店控制器 */
class Ultimate_storeApp extends BackendApp
{
    var $_store_mod;
	var $_us_mod;
	var $_member_mod;
	var $_brand_mod;

    function __construct()
    {
        $this->Ultimate_storeApp();
    }

    function Ultimate_storeApp()
    {
        parent::__construct();
        $this->_store_mod =& m('store');
		$this->_us_mod = &m('ultimate_store');
		$this->_member_mod = &m('member');
		$this->_brand_mod = &m('brand');
    }

	function index()
	{
		$ultimate_stores=$this->_us_mod->find(array('order'=>'ultimate_id desc'));
		$gcategory_mod=&m('gcategory');
		foreach($ultimate_stores as $k=>$v){
			$store=$this->_store_mod->get(array('conditions'=>'store_id='.$v['store_id'],'fields'=>'store_name'));
			$brand=$this->_brand_mod->get(array('conditions'=>'brand_id='.$v['brand_id'],'fields'=>'brand_name'));
			$gcategory=$gcategory_mod->get(array('conditions'=>'cate_id='.$v['cate_id'],'fields'=>'cate_name'));
			
			$ultimate_stores[$k]['brand_name']=$brand['brand_name'];
			$ultimate_stores[$k]['cate_name']=$gcategory['cate_name'];
			$ultimate_stores[$k]['store_name']=$store['store_name'];
		}
		$this->assign('ultimate_store',$ultimate_stores);
		$this->display('ultimate_store.index.html');
	}
	function add()
	{
		if (!IS_POST)
		{
			$brands=$this->_get_brand_options();
			$gcategories=$this->_get_gcategory_options(2);
			$this->assign('status', array(
					'1' => Lang::get('open'),
					'0' => Lang::get('close'),
			  ));
			$this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js,mlselection.js'
            ));
			$this->assign('brands',$brands);
			$this->assign('gcategories',$gcategories);
			$this->display('ultimate_store.form.html');	
		}
		else
		{
			$data=array();
			$data['brand_id']	=	intval($_POST['brand_id']);
			$data['cate_id'] 	=	intval($_POST['cate_id']);
			$data['status']		= 	intval($_POST['status']);
			$data['keyword']	= 	trim($_POST['keyword']);
			$data['description']= 	trim($_POST['description']);
			
			if(!empty($_POST['user_name']))
			{
				$member = $this->_member_mod->get(array('conditions'=>"user_name='".trim($_POST['user_name'])."'",'fields'=>'user_id'));
				$data['store_id'] = $member['user_id'];
			}
			else {
				$data['store_id']	=	intval($_POST['store_id']);
			}
			
			if ($this->_us_mod->add($data) === false)
            {
                $this->show_warning($this->_us_mod->get_error());
                return false;
            }

            $this->show_message('add_ok',
                'back_ultimate_list',    'index.php?app=ultimate_store',
                'continue_add_ultimate', 'index.php?app=ultimate_store&amp;act=add'
            );
			
		}
	}
	function edit()
	{
		$ultimate_id= intval($_GET['id']);
		if (!IS_POST)
		{
			if (!$ultimate_id)
            {
                $this->show_warning('ultimate_no_exist');
                return;
            }
			$brands=$this->_get_brand_options();
			$gcategories=$this->_get_gcategory_options(2);
			$this->assign('status', array(
					'1' => Lang::get('open'),
					'0' => Lang::get('close'),
			 ));
			$ultimate_store=$this->_us_mod->get(array('conditions'=>'ultimate_id='.$ultimate_id)); 
			$store=$this->_store_mod->get(array('conditions'=>'store_id='.$ultimate_store['store_id'],'fields'=>'store_name'));
		    $ultimate_store['store_name']=$store['store_name'];
			$this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js,mlselection.js'
            ));
			$this->assign('ultimate',$ultimate_store);
			$this->assign('brands',$brands);
			$this->assign('gcategories',$gcategories);
			$this->display('ultimate_store.form.html');	
		}
		else
		{
			$data=array();
			$data['brand_id']	=	intval($_POST['brand_id']);
			$data['cate_id'] 	=	intval($_POST['cate_id']);
			$data['status']		= 	intval($_POST['status']);
			$data['keyword']	= 	trim($_POST['keyword']);
			$data['description']= 	trim($_POST['description']);

			$this->_us_mod->edit($ultimate_id,$data);
            $this->show_message('add_ok',
                'back_ultimate_list',    'index.php?app=ultimate_store',
                'edit_ultimate_again', 'index.php?app=ultimate_store&amp;act=edit&amp;id='.$ultimate_id
            );
			
		}
	}
	function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('ultimate_no_exist');
            return;
        }

        $ids = explode(',', $id);
        if (!$this->_us_mod->drop($ids))
        {
            $this->show_warning($this->_us_mod->get_error());
            return;
		}

        $this->show_message('drop_ultimate_ok');
    }
	function check_brand()
    {
        $brand_id = empty($_GET['brand_id']) ? 0 : intval($_GET['brand_id']);
		!empty($_GET['ultimate_id']) && $add_condition=' and ultimate_id!='.$_GET['ultimate_id'];
        if ($this->_us_mod->get(array('conditions'=>'brand_id='.$brand_id.$add_condition)))
        {
            echo ecm_json_encode(false);
            return;
        }
        echo ecm_json_encode(true);
    }
	function check_gcategory()
    {
        $cate_id  = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);
		!empty($_GET['ultimate_id']) && $add_condition=' and ultimate_id!='.$_GET['ultimate_id'];
        if ($this->_us_mod->get(array('conditions'=>'cate_id='.$cate_id.$add_condition)))
        {
            echo ecm_json_encode(false);
            return; 
        }
        echo ecm_json_encode(true);
    }
	function check_kw()
    {
        $keyword  = empty($_GET['keyword']) ? '' : trim($_GET['keyword']);
		!empty($_GET['ultimate_id']) && $add_condition=' and ultimate_id!='.$_GET['ultimate_id'];
        if ($this->_us_mod->get(array('conditions'=>'keyword='.'"'.$keyword.'"'.$add_condition)))
        {
            echo ecm_json_encode(false);
            return;
        }
        echo ecm_json_encode(true);
    }
	function check_user_name()
	{
		$user_name = trim($_GET['user_name']);
		$member = $this->_member_mod->get(array(
			'conditions'=>"state=1 AND user_name='".$user_name."'",
			'join'=>'has_store',
			'fields'=>'store_id',
		));
		if($member)
		{
			echo ecm_json_encode(true);
			return;
		}
		echo ecm_json_encode(false);
	}

	/* 取得分类列表 */
    function _get_gcategory_options()
    {
        $gcategory_mod =& bm('gcategory', array('_store_id' => 0));
        $gcategories = $gcategory_mod->get_list();

        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');

        return $tree->getOptions($layer);
    }
	/* 取得分类列表 */
    function _get_brand_options()
    {
        $brands = $this->_brand_mod->find(array('fields'=>'brand_id,brand_name'));
		$result=array();
        foreach($brands as $k=>$brand){
			$result[$brand['brand_id']]=$brand['brand_name'];
		}
        return $result;
    }

}

?>
