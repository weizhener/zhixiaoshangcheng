<?php

/**
 * 
 * 第三方登录
 * @author xiaozhuge
 *
 */
class third_loginApp extends MallbaseApp {

    var $_third_login_mod;

    function __construct() {
        $this->third_loginApp();
    }

    function third_loginApp() {
        parent::__construct();
        $this->_third_login_mod = & m('third_login');
    }

    function qq() {
        //第三方的名称
        $third_name = 'qq';

        //应用的APPID APPKEY
        $app_id = Conf::get('qq_appid');
        $app_secret = Conf::get('qq_appkey');

        if (empty($app_id) || empty($app_secret)) {
            $this->show_warning('qq_error');
            return;
        }


//成功授权后的回调地址
        $my_url = site_url() . "/index.php?app=third_login&act=qq";

//Step1：获取Authorization Code
        session_start();
        $code = $_REQUEST["code"];
        if (empty($code)) {
            //state参数用于防止CSRF攻击，成功授权后回调时会原样带回
            $_SESSION['state'] = md5(uniqid(rand(), TRUE));
            //拼接URL     
            $dialog_url = "https://graph.qq.com/oauth2.0/authorize?response_type=code&client_id="
                    . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
                    . $_SESSION['state'];
            echo("<script> top.location.href='" . $dialog_url . "'</script>");
            exit;
        }

        //Step2：通过Authorization Code获取Access Token
        if ($_REQUEST['state'] == $_SESSION['state']) {
            //拼接URL   
            $token_url = "https://graph.qq.com/oauth2.0/token?grant_type=authorization_code&"
                    . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
                    . "&client_secret=" . $app_secret . "&code=" . $code;

            $response = file_get_contents($token_url);

            if (strpos($response, "callback") !== false) {
                $lpos = strpos($response, "(");
                $rpos = strrpos($response, ")");
                $response = substr($response, $lpos + 1, $rpos - $lpos - 1);
                $msg = json_decode($response);
                if (isset($msg->error)) {
                    echo "<h3>error:</h3>" . $msg->error;
                    echo "<h3>msg  :</h3>" . $msg->error_description;
                    exit;
                }
            }

            //Step3：使用Access Token来获取用户的OpenID
            $params = array();
            parse_str($response, $params);
            $graph_url = "https://graph.qq.com/oauth2.0/me?access_token=" . $params['access_token'];
            $str = file_get_contents($graph_url);
            if (strpos($str, "callback") !== false) {
                $lpos = strpos($str, "(");
                $rpos = strrpos($str, ")");
                $str = substr($str, $lpos + 1, $rpos - $lpos - 1);
            }
            $user = json_decode($str);
            if (isset($user->error)) {
                echo "<h3>error:</h3>" . $user->error;
                echo "<h3>msg  :</h3>" . $user->error_description;
                exit;
            }

            //    echo("Hello " . $user->openid);  这个是唯一的  通过这个判断  用户 是否存在 根据ID值获取相关信息
            $get_user_info_url = "https://graph.qq.com/user/get_user_info?access_token=" . $params['access_token'] . "&oauth_consumer_key=" . $app_id . "&openid=" . $user->openid;
            $str = file_get_contents($get_user_info_url);
            $qq_user = json_decode($str);

            $_SESSION['portrait'] = $qq_user->figureurl_qq_1; #获得头像
            $_SESSION['nickname'] = $qq_user->nickname; #获取的名称
            $_SESSION['openid'] = $user->openid; #获取的唯一值
            $_SESSION['third_name'] = $third_name; #类别
            #对获取到的信息进行处理
            # $user->openid 为判断唯一值
            $this->check_third_login($user->openid, $third_name);
        } else {
            echo("The state does not match. You may be a victim of CSRF.");
        }
    }

    /**
     * 
     * 新浪微博登录
     */
    function sina() {
        //应用的APPID APPKEY
        $sina_app_key = Conf::get('sina_appid');
        $sina_app_secret = Conf::get('sina_appkey');
        

        if (empty($sina_app_key) || empty($sina_app_secret)) {
            $this->show_warning('qq_error');
            return;
        }

        $retrun_url = !empty($_GET['ret_url']) ? $_GET['ret_url'] : '/index.php';
        $_SESSION['retrun_url'] = $retrun_url;
        $redirect_to_login = '/includes/third/sina_api/index.php?sina_app_key=' . $sina_app_key
                . '&sina_app_secret=' . $sina_app_secret;
        header("location:$redirect_to_login");
        exit();
    }

    /**
     * 
     * 新浪微博登录回调
     */
    function sina_callback() {
        
        $third_name = 'sina';

        $nickname = isset($_GET["sina_nickname"]) ? $_GET["sina_nickname"] : '';
        $user_id = isset($_GET["sina_user_id"]) ? $_GET["sina_user_id"] : '';

        $_SESSION['portrait'] = ''; #获得头像
        $_SESSION['nickname'] = $user_id; #获取的名称
        $_SESSION['openid']   = $user_id; #获取的唯一值
        $_SESSION['third_name'] = $third_name; #类别
        #对获取到的信息进行处理
        # $user_id 为判断唯一值
        $this->check_third_login($user_id, $third_name);
    }

    /*
     * $openid 判断唯一值  
     * $third_name 类型
     */

    function check_third_login($openid, $third_name) {

        //是否已存在该用户
        $conditions = " openid='$openid' and third_name='$third_name'";
        $third_login = $this->_third_login_mod->get($conditions);


        if ($third_login) {
            $data = array(
                'update_time' => gmtime(),
            );
            $this->_third_login_mod->edit("id=" . $third_login["id"], $data);

            //检测绑定信息 关联的 用户 是否存在。

            if ($third_login["user_id"]) {
                $member_mod = &m('member');
                $member = $member_mod->get($third_login["user_id"]);
                if (empty($member)) {
                    $this->_third_login_mod->edit("id=" . $third_login["id"], array('user_id' => 0));
                    $third_login['user_id'] = 0;
                }
            }
            
            
            
            if ($third_login["user_id"]) {
                //如果存在 user_id 表示已经绑定
                //登录
                $this->_do_login($third_login["user_id"]);
                //跳转
                $retrun_url = !empty($_SESSION['retrun_url']) ? $_SESSION['retrun_url'] : '/index.php';
                $this->show_message('login_successed', 'back_before_register', rawurldecode($retrun_url), 'enter_member_center', '/index.php?app=member', 'apply_store', 'index.php?app=apply');
            } else {
                // 用户未绑定
                $this->show_message('binding_user', 'back_list', 'index.php?app=third_login&act=binding');
            }
        } else {
            //添加到third_login表
            $data = array(
                'third_name' => $third_name,
                'openid' => $openid,
                'user_id' => '0',
                'add_time' => gmtime(),
                'update_time' => gmtime(),
            );
            $this->_third_login_mod->add($data);

            // 新增后绑定相关用户
            $this->show_message('binding_user', 'back_list', 'index.php?app=third_login&act=binding');
        }
    }

    //第三方登录  与用户进行绑定
    function binding() {
        
        $third_name = $_SESSION['third_name'];
        $portrait   = $_SESSION['portrait'];
        $nickname   = $_SESSION['nickname'];
        $openid     = $_SESSION['openid'];
        
        
        if (empty($third_name) ||  empty($openid)) {
            $this->show_message('login', 'back_list', 'index.php?app=member&act=login');
            exit;
        }

        if (!IS_POST) {

            $this->assign('nickname', $nickname);
            $this->assign('portrait', $portrait);

            $this->display('third_login.binding.html');
        } else {
            //登录为QQ登录
            if (empty($openid)) {
                $this->show_message('login', 'back_list', 'index.php?app=login');
                exit;
            }

            $user_id = $this->do_binding();

            $conditions = " openid='$openid' and third_name='$third_name'";
            $third_login = $this->_third_login_mod->get($conditions);
            if ($third_login) {
                if ($third_login['user_id']) {
                    $this->show_warning('qq_already_binding');
                    exit;
                } else {
                    $data = array(
                        'user_id' => $user_id,
                    );
                    $this->_third_login_mod->edit("id=" . $third_login["id"], $data);
                    $this->show_message('binding_ok', 'back_list', 'index.php');
                }
            } else {
                $this->show_warning('binding_qq_error');
                exit;
            }
        }
    }

    function do_binding() {
        if ($this->visitor->has_login) {
            $this->show_warning('has_login');
            exit;
        }

        $binding_type = $_POST['binding_type'];
        if ($binding_type == 'register') {
            $user_id = $this->register();
        } else if ($binding_type == 'login') {
            $user_id = $this->login();
        }

        if (empty($user_id)) {
            $this->show_warning('do_binding_error');
            exit;
        } else {
            return $user_id;
        }
    }

    function register() {
        if ($_POST['password'] != $_POST['password_confirm']) {
            /* 两次输入的密码不一致 */
            $this->show_warning('inconsistent_password');
            exit;
        }

        /* 注册并登陆 */
        $user_name = trim($_POST['user_name']);
        $password = $_POST['password'];
        $email = trim($_POST['email']);
        $passlen = strlen($password);
        $user_name_len = strlen($user_name);
        if ($user_name_len < 3 || $user_name_len > 25) {
            $this->show_warning('user_name_length_error');
            exit;
        }
        if ($passlen < 6 || $passlen > 20) {
            $this->show_warning('password_length_error');
            exit;
        }
        if (!is_email($email)) {
            $this->show_warning('email_error');
            exit;
        }

        $ms = & ms(); //连接用户中心
        $user_id = $ms->user->register($user_name, $password, $email);

        if (!$user_id) {
            $this->show_warning($ms->user->get_error());
            exit;
        }
        $this->_hook('after_register', array('user_id' => $user_id));
        //登录
        $this->_do_login($user_id);
        /* 同步登陆外部系统 */
        $synlogin = $ms->user->synlogin($user_id);
        return $user_id;
    }

    function login() {
        $user_name = trim($_POST['user_name']);
        $password = $_POST['password'];

        $ms = & ms();
        $user_id = $ms->user->auth($user_name, $password);
        if (!$user_id) {
            /* 未通过验证，提示错误信息 */
            $this->show_warning($ms->user->get_error());
            exit;
        } else {
            /* 通过验证，执行登陆操作 */
            $this->_do_login($user_id);
            /* 同步登陆外部系统 */
            $synlogin = $ms->user->synlogin($user_id);
        }
        return $user_id;
    }

}
