<?php

class storetopApp extends MemberbaseApp {

    function index() {

        $store_mod = & m('store');
		$epay_mod=   & m('epay');
		$filter = $this->_get_query_conditions(array(
            array(
                'field' => 'store_name',
                'equal' => 'like',
            ),
            array(
                'field' => 'sgrade',
            ),
        ));
		
		
	    $page = $this->_get_page();
        $stores = $store_mod->find(array(
            'conditions' => $conditions,
            'join'  => 'belongs_to_user',
            'fields'=> 'this.*,member.user_name',
            'limit' => $page['limit'],
            'count' => true,
            'order' => "store_id desc"
        ));	
		
		foreach($stores as $key=>$val)
		{
		$row=$this->order_sum($val['store_id']);
		
		$epay_info=$epay_mod->get("user_id=".$val['store_id']);
		
		$stores[$key]['goods_amount']=$row['goods_amount'];
		$stores[$key]['quantity']=$row['quantity'];
		$stores[$key]['money']=$epay_info['money'];
		$stores[$key]['moneyxn']=$epay_info['money'];
		}
		$this->assign('stores', $stores);
		
		$this->_curitem('storetop');

        $this->_curmenu('storetop');
        $this->display('storetop.index.html');
    }
    
	
	function order_sum($seller_id)
	{
	
	  $model_order =& m('order');
	  $goods_amount= $model_order->getOne("SELECT SUM(goods_amount) FROM " . DB_PREFIX . "order WHERE status=40");
	  $orders=  $model_order->find(array(
            'conditions'    => '1=1 and seller_id =' . $seller_id,
                      //允许统计
        )); //找出所有商城的合作伙伴
		$orders_id='0';
	   foreach($orders as $key=>$val)
	   {
	   
	   $orders_id .=','.$val['order_id'];
	   }
	 
  $quantity= $model_order->getOne("SELECT SUM(quantity) FROM " . DB_PREFIX . "order_goods WHERE order_id in ($orders_id)");
     
	  $row['quantity']= $quantity;
      $row['goods_amount']= $goods_amount;
      
	  return  $row;
	  
	}
	

}

?>