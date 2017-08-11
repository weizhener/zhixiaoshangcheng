<?php

class Export_excelApp extends StoreadminbaseApp {

    function index() {

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('order_manage'), 'index.php?app=seller_order', LANG::get('order_list'));

        /* 当前用户中心菜单 */
        $type = (isset($_GET['type']) && $_GET['type'] != '') ? trim($_GET['type']) : 'all_orders';
        $this->_curitem('export_excel');
        $this->_curmenu($type);
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('order_manage'));
        $this->assign('ztype', $this->get_options_type());
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

        $this->assign('orders', $orders);
        $this->display('export_order.html');
    }

    function export() {
        $model_order = & m('order');

        $type = (isset($_GET['type']) && $_GET['type'] != '') ? trim($_GET['type']) : 'all_orders';

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
            'order' => 'add_time DESC',
            'include' => array(
                'has_ordergoods', //取出商品
            ),
        ));

        import('excelwriter.lib');
        $excel = new ExcelWriter('utf8', 'toexcel');
        if (!$orders) {
            $this->show_warning('无数据');
            return;
        }

        $cols = array();
        $cols_item = array();
        $cols_item[] = '订单编号';
        $cols_item[] = '店铺名称';
        $cols_item[] = '消费者名称';
        $cols_item[] = '消费者邮箱';
        $cols_item[] = '订单状态';
        $cols_item[] = '下单时间';
        $cols_item[] = '支付方式';
        $cols_item[] = '付款时间';
        $cols_item[] = '发货时间';
        $cols_item[] = '快递单号';
        $cols_item[] = '完成时间';
        $cols_item[] = '商品总价';
        $cols_item[] = '折扣';
        $cols_item[] = '订单总价';
        $cols_item[] = '付款留言';
        $cols_item[] = '收货地区';
        $cols_item[] = '收货地址';
        $cols_item[] = '邮编';
        $cols_item[] = '电话';
        $cols_item[] = '手机';
        $cols_item[] = '快递方式';
        $cols_item[] = '快递费用';

        $cols[] = $cols_item;

        if (is_array($orders) && count($orders) > 0) {
            foreach ($orders as $k => $v) {

                $tmp_col = array();
                $tmp_col[] = $v['order_sn'];
                $tmp_col[] = $v['seller_name'];
                $tmp_col[] = $v['buyer_name'];
                $tmp_col[] = $v['buyer_email'];
                $tmp_col[] = $this->get_status($v['status']);
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['add_time']);
                $tmp_col[] = $v['payment_name'];
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['pay_time']);
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['ship_time']);
                $tmp_col[] = $v['invoice_no'];
                $tmp_col[] = local_date('Y-m-d H:i:s', $v['finished_time']);
                $tmp_col[] = $v['goods_amount'];
                $tmp_col[] = $v['discount'];
                $tmp_col[] = $v['order_amount'];
                $tmp_col[] = $v['postscript'];
                $tmp_col[] = $v['region_name'];
                $tmp_col[] = $v['address'];
                $tmp_col[] = $v['zipcode'];
                $tmp_col[] = $v['phone_tel'];
                $tmp_col[] = $v['phone_mob'];
                $tmp_col[] = $v['shipping_name'];
                $tmp_col[] = $v['shipping_fee'];
                $cols[] = $tmp_col;
            }
        }
        $excel->add_array($cols);
        $excel->output();
    }

    function get_status($status) {

        switch ($status) {
            case 0:
                $msg = '已取消';
                break;
            case 10:
                $msg = '发货中';
                break;
            case 11:
                $msg = '待付款';
                break;
            case 20:
                $msg = '待发货';
                break;
            case 30:
                $msg = '已发货';
                break;
            case 40:
                $msg = '交易成功';
                break;

            default:
                # code...
                break;
        }
        return $msg;
    }

    function get_options_type() {
        return array(
            'pending' => '待付款',
            'submitted' => '已提交',
            'accepted' => '待发货',
            'shipped' => '已发货',
            'finished' => '已完成',
            'canceled' => '已取消',
        );
    }

    function _get_member_submenu() {
        $array = array(
            array(
                'name' => 'all_orders',
                'url' => 'index.php?app=seller_order&amp;type=all_orders',
            ),
        );
        return $array;
    }

}

?>