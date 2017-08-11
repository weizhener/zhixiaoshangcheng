<?php

define('REC_NEW', -100); // 新品推荐

/* 推荐类型 recommend */

class RecommendModel extends BaseModel {

    var $table = 'recommend';
    var $prikey = 'recom_id';
    var $_name = 'recommend';
    var $_relation = array(
        // todo 一个推荐类型只能属于一个店铺
        // 推荐类型和商品是多对多的关系
        'recommend_goods' => array(
            'model' => 'goods',
            'type' => HAS_AND_BELONGS_TO_MANY,
            'middle_table' => 'recommended_goods',
            'foreign_key' => 'recom_id',
            'reverse' => 'be_recommend',
        ),
    );
    var $_autov = array(
        'recom_name' => array(
            'required' => true,
            'filter' => 'trim',
        ),
    );

    /**
     * 取得某推荐下商品
     * @param   int     $recom_id       推荐类型
     * @param   int     $num            取商品数量
     * @param   bool    $default_image  如果商品没有图片，是否取默认图片
     * @param   int     $mall_cate_id   分类（最新商品用到）
     */
    function get_recommended_goods($recom_id, $num, $default_image = true, $mall_cate_id = 0, $timeslot = array(), $sort_by = '') {
        $goods_list = array();
        $order = '';

        $conditions = "g.if_show = 1 AND g.closed = 0 AND s.state = 1 ";

        //  加了时间段
        if (count($timeslot) > 0) {
            $conditions .= "AND g.add_time >='" . $timeslot['begin'] . "' and g.add_time <='" . $timeslot['end'] . "'";
        }

        if ($recom_id == REC_NEW) {
            if (empty($sort_by)) {
                $order = ' g.add_time DESC ';
            } elseif (in_array($sort_by, array('views', 'collects', 'comments', 'sales'))) {
                $order = ' goodsstatistics.' . $sort_by . ' DESC,g.add_time DESC ';
            } elseif ($sort_by == 'add_time') {
                $order = ' g.add_time DESC ';
            }

            /* 最新商品 */
            if ($mall_cate_id > 0) {
                $gcategory_mod = & m('gcategory');
                $conditions .= " AND g.cate_id " . db_create_in($gcategory_mod->get_descendant($mall_cate_id));
            }
            $sql = "SELECT g.goods_id, g.goods_name, g.default_image, g.virtual_seles, gs.price, gs.stock,goodsstatistics.sales,s.store_id,s.store_name " .
                    "FROM " . DB_PREFIX . "goods AS g " .
                    "LEFT JOIN " . DB_PREFIX . "goods_spec AS gs ON g.default_spec = gs.spec_id " .
                    "LEFT JOIN " . DB_PREFIX . "store AS s ON g.store_id = s.store_id " .
                    "LEFT JOIN " . DB_PREFIX . "goods_statistics AS goodsstatistics ON goodsstatistics.goods_id=g.goods_id " .
                    "WHERE " . $conditions .
                    "ORDER BY  " . $order .
                    "LIMIT {$num}";
        } else {
            if (empty($sort_by)) {
                $order = ' rg.sort_order ';
            } elseif (in_array($sort_by, array('views', 'collects', 'comments', 'sales'))) {
                $order = ' goodsstatistics.' . $sort_by . ' DESC,rg.sort_order ';
            } elseif ($sort_by == 'add_time') {
                $order = ' g.add_time DESC ';
            }

            /* 推荐商品 */
            $sql = "SELECT g.goods_id, g.goods_name, g.default_image, g.virtual_seles, gs.price, gs.stock,goodsstatistics.sales,s.store_id,s.store_name " .
                    "FROM " . DB_PREFIX . "recommended_goods AS rg " .
                    "   LEFT JOIN " . DB_PREFIX . "goods AS g ON rg.goods_id = g.goods_id " .
                    "   LEFT JOIN " . DB_PREFIX . "goods_spec AS gs ON g.default_spec = gs.spec_id " .
                    "   LEFT JOIN " . DB_PREFIX . "store AS s ON g.store_id = s.store_id " .
                    "	LEFT JOIN " . DB_PREFIX . "goods_statistics AS goodsstatistics ON goodsstatistics.goods_id=g.goods_id " .
                    "WHERE " . $conditions .
                    "AND rg.recom_id = '$recom_id' " .
                    "AND g.goods_id IS NOT NULL " .
                    "ORDER BY  " . $order .
                    "LIMIT {$num}";
        }
        $res = $this->db->query($sql);
        $promotion_mod = &m('promotion');
        while ($row = $this->db->fetchRow($res)) {
            $default_image && empty($row['default_image']) && $row['default_image'] = Conf::get('default_goods_image');
			$row['sales'] = $row['sales'] + $row['virtual_seles'];
			
            /* 读取促销价格 */
            $promotion_price = $promotion_mod->get_promotion_price($row['goods_id'], $row['spec_id']);
            if($promotion_price){
                $row['price'] = $promotion_price;
            }
            
            $goods_list[] = $row;
        }

        return $goods_list;
    }

}

class RecommendBModel extends RecommendModel {

    var $_store_id = 0;

    /*
     * 判断名称是否唯一
     */

    function unique($recom_name, $recom_id = 0) {
        $conditions = "recom_name = '$recom_name'";
        $recom_id && $conditions .= " AND recom_id <> '" . $recom_id . "'";

        return count($this->find(array('conditions' => $conditions))) == 0;
    }

    /* 覆盖基类方法 */

    function add($data, $compatible = false) {
        $data['store_id'] = $this->_store_id;

        return parent::add($data, $compatible);
    }

    /* 覆盖基类方法 */

    function _getConditions($conditions, $if_add_alias = false) {
        $alias = '';
        if ($if_add_alias) {
            $alias = $this->alias . '.';
        }
        $res = parent::_getConditions($conditions, $if_add_alias);
        return $res ? $res . " AND {$alias}store_id = '{$this->_store_id}'" : " WHERE {$alias}store_id = '{$this->_store_id}'";
    }

    function get_options() {
        $options = array();
        $recommends = $this->find();
        foreach ($recommends as $recommend) {
            $options[$recommend['recom_id']] = $recommend['recom_name'];
        }

        return $options;
    }

    /**
     * 统计各推荐下商品数
     *
     * @return array(recom_id => count)
     */
    function count_goods() {
        $count = array();
        $sql = "SELECT rg.recom_id, COUNT(*) AS goods_count " .
                "FROM " . DB_PREFIX . "recommended_goods AS rg " .
                "   LEFT JOIN {$this->table} AS r ON rg.recom_id = r.recom_id " .
                "   LEFT JOIN " . DB_PREFIX . "goods AS g ON rg.goods_id = g.goods_id " .
                "WHERE r.store_id = '{$this->_store_id}' " .
                "AND g.goods_id IS NOT NULL " .
                "GROUP BY rg.recom_id";
        $res = $this->db->query($sql);
        while ($row = $this->db->fetchRow($res)) {
            $count[$row['recom_id']] = $row['goods_count'];
        }

        return $count;
    }

    /**
     * 取得某推荐下商品
     * @param   int     $recom_id       推荐类型
     * @param   int     $num            取商品数量
     * @param   bool    $default_image  如果商品没有图片，是否取默认图片
     * @param   int     $mall_cate_id   分类（最新商品用到）
     */
    function get_recommended_goods($recom_id, $num, $default_image = true, $mall_cate_id = 0) {
        $goods_list = array();
        $left_join = '';
        $conditions = "g.if_show = 1 AND g.closed = 0 AND s.state = 1 AND g.store_id = '" . $this->_store_id . "'";
        if ($recom_id == REC_NEW) {
            /* 最新商品 */
            if ($mall_cate_id > 0) {
                $gcategory_mod = & m('gcategory');
                $conditions .= " AND cg.cate_id " . db_create_in($gcategory_mod->get_descendant($mall_cate_id)) . " GROUP BY cg.goods_id ";
                $left_join = "LEFT JOIN " . DB_PREFIX . "category_goods AS cg ON cg.goods_id = g.goods_id ";
            }
            $sql = "SELECT g.goods_id,g.cate_id,g.cate_name,g.goods_name,g.tags,g.brand, g.default_image, g.virtual_seles, gs.price, gs.stock,goodsstatistics.sales,goodsstatistics.comments,goodsstatistics.collects,s.store_id,s.im_qq,s.im_ww,s.store_name " .
                    "FROM " . DB_PREFIX . "goods AS g " .
                    "LEFT JOIN " . DB_PREFIX . "goods_spec AS gs ON g.default_spec = gs.spec_id " .
                    "LEFT JOIN " . DB_PREFIX . "store AS s ON g.store_id = s.store_id " .
                    "LEFT JOIN " . DB_PREFIX . "goods_statistics AS goodsstatistics ON goodsstatistics.goods_id=g.goods_id " .
                    $left_join .
                    "WHERE " . $conditions .
                    "ORDER BY g.add_time DESC " .
                    "LIMIT {$num}";
        } else {
            /* 推荐商品 */
            $sql = "SELECT g.goods_id,g.cate_id,g.cate_name,g.goods_name,g.tags,g.virtual_seles,g.brand, g.default_image, gs.price, gs.stock,goodsstatistics.sales,goodsstatistics.comments,s.store_id,s.im_qq,s.im_ww,s.store_name " .
                    "FROM " . DB_PREFIX . "recommended_goods AS rg " .
                    "   LEFT JOIN " . DB_PREFIX . "goods AS g ON rg.goods_id = g.goods_id " .
                    "   LEFT JOIN " . DB_PREFIX . "goods_spec AS gs ON g.default_spec = gs.spec_id " .
                    "   LEFT JOIN " . DB_PREFIX . "store AS s ON g.store_id = s.store_id " .
                    "   LEFT JOIN " . DB_PREFIX . "goods_statistics AS goodsstatistics ON goodsstatistics.goods_id=g.goods_id " .
                    "WHERE " . $conditions .
                    "AND rg.recom_id = '$recom_id' " .
                    "AND g.goods_id IS NOT NULL " .
                    "ORDER BY rg.sort_order " .
                    "LIMIT {$num}";
        }
        $res = $this->db->query($sql);
        $promotion_mod = &m('promotion');
        while ($row = $this->db->fetchRow($res)) {
            $default_image && empty($row['default_image']) && $row['default_image'] = Conf::get('default_goods_image');
            /* 读取促销价格 */
            $promotion_price = $promotion_mod->get_promotion_price($row['goods_id'], $row['spec_id']);
            if($promotion_price){
                $row['price'] = $promotion_price;
            }
            $goods_list[] = $row;
        }

        return $goods_list;
    }

}

?>