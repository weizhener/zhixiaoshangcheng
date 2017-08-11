<?php



/* 申请开店 */



class regApp extends MallbaseApp {



    function index() {

        if (!IS_POST) {
            if (!empty($_GET['ret_url'])) {

                $ret_url = trim($_GET['ret_url']);

            } else {

                if (isset($_SERVER['HTTP_REFERER'])) {

                    $ret_url = $_SERVER['HTTP_REFERER'];

                } else {

                    $ret_url = SITE_URL . '/index.php';

                }

            }

            $this->assign('ret_url', rawurlencode($ret_url));
			
			$this->assign('g', $_GET);

            $this->_curlocal(LANG::get('user_register'));

            $this->_config_seo('title', Lang::get('user_register') . ' - ' . Conf::get('site_title'));



            if (Conf::get('captcha_status.register')) {

                $this->assign('captcha', 1);

            }

            if (Conf::get('msg_enabled')) {

                $this->assign('msg_enabled', 1);

            }

            /* 导入jQuery的表单验证插件   */

            $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js,jquery.plugins/poshy_tip/jquery.poshytip.js',

                'style' => 'jquery.plugins/poshy_tip/tip-yellowsimple/tip-yellowsimple.css')

            );
            $this->display('reg.html');

        } else {

            if (!$_POST['agree']) {

                $this->show_warning('agree_first');



                return;

            }

            if (Conf::get('captcha_status.register') && base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha'])) {

                $this->show_warning('captcha_failed');

                return;

            }

            if ($_POST['password'] != $_POST['password_confirm']) {

                /* 两次输入的密码不一致 */

                $this->show_warning('inconsistent_password');

                return;

            }
			
			
			$member_mod = &m('member');
			
			$tname  = $_POST['tname'];

            $tname_info = $member_mod->get("user_name='$tname'");
			
		    if(!$tname_info&&$tname)
			{
			  $this->show_warning('推荐人不存在');

              return;
			
			}else
			{
			
			$_SESSION['tuijian_id']=$tname_info['user_id'];
		
			
			$_SESSION['referid']=$tname_info['user_id'];
			
			    $referid = $tname_info['user_id'];
			}
			

            /* 注册并登陆 */

            $user_name = trim($_POST['user_name']);

            $password = $_POST['password'];
            
            $real_name = $_POST['real_name'];
            
            $telephone = $_POST['telephone'];
            
            $identity_card = $_POST['identity_card'];
			
            

            $email = trim($_POST['email']);

            $passlen = strlen($password);

            $user_name_len = strlen($user_name);

            if ($user_name_len < 3 || $user_name_len > 25) {

                $this->show_warning('user_name_length_error');

                return;

            }

            if ($passlen < 6 || $passlen > 20) {

                $this->show_warning('password_length_error');


                return;

            }

            /*
            if (!is_email($email)) {

                $this->show_warning('email_error');

                return;

            }
            */
			/*

            if (!preg_match("/^[0-9a-zA-Z]{3,15}$/", $user_name)) {

                $this->show_warning('user_already_taken');

                return;

            }

			*/

   
            if (Conf::get('msg_enabled') && $_SESSION['MobileConfirmCode'] != $_POST['confirm_code']) {

                $this->show_warning('mobile_code_error');

                return;

            }



            $ms = & ms(); //连接用户中心

            $user_id = $ms->user->register($user_name, $password,$email,$real_name, $identity_card,$telephone,array('phone_mob'=>$_POST['phone_mob']));

            if (!$user_id) {

                $this->show_warning($ms->user->get_error());

                return;

            }

            

            /*用户注册功能后 积分操作*/

            import('integral.lib');

            $integral=new Integral();

            $integral->change_integral_reg($user_id);

            /*用户注册如果有推荐人，则推荐人增加积分*/

            if(intval($_SESSION['referid'])){

                $integral->change_integral_recom(intval($_SESSION['referid']));

            }

            

            $this->_hook('after_register', array('user_id' => $user_id));

            //登录

            $this->_do_login($user_id);

            //修改成长值和会员等级 by qufood

            $user_mod=&m('member');

            $user_mod->edit_growth($user_id,'register');

            

            /* 同步登陆外部系统 */

            $synlogin = $ms->user->synlogin($user_id);



            #TODO 可能还会发送欢迎邮件
			
			$this->display('mobile.html');


        }

    }



}



?>

