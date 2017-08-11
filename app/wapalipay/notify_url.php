<?php

/* 添加适合 BEGIN */
define('ROOT_PATH', dirname(__FILE__) . "/../..");
include(ROOT_PATH . '/eccore/ecmall.php');

/* 定义配置信息 */
ecm_define(ROOT_PATH . '/data/config.inc.php');
include(ROOT_PATH . '/eccore/model/model.base.php');
define('CHARSET', 'utf-8');

$settings = include(ROOT_PATH . '/data/settings.inc.php');

$spname = "支付宝双接口测试";
$alipay_config['partner'] = $settings['epay_alipay_partner'];  //支付宝商户号
$alipay_config['key'] = $settings['epay_alipay_key'];      //支付宝密钥




require_once("alipay.config.php");
require_once("lib/alipay_notify.class.php");

//计算得出通知验证结果
$alipayNotify = new AlipayNotify($alipay_config);
$verify_result = $alipayNotify->verifyNotify();

if ($verify_result) {//验证成功
    $doc = new DOMDocument();
    if ($alipay_config['sign_type'] == 'MD5') {
        $doc->loadXML($_POST['notify_data']);
    }

    if ($alipay_config['sign_type'] == '0001') {
        $doc->loadXML($alipayNotify->decrypt($_POST['notify_data']));
    }


    if (!empty($doc->getElementsByTagName("notify")->item(0)->nodeValue)) {



        //商户订单号
        $out_trade_no = $doc->getElementsByTagName("out_trade_no")->item(0)->nodeValue;
        //支付宝交易号
        $trade_no = $doc->getElementsByTagName("trade_no")->item(0)->nodeValue;
        //交易状态
        $trade_status = $doc->getElementsByTagName("trade_status")->item(0)->nodeValue;

        $total_fee = $doc->getElementsByTagName("total_fee")->item(0)->nodeValue;


//        file_put_contents('log.txt', $trade_status.$total_fee.'test'.date('H:i:s').'--',FILE_APPEND);


        if ($trade_status == 'TRADE_FINISHED') {
            echo "success";  //请不要修改或删除
        } else if ($trade_status == 'TRADE_SUCCESS') {

            $time = time()-8*6400;

            $dingdan = $out_trade_no;
            $mod_epay = & m('epay');
            $mod_epaylog = & m('epaylog');
            //根据用户订单号，获取充值者的ID
            $row_epay_log = $mod_epaylog->get("order_sn='$dingdan'");

            if (empty($row_epay_log) || $row_epay_log['complete'] == '1') {
                return;
            }


            $user_id = $row_epay_log['user_id'];
            //获取用户的余额
            $row_epay = $mod_epay->get("user_id='$user_id'");
            //计算新的余额
            $old_money = $row_epay['money'];
            $new_money = $old_money + $total_fee;
            $edit_money = array(
                'money' => $new_money,
            );
            $mod_epay->edit('user_id=' . $user_id, $edit_money);
            //修改记录
            $edit_epaylog = array(
                'add_time' => $time,
                'money' => $total_fee,
                'complete' => 1,
                'states' => 61,
            );
            $mod_epaylog->edit('order_sn=' . '"' . $dingdan . '"', $edit_epaylog);






            //---------------------  以下是判断  是否启用 自动付款----------------------

            $mod_order = & m('order');
            //根据用户返回的 order_sn 判断是否为订单
            $order_info = $mod_order->get('order_sn=' . $dingdan);

            if (!empty($order_info)) {
                //如果存在订单号  则自动付款
                $order_id = $order_info['order_id'];


                $row_epay = $mod_epay->get("user_id='$user_id'");
                $buyer_name = $row_epay['user_name']; //用户名
                $buyer_old_money = $row_epay['money']; //当前用户的原始金钱
//从定单中 读取卖家信息
                $row_order = $mod_order->get("order_id='$order_id'");
                $order_order_sn = $row_order['order_sn']; //定单号
                $order_seller_id = $row_order['seller_id']; //定单里的 卖家ID
                $order_money = $row_order['order_amount']; //定单里的 最后定单总价格
//读取卖家SQL
                $seller_row = $mod_epay->get("user_id='$order_seller_id'");
                $seller_id = $seller_row['user_id']; //卖家ID 
                $seller_name = $seller_row['user_name']; //卖家用户名
                $seller_money_dj = $seller_row['money_dj']; //卖家的原始冻结金钱
//检测余额是否足够
                if ($buyer_old_money < $order_money) {   //检测余额是否足够 开始
                    return;
                }


//扣除买家的金钱
                $buyer_array = array(
                    'money' => $buyer_old_money - $order_money,
                );
                $mod_epay->edit('user_id=' . $user_id, $buyer_array);

//更新卖家的冻结金钱	
                $seller_array = array(
                    'money_dj' => $seller_money_dj + $order_money,
                );
                $seller_edit = $mod_epay->edit('user_id=' . $seller_id, $seller_array);


//买家添加日志
                $buyer_log_text = '购买商品店铺' . $seller_name;
                $buyer_add_array = array(
                    'user_id' => $user_id,
                    'user_name' => $buyer_name,
                    'order_id' => $order_id,
                    'order_sn ' => $order_order_sn,
                    'to_id' => $seller_id,
                    'to_name' => $seller_name,
                    'add_time' => $time,
                    'type' => 20,
                    'money_flow' => 'outlay',
                    'money' => $order_money,
                    'log_text' => $buyer_log_text,
                    'states' => 20,
                );
                $mod_epaylog->add($buyer_add_array);
//卖家添加日志
                $seller_log_text = '出售商品买家' . $buyer_name;
                $seller_add_array = array(
                    'user_id' => $seller_id,
                    'user_name' => $seller_name,
                    'order_id' => $order_id,
                    'order_sn ' => $order_order_sn,
                    'to_id' => $user_id,
                    'to_name' => $buyer_name,
                    'add_time' => $time,
                    'type' => 30,
                    'money_flow' => 'income',
                    'money' => $order_money,
                    'log_text' => $seller_log_text,
                    'states' => 20,
                );
                $mod_epaylog->add($seller_add_array);
//改变定单为 已支付等待卖家确认  status10改为20
                $payment_code = "zjgl";
//更新定单状态
                $order_edit_array = array(
                    'payment_name' => '余额支付',
                    'payment_code' => $payment_code,
                    'pay_time' => $time,
                    'out_trade_sn' => $order_sn,
                    'status' => 20, //20就是 待发货了
                );
                $mod_order->edit($order_id, $order_edit_array);
            }


            echo "success";  //请不要修改或删除
        }
    }

    //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——
    /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
} else {
    //验证失败
    echo "fail";

    //调试用，写文本函数记录程序运行情况是否正常
    //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
}
?>