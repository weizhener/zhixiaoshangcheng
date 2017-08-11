<?php

class Tuijian {

    var $_epay_mod;
    var $_epaylog_mod;
    var $_member_mod;

    function __construct() {
        $this->_epay_mod = & m('epay');
        $this->_epaylog_mod = & m('epaylog');
        $this->_member_mod = & m('member');
    }

    function do_tuijian($order) {
        $this->tuijian_seller($order);
        $this->tuijian_buyer($order);
	    $this->diqu_buyer($order);
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
		
		        
				
				
		
		        $this->change_epay(
                array(
                    'user_id' => $val['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $val['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => $gh_price, #一级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' =>$v.'代理区域利润提成',
                )
        ); 
		  $buyer_id = $val['user_id'];
          $buyer_info = $this->_member_mod->get($buyer_id);


        //1级推荐人 不存在买家的推荐人则返回
        if (!$buyer_info['referid']) {
            return;
        }
		
		 if ($val['tjbl'])
		 {
           $referinfo_1 = $this->_member_mod->get($buyer_info['referid']);
		  $this->change_epay(
                array(
                    'user_id' => $referinfo_1['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $referinfo_1['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => round($gh_price*$val['tjbl'],2), #一级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' =>'推荐'.$val['user_name'].'代理区域利润提成',
                )
        );  
         
		 }
			 return;
			break ;	
			}
		
		
		   }
		 
		 }
		 
	  }	

	}

    /**
     * 此处是  推荐成为卖家， 卖家卖出产品后，他的推荐者可以获得佣金
     */
    function tuijian_seller($order) {
        $add_time = gmtime();
        
        //判断是否开启 推荐会员成为卖家 ， 卖家卖出产品  推荐者会获取提成
        if (!Conf::get('tuijian_seller_status')) {
            return;
        }

        /* 第1级 佣金操作  查看卖家是否有推荐人  BEGIN */
        if (!Conf::get('tuijian_seller_ratio1')) {
            return;
        }
        $tuijian_seller_ratio1 = round(Conf::get('tuijian_seller_ratio1') / 100, 2);

        //卖家相关信息
        $seller_id = $order['seller_id'];
        $seller_info = $this->_member_mod->get($seller_id);


        //1级推荐人 不存在卖家的推荐人则返回
        if (!$seller_info['referid']) {
            return;
        }
        $referid_1 = $seller_info['referid'];
        //查看推荐人是否存在 不存在则不操作
        $referinfo_1 = $this->_member_mod->get($referid_1);
        if (empty($referinfo_1)) {
            return;
        }
        //卖家先扣除佣金
        $this->change_epay(
                array(
                    'user_id' => $seller_id,
                    'add_time'=>$add_time,
                    'user_name' => $seller_info['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => round($order['goods_amount'] * $tuijian_seller_ratio1, 2), #一级推荐人应该获取的佣金
                    'money_flow' => 'outlay', #流出佣金
                    'complete' => '1',
                    'log_text' => '恭喜你缴纳' . round($order['goods_amount'] * $tuijian_seller_ratio1, 2) . '元佣金,佣金被1级店铺推荐者'
                    . $referinfo_1['user_name'] . '获得,订单金额为' . $order['goods_amount'] . ',1级佣金比例为' . $tuijian_seller_ratio1
                    . ',推荐关系为:' . $seller_info['user_name'] . '<<--' . $referinfo_1['user_name'],
                )
        );
        //1级推荐人获得佣金
        $this->change_epay(
                array(
                    'user_id' => $referinfo_1['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $referinfo_1['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => round($order['goods_amount'] * $tuijian_seller_ratio1, 2), #一级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' => '恭喜你获得' . round($order['goods_amount'] * $tuijian_seller_ratio1, 2) . '元佣金,佣金由店铺' . $seller_info['user_name']
                    . '缴纳,订单金额为' . $order['goods_amount'] . ',1级佣金比例为' . $tuijian_seller_ratio1
                    . ',推荐关系为:' . $seller_info['user_name'] . '<<--' . $referinfo_1['user_name'],
                )
        );
        /* 第1级 佣金操作  查看卖家是否有推荐人  END */



        /* 第2级 佣金操作  查看卖家是否有推荐人  BEGIN */
        if (!Conf::get('tuijian_seller_ratio2')) {
            return;
        }
        $tuijian_seller_ratio2 = round(Conf::get('tuijian_seller_ratio2') / 100, 2);
        //2级推荐人 不存在卖家的推荐人则返回
        if (!$referinfo_1['referid']) {
            return;
        }
        $referid_2 = $referinfo_1['referid'];
        //查看推荐人是否存在 不存在则不操作
        $referinfo_2 = $this->_member_mod->get($referid_2);
        if (empty($referinfo_2)) {
            return;
        }
        //卖家先扣除佣金
        $this->change_epay(
                array(
                    'user_id' => $seller_id,
                    'add_time'=>$add_time,
                    'user_name' => $seller_info['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => round($order['goods_amount'] * $tuijian_seller_ratio2, 2), #2级推荐人应该获取的佣金
                    'money_flow' => 'outlay', #流出佣金
                    'complete' => '1',
                    'log_text' => '恭喜你缴纳' . round($order['goods_amount'] * $tuijian_seller_ratio2, 2) . '元佣金,佣金被2级店铺推荐者' . $referinfo_2['user_name']
                    . '获得,订单金额为' . $order['goods_amount'] . ',2级佣金比例为' . $tuijian_seller_ratio2
                    . ',推荐关系为:' . $seller_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'],
                )
        );
        //2级推荐人获得佣金
        $this->change_epay(
                array(
                    'user_id' => $referinfo_2['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $referinfo_2['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => round($order['goods_amount'] * $tuijian_seller_ratio2, 2), #2级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' => '恭喜你获得' . round($order['goods_amount'] * $tuijian_seller_ratio2, 2) . '元佣金,佣金由店铺' . $seller_info['user_name']
                    . '缴纳,订单金额为' . $order['goods_amount'] . ',2级佣金比例为' . $tuijian_seller_ratio2
                    . ',推荐关系为:' . $seller_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'],
                )
        );
        /* 第2级 佣金操作  查看卖家是否有推荐人  END */


        /* 第3级 佣金操作  查看卖家是否有推荐人  BEGIN */
        if (!Conf::get('tuijian_seller_ratio3')) {
            return;
        }
        $tuijian_seller_ratio3 = round(Conf::get('tuijian_seller_ratio3') / 100, 2);
        //2级推荐人 不存在卖家的推荐人则返回
        if (!$referinfo_2['referid']) {
            return;
        }
        $referid_3 = $referinfo_2['referid'];
        //查看推荐人是否存在 不存在则不操作
        $referinfo_3 = $this->_member_mod->get($referid_3);
        if (empty($referinfo_3)) {
            return;
        }
        //卖家先扣除佣金
        $this->change_epay(
                array(
                    'user_id' => $seller_id,
                    'add_time'=>$add_time,
                    'user_name' => $seller_info['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => round($order['goods_amount'] * $tuijian_seller_ratio3, 2), #3级推荐人应该获取的佣金
                    'money_flow' => 'outlay', #流出佣金
                    'complete' => '1',
                    'log_text' => '恭喜你缴纳' . round($order['goods_amount'] * $tuijian_seller_ratio3, 2) . '元佣金,佣金被3级店铺推荐者' . $referinfo_3['user_name']
                    . '获得,订单金额为' . $order['goods_amount'] . ',3级佣金比例为' . $tuijian_seller_ratio3
                    . ',推荐关系为:' . $seller_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'] . '<<--' . $referinfo_3['user_name'],
                )
        );
        //3级推荐人获得佣金
        $this->change_epay(
                array(
                    'user_id' => $referinfo_3['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $referinfo_3['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_SELLER,
                    'money' => round($order['goods_amount'] * $tuijian_seller_ratio3, 2), #3级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' => '恭喜你获得' . round($order['goods_amount'] * $tuijian_seller_ratio3, 2) . '元佣金,佣金由店铺' . $seller_info['user_name']
                    . '缴纳,订单金额为' . $order['goods_amount'] . ',3级佣金比例为' . $tuijian_seller_ratio3
                    . ',推荐关系为:' . $seller_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'] . '<<--' . $referinfo_3['user_name'],
                )
        );
        /* 第3级 佣金操作  查看卖家是否有推荐人  END */
    }

    /**
     * 此处是  推荐成为买家， 买家购买产品后，他的推荐者可以获得佣金，佣金来源于卖家
     */
    function tuijian_buyer($order) {
        $add_time = gmtime();
        //判断是否开启 推荐会员成为买家 ， 买家购买产品  推荐者会获取提成，佣金来源于卖家
        if (!Conf::get('tuijian_buyer_status')) {
            return;
        }
        /* 第1级 佣金操作  查看卖家是否有推荐人  BEGIN */
        if (!Conf::get('tuijian_buyer_ratio1')) {
            return;
        }
        $tuijian_buyer_ratio1 = round(Conf::get('tuijian_buyer_ratio1') / 100, 2);

        //卖家相关信息
        $seller_id = $order['seller_id'];
        $seller_info = $this->_member_mod->get($seller_id);

        //买家相关信息
        $buyer_id = $order['buyer_id'];
        $buyer_info = $this->_member_mod->get($buyer_id);


        //1级推荐人 不存在买家的推荐人则返回
        if (!$buyer_info['referid']) {
            return;
        }
        $referid_1 = $buyer_info['referid'];
        //查看推荐人是否存在 不存在则不操作
        $referinfo_1 = $this->_member_mod->get($referid_1);
        if (empty($referinfo_1)) {
            return;
        }
        //卖家先扣除佣金
        $this->change_epay(
                array(
                    'user_id' => $seller_id,
                    'add_time'=>$add_time,
                    'user_name' => $seller_info['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_BUYER,
                    'money' => round($order['goods_amount'] * $tuijian_buyer_ratio1, 2), #一级推荐人应该获取的佣金
                    'money_flow' => 'outlay', #流出佣金
                    'complete' => '1',
                    'log_text' => '恭喜你缴纳' . round($order['goods_amount'] * $tuijian_buyer_ratio1, 2) . '元佣金,佣金被1级买家推荐者' . $referinfo_1['user_name']
                    . '获得,订单金额为' . $order['goods_amount'] . ',1级佣金比例为' . $tuijian_buyer_ratio1
                    . ',推荐关系为:' . $buyer_info['user_name'] . '<<--' . $referinfo_1['user_name'],
                )
        );
        //1级推荐人获得佣金
        $this->change_epay(
                array(
                    'user_id' => $referinfo_1['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $referinfo_1['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_BUYER,
                    'money' => round($order['goods_amount'] * $tuijian_buyer_ratio1, 2), #一级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' => '恭喜你获得' . round($order['goods_amount'] * $tuijian_buyer_ratio1, 2) . '元佣金,佣金由店铺' . $seller_info['user_name']
                    . '缴纳,订单金额为' . $order['goods_amount'] . ',1级佣金比例为' . $tuijian_buyer_ratio1
                    . ',推荐关系为:' . $buyer_info['user_name'] . '<<--' . $referinfo_1['user_name'],
                )
        );
        /* 第1级 佣金操作  查看卖家是否有推荐人  END */



        /* 第2级 佣金操作  查看买家是否有推荐人  BEGIN */
        if (!Conf::get('tuijian_buyer_ratio2')) {
            return;
        }
        $tuijian_buyer_ratio2 = round(Conf::get('tuijian_buyer_ratio2') / 100, 2);
        //2级推荐人 不存在买家的推荐人则返回
        if (!$referinfo_1['referid']) {
            return;
        }
        $referid_2 = $referinfo_1['referid'];
        //查看推荐人是否存在 不存在则不操作
        $referinfo_2 = $this->_member_mod->get($referid_2);
        if (empty($referinfo_2)) {
            return;
        }
        //卖家先扣除佣金
        $this->change_epay(
                array(
                    'user_id' => $seller_id,
                    'add_time'=>$add_time,
                    'user_name' => $seller_info['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_BUYER,
                    'money' => round($order['goods_amount'] * $tuijian_buyer_ratio2, 2), #2级推荐人应该获取的佣金
                    'money_flow' => 'outlay', #流出佣金
                    'complete' => '1',
                    'log_text' => '恭喜你缴纳' . round($order['goods_amount'] * $tuijian_buyer_ratio2, 2) . '元佣金,佣金被2级买家推荐者' . $referinfo_2['user_name']
                    . '获得,订单金额为' . $order['goods_amount'] . ',2级佣金比例为' . $tuijian_buyer_ratio2
                    . ',推荐关系为:' . $buyer_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'],
                )
        );
        //2级推荐人获得佣金
        $this->change_epay(
                array(
                    'user_id' => $referinfo_2['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $referinfo_2['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_BUYER,
                    'money' => round($order['goods_amount'] * $tuijian_buyer_ratio2, 2), #2级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' => '恭喜你获得' . round($order['goods_amount'] * $tuijian_buyer_ratio2, 2) . '元佣金,佣金由店铺' . $seller_info['user_name']
                    . '缴纳,订单金额为' . $order['goods_amount'] . ',2级佣金比例为' . $tuijian_buyer_ratio2
                    . ',推荐关系为:' . $buyer_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'],
                )
        );
        /* 第2级 佣金操作  查看卖家是否有推荐人  END */


        /* 第3级 佣金操作  查看卖家是否有推荐人  BEGIN */
        if (!Conf::get('tuijian_buyer_ratio3')) {
            return;
        }
        $tuijian_buyer_ratio3 = round(Conf::get('tuijian_buyer_ratio3') / 100, 2);
        //2级推荐人 不存在卖家的推荐人则返回
        if (!$referinfo_2['referid']) {
            return;
        }
        $referid_3 = $referinfo_2['referid'];
        //查看推荐人是否存在 不存在则不操作
        $referinfo_3 = $this->_member_mod->get($referid_3);
        if (empty($referinfo_3)) {
            return;
        }
        //卖家先扣除佣金
        $this->change_epay(
                array(
                    'user_id' => $seller_id,
                    'add_time'=>$add_time,
                    'user_name' => $seller_info['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_BUYER,
                    'money' => round($order['goods_amount'] * $tuijian_buyer_ratio3, 2), #3级推荐人应该获取的佣金
                    'money_flow' => 'outlay', #流出佣金
                    'complete' => '1',
                    'log_text' => '恭喜你缴纳' . round($order['goods_amount'] * $tuijian_buyer_ratio3, 2) . '元佣金,佣金被3级买家推荐者' . $referinfo_3['user_name']
                    . '获得,订单金额为' . $order['goods_amount'] . ',3级佣金比例为' . $tuijian_buyer_ratio3
                    . ',推荐关系为:' . $buyer_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'] . '<<--' . $referinfo_3['user_name'],
                )
        );
        //3级推荐人获得佣金
        $this->change_epay(
                array(
                    'user_id' => $referinfo_3['user_id'],
                    'add_time'=>$add_time,
                    'user_name' => $referinfo_3['user_name'],
                    'order_sn' => $order['order_sn'],
                    'type' => EPAY_TUIJIAN_BUYER,
                    'money' => round($order['goods_amount'] * $tuijian_buyer_ratio3, 2), #3级推荐人应该获取的佣金
                    'money_flow' => 'income', #流入佣金
                    'complete' => '1',
                    'log_text' => '恭喜你获得' . round($order['goods_amount'] * $tuijian_buyer_ratio3, 2) . '元佣金,佣金由店铺' . $seller_info['user_name']
                    . '缴纳,订单金额为' . $order['goods_amount'] . ',3级佣金比例为' . $tuijian_buyer_ratio3
                    . ',推荐关系为:' . $buyer_info['user_name'] . '<<--' . $referinfo_1['user_name'] . '<<--' . $referinfo_2['user_name'] . '<<--' . $referinfo_3['user_name'],
                )
        );
        /* 第3级 佣金操作  查看卖家是否有推荐人  END */
    }

    function change_epay($data) {
        //        $user_id,$order_sn,$type,$money,$money_flow,$complete,$log_text
        $epay = $this->_epay_mod->get('user_id=' . $data['user_id']);
        if ($data['money_flow'] == 'income') {
            $new_epay = array(
                'money' => $epay['money'] + $data['money'],
            );
        } else {
            $new_epay = array(
                'money' => $epay['money'] - $data['money'],
            );
        }
        $this->_epay_mod->edit('user_id=' . $data['user_id'], $new_epay);

        $this->_epaylog_mod->add($data);
    }

}
