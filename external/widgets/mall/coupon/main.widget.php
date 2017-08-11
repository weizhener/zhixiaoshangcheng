<?php

class couponWidget extends BaseWidget {

    var $_name = 'coupon';
    var $_ttl = 86400;

    function _get_data() {
        $cache_server = & cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if ($data === false) {
            $coupon_mod =& m('coupon');
            $coupons = $coupon_mod->find(array(
                'fields' => 'coupon.*,s.store_name',
                'conditions' => 'if_issue = 1 AND coupon.end_time > ' . gmtime(),
                'order' => 'add_time desc',
                'join' => 'belong_to_store',
                'limit' => 5,
            ));
        foreach ($coupons as $key => $coupon) {
            if(empty($coupon['coupon_bg'])){
                $coupons[$key]['coupon_bg'] = Conf::get('default_coupon_image');
            }
        }
            $data = array(
                'coupons'=>$coupons,
            );

            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }

    function get_config_datasrc() {
        // 取得多级文章分类，去除系统文章
        $this->assign('forum_categorys', $this->_get_forum_category_options(2));
    }

    function parse_config($input) {
        return $input;
    }

}

?>