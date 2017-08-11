<?php
class WxoauthApp extends MallbaseApp
{
	

	
	  function index()
    {
		
	$store_id = $_GET['store_id'];	
    $oid = $_GET['oid'];
    $_SESSION['wxch_oid'] = $oid;
    $getoid = 'store_id='.$store_id.'&oid=' . $oid;
		
	$my_wxconfig_mod= m('wxconfig');
	$wxconfig = $my_wxconfig_mod->get_info_user($store_id);
	$appid=$wxconfig['appid'];
	$back_url = SITE_URL.'/index.php?app=wxlogin&'.$getoid;
$redirect_uri = urlencode($back_url);
	
$state = 'wechat';
$scope = 'snsapi_base';
$oauth_url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . $appid . '&redirect_uri=' . $redirect_uri . '&response_type=code&scope=' . $scope . '&state=' . $state . '#wechat_redirect';
header('Expires: 0');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: no-store, no-cahe, must-revalidate');
header('Cache-Control: post-chedk=0, pre-check=0', false);
header('Pragma: no-cache');
header("HTTP/1.1 301 Moved Permanently");
header("Location: $oauth_url");
exit;	
		
	
}
	
	
	
	function getOpenid($url)
	{
		
        //初始化curl
       	$ch = curl_init();
		//设置超时
		//curl_setopt($ch, CURLOP_TIMEOUT, $this->curl_timeout);
		curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		//运行curl，结果以jason形式返回
        $res = curl_exec($ch);
		curl_close($ch);
		//取出openid
		$data = json_decode($res,true);
	
		return 	$data;
	}
	
	
}
	
?>