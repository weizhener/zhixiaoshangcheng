<?php

/**
 *    合作伙伴控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class OrderApp extends BackendApp
{
    /**
     *    管理
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function index()
    {
        $search_options = array(
            'seller_name'   => Lang::get('store_name'),
            'buyer_name'   => Lang::get('buyer_name'),
            'payment_name'   => Lang::get('payment_name'),
            'order_sn'   => Lang::get('order_sn'),
        );
        /* 默认搜索的字段是店铺名 */
        $field = 'seller_name';
        array_key_exists($_GET['field'], $search_options) && $field = $_GET['field'];
        $conditions = $this->_get_query_conditions(array(array(
                'field' => $field,       //按用户名,店铺名,支付方式名称进行搜索
                'equal' => 'LIKE',
                'name'  => 'search_name',
            ),array(
                'field' => 'status',
                'equal' => '=',
                'type'  => 'numeric',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'   => 'gmstr2time_end',
            ),array(
                'field' => 'order_amount',
                'name'  => 'order_amount_from',
                'equal' => '>=',
                'type'  => 'numeric',
            ),array(
                'field' => 'order_amount',
                'name'  => 'order_amount_to',
                'equal' => '<=',
                'type'  => 'numeric',
            ),
        ));
        $model_order =& m('order');
        $page   =   $this->_get_page(10);    //获取分页信息
        //更新排序
        if (isset($_GET['sort']) && isset($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'add_time';
             $order = 'desc';
            }
        }
        else
        {
            $sort  = 'add_time';
            $order = 'desc';
        }
        $orders = $model_order->find(array(
            'conditions'    => '1=1  ' . $conditions,
            'limit'         => $page['limit'],  //获取当前页的数据
            'order'         => "$sort $order",
            'count'         => true             //允许统计
        )); //找出所有商城的合作伙伴
		
		
		
		foreach($orders as $key=>$val)
		{
		//print_r($val);
		$orders[$key]['ptmoney']=$val['order_amount']-$val['gh_order_amount'];
		
	    $orders[$key]['gh_price']=$this->diqu_buyer($val);
		$gh_price += $orders[$key]['gh_price'];
		
		$ptmoney +=$orders[$key]['ptmoney'];
		$gh_goods_amount +=$val['gh_goods_amount'];
		$order_amount +=$orders[$key]['order_amount'];
		}
		
		$this->assign('order_amount', $order_amount);
		 $this->assign('gh_price', $gh_price);
		 $this->assign('ptmoney', $ptmoney);
		 $this->assign('gh_goods_amount', $gh_goods_amount);
        $page['item_count'] = $model_order->getCount();   //获取统计的数据
        $this->_format_page($page);
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('order_status_list', array(
            ORDER_PENDING => Lang::get('order_pending'),
            ORDER_SUBMITTED => Lang::get('order_submitted'),
            ORDER_ACCEPTED => Lang::get('order_accepted'),
            ORDER_SHIPPED => Lang::get('order_shipped'),
            ORDER_FINISHED => Lang::get('order_finished'),
            ORDER_CANCELED => Lang::get('order_canceled'),
        ));
        $this->assign('search_options', $search_options);
        $this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条
        $this->assign('orders', $orders);
        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
        $this->display('order.index.html');
    }
	
	
	function diqu_buyer($order)
	{
	  $add_time = gmtime();
	
	  $model_extm = & m('orderextm');
      $extm_info= $model_extm->get("order_id=".$order['order_id']);
	  $daili_mod =& m('daili');
	  $goods_mod =& m('goods');
	   $model_region = & m('region');
	  $daili_list= $daili_mod->find(array(
           'conditions' => '1=1' . $conditions,
            
            'order' => "id desc",
         
        ));
		$model_order_goods = & m('ordergoods');
		
		
		 $goods_list= $model_order_goods->find(array(
           'conditions' => "order_id=".$order['order_id'],
           
         ));
		 
		 foreach($goods_list as $vv)
		 {
		    $goods_info=	 $goods_mod->get($vv['goods_id']);
		    $gh_price+=($vv['price']-$vv['gh_price'])*$goods_info['fengcheng'];
		 
		 }
		 
		 
		 if($gh_price  <= 0)
		 {
		 return '';
		 }
		
	  foreach($daili_list as $key=>$val)
	  {
		 $diqu = unserialize($val['diqu']);
		 
	     if(is_array($diqu))
		 {
		   foreach($diqu as $k=>$v)
		   {
		 
		$son_diqu =  $model_region->get_descendant($k);
		
		//print_r($son_diqu);
		    if(in_array($extm_info['region_id'],$son_diqu))
			{
	
		    return $gh_price;   
			
			break ;	
			}
		
		
		   }
		 
		 }
		 
	  }	
	  

	  	
	
	
	
	}
    
/**
     * 订单导出
     */
    function export()
    {
        $search_options = array(
            'seller_name'   => Lang::get('store_name'),
            'buyer_name'   => Lang::get('buyer_name'),
            'payment_name'   => Lang::get('payment_name'),
            'order_sn'   => Lang::get('order_sn'),
        );
        /* 默认搜索的字段是店铺名 */
        $field = 'seller_name';
        array_key_exists($_GET['field'], $search_options) && $field = $_GET['field'];
        $conditions = $this->_get_query_conditions(array(array(
                'field' => $field,       //按用户名,店铺名,支付方式名称进行搜索
                'equal' => 'LIKE',
                'name'  => 'search_name',
            ),array(
                'field' => 'status',
                'equal' => '=',
                'type'  => 'numeric',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'   => 'gmstr2time_end',
            ),array(
                'field' => 'order_amount',
                'name'  => 'order_amount_from',
                'equal' => '>=',
                'type'  => 'numeric',
            ),array(
                'field' => 'order_amount',
                'name'  => 'order_amount_to',
                'equal' => '<=',
                'type'  => 'numeric',
            ),
        ));
        
        $model_order =& m('order');
        $page   =   $this->_get_page(10);    //获取分页信息
        //更新排序
        if (isset($_GET['sort']) && isset($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'add_time';
             $order = 'desc';
            }
        }
        else
        {
            $sort  = 'add_time';
            $order = 'desc';
        }
        $orders = $model_order->find(array(
            'conditions'    => '1=1 ' . $conditions,
            'order'         => "$sort $order",
            'join'=>'has_orderextm',
        )); //找出所有商城的合作伙伴
        
        
        
        import('excelwriter.lib');
        $excel = new ExcelWriter('utf8', 'toexcel');
        if (!$orders) {
            $this->show_warning('无数据');
            return;
        }

        $cols = array();
        $cols_item = array();
        $cols_item[] = '订单编号';
        $cols_item[] = '店铺名称';
        $cols_item[] = '消费者名称';
        $cols_item[] = '消费者邮箱';
        $cols_item[] = '订单状态';
        $cols_item[] = '下单时间';
        $cols_item[] = '支付方式';
        $cols_item[] = '付款时间';
        $cols_item[] = '发货时间';
        $cols_item[] = '快递单号';
        $cols_item[] = '完成时间';
        $cols_item[] = '商品总价';
        $cols_item[] = '折扣';
        $cols_item[] = '订单总价';
		  $cols_item[] = '供货总价';
        $cols_item[] = '付款留言';
        $cols_item[] = '收货地区';
        $cols_item[] = '收货地址';
        $cols_item[] = '邮编';
        $cols_item[] = '电话';
        $cols_item[] = '手机';
        $cols_item[] = '快递方式';
        $cols_item[] = '快递费用';

        $cols[] = $cols_item;

        if (is_array($orders) && count($orders) > 0) {
            foreach ($orders as $k => $v) {

                $tmp_col = array();
                $tmp_col[] = $v['order_sn'];
                $tmp_col[] = $v['seller_name'];
                $tmp_col[] = $v['buyer_name'];
                $tmp_col[] = $v['buyer_email'];
                $tmp_col[] = $this->get_status($v['status']);
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['add_time']);
                $tmp_col[] = $v['payment_name'];
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['pay_time']);
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['ship_time']);
                $tmp_col[] = $v['invoice_no'];
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['finished_time']);
                $tmp_col[] = $v['goods_amount'];
                $tmp_col[] = $v['discount'];
                $tmp_col[] = $v['order_amount'];
				$tmp_col[] = $v['gh_order_amount'];
                $tmp_col[] = $v['postscript'];
                $tmp_col[] = $v['region_name'];
                $tmp_col[] = $v['address'];
                $tmp_col[] = $v['zipcode'];
                $tmp_col[] = $v['phone_tel'];
                $tmp_col[] = $v['phone_mob'];
                $tmp_col[] = $v['shipping_name'];
                $tmp_col[] = $v['shipping_fee'];
                $cols[] = $tmp_col;
            }
        }
        $excel->add_array($cols);
        $excel->output();
        
    }
    
    function get_status($status) {
        switch ($status) {
            case 0:
                $msg = '已取消';
                break;
            case 10:
                $msg = '发货中';
                break;
            case 11:
                $msg = '待付款';
                break;
            case 20:
                $msg = '待发货';
                break;
            case 30:
                $msg = '已发货';
                break;
            case 40:
                $msg = '交易成功';
                break;
            default:
                break;
        }
        return $msg;
    }

    /**
     *    查看
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function view()
    {
        $order_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 获取订单信息 */
        $model_order =& m('order');
        $order_info = $model_order->get(array(
            'conditions'    => $order_id,
            'join'          => 'has_orderextm',
            'include'       => array(
                'has_ordergoods',   //取出订单商品
            ),
        ));

        if (!$order_info)
        {
            $this->show_warning('no_such_order');
            return;
        }
        $order_type =& ot($order_info['extension']);
        $order_detail = $order_type->get_order_detail($order_id, $order_info);
        $order_info['group_id'] = 0;
        if ($order_info['extension'] == 'groupbuy')
        {
            $groupbuy_mod =& m('groupbuy');
            $groupbuy = $groupbuy_mod->get(array(
                'fields' => 'groupbuy.group_id',
                'join' => 'be_join',
                'conditions' => "order_id = {$order_info['order_id']} ",
                )
            );
            $order_info['group_id'] = $groupbuy['group_id'];
        }
        foreach ($order_detail['data']['goods_list'] as $key => $goods)
        {
            if (substr($goods['goods_image'], 0, 7) != 'http://')
            {
                $order_detail['data']['goods_list'][$key]['goods_image'] = SITE_URL . '/' . $goods['goods_image'];
            }
        }
        $this->assign('order', $order_info);
        $this->assign($order_detail['data']);
        $this->display('order.view.html');
    }
}
?>
