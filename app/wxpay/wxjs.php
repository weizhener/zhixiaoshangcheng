<?php

/* 添加适合 BEGIN */
define('ROOT_PATH', dirname(__FILE__) . "/../..");
include(ROOT_PATH . '/eccore/ecmall.php');

/* 定义配置信息 */
ecm_define(ROOT_PATH . '/data/config.inc.php');
include(ROOT_PATH . '/eccore/model/model.base.php');
define('CHARSET', 'utf-8');

$settings = include(ROOT_PATH . '/data/settings.inc.php');

/* END */



define("APPID", $settings['epay_wx_appid']);
define("MCHID", $settings['epay_wx_mch_id']);
define("KEY", $settings['epay_wx_key']);
define("APPSECRET", $settings['epay_wx_secret']);


$site_url = $_GET['site_url'];
$dingdan = $_GET['dingdan'];
$user_id = $_GET['user_id'];
$user_name = $_GET['user_name'];
$cz_money = $_GET['cz_money'];


require_once "WxPay.JsApiPay.php";
require_once 'log.php';

//初始化日志
$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}





//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();

//②、统一下单
$input = new WxPayUnifiedOrder();
//商品描述
$input->SetBody("微信扫码支付"); 
//$input->SetBody("test");
//附加数据
$input->SetAttach("$dingdan");
//$input->SetAttach("test");
//商户订单号
$input->SetOut_trade_no($dingdan);
//$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));

//总金额
$input->SetTotal_fee(intval($cz_money * 100));
//$input->SetTotal_fee("1");
//交易起始时间
$input->SetTime_start(date("YmdHis"));
//交易结束时间
$input->SetTime_expire(date("YmdHis", time() + 3600*24*7));
//商品标记
$input->SetGoods_tag("微信扫码支付");

$input->SetNotify_url($site_url . "/app/wxpay/notify_url.php");


$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);

$jsApiParameters = $tools->GetJsApiParameters($order);



//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>微信支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	
	</script>
</head>
<body>

    <script>
        setInterval("check_payment()",3000);
    function check_payment()
    {
        
    var url = '/index.php?app=default&act=check_payment';
    $.get(url, {'dingdan':<?php echo $dingdan ?>}, function(result){
        if(result=='1'){
            self.location="/index.php?app=member"; 
        }else if(result=='2'){
            self.location="/index.php?app=buyer_order"; 
        }else{
//            alert('失败');
        }
    });
    }
    </script>
    <div align="center">
        <div style="color:#556B2F;font-size:30px;font-weight: bolder;">微信直接支付</div>
        <button style="width:210px; height:50px; border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onclick="callpay()" >立即支付</button>
        <br/>
        <a style="width:210px; height:30px;line-height: 30px;border-radius: 15px;background-color:#FE6714; border:0px #FE6714 solid; cursor: pointer;color:white;  font-size:16px;display: block;margin-top: 20px;" href="/index.php">返回首页</a>
    </div>
</body>
</html>

