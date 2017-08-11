<?php

/**
 * 友情链接挂件
 */
class PartnersWidget extends Store_baseWidget
{
    var $_name = 'partners';
	var $_ttl  = 86400;
	function _get_data()
    {
		$cache_server =& cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if($data === false)
        {
			$data = $this->_get_partners($this->_store_id);
			$cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
    /* 取得友情链接 */
    function _get_partners($id)
    {
        $partner_mod =& m('partner');
        return $partner_mod->find(array(
            'conditions' => "store_id = '$id'",
            'order' => 'sort_order',
        ));
    }
}

?>