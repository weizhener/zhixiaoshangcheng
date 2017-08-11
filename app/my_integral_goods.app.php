<?php



/**

 * 积分产品兑换

 */

class My_integral_goodsApp extends MemberbaseApp {



    var $_integral_goods_mod;

    var $_integral_goods_log_mod;

    var $_user_id;



    function __construct() {

        $this->My_integral_goodsApp();

    }



    function My_integral_goodsApp() {

        parent::__construct();

        

        //判断积分操作是否开启 未开启直接返回

        if (!Conf::get('integral_enabled')) {

            $this->show_warning('未开启积分');exit;

            return;

        }

        

        $this->_integral_goods_mod = & m('integral_goods');

        $this->_integral_goods_log_mod = & m('integral_goods_log');

        $this->_user_id = $this->visitor->get('user_id');

    }



    /**

     * 显示所有积分产品

     */

    function index() {

        $page = $this->_get_page(10);   //获取分页信息

        //获取统计数据

        $integral_goods_list = $this->_integral_goods_mod->find(array(

            'conditions' => '1=1 ' . $conditions,

            'limit' => $page['limit'],

            'order' => "add_time desc",

            'count' => true   //允许统计

        ));
		
		
        foreach ($integral_goods_list as $key => $integral_goods){
			
			empty($integral_goods['goods_logo']) && $integral_goods_list[$key]['goods_logo'] = Conf::get('default_goods_image');

        }



        $page['item_count'] = $this->_integral_goods_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);



        /* 当前用户中心菜单 */

        $this->_curitem('my_integral_goods');

        $this->_curmenu('my_integral_goods');

        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_integral_goods'));



        $this->assign('integral_goods_list', $integral_goods_list);

        $this->display('my_integral_goods.index.html');

    }

    function tui() {

        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $integral_goods_log = $this->_integral_goods_log_mod->get($id);
		
		
		

        if (empty($integral_goods_log)) {

            $this->show_warning('对不起，非法操作');

            return;

        }
		
        if ($integral_goods_log['add_time']+1800<time()) {

            $this->show_warning('对不起，已经超时');

            return;

        }


        if (!IS_POST) {

            /* 当前用户中心菜单 */

            $this->_curitem('my_integral_goods');

            $this->_curmenu('my_integral_goods');

            $this->_config_seo('title', Lang::get('member_center'));



            $this->assign('integral_goods_log', $integral_goods_log);

            $this->display('my_integral_goods.tui.html');

        } else {


            $data = array(

                'truename' => $_POST['truename'],

                'bankcard' => $_POST['bankcard'],

                'bankname' => $_POST['bankname'],

                'bankadd' => $_POST['bankadd'],

                'state' => 2,



            );

            $this->_integral_goods_log_mod->edit($integral_goods_log['id'],$data);

            $this->show_message('add_ok', 'back_list', 'index.php?app=my_integral_goods&act=log');

        }

    }

    /**

     * 添加兑换申请  此处并不扣除积分，当管理员审核通过之后 才扣除积分

     */

    function add() {

        $goods_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        $integral_goods = $this->_integral_goods_mod->get($goods_id);

        if (empty($integral_goods)) {

            $this->show_warning('no_such_integral_goods');

            return;

        }



        if ($integral_goods['goods_stock'] < 1) {

            $this->show_warning('no_goods_stock');

            return;

        }



        if (!IS_POST) {

            /* 当前用户中心菜单 */

            $this->_curitem('my_integral_goods');

            $this->_curmenu('my_integral_goods');

            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_integral_goods_add'));



            $this->assign('integral_goods', $integral_goods);

            $this->display('my_integral_goods.add.html');

        } else {

            $my_num = intval($_POST['my_num']);

            

            if($my_num<1){

                $this->show_warning('error');

                return;

            }

            

            //判断当前是否有足够的兑换数量

            if ($integral_goods['goods_stock'] < $my_num) {

                $this->show_warning('greater_goods_stock');

                return;

            }



            $member_mod = &m('member');

            $member = $member_mod->get($this->_user_id);



            //判断当前用户的可用积分  是否可以兑换这么多产品

            $point = $integral_goods['goods_point'] * $my_num;

            if ($point > $member['integral']) {

                $this->show_warning('no_such_point');

                return;

            }



            //加入产品兑换记录

            $data = array(

                'goods_id' => $integral_goods['goods_id'],

                'goods_name' => $integral_goods['goods_name'],
				
				'money' => $integral_goods['goods_price'],

                'user_id' => $member['user_id'],

                'user_name' => $member['user_name'],

                'my_name' => $_POST['my_name'],

                'my_address' => $_POST['my_address'],

                'my_mobile' => $_POST['my_mobile'],

                'my_remark' => $_POST['my_remark'],

                'my_num' => $_POST['my_num'],

                'add_time'=> gmtime(),

            );

            $this->_integral_goods_log_mod->add($data);

            

            

            //更新积分回购库存数量

            $this->_integral_goods_mod->edit($goods_id,array('goods_stock'=>$integral_goods['goods_stock']-$my_num,'goods_stock_exchange'=>$integral_goods['goods_stock_exchange']+$my_num));

            



            //写入记录 扣除积分

            $member_mod->edit($this->_user_id, array('integral' => $member['integral'] - $point));





            //操作记录入积分记录

            $integral_log_mod = &m('integral_log');

            $integral_log = array(

                'user_id' => $this->_user_id,

                'user_name' => $member['user_name'],

                'point' => $point,

                'add_time' => gmtime(),

                'remark' => '积分回购' . $point,

                'integral_type' => INTEGRAL_GOODS,

            );

            $integral_log_mod->add($integral_log);



            $this->show_message('add_ok', 'back_list', 'index.php?app=my_integral_goods&act=log'

            );

        }

    }

    

    //获取兑换记录

    function log()

    {

        $conditions = '';

        $page = $this->_get_page(10);   //获取分页信息

        //获取统计数据

        $integral_goods_log_list = $this->_integral_goods_log_mod->find(array(

            'conditions' => 'user_id =  '.$this->_user_id . $conditions,

            'limit' => $page['limit'],

            'order' => "add_time desc",

            'count' => true   //允许统计

        ));



        $states = array(

            0      => Lang::get('wait'),

            1    => Lang::get('send'),
			
			2    => Lang::get('tui'),
			
			3    => Lang::get('yestui'),

        );

        

        foreach ($integral_goods_log_list as $key => $integral_goods_log){

            $integral_goods_log_list[$key]['state'] = $states[$integral_goods_log['state']];
			
			

        }

        

        

        $page['item_count'] = $this->_integral_goods_log_mod->getCount();

        $this->_format_page($page);

        $this->assign('page_info', $page);



        /* 当前用户中心菜单 */

        $this->_curitem('my_integral_goods');

        $this->_curmenu('my_integral_goods_log');

        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_integral_goods_log'));



        $this->assign('integral_goods_log_list', $integral_goods_log_list);

        $this->display('my_integral_goods.log.html');

    }

    



    function _get_member_submenu() {

        $menus = array(
		
		
			
            array(

                'name' => 'my_integral_goods',

                'url' => 'index.php?app=my_integral_goods',

            ),

            array(

                'name' => 'my_integral_goods_log',

                'url' => 'index.php?app=my_integral_goods&act=log',

            ),


        );

        return $menus;

    }



}

