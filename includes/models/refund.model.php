<?php

/* 退款 */
class RefundModel extends BaseModel
{
    var $table  = 'refund';
    var $prikey = 'refund_id';
    var $_name  = 'refund';
	
	var $_relation  = array(
        
        'belongs_to_order' => array(
            'model'         => 'order',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'order_id',
            'reverse'       => 'has_refund',
        ),
	);
	
	function gen_refund_sn()
	{
	
        mt_srand((double) microtime() * 1000000);
        $timestamp = gmtime();
        $y = date('Y', $timestamp);
        $z = date('z', $timestamp);
        $refund_sn = $y . str_pad($z, 3, '0', STR_PAD_LEFT) . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $refund = parent::get(array('conditions'=>'refund_sn=' . $refund_sn,'fields'=>'refund_id'));
        if (!$refund)
        {
            
            return $refund_sn;
        }

       
        return $this->_gen_refund_sn();
	}
	
	
	function get_order_can_confirm_goods($order_info, $adjust_rate = 1)
	{
		
		$goods_close_refund_and_no_refund    = array();
		$ordergoods_mod = &m('ordergoods');
		$goods_amount = $shipping_fee = 0;
				
		$ordergoods = $ordergoods_mod->find(array('conditions'=>"order_id=".$order_info['order_id']));
		foreach($ordergoods as $key=>$goods)
		{
			$goods_refund = parent::get(array('conditions'=>"order_id=".$order_info['order_id']." and goods_id=".$goods['goods_id']." and spec_id=".$goods['spec_id'],'fields'=>'status'));
					
			
			if($goods['status'] != 'SUCCESS' && (!$goods_refund || $goods_refund['status']=='CLOSED'))
			{
				
				$goods_fee = $adjust_rate >=0 ? $goods['price'] * $goods['quantity'] * $adjust_rate : $order_info['goods_amount'] / count($ordergoods);
				
				
				if($order_info['goods_amount'] >0 ) {
					$goods_shipping_fee = round(($order_info['order_amount'] - $order_info['goods_amount']) * $goods_fee / $order_info['goods_amount'],2);
				} else $goods_shipping_fee = round(($order_info['order_amount'] - $order_info['goods_amount']) / count($ordergoods), 2);
				
				$shipping_fee += $goods_shipping_fee; 
				
				$goods_amount += $goods_fee;
						
				
				$goods_close_refund_and_no_refund[$key] = $goods + array('refund_closed' => $goods_refund ? 1 : 0);
			}
		}
		
		return array('confirm_ordergoods' => $goods_close_refund_and_no_refund, 'confirm_order_amount' => round($goods_amount,2) + $shipping_fee);
	}
}

?>