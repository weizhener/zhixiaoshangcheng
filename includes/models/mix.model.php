<?php

/* 自由搭配 mix */
class mixModel extends BaseModel
{
    var $table  = 'mix';
    var $prikey = 'mix_id';
    var $_name  = 'mix';

    var $_relation = array(
        // 一个自由搭配只能属于一个店铺
        'belongs_to_store' => array(
            'model'         => 'store',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'store_id',
            'reverse'       => 'has_mix',
        ),
        // 自由搭配和商品是多对多的关系
        'mix_goods' => array(
            'model'         => 'goods',
            'type'          => HAS_AND_BELONGS_TO_MANY,
            'middle_table'  => 'mix_goods',
            'foreign_key'   => 'mix_id',
            'reverse'       => 'be_mix',
        ),
    );

    var $_autov = array(
        'mix_name' => array(
            'required'  => true,
            'filter'    => 'trim',
        ),
    );
	
    /**
     * 取得商品自由搭配
     *
     * @param array $params     这个参数跟find函数的参数相同
     * @param int   $scate_ids  店铺商品分类id
     * @return array
     */
    function get_list($params = array(), $scate_ids = array())
    {
        is_int($scate_ids) && $scate_ids > 0 && $scate_ids = array($scate_ids);

        extract($this->_initFindParams($params));

        $store_mod =& m('store');
		$goods_mod =& m('goods');
		
        $fields = "g.goods_id, g.store_id, g.goods_name, g.default_image" .
                ", s.store_name" ;
        $tables = "{$this->table} m " .
                "LEFT JOIN {$store_mod->table} s ON s.store_id = m.store_id " .
                "LEFT JOIN {$goods_mod->table} g ON g.goods_id = m.nav_goods_id ";

        /* 条件(WHERE) */
        $conditions = $this->_getConditions($conditions, true);
        $conditions .= " AND g.goods_id IS NOT NULL AND s.store_id IS NOT NULL ";

        /* 排序(ORDER BY) */
        if ($order)
        {
            $order = ' ORDER BY ' . $this->getRealFields($order) . ', m.mix_id ';
        }


        /* 完整的SQL */
        $this->temp = $tables . $conditions;
        $sql = "SELECT {$fields} FROM {$tables}{$conditions}{$order}{$limit}";

        $mix_list = $index_key ? $this->db->getAllWithIndex($sql, $index_key) : $this->db->getAll($sql);

        return $mix_list;
    }
    /**
     * 取得某自由搭配的信息
     * @param   int     $mix_id       自由搭配
     * @param   bool    $mix_info  返回的信息
     */	
	function get_info($mix_id)
	{
        $mix_info = $this->get(array(
            'conditions' => "mix_id = '$mix_id'",
            'join'       => 'belongs_to_store',
            'fields'     => 'this.*, store.store_name'
        ));
		$goods_mod =& m('goods');
		$goods_info = $goods_mod->get($mix_info['nav_goods_id']);
        if($goods_info)
        {
			$mix_info['goods_info'] = $goods_info;
		}
		return $mix_info;
	}
    /**
     * 取得某自由搭配下商品
     * @param   int     $mix_id       自由搭配
     * @param   int     $num            取商品数量
     * @param   bool    $default_image  如果商品没有图片，是否取默认图片
     */
    function get_mix_goods($mix_id, $num, $default_image = true)
    {
        $goods_list = array();

        $conditions = "g.if_show = 1 AND g.closed = 0 AND s.state = 1 ";

		/* 自由搭配商品 */
		$sql = "SELECT g.goods_id, g.goods_name, g.default_image, gs.price, gs.stock " .
				"FROM " . DB_PREFIX . "mix_goods AS mg " .
				"   LEFT JOIN " . DB_PREFIX . "goods AS g ON mg.goods_id = g.goods_id " .
				"   LEFT JOIN " . DB_PREFIX . "goods_spec AS gs ON g.default_spec = gs.spec_id " .
				"   LEFT JOIN " . DB_PREFIX . "store AS s ON g.store_id = s.store_id " .
				"WHERE " . $conditions . 
				"AND mg.mix_id = '$mix_id' " .
				"AND g.goods_id IS NOT NULL " .
				"ORDER BY mg.sort_order " .
				"LIMIT {$num}";

        $res = $this->db->query($sql);
        while ($row = $this->db->fetchRow($res))
        {
            $default_image && empty($row['default_image']) && $row['default_image'] = Conf::get('default_goods_image');
            $goods_list[] = $row;
        }

        return $goods_list;
    }
}

class mixBModel extends mixModel
{
    var $_store_id = 0;

    /*
     * 判断名称是否唯一
     */
    function unique($mix_name, $mix_id = 0)
    {
        $conditions = "mix_name = '$mix_name'";
        $mix_id && $conditions .= " AND mix_id <> '" . $mix_id . "'";

        return count($this->find(array('conditions' => $conditions))) == 0;
    }

    /* 覆盖基类方法 */
    function add($data, $compatible = false)
    {
        $data['store_id'] = $this->_store_id;

        return parent::add($data, $compatible);
    }

    /* 覆盖基类方法 */
    function _getConditions($conditions, $if_add_alias = false)
    {
        $alias = '';
        if ($if_add_alias)
        {
            $alias = $this->alias . '.';
        }
        $res = parent::_getConditions($conditions, $if_add_alias);
        return $res ? $res . " AND {$alias}store_id = '{$this->_store_id}'" : " WHERE {$alias}store_id = '{$this->_store_id}'";
    }

    function get_options()
    {
        $options = array();
        $mixs = $this->find();
        foreach ($mixs as $mix)
        {
            $options[$mix['mix_id']] = $mix['mix_name'];
        }

        return $options;
    }

    /**
     * 统计各自由搭配下商品数
     *
     * @return array(mix_id => count)
     */
    function count_goods()
    {
        $count = array();
        $sql = "SELECT mg.mix_id, COUNT(*) AS goods_count " .
                "FROM " . DB_PREFIX . "mix_goods AS mg " .
                "   LEFT JOIN {$this->table} AS m ON mg.mix_id = m.mix_id " .
                "   LEFT JOIN " . DB_PREFIX . "goods AS g ON mg.goods_id = g.goods_id " .
                "WHERE m.store_id = '{$this->_store_id}' " .
                "AND g.goods_id IS NOT NULL " .
                "GROUP BY mg.mix_id";
        $res = $this->db->query($sql);
        while ($row = $this->db->fetchRow($res))
        {
            $count[$row['mix_id']] = $row['goods_count'];
        }

        return $count;
    }
}

?>