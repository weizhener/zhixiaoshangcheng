<?php

/* 促销管理控制器 */
class Seller_promotionApp extends StoreadminbaseApp
{
	var $_goods_mod;
    var $_store_mod;
	var $_spec_mod;
	var $_promotion_mod;

    /* 构造函数 */
    function __construct()
    {
         $this->Seller_promotionApp();
    }

    function Seller_promotionApp()
    {
        parent::__construct();

        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_goods_mod =& bm('goods', array('_store_id' => $this->_store_id));
        $this->_spec_mod  =& m('goodsspec');
		$this->_promotion_mod = & m('promotion');
    }

    function index()
    {
		if(!empty($_GET['pro_name'])){
			$conditions = " AND pro.pro_name LIKE '%".trim($_GET['pro_name'])."%' ";
		}
		else{
			$conditions = '';
		}
		
		$page   =   $this->_get_page(10);    //获取分页信息
        $promotion_list = $this->_promotion_mod->find(
            array(
                'join' => 'belong_goods',
                'conditions' => "pro.store_id=".$this->_store_id . $conditions,
                'order' => 'pro.pro_id DESC',
                'limit' => $page['limit'],  //获取当前页的数据
				'fields' => 'pro.*,g.default_image,g.price,g.default_spec',
                'count' => true
            )
        );
        $page['item_count'] = $this->_promotion_mod->getCount();   //获取统计的数据
        foreach ($promotion_list as $key => $promotion)
        {
            $promotion['spec_price'] = unserialize($promotion['spec_price']);
			if($promotion['spec_price'][$promotion['default_spec']]['is_pro']==1)
			{
			   if($promotion['spec_price'][$promotion['default_spec']]['pro_type'] == 'price') // 这里是计算默认规格的价格
			   {
				  $promotion_list[$key]['pro_price'] = round($promotion['price'] - $promotion['spec_price'][$promotion['default_spec']]['price'],2);
			   }
			   else
			   {
				  $promotion_list[$key]['pro_price'] = round($promotion['price'] * $promotion['spec_price'][$promotion['default_spec']]['price'] / 10,2);
			   }
			}
			else{
				$promotion_list[$key]['pro_price'] = $promotion['price'];// 如果默认规格没有设置促销，则显示原价
			}
            $promotioin['default_image'] || $promotioin_list[$key]['default_image'] = Conf::get('default_goods_image');
        }
		
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                         LANG::get('promotion_manage'), 'index.php?app=seller_promotion',
                         LANG::get('promotion_list'));
		/* 当前用户中心菜单 */
        $this->_curitem('promotion_manage');
		 /* 当前所处子菜单 */
        $this->_curmenu('promotion_list');
		$this->_format_page($page);
        $this->_import_resource();
        $this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条
        $this->assign('promotion_list', $promotion_list);
		$this->assign('time_now', gmtime());
		
		$this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('add_promotion'));
		$this->display('seller_promotion.index.html');
	}
	function add() 
	{
		if(!IS_POST) 
		{
			
			$goods_mod = &bm('goods', array('_store_id' => $this->_store_id));
            $goods_count = $goods_mod->get_count();
            if ($goods_count == 0)
            {
                $this->show_warning('has_no_goods', 'add_goods', 'index.php?app=my_goods&act=add');
                return;
            }
			
			/* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                             LANG::get('promotion_manage'), 'index.php?app=seller_promotion',
                             LANG::get('add_promotion'));

            /* 当前用户中心菜单 */
            $this->_curitem('promotion_manage');

            /* 当前所处子菜单 */
            $this->_curmenu('add_promotion');
			$this->assign('store_id', $this->_store_id);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('add_promotion'));
			$this->_import_resource();
			$this->display('seller_promotion.form.html');
		}
		else
        {
            /* 检查数据 */
            if (!$this->_handle_post_data($_POST, 0))
            {
                $this->show_warning($this->get_error());
                return;
            }
            $promotion_info = $this->_promotion_mod->get($this->_last_update_id);
            if (true)
            {
                $_goods_info  = $this->_query_goods_info($promotion_info['goods_id']);
                $promotion_url = SITE_URL . '/' . url('app=goods&id=' . $promotion_info['goods_id']);
                $feed_images = array();
                $feed_images[] = array(
                    'url'   => SITE_URL . '/' . $_goods_info['default_image'],
                    'link'   => $promotion_url,
                );
                $this->send_feed('promotion_created', array(
                    'user_id' => $this->visitor->get('user_id'),
                    'user_name' => $this->visitor->get('user_name'),
                    'promotion_url' => $groupbuy_url,
                    'pro_name' => $promotion_info['pro_name'],
                    'message' => $groupbuy_info['pro_desc'],
                    'images' => $feed_images,
                ));
            }
			
			//  立即更新
			$cache_server =& cache_server();
        	$cache_server->clear();
			
            $this->show_message('add_promotion_ok',
                'back_list', 'index.php?app=seller_promotion',
                'continue_add', 'index.php?app=seller_promotion&amp;act=add'
            );
        }
		
	}
	function edit()
    {
        $id = empty($_GET['id']) ? 0 : $_GET['id'];
        if (!$id)
        {
            $this->show_warning('no_such_promotion');
            return false;
        }
        if (!IS_POST)
        {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                             LANG::get('promotion_manage'), 'index.php?app=seller_promotion',
                             LANG::get('edit_promotion'));

            /* 当前用户中心菜单 */
            $this->_curitem('promotion_manage');

            /* 当前所处子菜单 */
            $this->_curmenu('edit_promotion');

            /* 促销信息 */
            $promotion = $this->_promotion_mod->get($id);
            $promotion['spec_price'] = unserialize($promotion['spec_price']);
            $goods = $this->_query_goods_info($promotion['goods_id']);
            foreach ($goods['_specs'] as $key => $spec)
            {
                if (!empty($promotion['spec_price'][$spec['spec_id']]))
                {
                    $goods['_specs'][$key]['pro_price'] = $promotion['spec_price'][$spec['spec_id']]['price'];
					$goods['_specs'][$key]['pro_type'] = $promotion['spec_price'][$spec['spec_id']]['pro_type'];
                }
            }
			//print_r($goods['_specs']);
            $this->assign('promotion', $promotion);
            $this->assign('goods', $goods);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('edit_promotion'));
            $this->_import_resource();
            $this->display('seller_promotion.form.html');
        }
        else
        {
            /* 检查数据 */
            if (!$this->_handle_post_data($_POST, $id))
            {
                $this->show_warning($this->get_error());
                return;
            }
			
			//  立即更新
			$cache_server =& cache_server();
        	$cache_server->clear();
			
            $this->show_message('edit_promotion_ok',
                'back_list', 'index.php?app=seller_promotion',
                'continue_edit', 'index.php?app=seller_promotion&act=edit&id=' . $id
            );
        }
    }
	function drop()
    {
        $id = empty($_GET['id']) ? 0 : $_GET['id'];
        if (!$id)
        {
            $this->show_warning('no_such_promotion');
            return false;
        }
        if (!$this->_promotion_mod->drop($id))
        {
            $this->show_warning($this->_promotion_mod->get_error());

            return;
        }

        $this->show_message('drop_promotion_successed');
    }
	/**
     * 检查提交的数据
     */
    function _handle_post_data($post, $id = 0)
    {
		if (gmstr2time($post['start_time']) <= gmtime())
        {
            $post['start_time'] = gmtime();
        }
        else
        {
            $post['start_time'] = gmstr2time($post['start_time']);
        }
        if (intval($post['end_time']))
        {
            $post['end_time'] = gmstr2time_end($post['end_time']);
        }
        else
        {
            $this->_error('fill_end_time');
            return false;
        }
        if ($post['end_time'] < $post['start_time'])
        {
            $this->_error('start_not_gt_end');
            return false;
        }

        if (($post['goods_id'] = intval($post['goods_id'])) == 0)
        {
            $this->_error('fill_goods');
            return false;
        }
		if($id == 0 && $this->_promotion_mod->get(array('conditions'=>'goods_id='.$post['goods_id'])))
		{
			$this->_error('goods_has_set_promotion');
			return false;
		}
        if (empty($post['spec_id']) || !is_array($post['spec_id']))
        {
            $this->_error('fill_spec');
            return false;
        }
		$spec_id_yx = array();
		//print_r($post['spec_id']);exit;
        foreach ($post['spec_id'] as $key => $val)
        {
			if (empty($post['pro_price'.$val]))
            {
                $this->_error('invalid_pro_price');
                return false;
            }
			$spec_id_yx[] = $val;
            $spec_price[$val] = array('price' => $post['pro_price'.$val],'pro_type'=>$post['pro_type'.$val],'is_pro'=>1);
        }
		// 取得所有 spec_id,对未设置的进行处理
		$goods_info = $this->_query_goods_info($post['goods_id']);
		foreach($goods_info['_specs'] as $spec)
		{
			if(!in_array($spec['spec_id'],$spec_id_yx))
			{
				$spec_price[$spec['spec_id']] = array('is_pro'=>0);// 设置未选中的 spec_id
			}
		}
		//print_r($spec_price);exit;

        $data = array(
            'pro_name' => $post['pro_name'],
            'pro_desc' => $post['pro_desc'],
            'start_time' => $post['start_time'],
            'end_time'   => $post['end_time'] - 1,
            'goods_id'   => $post['goods_id'],
            'spec_price' => serialize($spec_price),
            'store_id'     => $this->_store_id
        );
        if ($id > 0)
        {
            $this->_promotion_mod->edit($id, $data);
            if ($this->_promotion_mod->has_error())
            {
                $this->_error($this->_promotion_mod->get_error());
                return false;
            }
        }
        else
        {
            if (!($id = $this->_promotion_mod->add($data)))
            {
                $this->_error($this->_promotion_mod->get_error());
                return false;
            }
        }
        $this->_last_update_id = $id;

        return true;
    }
	function query_goods_info()
    {
        $goods_id = empty($_GET['goods_id']) ? 0 : intval($_GET['goods_id']);
        if ($goods_id)
        {
            $goods = $this->_query_goods_info($goods_id);
            $this->json_result($goods);
        }
    }
	function _query_goods_info($goods_id)
    {
        $goods = $this->_goods_mod->get_info($goods_id);
        if ($goods['spec_qty'] ==1 || $goods['spec_qty'] ==2)
        {
            $goods['spec_name'] = htmlspecialchars($goods['spec_name_1'] . ($goods['spec_name_2'] ? ' ' . $goods['spec_name_2'] : ''));
        }
        else
        {
            $goods['spec_name'] = Lang::get('spec');
        }
		
        foreach ($goods['_specs'] as $key => $spec)
        {
            if ($goods['spec_qty'] ==1 || $goods['spec_qty'] ==2)
            {
                $goods['_specs'][$key]['spec'] = htmlspecialchars($spec['spec_1'] . ($spec['spec_2'] ? ' ' . $spec['spec_2'] : ''));
			}
		    else
            {
                $goods['_specs'][$key]['spec'] = Lang::get('default_spec');
            }
					
        }
        $goods['default_image'] || $goods['default_image'] = Conf::get('default_goods_image');
        return $goods;
    }
	function query_goods()
    {
        $goods_mod = &bm('goods', array('_store_id' => $this->_store_id));

        /* 搜索条件 */
        $conditions = "1 = 1";
        if (trim($_GET['goods_name']))
        {
            $str = "LIKE '%" . trim($_GET['goods_name']) . "%'";
            $conditions .= " AND (goods_name {$str})";
        }

        if (intval($_GET['sgcate_id']) > 0)
        {
            $cate_mod =& bm('gcategory', array('_store_id' => $this->visitor->get('manage_store')));
            $cate_ids = $cate_mod->get_descendant(intval($_GET['sgcate_id']));
        }
        else
        {
            $cate_ids = 0;
        }

        /* 取得商品列表 */
        $goods_list = $goods_mod->get_list(array(
            'conditions' => $conditions . ' AND g.if_show=1 AND g.closed=0',
            'order' => 'g.add_time DESC',
            'limit' => 100,
        ), $cate_ids);

        foreach ($goods_list as $key => $val)
        {
            $goods_list[$key]['goods_name'] = htmlspecialchars($val['goods_name']);
        }
        $this->json_result($goods_list);
    }
	function _get_member_submenu()
    {
        $menus = array(
            array(
                'name'  => 'promotion_list',
                'url'   => 'index.php?app=seller_promotion',
            ),
	    array(
                'name' => 'add_promotion',
                'url'  => 'index.php?app=seller_promotion&act=add',
            )
        );

        if (ACT == 'edit')
        {
            $menus[] = array(
                'name' => ACT . '_promotion',
                'url'  => '',
            );
        }
        return $menus;
	}
	function _import_resource()
    {
        if(in_array(ACT, array('index' , 'add', 'edit')))
        {
            $resource['script'][] = array( // JQUERY UI
                'path' => 'jquery.ui/jquery.ui.js'
            );
        }
        if(in_array(ACT, array('index', 'add', 'edit')))
        {
            $resource['script'][] = array( // 对话框
                'attr' => 'id="dialog_js"',
                'path' => 'dialog/dialog.js'
            );
        }
        if(in_array(ACT, array('add', 'edit')))
        {
            $resource['script'][] = array( // 验证
                'path' => 'jquery.plugins/jquery.validate.js'
            );
        }
        if(in_array(ACT, array('add', 'edit'))) //日历相关
        {
            $resource['script'][] = array(
                'path' => 'jquery.ui/i18n/' . i18n_code() . '.js'
            );
            $resource['style'] .= 'jquery.ui/themes/ui-lightness/jquery.ui.css';
        }
        $this->import_resource($resource);
    }
}

?>
