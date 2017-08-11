<?php

class Sale_orderApp extends BackendApp
{
    /**
     *    管理
     *
     *    @author  tianya
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
        $sort  = 'num';
        $order = 'desc';
		$conditions ="GROUP   BY   goods_id";
		$model_order_goods =& m('ordergoods');
		$order_goods = $model_order_goods->find(array(
			'fields' => 'this.*,SUM(quantity) as num',	
            'conditions'    => '1=1 ' . $conditions,
            'limit'         => $page['limit'],  //获取当前页的数据
			'order'         => "$sort $order",
            'count'         => true             //允许统计
        )); 
		$goods_info	=array();
		foreach($order_goods as $key=>$val){
			if(in_array($val['order_id'],$order_ids)){
				/* 该订单该商品的数量 */
			$goods_info[$key]['goods_num']=$val['num'];
			$goods_info[$key]['goods_id']= $val['goods_id'];
			$goods_info[$key]['goods_name']=$val['goods_name'];
			$goods_info[$key]['goods_price']=$val['price'];
			$goods_info[$key]['goods_amount']=$val['price']*$val['num'];
			$goods_info[$key]['cate_name']=$model_order->getOne("SELECT cate_name  FROM " . DB_PREFIX . "goods where goods_id=".$val['goods_id']);
			}
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
        $this->display('sale_order.htm');
    }

}
?>
