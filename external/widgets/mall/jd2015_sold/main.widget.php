<?php

/**
 * 文章挂件
 *
 * @return  array
 */
class jd2015_soldWidget extends BaseWidget {

    var $_name = 'jd2015_sold';
    var $_ttl = 1;

    function _get_data() {
        if (empty($this->options['num']) || intval($this->options['num']) <= 0) {
            $this->options['num'] = 20;
        }

        $cache_server = & cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if ($data === false) {
            $order_goods_mod = & m('ordergoods');
            $goods_list = $order_goods_mod->find(array(
                'conditions' => "comment is not null and status = '" . ORDER_FINISHED . "' and is_drop = ''",
                'order' => 'finished_time desc',
                'join' => 'belongs_to_order',
                'limit' => $this->options['num'],
            ));
            foreach ($goods_list as $key => $goods) {
                empty($goods['goods_image']) && $goods_list[$key]['goods_image'] = Conf::get('default_goods_image');
            }
            
            $data = array(
                'model_id' => mt_rand(),
                'goods_list'=>$goods_list,
            );
            
            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }

}

?>