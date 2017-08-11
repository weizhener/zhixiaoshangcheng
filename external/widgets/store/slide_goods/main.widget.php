<?php

/**
 * 商品列表挂件
 */
class Slide_goodsWidget extends Store_baseWidget
{
    var $_name = 'slide_goods';
	var $_ttl  = 86400;
	function _get_data()
    {
		$amount = !empty($this->options['amount']) ? intval($this->options['amount']) : 10;
		$recom_mod =& bm('recommend', array('_store_id' => $this->_store_id));
        $goods_list = $recom_mod->get_recommended_goods($this->options['img_recom_id'], $amount, true, $this->options['img_cate_id']);
		$data = array(
			'model_id' => mt_rand(),
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