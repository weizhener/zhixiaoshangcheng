<?php

/* 运费模板 */
class Delivery_templateModel extends BaseModel
{
    var $table  = 'delivery_template';
    var $prikey = 'template_id';
    var $_name  = 'delivery_template'; 
	
	function format_template($delivery_template,$need_dest_ids=false)
	{
		if(!is_array($delivery_template)){
			return array();
		}
		
		$region_mod = &m('region');
		
		$deliverys = Psmb_init()->Delivery_templateModel_format_template($region_mod, $delivery_template, $need_dest_ids);
		
		return $deliverys;
	}
	
	function format_template_foredit($delivery)
	{
		if(is_array($delivery)){
			$delivery_template = $delivery;
		} else {
			$delivery_template = $this->get($delivery);
		}
		
		$region_mod = &m('region');
		$delivery = Psmb_init()->Delivery_templateModel_format_template_foredit($delivery_template, $region_mod);
		
		$delivery['plus_type'] = $this->get_plus_type($delivery['area_fee']);
		
		return $delivery;
	}
	
	function get_plus_type($area_fee=array())
	{
		$types = array('express','ems','post');
		if(count($area_fee)>0){
			if(isset($area_fee['express'])){
				unset($types[0]);
			}
			if(isset($area_fee['ems'])){
				unset($types[1]);
			}
			if(isset($area_fee['post'])){
				unset($types[2]);
			}
		}
		return $types;
	}
	
	function get_city_logist($delivery,$city_id,$types=null)
	{
		if($types==null){
			$types = array('express','ems','post');
		}
		if($delivery) {
			$logist = $this->get_type_logist($this->format_template_foredit($delivery),$city_id,$types);
		}
		return $logist;
	}
	
	function get_type_logist($logist,$city_id,$types)
	{
		$logist_fee = array();
		
		// 通过运送目的地city_id（城市id）,获取该城市的上级id，即省id，如果 $city_id=0（等于0是在通过淘宝IP数据库无法返回正常的城市名称的前提下出现，当出现该情况时，取默认运费，即设置：province_id=1
		if($city_id)
		{
			$region_mod = &m('region');
			$region = $region_mod->get(array('conditions'=>'region_id='.$city_id,'fields'=>'parent_id'));
			$porovince_id = $region['parent_id'];
		} else {
			$porovince_id = 1;
		}
		
		foreach($types as $type)
		{
			$find = false;
			if(isset($logist['area_fee'][$type])){
				if(isset($logist['area_fee'][$type]['other_fee'])){
					foreach($logist['area_fee'][$type]['other_fee'] as $key=>$val){
						$dest_ids = explode('|',$val['dest_ids']);
						if(in_array($city_id,$dest_ids) || in_array($porovince_id,$dest_ids)){
							$logist_fee[] = array(
								'type'=>$type,
								'name'=>Lang::get($type),
								'start_standards' => $val['start_standards'],
								'start_fees'=> $val['start_fees'],
								'add_standards' => $val['add_standards'],
								'add_fees' => $val['add_fees']
							);
							$find = true;
							break;
						}
					}
					if(!$find){
						$logist_fee[] = array(
							'type'=>$type,
							'name'=>Lang::get($type),
							'start_standards' => $logist['area_fee'][$type]['default_fee']['start_standards'],
							'start_fees'=> $logist['area_fee'][$type]['default_fee']['start_fees'],
							'add_standards' => $logist['area_fee'][$type]['default_fee']['add_standards'],
							'add_fees' => $logist['area_fee'][$type]['default_fee']['add_fees']
							
						);
					}
				} else {
					$logist_fee[] = array(
						'type'=>$type,
						'name'=>Lang::get($type),
						'start_standards' => $logist['area_fee'][$type]['default_fee']['start_standards'],
						'start_fees'=> $logist['area_fee'][$type]['default_fee']['start_fees'],
						'add_standards' => $logist['area_fee'][$type]['default_fee']['add_standards'],
						'add_fees' => $logist['area_fee'][$type]['default_fee']['add_fees']
					);
				}
				
			}
		}
		return $logist_fee;
	}
}

?>