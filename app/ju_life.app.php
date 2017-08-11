<?php

class Ju_lifeApp extends MallbaseApp
{	
	var $_jucate_mod;
	var $_jutemplate_mod;
	var $_ju_mod;
	
    function __construct()
    {
        $this->Ju_lifeApp();
    }

    function Ju_lifeApp()
    {
        parent::__construct();
		$this->_jucate_mod =&m('jucate');	
		$this->_jutemplate_mod =&m('jutemplate');	
		$this->_ju_mod =&m('ju');
    }

    function index()
    {
		$cate_list = $this->_list_category();
		$this->assign('cate_list',$cate_list);
		$ju_list_all = $this->_ju_mod->find(array(
			'join' => 'belong_store,belong_template',
			'conditions' => 'ju.status=1 and ju.channel=5 and jt.state=1',
			'fields'=>'this.*,s.region_id,s.region_name'
		)); 
		$this->assign('ju_count',count($ju_list_all));
		$cate_parent = $this->_jucate_mod->get("if_show = 1 and parent_id = '0' and channel=5");
		$cate_child = $this->_jucate_mod->get_children($cate_parent['cate_id'],false);
		foreach($cate_child as $k => $child)
		{
			$cate_child[$k]['count'] = 0;
			foreach($ju_list_all as $list)
			{
				if($child['cate_id'] == $list['cate_id'])
				{
					$cate_child[$k]['count'] += 1;
				}
			}
		}
		$this->assign('cate_child',$cate_child);
		$region = array();//地区筛选
		foreach($ju_list_all as $list)
		{
			$region[$list['region_id']] = array(
				'region_id' => $list['region_id'],
				'region_name' => $list['region_name']
			);
		}
		$this->assign('region',$region);
        $this->_config_seo('title', Lang::get('ju_life') . ' - ' . Conf::get('site_title'));
		$this->import_resource(array('style' =>array(array('path'=>'res:css/ju.css'))));
        $this->display("ju.life.html");
    }
	
	function search()
	{
		$param = $this->_get_query_param();
		$conditions = $this->_get_conditions($param);
		$page   =   $this->_get_page(12);    //获取分页信息
		$ju_list = $this->_ju_mod->find(array(
			'join' => 'belong_goods,belong_store,belong_template',
			'conditions' => 'ju.status=1 and ju.channel=5 and jt.state=1' . $conditions,
			'order' => 'ju.channel ASC,ju.group_id DESC',
			'limit' => $page['limit'],  //获取当前页的数据
			'fields'=>'this.*,g.goods_id,g.goods_name,g.store_id,g.default_spec,g.price,g.default_image,s.region_id,s.region_name',
			'count' => true
		));
				
		import('init.lib');
		$init = new Init_Ju_lifeApp();
		$ju_list = $init->format_ju_list($ju_list, $this->_ju_mod);
		
		//排序
		$order = isset($_GET['order']) ? $_GET['order'] : '';
		if($order)
		{
				switch($order)
				{
					case 'sale' :
						$ju_list = $this->array_sort($ju_list,'all_count','desc');
					break;
					case 'discount' :
						$ju_list = $this->array_sort($ju_list,'discount','desc');
					break;
					case 'addtime' :
						$ju_list = $this->array_sort($ju_list,'group_id','desc');
					break;
					default :
					break;
				}
		}
		//按地区搜索
		$region_id = isset($_GET['region_id']) ? $_GET['region_id'] : '';
		if($region_id)
		{
			foreach($ju_list as $key => $ju)
			{
				if($ju['region_id'] != $region_id)
				{
					unset($ju_list[$key]);
				}
			}
		}
		$page['item_count'] = $this->_ju_mod->getCount();   //获取统计的数据
		$this->_format_page($page);
		$this->assign('page_info', $page);
		$this->assign('ju_list',$ju_list);
		$cate_list = $this->_list_category();
		$this->assign('cate_list',$cate_list);
		$ju_list_all = $this->_ju_mod->find(array(
			'join' => 'belong_store,belong_template',
			'conditions' => 'ju.status=1 and ju.channel=5 and jt.state=1',
			'fields'=>'this.*,s.region_id,s.region_name'
		)); 
		$this->assign('ju_count',count($ju_list_all));
		$cate_parent = $this->_jucate_mod->get("if_show = 1 and parent_id = '0' and channel=5");
		$cate_child = $this->_jucate_mod->get_children($cate_parent['cate_id'],false);
		foreach($cate_child as $k => $child)
		{
			$cate_child[$k]['count'] = 0;
			foreach($ju_list_all as $list)
			{
				if($child['cate_id'] == $list['cate_id'])
				{
					$cate_child[$k]['count'] += 1;
				}
			}
		}
		$this->assign('cate_child',$cate_child);
		$region = array();//地区筛选
		foreach($ju_list_all as $list)
		{
			$region[$list['region_id']] = array(
				'region_id' => $list['region_id'],
				'region_name' => $list['region_name']
			);
		}
		$this->assign('region',$region);
        $this->_config_seo('title', Lang::get('ju_life') . ' - ' . Conf::get('site_title'));
		$this->import_resource(array('style' =>array(array('path'=>'res:css/ju.css'))));
        $this->display("ju.life_search.html");
	}

	function _list_category()
    {
        $cache_server =& cache_server();
        $key = 'page_ju_category';
        $data = $cache_server->get($key);
        if ($data === false)
        {
            $categories = $this->_jucate_mod->find(array(
				'conditions' => "if_show = 1 and parent_id = '0' and channel in (1,5)",
			));
			$categories1 = array();
			foreach($categories as $categorie)
			{
				$categories1 += $this->_jucate_mod->find(array(
					'conditions' => "if_show = 1 and parent_id = ".$categorie['cate_id'],
				));
			}
            import('tree.lib');
            $tree = new Tree();
            $tree->setTree(array_merge($categories,$categories1), 'cate_id', 'parent_id', 'cate_name');
            $data = $tree->getArrayList(0);

            $cache_server->set($key, $data, 3600);
        }
        return $data;
    }
	
	function _get_query_param()
    {
        static $res = null;
        if ($res === null)
        {
            $res = array();
            // cate_id
            if (isset($_GET['cate_id']) && intval($_GET['cate_id']) > 0)
            {
                $res['cate_id'] = intval($_GET['cate_id']);
            }
        }
        return $res;
    }
	
	/**
     * 取得查询条件语句
     *
     * @param   array   $param  查询参数（参加函数_get_query_param的返回值说明）
     * @return  string  where语句
     */
    function _get_conditions($param)
    {
        if (isset($param['cate_id']))
        {
			$ids_arr = $this->_jucate_mod->get_descendant($param['cate_id']);
			$ids = implode(',',$ids_arr);
            $conditions .= " AND ju.cate_id in (" . $ids . ")";
        }
        return $conditions;
    }
	
	function array_sort($arr, $keys, $type = 'desc') 
	{
        $keysvalue = $new_array = array();
        foreach ($arr as $k => $v) 
		{
            $keysvalue[$k] = $v[$keys];
        }
        if ($type == 'asc') 
		{
            asort($keysvalue);
        } 
		else 
		{
            arsort($keysvalue);
        }
        reset($keysvalue);
        foreach ($keysvalue as $k => $v) 
		{
            $new_array[$k] = $arr[$k];
        }
        return $new_array;
    }
}

?>
