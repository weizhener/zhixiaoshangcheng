<?php

class LogistApp extends MallbaseApp
{
	var $_store_mod;
	var $_region_mod;
	var $_delivery_mod;

    function __construct()
    {
        $this->LogistApp();
    }
    function LogistApp()
    {
        parent::__construct();
		$this->_store_mod = &m('store');
		$this->_region_mod= &m('region');
		$this->_delivery_mod = &m('delivery_template');
    }
    function index()
    {
		$delivery_template_id = intval($_GET['delivery_template_id']);
		$store_id = intval($_GET['store_id']); // 在deliery_template_id=0 的时候用到
		$city_id  = intval($_GET['city_id']);// 运送目的地ID
		
		// 如果没有设置运费模板，则取该店铺默认的运费模板
		if(!$delivery_template_id)
		{
			$delivery = $this->_delivery_mod->get(array(
				'condtions'=>'store_id='.$store_id,
				'order'=>'template_id',
			));
		} else {
			$delivery = $this->_delivery_mod->get($delivery_template_id);
		}
		
		// 如果是通过IP自动获取省和城市id
		if(empty($city_id)) {
			$city_id = $this->_region_mod->get_city_id_by_ip();
		} 
		else {
			$city_id = intval($_GET['city_id']);
		}
		//print_r($this->_region_mod->get_city_id_by_ip());
		$logist_fee = $this->_delivery_mod->get_city_logist($delivery,$city_id);
		$logist = array(
			'logist_fee' => $logist_fee,
			'city_name'  => $this->_region_mod->get_region_name($city_id), // 获取运送目的地的城市名
		);
		//print_r($logist);

		$this->json_result($logist);
	}
	/*
	function order()
	{
		$store_id = intval($_GET['store_id']);
		$city_id  = intval($_GET['city_id']);
		
		if(!$store_id){
			return;
		}
		$logist_fee = $this->_delivery_mod->get_city_logist($store_id,$city_id);
		//print_r($logist_fee);exit;
		if($logist_fee)
		{
			foreach($logist_fee as $shipping)
			{
				$data['shipping_methods'][] = array(
					'shipping_id'=> $key,
					'store_id'=>$store_id,
					'shipping_name'=> $shipping['name'],
					'shipping_desc'=> '首件：'.$shipping['start_fees'].'元/'.$shipping['start_standards'].'件，续件：'.$shipping['add_fees'].'元/'.$shipping['add_standards'].'件',
					'first_price'=> $shipping['start_fees'],
					'step_price'=> $shipping['add_fees'],
					'cod_regions'=>'',
					'enabled'=>1
				);
			}
		}
		return ecm_json_encode($data['shipping_methods']);
	}
	*/
}

?>
