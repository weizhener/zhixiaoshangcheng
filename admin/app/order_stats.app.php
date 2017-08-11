<?php

class Order_statsApp extends BackendApp
{
    /**
     *    @author    tianya
     */
    function index()
    {

        $conditions = $this->_get_query_conditions(array(array(
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
    /* 时间参数 */
    	if (isset($_GET['add_time_from']) && !empty($_GET['add_time_to']))
    	{
        	$start_date = strtotime($_GET['add_time_from']);
       	 	$end_date = strtotime($_GET['add_time_to']);
        	if ($start_date == $end_date)
        	{
				$end_date   =   $start_date + 86400;
        	}
    	}
    	else
    	{
        	$today      = strtotime(date('Y-m-d'));   //本地时间
        	$start_date = $today - 86400 * 30*12;
        	$end_date   = $today + 86400;               //至明天零时
    	}
		$model_order =& m('order');
        $sort  = 'finished_time';
        $order = 'desc';
		$format = '%Y-%m';
		$conditions .=" GROUP BY DATE_FORMAT(FROM_UNIXTIME(finished_time), '".$format."')";
        $orders = $model_order->find(array(
			'fields' => "this.*,SUM(order_amount) as order_amounts,COUNT(*) AS order_count,DATE_FORMAT(FROM_UNIXTIME(finished_time), '".$format."') as period",	
            'conditions'    => "1=1 and status ='".ORDER_FINISHED."'" . $conditions,
            'order'         => "$sort $order",
            'count'         => true             //允许统计
        )); 
		
		
		/* 订单总数 */
		$total_order_num = $model_order->getOne("SELECT COUNT(*)  FROM " . DB_PREFIX . "order where status ='".ORDER_FINISHED."'");
		/* 随机的颜色数组 */
    	$color_array = array('33FF66', 'FF6600', '3399FF', '009966', 'CC3399', 'FFCC33', '6699CC', 'CC3366');
		/* 计算订单各种费用之和 */
    	$total_turnover = $model_order->getOne("SELECT SUM(order_amount) AS total_turnover  FROM " . DB_PREFIX . "order where status ='".ORDER_FINISHED."'");
		
		/* 取得商品总点击数量 */
		$click_count =	$model_order->getOne("SELECT SUM(views) AS total_turnover  FROM " . DB_PREFIX . "goods_statistics ");
		/* 每千个点击的订单数 */
		$click_ordernum =	$click_count > 0 ? round(($total_order_num * 1000)/$click_count,2) : 0;
		/* 每千个点击的购物额 */
		$click_turnover =	$click_count > 0 ? round(($total_turnover * 1000)/$click_count,2) : 0;
		
		/* 订单概况 */
		$order_info = $this->get_orderinfo($start_date, $end_date);
		$order_general_xml = "<graph caption='".Lang::get('order_circs')."' decimalPrecision='2' showPercentageValues='0' showNames='1' showValues='1' showPercentageInLabel='0' pieYScale='45' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='100' outCnvBaseFontSize='13' baseFontSize='12'>";

        $order_general_xml .= "<set value='" .$order_info['confirmed_num']. "' name='" . Lang::get('confirmed') . "' color='".$color_array[5]."' />";

        $order_general_xml .= "<set value='" .$order_info['succeed_num']."' name='" . Lang::get('succeed') . "' color='".$color_array[0]."' />";

        $order_general_xml .= "<set value='" .$order_info['unconfirmed_num']. "' name='" . Lang::get('unconfirmed') . "' color='".$color_array[1]."'  />";

        $order_general_xml .= "<set value='" .$order_info['invalid_num']. "' name='" . Lang::get('invalid') . "' color='".$color_array[4]."' />";
        $order_general_xml .= "</graph>";
		
		/* 支付方式 */
        $pay_xml = "<graph caption='" . Lang::get('payment_name') . "' decimalPrecision='2' showPercentageValues='0' showNames='1' numberPrefix='' showValues='1' showPercentageInLabel='0' pieYScale='45' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='100' outCnvBaseFontSize='13' baseFontSize='12'>";

        $sql = 'SELECT o.payment_id, p.payment_name  AS payment_name, COUNT(o.order_id) AS order_num ' .
           'FROM ' .DB_PREFIX. 'payment AS p, ' .DB_PREFIX. 'order AS o '.
           "WHERE p.payment_id = o.payment_id and o.status ='" . ORDER_FINISHED .
           "' AND o.add_time >= '$start_date' AND o.add_time <= '$end_date' ".
           "GROUP BY o.payment_id  ORDER BY order_num DESC";
        //$pay_res= $db->query($sql);
		$pay_res = $model_order->db->query($sql);
		 while ($pay_item =$model_order->db->FetchRow($pay_res))
        {
            $pay_xml .= "<set value='".$pay_item['order_num']."' name='".$pay_item['payment_name']."' color='".$color_array[mt_rand(0,7)]."'/>";
        }
        $pay_xml .= "</graph>";
		
		/* 配送方式 */
        $ship_xml = "<graph caption='".Lang::get('shipping_name')."' decimalPrecision='2' showPercentageValues='0' showNames='1' numberPrefix='' showValues='1' showPercentageInLabel='0' pieYScale='45' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='100' outCnvBaseFontSize='13' baseFontSize='12'>";

		$tmp = 'SELECT oe.shipping_id, oe.shipping_name AS ship_name, COUNT(o.order_id) AS order_num ' .
               'FROM ' . DB_PREFIX. 'order_extm AS oe, '. DB_PREFIX. 'order AS o '.
               "WHERE oe.order_id = o.order_id  and o.status ='" . ORDER_FINISHED .
               "' AND o.add_time >= '$start_date' AND o.add_time <= '$end_date' " .
               "GROUP BY oe.shipping_id ORDER BY order_num DESC";	
			   	
        $sql = 'SELECT sp.shipping_id, sp.shipping_name AS ship_name, t.order_num ' .
               'FROM ' .DB_PREFIX.'shipping AS sp, (' . $tmp. ') AS t '.
               "WHERE sp.shipping_id = t.shipping_id " . "GROUP BY t.shipping_id ORDER BY t.order_num DESC";	
			   		   
		$ship_res = $model_order->db->query($sql);
		while ($ship_item =$model_order->db->FetchRow($ship_res))
        {
            $ship_xml .= "<set value='".$ship_item['order_num']."' name='".$ship_item['ship_name']."' color='".$color_array[mt_rand(0,7)]."' />";
        }

        $ship_xml .= "</graph>";

    	//$this->assign('order_general',       $order_general);
    	$this->assign('total_turnover',      $total_turnover);		//商品订单总额
    	$this->assign('click_count',         $click_count);         //商品总点击数
    	$this->assign('click_ordernum',      $click_ordernum);      //每千点订单数
    	$this->assign('click_turnover',      $click_turnover);  //每千点购物额
		$this->assign('order_general_xml',   $order_general_xml);
    	$this->assign('ship_xml',            $ship_xml);
    	$this->assign('pay_xml',             $pay_xml);
    	
        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
                                  'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
								  				        $model_setting = &af('settings');
        	$setting = $model_setting->getAll(); //载入系统设置数据
			$this->assign('setting', $setting);
        $this->display('order_stats.htm');
    }
 function get_orderinfo($start_date, $end_date)
 {
    $order_info = array();
	$model_order =& m('order');
    /* 未确认订单数 */
    $order_info['unconfirmed_num'] = $model_order->getOne("SELECT COUNT(*) AS unconfirmed_num  FROM " . DB_PREFIX . "order where status <'".ORDER_ACCEPTED."'"." AND status >'".ORDER_CANCELED."' AND add_time >= '$start_date'"." AND add_time < '" . ($end_date + 86400) . "'");

    /* 已确认订单数 */
    $order_info['confirmed_num'] = $model_order->getOne("SELECT COUNT(*) AS confirmed_num  FROM " . DB_PREFIX . "order where  status >= '".ORDER_ACCEPTED."' AND add_time >= '$start_date'"." AND add_time < '" . ($end_date + 86400) . "'");

    /* 已成交订单数 */
    $order_info['succeed_num'] = $model_order->getOne("SELECT COUNT(*) AS succeed_num  FROM " . DB_PREFIX . "order where  status = '".ORDER_FINISHED."' AND add_time >= '$start_date'"." AND add_time < '" . ($end_date + 86400) . "'");

    /* 无效或已取消订单数 */
    $order_info['invalid_num'] = $model_order->getOne("SELECT COUNT(*) AS invalid_num  FROM " . DB_PREFIX . "order where  status = '".ORDER_CANCELED."' AND add_time >= '$start_date'"." AND add_time < '" . ($end_date + 86400) . "'");
    return $order_info;
 }
 
}
?>
