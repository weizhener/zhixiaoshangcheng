<?php

class PromotionApp extends MallbaseApp {

    function index() {
        $promotion_mod = &m('promotion');

        $page = $this->_get_page(20);
        $goods_list = $promotion_mod->find(array(
            'conditions' => 'start_time <=' . gmtime() . ' AND end_time>=' . gmtime(),
            'join' => 'belong_goods',
            'fields' => 'this.*,g.default_image,g.price,g.default_spec,g.goods_name,g.default_spec',
            'limit' => $page['limit'],
            'count' => true,
            'order' => 'pro_id DESC'
        ));
        if ($goods_list) {
            foreach ($goods_list as $key => $goods) {
                $pro_price = $promotion_mod->get_promotion_price($goods['goods_id'], $goods['default_spec']);
                if ($pro_price < $goods['price']) {
                    $goods_list[$key]['pro_price'] = $pro_price;
                } else
                    $goods_list[$key]['pro_price'] = $goods['price'];

                $goods['default_image'] || $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
            }
        }

        $page['item_count'] = $promotion_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        /* 当前位置 */
        $this->_curlocal(array(array('text' => Lang::get('promotion_list'), 'url' => '')));
        /* 取得导航 */
        $this->assign('navs', $this->_get_navs());

        /* 配置seo信息 */
        $this->_config_seo('title', Lang::get('promotion_list') . ' - ' . Conf::get('site_title'));

        $this->assign('goods_list', $goods_list);
        $this->display('promotion.index.html');
    }

}

?>
