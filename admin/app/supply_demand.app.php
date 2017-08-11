<?php

/**
 *    供求信息管理控制器
 *
 *    @author    andcpp
 *    @usage    none
 */
define('MAX_LAYER', 2);


class Supply_demandApp extends BackendApp
{
    var $_sdinfo_mod;
	var $_category_mod;

    function __construct()
    {
        $this->Supply_demandApp();
    }

    function Supply_demandApp()
    {
        parent::BackendApp();

        $this->_sdinfo_mod =& m('sdinfo');
		$this->_category_mod = &m('sdcategory');
    }

    function index()
    {
        /* 处理cate_id */
        $cate_id = !empty($_GET['cate_id'])? intval($_GET['cate_id']) : 0;
        if ($cate_id > 0) //取得该分类及子分类cate_id
        {
            $cate_ids = $this->_category_mod->get_descendant($cate_id);
            if (!$cate_ids)
            {
                $this->show_warning('no_data');
                return;
            }
        }
        $conditions='';
        !empty($cate_ids)&& $conditions = ' AND cate_id ' . db_create_in($cate_ids);
		$search_options = array(
            'title'   => Lang::get('title'),
            'user_name'   => Lang::get('user_name'),
        );
		 /* 默认搜索的字段是标题 */
        $field = 'title';
        array_key_exists($_GET['field'], $search_options) && $field = $_GET['field'];
		$conditions .= $this->_get_query_conditions(array(
			array(
                'field' => $field,       //按用户名,店铺名,支付方式名称进行搜索
                'equal' => 'LIKE',
                'name'  => 'search_name',
            ),array(
                'field' => 'type',
                'equal' => '=',
                'type'  => 'numeric',
			)
        ));
        $page   =   $this->_get_page(10);   //获取分页信息
        $infos = $this->_sdinfo_mod->find(array(
			'fields'   => 'this.*,member.user_name',
			'conditions'  => "verify = 1".$conditions,
			'limit'   => $page['limit'],
			'join'    => 'belongs_to_member',
			'order'   => 'sdinfo.sort_order ASC,sdinfo.add_time DESC', //必须加别名
			'count'   => true   //允许统计
        ));
        $page['item_count']=$this->_sdinfo_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->import_resource(array('script' => 'inline_edit.js'));
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('infos', $infos);
		$this->assign('parents', $this->_get_options_all());
		$this->assign('search_options', $search_options);
		$type = array(
            1 => Lang::get('supply'),
            2 => Lang::get('demand'),
        );
		$this->assign('type', $type);
        $this->display('supply_demand.index.html');
    }
	function wait_verify()
    {
        /* 处理cate_id */
        $cate_id = !empty($_GET['cate_id'])? intval($_GET['cate_id']) : 0;
        if ($cate_id > 0) //取得该分类及子分类cate_id
        {
            $cate_ids = $this->_category_mod->get_descendant($cate_id);
            if (!$cate_ids)
            {
                $this->show_warning('no_this_acategory');
                return;
            }
        }
        $conditions='';
        !empty($cate_ids)&& $conditions = ' AND cate_id ' . db_create_in($cate_ids);
		$search_options = array(
            'title'   => Lang::get('title'),
            'user_name'   => Lang::get('user_name'),
        );
		 /* 默认搜索的字段是标题 */
        $field = 'title';
        array_key_exists($_GET['field'], $search_options) && $field = $_GET['field'];
		$conditions .= $this->_get_query_conditions(array(
			array(
                'field' => $field,       //按用户名,店铺名,支付方式名称进行搜索
                'equal' => 'LIKE',
                'name'  => 'search_name',
            ),array(
                'field' => 'type',
                'equal' => '=',
                'type'  => 'numeric',
			)
        ));
        $page   =   $this->_get_page(10);   //获取分页信息
        $infos = $this->_sdinfo_mod->find(array(
			'fields'   => 'this.*,member.user_name',
			'conditions'  => "verify <> 1".$conditions,
			'limit'   => $page['limit'],
			'join'    => 'belongs_to_member',
			'order'   => 'sdinfo.sort_order ASC,sdinfo.add_time DESC', //必须加别名
			'count'   => true   //允许统计
        ));
        $page['item_count']=$this->_sdinfo_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->import_resource(array('script' => 'inline_edit.js'));
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('infos', $infos);
		$this->assign('parents', $this->_get_options_all());
		$this->assign('search_options', $search_options);
		$type = array(
            1 => Lang::get('supply'),
            2 => Lang::get('demand'),
        );
		$this->assign('type', $type);
        $this->display('supply_demand.verifylist.html');
    }
	
	function verify()
	{
		$ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$ids)
        {
            $this->show_warning('no_such_info');

            return;
        }
        $ids=explode(',', $ids);
		
		if(!IS_POST)
		{
			$info = array();
			if(count($ids)==1) // 如果不是批量审核
			{
				$info = $this->_sdinfo_mod->get(array('conditions'=>'id='.current($ids),'fields'=>'verify_desc,verify'));
			}
			
			$this->assign('verify_options', array(
                '1' => Lang::get('yes'),
                '2' => Lang::get('no'),
            ));
			$this->assign('info',$info);
			$this->display('supply_demand.verify.html');
		}
		else
		{
			$data = array();
			$data['verify_desc'] = trim($_POST['verify_desc']);
			$data['verify'] = isset($_POST['verify']) ? intval($_POST['verify']) : 0;
			$this->_sdinfo_mod->edit('id' . db_create_in($ids),$data);
			if ($this->_sdinfo_mod->has_error())    //有错误
            {
                $this->show_warning($this->_sdinfo_mod->get_error());

                return;
            }
			$this->show_message('verify_successed',
				'back_list', 'index.php?app=supply_demand'
			);
		}
	}
	function view()
	{
		$id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_such_info');

            return;
        }	
		$info = $this->_sdinfo_mod->get(array(
			'fields'   => 'this.*,member.user_name',
			'conditions'  => "id=".$id,
			'join'    => 'belongs_to_member',
        ));
		$this->assign('info',$info);
		$this->display("supply_demand.view.html");	
	}
	function drop()
    {
        $ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$ids)
        {
            $this->show_warning('no_such_info');

            return;
        }
        $ids=explode(',', $ids);
        if (!$this->_sdinfo_mod->drop($ids))    //删除
        {
            $this->show_warning($this->_sdinfo_mod->get_error());

            return;
        }
        $this->show_message('drop_ok');
    }
	
	function cate()
	{
        /* 取得分类 */
        $acategories = $this->_category_mod->get_list();
        $tree =& $this->_tree($acategories);

        /* 先根排序 */
        $sorted_acategories = array();
        $cate_ids = $tree->getChilds();
        foreach ($cate_ids as $id)
        {
            //$parent_children_valid = $this->_category_mod->parent_children_valid($id);
            $sorted_acategories[] = array_merge($acategories[$id], array('layer' => $tree->getLayer($id)));
        }
        $this->assign('acategories', $sorted_acategories);

        /* 构造映射表（每个结点的父结点对应的行，从1开始） */
        $row = array(0 => 0);   // cate_id对应的row
        $map = array();         // parent_id对应的row
        foreach ($sorted_acategories as $key => $acategory)
        {
            $row[$acategory['cate_id']] = $key + 1;
            $map[] = $row[$acategory['parent_id']];
        }
        $this->assign('map', ecm_json_encode($map));

        $this->assign('max_layer', MAX_LAYER);

        $this->import_resource(array(
            'script' => 'jqtreetable.js,inline_edit.js',
            'style'  => 'res:style/jqtreetable.css')
        );
        $this->display('supply_demand.cate.html');
	}
	
	/* 新增 */
    function add_cate()
    {
        if (!IS_POST)
        {
            /* 参数 */
            $pid = empty($_GET['pid']) ? 0 : intval($_GET['pid']);
            $acategory = array('parent_id' => $pid, 'sort_order' => 255);
            $this->assign('acategory', $acategory);
			
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->assign('parents', $this->_get_options());
            $this->display('supply_demand.cateform.html');
        }
        else
        {
            $data = array(
                'cate_name'  => $_POST['cate_name'],
                'parent_id'  => $_POST['parent_id'],
                'sort_order' => $_POST['sort_order'],
            );

            /* 检查名称是否已存在 */
            if (!$this->_category_mod->unique(trim($data['cate_name']), $data['parent_id']))
            {
                $this->show_warning('name_exist');
                return;
            }

            /* 保存 */
            $cate_id = $this->_category_mod->add($data);
            if (!$cate_id)
            {
                $this->show_warning($this->_category_mod->get_error());
                return;
            }

            $this->show_message('add_ok',
                'back_list',    'index.php?app=supply_demand&amp;act=cate',
                'continue_add', 'index.php?app=supply_demand&amp;act=add_cate&amp;pid=' . $data['parent_id']
            );
        }
    }

    /* 检查文章分类的唯一性 */
    function check_acategory()
    {
        $cate_name = empty($_GET['cate_name']) ? '' : trim($_GET['cate_name']);
        $parent_id = empty($_GET['parent_id']) ? 0 : intval($_GET['parent_id']);
        $cate_id   = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$cate_name)
        {
            echo ecm_json_encode(true);
            return ;
        }
        if ($this->_category_mod->unique($cate_name, $parent_id, $cate_id))
        {
            echo ecm_json_encode(true);
        }
        else
        {
            echo ecm_json_encode(false);
        }
        return ;
    }

    /* 编辑 */
    function edit_cate()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!IS_POST)
        {
            /* 是否存在 */
            $acategory = $this->_category_mod->get_info($id);
            if (!$acategory)
            {
                $this->show_warning('no_such_cate');
                return;
            }
            $this->assign('acategory', $acategory);
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->display('supply_demand.cateform.html');
        }
        else
        {
            $data = array(
                'cate_name'  => $_POST['cate_name'],
                'parent_id'  => $_POST['parent_id'],
                'sort_order' => $_POST['sort_order'],
            );
            /* 检查名称是否已存在 */
            if (!$this->_category_mod->unique(trim($data['cate_name']), $data['parent_id'], $id))
            {
                $this->show_warning('name_exist');
                return;
            }

            /* 保存 */
            $rows = $this->_category_mod->edit($id, $data);
            if ($this->_category_mod->has_error())
            {
                $this->show_warning($this->_category_mod->get_error());
                return;
            }

            $this->show_message('edit_ok',
                'back_list',    'index.php?app=supply_demand&amp;act=cate',
                'edit_again',   'index.php?app=supply_demand&amp;act=edit_cate&amp;id=' . $id
            );
        }
    }
	 /* 删除 */
    function drop_cate()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_such_cate');
            return;
        }
        $ids = explode(',', $id);
        if (!$this->_category_mod->drop($ids))
        {
            $this->show_warning($this->_category_mod->get_error());
            return;
        }
        $this->show_message('drop_ok');
    }
	 //异步修改数据
   function ajax_col()
   {
       $id     = empty($_GET['id']) ? 0 : intval($_GET['id']);
       $column = empty($_GET['column']) ? '' : trim($_GET['column']);
       $value  = isset($_GET['value']) ? trim($_GET['value']) : '';
       $data   = array();

	   if (in_array($column ,array('cate_name', 'sort_order','sort_order_cate')))
       {
           $data[$column] = $value;
		   if($column == 'sort_order')
		   {
			   $this->_sdinfo_mod->edit($id, $data);
			   if(!$this->_sdinfo_mod->has_error())
			   {
				   echo ecm_json_encode(true);
			   }
		   }
			if($column == 'cate_name')
			{
				$acategory = $this->_category_mod->get_info($id);
				if(!$this->_category_mod->unique($value, $acategory['parent_id'], $id))
				{
					echo ecm_json_encode(false);
					return ;
				}
				$this->_category_mod->edit($id, $data);
			   if(!$this->_category_mod->has_error())
			   {
				   echo ecm_json_encode(true);
			   }
			}
			if($column == 'sort_order_cate')
			{
				$this->_category_mod->edit($id, array('sort_order' => $data['sort_order_cate']));
			   if(!$this->_category_mod->has_error())
			   {
				   echo ecm_json_encode(true);
			   }
			}   
       }
       else
       {
           return ;
       }
       return ;
   }

    /* 构造并返回树 */
    function &_tree($acategories)
    {
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($acategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree;
    }

    /* 取得可以作为上级的分类数据 */
    function _get_options($except = NULL)
    {
        $acategories = $this->_category_mod->get_list();
        $tree =& $this->_tree($acategories);
        return $tree->getOptions(MAX_LAYER - 1, 0, $except);
    }

        /* 取得全部分类数据 */
    function _get_options_all()
    {
        $mod_sdcategory = &m('sdcategory');
        $sdcategorys = $mod_sdcategory->get_list();
        $tree =& $this->_tree($sdcategorys);
        return $tree->getOptions();
    }
}

?>