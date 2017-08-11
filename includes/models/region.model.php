<?php

/* 地区 region */

class RegionModel extends BaseModel {

    var $table = 'region';
    var $prikey = 'region_id';
    var $_name = 'region';
    var $_relation = array(
        // 一个地区有多个子地区
        'has_region' => array(
            'model' => 'region',
            'type' => HAS_MANY,
            'foreign_key' => 'parent_id',
            'dependent' => true
        ),
    );
    var $_autov = array(
        'region_name' => array(
            'required' => true,
            'filter' => 'trim',
        ),
        'sort_order' => array(
            'filter' => 'intval',
        ),
    );

    /**
     * 取得地区列表
     *
     * @param int $parent_id 大于等于0表示取某个地区的下级地区，小于0表示取所有地区
     * @return array
     */
    function get_list($parent_id = -1) {
        if ($parent_id >= 0) {
            return $this->find(array(
                        'conditions' => "parent_id = '$parent_id'",
                        'order' => 'sort_order, region_id',
            ));
        } else {
            return $this->find(array(
                        'order' => 'sort_order, region_id',
            ));
        }
    }
	
	function get_region_name($region_id,$full=false)
	{
		if($region_id==1 || $region_id==0){
			return '全国';
		}
		$str = '';
		
		$region_ids = explode('|', $region_id);
		foreach($region_ids as $region_id)
		{
			$region = $this->get(array('conditions'=>'region_id='.$region_id,'fields'=>'region_name,region_id,parent_id'));
			
			if($full===false)
			{
				$str .=','. $region['region_name'];
			} 
			else 
			{
				//while(isset($region['parent_id']) && $region['parent_id']>=0)
				while($region['parent_id'] != 0)
				{
					$parent_id = $region['parent_id'];
					$str = $region['region_name'] . $str;
					$region = $this->get(array('conditions'=>'region_id='.$parent_id,'fields'=>'region_name,region_id,parent_id'));
				}
				$str = ',' . $str;
			}
		}
		return substr($str,1);
	}

	function get_province_city()
	{
		$regions = $this->get_options(0);
		if(count($regions)>0)
		{
			foreach($regions as $key=>$val){
				$area = $this->get_list($key); // 省
			}
		}
		if(count($area)>0){
			foreach($area as $k=>$v){
				$cities = $this->get_list($k);
				$area[$k]['cities'] = $cities;
			}
		}
		return $area;
	}
	
	// 通过IP自动获取城市id
	function get_city_id_by_ip()
	{
		$find = false; // 淘宝IP数据库查找出来的省份和城市名称是否能与ECMall里面的地区名称正确匹配，true=能正确匹配
		//$ip = '116.255.143.70';
		$ip = real_ip();  // test 116.255.143.70 '171.36.178.203';
		$address = $this->get_address_from_ip($ip);
		$address = json_decode($address,true);

		if($data['code']==0) // 通过淘宝IP数据库查找所在城市正确返回了数据
		{
			$taobao_province_name = $address['data']['region'];
			$taobao_city_name = $address['data']['city'];
			
			// 先查出地区第一级的 region_id 等于多少（因为ecmall的地区结构是：中国 为第一级）
			$region = $this->get(array('conditions'=>'parent_id=0','fields'=>'region_id'));
			$parent_id = $region['region_id'];
				
			// （不完善，未考虑特殊情况，如果遇到特殊情况，需要设置ECMall的地区，使名称跟淘宝的一致）简单处理广东省!=广东的情况，淘宝的省份一般加上"省"的
			$conditions = "region_name='".$taobao_province_name."' OR region_name='".str_replace('省','',$taobao_province_name)."' and parent_id=".$parent_id;

			$region = $this->get(array('conditions'=>$conditions,'fields'=>'region_id,region_name'));
			if($region)
			{
				$province_id = $region['region_id'];
					
				//（不完善，如果遇到特殊情况，需要修改ECMall的地区，使名称跟淘宝的一致）简单处理广州市!=广州的情况，淘宝的市一般加上"市"
				$conditions = "region_name='".$taobao_city_name."' OR region_name='".str_replace('市','',$taobao_city_name)."' and parent_id=".$province_id;

				$region_city = $this->get(array('conditions'=>$conditions,'fields'=>'region_id,region_name'));
				if($region_city) {	
					$city_id = $region_city['region_id'];
					$find = true; //只有省份和城市名称正确匹配的时候，才返回true
				}
			}
		}
			
		if(!$find) // 如果当前IP无法在淘宝数据库中正确返回省和城市信息，则加载默认运费（全国）
		{
			$city_id = 0; // 注：最好不要设置为1，该情况会认为是读取默认邮费（全国）
		}
		return $city_id;
	}
	
	/* 使用淘宝的IP库
	 * http://ip.taobao.com
	*/
	function get_address_from_ip($ip)
	{
		if(empty($ip)){
			return;
		}
		$url = 'http://ip.taobao.com/service/getIpInfo.php?ip='.$ip;
		$address = file_get_contents($url);
		return $address;
	}
	
	// end 

	

    /*
     * 判断名称是否唯一
     */

    function unique($region_name, $parent_id, $region_id = 0) {
        $conditions = "parent_id = '" . $parent_id . "' AND region_name = '" . $region_name . "'";
        $region_id && $conditions .= " AND region_id <> '" . $region_id . "'";
        return count($this->find(array('conditions' => $conditions))) == 0;
    }

    /**
     * 取得options，用于下拉列表
     */
    function get_options($parent_id = 0) {
        $res = array();
        $regions = $this->get_list($parent_id);
        foreach ($regions as $region) {
            $res[$region['region_id']] = $region['region_name'];
        }
        return $res;
    }

    /**
     * 取得某地区的所有子孙地区id
     */
    function get_descendant($id) {
        $ids = array($id);
        $ids_total = array();
        $this->_get_descendant($ids, $ids_total);
        return array_unique($ids_total);
    }

    /**
     * 取得某地区的所有父级地区
     *
     * @author Garbin
     * @param  int $region_id
     * @return void
     * */
    function get_parents($region_id) {
        $parents = array();
        $region = $this->get($region_id);
        if (!empty($region)) {
            if ($region['parent_id']) {
                $tmp = $this->get_parents($region['parent_id']);
                $parents = array_merge($parents, $tmp);
                $parents[] = $region['parent_id'];
            }
            $parents[] = $region_id;
        }

        return array_unique($parents);
    }

    function _get_descendant($ids, &$ids_total) {
        $childs = $this->find(array(
            'fields' => 'region_id',
            'conditions' => "parent_id " . db_create_in($ids)
        ));
        $ids_total = array_merge($ids_total, $ids);
        $ids = array();
        foreach ($childs as $child) {
            $ids[] = $child['region_id'];
        }
        if (empty($ids)) {
            return;
        }
        $this->_get_descendant($ids, $ids_total);
    }

}

?>
