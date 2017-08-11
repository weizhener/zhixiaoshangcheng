<?php



class integralApp extends MallbaseApp {

    

    var $_user_id;

    var $_goods_mod;

    var $_integral_goods_mod;

    

    

    function __construct() {

        $this->integralApp();

    }



    function integralApp() {

        parent::__construct();

        //判断积分操作是否开启 未开启直接返回

        if (!Conf::get('integral_enabled')) {

            $this->show_warning('未开启积分');exit;

            return;

        }

        $this->_user_id = $this->visitor->get('user_id');

        $this->_goods_mod = & m('goods');

        $this->_integral_goods_mod = & m('integral_goods');

    }

    

    

    function index()

    {

        //判断用户是否登录 登录则获得用户相关信息

        if ($this->_user_id) {

            $user_mod = & m('member');

            $user = $user_mod->get_info($this->_user_id);

            $user['ugrade'] = $user_mod->get_grade_info($user['user_id']);

            $user['portrait'] = portrait($user['user_id'], $info['portrait'], 'middle');

            $this->assign('user', $user);

        }





        $page = $this->_get_page(16);   //获取分页信息



        //获取积分产品 按照抵扣数额排列

        $conditions = 'goods_id > 0';

        $goods_list = $this->_integral_goods_mod->find(array(

            'conditions' => $conditions,

            'order' => 'goods_id desc', 

            'limit' => $page['limit'],

            'count' => true   //允许统计

        ));

        foreach ($goods_list as $key => $goods) {

            empty($goods['goods_logo']) && $goods_list[$key]['goods_logo'] = Conf::get('default_goods_image');

        }

        $this->assign('goods_list', $goods_list);

        

        $page['item_count'] = $this->_goods_mod->getCount();   //获取统计数据

        $this->_format_page($page);

        $this->assign('page_info', $page);

        

        

        $this->display('integral.index.html');

    }

    
    function view()
    {
    	$id = empty($_GET['id']) ? 0 : $_GET['id'];
		
		$userid = $this->visitor->get("user_id");		
        $member_mod = &m('member');
        $member = $member_mod->get($userid);
		
		if(!$userid){
			$this->show_warning('请登录后操作');
		  	exit;
	    }
		
    	$integral_info = $this->_integral_goods_mod->get_info($id);
		

		
        $this->mod_epay_bank = & m('epay_bank');
        $bank_list = $this->mod_epay_bank->find(array('conditions'=>'user_id='.$this->visitor->get('user_id')));

		if(!$bank_list){
			$this->show_warning('<a href="index.php?app=epay&act=bank_add">请先设置后银行信息后操作,马上设置</a>');
			exit;
		  	
	    }
		foreach($bank_list as $val){
		  if($val){
				$bankname = $val['bank_name'];
				$bankcard = $val['bank_num'];
				$bankadd = $val['open_bank'];
				$my_name = $val['account_name'];
				break;
		  }	
		}
		$money = $integral_info['goods_point'];
		
		if($member['integral'] < $money){
		 $this->show_warning('你的积分不足');
		 exit;
		 }
		
		
            $member_mod->edit($userid, array('integral' => $member['integral'] - $money));
            //操作记录入积分记录
            $integral_log_mod = &m('integral_log');
            $integral_log = array(
                'user_id' => $userid,
                'user_name' => $member['user_name'],
                'point' => $money,
                'add_time' => gmtime(),
                'remark' => '积分回购',
                'integral_type' => INTEGRAL_GOODS,
            );
            $integral_log_mod->add($integral_log);
			
			
            $integral_goods_log_mod = &m('integral_goods_log');
            $integral_goods_log = array(
				'goods_id' => $integral_info['goods_id'],
				'goods_name' => $integral_info['goods_name'],
				'user_id' => $userid,
				'user_name' => $member['user_name'],
				'my_mobile' => $member['phone_tel'],
				'bankname' => $bankname,
                'bankcard' => $bankcard,
                'bankadd' => $bankadd,
				'my_name' => $my_name,
                'money' => $integral_info['goods_point'],
                'add_time' => gmtime(),
            );
            $integral_goods_log_mod->add($integral_goods_log);
			
			

			
			
			
		$this->show_message('回购成功，等待管理员审核', 'index', 'index.php?app=integral');
		print_r($integral_info);
		exit;
    }
    

}

