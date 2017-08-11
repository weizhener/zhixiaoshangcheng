<META http-equiv=Content-Type content="text/html; charset=utf-8">
<?php
/* 添加适合 BEGIN */
define('ROOT_PATH', dirname(__FILE__) . "/../..");
include(ROOT_PATH . '/eccore/ecmall.php');

/* 定义配置信息 */
ecm_define(ROOT_PATH . '/data/config.inc.php');
include(ROOT_PATH . '/eccore/model/model.base.php');
define('CHARSET', 'utf-8');

$settings = include(ROOT_PATH . '/data/settings.inc.php');

$spname = "财付通双接口测试";
$partner = $settings['epay_tenpay_bargainor_id'];  //财付通商户号
$key = $settings['epay_tenpay_key'];    //财付通密钥
/* END */


//---------------------------------------------------------
//财付通即时到帐支付后台回调示例，商户按照此文档进行开发即可
//---------------------------------------------------------

require ("classes/ResponseHandler.class.php");
require ("classes/RequestHandler.class.php");
require ("classes/client/ClientResponseHandler.class.php");
require ("classes/client/TenpayHttpClient.class.php");
require ("./classes/function.php");
require_once ("./tenpay_config.php");

log_result("进入后台回调页面");


/* 创建支付应答对象 */
$resHandler = new ResponseHandler();
$resHandler->setKey($key);

//判断签名
if ($resHandler->isTenpaySign()) {

    //通知id
    $notify_id = $resHandler->getParameter("notify_id");

    //通过通知ID查询，确保通知来至财付通
    //创建查询请求
    $queryReq = new RequestHandler();
    $queryReq->init();
    $queryReq->setKey($key);
    $queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
    $queryReq->setParameter("partner", $partner);
    $queryReq->setParameter("notify_id", $notify_id);

    //通信对象
    $httpClient = new TenpayHttpClient();
    $httpClient->setTimeOut(5);
    //设置请求内容
    $httpClient->setReqContent($queryReq->getRequestURL());

    //后台调用
    if ($httpClient->call()) {
        //设置结果参数
        $queryRes = new ClientResponseHandler();
        $queryRes->setContent($httpClient->getResContent());
        $queryRes->setKey($key);

        if ($resHandler->getParameter("trade_mode") == "1") {
            //判断签名及结果（即时到帐）
            //只有签名正确,retcode为0，trade_state为0才是支付成功
            if ($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0") {
                log_result("即时到帐验签ID成功");
                //取结果参数做业务处理
                $out_trade_no = $resHandler->getParameter("out_trade_no");
                //财付通订单号
                $transaction_id = $resHandler->getParameter("transaction_id");
                //金额,以分为单位
                $total_fee = $resHandler->getParameter("total_fee");
                //如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
                $discount = $resHandler->getParameter("discount");

                //------------------------------
                //处理业务开始
                //------------------------------
                //处理数据库逻辑
                //注意交易单不要重复处理
                //注意判断返回金额
                $time = time()-8*6400;
                
                $total_fee = $total_fee*0.01;
                
                $dingdan = $out_trade_no;
                $mod_epay = & m('epay');
                $mod_epaylog = & m('epaylog');
                //根据用户订单号，获取充值者的ID
                $row_epay_log = $mod_epaylog->get("order_sn='$dingdan'");
                
                if(empty($row_epay_log) || $row_epay_log['complete'] == '1'){
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
                    'money'=>$total_fee,
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
                        'money_flow'=>'income',
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






















                //------------------------------
                //处理业务完毕
                //------------------------------
                log_result("即时到帐后台回调成功");
                echo "success";
            } else {
                //错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
                //echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->                         getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
                log_result("即时到帐后台回调失败");
                echo "fail";
            }
        }



        //获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
        /*
          echo "<br>------------------------------------------------------<br>";
          echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
          echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
          echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
          echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
          echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
         */
    } else {
        //通信失败
        echo "fail";
        //后台调用通信失败,写日志，方便定位问题
        echo "<br>call err:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
    }
} else {
    echo "<br/>" . "认证签名失败" . "<br/>";
    echo $resHandler->getDebugInfo() . "<br>";
}
?>