<?php



/* 会员控制器 */



class UserApp extends BackendApp {



    var $_admin_mod;

    var $_user_mod;

	 var $weixin_user;



    function __construct() {

        $this->UserApp();

    }



    function UserApp() {

        parent::__construct();

        $this->_user_mod = & m('member');

        $this->_admin_mod = & m('userpriv');

		$this->weixin_user =& m('weixinuser');

		$this->epay_mod = & m('epay');

    }



    function index() {

        $conditions = $this->_get_query_conditions(array(

            array(

                'field' => $_GET['field_name'],

                'name' => 'field_value',

                'equal' => 'like',

            ),

        ));

        //更新排序

        if (isset($_GET['sort']) && !empty($_GET['order'])) {

            $sort = strtolower(trim($_GET['sort']));

            $order = strtolower(trim($_GET['order']));

            if (!in_array($order, array('asc', 'desc'))) {

                $sort = 'user_id';

                $order = 'asc';

            }

        } else {

            if (isset($_GET['sort']) && empty($_GET['order'])) {

                $sort = strtolower(trim($_GET['sort']));

                $order = "";

            } else {

                $sort = 'user_id';

                $order = 'desc';

            }

        }

        $page = $this->_get_page();

        $users = $this->_user_mod->find(array(

            'join' => 'has_store,manage_mall',

            'fields' => 'this.*,store.store_id,userpriv.store_id as priv_store_id,userpriv.privs',

            'conditions' => '1=1' . $conditions,

            'limit' => $page['limit'],

            'order' => "$sort $order",

            'count' => true,

        ));
$member_mod = &m('member');
        foreach ($users as $key => $val) {

            if ($val['priv_store_id'] == 0 && $val['privs'] != '') {

                $users[$key]['if_admin'] = true;

            }
			
			$t = $member_mod->get($val['referid']);	  
	        $users[$key]['_user_name'] = $t['user_name'];
			$users[$key]['_real_name'] = $t['real_name'];

        }

        $this->assign('users', $users);

        $page['item_count'] = $this->_user_mod->getCount();

        $this->_format_page($page);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件

        $this->assign('page_info', $page);

        /* 导入jQuery的表单验证插件 */

        $this->import_resource(array(

            'script' => 'jqtreetable.js,inline_edit.js',

            'style' => 'res:style/jqtreetable.css'

        ));

        $this->assign('query_fields', array(

            'user_name' => LANG::get('user_name'),

            'email' => LANG::get('email'),

            'real_name' => LANG::get('real_name'),

//            'phone_tel' => LANG::get('phone_tel'),

              'phone_mob' => LANG::get('phone_mob'),

        ));

        $this->assign('sort_options', array(

            'reg_time DESC' => LANG::get('reg_time'),

            'last_login DESC' => LANG::get('last_login'),

            'logins DESC' => LANG::get('logins'),

        ));

        $this->assign('if_system_manager', $this->_admin_mod->check_system_manager($this->visitor->get('user_id')) ? 1 : 0);

        $this->display('user.index.html');

    }

	

	

function daili()

{

$daili_mod =& m('daili');





$daili_list= $daili_mod->find(array(

           'conditions' => '1=1' . $conditions,

            'limit' => $page['limit'],

            'order' => "id desc",

            'count' => true,

        ));



foreach($daili_list as $key=>$val)

{

 $diqu = unserialize($val['diqu']);

           

$daili_list[$key]['dqlist']= str_replace('中国	','',$diqu) ;



}		

	

   $this->assign('daili_list', $daili_list);

   $this->display('user.daili.html');



}







    function _get_regions()

    {

        $model_region =& m('region');

        $regions = $model_region->get_list(0);

        if ($regions)

        {

            $tmp  = array();

            foreach ($regions as $key => $value)

            {

                $tmp[$key] = $value['region_name'];

            }

            $regions = $tmp;

        }

        $this->assign('regions', $regions);

    }



function dailiadd()

{

   $daili_mod =& m('daili');

   

    $id = empty($_GET['id']) ? 0 : $_GET['id'];

  if (!IS_POST){

	  if($id)

	  {

	  

	   $this->_get_regions();

	   $daili_info= $daili_mod->get($id);

	     $cod_regions = unserialize($daili_info['diqu']);

            !$cod_regions && $cod_regions = array();



           

            $this->assign('cod_regions', $cod_regions);

	   

	   $this->assign('user', $daili_info);

	 }

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

                      'path' => 'jquery.plugins/jquery.validate.js',

                      'attr' => '',

                   ),

                   array(

                      'path' => 'mlselection.js',

                      'attr' => '',

                   ),

          ),

          'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css,res:jqtreetable.css',

        ));

		

		

		

	 

    $this->display('user.dailiadd.html');

  

  }else

  {

  

   $title=$_POST['title'];

   $user_id=$_POST['user_id'];



   if(!$user_id)

   {

   $this->show_warning('请输入会员id');



      return;	

   }

   

   $user_info=$this->_user_mod->get($user_id);

   

   

   

   if(!$user_info)

   {

   $this->show_warning('会员id不存在');



      return;	

   }

   

   $data=array(

    'title'=>$title,

	'user_id'=>$user_id,

    'user_name'=>$user_info['user_name'],

    'tjbl'=>$_POST['tjbl'],

    );

	

	   if (!empty($_POST['cod_regions']))

            {

                $data['diqu']    =   serialize($_POST['cod_regions']);

            }

	 if($id)

	 {

		  $daili_mod->edit($id,$data);

	 }else

	 {

		 $daili_mod->add($data);

	  }

  

  $this->show_message('提交成功','返回','index.php?app=user&act=daili'); 

  

  }

}



function send()

{

	  $id = empty($_GET['wxid']) ? 0 : $_GET['wxid'];

	  

	  

	  

	     if (!IS_POST){

	$wxmessage =& m('wxmessage');

    $wxmessage_list = $wxmessage->find(array(

          'conditions' => "1=1 AND wxid='$id'",

            'limit'=>'5',

			 'order' => "id desc",

        ));

		$weixinuser=& m('weixinuser');

	  $wxinfo= $weixinuser->get("wxid='$id'");

	

	   $this->assign('wxinfo', $wxinfo);

	  $this->assign('wxmessage_list', $wxmessage_list);

	//print_r($wxmessage_List);

	$this->display('wx.from.html');

	}else{

	$wxid = $_POST['wxid'];

    $content = $_POST['msg_content'];

    $uid = $_POST['uid'];

    $time = time();

	

	 if(empty($content))

     {

	 $this->show_warning('内容不能为空');



      return;	 

		 

	  }	 	

		

		  import('weixin.lib');

      	$wxconfig=	& m('wxconfig');

		

	   $config = $wxconfig->get_info_user(2);

	   

	      if (empty($config)) {

            exit;

        }

	    $token = $config['token'];

        $ACCESS_LIST = Init_Weixin::curl($config['appid'], $config['appsecret']);

         $access_token= $ACCESS_LIST['access_token'];

	   

	   

        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;

        

        $post_msg = '{

            "touser":"'.$wxid.'",

            "msgtype":"text",

            "text":

            {

                 "content":"'.$content.'"

            }

        }';

		

		

		  $ret_json = $this->curl_grab_page($url, $post_msg);

        $ret = json_decode($ret_json);

		

	 if($ret->errcode == '40001')

      {

			 $this->show_warning('您公众号不支持接口');



      return;	  

	  }   elseif($ret->errcode == '45015')

        {

           

			

	 $this->show_warning('回复时间超过限制');



      return;

			

     }     elseif($ret->errcode == '0')

        {

            

		$data=array(

   'wxid'=>$wxid,

   'w_message'=>$content,

   'dateline'=>time(),

 

   );	

$wxmessage =& m('wxmessage');

 $wxmessage->add($data);	

 

   $this->show_message('回复成功' );

 

        }

		

		

		}

	

}







function view()

{



   $id = empty($_GET['wxid']) ? 0 : $_GET['wxid'];

	  

	    $conditions = $this->_get_query_conditions(array(

            array(

                'field' => $_GET['field_name'],

                'name'  => 'field_value',

                'equal' => 'like',

            ),

        )); 

	  

	  $page = $this->_get_page();

	$wxmessage =& m('wxmessage');

    $wxmessage_list = $wxmessage->find(array(

          'conditions' => "1=1 AND wxid='$id' ".$conditions,

             'limit' => $page['limit'],

			   'count' => true,

			 'order' => "id desc",

        ));

		

	    $page['item_count'] = $this->_user_mod->getCount();

        $this->_format_page($page);	

	$weixinuser=& m('weixinuser');

	$wxinfo= $weixinuser->get("wxid='$id'");

	

	 $this->assign('page_info', $page);

	 $this->assign('id', $id);

    $this->assign('wxinfo', $wxinfo);

	$this->assign('wxmessage_list', $wxmessage_list);

	    $this->assign('query_fields', array(

            'message' =>"发送内容",

			  'w_message' =>"回复内容",

    

        ));

     $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件

    $this->display('wx.view.html');

}



function curl_grab_page($url,$data,$proxy='',$proxystatus='',$ref_url='')

{

 $ch = curl_init();

 curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");

 curl_setopt($ch, CURLOPT_TIMEOUT, 1);

 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

 if ($proxystatus == 'true') {

     curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);

     curl_setopt($ch, CURLOPT_PROXY, $proxy);

 }

 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

 curl_setopt($ch, CURLOPT_URL, $url);

if(!empty($ref_url)){

     curl_setopt($ch, CURLOPT_HEADER, TRUE);

     curl_setopt($ch, CURLOPT_REFERER, $ref_url);

}

 curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);

 @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);

 curl_setopt($ch, CURLOPT_POST, TRUE);

 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

 ob_start();

 return curl_exec ($ch); // execute the curl command

 ob_end_clean();

 curl_close ($ch);

 unset($ch);

}





function weixin()

{

	

  

  $conditions = $this->_get_query_conditions(array(

            array(

                'field' => $_GET['field_name'],

                'name'  => 'field_value',

                'equal' => 'like',

            ),

        ));

        //更新排序

        if (isset($_GET['sort']) && !empty($_GET['order']))

        {

            $sort  = strtolower(trim($_GET['sort']));

            $order = strtolower(trim($_GET['order']));

            if (!in_array($order,array('asc','desc')))

            {

             $sort  = 'user_id';

             $order = 'asc';

            }

        }

        else

        {

            if (isset($_GET['sort']) && empty($_GET['order']))

            {

                $sort  = strtolower(trim($_GET['sort']));

                $order = "";

            }

            else

            {

                $sort  = 'uid';

                $order = 'DESC';

            }

        }

		

		

        $page = $this->_get_page(10);

		

        $users = $this->weixin_user->find(array(

          'join' => 'belongs_to_user',

            'conditions' => '1=1' . $conditions,

            'limit' => $page['limit'],

            'order' => "$sort $order",

            'count' => true,

        ));

		



    

        $this->assign('users', $users);

        $page['item_count'] = $this->weixin_user->getCount();

        $this->_format_page($page);

        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件

        $this->assign('page_info', $page);

        /* 导入jQuery的表单验证插件 */

        $this->import_resource(array(

            'script' => 'jqtreetable.js,inline_edit.js',

            'style'  => 'res:style/jqtreetable.css'

        ));

        $this->assign('query_fields', array(

            'nickname' =>"微信用户名",

     'user_name' =>"用户名",

        ));

        $this->assign('sort_options', array(

            'subscribe_time DESC'   => '关注时间',

          

        ));

		$this->assign('if_system_manager', $this->_admin_mod->check_system_manager($this->visitor->get('user_id')) ? 1 : 0);

     

  	

	

	



  $this->display('wx.index.html');

}





    function super_login() {

        

        $user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;

        $_SESSION['super_user_id'] = $user_id;

        $url = 'Location:'.SITE_URL.'/index.php?app=member';

        header($url);

    }



    function add() {

        if (!IS_POST) {

            $this->assign('user', array(

                'gender' => 0,

            ));

            /* 导入jQuery的表单验证插件 */

            $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js'

            ));

            

            //获取会员等级信息 by qufood

            $ugrade_mod = &m('ugrade'); 

            $member_mod = &m('member');

            $user = $user + $member_mod->get_grade_info($id);

            $ugrades = $ugrade_mod->get_option('grade_name');

            $this->assign('ugrades', $ugrades);

            //

            

            $ms = & ms();

            $this->assign('set_avatar', $ms->user->set_avatar());

            $this->display('user.form.html');

        } else {

            $user_name = trim($_POST['user_name']);

            $password = trim($_POST['password']);

            $email = trim($_POST['email']);

            $real_name = trim($_POST['real_name']);

            $gender = trim($_POST['gender']);

            $im_qq = trim($_POST['im_qq']);

            $im_msn = trim($_POST['im_msn']);



            if (strlen($user_name) < 3 || strlen($user_name) > 25) {

                $this->show_warning('user_name_length_error');



                return;

            }



            if (strlen($password) < 6 || strlen($password) > 20) {

                $this->show_warning('password_length_error');



                return;

            }



            if (!is_email($email)) {

                $this->show_warning('email_error');



                return;

            }

            





            /* 连接用户系统 */

            $ms = & ms();



            /* 检查名称是否已存在 */

            if (!$ms->user->check_username($user_name)) {

                $this->show_warning($ms->user->get_error());



                return;

            }



            /* 保存本地资料 */

            $data = array(

                'real_name' => $_POST['real_name'],

                'gender' => $_POST['gender'],

//                'phone_tel' => join('-', $_POST['phone_tel']),

                'phone_mob' => $_POST['phone_mob'],

                'im_qq' => $_POST['im_qq'],

                'im_msn' => $_POST['im_msn'],

//                'im_skype'  => $_POST['im_skype'],

//                'im_yahoo'  => $_POST['im_yahoo'],

//                'im_aliww'  => $_POST['im_aliww'],

                'reg_time' => gmtime(),

            );



            /* 到用户系统中注册 */

            $user_id = $ms->user->register($user_name, $password, $email, $data);

            if (!$user_id) {

                $this->show_warning($ms->user->get_error());



                return;

            }



            if (!empty($_FILES['portrait'])) {

                $portrait = $this->_upload_portrait($user_id);

                if ($portrait === false) {

                    return;

                }



                $portrait && $this->_user_mod->edit($user_id, array('portrait' => $portrait));

            }





            $this->show_message('add_ok', 'back_list', 'index.php?app=user', 'continue_add', 'index.php?app=user&amp;act=add'

            );

        }

    }

     

	 

	 

	 /**

	*-- 客户统计列表

	*/

	function user_list()

	{

	        $model_setting = &af('settings');

        	$setting = $model_setting->getAll(); //载入系统设置数据

			$this->assign('setting', $setting);

		$user_mod =& m('member');

		/* 取得会员总数 */

		$user_num  = $user_mod->getOne("SELECT COUNT(*) FROM " . DB_PREFIX . "member");

		/* 计算订单各种费用之和的语句*/

		/* 有过订单的会员数 */

		$have_order_usernum = $user_mod->getOne("SELECT COUNT(DISTINCT buyer_id) FROM " . DB_PREFIX . "order");

		/* 会员订单总数和订单总购物额 */

		$user_all_order  = $user_mod->getOne("SELECT COUNT(*) FROM " . DB_PREFIX . "order  WHERE status = '" . ORDER_FINISHED . "'");

		$order_amount  =  $user_mod->getOne("SELECT SUM(order_amount) FROM " . DB_PREFIX . "order WHERE status = '" . ORDER_FINISHED . "'");

		$this->assign('user_num',$user_num);

		$this->assign('have_order_usernum',$have_order_usernum);

		$this->assign('user_all_order',$user_all_order);

		/* 注册会员购买率 */

		$this->assign('user_ratio', sprintf("%0.2f", ($user_num > 0 ? $have_order_usernum / $user_num : 0) * 100));

    

		/* 每会员平均订单数及购物额 */

		$this->assign('ave_user_ordernum',  $user_num > 0 ? sprintf("%0.2f", $user_all_order / $user_num) : 0);

		$this->assign('ave_user_turnover', $user_num > 0 ? sprintf("%0.2f",$order_amount / $user_num) : 0);

		$this->assign('order_amount',$order_amount);

		$this->display('guest_stats.htm'); 

	}

    /* 检查会员名称的唯一性 */



    function check_user() {

        $user_name = empty($_GET['user_name']) ? null : trim($_GET['user_name']);

        if (!$user_name) {

            echo ecm_json_encode(false);

            return;

        }



        /* 连接到用户系统 */

        $ms = & ms();

        echo ecm_json_encode($ms->user->check_username($user_name));

    }



    function edit() {

	$ugrade_mod=&m('ugrade');//by qufood

        

        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);

        //判断是否是系统初始管理员，如果是系统管理员，必须是自己才能编辑，其他管理员不能编辑系统管理员

        if ($this->_admin_mod->check_system_manager($id) && !$this->_admin_mod->check_system_manager($this->visitor->get('user_id'))) {

            $this->show_warning('system_admin_edit');

            return;

        }

        if (!IS_POST) {

            /* 是否存在 */

            $user = $this->_user_mod->get_info($id);

            if (!$user) {

                $this->show_warning('user_empty');

                return;

            }



            //获取会员等级信息 by qufood

            $member_mod = &m('member');

            $user = $user + $member_mod->get_grade_info($id);

            $ugrades = $ugrade_mod->get_option('grade_name');

            $this->assign('ugrades', $ugrades);

            //

            

            $ms = & ms();

            $this->assign('set_avatar', $ms->user->set_avatar($id));

            $this->assign('user', $user);

            $this->assign('phone_tel', explode('-', $user['phone_tel']));

            /* 导入jQuery的表单验证插件 */

            $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js'

            ));

            $this->display('user.form.html');

        } else {

            $data = array(

                'real_name' => $_POST['real_name'],

                'gender' => $_POST['gender'],

//                'phone_tel' => join('-', $_POST['phone_tel']),

                'phone_mob' => $_POST['phone_mob'],

                'im_qq' => $_POST['im_qq'],

                'im_msn' => $_POST['im_msn'],

				'referid' => $_POST['referid'],

//                'im_skype'  => $_POST['im_skype'],

//                'im_yahoo'  => $_POST['im_yahoo'],

//                'im_aliww'  => $_POST['im_aliww'],

            );

            

            //当输入积分大于 0 

            $point = intval($_POST['point']);

            if ($point > 0) {

                $user = $this->_user_mod->get_info($id);

                //选项为 增加积分

                if ($_POST['point_change'] == 'inc_by') {

                    $data['integral'] = $user['integral'] + $point;

                    $data['total_integral'] = $user['total_integral'] + $point;



                    //操作记录入积分记录

                    $integral_log_mod = &m('integral_log');

                    $integral_log = array(

                        'user_id' => $user['user_id'],

                        'user_name' => $user['user_name'],

                        'point' => $point,

                        'add_time' => gmtime(),

                        'remark' => '管理员新增积分' . $point,

                        'integral_type' => INTEGRAL_ADD,

                    );

                    $integral_log_mod->add($integral_log);

                }

                

                //选项为 减少积分

                if ($_POST['point_change'] == 'dec_by') {

                    //如果当前的可用积分小于扣除的积分  则不做操作

                    if ($user['integral'] >= $point) {

                        

                        $data['integral'] = $user['integral'] - $point;

                        //$data['total_integral'] = $user['total_integral'] - $point;



                        //操作记录入积分记录

                        $integral_log_mod = &m('integral_log');

                        $integral_log = array(

                            'user_id' => $user['user_id'],

                            'user_name' => $user['user_name'],

                            'point' => $point,

                            'add_time' => gmtime(),

                            'remark' => '管理员扣除积分' . $point,

                            'integral_type' => INTEGRAL_SUB,

                        );

                        $integral_log_mod->add($integral_log);

                    }

                }

            }

            

            //管理员编辑会员等级后，也把该会员的会员积分修改为该会员等级所需要的最低积分 by qufood

            $ugrade_info = $ugrade_mod->get($_POST['grade_id']);

            $data['ugrade'] = $ugrade_info['grade'];

            $data['growth'] = $ugrade_info['floor_growth'];

            //end

            

            if (!empty($_POST['password'])) {

                $password = trim($_POST['password']);

                if (strlen($password) < 6 || strlen($password) > 20) {

                    $this->show_warning('password_length_error');



                    return;

                }

            }

            if (!is_email(trim($_POST['email']))) {

                $this->show_warning('email_error');



                return;

            }



            if (!empty($_FILES['portrait'])) {

                $portrait = $this->_upload_portrait($id);

                if ($portrait === false) {

                    return;

                }

                $data['portrait'] = $portrait;

            }

			if (!empty($_POST['cz_zfpass'])) {

				$zf_pass= array();

                $zf_pass['zf_pass']='';

				$this->epay_mod->edit($id,$zf_pass);	

            }

            /* 修改本地数据 */

            $this->_user_mod->edit($id, $data);



            /* 修改用户系统数据 */

            $user_data = array();

            !empty($_POST['password']) && $user_data['password'] = trim($_POST['password']);

            !empty($_POST['email']) && $user_data['email'] = trim($_POST['email']);

            if (!empty($user_data)) {

                $ms = & ms();

                $ms->user->edit($id, '', $user_data, true);

            }



            $this->show_message('edit_ok', 'back_list', 'index.php?app=user', 'edit_again', 'index.php?app=user&amp;act=edit&amp;id=' . $id

            );

        }

    }



    function drop() {

        $id = isset($_GET['id']) ? trim($_GET['id']) : '';

        if (!$id) {

            $this->show_warning('no_user_to_drop');

            return;

        }

        $admin_mod = & m('userpriv');

        if (!$admin_mod->check_admin($id)) {

            $this->show_message('cannot_drop_admin', 'drop_admin', 'index.php?app=admin');

            return;

        }



        if (!$this->check_store($id)) {

            $this->show_message('cannot_drop_store', 'drop_store', 'index.php?app=store');

            return;

        }



        $ids = explode(',', $id);



        /* 连接用户系统，从用户系统中删除会员 */

        $ms = & ms();

        if (!$ms->user->drop($ids)) {

            $this->show_warning($ms->user->get_error());



            return;

        }else{
		  $mod_epay = & m('epay');

          $mod_epay->drop($ids);
		
		}



        $this->show_message('drop_ok');

    }



    //检测删除的用户是否存在店铺  如果存在 需要先删除店铺 以便删除相关多余本地图片

    function check_store($user_id) {

        $conditions = "store_id in (" . $user_id . ")";

        $store_mod = & m('store');

        return count($store_mod->find(array('conditions' => $conditions))) == 0;

    }



    /**

     * 上传头像

     *

     * @param int $user_id

     * @return mix false表示上传失败,空串表示没有上传,string表示上传文件地址

     */

    function _upload_portrait($user_id) {

        $file = $_FILES['portrait'];

        if ($file['error'] != UPLOAD_ERR_OK) {

            return '';

        }



        import('uploader.lib');

        $uploader = new Uploader();

        $uploader->allowed_type(IMAGE_FILE_TYPE);

        $uploader->addFile($file);

        if ($uploader->file_info() === false) {

            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=user&amp;act=edit&amp;id=' . $user_id);

            return false;

        }



        $uploader->root_dir(ROOT_PATH);

        return $uploader->save('data/files/mall/portrait/' . ceil($user_id / 500), $user_id);

    }



}



?>

