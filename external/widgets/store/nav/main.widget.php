<?php

class NavWidget extends Store_baseWidget
{
    var $_name = 'nav';

    function _get_data()
    {
        return array(
			'store_id' => $this->_store_id,
            'color'  => $this->options['color'],
			'navs'     => $this->options['navs'],
        );
    }

    function parse_config($input)
    {
        $result = array();
        $num    = isset($input['link']) ? count($input['link']) : 0;
        if ($num > 0)
        {
            for ($i = 0; $i < $num; $i++)
            {
                    $result[] = array(
                        'title' => $input['title'][$i],
                        'link'  => $input['link'][$i]
                    );
            }
        }
		$input['navs'] = $result;
        return $input;
    }
}

?>