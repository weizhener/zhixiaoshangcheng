<?php

class jd2015_floor5Widget extends BaseWidget {

    var $_name = 'jd2015_floor5';
    var $_ttl = 86400;
    var $_num = 6;

    function _get_data() {
        $recom_mod = & m('recommend');
        $data = array(
            'model_id' => mt_rand(),
            'model_name' => $this->options['model_name'],
            'goods_list_1' => $recom_mod->get_recommended_goods($this->options['img_recom_id_1'], $this->_num, true, $this->options['img_cate_id_1']),
        );
        return $data;
    }

    function get_config_datasrc() {
        // 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options());
    }

}

?>