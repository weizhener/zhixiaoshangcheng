<?php



/**

 * 积分记录操作

 */

class Integral_goods_logApp extends BackendApp {



    var $_integral_goods_log_mod;



    function __construct() {

        $this->Integral_goods_logApp();

    }



    function Integral_goods_logApp() {

        parent::BackendApp();

        $this->_integral_goods_log_mod = & m('integral_goods_log');

    }



    function index() {

        $conditions = $this->_get_query_conditions(array(array(

                'field' => 'goods_name',

                'equal' => 'LIKE',

                'assoc' => 'AND',

                'name' => 'goods_name',

                'type' => 'string',

            ), array(

                'field' => 'state',

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

            ), array(

                'field' => 'user_name',

                'equal' => 'LIKE',

                'assoc' => 'AND',

                'name' => 'user_name',

                'type' => 'string',

            ),

        ));



        $page = $this->_get_page(10);   //获取分页信息

        //获取统计数据

        $integral_goods_log_list = $this->_integral_goods_log_mod->find(array(

            'conditions' => '1=1 ' . $conditions,

            'limit' => $page['limit'],

            'order' => "add_time desc",

            'count' => true   //允许统计

        ));



        $states = array(

            0 => Lang::get('wait'),

            1 => Lang::get('send'),
		    2 => "退货中",
				
				3 => "已退货",

        );

        $this->assign('states', $states);



        foreach ($integral_goods_log_list as $key => $integral_goods_log) {

            $integral_goods_log_list[$key]['state'] = $states[$integral_goods_log['state']];

        }



        $page['item_count'] = $this->_integral_goods_log_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);



        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',

            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css'));



        $this->assign('integral_goods_log_list', $integral_goods_log_list);

        $this->display('integral_goods_log.index.html');

    }



    function edit() {

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $integral_goods_log = $this->_integral_goods_log_mod->get($id);

        if (empty($integral_goods_log)) {

            $this->show_warning('no_such_integral_goods_log');

            return;

        }



        if (!IS_POST) {



            $states = array(

                0 => Lang::get('wait'),

                1 => Lang::get('send'),
				
				2 => "退货中",
				
				3 => "已退货",

            );

            $this->assign('states', $states);



            $this->assign('integral_goods_log', $integral_goods_log);

            $this->display('integral_goods_log.form.html');

        } else {



            $data = array(

                'my_name' => $_POST['my_name'],

                'my_address' => $_POST['my_address'],

                'my_mobile' => $_POST['my_mobile'],

                'my_remark' => $_POST['my_remark'],

                'wuliu_name' => $_POST['wuliu_name'],

                'wuliu_danhao' => $_POST['wuliu_danhao'],

                'state' => $_POST['state'],

            );



            $this->_integral_goods_log_mod->edit($id, $data);

            

            

            $this->show_message('edit_successed',

                'back_list',        'index.php?app=integral_goods_log',

                'edit_again',    'index.php?app=integral_goods_log&amp;act=edit&amp;id=' . $id);

            

            

        }

    }



}

