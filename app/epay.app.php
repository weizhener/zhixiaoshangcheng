<?php



class EpayApp extends MemberbaseApp {



    

    function EpayApp() {

        parent::__construct();

        $this->mod_epay = & m('epay');

        $this->mod_epaylog = & m('epaylog');

        $this->mod_epay_bank = & m('epay_bank');

        $this->mod_order = & m('order');

    }

    function jinhua(){
		
	}

    function exits() {

        //执行关闭页面	

        echo "<script language='javascript'>window.opener=null;window.close();</script>";

    }



    function logall() {

        $user_id = $this->visitor->get('user_id');

        /* 当前用户中心菜单 */

        $this->_curitem('epay');

        $this->_curmenu('epay_logall');

        



        $conditions = $this->_get_query_conditions(array(

            array(

                'field' => 'add_time',

                'name' => 'add_time_from',

                'equal' => '>=',

                'handler' => 'gmstr2time',

            ), array(

                'field' => 'add_time',

                'name' => 'add_time_to',

                'equal' => '<=',

                'handler' => 'gmstr2time_end',

            ),

            array(//按订单号

                'field' => 'order_sn',

                'equal' => 'LIKE',

                'name' => 'order_sn',

            ), 

            array(

                'field' => 'type',

                'equal' => '=',

                'name' => 'type',

                'type' => 'numeric',

            ),

            array(

                'field' => 'complete',

                'equal' => '=',

                'name' => 'complete',

                'type' => 'numeric',

            ),

            

        ));

        $page = $this->_get_page(10);

        $epaylog_list = $this->mod_epaylog->find(array(

            'conditions' => 'user_id=' . $this->visitor->get('user_id')  . $conditions,

            'limit' => $page['limit'],

            'order' => "id desc",

            'count' => true));

        $page['item_count'] = $this->mod_epaylog->getCount();

        $this->_format_page($page);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件

        

        

        $this->assign('page_info', $page);

        $this->assign('epaylog_list', $epaylog_list);



        $this->assign('epay_type_list', array(

            EPAY_ADMIN => Lang::get('epay_admin'), //手工操作

            EPAY_BUY => Lang::get('epay_buy'), //购买商品

            EPAY_SELLER => Lang::get('epay_seller'), //出售商品

            EPAY_IN => Lang::get('epay_in'), //账户转入

            EPAY_OUT => Lang::get('epay_out'), //账户转出

            EPAY_CZ => Lang::get('epay_cz'), //账户充值

            EPAY_TX => Lang::get('epay_tx'), //账户提现

            EPAY_REFUND_IN => Lang::get('epay_refund_in'), //账户退款收入,通常为买家退款成功 得到退款

            EPAY_REFUND_OUT => Lang::get('epay_refund_out'), //账户退款收入,通常为卖家退款成功 扣除退款

            EPAY_TUIJIAN_BUYER => Lang::get('epay_tuijian_buyer'),  // 用户推荐注册,注册者购买产品，推荐人会获得佣金，店铺会损失佣金。

            EPAY_TUIJIAN_SELLER=> Lang::get('epay_tuijian_seller'), // 用户推荐注册,注册者成为店主，卖出产品推荐人会获得佣金，店主会损失佣金。

            EPAY_TRADE_CHARGES=> Lang::get('epay_trade_charges'), // 扣除卖家交易佣金
			
			EPAY_KAIDIAN=> '开通店铺', // 扣除卖家交易佣金

        ));

        

        $this->assign('complete_list', array(

            0 => Lang::get('uncomplete'), 

            1 => Lang::get('oncomplete'), 

        ));

        

        

        $this->import_resource(array(

            'script' => array(

                array(

                    'path' => 'jquery.ui/jquery.ui.js',

                    'attr' => '',

                ),

            ),

            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css',

        ));

        $this->display('epay.logall.html');

    }







    //在线充值

    function czlist() {

        $user_id = $this->visitor->get('user_id');

        $this->_curitem('epay');

        $this->_curmenu('epay_czlist');



        $this->assign('epay_alipay_enabled', Conf::get('epay_alipay_enabled'));

        $this->assign('epay_chinabank_enabled', Conf::get('epay_chinabank_enabled'));

        $this->assign('epay_tenpay_enabled', Conf::get('epay_tenpay_enabled'));

        $this->assign('epay_wxjs_enabled', Conf::get('epay_wxjs_enabled'));

        $this->assign('epay_wxnative_enabled', Conf::get('epay_wxnative_enabled'));

    $this->assign('epay_bitebi_enabled', Conf::get('epay_bitebi_enabled'));

        $epay = $this->mod_epay->get("user_id=$user_id");

        $this->assign('epay', $epay);

        

        $this->assign('epay_offline_info', Conf::get('epay_offline_info'));



        $this->display('epay.czlist.html');

    }





    //提现申请

    function withdraw() {

        $user_id = $this->visitor->get('user_id');



        if (!IS_POST) {

            $this->_curitem('epay');

            $this->_curmenu('epay_withdraw');



            $epay = $this->mod_epay->get("user_id=$user_id");

            

            if(empty($epay['zf_pass'])){

                $this->show_message('epay_editpassword', 'epay_editpassword', 'index.php?app=epay&act=editpassword');

                return;

            }

            

            $this->assign('epay', $epay);

            

            //获取当前用户设置的银行卡信息

            $bank_list = $this->mod_epay_bank->find(array('conditions'=>'user_id='.$this->visitor->get('user_id')));

            $this->assign('bank_list', $bank_list);

            

            $this->display('epay.withdraw.html');

        } else {

            $tx_money = trim($_POST['tx_money']);

            $money_row = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_id='$user_id'");

            

            $post_zf_pass = trim($_POST['post_zf_pass']);

            if (empty($post_zf_pass)) {

                $this->show_warning('cuowu_zhifumimabunengweikong');

                return;

            }

            $md5zf_pass = md5($post_zf_pass);

            if ($money_row['zf_pass'] != $md5zf_pass) {

                $this->show_warning('cuowu_zhifumimayanzhengshibai');

                return;

            }

            //检测用户的银行信息

            //

            if (empty($tx_money)) {

                $this->show_warning('cuowu_tixianjinebunengweikong');

                return;

            }

            if (preg_match("/[^0.-9]/", $tx_money)) {

                $this->show_warning('cuowu_nishurudebushishuzilei');

                return;

            }

            if ($money_row['money'] < $tx_money) {

                $this->show_warning('duibuqi_zhanghuyuebuzu');

                return;

            }

            //通过验证 开始操作数据

            $newmoney = $money_row['money'] - $tx_money;

            $newmoney_dj = $money_row['money_dj'] + $tx_money;



            //获取提交的bank_id

            $bank_id = $_POST['bank_id'];

            $bank = $this->mod_epay_bank->get('bank_id='.$bank_id.' AND user_id='.$this->visitor->get('user_id'));

            $bank_str = '开户银行:'.$bank['bank_name'].',开户行地址:'.$bank['open_bank'].',户名:'.$bank['account_name'].',卡号:'.$bank['bank_num'];

            

            

            //添加日志

            $order_sn = date('YmdHis',gmtime()+8*3600).rand(1000,9999);

            $log_text = $this->visitor->get('user_name') . Lang::get('tixianshenqingjine') . $tx_money . Lang::get('yuan').$bank_str;

            $add_epaylog = array(

                'user_id' => $user_id,

                'user_name' => $this->visitor->get('user_name'),

                'order_sn ' => '70' . $order_sn,

                'add_time' => gmtime(),

                'type' => EPAY_TX, //提现

                'money_flow'=>'outlay',

                'money' => $tx_money,

                'log_text' => $log_text,

                'states' => 70, //待审核																			

            );

            $this->mod_epaylog->add($add_epaylog);

            $edit_mymoney = array(

                'money_dj' => $newmoney_dj,

                'money' => $newmoney,

            );

            $this->mod_epay->edit('user_id=' . $user_id, $edit_mymoney);

            $this->show_message('tixian_chenggong');

            return;

        }

    }

//余额转帐

    function out() {

        $to_user = trim($_POST['to_user']);

        $to_money = trim($_POST['to_money']);

        $user_id = $this->visitor->get('user_id');

        if (!IS_POST) {

            /* 当前用户中心菜单 */

            $this->_curitem('epay');

            $this->_curmenu('epay_out');

            $epay = $this->mod_epay->get("user_id=$user_id");

            $this->assign('epay', $epay);

            $this->display('epay.out.html');

        } else {//检测有提交

            if (preg_match("/[^0.-9]/", $to_money)) {

                $this->show_warning('cuowu_nishurudebushishuzilei');

                return;

            }





            $to_row = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_name='$to_user'");

            $to_user_id = $to_row['user_id'];

            $to_user_name = $to_row['user_name'];

            $to_user_money = $to_row['money'];



            if ($to_user_id == $user_id) {

                $this->show_warning('cuowu_bunenggeizijizhuanzhang');

                return;

            }



            if (empty($to_user_id)) {

                $this->show_warning('cuowu_mubiaoyonghubucunzai');

                return;

            }

            $row_epay = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_id='$user_id'");

            $user_money = $row_epay['money'];

            $user_zf_pass = $row_epay['zf_pass'];

            $zf_pass = md5(trim($_POST['zf_pass']));

            if ($user_zf_pass != $zf_pass) {

                $this->show_warning('cuowu_zhifumimayanzhengshibai');

                return;

            }

            $order_sn = "40" . date('YmdHis',gmtime()+8*3600).rand(1000,9999);

            if ($user_money < $to_money) {

                $this->show_warning('cuowu_zhanghuyuebuzu');

                return;

            } else {

                //添加日志

                $log_text = $this->visitor->get('user_name') . Lang::get('gei') . $to_user . Lang::get('zhuanchujine') . $to_money . Lang::get('yuan');



                $add_epaylog = array(

                    'user_id' => $this->visitor->get('user_id'),

                    'user_name' => $this->visitor->get('user_name'),

                    'to_id' => $to_user_id,

                    'to_name' => $to_user_name,

                    'order_sn' => $order_sn,

                    'add_time' => gmtime(),

                    'type' => EPAY_OUT, //转出	

                    'money_flow' => 'outlay',

                    'money' => $to_money,

                    'complete' => 1,

                    'log_text' => $log_text,

                    'states' => 40,

                );

                $this->mod_epaylog->add($add_epaylog);

                $log_text_to = $this->visitor->get('user_name') . Lang::get('gei') . $to_user_name . Lang::get('zhuanrujine') . $to_money . Lang::get('yuan');

                $add_epaylog_to = array(

                    'user_id' => $to_user_id,

                    'user_name' => $to_user_name,

                    'to_id' => $this->visitor->get('user_id'),

                    'to_name' => $this->visitor->get('user_name'),

                    'order_sn ' => $order_sn,

                    'add_time' => gmtime(),

                    'type' => EPAY_IN, //转入	

                    'money_flow' => 'income',

                    'money' => $to_money,

                    'complete' => 1,

                    'log_text' => $log_text_to,

                    'states' => 40,

                );

                $this->mod_epaylog->add($add_epaylog_to);



                $new_user_money = $user_money - $to_money;

                $new_to_user_money = $to_user_money + $to_money;



                $add_jia = array(

                    'money' => $new_to_user_money,

                );

                $this->mod_epay->edit('user_id=' . $to_user_id, $add_jia);

                $add_jian = array(

                    'money' => $new_user_money,

                );

                $this->mod_epay->edit('user_id=' . $user_id, $add_jian);



                $this->show_message('zhuanzhangchenggong');

                return;

            }

        }

    }





    //修改支付密码

    function editpassword() {

        $user_id = $this->visitor->get('user_id');

        $epay = $this->mod_epay->get("user_id='$user_id'");

		 $user_mod =& m('member');

		 $info = $user_mod->get_info($user_id);

		 $this->assign('info', $info);

        if (!$_POST) {//检测是否提交

            $this->assign('epay', $epay);

            /* 当前用户中心菜单 */

            $this->_curitem('epay');

            $this->_curmenu('epay_editpassword');

			   $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js',

            ));

            $this->display('epay.editpassword.html');

            return;

        } else {

            $y_pass = trim($_POST['y_pass']);

            $zf_pass = trim($_POST['zf_pass']);

            $zf_pass2 = trim($_POST['zf_pass2']);

			

			 $email = trim($_POST['email']);

			 $confirm_code = trim($_POST['confirm_code']);

			 

			 

			 

			 if ($zf_pass != $zf_pass2) {

                $this->show_warning('cuowu_liangcishurumimabuyizhi');

                return;

            }

         

			if(!$_GET['ispas'])

			{

				   if (empty($zf_pass)) {

                $this->show_warning('cuowu_zhifumimabunengweikong');

                return;

            }

			

			 

			}else

			{

			

			if ($_SESSION['code'] != md5($email.$confirm_code)) {

                $this->show_warning('验证码错误');

                return;

            }

			

			}

          



            //如果未设置支付密码，则直接设置,已设置支付密码 需要验证原支付密码

            $md5zf_pass = md5($zf_pass);

            if ($epay['zf_pass'] != "") {

                //转换32位 MD5

                $md5y_pass = md5($y_pass);

            if(!$_GET['ispas'])

			{

                if ($epay['zf_pass'] != $md5y_pass) {

                    $this->show_warning('cuowu_yuanzhifumimayanzhengshibai');

                    return;

                }

			}

            }



            $newpass_array = array(

                'zf_pass' => $md5zf_pass,

            );

            $this->mod_epay->edit('user_id=' . $user_id, $newpass_array);

            $this->show_message('zhifumimaxiugaichenggong');

            return;

        }

    }



    function bank_add() {//增加银行卡

        if (!IS_POST) {

            $this->_curitem('epay');

            $this->_curmenu('epay_add_bank');

            $this->assign('bank_inc', $this->_get_bank_inc());

            $this->display('epay.bank_form.html');

        } else {

            $short_name = trim($_POST['short_name']);

            $account_name = trim($_POST['account_name']);

            $bank_type = trim($_POST['bank_type']);

            $bank_num = trim($_POST['bank_num']);



            if (empty($short_name)) {

                $this->show_warning('short_name_error');

                return;

            }

            if (empty($bank_num)) {

                $this->show_warning('num_empty');

                return;

            }

            if (empty($account_name) || strlen($account_name) < 6 || strlen($account_name) > 30) {

                $this->show_warning('account_name_error');

                return;

            }

            if (!in_array($bank_type, array('debit', 'credit'))) {

                $this->show_warning('type_error');

                return;

            }

            $bank_name = $this->_get_bank_name($short_name);

            if (empty($bank_name)) {

                $this->show_warning('bank_name_error');

                return;

            }

            if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha'])) {

                $this->show_warning('captcha_failed');

                return;

            }

            $data = array(

                'user_id' => $this->visitor->get('user_id'),

                'bank_name' => $bank_name,

                'short_name' => strtoupper($short_name),

                'account_name' => $account_name,

                'open_bank' => trim($_POST['open_bank']),

                'bank_type' => $bank_type,

                'bank_num' => $bank_num,

            );



            if (!$this->mod_epay_bank->add($data)) {

                $this->show_warning('add_error');

                return;

            }

            $this->show_message('add_ok', 'back_list', 'index.php?app=epay&act=bank_add');

        }

    }

    function bank_edit() {
    
        if (!IS_POST) {
            
            $card=$this->mod_epay_bank->get_info($_GET['bank_id']);
            
            $this->assign('card', $card);
            
            $this->_curitem('epay');
    
            $this->_curmenu('epay_add_bank');
    
            $this->assign('bank_inc', $this->_get_bank_inc());
    
            $this->display('epay.bank_form.html');
    
        } else {
    
            $short_name = trim($_POST['short_name']);
    
            $account_name = trim($_POST['account_name']);
    
            $bank_type = trim($_POST['bank_type']);
    
            $bank_num = trim($_POST['bank_num']);
    
            $bank_id=trim($_POST['bank_id']);
    
            if (empty($short_name)) {
    
                $this->show_warning('short_name_error');
    
                return;
    
            }
    
            if (empty($bank_num)) {
    
                $this->show_warning('num_empty');
    
                return;
    
            }
    
            if (empty($account_name) || strlen($account_name) < 6 || strlen($account_name) > 30) {
    
                $this->show_warning('account_name_error');
    
                return;
    
            }
    
            if (!in_array($bank_type, array('debit', 'credit'))) {
    
                $this->show_warning('type_error');
    
                return;
    
            }
    
            $bank_name = $this->_get_bank_name($short_name);
    
            if (empty($bank_name)) {
    
                $this->show_warning('bank_name_error');
    
                return;
    
            }
    
            if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha'])) {
    
                $this->show_warning('captcha_failed');
    
                return;
    
            }
    
            $data = array(
                
                'bank_id'=>$bank_id,
    
                'user_id' => $this->visitor->get('user_id'),
    
                'bank_name' => $bank_name,
    
                'short_name' => strtoupper($short_name),
    
                'account_name' => $account_name,
    
                'open_bank' => trim($_POST['open_bank']),
    
                'bank_type' => $bank_type,
    
                'bank_num' => $bank_num,
    
            );
    
    
    
            if (!$this->mod_epay_bank->edit($bank_id,$data)) {
    
                $this->show_warning('edit_error');
    
                return;
    
            }
    
            $this->show_message('edit_ok', 'back_list', 'index.php?app=epay&act=withdraw');
    
        }
    
    }
    


    function _check_short_name($short_name) {

        $bank_inc = $this->_get_bank_inc();

        if (!is_array($bank_inc) || count($bank_inc) < 1) {

            return false;

        }

        foreach ($bank_inc as $key => $bank) {

            if (strtoupper($short_name) == strtoupper($key)) {

                return true;

            }

        }

        return false;

    }



    function _get_bank_inc($type = '') {

        if ($type == 'alipaybank') {

            $bank_inc = include ROOT_PATH . '/data/alipaybank.inc.php';

        } else

            $bank_inc = include ROOT_PATH . '/data/bank.inc.php';

        if (!is_array($bank_inc) || count($bank_inc) < 1) {

            $this->show_warning('bank_inc_error');

            return;

        }

        return $bank_inc;

    }

    function _get_bank_name($short_name) {

        if (!$this->_check_short_name($short_name))

            return '';

        $bank_inc = $this->_get_bank_inc();

        return $bank_inc[$short_name];

    }

    

    

    /**

     * 此处是客户汇款之后提交相关信息给后台让管理员审核，审核通过手动进行充值

     */

    function offline_chongzhi()

    {

        if (IS_POST){

            if(empty($_POST['message'])||empty($_POST['realname'])||empty($_POST['mobile'])){

                $this->show_message('请输入完整信息', 'back_list', 'index.php?app=epay&act=czlist');

                return;

            }

            $data = array(

                'message' => $_POST['message'],

                'realname' => $_POST['realname'],

                'mobile' => $_POST['mobile'],

                'add_time' => gmtime(),

                'type' => CUSTOMER_EPAYOFFLINE,

                'user_id'=>$this->visitor->get('user_id'),

            );

            $customer_message_mod = & m('customer_message');

            $customer_message_mod->add($data);

            $this->show_message('提交成功,等待管理员审核', 'index.php?app=epay&act=czlist');

        }

    }



    function _get_member_submenu()

    {

        $menus = array(

            array(

                'name'  => 'epay_logall',

                'url'   => 'index.php?app=epay&act=logall',

            ),

            array(

                'name'  => 'epay_czlist',

                'url'   => 'index.php?app=epay&act=czlist',

            ),

            array(

                'name'  => 'epay_out',

                'url'   => 'index.php?app=epay&act=out',

            ),

            array(

                'name'  => 'epay_editpassword',

                'url'   => 'index.php?app=epay&act=editpassword',

            ),

            array(

                'name'  => 'epay_withdraw',

                'url'   => 'index.php?app=epay&act=withdraw',

            ),

        );

        return $menus;

    }

    

    

    

    

    



    //支付定单

    function payment() {

        $user_id = $this->visitor->get('user_id');

        $zf_pass = trim($_POST['zf_pass']);

        $post_money = trim($_POST['post_money']); //提交过来的 金钱

        $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0; //提交过来的 定单号码
        
        $payment_id = isset($_GET['payment_id']) ? intval($_GET['payment_id']) : 0; //提交过来的 定单号码
        
        

        if (empty($order_id)) {

            $this->show_warning('feifacanshu');

            return;

        }

        $epay = $this->mod_epay->get("user_id='$user_id'");

        if (empty($epay['zf_pass'])) {

            $this->show_message('epay_editpassword', 'epay_editpassword', 'index.php?app=epay&act=editpassword');

            return;

        }
        
        
        if ($_POST) {//检测是否提交
            
            $buyer_name = $epay['user_name']; //用户名

            $buyer_zf_pass = $epay['zf_pass']; //支付密码

            $buyer_old_money = $epay['money']; //当前用户的原始金钱

            //从定单中 读取卖家信息

            $row_order = $this->mod_order->getrow("select * from " . DB_PREFIX . "order where order_id='$order_id'");

            $order_order_sn = $row_order['order_sn']; //定单号

            $order_seller_id = $row_order['seller_id']; //定单里的 卖家ID

            $order_money = $row_order['order_amount']; //定单里的 最后定单总价格

            $gh_order_amount = $row_order['gh_order_amount']; //定单里的 最后定单总供货价格
			
			$use_integral = $row_order['use_integral'];

//读取卖家SQL

             

		    //读取卖家SQL

            $seller_row = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_id='$order_seller_id'");

            $seller_id = $seller_row['user_id']; //卖家ID 

            $seller_name = $seller_row['user_name']; //卖家用户名

            $seller_money_dj = $seller_row['money_dj']; //卖家的原始冻结金钱

            //检测支付密码

            if (empty($zf_pass)) {

                $this->show_warning('cuowu_zhifumimabunengweikong');

                return;

            }

            $md5zf_pass = md5($zf_pass);

            if ($epay['zf_pass'] != $md5zf_pass) {

                $this->show_warning('cuowu_zhifumimayanzhengshibai');

                return;

            }

            if($payment_id==10){//购物积分支付分开
                
                //检测余额是否足够
                
                if ( $epay['moneyjf'] < $order_money) {   //检测余额是否足够 开始
                
                    //         $this->show_warning('cuowu_zhanghuyuebuzu', 'lijichongzhi', 'index.php?app=epay&act=czlist');
                     
                    $this->show_warning('cuowu_zhanghuyuebuzu');
                
                    return;
                
                } //检测余额是否足够 结束
                
                //金额是否相同
                
                if ($post_money != $order_money) {   //检测密保相符 开始
                
                    $this->show_warning('fashengcuowu_jineshujukeyi');
                
                    return;
                
                } //金额是否相同 结束
                
                //检测SESSION 是否存为空
                
                if ($_SESSION['session_order_sn'] != $order_order_sn) {
                
                    //扣除买家的积分金钱金钱
                
                    $buyer_array = array(
                
                        'moneyjf' => $epay['moneyjf'] - $order_money,
                
                    );
                
                    $this->mod_epay->edit('user_id=' . $user_id, $buyer_array);
                
                
                
                    //更新卖家的冻结金钱
                
                    $seller_array = array(//卖家把钱按照供货价格转换为现金
                
                        'money_dj' => $seller_money_dj + $gh_order_amount,
                
                    );
                
                    $seller_edit = $this->mod_epay->edit('user_id=' . $seller_id, $seller_array);
                
                //买家添加日志

                $buyer_log_text = Lang::get('goumaishangpin_dianzhu') . $seller_name;

                $buyer_add_array = array(

                    'user_id' => $user_id,

                    'user_name' => $buyer_name,

                    'order_id' => $order_id,

                    'order_sn ' => $order_order_sn,

                    'to_id' => $seller_id,

                    'to_name' => $seller_name,

                    'add_time' => gmtime(),

                    'type' => EPAY_BUY,

                    'money_flow' => 'outlay',

                    'money' => $order_money,

//                    'complete' => 1,

                    'log_text' => $buyer_log_text,

                    'states' => 20,

                );

                $this->mod_epaylog->add($buyer_add_array);

                //卖家添加日志

                $seller_log_text = Lang::get('chushoushangpin_maijia') . $buyer_name;

                $seller_add_array = array(

                    'user_id' => $seller_id,

                    'user_name' => $seller_name,

                    'order_id' => $order_id,

                    'order_sn ' => $order_order_sn,

                    'to_id' => $user_id,

                    'to_name' => $buyer_name,

                    'add_time' => gmtime(),

                    'type' => EPAY_SELLER,

                    'money_flow' => 'income',

                    'money' =>$gh_order_amount,// $order_money,   卖家此处添加的日志为供货价

                    'log_text' => $seller_log_text,

                    'states' => 20,

                );

                $this->mod_epaylog->add($seller_add_array);

                //改变定单为 已支付等待卖家确认  status10改为20



                //更新定单状态

                $order_edit_array = array(

                    'payment_name' => Lang::get('epay_name'),

                    'payment_code' => $payment_code,

                    'pay_time' => gmtime(),

                    'out_trade_sn' => $order_sn,

                    'status' => 20, //20就是 待发货了

                );
                
                    if($payment_id==10){
                        
                        $order_edit_array['payment_code']="gwjf";
                        $order_edit_array['payment_name']=Lang::get('epaygwjf_name');
                    }else{
                        $payment_code = "zjgl";
                        
    
                    }
                    
                $this->mod_order->edit($order_id, $order_edit_array);

                //$edit_data['status']    =   ORDER_ACCEPTED;//定义 为 20 待发货

                //$mod_orderel->edit($order_id, $edit_data);//直接更改为 20 待发货

                //支付成功

                $this->show_message('zhifu_chenggong', 'sanmiaohouzidongtiaozhuandaodingdanliebiao', 'index.php?app=buyer_order', 'chankandingdan', 'index.php?app=buyer_order', 'guanbiyemian', 'index.php?app=epay&act=exits'

                );

                //定义SESSION值

                $_SESSION['session_order_sn'] = $order_order_sn;

            }//检测SESSION为空 执行完毕

            else {//检测SESSION为空 否则//检测SESSION为空 否则 开始

                $this->show_warning('jinggao_qingbuyaochongfushuaxinyemian');

                return;

            }//检测SESSION为空 否则 结束
                    
                
          }else{//.......................................现金支付
                //检测余额是否足够
			    $omoney = $order_money;
				
				$order_money -=  $use_integral;
				
				
                $member_mod = &m('member');
                $member = $member_mod->get($user_id);
				

                
                if ($buyer_old_money < $order_money) {   //检测余额是否足够 开始
                
                    //         $this->show_warning('cuowu_zhanghuyuebuzu', 'lijichongzhi', 'index.php?app=epay&act=czlist');
                     
                    $this->show_warning('cuowu_zhanghuyuebuzu');
                
                    return;
                
                } //检测余额是否足够 结束
				
				
                if ($member['integral'] < $use_integral) {   //检测余额是否足够 开始
                
                    //         $this->show_warning('cuowu_zhanghuyuebuzu', 'lijichongzhi', 'index.php?app=epay&act=czlist');
                     
                    $this->show_warning('对不起，积分余额不足');
                
                    return;
                
                } //检测余额是否足够 结束
				
				
                
                //金额是否相同
                
                if ($post_money != $omoney) {   //检测密保相符 开始
                
                    $this->show_warning('fashengcuowu_jineshujukeyi');
                
                    return;
                
                } //金额是否相同 结束
                
                //检测SESSION 是否存为空
                
                if ($_SESSION['session_order_sn'] != $order_order_sn) {
                
                    //扣除买家的金钱
                
                    $buyer_array = array(
                
                        'money' => $buyer_old_money - $order_money,
                
                    );
                
                    $this->mod_epay->edit('user_id=' . $user_id, $buyer_array);
		if($use_integral>0){			
					
            $member_mod->edit($user_id, array('integral' => $member['integral'] - $use_integral));
            //操作记录入积分记录
            $integral_log_mod = &m('integral_log');
            $integral_log = array(
                'user_id' => $user_id,
                'user_name' => $member['user_name'],
                'point' => $use_integral,
                'add_time' => gmtime(),
                'remark' => '购物消费',
                'integral_type' => INTEGRAL_SELLER,
            );
            $integral_log_mod->add($integral_log);
					
		}
                
                
                    //更新卖家的冻结金钱
                
                    $seller_array = array(
                
                        'money_dj' => $seller_money_dj + $gh_order_amount,
                
                    );
                
                    $seller_edit = $this->mod_epay->edit('user_id=' . $seller_id, $seller_array);
                
              //买家添加日志

                $buyer_log_text = Lang::get('goumaishangpin_dianzhu') . $seller_name;

                $buyer_add_array = array(

                    'user_id' => $user_id,

                    'user_name' => $buyer_name,

                    'order_id' => $order_id,

                    'order_sn ' => $order_order_sn,

                    'to_id' => $seller_id,

                    'to_name' => $seller_name,

                    'add_time' => gmtime(),

                    'type' => EPAY_BUY,

                    'money_flow' => 'outlay',

                    'money' => $order_money,

//                    'complete' => 1,

                    'log_text' => $buyer_log_text,

                    'states' => 20,

                );

                $this->mod_epaylog->add($buyer_add_array);

                //卖家添加日志

                $seller_log_text = Lang::get('chushoushangpin_maijia') . $buyer_name;

                $seller_add_array = array(

                    'user_id' => $seller_id,

                    'user_name' => $seller_name,

                    'order_id' => $order_id,

                    'order_sn ' => $order_order_sn,

                    'to_id' => $user_id,

                    'to_name' => $buyer_name,

                    'add_time' => gmtime(),

                    'type' => EPAY_SELLER,

                    'money_flow' => 'income',

                    'money' => $gh_order_amount,//$order_money,卖家为  供货价

                    'log_text' => $seller_log_text,

                    'states' => 20,

                );

                $this->mod_epaylog->add($seller_add_array);

                //改变定单为 已支付等待卖家确认  status10改为20



                //更新定单状态

                $order_edit_array = array(

                    'payment_name' => Lang::get('epay_name'),

                    'payment_code' => $payment_code,

                    'pay_time' => gmtime(),

                    'out_trade_sn' => $order_sn,

                    'status' => 20, //20就是 待发货了

                );
                
                if($payment_id==10){
                    
                    $order_edit_array['payment_code']="gwjf";
                    $order_edit_array['payment_name']=Lang::get('epaygwjf_name');
                }else{
                    $payment_code = "zjgl";
                    

                }

                $this->mod_order->edit($order_id, $order_edit_array);

                //$edit_data['status']    =   ORDER_ACCEPTED;//定义 为 20 待发货

                //$mod_orderel->edit($order_id, $edit_data);//直接更改为 20 待发货

                //支付成功
				
				
		$db = &db();
		$query = $db -> query("select * from ecm_order_goods where order_id='{$order_id}'");
		while($rs = $db->fetchrow($query)){
			unset($r,$jinhua);
			$r = $db->getOne2("select * from ecm_goods where goods_id='{$rs['goods_id']}'");
            $jinhua = array(
                'uid' => $user_id,
                'jinhua1' => $r['jinhua1'],
                'jinhua2' => $r['jinhua2'],
                'jinhua3' => $r['jinhua3'],
                'jinhua4' => $r['jinhua4'],
                'jinhua5' => $r['jinhua5'],
				'orderid' => $order_id,
            );	
			for($i=0;$i<$rs['quantity'];$i++) $db->autoExecute("ecm_jinhua",$jinhua);
		}

                $this->show_message('zhifu_chenggong', 'sanmiaohouzidongtiaozhuandaodingdanliebiao', 'index.php?app=jinhua', 'chankandingdan', 'index.php?app=buyer_order', 'guanbiyemian', 'index.php?app=epay&act=exits'

                );

                //定义SESSION值

                $_SESSION['session_order_sn'] = $order_order_sn;

            }//检测SESSION为空 执行完毕

            else {//检测SESSION为空 否则//检测SESSION为空 否则 开始

                $this->show_warning('jinggao_qingbuyaochongfushuaxinyemian');

                return;

            }//检测SESSION为空 否则 结束
           }
              
            }else {

            /* 外部提供订单号 */

            $order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;

            if (!$order_id) {

                $this->show_warning('no_such_order');



                return;

            }
          
            /* 内部根据订单号收银,获取收多少钱，使用哪个支付接口 */

            $order_model = & m('order');

            $order_info = $order_model->get("order_id={$order_id} AND buyer_id=" . $this->visitor->get('user_id'));

            if (empty($order_info)) {

                $this->show_warning('no_such_order');



                return;

            }

            /* 订单有效性判断 */

            if ($order_info['payment_code'] != 'cod' && $order_info['status'] != ORDER_PENDING) {

                $this->show_warning('no_such_order');

                return;

            }

            $payment_model = & m('payment');

            //余额支付 读取资金，读取店铺是否安装支付方式

            $this->assign('money', $epay);

            //余额支付 结束

             $this->assign('payment_id', $payment_id);//如果是10 代表用购物积分 
			 
			 $order_info['lost_money'] = $order_info['order_amount']-$order_info['use_integral'];

            $this->assign('order', $order_info);

            $this->display('cashier.payment1.html');

        }

    }



    //筛选充值方式

    function czfs() {

        if ($_POST) {

            $user_id = $this->visitor->get('user_id');

            $user_name = $this->visitor->get('user_name');

            $cz_money = trim($_POST['cz_money']);

            $czfs = trim($_POST['czfs']);

            switch ($czfs) {

                case 'alipay':

                    $bank_name = "支付宝";

                    break;

                case 'wapalipay':

                    $bank_name = "手机支付宝";

                    break;

                case 'chinabank':

                    $bank_name = "网银在线";

                    break;

                case 'tenpay':

                    $bank_name = "财付通";

                    break;

                default:

                    $bank_name = "支付宝";

            }



            $log_text = $this->visitor->get('user_name') . "充值" . $cz_money . Lang::get('yuan');





            if (!$_POST['order_sn']) {

                $dingdan = "60" . date('YmdHis',gmtime()+8*3600).rand(1000,9999);

            } else {

                $dingdan = $_POST['order_sn'];

            }





            $info = $this->mod_epaylog->get('order_sn=' . $dingdan);

            if (empty($info)) {

                $add_epaylog = array(

                    'user_id' => $user_id,

                    'user_name' => $user_name,

                    'order_sn' => $dingdan,

                    'to_name' => $bank_name,

                    'add_time' => gmtime(),

                    'type' => EPAY_CZ,

                    'money_flow' => 'income',

                    'money' => $cz_money,

                    'log_text' => $log_text,

                    'states' => 60,

                );

                $this->mod_epaylog->add($add_epaylog);

            }





            $site_url = SITE_URL;





            switch ($czfs) {

                case 'alipay':

                    $epay_alipay_seller_email = Conf::get('epay_alipay_seller_email');

                    $epay_alipay_partner = Conf::get('epay_alipay_partner');

                    $epay_alipay_key = Conf::get('epay_alipay_key');

                    ?>

                    <body onLoad="javascript:document.ALI_FORM.submit()">

                        <form method="post" name="ALI_FORM" action="app/alipay/alipayapi.php">

                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">

                            <input type="hidden" name="dingdan" value="<?php echo $dingdan; ?>">

                            <input type="hidden" name="alimoney" value="<?php echo $cz_money; ?>">

                            <input type="hidden" name="epay_alipay_seller_email" value="<?php echo $epay_alipay_seller_email; ?>">

                            <input type="hidden" name="epay_alipay_partner" value="<?php echo $epay_alipay_partner; ?>">

                            <input type="hidden" name="epay_alipay_key" value="<?php echo $epay_alipay_key; ?>">

                            <input type="hidden" name="site_url" value="<?php echo $site_url; ?>">

                        </form>

                    </body>

                    <?php

                    break;

                case 'wapalipay':

                    $epay_alipay_seller_email = Conf::get('epay_alipay_seller_email');

                    $epay_alipay_partner = Conf::get('epay_alipay_partner');

                    $epay_alipay_key = Conf::get('epay_alipay_key');

                    ?>

                    <body onLoad="javascript:document.ALI_FORM.submit()">

                        <form method="post" name="ALI_FORM" action="app/wapalipay/alipayapi.php">

                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">

                            <input type="hidden" name="dingdan" value="<?php echo $dingdan; ?>">

                            <input type="hidden" name="alimoney" value="<?php echo $cz_money; ?>">

                            <input type="hidden" name="epay_alipay_seller_email" value="<?php echo $epay_alipay_seller_email; ?>">

                            <input type="hidden" name="epay_alipay_partner" value="<?php echo $epay_alipay_partner; ?>">

                            <input type="hidden" name="epay_alipay_key" value="<?php echo $epay_alipay_key; ?>">

                            <input type="hidden" name="site_url" value="<?php echo $site_url; ?>">

                        </form>

                    </body>

                    <?php

                    break;

                case 'chinabank':

                    $v_mid = Conf::get('epay_chinabank_mid');

                    $key = Conf::get('epay_chinabank_key');

                    $v_url = SITE_URL . '/index.php?app=epay&act=chinabank_return_url';

                    $v_oid = $dingdan; #网银定单号,不加商号了

                    $v_moneytype = "CNY"; #币种

                    $text = $cz_money . $v_moneytype . $v_oid . $v_mid . $v_url . $key; #md5加密拼凑串,注意顺序不能变

                    $v_md5info = strtoupper(md5($text));

                    ?>

                    <body onLoad="javascript:document.CHINABLANK_FORM.submit()">

                        <form method="post" name="CHINABLANK_FORM" action="https://pay3.chinabank.com.cn/PayGate">

                            <input type="hidden" name="v_mid"         value="<?php echo $v_mid; ?>"/>

                            <input type="hidden" name="v_oid"         value="<?php echo $v_oid; ?>"/>

                            <input type="hidden" name="v_amount"      value="<?php echo $cz_money; ?>"/>

                            <input type="hidden" name="v_moneytype"   value="<?php echo $v_moneytype; ?>"/>

                            <input type="hidden" name="v_url"         value="<?php echo $v_url; ?>"/>

                            <input type="hidden" name="v_md5info"     value="<?php echo $v_md5info; ?>"/>

                            <input type="hidden" name="remark1"       value="<?php echo $remark1; ?>"/>

                            <input type="hidden" name="remark2"       value="<?php echo $remark2; ?>"/>

                        </form>

                    </body>

                    <?php

                    break;

                case 'tenpay':

                    $epay_tenpay_bargainor_id = Conf::get('epay_tenpay_bargainor_id');

                    $epay_tenpay_key = Conf::get('epay_tenpay_key');

                    ?>

                    <body onLoad="javascript:document.TENPAY_FORM.submit()">

                        <form method="post" name="TENPAY_FORM" action="app/tenpay/tenpay.php">

                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">

                            <input type="hidden" name="dingdan" value="<?php echo $dingdan; ?>">

                            <input type="hidden" name="tenmoney" value="<?php echo $cz_money; ?>">

                            <input type="hidden" name="epay_tenpay_bargainor_id" value="<?php echo $epay_tenpay_bargainor_id; ?>">

                            <input type="hidden" name="epay_tenpay_key" value="<?php echo $epay_tenpay_key; ?>">

                            <input type="hidden" name="site_url" value="<?php echo $site_url; ?>">

                        </form>

                    </body>

                    <?php

                    break;

                case 'wxjs':

                    ?>

                    <body onLoad="javascript:document.WXJS_FORM.submit()">

                        <form method="get" name="WXJS_FORM" action="app/wxpay/wxjs.php">

                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">

                            <input type="hidden" name="dingdan" value="<?php echo $dingdan; ?>">

                            <input type="hidden" name="cz_money" value="<?php echo $cz_money; ?>">

                            <input type="hidden" name="site_url" value="<?php echo $site_url; ?>">

                        </form>

                    </body>

                    <?php

                    break;

                case 'wxnative':

                    ?>

                    <body onLoad="javascript:document.WXNATIVE_FORM.submit()">

                        <form method="post" name="WXNATIVE_FORM" action="app/wxpay/wxnative.php">

                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

                            <input type="hidden" name="user_name" value="<?php echo $user_name; ?>">

                            <input type="hidden" name="dingdan" value="<?php echo $dingdan; ?>">

                            <input type="hidden" name="cz_money" value="<?php echo $cz_money; ?>">

                            <input type="hidden" name="site_url" value="<?php echo $site_url; ?>">

                        </form>

                    </body>

                    <?php

                    break;

                default:

                    header("Location: index.php?app=epay&act=czlist");

            }

        }

    }



    function chinabank_return_url() {

        $user_id = $this->visitor->get('user_id');

        $user_name = $this->visitor->get('user_name');

        if ($_POST) {



            $key = Conf::get('epay_chinabank_key');





            $v_oid = trim($_POST['v_oid']);       // 商户发送的v_oid定单编号   

            $v_pmode = trim($_POST['v_pmode']);    // 支付方式（字符串）   

            $v_pstatus = trim($_POST['v_pstatus']);   //  支付状态 ：20（支付成功）；30（支付失败）

            $v_pstring = trim($_POST['v_pstring']);   //提示中文"支付成功"字符串



            $v_amount = trim($_POST['v_amount']);     // 订单实际支付金额

            $v_moneytype = trim($_POST['v_moneytype']); //订单实际支付币种

            $remark1 = trim($_POST['remark1']);      //备注字段1

            $remark2 = trim($_POST['remark2']);     //备注字段2

            $v_md5str = trim($_POST['v_md5str']);   //拼凑后的MD5校验值

            //重新计算md5的值                         

            $md5string = strtoupper(md5($v_oid . $v_pstatus . $v_amount . $v_moneytype . $key));



            //校验MD5 开始//校验MD5 IF括号

            if ($v_md5str == $md5string) {

                if ($v_pstatus == "20") {









//根据用户订单号，获取充值者的ID

                    $row_epay_log = $this->mod_epaylog->get("order_sn='$v_oid'");



                    if (empty($row_epay_log) || $row_epay_log['complete'] == '1' || $row_epay_log['user_id'] != $user_id) {

                        $this->show_message('jinggao_qingbuyaochongfushuaxinyemian', 'guanbiyemian', 'index.php?app=epay&act=exits');

                    }



                    //获取用户的余额

                    $row_epay = $this->mod_epay->get("user_id='$user_id'");

                    //计算新的余额

                    $total_fee = $v_amount;   //获取总价格

                    $old_money = $row_epay['money'];

                    $new_money = $old_money + $total_fee;

                    $edit_money = array(

                        'money' => $new_money,

                    );

                    $this->mod_epay->edit('user_id=' . $user_id, $edit_money);

                    //修改记录

                    $edit_epaylog = array(

                        'add_time' => gmtime(),

                        'money'=>$total_fee,

                        'complete' => 1,

                        'states' => 61,

                    );

                    $this->mod_epaylog->edit('order_sn=' . '"' . $v_oid . '"', $edit_epaylog);

                    

                    

                    

                    

                    

                    

                    //根据用户返回的 order_sn 判断是否为订单

                    $order_info = $this->mod_order->get('order_sn='.$v_oid);

                    

                    if (!empty($order_info)) {

                        //如果存在订单号  则自动付款

                        $order_id = $order_info['order_id'];

                        



                        $row_epay = $this->mod_epay->get("user_id='$user_id'");

                        $buyer_name = $row_epay['user_name']; //用户名

                        $buyer_old_money = $row_epay['money']; //当前用户的原始金钱

//从定单中 读取卖家信息

                        $row_order = $this->mod_order->get("order_id='$order_id'");

                        $order_order_sn = $row_order['order_sn']; //定单号

                        $order_seller_id = $row_order['seller_id']; //定单里的 卖家ID

                        $order_money = $row_order['order_amount']; //定单里的 最后定单总价格

//读取卖家SQL

                        $seller_row = $this->mod_epay->get("user_id='$order_seller_id'");

                        $seller_id = $seller_row['user_id']; //卖家ID 

                        $seller_name = $seller_row['user_name']; //卖家用户名

                        $seller_money_dj = $seller_row['money_dj']; //卖家的原始冻结金钱

//检测余额是否足够

                        if ($buyer_old_money < $order_money) {   //检测余额是否足够 开始

                            return;

                        }





//扣除买家的金钱

                        $buyer_array = array(

                            'money' => $buyer_old_money - $order_money,

                        );

                        $this->mod_epay->edit('user_id=' . $user_id, $buyer_array);



//更新卖家的冻结金钱	

                        $seller_array = array(

                            'money_dj' => $seller_money_dj + $order_money,

                        );

                        $seller_edit = $this->mod_epay->edit('user_id=' . $seller_id, $seller_array);

                        

                        

                        

//买家添加日志

                        $buyer_log_text = '购买商品店铺' . $seller_name;

                        $buyer_add_array = array(

                            'user_id' => $user_id,

                            'user_name' => $buyer_name,

                            'order_id' => $order_id,

                            'order_sn ' => $order_order_sn,

                            'to_id' => $seller_id,

                            'to_name' => $seller_name,

                            'add_time' => gmtime(),

                            'type' => EPAY_BUY,

                            'money_flow' => 'outlay',

                            'money' => $order_money,

                            'log_text' => $buyer_log_text,

                            'states' => 20,

                        );

                        $this->mod_epaylog->add($buyer_add_array);

//卖家添加日志

                        $seller_log_text = '出售商品买家' . $buyer_name;

                        $seller_add_array = array(

                            'user_id' => $seller_id,

                            'user_name' => $seller_name,

                            'order_id' => $order_id,

                            'order_sn ' => $order_order_sn,

                            'to_id' => $user_id,

                            'to_name' => $buyer_name,

                            'add_time' => gmtime(),

                            'type' => EPAY_SELLER,

                            'money_flow' => 'income',

                            'money' => $order_money,

                            'log_text' => $seller_log_text,

                            'states' => 20,

                        );

                        $this->mod_epaylog->add($seller_add_array);

//改变定单为 已支付等待卖家确认  status10改为20

                        $payment_code = "zjgl";

//更新定单状态

                        $order_edit_array = array(

                            'payment_name' => '余额支付',

                            'payment_code' => $payment_code,

                            'pay_time' => gmtime(),

                            'out_trade_sn' => $order_sn,

                            'status' => 20, //20就是 待发货了

                        );

                        $this->mod_order->edit($order_id, $order_edit_array);

                        $this->show_warning('zhifu_chenggong', 'guanbiyemian', 'index.php?app=epay&act=exits');

                    } else {

                        $this->show_message('chongzhi_chenggong_jineyiruzhang', 'chakancicichongzhi', 'index.php?app=epay&act=logall', 'guanbiyemian', 'index.php?app=epay&act=exits');

                    }

                } else {

                    $this->show_warning('chongzhi_shibai_qingchongxintijiao', 'guanbiyemian', 'index.php?app=epay&act=exits');

                }

            } else {

                $this->show_warning('wangyinshujuxiaoyanshibai_shujukeyi', 'guanbiyemian', 'index.php?app=epay&act=exits');

            }

        } else {

            $this->show_warning('feifacanshu', 'guanbiyemian', 'index.php?app=epay&act=exits');

        }

    }



    function tenpay_return_url() {

        if(empty($_GET['order_sn'])){

            $this->show_message('chongzhi_chenggong_jineyiruzhang', 'guanbiyemian', 'index.php?app=epay&act=logall');

            return;

        }

        

        $mod_order = & m('order');

        //根据用户返回的 order_sn 判断是否为订单

        $order_info = $mod_order->get('order_sn=' . $_GET['order_sn']);

        if (!empty($order_info)) {

            $this->show_message('zhifu_chenggong', 'guanbiyemian', 'index.php?app=buyer_order');

        }else{

            $this->show_message('chongzhi_chenggong_jineyiruzhang', 'guanbiyemian', 'index.php?app=epay&act=logall');

        }

    }

}
?>