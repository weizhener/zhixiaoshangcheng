<?php
ob_start();

session_start();
include_once( 'config.php' );
include_once( 'weibooauth.php' );
//exit(print_r($_GET));
$new_app_key=$_GET["sina_app_key"];
$new_app_secret=$_GET["sina_app_secret"];
//如果站点申请新的应用，就使用新应用的信息，否则使用默认的应用信息
if($new_app_key&&$new_app_secret)
{
	$o = new WeiboOAuth( $new_app_key , $new_app_secret , $_SESSION['keys']['oauth_token'] , $_SESSION['keys']['oauth_token_secret']  );
	$last_key = $o->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
	$_SESSION['last_key'] = $last_key;
	$_SESSION['sina_token']=$_SESSION['last_key']['oauth_token'];
	$_SESSION['sina_token_secret']=$_SESSION['last_key']['oauth_token_secret'];
	$_SESSION['sina_user_id']=$_SESSION['last_key']['user_id'];
	$c = new WeiboClient( $new_app_key , $new_app_secret , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
	//$ms  = $c->home_timeline(); // done
	$me = $c->verify_credentials();
}
else
{
	$o = new WeiboOAuth( WB_AKEY , WB_SKEY , $_SESSION['keys']['oauth_token'] , $_SESSION['keys']['oauth_token_secret']  );
	$last_key = $o->getAccessToken(  $_REQUEST['oauth_verifier'] ) ;
	$_SESSION['last_key'] = $last_key;
	$_SESSION['sina_token']=$_SESSION['last_key']['oauth_token'];
	$_SESSION['sina_token_secret']=$_SESSION['last_key']['oauth_token_secret'];
	$_SESSION['sina_user_id']=$_SESSION['last_key']['user_id'];
	$c = new WeiboClient( WB_AKEY , WB_SKEY , $_SESSION['last_key']['oauth_token'] , $_SESSION['last_key']['oauth_token_secret']  );
	//$ms  = $c->home_timeline(); // done
	$me = $c->verify_credentials();
}
if($me)
{
	//exit(print_r($me));
	$_SESSION['sina_nickname']=$me['screen_name'];
	$go_url="/index.php?app=third_login&act=sina_callback&sina_token="
	.$_SESSION['sina_token']."&sina_token_secret=".
	$_SESSION['sina_token_secret']."&sina_user_id="
	.$_SESSION['sina_user_id']."&sina_nickname=".urlencode($_SESSION['sina_nickname']);
	
	header("location:$go_url");
	ob_end_flush();
	exit();
}
else
{
	exit("not get user info.");
}
?>