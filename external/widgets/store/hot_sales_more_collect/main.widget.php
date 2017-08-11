<?php

/**
 * 站内搜索挂件
 */
class Hot_sales_more_collectWidget extends Store_baseWidget
{
    var $_name = 'hot_sales_more_collect';
	function _get_data()
    {
		return array('hot_saleslist'=>$this->_get_hot_saleslist(),'collect_goods'=>$this->_get_collect_goods());
    }
	function _get_hot_saleslist()
	{
	   if (!$this->_store_id)
	   {
	      return array();
	   }
	   $goods_mod =& m('goods');
       $data = $goods_mod->find(array(
           'conditions' => "if_show = 1 AND store_id = '{$this->_store_id}' AND closed = 0 ",
           'order' => 'sales DESC',
           'fields' => 'g.goods_id, g.goods_name,goods.default_image,g.price,goods_statistics.sales',
           'join' => 'has_goodsstatistics',
           'limit' => 10,
       ));
	   return $data;
	}
	function _get_collect_goods()
	{
        $goods_mod =& m('goods');
        $data = $goods_mod->find(array(
            'conditions' => "if_show = 1 AND store_id = '{$this->_store_id}' AND closed = 0 ",
            'order' => 'collects DESC',
			'fields' => 'g.goods_id, g.goods_name,g.default_image,g.price,goods_statistics.collects',
			'join'  => 'has_goodsstatistics',
            'limit' => 10,
        ));
		return $data;
	}
}

?>