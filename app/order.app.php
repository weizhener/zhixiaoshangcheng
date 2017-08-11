<?php



/**

 *    售货员控制器，其扮演实际交易中柜台售货员的角色，你可以这么理解她：你告诉我（售货员）要买什么东西，我会询问你你要的收货地址是什么之类的问题

 *        并根据你的回答来生成一张单子，这张单子就是“订单”

 *

 *    @author    Garbin

 *    @param    none

 *    @return    void

 */

class OrderApp extends ShoppingbaseApp {



    function __construct() {

        $this->OrderApp();

    }



    function OrderApp() {

        parent::__construct();

        $this->mod_msg = & m('msg');

        $this->mod_msglog = & m('msglog');

    }



    /**

     *    填写收货人信息，选择配送，支付方式。

     *

     *    @author    Garbin

     *    @param    none

     *    @return    void

     */

    function index() {

        $goods_info = $this->_get_goods_info();

        if ($goods_info === false) {

            /* 购物车是空的 */

            $this->show_warning('goods_empty');



            return;

        }



        /*  检查库存 */

        $goods_beyond = $this->_check_beyond_stock($goods_info['items']);

        if ($goods_beyond) {

            $str_tmp = '';

            foreach ($goods_beyond as $goods) {

                $str_tmp .= '<br /><br />' . $goods['goods_name'] . '&nbsp;&nbsp;' . $goods['specification'] . '&nbsp;&nbsp;' . Lang::get('stock') . ':' . $goods['stock'];

            }

            $this->show_warning(sprintf(Lang::get('quantity_beyond_stock'), $str_tmp));

            return;

        }

        if (!IS_POST) {


			$address_model = & m('address');

            if (!$address_model->get('user_id=' . $this->visitor->get('user_id'))) {
    
                $this->show_warning('请先添加你的收货地址', '添加地址', 'index.php?app=my_address');
    
                return;
    
            }


            /* 根据商品类型获取对应订单类型 */

            $goods_type = & gt($goods_info['type']);

            $order_type = & ot($goods_info['otype']);



            /* 显示订单表单 */

          $form = $order_type->get_order_form($goods_info); // psmb

            if ($form === false) {

                $this->show_warning($order_type->get_error());

                return;

            }

            $this->_curlocal(

                    LANG::get('create_order')

            );

            /*满包邮 GEGIN*/

            (($goods_info['amount'] > $goods_info['amount_for_free_fee']) && ($goods_info['amount_for_free_fee'] > 0)) && $logic1 = true;

            $logic2 = ($goods_info['quantity'] >= $goods_info['acount_for_free_fee']) && ($goods_info['acount_for_free_fee'] > 0);

            if ($logic1 || $logic2) {

                $logic2 && $title = sprintf(Lang::get('free_acount_ship_title'), $goods_info['acount_for_free_fee']);

                $logic1 && $title = sprintf(Lang::get('free_amount_ship_title'), $goods_info['amount_for_free_fee']);

                $this->assign('is_free_fee', true);

                $this->assign('free_fee_name', $title);

            }

            /*满包邮 END*/

            

            $this->_config_seo('title', Lang::get('confirm_order') . ' - ' . Conf::get('site_title'));



            import('init.lib');

            $this->assign('coupon_list', Init_OrderApp::get_available_coupon($goods_info['store_id']));

            
            
            //以下部分为激活用
            $member_mod = & m('member');
            
            $member_info = $member_mod->get($this->visitor->get('user_id'));
            
            if(!$member_info['status']){//获取 用户是否激活
                
                $goods_mod = & m('goods');
                
                foreach ($goods_info['items'] as $goods) {
                
                    // 因为一个订单可能包含多个商品,一个商品可能购买了M件，那么可使用的积分便是 N*M 之和
                
                    $goods_integral = $goods_mod->get($goods['goods_id']); //获取商品的是否为激活状态
                
                    /*if(!$goods_integral['status']){
                        
                        $this->show_warning('tip_notnavication');
                        
                        return;
                    }*/
                
                }
                
            }
            
            
            
            
            #获取系统是否开启积分

            if ($goods_info['integral_enabled']) {

                $total_integral_max_exchange = 0; #共可使用多少积分进行抵扣

                $goods_mod = & m('goods');

                foreach ($goods_info['items'] as $goods) {

                    // 因为一个订单可能包含多个商品,一个商品可能购买了M件，那么可使用的积分便是 N*M 之和

                    $goods_integral = $goods_mod->get($goods['goods_id']); #当前产品设置的积分抵扣额

                    $total_integral_max_exchange += $goods_integral['integral_max_exchange'] * $goods['quantity'];

                }

                //获取当前用户可用积分

                $member_mod = & m('member');

                $member_info = $member_mod->get($this->visitor->get('user_id'));

                $this->assign('member_integral', $member_info['integral']);

                $this->assign('total_integral_max_exchange', $total_integral_max_exchange);

                $this->assign('integral_seller',  Conf::get('integral_seller'));#积分抵扣金额比例

            }

            

            $this->assign('goods_info', $goods_info);

            $this->assign($form['data']);

            $this->display($form['template']);

        } else {

            /* 在此获取生成订单的两个基本要素：用户提交的数据（POST），商品信息（包含商品列表，商品总价，商品总数量，类型），所属店铺 */

            $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;

            if ($goods_info === false) {

                /* 购物车是空的 */

                $this->show_warning('goods_empty');



                return;

            }

            /* 优惠券数据处理 */

            if ($goods_info['allow_coupon'] && isset($_POST['coupon_sn']) && !empty($_POST['coupon_sn'])) {

                $coupon_sn = trim($_POST['coupon_sn']);

                $coupon_mod = & m('couponsn');

                $coupon = $coupon_mod->get(array(

                    'fields' => 'coupon.*,couponsn.remain_times',

                    'conditions' => "coupon_sn.coupon_sn = '{$coupon_sn}' AND coupon.store_id = " . $store_id,

                    'join' => 'belongs_to_coupon'));

                if (empty($coupon)) {

                    $this->show_warning('involid_couponsn');

                    exit;

                }

                if ($coupon['remain_times'] < 1) {

                    $this->show_warning("times_full");

                    exit;

                }

                $time = gmtime();

                if ($coupon['start_time'] > $time) {

                    $this->show_warning("coupon_time");

                    exit;

                }



                if ($coupon['end_time'] < $time) {

                    $this->show_warning("coupon_expired");

                    exit;

                }

                if ($coupon['min_amount'] > $goods_info['amount']) {

                    $this->show_warning("amount_short");

                    exit;

                }

                unset($time);

                $goods_info['discount'] = $coupon['coupon_value'];

            }

            

            if ($goods_info['integral_enabled'] && intval($_POST['use_integral'])) {

                //用户提交使用的积分额度

                $use_integral = intval($_POST['use_integral']);



                $total_integral_max_exchange = 0; #共可使用多少积分进行抵扣

                $goods_mod = & m('goods');

                foreach ($goods_info['items'] as $goods) {

                    // 因为一个订单可能包含多个商品,一个商品可能购买了M件，那么可使用的积分便是 N*M 之和

                    $goods_integral = $goods_mod->get($goods['goods_id']); #当前产品设置的积分抵扣额

                    $total_integral_max_exchange += $goods_integral['integral_max_exchange'] * $goods['quantity'];

                }



                if ($use_integral > $total_integral_max_exchange) {

                    $this->show_warning('此订单最多可以使用 ' . $total_integral_max_exchange . '积分。');

                    exit;

                }

                //获取当前用户可用积分

                $member_mod = & m('member');

                $member_info = $member_mod->get($this->visitor->get('user_id'));

                if ($use_integral > $member_info['integral']) {

                    $this->show_warning('对不起，你没有足够的积分！你目前的积分值为：' . $member_info['integral']);

                    exit;

                }

                //获取抵扣金额

                /*$goods_info['discount'] += $use_integral * Conf::get('integral_seller');

                //扣除积分记录,更新信息

                import('integral.lib');

                $integral = new Integral();

                $integral->change_integral_seller($this->visitor->get('user_id'), $use_integral);*/

            }

            

            /* 根据商品类型获取对应的订单类型 */

            $goods_type = & gt($goods_info['type']);

            $order_type = & ot($goods_info['otype']);



            /* 将这些信息传递给订单类型处理类生成订单(你根据我提供的信息生成一张订单) */

            $order_id = $order_type->submit_order(array(

                'goods_info' => $goods_info, //商品信息（包括列表，总价，总量，所属店铺，类型）,可靠的!

                'post' => $_POST, //用户填写的订单信息

            ));





            if (!$order_id) {

                $this->show_warning($order_type->get_error());



                return;

            }



            /*  检查是否添加收货人地址  */

            if (isset($_POST['save_address']) && (intval(trim($_POST['save_address'])) == 1)) {

                $data = array(

                    'user_id' => $this->visitor->get('user_id'),

                    'consignee' => trim($_POST['consignee']),

                    'region_id' => $_POST['region_id'],

                    'region_name' => $_POST['region_name'],

                    'address' => trim($_POST['address']),

                    'zipcode' => trim($_POST['zipcode']),

                    'phone_tel' => trim($_POST['phone_tel']),

                    'phone_mob' => trim($_POST['phone_mob']),

                );

                $model_address = & m('address');

                $model_address->add($data);

            }

            /* 下单完成后清理商品，如清空购物车，或将团购拍卖的状态转为已下单之类的 */

            $this->_clear_goods($order_id);



            /* 发送邮件 */

            $model_order = & m('order');



            /* 减去商品库存 */

            $model_order->change_stock('-', $order_id);



            /* 获取订单信息 */

            $order_info = $model_order->get($order_id);



            /* 记录订单操作日志 */

            $order_log =& m('orderlog');

            $order_log->add(array(

                'order_id'  => $order_id,

                'operator'  => addslashes($this->visitor->get('user_name')),

                'order_status' => '',

                'changed_status' => '下订单',

                'remark'    => '买家下单',

                'log_time'  => gmtime(),

                'operator_type'=>'buyer'

            ));

            

            /* 发送事件 */

            $feed_images = array();

            foreach ($goods_info['items'] as $_gi) {

                $feed_images[] = array(

                    'url' => SITE_URL . '/' . $_gi['goods_image'],

                    'link' => SITE_URL . '/' . url('app=goods&id=' . $_gi['goods_id']),

                );

            }

            $this->send_feed('order_created', array(

                'user_id' => $this->visitor->get('user_id'),

                'user_name' => addslashes($this->visitor->get('user_name')),

                'seller_id' => $order_info['seller_id'],

                'seller_name' => $order_info['seller_name'],

                'store_url' => SITE_URL . '/' . url('app=store&id=' . $order_info['seller_id']),

                'images' => $feed_images,

            ));



            $buyer_address = $this->visitor->get('email');

            $model_member = & m('member');

            $member_info = $model_member->get($goods_info['store_id']);

            $seller_address = $member_info['email'];



            /* 发送给买家下单通知 */

            $buyer_mail = get_mail('tobuyer_new_order_notify', array('order' => $order_info));

            $this->_mailto($buyer_address, addslashes($buyer_mail['subject']), addslashes($buyer_mail['message']));



            /* 发送给卖家新订单通知 */

            $seller_mail = get_mail('toseller_new_order_notify', array('order' => $order_info));

            $this->_mailto($seller_address, addslashes($seller_mail['subject']), addslashes($seller_mail['message']));



            /* 更新下单次数 */

            $model_goodsstatistics = & m('goodsstatistics');

            $goods_ids = array();

            foreach ($goods_info['items'] as $goods) {

                $goods_ids[] = $goods['goods_id'];

            }

            $model_goodsstatistics->edit($goods_ids, 'orders=orders+1');



            /* 到收银台付款 */

            $buyer_info=$model_member->get($this->visitor->get('user_id'));
            if(!$buyer_info['status']){//假如会员没激活，则激活会员
                $model_member->edit($buyer_info['user_id'],array('status' => 1));
            }//买家付款过后，买家账号变成激活状态1

            

            //买家下单发送短信给卖家

            import('mobile_msg.lib');

            $mobile_msg = new Mobile_msg();

            $mobile_msg->send_msg_order($order_info,'buy');

            

            

            header('Location:index.php?app=cashier&order_id=' . $order_id);

            

        }

    }



    /**

     *    获取外部传递过来的商品

     *

     *    @author    Garbin

     *    @param    none

     *    @return    void

     */

    function _get_goods_info() {

        $return = array(

            'items' => array(), //商品列表

            'quantity' => 0, //商品总量

            'amount' => 0, //商品总价

            'store_id' => 0, //所属店铺

            'store_name' => '', //店铺名称

            'type' => null, //商品类型

            'otype' => 'normal', //订单类型

            'allow_coupon' => false, //是否允许使用优惠券

            'integral_enabled'=> Conf::get('integral_enabled') ? true : false,    // 获取系统是否开启积分

        );

        switch ($_GET['goods']) {

            case 'groupbuy':

                /* 团购的商品 */

                $group_id = isset($_GET['group_id']) ? intval($_GET['group_id']) : 0;

                $user_id = $this->visitor->get('user_id');

                if (!$group_id || !$user_id) {

                    return false;

                }

                /* 获取团购记录详细信息 */

                $model_groupbuy = & m('groupbuy');

                $groupbuy_info = $model_groupbuy->get(array(

                    'join' => 'be_join, belong_store, belong_goods',

                    'conditions' => $model_groupbuy->getRealFields("groupbuy_log.user_id={$user_id} AND groupbuy_log.group_id={$group_id} AND groupbuy_log.order_id=0 AND this.state=" . GROUP_FINISHED),

                    'fields' => 'store.store_id, store.store_name, goods.goods_id, goods.goods_name, goods.default_image, groupbuy_log.quantity, groupbuy_log.spec_quantity, this.spec_price',

                ));



                if (empty($groupbuy_info)) {

                    return false;

                }



                /* 库存信息 */

                $model_goodsspec = &m('goodsspec');

                $goodsspec = $model_goodsspec->find('goods_id=' . $groupbuy_info['goods_id']);



                /* 获取商品信息 */

                $spec_quantity = unserialize($groupbuy_info['spec_quantity']);

                $spec_price = unserialize($groupbuy_info['spec_price']);

                $amount = 0;

                $groupbuy_items = array();

                $goods_image = empty($groupbuy_info['default_image']) ? Conf::get('default_goods_image') : $groupbuy_info['default_image'];

                foreach ($spec_quantity as $spec_id => $spec_info) {

                    $the_price = $spec_price[$spec_id]['price'];

                    $subtotal = $spec_info['qty'] * $the_price;

                    $groupbuy_items[] = array(

                        'goods_id' => $groupbuy_info['goods_id'],

                        'goods_name' => $groupbuy_info['goods_name'],

                        'spec_id' => $spec_id,

                        'specification' => $spec_info['spec'],

                        'price' => $the_price,

                        'quantity' => $spec_info['qty'],

                        'goods_image' => $goods_image,

                        'subtotal' => $subtotal,

                        'stock' => $goodsspec[$spec_id]['stock'],

                    );

                    $amount += $subtotal;

                }



                $return['items'] = $groupbuy_items;

                $return['quantity'] = $groupbuy_info['quantity'];

                $return['amount'] = $amount;

                $return['store_id'] = $groupbuy_info['store_id'];

                $return['store_name'] = $groupbuy_info['store_name'];

                $return['type'] = 'material';

                $return['otype'] = 'groupbuy';

                $return['allow_coupon'] = false;

                break;

            default:

                /* 从购物车中取商品 */

                $_GET['store_id'] = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;

                $store_id = $_GET['store_id'];

                if (!$store_id) {

                    return false;

                }





                $cart_model = & m('cart');



                /*

                $cart_items = $cart_model->find(array(

                    'conditions' => "user_id = " . $this->visitor->get('user_id') . " AND store_id = {$store_id} AND session_id='" . SESS_ID . "'",

                    'join' => 'belongs_to_goodsspec',

                ));

                 */

                $cart_items = $cart_model->find(array(

                    'conditions' => "user_id = " . $this->visitor->get('user_id') . " AND store_id = {$store_id} AND session_id='" . SESS_ID . "'",

                    'join' => 'belongs_to_goodsspec',

                    'fields' => 'gs.spec_id,gs.spec_1,gs.spec_2,gs.color_rgb,gs.stock,gs.sku,cart.*' // 不能有 gs.price， 要不读取的不是促销价格，购物车里面才是促销价格

                ));



                if (empty($cart_items)) {

                    return false;

                }





                $store_model = & m('store');

                $store_info = $store_model->get($store_id);



                foreach ($cart_items as $rec_id => $goods) {

                    $return['quantity'] += $goods['quantity'];                      //商品总量

                    $return['amount'] += $goods['quantity'] * $goods['price'];    //商品总价

					

					 $return['gh_amount'] += $goods['quantity'] * $goods['gh_price'];    //商品总价

                    $cart_items[$rec_id]['subtotal'] = $goods['quantity'] * $goods['price'];   //小计

                    empty($goods['goods_image']) && $cart_items[$rec_id]['goods_image'] = Conf::get('default_goods_image');

                }



                $return['items'] = $cart_items;

                $return['store_id'] = $store_id;

                $return['store_name'] = $store_info['store_name'];

                $return['store_im_qq'] = $store_info['im_qq']; //  

                $return['type'] = 'material';

                $return['amount_for_free_fee'] = $store_info['amount_for_free_fee'];

                $return['acount_for_free_fee'] = $store_info['acount_for_free_fee'];

                $return['otype'] = 'normal';

                break;

        }



        return $return;

    }



    /**

     *    下单完成后清理商品

     *

     *    @author    Garbin

     *    @return    void

     */

    function _clear_goods($order_id) {

        switch ($_GET['goods']) {

            case 'groupbuy':

                /* 团购的商品 */

                $model_groupbuy = & m('groupbuy');

                $model_groupbuy->updateRelation('be_join', intval($_GET['group_id']), $this->visitor->get('user_id'), array(

                    'order_id' => $order_id,

                ));

                break;

            default://购物车中的商品

                /* 订单下完后清空指定购物车 */

                $_GET['store_id'] = isset($_GET['store_id']) ? intval($_GET['store_id']) : 0;

                $store_id = $_GET['store_id'];

                if (!$store_id) {

                    return false;

                }

                $model_cart = & m('cart');

                $model_cart->drop("store_id = {$store_id} AND session_id='" . SESS_ID . "'");

                //优惠券信息处理

                if (isset($_POST['coupon_sn']) && !empty($_POST['coupon_sn'])) {

                    $sn = trim($_POST['coupon_sn']);

                    $couponsn_mod = & m('couponsn');

                    $couponsn = $couponsn_mod->get("coupon_sn = '{$sn}'");

                    if ($couponsn['remain_times'] > 0) {

                        $couponsn_mod->edit("coupon_sn = '{$sn}'", "remain_times= remain_times - 1");

                    }

                }

                break;

        }

    }



    /**

     * 检查优惠券有效性

     */

    function check_coupon() {

        $coupon_sn = $_GET['coupon_sn'];

        $store_id = is_numeric($_GET['store_id']) ? $_GET['store_id'] : 0;

        if (empty($coupon_sn)) {

            $this->js_result(false);

        }

        $coupon_mod = & m('couponsn');

        $coupon = $coupon_mod->get(array(

            'fields' => 'coupon.*,couponsn.remain_times',

            'conditions' => "coupon_sn.coupon_sn = '{$coupon_sn}' AND coupon.store_id = " . $store_id,

            'join' => 'belongs_to_coupon'));

        if (empty($coupon)) {

            $this->json_result(false);

            exit;

        }

        if ($coupon['remain_times'] < 1) {

            $this->json_result(false);

            exit;

        }

        $time = gmtime();

        if ($coupon['start_time'] > $time) {

            $this->json_result(false);

            exit;

        }





        if ($coupon['end_time'] < $time) {

            $this->json_result(false);

            exit;

        }



        // 检查商品价格与优惠券要求的价格



        $model_cart = & m('cart');

        $item_info = $model_cart->find("store_id={$store_id} AND session_id='" . SESS_ID . "'");

        $price = 0;

        foreach ($item_info as $val) {

            $price = $price + $val['price'] * $val['quantity'];

        }

        if ($price < $coupon['min_amount']) {

            $this->json_result(false);

            exit;

        }

        $this->json_result(array('res' => true, 'price' => $coupon['coupon_value']));

        exit;

    }



    function _check_beyond_stock($goods_items) {

        $goods_beyond_stock = array();

        foreach ($goods_items as $rec_id => $goods) {

            if ($goods['quantity'] > $goods['stock']) {

                $goods_beyond_stock[$goods['spec_id']] = $goods;

            }

        }

        return $goods_beyond_stock;

    }



}



?>

