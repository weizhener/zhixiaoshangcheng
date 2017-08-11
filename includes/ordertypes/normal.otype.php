<?php

/**
 *    普通订单类型
 *
 *    @author    Garbin
 *    @usage    none
 */
class NormalOrder extends BaseOrder {

    var $_name = 'normal';

    /**
     *    查看订单
     *
     *    @author    Garbin
     *    @param     int $order_id
     *    @param     array $order_info
     *    @return    array
     */
    function get_order_detail($order_id, $order_info) {
        if (!$order_id) {
            return array();
        }

        /* 获取商品列表 */
        $data['goods_list'] = $this->_get_goods_list($order_id);

        /* 配关信息 */
        $data['order_extm'] = $this->_get_order_extm($order_id);

        /* 支付方式信息 */
        if ($order_info['payment_id']) {
            $payment_model = & m('payment');
            $payment_info = $payment_model->get("payment_id={$order_info['payment_id']}");
            $data['payment_info'] = $payment_info;
        }

        /* 订单操作日志 */
        $data['order_logs'] = $this->_get_order_logs($order_id);

        return array('data' => $data);
    }

    /* 显示订单表单 */

   /* 显示订单表单 */
    function get_order_form($goods_info) // delivery
    {
        $data = array();
        $template = 'order.form.html';

        $visitor =& env('visitor');

        /* 获取我的收货地址 */
        $data['my_address']         = $this->_get_my_address($visitor->get('user_id'));
		if(!$data['my_address'])
	{
		  $data['my_address']['region_id']='2';
	}
        $data['addresses']          =   ecm_json_encode($data['my_address']);
        $data['regions']            = $this->_get_regions();


        
/* 配送方式  改为运费模板 tyioocom

		/* 根据 goods_info['items'] 找出每个商品的运费模板id */
		$goods_mod = &m('goods');
		$delivery_mod = &m('delivery_template');
		$deliverys = $base_deliverys = array();
		foreach($goods_info['items'] as $goods)
		{
			$search_goods = $goods_mod->get(array(
				'conditions'=>'goods_id='.$goods['goods_id'],
				'fields'=>'delivery_template_id'
			));
			$template_id = $search_goods['delivery_template_id'];
			
			/* 如果商品的运费模板id为0，即未设置运费模板，则获取店铺默认的运费模板（取第一个） */
			if(!$template_id)
			{
				$delivery = $delivery_mod->get(array(
					'conditions'=>'store_id='.$goods_info['store_id']
				));
				
				
				if(empty($delivery)){
					
					$delivery = $delivery_mod->find(array(
					'conditions'=>'1'));
					$delivery=current($delivery);
				
					}
				
				// 如果店铺也没有默认的运费模板
				if(empty($delivery)){
					$this->_error('store_no_delivery');
					return false;
				}
							
			} else {
				$delivery = $delivery_mod->get($template_id);
			}
			
			$base_deliverys[$goods['goods_id']] = $delivery;
		}
		
		/* 根据运送目的地，获取运费情况 */
		foreach($data['my_address'] as $addr_id=>$my_address)
		{
			$city_id = $my_address['region_id']; // 此处不是 city_id 的话，可能影响也不大。
			foreach($base_deliverys as $key=>$delivery){
				$deliverys[$key] = $delivery_mod->get_city_logist($delivery,$city_id);
			}
			/* 判断这些运费模板中的运费方式是否全等（只有在全等的情况下，才能统一计算运费，否则分开计算* /
			/* 注：目前已经强制每个运费模板都必须设置三个运送方式，所以不存在不全等的情况，此处是留备日后拓展 */
			$k = 0;
			$can_merge = true;
			foreach($deliverys as $delivery)
			{
				$k++;
				if($k==1){
					$first_template_types_count = count($delivery);
				} elseif($first_template_types_count != count($delivery)){ // 如果有一个运送方式个数不等，则认为运送方式不全等
					//$can_merge = false;
				}
			}
		
			/* 一、如果每个商品可用的运送方式都一致，则统一计算；二、 如果有一个商品的运送方式不同，则进行组合计算 */
			/* 注：目前已经强制每个运费模板都必须设置三个运送方式，所以不存在不全等的情况，此处是留备日后拓展 */
			if($can_merge)
			{ 
				/* 1. 分别计算每个运送方式的费用：找出首费最大的那个运费方式，作为首费，并且找出作为首费的那个商品id，便于在统计运费总额时，该商品使用首费，其他商品使用续费计算 */
				$merge_info = array(
					'express' => array('start_fees'=>0,'goods_id'=>0),
					'ems'     => array('start_fees'=>0,'goods_id'=>0),
					'post'    => array('start_fees'=>0,'goods_id'=>0),
				);
				foreach($deliverys as $goods_id=>$delivery)
				{
					foreach($delivery as $template_types)
					{
						if($merge_info[$template_types['type']]['start_fees'] < $template_types['start_fees']){
							$merge_info[$template_types['type']]['start_fees'] = $template_types['start_fees'];
							$merge_info[$template_types['type']]['goods_id'] = $goods_id;
						}
					}
				}
				/* 计算每个订单（店铺）的商品的总件数（包括不同规格）和每个商品的总件数（包括不同规格），以下会用到总件数来计算运费 */
				$total_quantity = 0;
				$quantity = array();
				foreach($goods_info['items'] as $goods)
				{
					$quantity[$goods['goods_id']] += $goods['quantity'];
					$total_quantity += $goods['quantity'];
				}
				/* 计算总运费 */
				$logist = array();
				foreach($deliverys as $goods_id=>$delivery)
				{
					foreach($delivery as $template_types)
					{
						if($goods_id == $merge_info[$template_types['type']]['goods_id']){
							if($total_quantity > $template_types['start_standards'] && $template_types['add_standards'] > 0){
								$goods_fees = $merge_info[$template_types['type']]['start_fees'] + ($quantity[$goods_id]- $template_types['start_standards']) / $template_types['add_standards'] * $template_types['add_fees'];
								//$logist[$template_types['type']]['list_fee'][$goods_id]['logist_fee'] +=  $goods_fees;
							} else {
								$goods_fees = $merge_info[$template_types['type']]['start_fees'];
								//$logist[$template_types['type']]['list_fee'][$goods_id]['logist_fee'] +=  $goods_fees;
							}	
						}
						else
						{
							if($template_types['add_standards']>0){
								$goods_fees = $quantity[$goods_id] / $template_types['add_standards'] * $template_types['add_fees'];
							} else {
								$goods_fees = $template_types['add_fees'];
							}
							//$logist[$template_types['type']]['list_fee'][$goods_id]['logist_fee'] += $goods_fees;
						}
						$logist[$template_types['type']]['logist_fees'] += $goods_fees;
						$logist[$template_types['type']] += $template_types;
					}
				}
				$data['shipping_methods'][$addr_id] = $logist;
			}
		}
		
		$data['template_id'] =$template_id;
		$data['shippings'] = ecm_json_encode($data['shipping_methods']);
		$data['shipping_methods'] = current($data['shipping_methods']);// 取默认（第一条地区对应的运费）
		
		// end tyioocom delivery

        return array('data' => $data, 'template' => $template);
    }


    /**
     *    提交生成订单，外部告诉我要下的单的商品类型及用户填写的表单数据以及商品数据，我生成好订单后返回订单ID
     *
     *    @author    Garbin
     *    @param     array $data
     *    @return    int
     */
    function submit_order($data) {
        /* 释放goods_info和post两个变量 */
        extract($data);
        /* 处理订单基本信息 */
        $base_info = $this->_handle_order_info($goods_info, $post);
        if (!$base_info) {
            /* 基本信息验证不通过 */

            return 0;
        }

        /* 处理订单收货人信息 */
        $consignee_info = $this->_handle_consignee_info($goods_info, $post);
        if (!$consignee_info) {
            /* 收货人信息验证不通过 */
            return 0;
        }

        /* 至此说明订单的信息都是可靠的，可以开始入库了 */

        /* 插入订单基本信息 */
        //订单总实际总金额，可能还会在此减去折扣等费用
        $base_info['order_amount'] = $base_info['goods_amount'] + $consignee_info['shipping_fee'] - $base_info['discount'];
        
		$base_info['gh_order_amount'] = $base_info['gh_goods_amount'] + $consignee_info['shipping_fee'] - $base_info['discount'];
		
		
        /* 如果优惠金额大于商品总额和运费的总和 */
        if ($base_info['order_amount'] < 0) {
            $base_info['order_amount'] = 0;
            $base_info['discount'] = $base_info['goods_amount'] + $consignee_info['shipping_fee'];
        }
        $order_model = & m('order');
        $order_id = $order_model->add($base_info);

        if (!$order_id) {
            /* 插入基本信息失败 */
            $this->_error('create_order_failed');

            return 0;
        }

        /* 插入收货人信息 */
        $consignee_info['order_id'] = $order_id;
        $order_extm_model = & m('orderextm');
        $order_extm_model->add($consignee_info);

        /* 插入商品信息 */
        $goods_items = array();
        foreach ($goods_info['items'] as $key => $value) {
            $goods_items[] = array(
                'order_id' => $order_id,
                'goods_id' => $value['goods_id'],
                'goods_name' => $value['goods_name'],
                'spec_id' => $value['spec_id'],
                'specification' => $value['specification'],
                'price' => $value['price'],
                'quantity' => $value['quantity'],
                'goods_image' => $value['goods_image'],
            );
        }
        $order_goods_model = & m('ordergoods');
        $order_goods_model->add(addslashes_deep($goods_items)); //防止二次注入

        return $order_id;
    }

}

?>