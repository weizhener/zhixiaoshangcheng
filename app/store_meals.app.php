<?php

class Store_mealsApp extends StorebaseApp {

    function index() {
        /* 店铺信息 */
        $_GET['act'] = 'index';
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id) {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->set_store($id);
        $store = $this->get_store_data();
        $this->assign('store', $store);


        /* 当前位置 */
        $this->_curlocal(LANG::get('all_stores'), 'index.php?app=search&amp;act=store', $store['store_name']);

        $this->_config_seo('title', $store['store_name'] . ' - ' . Conf::get('site_title'));
        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info($store));

        $this->_get_waimai_data($id);

        $this->display('store_meals.index.html');
    }

    function _get_waimai_data($store_id) {
        //获取当前店铺的购物车相关信息
        $carts = array();

        /* 获取所有购物车中的内容 */
        $where_store_id = $store_id ? ' AND cart.store_id=' . $store_id : '';

        /* 只有是自己购物车的项目才能购买 */
        $where_user_id = $this->visitor->get('user_id') ? " AND cart.user_id=" . $this->visitor->get('user_id') : '';
        $cart_model = & m('cart');
        $cart_items = $cart_model->find(array(
            'conditions' => 'session_id = \'' . SESS_ID . "'" . $where_store_id . $where_user_id,
            'fields' => 'this.*,store.store_name',
            'join' => 'belongs_to_store',
        ));
        if (!empty($cart_items)) {
            $kinds = array();
            foreach ($cart_items as $item) {
                /* 小计 */
                $item['subtotal'] = $item['price'] * $item['quantity'];
                $kinds[$item['store_id']][$item['goods_id']] = 1;

                /* 以店铺ID为索引 */
                empty($item['goods_image']) && $item['goods_image'] = Conf::get('default_goods_image');
                $carts[$item['store_id']]['store_name'] = $item['store_name'];
                $carts[$item['store_id']]['amount'] += $item['subtotal'];   //各店铺的总金额
                $carts[$item['store_id']]['quantity'] += $item['quantity'];   //各店铺的总数量
                $carts[$item['store_id']]['goods'][$item['spec_id']] = $item;
            }

            foreach ($carts as $_store_id => $cart) {
                $carts[$_store_id]['kinds'] = count(array_keys($kinds[$_store_id]));  //各店铺的商品种类数
            }

            $meals_carts = $carts[$store_id];
            $this->assign('meals_carts', $meals_carts);
        }
        /*END*/
        
        
        
        
        //获取店铺的所有分类
        $gcategory_mod = & bm('gcategory', array('_store_id' => $store_id));
        $goods_mod = & m('goods');
        $gcategories = $gcategory_mod->get_list(-1, true);
        if (!$gcategories) {
            return;
        }
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
        $gcategories = $tree->getArrayList(0);

        $meals_goods = array();
        foreach ($gcategories as $gcategorie_key => $value) {
            //获取分类以及子分类
            $sgcate_ids = $gcategory_mod->get_descendant_ids($value['id']);
            $goods_list = $goods_mod->get_list(array(
                'conditions' => 'closed = 0 AND if_show = 1' . $conditions,
                'order' => 'add_time desc',
                    ), $sgcate_ids);
            foreach ($goods_list as $goods_key => $goods) {
                
                //此处需要通过 规格ID 判断
                if($meals_carts&&array_key_exists($goods['spec_id'], $meals_carts['goods'])){
                    $goods_list[$goods_key]['quantity'] = $meals_carts['goods'][$goods['spec_id']]['quantity'];
                }
                empty($goods['default_image']) && $goods_list[$goods_key]['default_image'] = Conf::get('default_goods_image');
            }
            $meals_goods[$gcategorie_key] = $value;
            $meals_goods[$gcategorie_key]['count'] = count($goods_list);
            $meals_goods[$gcategorie_key]['goods_list'] = $goods_list;
        }
        $this->assign('waimai', $meals_goods);
        
        
        
        
        /*获取当前店铺的买家评价*/
        $order_goods_mod = & m('ordergoods');
        $meals_orders = $order_goods_mod->find(array(
            'conditions' => "seller_id = '$store_id' AND evaluation_status = 1 AND is_valid = 1 " . $conditions,
            'join' => 'belongs_to_order',
            'fields' => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment',
            'order' => 'evaluation_time desc',
            'limit' => 100,
        ));
        $this->assign('meals_orders', $meals_orders);
        
        
    }

    
    
    

    function _get_seo_info($data) {
        $seo_info = $keywords = array();
        $seo_info['title'] = $data['store_name'] . ' - ' . Conf::get('site_title');
        $keywords = array(
            str_replace("\t", ' ', $data['region_name']),
            $data['store_name'],
        );
        //$seo_info['keywords'] = implode(',', array_merge($keywords, $data['tags']));
        $seo_info['keywords'] = implode(',', $keywords);
        $seo_info['description'] = sub_str(strip_tags($data['description']), 10, true);
        return $seo_info;
    }

    

}
