<?php

class Ju_floor_mpWidget extends BaseWidget
{
    var $_name = 'ju_floor_mp';
	var $_ttl  = 1800;

    function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {	
			
			$data = $this->options;
			foreach($data as $k => $val)
			{
				$data[$k]['goods'] = $this->get_goods($val['num'],$val['cate_id']);
			}
        	$cache_server->set($key, $data,$this->_ttl);
        }
		//print_r($data);
        return $data;
    }
	
	 function parse_config($input)
    {
        $result = array();
        $num    = isset($input['model_name']) ? count($input['model_name']) : 0;
        if ($num > 0)
        {
            for ($i = 0; $i < $num ; $i++)
            {    
                $result[] = array(
                        'model_name' => $input['model_name'][$i],
                        'num'  => $input['num'][$i],
                        'cate_id' => $input['cate_id'][$i]
               );
            }
        }
        return $result;
    }

	function get_config_datasrc()
    {
        $this->assign('categories', $this->get_category());
    }
	
	function get_category()
	{
		$mod_jucate = &m('jucate');
		$parent_id = $mod_jucate->get(array(
			'conditions' => 'if_show=1 and channel=3',
		));
		$categories = array();
		if($parent_id)
		{
			$categories = $mod_jucate->find(array(
				'conditions' => 'if_show=1 and parent_id='.$parent_id['cate_id'],
			));
		}
		foreach($categories as $cate)
		{
			$data[$cate['cate_id']] = $cate['cate_name'];
		}
		return $data;
	}
	
	function get_goods($num=0,$cate_id=0)
	{
		$mod_ju = &m('ju');
		$mod_jutemplate = &m('jutemplate');
		$tempalte = $mod_jutemplate->get('channel=3 AND state=1');
		$ju_list = array();
		if($tempalte)
		{
			$ju_list = $mod_ju->find(array(
				'join' => 'belong_goods',
				'conditions' => 'ju.template_id='.$tempalte['template_id'].' AND ju.status=1 AND ju.channel=3 AND ju.cate_id='.$cate_id,
				'order' => 'ju.group_id DESC',
				'limit' => $num,
				'fields'=>'this.*,g.goods_id,g.goods_name,g.store_id,g.default_spec,g.price,g.default_image',
			));
			foreach ($ju_list as $key => $ju)
        	{
				$ju_list[$key]['group_price'] = unserialize($ju['spec_price']);
				$ju_list[$key]['group_price'] = $ju_list[$key]['group_price'][$ju['default_spec']]['price'];
				$ju_list[$key]['price_save']  = round($ju['price'] - $ju_list[$key]['group_price'],2);
				$ju_list[$key]['all_count']   = $mod_ju->_get_group_join($ju['group_id']);
				if($ju['price'] > 0){
					$ju_list[$key]['discount'] = round(100-$ju_list[$key]['group_price'] / $ju['price'] * 100,1); 
				} else {
					$ju_list[$key]['discount'] = 0;
				}
				empty($ju['default_image']) && $ju_list[$key]['default_image'] = Conf::get('default_goods_image');	
        	}
		}
		return $ju_list;
	}
}

?>