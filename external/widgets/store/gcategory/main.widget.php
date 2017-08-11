<?php

/**
 * 商品分类挂件
 */
class GcategoryWidget extends Store_baseWidget
{
    var $_name = 'gcategory';
	var $_ttl  = 86400;
	function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$data = array(
				'store_id' => $this->_store_id,
				'store_gcates' => $this->_get_store_gcategory(),
			);
		}
        return $data;
    }
    /* 取得店铺分类 */
    function _get_store_gcategory()
    {
        $gcategory_mod =& bm('gcategory', array('_store_id' => $this->_store_id));
        $gcategories = $gcategory_mod->get_list(-1, true);
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree->getArrayList(0);
    }
}

?>