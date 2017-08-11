<?php

class CouponApp extends MallbaseApp
{
    
    var $_store_mod;
    var $_coupon_mod;
    var $_couponsn_mod;
    function __construct()
    {
        $this->CouponApp();
    }
    function CouponApp()
    {
        parent::__construct();
        $this->_store_mod =& m('store');
        $this->_coupon_mod =& m('coupon');
        $this->_couponsn_mod =& m('couponsn');
    }
    
    function index()
    {
        $page = $this->_get_page(10);
        $coupons = $this->_coupon_mod->find(array(
            'fields' => 'coupon.*,s.store_name', 
            'conditions' => 'if_issue = 1 AND coupon.end_time > '.gmtime(),
            'join'=>'belong_to_store',
            'limit' => $page['limit'],
            'count' => true,
        ));
        foreach ($coupons as $key => $coupon) {
            if(empty($coupon['coupon_bg'])){
                $coupons[$key]['coupon_bg'] = Conf::get('default_coupon_image');
            }
        }
        
        $page['item_count'] = $this->_coupon_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        
        
        $this->assign('coupons', $coupons);
        
        /* 当前位置 */
        $_curlocal=array(
            array(
                'text'  => Lang::get('index'),
                'url'   => 'index.php',
            ),
            array(
                'text'  => Lang::get('coupon'),
                'url'   => '',
            ),
        );
        $this->assign('_curlocal',$_curlocal);
        
        $this->display('coupon.index.html');
    }
    
    
    function view()
    {
        $coupon_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if(!$coupon_id){
            $this->show_warning("error");
            exit;
        }
        $coupon = $this->_coupon_mod->get(array('conditions' => 'coupon_id = ' . $coupon_id));
        if(empty($coupon)){
            $this->show_warning("error");
            exit;
        }
        
        //获取可领取的优惠卷
        $sql1 = "SELECT COUNT(*) FROM {$this->_couponsn_mod->table} WHERE user_id = 0 AND remain_times>0 AND coupon_id=".$coupon['coupon_id'];
        $coupon['not_received'] = $this->_couponsn_mod->getOne($sql1);
        $sql2 = "SELECT COUNT(*) FROM {$this->_couponsn_mod->table} WHERE user_id != 0 AND remain_times>0 AND coupon_id=".$coupon['coupon_id'];
        $coupon['hava_received'] = $this->_couponsn_mod->getOne($sql2);
        
        $url = SITE_URL . '/index.php?app=coupon%26act=view%26id=' . $coupon['coupon_id'];
        $coupon['scan_code'] = '<img src=' . SITE_URL . '/index.php?app=qrcode&url=' . $url . '/>';
        
        $this->assign('coupon', $coupon);
        
        $store = $this->_store_mod->get($coupon['store_id']);
        $this->assign('store', $store);
        
        
        /* 当前位置 */
        $_curlocal=array(
            array(
                'text'  => Lang::get('index'),
                'url'   => 'index.php',
            ),
            array(
                'text'  => Lang::get('coupon'),
                'url'   => 'index.php?app=coupon',
            ),
            array(
                'text'  => $coupon['coupon_name'],
                'url'   => '',
            ),
        );
        $this->assign('_curlocal',$_curlocal);
        
        $this->display('coupon.view.html');
    }
    
    
    
    
    
}
?>
