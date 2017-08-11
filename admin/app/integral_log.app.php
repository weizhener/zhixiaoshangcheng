<?php



/* 会员积分控制器 */



class integral_logApp extends BackendApp {



    var $_integral_log_mod;



    function __construct() {

        $this->User_pointApp();

    }



    function User_pointApp() {

        parent::__construct();

        $this->_integral_log_mod = & m('integral_log');

    }



    function index() {

        //此处是获得用户的积分记录

        $conditions .= $this->_get_query_conditions(array(

            array(

                'field' => 'user_name', //可搜索字段title

                'equal' => 'LIKE', //等价关系,可以是LIKE, =, <, >, <>

                'assoc' => 'AND', //关系类型,可以是AND, OR

                'name' => 'user_name', //GET的值的访问键名

                'type' => 'string', //GET的值的类型

            ), array(

                'field' => 'integral_type',

                'equal' => '=',

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

            ),

        ));



        $page = $this->_get_page(10);   //获取分页信息

        //获取统计数据

        $integral_logs = $this->_integral_log_mod->find(array(

            'conditions' => '1=1 ' . $conditions,

            'limit' => $page['limit'],

            'order'         => "add_time desc",

            'count' => true   //允许统计

            

        ));

        $page['item_count'] = $this->_integral_log_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件





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
			
			INTEGRAL_DZP => Lang::get('integral_dzp'), #大转盘积分类型
			
			INTEGRAL_DZP2 => Lang::get('integral_dzp2'), #开金花积分类型
			
			INTEGRAL_DATE => Lang::get('integral_date'), #每日返利积分类型

        ));



        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',

            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css'));



        $this->assign('integral_logs', $integral_logs);

        $this->display('integral_log.index.html');

    }



    //设置积分获取规则

    function set() {



        $model_setting = &af('settings');

        $setting = $model_setting->getAll(); //载入系统设置数据

        //print_r($setting);

        if (!IS_POST) {

            $this->assign('setting', $setting);

            $this->display('integral_log.set.html');

        } else {

            $data['integral_enabled'] = $_POST['integral_enabled']; #是否开启

            $data['integral_reg'] = empty($_POST['integral_reg']) ? 0 : intval($_POST['integral_reg']);        #注册获得积分

            $data['integral_login'] = empty($_POST['integral_login']) ? 0 : intval($_POST['integral_login']);  #登录获得积分

            $data['integral_recom'] = empty($_POST['integral_recom']) ? 0 : intval($_POST['integral_recom']);  #推荐获得积分

            $data['integral_buy'] = empty($_POST['integral_buy']) ? 0 : round($_POST['integral_buy'], 2);   #购买获得积分

            $data['integral_seller'] = empty($_POST['integral_seller']) ? 0 : round($_POST['integral_seller'], 2);   #用户购买抵扣积分 比例

            $model_setting->setAll($data);

            $this->show_message('edit_ok');

        }

    }



}



?>

