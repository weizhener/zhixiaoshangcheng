<?php
class StoreApp extends StorebaseApp

{

    function index()

    {

        /* 店铺信息 */

        $_GET['act'] = 'index';
		
		
		$uid = $this->visitor->get('user_id');

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        if (!$id)

        {

            $this->show_warning('Hacking Attempt');

            return;

        }

        $this->set_store($id);

        $store = $this->get_store_data();

        $this->assign('store', $store);



        if ($store['pic_slides_wap']) {

            $pic_slides_wap_arr = json_decode($store['pic_slides_wap'], true);

            foreach ($pic_slides_wap_arr as $key => $slides) {

                $pic_slides_wap[$key]['image_url'] = $slides['url'];

                $pic_slides_wap[$key]['image_link'] = $slides['link'];

            }

            $this->assign('goods_images', $pic_slides_wap);

        }

        

        /* 取得友情链接 */

        $this->assign('partners', $this->_get_partners($id));



        /* 取得推荐商品 */

        $this->assign('recommended_goods', $this->_get_recommended_goods($id));

        $this->assign('new_groupbuy', $this->_get_new_groupbuy($id));



        /* 取得最新商品 */

        $this->assign('new_goods', $this->_get_new_goods($id));

		

		/* 取得热卖商品 */

		$this->assign('hot_sale_goods', $this->_get_hot_sale_goods($id));



        /* 当前位置 */

        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store', $store['store_name']);



        $this->_config_seo('title', $store['store_name'] . ' - ' . Conf::get('site_title'));

        /* 配置seo信息 */

        $this->_config_seo($this->_get_seo_info($store));

        $this->display('store.index.html');

    }

    

    /* 关于我们 */

    function about(){

        $uid = $this->visitor->get('user_id');

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        if (!$id)

        {

            $this->show_warning('Hacking Attempt');

            return;

        }

        $this->set_store($id);

        $store = $this->get_store_data();

        $this->assign('store', $store);

        

        /* 当前位置 */

        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store', $store['store_name']);



        $this->_config_seo('title', $store['store_name'] . ' - ' . Conf::get('site_title'));

        /* 配置seo信息 */

        $this->_config_seo($this->_get_seo_info($store));

        $this->display('store.about.html');

    }



    function search()

    {

        /* 店铺信息 */
		
		$uid = $this->visitor->get('user_id');

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        if (!$id)

        {

            $this->show_warning('Hacking Attempt');

            return;

        }

        $this->set_store($id);

        $store = $this->get_store_data();

        $this->assign('store', $store);



        /* 搜索到的商品 */

        $this->_assign_searched_goods($id);



        /* 当前位置 */

        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',

            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],

            LANG::get('goods_list')

        );



        $this->_config_seo('title', Lang::get('goods_list') . ' - ' . $store['store_name']);

        $this->display('store.search.html');

    }



    function groupbuy()

    {

        /* 店铺信息 */
$uid = $this->visitor->get('user_id');

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        if (!$id)

        {

            $this->show_warning('Hacking Attempt');

            return;

        }

        $this->set_store($id);

        $store = $this->get_store_data();

        $this->assign('store', $store);



        /* 搜索团购 */

        empty($_GET['state']) &&  $_GET['state'] = 'on';

        $conditions = '1=1';

        if ($_GET['state'] == 'on')

        {

            $conditions .= ' AND gb.state ='. GROUP_ON .' AND gb.end_time>' . gmtime();

            $search_name = array(

                array(

                    'text'  => Lang::get('group_on')

                ),

                array(

                    'text'  => Lang::get('all_groupbuy'),

                    'url'  => url('app=store&act=groupbuy&state=all&id=' . $id)

                ),

            );

        }

        else if ($_GET['state'] == 'all')

        {

            $conditions .= ' AND gb.state '. db_create_in(array(GROUP_ON,GROUP_END,GROUP_FINISHED));

            $search_name = array(

                array(

                    'text'  => Lang::get('all_groupbuy')

                ),

                array(

                    'text'  => Lang::get('group_on'),

                    'url'  => url('app=store&act=groupbuy&state=on&id=' . $id)

                ),

            );

        }



        $page = $this->_get_page(16);

        $groupbuy_mod = &m('groupbuy');

        $groupbuy_list = $groupbuy_mod->find(array(

            'fields'    => 'goods.default_image, gb.group_name, gb.group_id, gb.spec_price, gb.end_time, gb.state',

            'join'      => 'belong_goods',

            'conditions'=> $conditions . ' AND gb.store_id=' . $id ,

            'order'     => 'group_id DESC',

            'limit'     => $page['limit'],

            'count'     => true

        ));

        $page['item_count'] = $groupbuy_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);

        if (empty($groupbuy_list))

        {

            $groupbuy_list = array();

        }

        foreach ($groupbuy_list as $key => $_g)

        {

            empty($groupbuy_list[$key]['default_image']) && $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');

            $tmp = current(unserialize($_g['spec_price']));

            $groupbuy_list[$key]['price'] = $tmp['price'];

            if ($_g['end_time'] < gmtime())

            {

                $groupbuy_list[$key]['group_state'] = group_state($_g['state']);

            }

            else

            {

                $groupbuy_list[$key]['lefttime'] = lefttime($_g['end_time']);

            }

        }

        /* 当前位置 */

        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',

            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],

            LANG::get('groupbuy_list')

        );



        $this->assign('groupbuy_list', $groupbuy_list);

        $this->assign('search_name', $search_name);

        $this->_config_seo('title', $search_name[0]['text'] . ' - ' . $store['store_name']);

        $this->display('store.groupbuy.html');

    }



    function article()

    {
$uid = $this->visitor->get('user_id');
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        if (!$id)

        {

            $this->show_warning('Hacking Attempt');

            return;

        }

        $article = $this->_get_article($id);

        if (!$article)

        {

            $this->show_warning('Hacking Attempt');

            return;

        }

        $this->assign('article', $article);



        /* 店铺信息 */

        $this->set_store($article['store_id']);

        $store = $this->get_store_data();

        $this->assign('store', $store);



        /* 当前位置 */

        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',

            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],

            $article['title']

        );



        $this->_config_seo('title', $article['title'] . ' - ' . $store['store_name']);

        $this->display('store.article.html');

    }



    function coupon()

    {


        /* 店铺信息 */
		
		$uid = $this->visitor->get('user_id');
		
        if (!$uid)

        {

            $this->show_warning('非法操作');

            return;

        }
		
		$store_mod = & m('store');
        $store = $store_mod->get($uid);		
        $time = date('Ymd',time());
        if (!$store)

        {

            $this->show_warning('非法操作');

            return;

        }
		
        if ($store['moneytime']>$time)

        {

            $this->show_warning('今天已签到');
            return;

        }
		$sgrade_mod = & m('sgrade');		
		$sgrade = $sgrade_mod->get($store['sgrade']);		
		$m1 = $sgrade['money']*0.7;		
		$m2 = $sgrade['money']*0.2;
          $member_mod = &m('member');
          $member = $member_mod->get($uid);
		  
            $member_mod->edit($uid, array('integral' => $member['integral'] + $m1,'shopmoney' => $member['shopmoney'] + $m2));
            //操作记录入积分记录
            $integral_log_mod = &m('integral_log');
            $integral_log = array(
                'user_id' => $uid,
                'user_name' => $member['user_name'],
                'point' => $m1,
                'add_time' => gmtime(),
                'remark' => '每日返利',
                'integral_type' => INTEGRAL_DATE,
            );
            $integral_log_mod->add($integral_log);
			
			$moneytime = date('Ymd',time()+(3600*24));
			
			$store_mod->edit($uid, array('moneytime' => $moneytime));
			
		$s_mod = & m('store');
		

			
        //1级推荐人 不存在买家的推荐人则返回
        if ($member['referid']) {
		   $referid_1 = $member['referid'];
		   $referinfo_1 = $member_mod->get($referid_1);		
		}
		
		$mystore = array();		
		$yesstore = '0';		
		$storetime = '0';
        //2级推荐人 不存在买家的推荐人则返回
        if ($referinfo_1['referid']) {
          $referid_2 = $referinfo_1['referid'];
          $referinfo_2 = $member_mod->get($referid_2);
		  
		  
		  $mystore = $s_mod->get_info($referinfo_2['user_id']);		
		  $yesstore = $mystore['store_id']>'0' ? '1' : '0';		
		  $storetime = $mystore['end_time']>time() ? '1' : '0';
		  $getmoney = '0';
		  $reg_time = strtotime(date("Y-m-d 00:00",$referinfo_2['reg_time']))+(3600*24*10);		  
		  if($yesstore&&$storetime){
		    $getmoney = '1';		  
		  }else{
		  	if(time()<$reg_time){
		      $getmoney = '1';
			}else{
		      $getmoney = '0';
			}		  
		  }
		  
		  
		  		  
		  
		  if($referinfo_2&&$getmoney=='1'){
		    $m_2 = $sgrade['money']*0.1;	
		    $m_2_1 = $m_2*0.7;		
		    $m_2_2 = $m_2*0.2;		  
            $member_mod->edit($referid_2, array('integral' => $referinfo_2['integral'] + $m_2_1,'shopmoney' => $member['shopmoney'] + $m_2_2));
            //操作记录入积分记录
            $integral_log = array(
                'user_id' => $referid_2,
                'user_name' => $referinfo_2['user_name'],
                'point' => $m_2_1,
                'add_time' => gmtime(),
                'remark' => '二级返利',
                'integral_type' => INTEGRAL_DATE,
            );
            $integral_log_mod->add($integral_log);
			
			
		  }
		  
		}
		$mystore = array();		
		$yesstore = '0';		
		$storetime = '0';
        if ($referinfo_2['referid']) {
          $referid_3 = $referinfo_2['referid'];
          $referinfo_3 = $member_mod->get($referid_3);	
		  $mystore = $s_mod->get_info($referinfo_3['user_id']);		
		  $yesstore = $mystore['store_id']>'0' ? '1' : '0';		
		  $storetime = $mystore['end_time']>time() ? '1' : '0';
		  $getmoney = '0';
		  $reg_time = strtotime(date("Y-m-d 00:00",$referinfo_3['reg_time']))+(3600*24*10);		  
		  if($yesstore&&$storetime){
		    $getmoney = '1';		  
		  }else{
		  	if(time()<$reg_time){
		      $getmoney = '1';
			}else{
		      $getmoney = '0';
			}		  
		  }
		  
		  
		  		  
		  
		  if($referinfo_3&&$getmoney=='1'){
		    $m_3 = $sgrade['money']*0.05;
		    $m_3_1 = $m_3*0.7;		
		    $m_3_2 = $m_3*0.2;		  
            $member_mod->edit($referid_3, array('integral' => $referinfo_3['integral'] + $m_3_1,'shopmoney' => $member['shopmoney'] + $m_3_2));
            //操作记录入积分记录
            $integral_log = array(
                'user_id' => $referid_3,
                'user_name' => $referinfo_3['user_name'],
                'point' => $m_3_1,
                'add_time' => gmtime(),
                'remark' => '三级返利',
                'integral_type' => INTEGRAL_DATE,
            );
            $integral_log_mod->add($integral_log);
		  }
		}
		$this->show_message('恭喜你，签到成功', 'index', 'index.php?app=member');

    }

    

    /* 信用评价 */

    function credit()

    {

        /* 店铺信息 */
		
		$uid = $this->visitor->get('user_id');

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        if (!$id)

        {

            $this->show_warning('Hacking Attempt');

            return;

        }

        $this->set_store($id);

        $store = $this->get_store_data();

        $this->assign('store', $store);

        /* 取得评价过的商品 */

        if (!empty($_GET['eval']) && in_array($_GET['eval'], array(1,2,3)))

        {

            $conditions = "AND evaluation = '{$_GET['eval']}'";

        }

        else

        {

            $conditions = "";

            $_GET['eval'] = '';

        }

        $page = $this->_get_page(10);

        $order_goods_mod =& m('ordergoods');

        $goods_list = $order_goods_mod->find(array(

            'conditions' => "seller_id = '$id' AND evaluation_status = 1 AND is_valid = 1 " . $conditions,

            'join'       => 'belongs_to_order',

            'fields'     => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment',

            'order'      => 'evaluation_time desc',

            'limit'      => $page['limit'],

            'count'      => true,

        ));

        //获取买家的信誉

        if(!empty($goods_list)){

            import('evaluation.lib');

            $evaluation = new Evaluation();

            foreach ($goods_list as $key => $value) {

                $data = $evaluation->get_buyer_evaluation($value['buyer_id']);

                $goods_list[$key]['buyer_credit_value'] = $data['buyer_credit_value'];

                $goods_list[$key]['buyer_credit_image'] = $data['buyer_credit_image'];

                $goods_list[$key]['buyer_praise_rate'] = $data['buyer_praise_rate'];

            }

        }

        $this->assign('goods_list', $goods_list);



        $page['item_count'] = $order_goods_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);



        /* 按时间统计 */

        $stats = array();

        for ($i = 0; $i <= 3; $i++)

        {

            $stats[$i]['in_a_week']        = 0;

            $stats[$i]['in_a_month']       = 0;

            $stats[$i]['in_six_month']     = 0;

            $stats[$i]['six_month_before'] = 0;

            $stats[$i]['total']            = 0;

        }



        $goods_list = $order_goods_mod->find(array(

            'conditions' => "seller_id = '$id' AND evaluation_status = 1 AND is_valid = 1 ",

            'join'       => 'belongs_to_order',

            'fields'     => 'evaluation_time, evaluation',

        ));

        foreach ($goods_list as $goods)

        {

            $eval = $goods['evaluation'];

            $stats[$eval]['total']++;

            $stats[0]['total']++;



            $days = (gmtime() - $goods['evaluation_time']) / (24 * 3600);

            if ($days <= 7)

            {

                $stats[$eval]['in_a_week']++;

                $stats[0]['in_a_week']++;

            }

            if ($days <= 30)

            {

                $stats[$eval]['in_a_month']++;

                $stats[0]['in_a_month']++;

            }

            if ($days <= 180)

            {

                $stats[$eval]['in_six_month']++;

                $stats[0]['in_six_month']++;

            }

            if ($days > 180)

            {

                $stats[$eval]['six_month_before']++;

                $stats[0]['six_month_before']++;

            }

        }

        $this->assign('stats', $stats);



        /* 当前位置 */

        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store',

            $store['store_name'], 'index.php?app=store&amp;id=' . $store['store_id'],

            LANG::get('credit_evaluation')

        );



        $this->_config_seo('title', Lang::get('credit_evaluation') . ' - ' . $store['store_name']);

        $this->display('store.credit.html');

    }



    /* 取得友情链接 */

    function _get_partners($id)

    {
		$uid = $this->visitor->get('user_id');

        $partner_mod =& m('partner');

        return $partner_mod->find(array(

            'conditions' => "store_id = '$id'",

            'order' => 'sort_order',

        ));

    }



    /* 取得推荐商品 */

    function _get_recommended_goods($id, $num = 12)

    {
		$uid = $this->visitor->get('user_id');

        $goods_mod =& bm('goods', array('_store_id' => $id));

        $goods_list = $goods_mod->find(array(

            'conditions' => "closed = 0 AND if_show = 1 AND recommended = 1",

            'fields'     => 'goods_name, default_image, price',

            'limit'      => $num,

        ));

        foreach ($goods_list as $key => $goods)

        {

            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');

        }



        return $goods_list;

    }



    function _get_new_groupbuy($id, $num = 12)

    {

        $model_groupbuy =& m('groupbuy');

        $groupbuy_list = $model_groupbuy->find(array(

            'fields'    => 'goods.default_image, this.group_name, this.group_id, this.spec_price, this.end_time',

            'join'      => 'belong_goods',

            'conditions'=> $model_groupbuy->getRealFields('this.state=' . GROUP_ON . ' AND this.store_id=' . $id . ' AND end_time>'. gmtime()),

            'order'     => 'group_id DESC',

            'limit'     => $num

        ));

        if (empty($groupbuy_list))

        {

            $groupbuy_list = array();

        }

        foreach ($groupbuy_list as $key => $_g)

        {

            empty($groupbuy_list[$key]['default_image']) && $groupbuy_list[$key]['default_image'] = Conf::get('default_goods_image');

            $tmp = current(unserialize($_g['spec_price']));

            $groupbuy_list[$key]['price'] = $tmp['price'];

            $groupbuy_list[$key]['lefttime'] = lefttime($_g['end_time']);

        }



        return $groupbuy_list;

    }



    /* 取得最新商品 */

    function _get_new_goods($id, $num = 12)

    {

        $goods_mod =& bm('goods', array('_store_id' => $id));

        $goods_list = $goods_mod->find(array(

            'conditions' => "closed = 0 AND if_show = 1",

            'fields'     => 'goods_name, default_image, price',

            'order'      => 'add_time desc',

            'limit'      => $num,

        ));

        foreach ($goods_list as $key => $goods)

        {

            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');

        }



        return $goods_list;

    }

	/* 取得热卖商品 */

	function _get_hot_sale_goods($id, $num = 16)

	{

		$goods_mod =& bm('goods', array('_store_id' => $id));

        $goods_list = $goods_mod->find(array(

            'conditions' => "closed = 0 AND if_show = 1",

			'join'		 => 'has_goodsstatistics',

            'fields'     => 'goods_name, default_image, price,sales',

            'order'      => 'sales desc,add_time desc',

            'limit'      => $num,

        ));

        foreach ($goods_list as $key => $goods)

        {

            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');

        }

        return $goods_list;

	}



    /* 搜索到的结果 */

    function _assign_searched_goods($id)

    {

        $goods_mod =& bm('goods', array('_store_id' => $id));

        $search_name = LANG::get('all_goods');



        $conditions = $this->_get_query_conditions(array(

            array(

                'field' => 'goods_name',

                'name'  => 'keyword',

                'equal' => 'like',

            ),

        ));

        if ($conditions)

        {

            $search_name = sprintf(LANG::get('goods_include'), $_GET['keyword']);

            $sgcate_id   = 0;

        }

        else

        {

            $sgcate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);

        }



        if ($sgcate_id > 0)

        {

            $gcategory_mod =& bm('gcategory', array('_store_id' => $id));

            $sgcate = $gcategory_mod->get_info($sgcate_id);

            $search_name = $sgcate['cate_name'];



            $sgcate_ids = $gcategory_mod->get_descendant_ids($sgcate_id);

        }

        else

        {

            $sgcate_ids = array();

        }



        /* 排序方式 */

        $orders = array(

            'add_time desc' => LANG::get('add_time_desc'),

            'price asc' => LANG::get('price_asc'),

            'price desc' => LANG::get('price_desc'),

        );

        $this->assign('orders', $orders);



        $page = $this->_get_page(16);

        $goods_list = $goods_mod->get_list(array(

            'conditions' => 'closed = 0 AND if_show = 1' . $conditions,

            'count' => true,

            'order' => empty($_GET['order']) || !isset($orders[$_GET['order']]) ? 'add_time desc' : $_GET['order'],

            'limit' => $page['limit'],

        ), $sgcate_ids);

        foreach ($goods_list as $key => $goods)

        {

            empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');

        }

        $this->assign('searched_goods', $goods_list);



        $page['item_count'] = $goods_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);



        $this->assign('search_name', $search_name);

    }



    /**

     * 取得文章信息

     */

    function _get_article($id)

    {

        $article_mod =& m('article');

        return $article_mod->get_info($id);

    }

    

    function _get_seo_info($data)

    {

        $seo_info = $keywords = array();

        $seo_info['title'] = $data['store_name'] . ' - ' . Conf::get('site_title');        

        $keywords = array(

            str_replace("\t", ' ', $data['region_name']),

            $data['store_name'],

        );

        //$seo_info['keywords'] = implode(',', array_merge($keywords, $data['tags']));

        $seo_info['keywords'] = implode(',', $keywords);

        $seo_info['description'] = sub_str(strip_tags($data['description']), 10, true);

        return $seo_info;

    }

}



?>

