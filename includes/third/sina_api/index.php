<?php

session_start();

//if( isset($_SESSION['last_key']) ) header("Location: weibolist.php");
include_once( 'config.php' );
include_once( 'weibooauth.php' );

$new_app_key=$_GET["sina_app_key"];
$new_app_secret=$_GET["sina_app_secret"];
//如果站点申请了应用，就使用新应用的信息，否则使用默认的应用信息
if($new_app_key&&$new_app_secret)
{
	$_SESSION["sina_app_key"]=$new_app_key;
	$_SESSION["sina_app_secret"]=$new_app_secret;

	$o = new WeiboOAuth( $new_app_key , $new_app_secret  );
	$keys = $o->getRequestToken();
	$callback='http://'.$_SERVER["HTTP_HOST"].'/includes/third/sina_api/callback.php?'
	."sina_app_key=".$new_app_key."&sina_app_secret=".$new_app_secret;
	//exit($callback);
	$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false ,$callback );
}
else 
{
	$o = new WeiboOAuth( WB_AKEY , WB_SKEY  );
	$keys = $o->getRequestToken();
	$callback='http://'.$_SERVER["HTTP_HOST"].'/includes/third/sina_api/callback.php';
	$aurl = $o->getAuthorizeURL( $keys['oauth_token'] ,false ,$callback );
}

$_SESSION['keys'] = $keys;

header("location:$aurl");
exit();
?>