<?php

/**
 * 商品列表挂件
 */
class Hot_salesWidget extends Store_baseWidget
{
    var $_name = 'hot_sales';
	var $_ttl  = 86400;
	function _get_data()
    {
		$amount = !empty($this->options['amount']) ? intval($this->options['amount']) : 9;
		$recom_mod =& bm('recommend', array('_store_id' => $this->_store_id));
        $goods_list = $recom_mod->get_recommended_goods($this->options['img_recom_id'], $amount, true, $this->options['img_cate_id']);
		$data = array(
			'model_name' => $this->options['model_name'],
			'link'  => $this->options['link'],
			'model_color'=>$this->options['model_color']?$this->options['model_color']:'#FFAA89',
			'goods_list' => $goods_list,
		);
        return $data;
    }
	
	function get_config_datasrc()
    {
		// 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());
		
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options(1));
    }
	function parse_config($input)
    {
        return $input;
    }    
}

?>