<?php

class JuApp extends MallbaseApp
{	
	var $_store_mod;
	var $_jutemplate_mod;
	var $_jucate_mod;
	var $_ju_mod;
	var $_order_mod;

    function __construct()
    {
        $this->JuApp();
    }

    function JuApp()
    {
        parent::__construct();
		$this->_jutemplate_mod =&m('jutemplate');
		$this->_jucate_mod =&m('jucate');
		$this->_ju_mod =&m('ju');
		$this->_order_mod =&m('order');
		$this->_store_mod = &m('store');
    }

    function index()
    {
		$param = $this->_get_query_param();
		$conditions = $this->_get_conditions($param);
		$page   =   $this->_get_page(12);    //获取分页信息
		$ju_list = $this->_ju_mod->find(array(
			'join' => 'belong_goods,belong_template',
			'conditions' => 'ju.status=1 AND jt.state=1' . $conditions,
			'order' => 'ju.recommend DESC,ju.channel ASC,ju.group_id DESC',
			'limit' => $page['limit'],  //获取当前页的数据
			'fields'=>'this.*,g.goods_id,g.goods_name,g.store_id,g.default_spec,g.price,g.default_image',
			'count' => true
		));
		foreach ($ju_list as $key => $ju)
        {
			$ju_list[$key]['group_price'] = unserialize($ju['spec_price']);
			$ju_list[$key]['group_price'] = $ju_list[$key]['group_price'][$ju['default_spec']]['price'];
			$ju_list[$key]['price_save']  = round($ju['price'] - $ju_list[$key]['group_price'],2);
			$ju_list[$key]['all_count']   = $this->_ju_mod->_get_group_join($ju['group_id']);
			if($ju['price'] > 0){
					$ju_list[$key]['discount'] = round(100-$ju_list[$key]['group_price'] / $ju['price'] * 100,1); 
			} else {
					$ju_list[$key]['discount'] = 0;
			}
			empty($ju['default_image']) && $ju_list[$key]['default_image'] = Conf::get('default_goods_image');	
        }
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
		$page['item_count'] = $this->_ju_mod->getCount();   //获取统计的数据
		$this->_format_page($page);
		$this->assign('page_info', $page);
		$this->assign('ju_list',$ju_list);
		$cate_list = $this->_list_category();
		$this->assign('cate_list',$cate_list);
		$this->import_resource(array('style' =>array(array('path'=>'res:css/ju.css'))));
		$this->_config_seo('title', Lang::get('ju') . ' - ' . Conf::get('site_title'));
        $this->display("ju.index.html");
    }
	
	function show()
	{
		$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
		if(!$id)
		{
			$this->show_warning('no_such_groupbuy');
			return;
		}
		$groupbuy = $this->_ju_mod->get(array(
			'join' => 'belong_goods,belong_template',
			'conditions' => 'ju.status=1 AND jt.state=1 AND ju.group_id='.$id,
			'fields'=>'this.*,g.goods_id,g.goods_name,g.store_id,g.default_spec,g.price,g.default_image,g.if_show,g.closed,jt.end_time',
		));
		if(!$groupbuy){
			$this->show_warning('no_such_groupbuy');
			return;
		}
		
		if(!$groupbuy['if_show'] || $groupbuy['closed'])
		{
			header('location:index.php?app=goods&id='.$groupbuy['goods_id']);
			exit();
		}
		
		import('init.lib');
		$init = new Init_JuApp();
		$groupbuy['lefttime'] = $init->lefttime($groupbuy['end_time']);		
		$groupbuy['group_price'] = unserialize($groupbuy['spec_price']);
		$groupbuy['group_price'] = $groupbuy['group_price'][$groupbuy['default_spec']]['price'];
		$groupbuy['price_save']  = round($groupbuy['price'] - $groupbuy['group_price'],2);
		$groupbuy['group_count'] = $this->_ju_mod->_get_group_join($groupbuy['group_id']);
		if($groupbuy['group_price'] > $groupbuy['price']) //如果原价修改后小于聚划算价格 
		{
			$this->_ju_mod->edit($id,"status=3");
			$this->show_warning('no_such_groupbuy');
			return;
		}
		if($groupbuy['price'] > 0){
			$groupbuy['discount'] = round(100-$groupbuy['group_price'] / $groupbuy['price'] * 100,1); 
		} else {
			$groupbuy['discount'] = 0;
		}
		empty($groupbuy['default_image']) && $groupbuy['default_image'] = Conf::get('default_goods_image');
		
		
		$groupbuy_hot = $this->_ju_mod->find(array(
			'join' => 'belong_goods,belong_template',
			'conditions' => 'ju.status=1 AND jt.state=1 AND ju.group_id !='.$groupbuy['group_id'].' and ju.channel='.$groupbuy['channel'],
			'limit' => 5,
			'fields'=>'this.*,g.goods_id,g.goods_name,g.store_id,g.default_spec,g.price,g.default_image',
			'order' => 'views desc',
		));

		$groupbuy_hot = $init->format_groupbuy_hot($groupbuy_hot);
		
		$order_goods_mod =& m('ordergoods');
        $order_list = $order_goods_mod->find(array(
            'conditions' => "order_goods.group_id=".$id,
            'join'  => 'belongs_to_order',
            'fields'=> 'buyer_name, add_time, goods_id, price, quantity,order_goods.group_id',
            'order' => 'add_time desc',
        ));
	
		$this->assign('order_list',$order_list);
		
		/* 赋值商品评论 */
        $comment = $this->_get_goods_comment($groupbuy['goods_id'], 10);
        $this->_assign_goods_comment($comment);
		$this->assign('comment_count',count($comment['comments']));//评论数
		
		/* 更新浏览次数 */
        $this->_ju_mod->edit($id, "views = views + 1");

		//取得店铺信息
		$store = $this->_store_mod->get(array(
			'conditions'=>'store_id='.$groupbuy['store_id'],
			'fields'=>'store_name,im_qq,im_ww,owner_name,region_name,address,tel'
		));
		$this->assign('store',$store);
		$cate_list = $this->_list_category();
		$this->assign('cate_list',$cate_list);
		$this->assign('groupbuy',$groupbuy);
		$this->assign('groupbuy_hot',$groupbuy_hot);
		$this->import_resource(array('style' =>  array(array('path'=>'res:css/ju.css'))));
		$this->_config_seo('title', Lang::get('groupbuy_detail') . ' - ' . Conf::get('site_title'));
		$this->display('ju.show.html'); 
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
		if (isset($param['keyword']))
        {
			$conditions .= " AND ju.group_name LIKE '%".$param['keyword']."%'";
        }
        return $conditions;
    }

    function _get_query_param()
    {
        static $res = null;
        if ($res === null)
        {
            $res = array();
			// keyword
            $keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
            if ($keyword != '')
            {
                $res['keyword'] = $keyword;
            }
            // cate_id
            if (isset($_GET['cate_id']) && intval($_GET['cate_id']) > 0)
            {
                $res['cate_id'] = intval($_GET['cate_id']);
            }
        }
        return $res;
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
	
	/* 取得商品评论 */
    function _get_goods_comment($goods_id, $num_per_page)
    {
        $data = array();

        $page = $this->_get_page($num_per_page);
        $order_goods_mod =& m('ordergoods');
        $comments = $order_goods_mod->find(array(
            'conditions' => "goods_id = '$goods_id' AND evaluation_status = '1'",
            'join'  => 'belongs_to_order',
            'fields'=> 'buyer_id, buyer_name, anonymous, evaluation_time, comment, evaluation',
            'count' => true,
            'order' => 'evaluation_time desc',
            'limit' => $page['limit'],
        ));
        $data['comments'] = $comments;

        $page['item_count'] = $order_goods_mod->getCount();
        $this->_format_page($page);
        $data['page_info'] = $page;
        $data['more_comments'] = $page['item_count'] > $num_per_page;

        return $data;
    }
	/* 赋值商品评论 */
    function _assign_goods_comment($data)
    {
        $this->assign('goods_comments', $data['comments']);
        $this->assign('page_info',      $data['page_info']);
        $this->assign('more_comments',  $data['more_comments']);
    }
}

?>
