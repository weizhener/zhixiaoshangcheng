<?php

class My_couponApp extends MemberbaseApp {

    var $_user_mod;
    var $_store_mod;
    var $_coupon_mod;
    var $_couponsn_mod;

    function __construct() {
        $this->My_couponApp();
    }

    function My_couponApp() {
        parent::__construct();
        $this->_user_mod = & m('member');
        $this->_store_mod = & m('store');
        $this->_coupon_mod = & m('coupon');
        $this->_couponsn_mod = & m('couponsn');
    }

    function index() {
        $page = $this->_get_page(10);
        $coupons = $this->_couponsn_mod->find(
                array(
                    'conditions' => 'user_id = ' . $this->visitor->get('user_id'),
                    'limit' => $page['limit'],
                    'count' => true,
                    'join' => 'belongs_to_coupon,belong_to_store',
                )
        );
        $page['item_count'] = $this->_couponsn_mod->getCount();
        foreach ($coupons as $key => $coupon) {
            $time = gmtime();
            if (($coupon['remain_times'] > 0) && ($coupon['end_time'] == 0 || $coupon['end_time'] > $time)) {
                $coupons[$key]['valid'] = 1;
            }
            $store = $this->_store_mod->get($coupon['store_id']);
            $coupons[$key]['store_name'] = $store['store_name'];
            
            
        }
        $this->_format_page($page);
        $this->assign('page_info', $page);

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
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_coupon'), 'index.php?app=my_coupon', LANG::get('coupon_list'));
        $this->_curitem('my_coupon');

        $this->_curmenu('coupon_list');

        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('coupon_list'));

        $this->assign('coupons', $coupons);
        $this->display('my_coupon.index.html');
    }

    function bind() {
        if (!IS_POST) {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->display('my_coupon.form.html');
        } else {
            $coupon_sn = isset($_POST['coupon_sn']) ? trim($_POST['coupon_sn']) : '';
            if (empty($coupon_sn)) {
                $this->pop_warning('coupon_sn_not_empty');
                exit;
            }
            $coupon = $this->_couponsn_mod->get(array('conditions' => 'coupon_sn = ' . $coupon_sn));
            if (empty($coupon)) {
                $this->pop_warning('involid_data');
                exit;
            }
            $this->_couponsn_mod->edit('coupon_sn=' . $coupon_sn, array('user_id' => $this->visitor->get('user_id')));
            $this->pop_warning('ok', 'my_coupon_bind');
            exit;
        }
    }

    function drop() {
        if (!isset($_GET['id']) && empty($_GET['id'])) {
            $this->show_warning("involid_data");
            exit;
        }
        $ids = explode(',', trim($_GET['id']));

        foreach ($ids as $key => $id) {
            $this->_couponsn_mod->drop('coupon_sn=' . $id);
        }

        if ($this->_couponsn_mod->has_error()) {
            $this->show_warning($this->_couponsn_mod->get_error());
            exit;
        }
        $this->show_message('drop_ok', 'back_list', 'index.php?app=my_coupon');
    }

    function _get_member_submenu() {
        $menus = array(
            array(
                'name' => 'coupon_list',
                'url' => 'index.php?app=my_coupon',
            ),
        );
        return $menus;
    }

    function add() {
        $coupon_id = empty($_GET['coupon_id']) ? 0 : intval($_GET['coupon_id']);

        //获取当前是否有足够领取的优惠券
        $coupon = $this->_couponsn_mod->get(array('conditions' => 'coupon_id = ' . $coupon_id . ' AND user_id=0'));
        if (!$coupon) {
            $this->json_error('没有足够的优惠券');
            return;
        }

        //查看当前用户是否领取了优惠券
        $result = $this->_couponsn_mod->get(array('conditions' => 'coupon_id = ' . $coupon_id . ' AND user_id=' . $this->visitor->get('user_id')));
        
        if ($result) {
            $this->json_error('您已领取了此优惠券');
            return;
        } else {
            $this->_couponsn_mod->edit('coupon_sn=' . $coupon['coupon_sn'], array('user_id' => $this->visitor->get('user_id')));
            $this->json_result('领取成功');
        }
    }

}

?>