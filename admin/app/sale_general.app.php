<?php

class Sale_generalApp extends BackendApp
{
	
	function index()
    {

		$conditions = $this->_get_query_conditions(array(array(
                'field' => 'finished_time ',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'finished_time ',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'   => 'gmstr2time_end',
            ),
        ));
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
		    /* 赋值统计数据 */
    	$xml = "<chart caption='' xAxisName='%s' showValues='0' decimals='0' formatNumberScale='0'>%s</chart>";
    	$set = "<set label='%s' value='%s' />";
		$i = 0;
    	$data_count  = '';
    	$data_amount = '';
		foreach ($orders as $key=>$data)
    	{
        	$data_count  .= sprintf($set, $data['period'], $data['order_count'], $this->chart_color($i));
        	$data_amount .= sprintf($set, $data['period'], $data['order_amounts'],$this->chart_color($i));
        	$i++;
    	}
		$this->assign('data_count',  sprintf($xml, '', $data_count)); // 订单数统计数据
    	$this->assign('data_amount', sprintf($xml, '', $data_amount));    // 销售额统计数据
        $this->assign('orders', $orders);
        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
		$model_setting = &af('settings');
        $setting = $model_setting->getAll(); //载入系统设置数据
		$this->assign('setting', $setting);
        $this->display('sale_general.htm');
    }
	function chart_color($n)
	{
    	/* 随机显示颜色代码 */
    	$arr = array('33FF66', 'FF6600', '3399FF', '009966', 'CC3399', 'FFCC33', '6699CC', 'CC3366', '33FF66', 'FF6600', '3399FF');

    	if ($n > 8)
    	{
        	$n = $n % 8;
    	}

		return $arr[$n];
	}
}
?>
