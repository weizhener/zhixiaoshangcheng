<?php

/**
 *    买家的订单管理控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class Seller_orderApp extends StoreadminbaseApp {

    function __construct() {
        $this->Seller_orderApp();
    }

    function Seller_orderApp() {
        parent::__construct();
        $this->clear_seller_logs();
        $this->mod_epay = & m('epay');
        $this->mod_epaylog = & m('epaylog');
        $this->mod_msg = & m('msg');
        $this->mod_msglog = & m('msglog');
    }
    
    //标识发货记录  清除operator_type='buyer'
    function clear_seller_logs()
    {
        $order_log_mod = & m('orderlog');
        $user_id = $this->visitor->get('user_id');
        $seller_order_log = $order_log_mod->find(
                array(
                    'conditions' => "seller_id = '$user_id' AND order_log_status = 0 AND operator_type='buyer'",
                    'join' => 'belongs_to_order',
                )
        );
        if(!empty($seller_order_log)){
            foreach ($seller_order_log as $key => $order) {
                $data['order_log_status'] = 1;
                $order_log_mod->edit($key, $data);
            }
        }
    }
    
    

    function index() {
        $this->auto_confirm_order();
        
        /* 获取订单列表 */
        $this->_get_orders();

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('order_manage'), 'index.php?app=seller_order', LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $type = (isset($_GET['type']) && $_GET['type'] != '') ? trim($_GET['type']) : 'all_orders';
        $this->_curitem('order_manage');
        $this->_curmenu($type);
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('order_manage'));
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
        /* 显示订单列表 */
        $this->display('seller_order.index.html');
    }

    /**
     *    查看订单详情
     *
     *    @author    Garbin
     *    @return    void
     */
    function view() {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

        $model_order = & m('order');
        $order_info = $model_order->findAll(array(
            'conditions' => "order_alias.order_id={$order_id} AND seller_id=" . $this->visitor->get('manage_store'),
            'join' => 'has_orderextm',
        ));
        $order_info = current($order_info);
        
        
        if (!$order_info) {
            $this->show_warning('no_such_order');
            return;
        }

        /* 团购信息 */
        if ($order_info['extension'] == 'groupbuy') {
            $groupbuy_mod = &m('groupbuy');
            $group = $groupbuy_mod->get(array(
                'join' => 'be_join',
                'conditions' => 'order_id=' . $order_id,
                'fields' => 'gb.group_id',
            ));
            $this->assign('group_id', $group['group_id']);
        }

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('order_manage'), 'index.php?app=seller_order', LANG::get('view_order'));

        /* 当前用户中心菜单 */
        $this->_curitem('order_manage');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('detail'));

        /* 调用相应的订单类型，获取整个订单详情数据 */
        $order_type = & ot($order_info['extension']);
        $order_detail = $order_type->get_order_detail($order_id, $order_info);
        $spec_ids = array();
        foreach ($order_detail['data']['goods_list'] as $key => $goods) {
            empty($goods['goods_image']) && $order_detail['data']['goods_list'][$key]['goods_image'] = Conf::get('default_goods_image');
            $spec_ids[] = $goods['spec_id'];
        }

        /* 查出最新的相应的货号 */
        $model_spec = & m('goodsspec');
        $spec_info = $model_spec->find(array(
            'conditions' => $spec_ids,
            'fields' => 'sku',
        ));
        foreach ($order_detail['data']['goods_list'] as $key => $goods) {
            $order_detail['data']['goods_list'][$key]['sku'] = $spec_info[$goods['spec_id']]['sku'];
        }

        $this->assign('order', $order_info);
        $this->assign($order_detail['data']);
        $this->display('seller_order.view.html');
    }
    
    
    /* 打印发货单 */
    function orderprint() {
        
        
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        $model_order = & m('order');
        $order_info = $model_order->get(array(
            'fields' => "*, order.add_time as order_add_time",
            'conditions' => "order_id={$order_id} AND seller_id=" . $this->visitor->get('manage_store'),
            'join' => 'belongs_to_store',
        ));
        if (!$order_info) {
            $this->show_warning('no_such_order');

            return;
        }

        /* 调用相应的订单类型，获取整个订单详情数据 */
        $order_type = & ot($order_info['extension']);
        $order_detail = $order_type->get_order_detail($order_id, $order_info);
        foreach ($order_detail['data']['goods_list'] as $key => $goods) {
            empty($goods['goods_image']) && $order_detail['data']['goods_list'][$key]['goods_image'] = Conf::get('default_goods_image');
        }
        $this->assign('order', $order_info);
        $this->assign($order_detail['data']);
        
        $this->display('seller_order.orderprint.html');
    }
    

    /**
     *    收到货款
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function received_pay() {
        list($order_id, $order_info) = $this->_get_valid_order_info(ORDER_PENDING);
        if (!$order_id) {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST) {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('seller_order.received_pay.html');
        } else {
            $model_order = & m('order');
            $model_order->edit(intval($order_id), array('status' => ORDER_ACCEPTED, 'pay_time' => gmtime()));
            if ($model_order->has_error()) {
                $this->pop_warning($model_order->get_error());

                return;
            }

            #TODO 发邮件通知
            /* 记录订单操作日志 */
            $order_log = & m('orderlog');
            $order_log->add(array(
                'order_id' => $order_id,
                'operator' => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_ACCEPTED),
                'remark' => $_POST['remark'],
                'log_time' => gmtime(),
                'operator_type'=>'seller',
            ));

            /* 发送给买家邮件，提示等待安排发货 */
            $model_member = & m('member');
            $buyer_info = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_offline_pay_success_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status' => Lang::get('order_accepted'),
                'actions' => array(
                    'cancel',
                    'shipped'
                ), //可以取消可以发货
            );

            $this->pop_warning('ok');
        }
    }

    /**
     *    货到付款的订单的确认操作
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function confirm_order() {
        list($order_id, $order_info) = $this->_get_valid_order_info(ORDER_SUBMITTED);
        if (!$order_id) {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST) {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->display('seller_order.confirm.html');
        } else {
            $model_order = & m('order');
            $model_order->edit($order_id, array('status' => ORDER_ACCEPTED));
            if ($model_order->has_error()) {
                $this->pop_warning($model_order->get_error());

                return;
            }

            /* 记录订单操作日志 */
            $order_log = & m('orderlog');
            $order_log->add(array(
                'order_id' => $order_id,
                'operator' => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_ACCEPTED),
                'remark' => $_POST['remark'],
                'log_time' => gmtime(),
                'operator_type'=>'seller',
            ));

            /* 发送给买家邮件，订单已确认，等待安排发货 */
            $model_member = & m('member');
            $buyer_info = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_confirm_cod_order_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status' => Lang::get('order_accepted'),
                'actions' => array(
                    'cancel',
                    'shipped'
                ), //可以取消可以发货
            );

            $this->pop_warning('ok');
            ;
        }
    }

    /**
     *    调整费用
     *
     *    @author    Garbin
     *    @return    void
     */
    function adjust_fee() {
        list($order_id, $order_info) = $this->_get_valid_order_info(array(ORDER_SUBMITTED, ORDER_PENDING));
        if (!$order_id) {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order = & m('order');
        $model_orderextm = & m('orderextm');
        $shipping_info = $model_orderextm->get($order_id);
        if (!IS_POST) {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
            $this->assign('shipping', $shipping_info);
            $this->display('seller_order.adjust_fee.html');
        } else {
            /* 配送费用 */
            $shipping_fee = isset($_POST['shipping_fee']) ? abs(floatval($_POST['shipping_fee'])) : 0;
            /* 折扣金额 */
            $goods_amount = isset($_POST['goods_amount']) ? abs(floatval($_POST['goods_amount'])) : 0;
            /* 订单实际总金额 */
            $order_amount = round($goods_amount + $shipping_fee, 2);
            if ($order_amount <= 0) {
                /* 若商品总价＋配送费用扣队折扣小于等于0，则不是一个有效的数据 */
                $this->pop_warning('invalid_fee');

                return;
            }
            $data = array(
                'goods_amount' => $goods_amount, //修改商品总价
                'order_amount' => $order_amount, //修改订单实际总金额
                'pay_alter' => 1    //支付变更
            );

            if ($shipping_fee != $shipping_info['shipping_fee']) {
                /* 若运费有变，则修改运费 */

                $model_extm = & m('orderextm');
                $model_extm->edit($order_id, array('shipping_fee' => $shipping_fee));
            }
            $model_order->edit($order_id, $data);

            if ($model_order->has_error()) {
                $this->pop_warning($model_order->get_error());

                return;
            }
            /* 记录订单操作日志 */
            $order_log = & m('orderlog');
            $order_log->add(array(
                'order_id' => $order_id,
                'operator' => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status($order_info['status']),
                'remark' => Lang::get('adjust_fee'),
                'log_time' => gmtime(),
                'operator_type'=>'seller',
            ));

            /* 发送给买家邮件通知，订单金额已改变，等待付款 */
            $model_member = & m('member');
            $buyer_info = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_adjust_fee_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'order_amount' => price_format($order_amount),
            );

            $this->pop_warning('ok');
        }
    }

    /**
     *    待发货的订单发货
     *
     *    @author    Garbin
     *    @return    void
     */
    function shipped() {
        list($order_id, $order_info) = $this->_get_valid_order_info(array(ORDER_ACCEPTED, ORDER_SHIPPED));
        if (!$order_id) {
            echo Lang::get('no_such_order');

            return;
        }
        $model_order = & m('order');
        if (!IS_POST) {
            /* 显示发货表单 */
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('order', $order_info);
			
			// 快递公司列表 tyioocom
			if($this->_check_express_plugin()){
				$this->assign('express_company',include(ROOT_PATH . '/data/express_company.inc.php'));
			}
			
            $this->display('seller_order.shipped.html');
        } else {
            if (!$_POST['invoice_no']) {
                $this->pop_warning('invoice_no_empty');

                return;
            }
            $edit_data = array('status' => ORDER_SHIPPED, 'invoice_no' => $_POST['invoice_no']);
 			// tyioocom express
			if($this->_check_express_plugin()){
				$edit_data['express_company'] = trim($_POST['express_company']);
			}           
            //未设置则默认为15天
            $auto_finished_day = intval(Conf::get('auto_finished_day'));
            $auto_finished_day = empty($auto_finished_day) ? 15 : $auto_finished_day;
            $edit_data['auto_finished_time'] = gmtime()+$auto_finished_day*3600*24;

            $is_edit = true;
            if (empty($order_info['invoice_no'])) {
                /* 不是修改发货单号 */
                $edit_data['ship_time'] = gmtime();
                $is_edit = false;
            }

            // 更新定单状态 简写到一句
            if ($order_info['payment_code'] == 'zjgl') {
                $epaylog = & m('epaylog')->edit('order_id=' . $order_id, array('states' => 30));
            }
            //更新定单状态 结束

            $model_order->edit(intval($order_id), $edit_data);
            if ($model_order->has_error()) {
                $this->pop_warning($model_order->get_error());

                return;
            }

            #TODO 发邮件通知
            /* 记录订单操作日志 */
            $order_log = & m('orderlog');
            $order_log->add(array(
                'order_id' => $order_id,
                'operator' => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_SHIPPED),
                'remark' => $_POST['remark'],
                'log_time' => gmtime(),
                'operator_type'=>'seller',
            ));


            /* 发送给买家订单已发货通知 */
            $model_member = & m('member');
            $buyer_info = $model_member->get($order_info['buyer_id']);
            $order_info['invoice_no'] = $edit_data['invoice_no'];
            $mail = get_mail('tobuyer_shipped_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            
            //发送短信给买家订单已发货通知 
            import('mobile_msg.lib');
            $mobile_msg = new Mobile_msg();
            $mobile_msg->send_msg_order($order_info,'send');
            
            
            $new_data = array(
                'status' => Lang::get('order_shipped'),
                'actions' => array(
                    'cancel',
                    'edit_invoice_no'
                ), //可以取消可以发货
            );
            if ($order_info['payment_code'] == 'cod') {
                $new_data['actions'][] = 'finish';
            }

            $this->pop_warning('ok');
        }
    }

    /**
     *    取消订单
     *
     *    @author    Garbin
     *    @return    void
     */
    function cancel_order() {
        /* 取消的和完成的订单不能再取消 */
        //list($order_id, $order_info)    = $this->_get_valid_order_info(array(ORDER_SUBMITTED, ORDER_PENDING, ORDER_ACCEPTED, ORDER_SHIPPED));
        $order_id = isset($_GET['order_id']) ? trim($_GET['order_id']) : '';
        if (!$order_id) {
            echo Lang::get('no_such_order');
        }
        $status = array(ORDER_SUBMITTED, ORDER_PENDING, ORDER_ACCEPTED, ORDER_SHIPPED);
        $order_ids = explode(',', $order_id);
        if ($ext) {
            $ext = ' AND ' . $ext;
        }

        $model_order = & m('order');
        /* 只有已发货的货到付款订单可以收货 */
        $order_info = $model_order->find(array(
            'conditions' => "order_id" . db_create_in($order_ids) . " AND seller_id=" . $this->visitor->get('manage_store') . " AND status " . db_create_in($status) . $ext,
        ));
        $ids = array_keys($order_info);
        if (!$order_info) {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST) {
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->assign('orders', $order_info);
            $this->assign('order_id', count($ids) == 1 ? current($ids) : implode(',', $ids));
            $this->display('seller_order.cancel.html');
        } else {
            $model_order = & m('order');
            foreach ($ids as $val) {
                $id = intval($val);
                $model_order->edit($id, array('status' => ORDER_CANCELED));
                if ($model_order->has_error()) {
                    //$_erros = $model_order->get_error();
                    //$error = current($_errors);
                    //$this->json_error(Lang::get($error['msg']));
                    //return;
                    continue;
                }

                /* 更新定单状态 开始**************************************************** */
                $row_epaylog = $this->mod_epaylog->getrow("select * from " . DB_PREFIX . "epaylog where order_id='$id' and type=".EPAY_SELLER);
                $money = $row_epaylog['money']; //定单价格
                $buy_user_id = $row_epaylog['to_id']; //买家ID
                $sell_user_id = $row_epaylog['user_id']; //卖家ID
                if ($row_epaylog['order_id'] == $id) {
                    $buy_money_row = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_id='$buy_user_id'");
                    $buy_money = $buy_money_row['money']; //买家的钱

                    $sell_money_row = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_id='$sell_user_id'");
                    $sell_money = $sell_money_row['money_dj']; //卖家的冻结资金

                    $new_buy_money = $buy_money + $money;
                    $new_sell_money = $sell_money - $money;
                    //更新数据
                    $this->mod_epay->edit('user_id=' . $buy_user_id, array('money' => $new_buy_money));
                    $this->mod_epay->edit('user_id=' . $sell_user_id, array('money_dj' => $new_sell_money));
                    //更新log为 定单已取消
                    $this->mod_epaylog->edit('order_id=' . $id, array('states' => 0));
                }
                /* 更新定单状态 结束*****************************************************

                  /* 加回订单商品库存 */
                $model_order->change_stock('+', $id);
                $cancel_reason = (!empty($_POST['remark'])) ? $_POST['remark'] : $_POST['cancel_reason'];
                /* 记录订单操作日志 */
                $order_log = & m('orderlog');
                $order_log->add(array(
                    'order_id' => $id,
                    'operator' => addslashes($this->visitor->get('user_name')),
                    'order_status' => order_status($order_info[$id]['status']),
                    'changed_status' => order_status(ORDER_CANCELED),
                    'remark' => $cancel_reason,
                    'log_time' => gmtime(),
                    'operator_type'=>'seller',
                ));

                /* 发送给买家订单取消通知 */
                $model_member = & m('member');
                $buyer_info = $model_member->get($order_info[$id]['buyer_id']);
                $mail = get_mail('tobuyer_cancel_order_notify', array('order' => $order_info[$id], 'reason' => $_POST['remark']));
                $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

                $new_data = array(
                    'status' => Lang::get('order_canceled'),
                    'actions' => array(), //取消订单后就不能做任何操作了
                );
            }
            $this->pop_warning('ok', 'seller_order_cancel_order');
        }
    }

    /**
     *    完成交易(货到付款的订单)
     *
     *    @author    Garbin
     *    @return    void
     */
    function finished() {
        list($order_id, $order_info) = $this->_get_valid_order_info(ORDER_SHIPPED, 'payment_code=\'cod\'');
        if (!$order_id) {
            echo Lang::get('no_such_order');

            return;
        }
        if (!IS_POST) {
            header('Content-Type:text/html;charset=' . CHARSET);
            /* 当前用户中心菜单 */
            $this->_curitem('seller_order');
            /* 当前所处子菜单 */
            $this->_curmenu('finished');
            $this->assign('_curmenu', 'finished');
            $this->assign('order', $order_info);
            $this->display('seller_order.finished.html');
        } else {
            $now = gmtime();
            $model_order = & m('order');
            $model_order->edit($order_id, array('status' => ORDER_FINISHED, 'pay_time' => $now, 'finished_time' => $now));
            if ($model_order->has_error()) {
                $this->pop_warning($model_order->get_error());

                return;
            }

            /* 记录订单操作日志 */
            $order_log = & m('orderlog');
            $order_log->add(array(
                'order_id' => $order_id,
                'operator' => addslashes($this->visitor->get('user_name')),
                'order_status' => order_status($order_info['status']),
                'changed_status' => order_status(ORDER_FINISHED),
                'remark' => $_POST['remark'],
                'log_time' => gmtime(),
                'operator_type'=>'seller',
            ));

            /* 更新累计销售件数 */
            $model_goodsstatistics = & m('goodsstatistics');
            $model_ordergoods = & m('ordergoods');
            $order_goods = $model_ordergoods->find("order_id={$order_id}");
            foreach ($order_goods as $goods) {
                $model_goodsstatistics->edit($goods['goods_id'], "sales=sales+{$goods['quantity']}");
            }


            /* 发送给买家交易完成通知，提示评论 */
            $model_member = & m('member');
            $buyer_info = $model_member->get($order_info['buyer_id']);
            $mail = get_mail('tobuyer_cod_order_finish_notify', array('order' => $order_info));
            $this->_mailto($buyer_info['email'], addslashes($mail['subject']), addslashes($mail['message']));

            $new_data = array(
                'status' => Lang::get('order_finished'),
                'actions' => array(), //完成订单后就不能做任何操作了
            );

            $this->pop_warning('ok');
        }
    }

    /**
     *    获取有效的订单信息
     *
     *    @author    Garbin
     *    @param     array $status
     *    @param     string $ext
     *    @return    array
     */
    function _get_valid_order_info($status, $ext = '') {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id) {

            return array();
        }
        if (!is_array($status)) {
            $status = array($status);
        }

        if ($ext) {
            $ext = ' AND ' . $ext;
        }

        $model_order = & m('order');
        /* 只有已发货的货到付款订单可以收货 */
        $order_info = $model_order->get(array(
            'conditions' => "order_id={$order_id} AND seller_id=" . $this->visitor->get('manage_store') . " AND status " . db_create_in($status) . $ext,
        ));
        if (empty($order_info)) {

            return array();
        }

        return array($order_id, $order_info);
    }

    /**
     *    获取订单列表
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_orders() {
        $page = $this->_get_page();
        $model_order = & m('order');

        !$_GET['type'] && $_GET['type'] = 'all_orders';

        $conditions = '';

        // 团购订单
        if (!empty($_GET['group_id']) && intval($_GET['group_id']) > 0) {
            $groupbuy_mod = &m('groupbuy');
            $order_ids = $groupbuy_mod->get_order_ids(intval($_GET['group_id']));
            $order_ids && $conditions .= ' AND order_alias.order_id' . db_create_in($order_ids);
        }

        $conditions .= $this->_get_query_conditions(array(
            array(//按订单状态搜索
                'field' => 'status',
                'name' => 'type',
                'handler' => 'order_status_translator',
            ),
            array(//按买家名称搜索
                'field' => 'buyer_name',
                'equal' => 'LIKE',
            ),
            array(//按下单时间搜索,起始时间
                'field' => 'add_time',
                'name' => 'add_time_from',
                'equal' => '>=',
                'handler' => 'gmstr2time',
            ),
            array(//按下单时间搜索,结束时间
                'field' => 'add_time',
                'name' => 'add_time_to',
                'equal' => '<=',
                'handler' => 'gmstr2time_end',
            ),
            array(//按订单号
                'field' => 'order_sn',
            ),
        ));

        /* 查找订单 */
        $orders = $model_order->findAll(array(
            'conditions' => "seller_id=" . $this->visitor->get('manage_store') . "{$conditions}",
            'count' => true,
            'join' => 'has_orderextm',
            'limit' => $page['limit'],
            'order' => 'add_time DESC',
            'include' => array(
                'has_ordergoods', //取出商品
            ),
        ));

        // psmb
        $member_mod = & m('member');
        $model_spec = & m('goodsspec');

        $refund_mod =& m('refund');
        foreach ($orders as $key1 => $order) {
            foreach ($order['order_goods'] as $key2 => $goods) {
                empty($goods['goods_image']) && $orders[$key1]['order_goods'][$key2]['goods_image'] = Conf::get('default_goods_image');

                /* 是否申请过退款 */
                $refund = $refund_mod->get(array('conditions' => 'order_id=' . $goods['order_id'] . ' and goods_id=' . $goods['goods_id'] . ' and spec_id=' . $goods['spec_id'], 'fields' => 'status,order_id'));
                if ($refund) {
                    $orders[$key1]['order_goods'][$key2]['refund_status'] = $refund['status'];
                    $orders[$key1]['order_goods'][$key2]['refund_id'] = $refund['refund_id'];
                }
                
                $spec = $model_spec->get(array('conditions' => 'spec_id=' . $goods['spec_id'], 'fields' => 'sku'));
                $orders[$key1]['order_goods'][$key2]['sku'] = $spec['sku'];
            }
            // psmb
            $orders[$key1]['goods_quantities'] = count($order['order_goods']);
            $orders[$key1]['buyer_info'] = $member_mod->get(array('conditions' => 'user_id=' . $order['buyer_id'], 'fields' => 'real_name,im_qq,im_aliww,im_msn'));
        }

        $page['item_count'] = $model_order->getCount();
        $this->_format_page($page);
        $this->assign('types', array('all' => Lang::get('all_orders'),
            'pending' => Lang::get('pending_orders'),
            'submitted' => Lang::get('submitted_orders'),
            'accepted' => Lang::get('accepted_orders'),
            'shipped' => Lang::get('shipped_orders'),
            'finished' => Lang::get('finished_orders'),
            'canceled' => Lang::get('canceled_orders')));
        $this->assign('type', $_GET['type']);
        $this->assign('orders', $orders);
        $this->assign('page_info', $page);
    }

    /* 三级菜单 */

    function _get_member_submenu() {
        $array = array(
            array(
                'name' => 'all_orders',
                'url' => 'index.php?app=seller_order&amp;type=all_orders',
            ),
            array(
                'name' => 'pending',
                'url' => 'index.php?app=seller_order&amp;type=pending',
            ),
            array(
                'name' => 'submitted',
                'url' => 'index.php?app=seller_order&amp;type=submitted',
            ),
            array(
                'name' => 'accepted',
                'url' => 'index.php?app=seller_order&amp;type=accepted',
            ),
            array(
                'name' => 'shipped',
                'url' => 'index.php?app=seller_order&amp;type=shipped',
            ),
            array(
                'name' => 'finished',
                'url' => 'index.php?app=seller_order&amp;type=finished',
            ),
            array(
                'name' => 'canceled',
                'url' => 'index.php?app=seller_order&amp;type=canceled',
            ),
        );
        return $array;
    }
    
    
    
    

    //自动收货
    function auto_confirm_order() {
        //获取当前 已发货的 ORDER_SHIPPED   并且支付方式  为  payment_code=zjgl    auto_finished_time 大于系统设置的数值
        $model_order = & m('order');
        
        $conditions = "payment_code ='zjgl' AND status=" . ORDER_SHIPPED . " AND auto_finished_time<" . gmtime()." AND seller_id=" . $this->visitor->get('manage_store') ;
        $orders = $model_order->findAll(array(
            'conditions' => $conditions,
        ));
        if (!empty($orders)) {
            foreach ($orders as $key => $order_info) {
                $this->auto_confirm($order_info);
            }
        }
		
		 $conditions = "  status=11  AND seller_id=" . $this->visitor->get('manage_store') ;
        $orders = $model_order->findAll(array(
            'conditions' => $conditions,
        ));
		
	   $now= 60*60*24 ;
	   foreach($orders as $key=>$val)
	   {
	     if((gmtime()-$val['add_time']) > $now)
		 {
		
		  $model_order->edit($val['order_id'],'status=0');
		 }  
	   
	   
	   }
		
		
    }

    function auto_confirm($order_info) {
        $order_id = $order_info['order_id'];
        $model_order = & m('order');
        $model_order->edit($order_id, array('status' => ORDER_FINISHED, 'finished_time' => gmtime()));
        /* 记录订单操作日志 */
        $order_log = & m('orderlog');
        $remark = '确认收货超时,系统自动确认收货';
        $order_log->add(array(
            'order_id' => $order_id,
            'operator' => 'system',
            'order_status' => order_status($order_info['status']),
            'changed_status' => order_status(ORDER_FINISHED),
            'remark' => $remark,
            'log_time' => gmtime(),
            'operator_type' => 'buyer',
        ));


        /* 更新定单状态 开始***************************************************** */
        $this->mod_epay = & m('epay');
        $this->mod_epaylog = & m('epaylog');
        $epaylog_row = $this->mod_epaylog->getrow("select * from " . DB_PREFIX . "epaylog where order_id='$order_id' and type=" . EPAY_BUY);
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
                'money' => $money,
                'complete' => 1,
                'states' => 40,
            );
            $new_seller_epaylog = array(
                'money' => $money,
                'complete' => 1,
                'states' => 40,
            );
            $this->mod_epay->edit('user_id=' . $sell_user_id, $new_money_array);
            $this->mod_epaylog->edit("order_id={$order_id} AND user_id={$sell_user_id}", $new_seller_epaylog);
            $this->mod_epaylog->edit("order_id={$order_id} AND user_id={$buyer_user_id}", $new_buyer_epaylog);
        }
        /* 更新定单状态 结束***************************************************** */


        /* 更新累计销售件数 */
        $model_goodsstatistics = & m('goodsstatistics');
        $model_ordergoods = & m('ordergoods');
        $order_goods = $model_ordergoods->find("order_id={$order_id}");
        foreach ($order_goods as $goods) {
            $model_goodsstatistics->edit($goods['goods_id'], "sales=sales+{$goods['quantity']}");
        }
		
		
		 /*用户确认收货后 扣除商城佣金*/
            import('epay.lib');
            $epay=new epay();
            $epay->trade_charges($order_info);
		
		 /*交易成功后,推荐者可以获得佣金  BEGIN*/
            import('tuijian.lib');
            $tuijian=new tuijian();
            $tuijian->do_tuijian($order_info);
            /*交易成功后,推荐者可以获得佣金  END*/

        /* 用户确认收货后 获得积分 */
        import('integral.lib');
        $integral = new Integral();
        $integral->change_integral_buy($order_info['buyer_id'], $order_info['goods_amount']);

        //卖家确认收货 发送短信给卖家
        import('mobile_msg.lib');
        $mobile_msg = new Mobile_msg();
        $mobile_msg->send_msg_order($order_info, 'check');
    }
    
    
    /**
     *    给买家评价
     *
     */
    function evaluate()
    {
        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
        if (!$order_id)
        {
            $this->show_warning('no_such_order');

            return;
        }

        /* 验证订单有效性 */
        $model_order =& m('order');
        $order_info  = $model_order->get("order_id={$order_id} AND seller_id=" . $this->visitor->get('manage_store'));
        if (!$order_info)
        {
            $this->show_warning('no_such_order');

            return;
        }
        if ($order_info['status'] != ORDER_FINISHED)
        {
            /* 不是已完成的订单，无法评价 */
            $this->show_warning('cant_evaluate');

            return;
        }
        if ($order_info['store_evaluation_status'] != 0)
        {
            /* 已评价的订单 */
            $this->show_warning('already_evaluate');

            return;
        }
        $model_ordergoods =& m('ordergoods');

        if (!IS_POST)
        {
            /* 显示评价表单 */
            /* 获取订单商品 */
            $goods_list = $model_ordergoods->find("order_id={$order_id}");
            foreach ($goods_list as $key => $goods)
            {
                empty($goods['goods_image']) && $goods_list[$key]['goods_image'] = Conf::get('default_goods_image');
            }
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                             LANG::get('my_order'), 'index.php?app=buyer_order',
                             LANG::get('seller_evaluate'));
            $this->assign('goods_list', $goods_list);
            $this->assign('order', $order_info);

            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('credit_evaluate'));
            $this->display('seller_order.evaluate.html');
        }
        else
        {
            $seller_evaluations = array();
            /* 写入评价 */
            foreach ($_POST['seller_evaluations'] as $rec_id => $seller_evaluation)
            {
                if ($seller_evaluation['seller_evaluation'] <= 0 || $seller_evaluation['seller_evaluation'] > 3)
                {
                    $this->show_warning('evaluation_error');

                    return;
                }
                switch ($seller_evaluation['seller_evaluation'])
                {
                    case 3:
                        $seller_credit_value = 1;
                    break;
                    case 1:
                        $seller_credit_value = -1;
                    break;
                    default:
                        $seller_credit_value = 0;
                    break;
                }
                $seller_evaluations[intval($rec_id)] = array(
                    'seller_evaluation'    => $seller_evaluation['seller_evaluation'],
                    'seller_comment'       => $seller_evaluation['seller_comment'],
                    'seller_credit_value'  => $seller_credit_value
                );
            }
            foreach ($seller_evaluations as $rec_id => $seller_evaluation)
            {
                $model_ordergoods->edit("rec_id={$rec_id} AND order_id={$order_id}", $seller_evaluation);
            }

            /* 更新订单评价状态 */
            $model_order->edit($order_id, array(
                'seller_evaluation_status' => 1,
                'seller_evaluation_time'   => gmtime()
            ));

            //更新买家信用度及好评率
            $model_member =& m('member');
            $model_member->edit($order_info['buyer_id'], array(
                'buyer_credit_value'  => $this->_recount_credit_value($order_info['buyer_id']),
                'buyer_praise_rate'   => $this->_recount_praise_rate($order_info['buyer_id'])
            ));

            $this->show_message('evaluate_successed',
                'back_list', 'index.php?app=seller_order');
        }
    }
    
    //计算买家总分
    function _recount_credit_value($buyer_id){
        $buyer_credit_value = 0;
        $model_ordergoods =& m('ordergoods');
        /* 找出所有is_valid为1的商品评价记录，计算他们的credit_value的和 */
        $info = $model_ordergoods->get(array(
            'join'          => 'belongs_to_order',
            'conditions'    => "buyer_id={$buyer_id} AND seller_evaluation_status=1 AND is_valid = 1",
            'fields'        => 'SUM(seller_credit_value) AS seller_credit_value',
            'index_key'     => false,   /* 不需要索引 */
        ));
        $buyer_credit_value = $info['seller_credit_value'];

        return $buyer_credit_value;
    }
    //计算买家好评率
    function _recount_praise_rate($buyer_id)
    {
        $buyer_praise_rate = 0.00;
        $model_ordergoods =& m('ordergoods');

        /* 找出所有is_valid为1的商品中的商品评价记录总数 */
        $info  = $model_ordergoods->get(array(
            'join'          => 'belongs_to_order',
            'conditions'    => "buyer_id={$buyer_id} AND seller_evaluation_status=1 AND is_valid=1",
            'fields'        => 'COUNT(*) as evaluation_count',
            'index_key'     => false,   /* 不需要索引 */
        ));
        $evaluation_count = $info['evaluation_count'];
        if (!$evaluation_count)
        {
            return $praise_count;
        }

        /* 找出所有的evaluation为3的记录总数 */
        $info = $model_ordergoods->get(array(
            'join'          => 'belongs_to_order',
            'conditions'    => "buyer_id={$buyer_id} AND seller_evaluation_status=1 AND is_valid=1 AND seller_evaluation=3",
            'fields'        => 'COUNT(*) as praise_count',
            'index_key'     => false,   /* 不需要索引 */
        ));
        $praise_count = $info['praise_count'];
        /* 计算好评数占总数的百分比 */
        $buyer_praise_rate = round(($praise_count / $evaluation_count), 4) * 100;

        return $buyer_praise_rate;
    }
    
    

}

?>
