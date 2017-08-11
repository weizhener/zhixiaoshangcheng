<?php

class Sale_listApp extends BackendApp
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

        $conditions = $this->_get_query_conditions(array(array(
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
            ),
        ));
        $model_order =& m('order');
       	$page = $this->_get_page();    //获取分页信息
        //更新排序
        $sort  = 'add_time';
        $order = 'desc';
		if($conditions)
		{
		
		
        $orders = $model_order->find(array(
            'conditions'    => '1=1 ' . $conditions,
           // 'limit'         => $page['limit'],  //获取当前页的数据
            'order'         => "$sort $order",
            'count'         => true             //允许统计
        ));
		
		
		$order_ids=array();
		foreach($orders as $key=>$val){
			$order_ids[$key]=$val['order_id'];
		}
		if($order_ids)
		{
		$order_ids= implode(',',$order_ids);
		$condi=" and  order_id in($order_ids)";
		}
		
		}	
		$model_order_goods =& m('ordergoods');
		$order_goods = $model_order_goods->find(array(
			
            'conditions'    => '1=1 '.$condi,
            'limit'         => $page['limit'],  //获取当前页的数据
            'count'         => true ,           //允许统计
			'order'         => "rec_id DESC ",
        )); 
		$goods_info	=array();
		foreach($order_goods as $key=>$val){
			
				/* 该订单该商品的数量 */
			$goods_num = $val['quantity'];
			$goods_name = $val['goods_name'];
			$goods_price = $val['price'];
			$goods_info[$key]['goods_num']=$goods_num;
			$goods_info[$key]['goods_id']= $val['goods_id'];
			$goods_info[$key]['goods_name']=$goods_name;
			$goods_info[$key]['goods_price']=$goods_price;
			$goods_info[$key]['finished_time']=$model_order->getOne("SELECT finished_time FROM " . DB_PREFIX . "order where order_id=".$val['order_id']);
			$goods_info[$key]['add_time']=$model_order->getOne("SELECT add_time FROM " . DB_PREFIX . "order where order_id=".$val['order_id']);
			$goods_info[$key]['order_sn']=$model_order->getOne("SELECT order_sn FROM " . DB_PREFIX . "order where order_id=".$val['order_id']);
		
		}

        $page['item_count'] = $model_order_goods->getCount();   //获取统计的数据

        $this->_format_page($page);
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条
        $this->assign('orders', $goods_info);
        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
		  $model_setting = &af('settings');
        	$setting = $model_setting->getAll(); //载入系统设置数据
			$this->assign('setting', $setting);
        $this->display('sale_list.htm');
    }

}
?>
