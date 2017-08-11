<?php

class Mobile_msg {

    var $_msg_mod;
    var $_msglog_mod;

    function __construct() {
        $this->_msg_mod = &m('msg');
        $this->_msglog_mod = & m('msglog');

        define('SMS_UID', Conf::get('msg_pid'));
        define('SMS_KEY', Conf::get('msg_key'));

        //判断是否开启短信
        if (!Conf::get('msg_enabled')) {
            return FALSE;
        }
    }


    /**
     * 关于订单的短信发送,此发送需要扣除卖家的短信条数
     */
    function send_msg_order($order_info, $type) {
        $msg = $this->_msg_mod->get("user_id=" . $order_info['seller_id']);

        /**
         * 检测是否有权限
         */
        if (!$this->check_functions($msg, $type)) {
            return FALSE;
        }

        $user_id = $order_info['seller_id'];
        $user_name = $order_info['seller_name'];


        if ($type == 'check') {
            //买家确认收货向卖家发送短信提示
            $to_mobile = $msg['mobile'];
            $smsText = "您的订单：" . $order_info['order_sn'] . "，买家" . $order_info['buyer_name'] . "已经确定！"; //内容
        } else if ($type == 'buy') {
            //买家下单向卖家发送短信提示
            $to_mobile = $msg['mobile'];
            $smsText = "您收到了来自买家" . $order_info['buyer_name'] . "的订单，订单号为：" . $order_info['order_sn'] . "，请及时处理！"; //内容
        } else if ($type == 'send') {
            //卖家发货向买家发送短信提示
            $mod_order_extm = & m('orderextm');
            $row_order_extm = $mod_order_extm->get("order_id=" . $order_info['order_id']);
            $to_mobile = $row_order_extm['phone_mob'];

            $smsText = "您的订单：" . $order_info['order_sn'] . ",卖家：" . $order_info['seller_name'] . "已经发货，请及时查收！"; //内容
        } else {
            return FALSE;
        }
        
        $result = $this->send_msg($user_id, $user_name, $to_mobile, $smsText);
        return $result;
    }

    /**
     * 卖家后台 发送短信
     */
    function send_msg_seller($user_id, $user_name, $to_mobile, $smsText) {
        $msg = $this->_msg_mod->get("user_id=" . $user_id);
        /**
         * 检测是否有权限
         */
        if (!$this->check_functions($msg, $type)) {
            return FALSE;
        }
        
        $result = $this->send_msg($user_id, $user_name, $to_mobile, $smsText);
        return $result;
    }
    
    /**
     * 系统发送短信，包含 注册   修改手机号  等信息
     */
    function send_msg_system($type, $to_mobile) {
        $mcode = $this->make_code();
        if ($type == 'register') {
            //注册发送短信的内容
            $smsText = "您的注册验证码是:" . $mcode . ".请不要把验证码泄露给其他人.";
        } else if ($type == 'change') {
            //修改发送的短信内容
            $smsText = "您的修改验证码是:" . $mcode . ".请不要把验证码泄露给其他人.";
        } else if ($type == 'find') {
            //找回密码发送的短信内容
            $smsText = "您的找回密码验证码是:" . $mcode . ".请不要把验证码泄露给其他人.";
        }
        //存入session 做认证
        unset($_SESSION['MobileConfirmCode']);
        $_SESSION['MobileConfirmCode'] = $mcode;
        $result = $this->send_msg(0, 'admin', $to_mobile, $smsText);
        return $result;
    }
    /**
     * 生成随机码 用于注册 以及修改
     */
    function make_code() {
        $chars = '0123456789';
        $code = '';
        for ($i = 0; $i < 6; $i++) {
            $code .= $chars[mt_rand(0, strlen($chars) - 1)];
        }
        return $code;
    }
    

    /**
     * 
     * @param type $user_id   记录ID   为0 表示为系统发送消息
     * @param type $user_name  用户名
     * @param type $to_mobile  地址
     * @param type $content  内容
     * @return boolean
     */
    function send_msg($user_id, $user_name, $to_mobile, $smsText) {
        //发送短信
        $url = 'http://utf8.sms.webchinese.cn/?Uid=' . SMS_UID . '&Key=' . SMS_KEY . '&smsMob=' . $to_mobile . '&smsText=' . $smsText;
        $res = $this->Sms_Get($url);

        $add_msglog = array(
            'user_id' => $user_id,
            'user_name' => $user_name,
            'to_mobile' => $to_mobile,
            'content' => $smsText,
            'state' => $res,
            'time' => gmtime(),
        );
        
        $this->_msglog_mod->add($add_msglog);

        if ($res > 0) {
            // user_id = 0 user_name = admin  表示为系统发送,短信的条数不做操作
            if ($user_id != 0) {
                $this->_msg_mod->edit('user_id=' . $user_id, 'num=num-1');
            }
            return TRUE;
        } else {
            return FALSE;
        }
    }

    /**
     *    中国网建接口
     *
     *    @author    andcpp
     *    @return    array
     */
    function Sms_Get($url) {
        if (function_exists('file_get_contents')) {
            $file_contents = file_get_contents($url);
        } else {
            $ch = curl_init();
            $timeout = 5;
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
            $file_contents = curl_exec($ch);
            curl_close($ch);
        }
        return $file_contents;
    }

    /**
     * 检测是否具有发送短信条件
     * 
     */
    function check_functions($msg, $type = '') {
        $functions = $this->get_functions();
        $tmp = explode(',', $msg['functions']);
        if ($functions) {
            foreach ($functions as $func) {
                $checked_functions[$func] = in_array($func, $tmp);
            }
        }
        
        //卖家未开启支付
        if ($msg['state'] == 0) {
            return FALSE;
        }
        if($type) {
            //卖家未开启 确认收货发送短信
            if (!$checked_functions[$type]) {
                return FALSE;
            }
        }
        
        //卖家可用短信数 不够
        if ($msg['num'] <= 0) {
            return FALSE;
        }
        return TRUE;
    }

    /**
     *    获取可用功能列表
     *
     *    @author    andcpp
     *    @return    array
     */
    function get_functions() {
        $arr = array();
        $arr[] = 'buy'; //来自买家下单通知   
        $arr[] = 'send'; //卖家发货通知买家   
        $arr[] = 'check'; //来自买家确认通知   
        return $arr;
    }

}
