<?php
class WxloginApp extends MallbaseApp
{
	
	 function __construct() {
        $this->Wxlogin();
    }
	
	
	    function Wxlogin() {
        parent::__construct();
        $this->my_wxkeyword_mod = & m('wxkeyword');
        $this->my_wxconfig_mod = & m('wxconfig');
		$this->weixin_user =& m('weixinuser');
		$this->user_mod= &m('member');
    }
	
	
	  function index()
    {
		
	 $store_id = isset($_GET['store_id']) ? intval($_GET['store_id']) : 1;
     $oid = isset($_GET['oid']) ? intval($_GET['oid']) : 0;
		
	 $my_wxconfig_mod= m('wxconfig');
	 $wxconfig = $my_wxconfig_mod->get_info_user($store_id);
	$myoauth_mod=& m('myoauth');
		 
		 if($oid)
		 {
		
			
		$myoauth_info=$myoauth_mod->get($oid);
	
		  }	
		
	//echo 'wwwwww';
	//print_r($_GET);	
	$code=$_GET['code'];
	
	if(!$code)
	{
		    
			$this->show_warning('获取不到code');
	exit();
		
	}
	   $url="https://api.weixin.qq.com/sns/oauth2/access_token?appid=".trim($wxconfig['appid'])."&secret=".trim($wxconfig['appsecret'])."&code=".$code."&grant_type=authorization_code";
	
    $data=$this->getOpenid($url);
	
	
	
    $access_token =$data['access_token'];
	$openid= $data['openid'];
	

    /*$url="https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
    $data=$this->getOpenid($url);
	*/
	if(!$openid)
	{
	$this->show_warning('接口出错');
	exit();
	}
	
    $user_info=$this->weixin_user->get(array('conditions'=>" wxid ='".$openid."'"));
    $ms =& ms();
	  
	  
  if($user_info['user_id'])
 {
	
	 
	  $this->_do_login($user_info['user_id']);
            
            /* 同步登陆外部系统 */
    $synlogin = $ms->user->synlogin($user_info['user_id']);
	  		
	
	 if($myoauth_info['url'])
	   {
		 $ret_url=$myoauth_info['url'];  
	   }else
	   {
	     $ret_url="index.php?app=member"; 
	    }
		
		header("Location: $ret_url");
	 //   $this->show_message('登陆成功','返回会员中心', $ret_url);
 }else
 {
	 header("Location: index.php");
	}
 

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