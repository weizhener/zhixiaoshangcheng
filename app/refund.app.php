<?php



/**

 *    退款维权管理控制器

 *

 *    @author    Garbin

 *    @usage    none

 */

class RefundApp extends MemberbaseApp {



    var $_order_mod;

    var $_order_log_mod;

    var $_order_extm_mod;

    var $_goods_mod;

    var $_ordergoods_mod;

    var $_refund_mod;

    var $_store_mod;

    var $_member_mod;

    var $_refund_message_mod;



    function __construct() {

        $this->RefundApp();

    }



    function RefundApp() {

        parent::__construct();

        $this->_order_mod = &m('order');

        $this->_order_log_mod = &m('orderlog');

        $this->_order_extm_mod = &m('orderextm');

        $this->_goods_mod = &m('goods');

        $this->_ordergoods_mod = &m('ordergoods');

        $this->_refund_mod = &m('refund');

        $this->_store_mod = &m('store');

        $this->_member_mod = &m('member');

        $this->_refund_message_mod = &m('refund_message');

    }



    function index() {

        $page = $this->_get_page(10);   //获取分页信息

        $refunds = $this->_refund_mod->find(array(

            'conditions' => 'buyer_id=' . $this->visitor->get('user_id'),

            'limit' => $page['limit'],

            'order' => 'created desc',

            'count' => true

        ));

        $page['item_count'] = $this->_refund_mod->getCount();

        foreach ($refunds as $key => $refund) {

            $store = $this->_store_mod->get(array('conditions' => 'store_id=' . $refund['seller_id'], 'fields' => 'store_name,owner_name'));

            $refunds[$key]['store_name'] = $store['store_name'];

            $refunds[$key]['user_name'] = $store['owner_name'];

            $goods = $this->_goods_mod->get(array('conditions' => 'goods_id=' . $refund['goods_id'], 'fields' => 'goods_name'));

            $refunds[$key]['goods_name'] = $goods['goods_name'];



            $order = $this->_order_mod->get(array('conditions' => 'order_id=' . $refund['order_id'], 'fields' => 'order_sn'));

            $refunds[$key]['order_sn'] = $order['order_sn'];

            $refunds[$key]['refund_fee'] = $refund['refund_goods_fee'] + $refund['refund_shipping_fee'];

        }

        $this->_format_page($page);

        $this->assign('page_info', $page);





        /* 当前位置 */

        $this->_curlocal(LANG::get('member_center'), url('app=member'), LANG::get('refund'), url('app=refund'), LANG::get('refund_apply'));



        /* 当前用户中心菜单 */

        $this->_curitem('refund_apply');

        $this->_curmenu('refund_apply');

        $this->_config_seo('title', Lang::get('member_center'));



        $this->assign('refunds', $refunds);

        $this->display('refund.index.html');

    }



    function view() {

        $refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);

        if (!$refund_id) {

            return;

        }





        $refund = $this->_refund_mod->get(array('conditions' => 'refund_id=' . $refund_id . ' and (buyer_id=' . $this->visitor->get('user_id') . ' or seller_id=' . $this->visitor->get('user_id') . ')'));

        if (!$refund) {

            $this->show_warning('refund_not_exist');

            return;

        }

        if (!IS_POST) {

            $refund['shipped_text'] = Lang::get('shipped_' . $refund['shipped']);

            $refund['refund_fee'] = $refund['refund_goods_fee'] + $refund['refund_shipping_fee'];



            /* 当前位置 */

            $this->_curlocal(LANG::get('member_center'), url('app=member'), LANG::get('refund'), url('app=refund'), LANG::get('refund_view'));



            /* 当前用户中心菜单 */

            $curitem = $refund['seller_id'] == $this->visitor->get('user_id') ? 'refund_receive' : 'refund_apply';

            $this->_curitem($curitem);

            $this->_curmenu('refund_view');

            $this->_config_seo('title', Lang::get('member_center'));



            $page = $this->_get_page(5);   //获取分页信息

            $refund['message'] = $this->_refund_message_mod->find(array(

                'conditions' => 'refund_id=' . $refund_id,

                'order' => 'created desc',

                'limit' => $page['limit'],

                'count' => true

            ));

            $page['item_count'] = $this->_refund_message_mod->getCount();

            $this->_format_page($page);

            $this->assign('page_info', $page);

            $this->assign('refund', $refund);

            $this->display('refund.view.html');

        } else {



            if ($refund['status'] == 'SUCCESS' || $refund['CLOSED']) {

                $this->show_warning('add_refund_message_not_allow');

                return;

            }



            $refund_image = $this->_upload_files();

            if ($refund_image === false) {

                $this->show_warning('refund_message_image_upload_error');

                return;

            }

            $data = array(

                'owner_id' => $this->visitor->get('user_id'),

                'owner_role' => $refund['buyer_id'] == $this->visitor->get('user_id') ? 'buyer' : ($refund['seller_id'] == $this->visitor->get('user_id') ? 'seller' : 'admin'),

                'refund_id' => $refund_id,

                'content' => htmlspecialchars(trim($_POST['content'])),

                'pic_url' => $refund_image['refund_cert'],

                'created' => gmtime()

            );

            $this->_refund_message_mod->add($data);

            $this->show_message('add_ok');

        }

    }



    function add() {

        $order_id = intval($_GET['order_id']);

        $goods_id = intval($_GET['goods_id']);

        $spec_id = intval($_GET['spec_id']);


        // 激活会员购买商品订单，拒绝退款
        $model_member = & m('member');
        $buyer_info=$model_member->get($this->visitor->get('user_id'));
        $model_goods=&m('goods');  
        
        $goods_info=$model_member->get($goods_id);
        /*if($goods_info['status']==1||$buyer_info['status']!=2){
            $this->show_warning('navication_refuse');
        
            return;
        }*/

        
        
        

        if (!$this->available_refund($order_id, $goods_id, $spec_id)) {

            $this->show_warning('not_allow_refund');

            return;

        }



        $order = $this->_order_mod->get($order_id);

        $shipping_info = $this->_order_extm_mod->get($order_id);

        $goods = $this->get_order_goods($order_id, $goods_id, $spec_id);





        $goods_amount_after_adjust = $order['goods_amount'];

        $goods_amount_before_adjust = $this->get_order_goods_amount($order_id);





        if ($goods_amount_before_adjust > 0) {

            $goods_share_rate = round($goods['price'] * $goods['quantity'] / $goods_amount_before_adjust, 2);

        }

        else

            $goods_share_rate = 0;







        if ($goods_amount_before_adjust == $goods_amount_after_adjust) {

            $goods['goods_fee'] = round($goods['price'] * $goods['quantity'] - $order['discount'] * $goods_share_rate, 2);

        } elseif ($goods_amount_before_adjust != 0) {

            $goods_total_fee = $goods['price'] * (1 - ($goods_amount_before_adjust - $goods_amount_after_adjust) / $goods_amount_before_adjust) * $goods['quantity'];

            $goods['goods_fee'] = round($goods_total_fee, 2);

        } else {

            $goods['goods_fee'] = 0;

        }





        $ordergoods = $this->_ordergoods_mod->find(array('conditions' => 'order_id=' . $order_id, 'fields' => 'rec_id'));

        if ($goods_amount_before_adjust > 0) {

            $goods['shipping_fee'] =  round($shipping_info['shipping_fee'] * $goods_share_rate, 2);

        }

        else{

            $goods['shipping_fee'] = round($shipping_info['shipping_fee'] / count($ordergoods), 2); // 平均分

        }

            





        if (!IS_POST) {

            $refund = array();

            $refund['goods_fee'] = $refund['refund_fee'] = $goods['goods_fee'];

            $refund['total_fee'] = $goods['goods_fee'] + $goods['shipping_fee'];

            $refund['shipping_fee'] = $goods['shipping_fee'];

            $this->assign('refund', $refund);





            $this->_curlocal(LANG::get('member_center'), url('app=member'), LANG::get('refund'), url('app=refund'), LANG::get('refund_add'));



            /* 当前用户中心菜单 */

            $this->_curitem('refund_apply');

            $this->_curmenu('refund_add');

            $this->_config_seo('title', Lang::get('member_center'));

            $this->display('refund.form.html');

        } else {



            $this->_check_post_data($goods);



            $refund_shipping_fee = $_POST['refund_shipping_fee'] ? $_POST['refund_shipping_fee'] : 0;



            $data = array(

                'refund_sn' => $this->_refund_mod->gen_refund_sn(),

                'order_id' => $order_id,

                'goods_id' => $goods_id,

                'spec_id' => $spec_id,

                'refund_reason' => htmlspecialchars(trim($_POST['refund_reason'])),

                'refund_desc' => htmlspecialchars(trim($_POST['refund_desc'])),

                'total_fee' => $goods['goods_fee'] + $goods['shipping_fee'],

                'goods_fee' => $goods['goods_fee'],

                'shipping_fee' => $goods['shipping_fee'],

                'refund_goods_fee' => trim($_POST['refund_goods_fee']),

                'refund_shipping_fee' => trim($_POST['refund_shipping_fee']),

                'shipped' => $_POST['shipped'] ? intval(trim($_POST['shipped'])) : 0,

                'buyer_id' => $order['buyer_id'],

                'seller_id' => $order['seller_id'],

                'status' => 'WAIT_SELLER_AGREE', // 买家已经申请退款，等待卖家同意

                'created' => gmtime(),

            );

            if ($refund_id = $this->_refund_mod->add($data)) {



                $this->_refund_message_mod->add(array(

                    'owner_id' => $this->visitor->get('user_id'),

                    'owner_role' => 'buyer',

                    'refund_id' => $refund_id,

                    'content' => sprintf(LANG::get('apply_refund_content_change'), $_POST['refund_goods_fee'], $refund_shipping_fee, LANG::get('shipped_' . $_POST['shipped']), $_POST['refund_reason'], $_POST['refund_desc']),

                    'created' => gmtime(),

                ));



                $this->show_message('add_ok', 'back_list', 'index.php?app=refund');

            }

        }

    }



    function edit() {

        $refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);

        if (!$refund_id) {

            $this->show_warning('no_such_refund');

            return;

        }





        $refund = $this->_refund_mod->get(array('conditions' => '(status != "SUCCESS" AND status != "CLOSED" AND status != "WAIT_ADMIN_AGREE") and refund_id=' . $refund_id . ' and buyer_id=' . $this->visitor->get('user_id')));

        if (!$refund) {

            $this->show_warning('refund_not_allow_edit');

            return;

        }



        if (!IS_POST) {

            $this->assign('refund', $refund);



            /* 当前位置 */

            $this->_curlocal(LANG::get('member_center'), url('app=member'), LANG::get('refund'), url('app=refund'), LANG::get('refund_edit'));



            /* 当前用户中心菜单 */

            $this->_curitem('refund_apply');

            $this->_curmenu('refund_edit');

            $this->_config_seo('title', Lang::get('member_center'));

            $this->display('refund.form.html');

        } else {

            // 检查提交的数据

            $this->_check_post_data($refund);



            $data = array(

                'status' => 'WAIT_SELLER_CONFIRM',

                'refund_reason' => htmlspecialchars(trim($_POST['refund_reason'])),

                'refund_desc' => htmlspecialchars(trim($_POST['refund_desc'])),

                'refund_goods_fee' => trim($_POST['refund_goods_fee']),

                'refund_shipping_fee' => trim($_POST['refund_shipping_fee']),

                'shipped' => $_POST['shipped'] ? intval(trim($_POST['shipped'])) : 0,

            );

            $this->_refund_mod->edit($refund_id, $data);



            $this->_refund_message_mod->add(array(

                'owner_id' => $this->visitor->get('user_id'),

                'owner_role' => 'buyer',

                'refund_id' => $refund_id,

                'content' => sprintf(LANG::get('refund_content_change'), $_POST['refund_goods_fee'], $_POST['refund_shipping_fee'], LANG::get('shipped_' . $_POST['shipped']), $_POST['refund_reason'], $_POST['refund_desc']),

                'created' => gmtime(),

            ));



            $this->show_message('edit_ok', 'back_list', 'index.php?app=refund');

        }

    }



    function ask_customer() {

        $refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);

        if (!$refund_id) {

            return;

        }



        $refund = $this->_refund_mod->get(array('conditions' => 'ask_customer !=1 and (status!="SUCCESS" AND status!="CLOSED") and refund_id=' . $refund_id . ' and (buyer_id=' . $this->visitor->get('user_id') . ' or seller_id=' . $this->visitor->get('user_id') . ')', 'fields' => 'refund_id,refund_sn,buyer_id,seller_id'));

        if (!$refund) {

            $this->show_warning('ask_customer_not_allow');

            return;

        }

        $this->_refund_mod->edit($refund_id, array('ask_customer' => 1));





        if ($refund['buyer_id'] == $this->visitor->get('user_id')) {

            $owner_role = 'buyer';

        } else {

            $owner_role = 'seller';

        }

        $data = array(

            'owner_id' => $this->visitor->get('user_id'),

            'owner_role' => $owner_role,

            'refund_id' => $refund_id,

            'content' => sprintf(Lang::get('ask_customer_content_change'), Lang::get($owner_role)),

            'created' => gmtime(),

        );

        $this->_refund_message_mod->add($data);

        $this->show_message('ask_customer_ok', 'back_list', 'index.php?app=refund&act=view&refund_id=' . $refund_id);

    }



    function agree() {

        $refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);

        if (!$refund_id) {

            return;

        }





        $refund = $this->_refund_mod->get(array('conditions' => '(status !="SUCCESS" AND status !="CLOSED" AND status !="WAIT_ADMIN_AGREE") and refund_id=' . $refund_id . ' and seller_id=' . $this->visitor->get('user_id')));



        if (!$refund) {

            $this->show_warning('agree_no_allow');

            return;

        }



        $order_id = $refund['order_id'];



        $order_info = $this->_order_mod->get($order_id);

        $seller_info = $this->_member_mod->get($order_info['seller_id']);

        $buyer_info = $this->_member_mod->get($order_info['buyer_id']);





        //如果为 epay 支付交易

        if ($order_info['payment_code'] == 'zjgl') {

            

            //判断是否已完成,如果未完成先结束订单

            $this->auto_refund_confirm_order($order_info);

            

            //首先对退货进行处理 BEGIN

            $this->_refund_mod->edit($refund_id, array('status'=>'SUCCESS', 'end_time' => gmtime()));

            $content = sprintf(Lang::get('seller_agree_refund_content_change'), $order_info['seller_name']);

            $data = array(

                'owner_id' => $order_info['seller_id'],

                'owner_role' => 'seller',

                'refund_id' => $refund_id,

                'content' => $content,

                'created' => gmtime()

            );

            $this->_refund_message_mod->add($data);

            // EBD

            

            

            $this->mod_epay = & m('epay');

            $this->mod_epaylog = & m('epaylog');

            //退款金额

            $money = $refund['refund_goods_fee'] + $refund['refund_shipping_fee'];

            $seller_user_id = $order_info['seller_id'];

            $buyer_user_id  = $order_info['buyer_id'];

            

            $seller_epay = $this->mod_epay->get('user_id='.$seller_user_id);

            $buyer_epay = $this->mod_epay->get('user_id='.$buyer_user_id);

            

            if(empty($seller_info)||empty($buyer_info)){

                $this->show_warning('seller_agree_refund_error');

            }

            

            

            //没有可用的退款余额

            if($seller_epay['money']<$money){

                $this->show_warning(sprintf(Lang::get('seller_agree_refund_money'), $money));

                return;

            }

            

            $seller_log_text = '您同意给买家'.$buyer_info['user_name'].'购买的产品退款'.$money.'元，订单号为:'.$order_info['order_sn'].',退款编号为:'.$refund_id;

            $seller_epay_log = array(

                'user_id'=>$seller_user_id,

                'user_name'=>$seller_info['user_name'],

                'order_id'=>$order_info['order_id'],

                'order_sn'=>$order_info['order_sn'],

                'to_id'=>$buyer_info['user_id'],

                'to_name'=>$buyer_info['user_name'],

                'type'=>EPAY_REFUND_OUT,

                'money_flow' => 'outlay',

                'money' => $money,

                'complete'=>1,

                'log_text'=>$seller_log_text,

                'add_time'=>  gmtime(),

            );

            $this->mod_epaylog->add($seller_epay_log);

            

            $buyer_log_text = $seller_info['user_name'].'同意给你购买的产品退款'.$money.'元，订单号为:'.$order_info['order_sn'].',退款编号为:'.$refund_id;

            $buyer_epay_log = array(

                'user_id'=>$buyer_user_id,

                'user_name'=>$buyer_info['user_name'],

                'order_id'=>$order_info['order_id'],

                'order_sn'=>$order_info['order_sn'],

                'to_id'=>$seller_info['user_id'],

                'to_name'=>$seller_info['user_name'],

                'type'=>EPAY_REFUND_IN,

                'money_flow' => 'income',

                'money' => $money,

                'complete'=>1,

                'log_text'=>$buyer_log_text,

                'add_time'=>  gmtime(),

            );

            $this->mod_epaylog->add($buyer_epay_log);

            

            

            $buyer_new_money = array(

                'money'=> $buyer_epay['money']+$money,

            );

            $this->mod_epay->edit('user_id='.$buyer_user_id, $buyer_new_money);

            

            $seller_new_money = array(

                'money'=>$seller_epay['money']-$money,

            );

            $this->mod_epay->edit('user_id='.$seller_user_id, $seller_new_money);

            



            /*

            $depopay_type = & dpt('outlay', 'refund');

            $tradesn = $depopay_type->submit(array(

                'trade_info' => array('user_id' => $order_info['seller_id'], 'party_id' => $order_info['buyer_id'], 'amount' => $refund['refund_goods_fee'] + $refund['refund_shipping_fee']),

                'extra_info' => $order_info + array('refund_id' => $refund_id, 'seller_user_name' => $seller_info['user_name'], 'operator' => 'seller'),

                'post' => $_POST,

            ));

            if (!$tradesn) {

                $this->show_warning('seller_agree_refund_error');

                return;

            }

            */

            



            $this->show_message('seller_agree_refund_ok', 'back_list', 'index.php?app=refund&act=view&refund_id=' . $refund_id);

        } else {



            $this->show_warning('payment_not_support_refund', 'back_list', 'index.php?app=refund&act=view&refund_id=' . $refund_id);

        }

    }

    

    //当卖家同意退款 订单自动确认收货

    function auto_refund_confirm_order($order_info)

    {

        

        $order_id = $order_info['order_id'];

        

        //判断订单是否已完成，未完成订单则自动完成

        if($order_info['status'] != ORDER_FINISHED){

            $this->_order_mod->edit($order_info['order_id'], array('status' => ORDER_FINISHED, 'finished_time' => gmtime()));

            

            /* 记录订单操作日志 */

            $order_log = & m('orderlog');

            $order_log->add(array(

                'order_id' => $order_id,

                'operator' => 0,

                'order_status' => order_status($order_info['status']),

                'changed_status' => order_status(ORDER_FINISHED),

                'remark' => Lang::get('seller_agree_refund_order_status_change'),

                'log_time' => gmtime(),

                'operator_type'=>'seller',

            ));

            

            

            /* 更新定单状态 开始***************************************************** */

            $this->mod_epay = & m('epay');

            $this->mod_epaylog = & m('epaylog');

            $epaylog_row = $this->mod_epaylog->getrow("select * from " . DB_PREFIX . "epaylog where order_id='$order_id' and type=".EPAY_BUY);

            $money = $epaylog_row['money']; //定单价格

            $sell_user_id = $epaylog_row['to_id']; //卖家ID

            $buyer_user_id = $epaylog_row['user_id']; //买家ID

            if ($epaylog_row['order_id'] == $order_id) {



                $sell_money_row = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_id='$sell_user_id'");

                $sell_money = $sell_money_row['money']; //卖家的资金

                $sell_money_dj = $sell_money_row['money_dj']; //卖家的冻结资金

                $new_money = $sell_money + $money;

                $new_money_dj = $sell_money_dj - $money;

                //更新数据

                $new_money_array = array(

                    'money' => $new_money,

                    'money_dj' => $new_money_dj,

                );

                $new_buyer_epaylog = array(

                    'money'=>$money,

                    'complete' => 1,

                    'states' => 40,

                );

                $new_seller_epaylog = array(

                    'money'=>$money,

                    'complete' => 1,

                    'states' => 40,

                );

                $this->mod_epay->edit('user_id=' . $sell_user_id, $new_money_array);

                $this->mod_epaylog->edit("order_id={$order_id} AND user_id={$sell_user_id}", $new_seller_epaylog);

                $this->mod_epaylog->edit("order_id={$order_id} AND user_id={$buyer_user_id}", $new_buyer_epaylog);

            }

            /* 更新定单状态 结束***************************************************** */

            

        }

    }

    

    

    



    function refuse() {

        $refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);

        if (!$refund_id) {

            return;

        }





        $refund = $this->_refund_mod->get(array('conditions' => '(status!="SUCCESS" AND status!="CLOSED" AND status!="WAIT_ADMIN_AGREE") and refund_id=' . $refund_id . ' and seller_id=' . $this->visitor->get('user_id')));



        if (!$refund) {

            $this->show_warning('refuse_not_allow');

            return;

        }



        if (!IS_POST) {

            $this->assign('refund', $refund);



            /* 当前位置 */

            $this->_curlocal(LANG::get('member_center'), url('app=member'), LANG::get('refund'), url('app=refund'), LANG::get('refund_refuse'));



            /* 当前用户中心菜单 */

            $this->_curitem('refund_receive');

            $this->_curmenu('refund_refuse');

            $this->_config_seo('title', Lang::get('member_center'));

            $this->display('refund.refuse.html');

        } else {

            $refund_image = $this->_upload_files();

            if ($refund_image === false) {

                $this->show_warning('refund_message_image_upload_error');

                return;

            }



            $this->_refund_mod->edit($refund_id, array('status' => 'SELLER_REFUSE_BUYER'));



            $data = array(

                'owner_id' => $this->visitor->get('user_id'),

                'owner_role' => 'seller',

                'refund_id' => $refund_id,

                'content' => sprintf(Lang::get('refuse_content_change'), htmlspecialchars(trim($_POST['content']))),

                'pic_url' => $refund_image['refund_cert'],

                'created' => gmtime()

            );

            $this->_refund_message_mod->add($data);

            $this->show_message('submit_ok', 'back_list', 'index.php?app=refund&act=view&refund_id=' . $refund_id);

        }

    }



    function cancel() {

        $refund_id = empty($_GET['refund_id']) ? 0 : intval($_GET['refund_id']);

        if (!$refund_id) {

            return;

        }



        $refund = $this->_refund_mod->get(array('conditions' => '(status!="SUCCESS" AND status!="CLOSED" AND status!="WAIT_ADMIN_AGREE") and refund_id=' . $refund_id . ' and buyer_id=' . $this->visitor->get('user_id'), 'fields' => 'refund_id,refund_sn'));

        if (!$refund) {

            $this->show_warning('cancel_not_allow');

            return;

        }

        $this->_refund_mod->edit($refund_id, array('status' => 'CLOSED', 'end_time' => gmtime()));

        $this->_refund_message_mod->add(array(

            'owner_id' => $this->visitor->get('user_id'),

            'owner_role' => 'buyer',

            'refund_id' => $refund_id,

            'content' => sprintf(Lang::get('cancel_content_change'), $refund['refund_sn']),

            'created' => gmtime(),

        ));

        $this->show_message('cancel_ok');

    }



    function available_refund($order_id, $goods_id, $spec_id) {

        if (!$order_id || !$goods_id || !$spec_id) {

            return false;

        }



        

        $order = $this->_order_mod->get(array('conditions' => 'order_id=' . $order_id . ' and buyer_id=' . $this->visitor->get('user_id'), 'fields' => 'order_id,status'));

        if (empty($order)) {

            return false;

        } elseif ($order['status'] != 20 && $order['status'] != 30 && $order['status'] != 40) {

            return false;

        }



        $ordergoods = $this->_ordergoods_mod->get(array('conditions' => 'order_id=' . $order_id . ' and goods_id=' . $goods_id . ' and spec_id=' . $spec_id, 'fields' => 'rec_id'));

        if (empty($ordergoods)) {

            return false;

        }



        if ($this->_refund_mod->get(array('conditions' => 'order_id=' . $order_id . ' and goods_id=' . $goods_id . ' and spec_id=' . $spec_id, 'fields' => 'refund_id'))) {

            return false;

        }

        

        return true;

    }



    function get_order_goods($order_id, $goods_id, $spec_id) {

        $ordergoods = $this->_ordergoods_mod->get(array('conditions' => 'order_id=' . $order_id . ' and goods_id=' . $goods_id . ' and spec_id=' . $spec_id));

        return $ordergoods;

    }



    function get_order_goods_amount($order_id) {

        $goods_amount = 0;



        if (!$order_id)

            return $goods_amount;



        $ordergoods = $this->_ordergoods_mod->find(array('conditions' => 'order_id=' . $order_id, 'fields' => 'price,quantity'));

        foreach ($ordergoods as $goods) {

            $goods_amount += $goods['price'] * $goods['quantity'];

        }

        return $goods_amount;

    }



    function receive() {

        $page = $this->_get_page(10);

        $refunds = $this->_refund_mod->find(array(

            'conditions' => 'seller_id=' . $this->visitor->get('user_id'),

            'order' => 'created desc',

            'limit' => $page['limit'],

            'count' => true

        ));

        $page['item_count'] = $this->_refund_mod->getCount();

        foreach ($refunds as $key => $refund) {

            $member = $this->_member_mod->get(array('conditions' => 'user_id=' . $refund['buyer_id'], 'fields' => 'user_name'));

            $refunds[$key]['user_name'] = $member['user_name'];

            $goods = $this->_goods_mod->get(array('conditions' => 'goods_id=' . $refund['goods_id'], 'fields' => 'goods_name'));

            $refunds[$key]['goods_name'] = $goods['goods_name'];



            $order = $this->_order_mod->get(array('conditions' => 'order_id=' . $refund['order_id'], 'fields' => 'order_sn'));

            $refunds[$key]['order_sn'] = $order['order_sn'];



            $refunds[$key]['refund_fee'] = $refund['refund_goods_fee'] + $refund['refund_shipping_fee'];

        }

        $this->_format_page($page);

        $this->assign('page_info', $page);



        /* 当前位置 */

        $this->_curlocal(LANG::get('member_center'), url('app=member'), LANG::get('refund'), url('app=refund'), LANG::get('refund_receive'));



        /* 当前用户中心菜单 */

        $this->_curitem('refund_receive');

        $this->_curmenu('refund_receive');

        $this->_config_seo('title', Lang::get('member_center'));



        $this->assign('refunds', $refunds);

        $this->display('refund.receive.html');

    }



    function _check_post_data($refund = array()) {

        if (empty($_POST['refund_goods_fee']) || floatval($_POST['refund_goods_fee']) < 0) {

            $this->show_warning('refund_fee_ge0');

            exit;

        } elseif (floatval($_POST['refund_goods_fee']) > $refund['goods_fee']) {

            $this->show_warning('refund_fee_error');

            exit;

        }

        if ($_POST['refund_shipping_fee'] != '' && floatval($_POST['refund_shipping_fee']) < 0) {

            $this->show_warning('refund_shipping_fee_ge0');

            exit;

        }

        if (floatval($_POST['refund_shipping_fee']) > $refund['shipping_fee']) {

            $this->show_warning('refund_shipping_fee_error');

            exit;

        }

        if (!in_array(trim($_POST['shipped']), array(0, 1, 2))) {

            $this->show_warning('select_refund_shipped');

            exit;

        }

        if (empty($_POST['refund_reason'])) {

            $this->show_warning('select_refund_reason');

            exit;

        }

    }



    function _get_member_submenu() {

        if (ACT == 'receive') {

            $menus[] = array(

                'name' => 'refund_receive',

                'url' => '',

            );

        }

        if (ACT == 'add') {

            $menus[] = array(

                'name' => 'refund_add',

                'url' => '',

            );

        }

        if (ACT == 'edit') {

            $menus[] = array(

                'name' => 'refund_edit',

                'url' => '',

            );

        }

        if (ACT == 'view') {

            $menus[] = array(

                'name' => 'refund_view',

                'url' => '',

            );

        }

        if (ACT == 'refuse') {

            $menus[] = array(

                'name' => 'refund_refuse',

                'url' => '',

            );

        } elseif (ACT == 'index') {

            $menus[] = array(

                'name' => 'refund_apply',

                'url' => '',

            );

        }



        return $menus;

    }



    /**

     * 上传凭证

     *

     */

    function _upload_files() {

        import('uploader.lib');

        $data = array();

        $file = $_FILES['refund_cert'];

        if ($file['error'] == UPLOAD_ERR_OK && $file != '') {

            $uploader = new Uploader();

            $uploader->allowed_type(IMAGE_FILE_TYPE);

            $uploader->addFile($file);

            $uploader->root_dir(ROOT_PATH);

            $data['refund_cert'] = $uploader->save('data/files/refund_cert/member_' . $this->visitor->get('user_id'), $uploader->random_filename());

        }

        return $data;

    }



}



?>

