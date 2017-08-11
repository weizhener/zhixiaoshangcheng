<?php



/**

 * 积分记录

 */

class my_integral_logApp extends MemberbaseApp {



    function __construct() {

        $this->my_integral_logApp();

    }



    function my_integral_logApp() {

        parent::__construct();

        

        //判断积分操作是否开启 未开启直接返回

        if (!Conf::get('integral_enabled')) {

            $this->show_warning('未开启积分');exit;

            return;

        }

    }

    

    function index() {

        $user_id = $this->visitor->get('user_id');

        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_integral_log'));

        $this->_curitem('my_integral_log');



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

            ), array(

                'field' => 'integral_type',

                'equal' => '=',

                'type' => 'numeric',

            ),

        ));



        $page = $this->_get_page(10);



        $integral_log_mod = &m('integral_log');

        $integral_logs = $integral_log_mod->find(array(

            'conditions' => 'user_id=' . $this->visitor->get('user_id') . $conditions,

            'limit' => $page['limit'],

            'order' => 'add_time desc',

            'count' => true

        ));

        $page['item_count'] = $integral_log_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);



        //获取积分类型

        $this->assign('integral_type_list', array(

            //INTEGRAL_REG => Lang::get('integral_reg'), #注册赠送积分类型

            //INTEGRAL_LOGIN => Lang::get('integral_login'), #登录赠送积分类型

            //INTEGRAL_RECOM => Lang::get('integral_recom'), #推荐赠送积分类型

            //INTEGRAL_BUY => Lang::get('integral_buy'), #购买赠送积分类型

            INTEGRAL_SELLER => Lang::get('integral_seller'), #抵扣扣除积分类型

            INTEGRAL_ADD => Lang::get('integral_add'), #管理员增加积分

            INTEGRAL_SUB => Lang::get('integral_sub'), #管理员减少积分

            INTEGRAL_EGG => Lang::get('integral_egg'), #砸金蛋扣除积分类型

            INTEGRAL_GOODS => Lang::get('integral_goods'), #兑换礼品扣除积分类型
			
			INTEGRAL_DZP => Lang::get('integral_dzp'), #开金花积分类型
			
			INTEGRAL_DZP2 => Lang::get('integral_dzp2'), #开金花积分类型
			
			INTEGRAL_DATE => Lang::get('integral_date'), #每日返利积分类型

        ));

        

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件



        $this->assign('integral_logs', $integral_logs);



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

        

        $this->display('my_integral_log.index.html');

    }



}

