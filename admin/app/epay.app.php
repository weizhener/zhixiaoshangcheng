<?php



/**

 *    资金管理控制器

 *

 */



class EpayApp extends BackendApp {



    var $mod_epay;

    var $mod_epaylog;



    function __construct() {

        $this->EpayApp();

    }



    function EpayApp() {

        parent::BackendApp();

        $this->mod_epay = & m('epay');

        $this->mod_epaylog = & m('epaylog');

    }



    //用户资金列表 含搜索

    function index() {

        $conditions = $this->_get_query_conditions(array(array(

                'field' => 'user_name',

                'equal' => 'LIKE',

                'name' => 'search_name',

            ), array(

                'field' => 'add_time',

                'name' => 'add_time_from',

                'equal' => '>=',

                'handler' => 'gmstr2time',

            ), array(

                'field' => 'add_time',

                'name' => 'add_time_to',

                'equal' => '<=',

                'handler' => 'gmstr2time_end',

            ), array(

                'field' => 'money',

                'name' => 'order_amount_from',

                'equal' => '>=',

                'type' => 'numeric',

            ), array(

                'field' => 'money',

                'name' => 'order_amount_to',

                'equal' => '<=',

                'type' => 'numeric',

            ),

        ));
		
		
		

        $page = $this->_get_page(10);

        $index = $this->mod_epay->find(array(

            'conditions' => '1=1' . $conditions,

            'limit' => $page['limit'],

            'order' => "id desc",

            'count' => true));

        $page['item_count'] = $this->mod_epay->getCount();

        $this->_format_page($page);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件

        $this->assign('page_info', $page);

        $this->assign('index', $index);

        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',

                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));

        $this->display('epay.index.html');

    }



    function statistics() {

        

        //计算方式1

        //有效的收入

        $income_sql = "SELECT SUM(money) FROM {$this->mod_epaylog->table} WHERE complete = 1 AND money_flow='income'";

        $income_money =  $this->mod_epaylog->getOne($income_sql);

        

        //有效的支出

        $outlay_sql = "SELECT SUM(money) FROM {$this->mod_epaylog->table} WHERE complete = 1 AND money_flow='outlay'";

        $outlay_money =  $this->mod_epaylog->getOne($outlay_sql);

        

        //当前可用资金

        $money_sql = "SELECT SUM(money) FROM {$this->mod_epay->table}";

        $money = $this->mod_epay->getOne($money_sql);

        

        //用户冻结资金

        $money_dj_sql = "SELECT SUM(money_dj) FROM {$this->mod_epay->table}";

        $money_dj = $this->mod_epay->getOne($money_dj_sql);

        

        

        $epay_check_1 = array(

            'income_money' => empty($income_money) ? '0.00' : $income_money, #收入资金

            'outlay_money' => empty($outlay_money) ? '0.00' : $outlay_money, #支出资金

            'money' => empty($money) ? '0.00' : $money, #可用资金

            'money_dj' => empty($money_dj) ? '0.00' : $money_dj, #冻结资金

        );

        $this->assign('epay_check_1', $epay_check_1);

        

        

        

        

        //计算方式2

        

        /* 金额统计 */

        //获取管理员增加的资金

        $sql10 = "SELECT SUM(money) FROM {$this->mod_epaylog->table} WHERE type=".EPAY_ADMIN." AND states=40 AND complete = 1 AND money_flow='income'";

        $type10 = $this->mod_epaylog->getOne($sql10);





        //获取管理员减少的资金

        $sql11 = "SELECT SUM(money) FROM {$this->mod_epaylog->table} WHERE type=".EPAY_ADMIN." AND states=40 AND complete = 1 AND money_flow='outlay'";

        $type11 = $this->mod_epaylog->getOne($sql11);



        //获取充值增加的资金

        $sql60 = "SELECT SUM(money) FROM {$this->mod_epaylog->table} WHERE type=".EPAY_CZ." AND states=61 AND complete = 1";

        $type60 = $this->mod_epaylog->getOne($sql60);





        //获取审核通过提现的资金

        $sql71 = "SELECT SUM(money) FROM {$this->mod_epaylog->table} WHERE type=".EPAY_TX." AND states = 71 AND complete = 1";

        $type71 = $this->mod_epaylog->getOne($sql71);



        //用户未冻结资金

        $sqlusermoney = "SELECT SUM(money) FROM {$this->mod_epay->table}";

        $typeusermoney = $this->mod_epay->getOne($sqlusermoney);



        //用户冻结资金

        $sqlusermoney_dj = "SELECT SUM(money_dj) FROM {$this->mod_epay->table}";

        $typeusermoney_dj = $this->mod_epay->getOne($sqlusermoney_dj);







        //等待处理提现

        //获取正在审核提现的资金

        $sql70 = "SELECT SUM(money) FROM {$this->mod_epaylog->table} WHERE type=".EPAY_TX." AND states = 70";

        $type70 = $this->mod_epaylog->getOne($sql70);

        $sqlcount70 = "SELECT COUNT(*) FROM {$this->mod_epaylog->table} WHERE type=".EPAY_TX." AND states = 70";

        $typecount70 = $this->mod_epaylog->getOne($sqlcount70);



        $epay_check_2 = array(

            'type10' => empty($type10) ? '0.00' : $type10, #管理员操作增加的资金

            'type11' => empty($type11) ? '0.00' : $type11, #管理员操作减少的资金

            'type60' => empty($type60) ? '0.00' : $type60, #充值增加的资金

            'type71' => empty($type71) ? '0.00' : $type71, #审核通过提现的资金

            'typeusermoney' => empty($typeusermoney) ? '0.00' : $typeusermoney, #用户未冻结资金

            'typeusermoney_dj' => empty($typeusermoney_dj) ? '0.00' : $typeusermoney_dj, #用户冻结资金



            /* -----相关信息------ */

            'type70' => empty($type70) ? '0.00' : $type70, #正在审核提现的资金

            'typecount70' => empty($typecount70) ? '0' : $typecount70, #等待处理提现笔数

        );

        $this->assign('epay_check_2', $epay_check_2);

        $this->display('epay.statistics.html');

    }



    //增加用户资金   

    function money_add() {

        if ($_POST) {

            $user_name = trim($_POST['user_name']);

            $post_money = trim($_POST['post_money']);

            $jia_or_jian = trim($_POST['jia_or_jian']);

            $log_text = trim($_POST['log_text']);

            if (empty($user_name) or empty($post_money) or empty($jia_or_jian)) {

                $this->show_warning('cuowu_notnull');

                return;

            }

            if (preg_match("/[^0.-9]/", $post_money)) {

                $this->show_warning('cuowu_nishurudebushishuzilei');

                return;

            }

            $money_row = $this->mod_epay->getrow("select * from " . DB_PREFIX . "epay where user_name='$user_name'");

            $user_id = $money_row['user_id'];

            $my_money = $money_row['money'];

            if (empty($user_id)) {

                $this->show_warning('cuowu_no_user');

                return;

            }

            if ($jia_or_jian == "jia") {

                $money = $my_money + $post_money;

                $money_flow = 'income';

            }

            if ($jia_or_jian == "jian") {

                if ($my_money >= $post_money) {

                    $money = $my_money - $post_money;

                    $money_flow = 'outlay';

                } else {

                    $this->show_warning('cuowu_moeny_low');

                    return;

                }

            }

            //写入LOG记录

            $dq_time = "10" . date('YmdHis',gmtime()+8*3600).rand(1000,9999);



            $logs_array = array(

                'user_id' => $user_id,

                'user_name' => $user_name,

                'order_sn' => $dq_time,

                'type' => EPAY_ADMIN,

                'money_flow' => $money_flow,

                'money' => $post_money,

                'states' => 40,

                'complete' => 1,

                'log_text' => $log_text,

                'add_time' => gmtime(),

            );

            $this->mod_epaylog->add($logs_array);

            //写入LOG记录

            $money_array = array(

                'money' => $money,

            );

            $this->mod_epay->edit('user_id=' . $user_id, $money_array);



            $this->show_message('add_money_ok', '返回列表', 'index.php?app=epay');

            return;

        } else {

            $user_id = isset($_GET['user_id']) ? trim($_GET['user_id']) : '';

            $user_name = isset($_GET['user_name']) ? trim($_GET['user_name']) : '';

            if (!empty($user_id)) {

                $index = $this->mod_epay->find('user_id=' . $user_id);

            }

            $this->assign('index', $index);

            $this->display('epay.money_add.html');

        }

        return;

    }



    //查看资金流水

    function money_log() {

        $search_options = array(

            'user_name' => Lang::get('user_name'),

            'log_text' => Lang::get('log_text'),

            'order_sn' => Lang::get('order_sn'),

        );

        /* 默认搜索的字段是操作名 */

        $field = 'user_name';

        array_key_exists($_GET['field'], $search_options) && $field = $_GET['field'];

        $conditions = $this->_get_query_conditions(array(array(

                'field' => $field, //按用户名,店铺名,支付方式名称进行搜索

                'equal' => 'LIKE',

                'name' => 'search_name',

            ), array(

                'field' => 'type',

                'equal' => '=',

                'name' => 'type',

                'type' => 'numeric',

            ), array(

                'field' => 'add_time',

                'name' => 'add_time_from',

                'equal' => '>=',

                'handler' => 'gmstr2time',

            ), array(

                'field' => 'add_time',

                'name' => 'add_time_to',

                'equal' => '<=',

                'handler' => 'gmstr2time_end',

            ), array(

                'field' => 'money',

                'name' => 'order_amount_from',

                'equal' => '>=',

                'type' => 'numeric',

            ), array(

                'field' => 'money',

                'name' => 'order_amount_to',

                'equal' => '<=',

                'type' => 'numeric',

            ),

        ));

        $page = $this->_get_page(10);

        $index = $this->mod_epaylog->find(array(

            'conditions' => 'complete=1' . $conditions,

            'limit' => $page['limit'],

            'order' => "id desc",

            'count' => true));

        $page['item_count'] = $this->mod_epaylog->getCount();

        $this->_format_page($page);

        $this->assign('search_options', $search_options);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件

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

        $this->assign('page_info', $page);

        $this->assign('index', $index);

        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',

                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));

        $this->display('epay.money_log.html');

    }



    //提现记录

    function txlog() {

        $search_options = array(

            'user_name' => Lang::get('user_name'),

            'order_sn' => Lang::get('order_sn'),

        );

        /* 默认搜索的字段是操作名 */

        $field = 'user_name';

        array_key_exists($_GET['field'], $search_options) && $field = $_GET['field'];

        $conditions = $this->_get_query_conditions(array(array(

                'field' => $field, //按用户名,店铺名,支付方式名称进行搜索

                'equal' => 'LIKE',

                'name' => 'search_name',

            ), array(

                'field' => 'states',

                'equal' => '=',

                'name' => 'status',

                'type' => 'numeric',

            ), array(

                'field' => 'add_time',

                'name' => 'add_time_from',

                'equal' => '>=',

                'handler' => 'gmstr2time',

            ), array(

                'field' => 'add_time',

                'name' => 'add_time_to',

                'equal' => '<=',

                'handler' => 'gmstr2time_end',

            ), array(

                'field' => 'money',

                'name' => 'order_amount_from',

                'equal' => '>=',

                'type' => 'numeric',

            ), array(

                'field' => 'money',

                'name' => 'order_amount_to',

                'equal' => '<=',

                'type' => 'numeric',

            ),

        ));

        $page = $this->_get_page(10);

        $index = $this->mod_epaylog->find(array(

            'conditions' => 'type='.EPAY_TX . $conditions,

            'limit' => $page['limit'],

            'order' => "id desc",

            'count' => true));

        $page['item_count'] = $this->mod_epaylog->getCount();

        $this->_format_page($page);

        $this->assign('search_options', $search_options);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件

        $this->assign('tx_status_list', array(

            70 => Lang::get('tx_weishenhe'), //未审核

            71 => Lang::get('tx_yishenhe'), //已审核

        ));

        $this->assign('page_info', $page);

        $this->assign('index', $index);

        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',

                                      'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));

        $this->display('epay.txlog.html');

    }



    //审核操作	

    function tx_view() {

        $log_id = $_GET['log_id'];

        $user_id = $_GET['user_id'];

        $order_id = trim($_POST['order_id']);

        $tx_money = trim($_POST['money']);

        $add_time = gmtime();

        if (!IS_POST) {

            if (empty($log_id) or empty($user_id)) {

                $this->show_warning('feifacanshu');

                return;

            }

            $epaylog = $this->mod_epaylog->get('id=' . $log_id);

            $this->assign('epaylog', $epaylog);

            $this->display('epay.tx_view.html');

            return;

        } else {



            $money_row = $this->mod_epay->getrow("select money_dj from " . DB_PREFIX . "epay where user_id='$user_id'");

            $row_money_dj = $money_row['money_dj'];



            if ($row_money_dj < $tx_money) {

                $this->show_warning('feifacanshu');

                return;

            }



            $new_money_dj = $row_money_dj - $tx_money;

            $new_money = array(

                'money_dj' => $new_money_dj,

            );

            $this->mod_epay->edit('user_id=' . $user_id, $new_money); //读取所有数据库



            $edit_log = array(

                'add_time' => $add_time,

                'states' => 71, //改变状态为已审核	

                'to_id' => $order_id,

                'complete'=>'1'

            );

            $this->mod_epaylog->edit('id=' . $log_id, $edit_log);

        }

        $this->show_message('shenhechenggong', 'fanhuiliebiao', 'index.php?app=epay&act=txlog');

    }



    function setting() {

        $model_setting = &af('settings');

        $setting = $model_setting->getAll(); //载入系统设置数据

        if (!IS_POST) {

            $this->assign('setting', $setting);

            $this->display('epay.setting.html');

        } else {

            //交易佣金比例

            $data['epay_trade_charges_ratio'] = empty($_POST['epay_trade_charges_ratio']) ? 0 : round($_POST['epay_trade_charges_ratio'], 2); 

            

            $data['epay_alipay_enabled'] = $_POST['epay_alipay_enabled']; #是否开启

            $data['epay_chinabank_enabled'] = $_POST['epay_chinabank_enabled']; #是否开启

            $data['epay_tenpay_enabled'] = $_POST['epay_tenpay_enabled']; #是否开启

            $data['epay_wxjs_enabled'] = $_POST['epay_wxjs_enabled']; #是否开启

            $data['epay_wxnative_enabled'] = $_POST['epay_wxnative_enabled']; #是否开启	

            $data['epay_bitebi_enabled'] = $_POST['epay_bitebi_enabled']; #是否开启	

			$data['epay_bitebi_key'] = $_POST['epay_bitebi_key'];

            //支付宝配置文件

            $data['epay_alipay_seller_email'] = $_POST['epay_alipay_seller_email'];

            $data['epay_alipay_partner'] = $_POST['epay_alipay_partner'];

            $data['epay_alipay_key'] = $_POST['epay_alipay_key'];



            //网银支付 chinabank配置文件

            $data['epay_chinabank_mid'] = $_POST['epay_chinabank_mid'];

            $data['epay_chinabank_key'] = $_POST['epay_chinabank_key'];





            //财付通配置文件

            $data['epay_tenpay_bargainor_id'] = $_POST['epay_tenpay_bargainor_id'];

            $data['epay_tenpay_key'] = $_POST['epay_tenpay_key'];



            //微信配置信息

            $data['epay_wx_appid'] = $_POST['epay_wx_appid']; 

            $data['epay_wx_key'] = $_POST['epay_wx_key'];

            $data['epay_wx_mch_id'] = $_POST['epay_wx_mch_id'];

            $data['epay_wx_secret'] = $_POST['epay_wx_secret'];



            

            //线下汇款信息

            $data['epay_offline_info'] = $_POST['epay_offline_info'];

			

            

            $model_setting->setAll($data);



            $this->show_message('setting_successed');

        }

    }



}

