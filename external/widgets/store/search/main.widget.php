<?php

/**
 * 站内搜索挂件
 */
class SearchWidget extends Store_baseWidget
{
    var $_name = 'search';
	function _get_data()
    {
		return $this->_store_id;
    }
}

?>