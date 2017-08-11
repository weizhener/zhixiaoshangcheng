<?php

/* 促销活动（打折减价） */

class PromotionModel extends BaseModel {

    var $table = 'promotion';
    var $alias = 'pro';
    var $prikey = 'pro_id';
    var $_name = 'promotion';
    var $_relation = array(
        // 一个促销活动属于一个商品
        'belong_goods' => array(
            'model' => 'goods',
            'type' => BELONGS_TO,
            'foreign_key' => 'goods_id',
            'reverse' => 'has_promotion',
        ),
        // 一个促销只能属于一个店铺
        'belongs_to_store' => array(
            'model' => 'store',
            'type' => BELONGS_TO,
            'foreign_key' => 'store_id',
            'reverse' => 'has_promotion',
        ),
    );

    function goods_has_promotion($goods_id = 0) {
        $result = false;

        if (!$goods_id)
            $result = false;

        $promotion = $this->find(array(
            'conditions' => "start_time<=" . gmtime() . " AND end_time>=" . gmtime() . " AND goods_id=" . $goods_id,
            'fields' => 'pro_id',
        ));
        if (empty($promotion)) {
            $result = false;
        }
        else
            $result = true;

        return $result;
    }

    function get_promotion_price($goods_id, $spec_id) {
        if (!$goods_id || !$spec_id)
            return 0;

        $spec_mod = &m('goodsspec');
        $spec = $spec_mod->get(array('conditions' => 'goods_id=' . $goods_id . ' AND spec_id=' . $spec_id, 'fields' => 'price'));

        $price = $old_price = $spec['price'];

        $promotion = parent::get(array(
                    'conditions' => "start_time<=" . gmtime() . " AND end_time>=" . gmtime() . " AND goods_id=" . $goods_id,
                    'fields' => 'spec_price'
        ));
        if (!empty($promotion)) {
            $spec_price = unserialize($promotion['spec_price']);

            if ($spec_price[$spec_id]['is_pro'] == 1) {
                if ($spec_price[$spec_id]['pro_type'] == 'price') {
                    $pro_price = round($old_price - $spec_price[$spec_id]['price'], 2);
                    if ($pro_price > 0) {
                        $price = $pro_price;
                    }
                }
                else
                    $price = round($old_price * $spec_price[$spec_id]['price'] / 1000, 4) * 100;
            }
        }
        return $price;
    }

}

?>
