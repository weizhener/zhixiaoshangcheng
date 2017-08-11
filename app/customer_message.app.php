<?php

class customer_messageApp extends MallbaseApp {

    /**
     * 添加
     */
    function index() {

//        $type_list = array(
//            CUSTOMER_MESSAGE_SUGGESTION =>Lang::get('customer_message_suggestion'), #客户网站建议投诉
//            CUSTOMER_MESSAGE_STORE=>Lang::get('customer_message_store'),#客户投诉卖家
//            CUSTOMER_MESSAGE_GOODS=>Lang::get('customer_message_goods'),#客户投诉产品
//        );


        if (in_array(intval($_GET['type']), array(CUSTOMER_MESSAGE_SUGGESTION, CUSTOMER_MESSAGE_STORE, CUSTOMER_MESSAGE_GOODS))) {
            $type = intval($_GET['type']);
        } else {
            $this->show_warning('error_0');
            return;
        }


        //当为 投诉店铺时
        if ($type == CUSTOMER_MESSAGE_STORE) {
            $store_id = intval($_GET['store_id']);
            if (empty($store_id)) {
                $this->show_warning('error_1');
                return;
            }
            $store_mod = & m('store');
            $store = $store_mod->get($store_id);
            if (empty($store)) {
                $this->show_warning('error_1');
                return;
            }
        }

        //当投诉商品时
        if ($type == CUSTOMER_MESSAGE_GOODS) {
            $goods_id = intval($_GET['goods_id']);
            if (empty($goods_id)) {
                $this->show_warning('error_2');
                return;
            }
            $goods_mod = &m('goods');
            $goods = $goods_mod->get($goods_id);
            if (empty($goods)) {
                $this->show_warning('error_2');
                return;
            }
        }




        if (!IS_POST) {

            $this->assign('store', $store);
            $this->assign('goods', $goods);
            
            $this->_config_seo(array(
                'title' => Lang::get('mall_index') . ' - ' . Conf::get('site_title'),
            ));
            $this->assign('type', $type);
            $this->assign('page_description', Conf::get('site_description'));
            $this->assign('page_keywords', Conf::get('site_keywords'));
            $this->display('customer_message.index.html');
        } else {

            $data = array(
                'message' => $_POST['message'],
                'realname' => $_POST['realname'],
                'mobile' => $_POST['mobile'],
                'add_time' => gmtime(),
                'type' => $type,
                'user_id'=>$this->visitor->get('user_id'),
            );
            if($store_id){
                $data['store_id'] = $store_id;
            }
            if($goods_id){
                $data['goods_id'] = $goods_id;
            }


            $customer_message_mod = & m('customer_message');

            $customer_message_mod->add($data);

            $this->show_message('add_ok', 'index.php?app=customer_message');
        }
    }

}

?>
