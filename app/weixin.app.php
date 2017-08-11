<?php

/* 微信公众平台 */

class WeixinApp extends MallbaseApp {

    var $ToUserName = '';
    var $FromUserName = '';
    var $my_wxconfig_mod;
    var $my_wxkeyword_mod;
	 var $weixin_user;
	  var $user_mod;
    var $_store_id;
     var $wxchqr;
	 var $wx_name;
	    var $_key;
    function __construct() {
        $this->WeixinApp();
    }

    function WeixinApp() {
        parent::__construct();
        $this->my_wxkeyword_mod = & m('wxkeyword');
        $this->my_wxconfig_mod = & m('wxconfig');
		$this->weixin_user =& m('weixinuser');
		$this->user_mod= &m('member');
		$this->wxchqr= &m('wxchqr');
    }

    function index() {
	       
		  
	    $user_id = isset($_REQUEST['id']) ? intval($_REQUEST['id']) : 0;
  
   
        import('weixin.lib');
		 $wx_mod =  new Init_Weixin();
        $this->_store_id = $user_id;
		
		
	
        $wxconfig = $this->my_wxconfig_mod->get_info_user($this->_store_id);
		$this->wx_name= $wxconfig['name'];
        //$model_setting = &af('settings');
        //$weixin_url = $model_setting->getOne('weixin_url');
        if (empty($wxconfig)) {
            exit;
        }
        $token = $wxconfig['token'];
        $ACCESS_LIST = Init_Weixin::curl($wxconfig['appid'], $wxconfig['appsecret']);
        $access_token= $ACCESS_LIST['access_token'];
		
		
		 $store_mod =& m('store');
		 $store_info=   $store_mod->get($this->_store_id);
		 $sname=$store_info['store_name'];
		
        $signature = $_GET['signature'];
        $timestamp = $_GET['timestamp'];
        $nonce = $_GET['nonce'];
        $echostr = $_GET['echostr'];
        $arr = array($token, $timestamp, $nonce);
        //sort($arr);
		sort($arr, SORT_STRING);
        $result = sha1(join($arr));
        if ($result == $signature) {
            echo $echostr;
        }


        //接收微信公众账号接收到的信息
        $poststr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $xmlObj = simplexml_load_string($poststr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $this->ToUserName = $xmlObj->ToUserName;
        $this->FromUserName = $xmlObj->FromUserName;
        $CreateTime = $xmlObj->CreateTime;
        $MsgType = $xmlObj->MsgType;
        $MsgEvent = $xmlObj->Event;
        $EventKey = $xmlObj->EventKey;

    /*初始值*/
$gongneng= "功能表 \r\n输入【cxbd】绑定会员\r\n输入【quit】退出绑定\r\n输入【member】会员中心\r\n输入【ddcx】查询订单\r\n输入【kdcx】快递查询\r\n输入【cxye】查询积分、余额";
  //  $wxid=substr(md5($this->FromUserName),'0','-5');
  
   $wxid=$this->FromUserName;
   
   $wx_user=$this->user_mod->get(array(
			  'join' => 'has_wx',
            'fields' => 'this.*,w.wxid,w.nickname,member.user_name,member.password,member.last_login,member.last_ip',
			 'conditions' => '1=1 and w.wxid="'.$wxid.'"',
			  ));
   
     $this->_key = md5($wx_user['user_id'].$wx_user['user_name'].$wx_user['password'].$wx_user['last_login'].$wx_user['last_ip']);
   
    $store_index=SITE_URL."/index.php?app=store&id=".$user_id."&wxid=".$wxid;
    $url=SITE_URL."/index.php?app=member";
	 
	  
	
		/*
		
		获取用户微信号
		
		*/
		$wxurl="https://api.weixin.qq.com/cgi-bin/user/info?access_token=". $access_token."&openid=".$wxid."&lang=zh_CN";
	   $wxid_info = file_get_contents($wxurl);
		$wxid_info=json_decode($wxid_info);

  
	 

//end


if($MsgEvent=='SCAN')
{
	if (isset($xmlObj->EventKey)){
		
			$wxch_qr_info= $this->wxchqr->get("scene_id=".$xmlObj->EventKey);
           $contentStr = "您已关注此公众号";
		 
		  $this->wxchqr->edit($wxch_qr_info['qid'],"scan=scan+1");
      echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);
	  }

}


if ($MsgType == 'text' || $MsgEvent == 'CLICK') {
	


//


$Content = $xmlObj->Content;
 if($EventKey){
  $Content=$xmlObj->EventKey; 
 	
 }
 
 



//end 
 
 
 //插入数据库
 if($MsgType == 'text')
 {
  $data=array(
   'wxid'=>$wxid,
   'message'=>$Content,
   'dateline'=>time(),
 
   );	
}
 if($MsgEvent == 'CLICK')
 {
  $data=array(
   'wxid'=>$wxid,
   'message'=>'menu:'.$Content,
   'dateline'=>time(),
 
   );	
}
 
  $wxmessage =& m('wxmessage');
 $wxmessage->add($data);
 //end
 
	
$str=explode(":",$Content);

if($str)
{
	$dd=$str[1];
}
	
	
	 
    
	
 $user_info=$this->weixin_user->get(array('conditions'=>" wxid ='".$this->FromUserName."'"));
 $setp = $user_info['setp'];

if(!$user_info)
{
	
	 $weixin_user =$this->weixin_user =& m('weixinuser');
   
     $local_user=time().rand(1,10000);

     $ms =& ms(); //连接用户中心
$redadd=array(
		
		'portrait'=>$wxid_info->headimgurl,
		
		  );
        $user_id = $ms->user->register($local_user, '000000',time().'@vchuang.cn',$redadd);
       
	     $data = array(
                    'user_id' => $user_id,
                    'wxid' => $this->FromUserName,
                    'setp' => '3',
                    'uname' => $local_user,
					'subscribe'=>$wxid_info->subscribe,
					'nickname'=>$wxid_info->nickname,
					'sex'=>$wxid_info->sex,
					'city'=>$wxid_info->city,
					'country'=>$wxid_info->country,
					'headimgurl'=>$wxid_info->headimgurl,
					'subscribe_time'=>$wxid_info->subscribe_time,
               
          );
		 
		   $this->weixin_user->add($data);	
	
	
 $password='000000';
  if($user_id)
  {
	 
   $contentreg = "\n恭喜您,用户注册成功!\n用户为:".$local_user."\n密码为:".$password."\r\n<a href='".SITE_URL."/index.php?wxid=".$this->FromUserName."'>进入商城首页</a>\r\n<a href='".$store_index."'>店铺首页</a>\r\n<a href='".$url."'>进入会员中心</a>";
   }else{
	   $contentreg = "\n恭喜您,用户注册成功!\n用户为:".$local_user."\n密码为:".$password."\r\n<a href='".SITE_URL."/index.php?wxid=".$this->FromUserName."'>进入商城首页</a>\r\n<a href='".$url."'>进入会员中心</a>"; 
	   }
				 
 //echo $this->send($this->ToUserName, $this->FromUserName, $contentreg);
	/*没有添加帐号*/
	
	
}	
	
	
if($Content=='tj')
{
	
	
  $user_info=$this->weixin_user->get(array('conditions'=>" wxid ='".$this->FromUserName."'"));
  

     

 $contentStr=$wx_mod->wxtj($access_token,$user_info);


	
	
	
	
	//echo $resultStr;	
echo $this->send_img($this->ToUserName, $this->FromUserName, $contentStr);
 
 


}	
	
if($Content=='pic')
{
	

$data=ROOT_PATH.'/qrcode/1430042444.jpg';
$filedata=array("media"=>"@".$data);
$url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type=image';
					
$res_json =$this ->https_request($url, $filedata);

$json = json_decode($res_json);	
 $msgType = "image";
$iipp = $_SERVER["REMOTE_ADDR"];
$phone_state=$_SERVER['HTTP_USER_AGENT'];
$contentStr = $json->media_id;
 $time=time();
	
	
	//echo $resultStr;	
echo $this->send_img($this->ToUserName, $this->FromUserName, $contentStr);

}	
if($Content=='qrcode')
{
	

if(!$wxid_info->nickname)
{
	
	 $this->send($this->ToUserName, $this->FromUserName, "您的不是认证的服务号,无权限操作");
}


 
 $user_info=$this->weixin_user->get(array('conditions'=>" wxid ='".$this->FromUserName."'"));
 $portrait="qrcode/images/head/".$user_info['user_id']."/".$user_info['user_id'].".jpg";
		  
		  
		  
		  
		  
		   if (!file_exists(dirname($portrait)))
        {
            ecm_mkdir(dirname($portrait));
        }
		  
		  
		  if(!file_exists($portrait))
		  {
				
	 
		
		$this->head($wxid_info->headimgurl,$portrait);
		  }

	
//$this->download_remote_file($wxid_info->headimgurl,$portrait);
		  $redadd=array(
		// 'user_name' => $wxid_info->nickname,
		'portrait'=>$portrait,
		
		  );
		$this->user_mod->edit($user_info['user_id'],$redadd);
		  
		   $data = array(
                    'wxid' => $this->FromUserName,
                    'setp' => '3',
                    'uname' => $local_user,
					'subscribe'=>$wxid_info->subscribe,
					'nickname'=>$wxid_info->nickname,
					'sex'=>$wxid_info->sex,
					'city'=>$wxid_info->city,
					'country'=>$wxid_info->country,
					//'headimgurl'=>$wxid_info->headimgurl,
						'headimgurl'=>$portrait,
					'subscribe_time'=>$wxid_info->subscribe_time,
               
          );
		  

		   $this->weixin_user->edit("user_id=".$user_info['user_id'],$data);
     



 $contentStr=$wx_mod->wxtj($access_token,$user_info,$wxconfig);


	

	//echo $resultStr;	
echo $this->send_img($this->ToUserName, $this->FromUserName, $contentStr);
 
 


}	
	
	
//生成二维码

if($Content=='222')
{
 $user_info=$this->weixin_user->get(array('conditions'=>" wxid ='".$this->FromUserName."'"));

   $wxuser_id= $user_info['user_id'];
   $user_info=$this->user_mod->get($wxuser_id);


	$scene_id = $wxuser_id;
    $affiliate=$wxuser_id;
	$wxch_qr_info= $this->wxchqr->get("scene_id=".$wxuser_id);
	
	
	if($wxch_qr_info['qr_path'])
	{   
	    $des_title="推荐二维码";
		$des="扫描二维码可以获得推荐关系！";
		$url_pic=SITE_URL."/".$wxch_qr_info['qr_path'];
		$web_url=SITE_URL."/".$wxch_qr_info['qr_path'];
		
		$news[]=array('title'=>$des_title,'description'=>$des,'picurl'=>$url_pic,'url'=>$web_url);
		
	 echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);

	exit();
	}
	
	

   $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;	

	  
	  
		
		
		
		
	 $scene=$user_info['user_name'];
	 $action_name="QR_LIMIT_SCENE";
	  	$qrcode = array('action_name'=>$action_name,'action_info'=>array('scene'=>array('scene_id'=>$scene_id)));
	  
         $qrcode = json_encode($qrcode);

	$ticket=$wx_mod->https_post($url,$qrcode); 
	  $ticket_url = urlencode($ticket);
	 $url= "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket_url;
	   $imageinfo= file_get_contents($url);

      $time = time();	
	 $timepath = $time.'.jpg';
	 
	
	 $path = ROOT_PATH.'/data/files/mall/weixin_qrcode/'.$timepath;
	 
	 if (!file_exists(dirname($path)))
        {
            ecm_mkdir(dirname($path));
        }
	 
	 $local_file=fopen($path,'w');
	 if(false !==$local_file)
	 {
		 if(false !==fwrite($local_file,$imageinfo)){
			fclose($local_file); 
		 }
		 
		 $data=array(
		 'wxid'=>$wxid,
		 'action_name'=>$action_name,
		 'scene_id'=>$scene_id,
		 'ticket'=>$ticket,
		 'scene'=>$scene,
		 'qr_path'=>'data/files/mall/weixin_qrcode/'.$timepath,
		 );
		 
		 $this->wxchqr->add($data);
		 
	 }
	 
	 
	    $des_title="推荐二维码";
		$des="扫描二维码可以获得推荐关系！";
		$url_pic=SITE_URL."/".'data/files/mall/weixin_qrcode/'.$timepath;
		$web_url=SITE_URL."/".'data/files/mall/weixin_qrcode/'.$timepath;
		
		$news[]=array('title'=>$des_title,'description'=>$des,'picurl'=>$url_pic,'url'=>$web_url);
		
		 echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
	 
//echo $this->send($this->ToUserName, $this->FromUserName, $path);

	
 //echo $this->send($this->ToUserName, $this->FromUserName, $wxuser_id);
}	
	
	
if($Content == 'kf')
{
	 echo $this->send2($this->ToUserName, $this->FromUserName,$this->ToUserName);
	
}	
	
	  if ($Content == '111') {
				 
	
				

	// echo $this->send($this->ToUserName, $this->FromUserName,"您已注册成功");
			 
	 $weixin_user =$this->weixin_user =& m('weixinuser');
   
     $local_user=time().rand(1,10000);

     $ms =& ms(); //连接用户中心
	
	  $user_info=$this->weixin_user->get(array('conditions'=>" wxid ='".$this->FromUserName."'"));
	  if(!$user_info)
      {
        
	
		
		/*$redadd=array(
		
		'portrait'=>$wxid_info->headimgurl,
		
		  );*/
		  
		  
		  $redadd=array(
		
		'portrait'=>"images/head/".time().".jpg",
		
		  );
        $user_id = $ms->user->register($local_user, '000000',time().'@vchuang.cn',$redadd);
     
	     $data = array(
                    'user_id' => $user_id,
                    'wxid' => $this->FromUserName,
                    'setp' => '3',
                    'uname' => $local_user,
					'subscribe'=>$wxid_info->subscribe,
					'nickname'=>$wxid_info->nickname,
					'sex'=>$wxid_info->sex,
					'city'=>$wxid_info->city,
					'country'=>$wxid_info->country,
					'headimgurl'=>$wxid_info->headimgurl,
					'subscribe_time'=>$wxid_info->subscribe_time,
               
          );
		  
		   $this->weixin_user->add($data);
	  }else {
		  
		  $contentreg= "输入【help】查看帮助\r\n输入【cxbd】绑定会员\r\n输入【quit】退出绑定\r\n输入【member】会员中心\r\n输入【new】查看最新商品\r\n输入【hot】查看热卖商品\r\n输入【best】查看推荐商品\r\n输入【promote】特价促销\r\n输入【qiandao】签到送积分\r\n输入【ddcx】查询订单\r\n输入【kdcx】快递查询\r\n输入【jfcx】查询积分、余额";
		  
		 $portrait="images/head/".time().".jpg";
		  
		  $this->download_remote_file($wxid_info->headimgurl,$portrait);
		
		  $redadd=array(
		
		'portrait'=>$portrait,
		
		  );
		$this->user_mod->edit($user_info['user_id'],$redadd);
		  
		   $data = array(
                    'wxid' => $this->FromUserName,
                    'setp' => '3',
                    'uname' => $local_user,
					'subscribe'=>$wxid_info->subscribe,
					'nickname'=>$wxid_info->nickname,
					'sex'=>$wxid_info->sex,
					'city'=>$wxid_info->city,
					'country'=>$wxid_info->country,
					'headimgurl'=>$portrait,
					'subscribe_time'=>$wxid_info->subscribe_time,
               
          );
		  
		  
		   $this->weixin_user->edit("user_id=".$user_info['user_id'],$data);
		  
		//   echo $this->send($this->ToUserName, $this->FromUserName, $contentreg);
		  
		  }


   


 $password='000000';
  if($user_id)
  {
	 
   $contentreg = "\n恭喜您,用户注册成功!\n用户为:".$local_user."\n密码为:".$password."\r\n<a href='".SITE_URL."/index.php?wxid=".$this->FromUserName."'>进入商城首页</a>\r\n<a href='".$store_index."'>店铺首页</a>\r\n<a href='".$url."'>进入会员中心</a>";
   }else{
	   $contentreg = "\n恭喜您,用户注册成功!\n用户为:".$local_user."\n密码为:".$password."\r\n<a href='".SITE_URL."/index.php?wxid=".$this->FromUserName."'>进入商城首页</a>\r\n<a href='".$url."'>进入会员中心</a>"; 
	   }
				 
 //echo $this->send($this->ToUserName, $this->FromUserName, $contentreg);
			
	
	
	 }
			 
			 
  /*绑定流程*/
  

      
if($Content == 'cxbd')
{
  $contentStr = '您已进入会员绑定流程，想要退出绑定流程请回复【quit】,继续请输入网站会员昵称';
 $this->weixin_user->edit( "wxid='".$this->FromUserName."'","setp=1");	
 echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);
}

if($setp > 0 and $setp < 3)
{
	
	
    /*退出绑定*/
if($Content =='quit'){
        $this->weixin_user->edit( "wxid='".$this->FromUserName."'","setp=3");
          $contentStr = "您已退出会员绑定流程，再次绑定输入【cxbd】进入绑定流程";
          
     echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);
      
}	
	
	
if($setp==1)
{


			
$member = $this->user_mod->get("user_name  ='".$Content."'");
     
if($member)
{

$contentStr = '请输入密码';
$this->weixin_user->edit( "wxid='".$this->FromUserName."'","setp=2");
$this->weixin_user->edit( "wxid='".$this->FromUserName."'","uname='".$Content."'");
 echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);
	
}else
{
	
$contentStr ="您输入的用户名不存在，检查之后请重新输入：" . $Content."\n退出绑定回复【quit】";
echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);	
	
}


	
	   
}elseif($setp==2)
{

    $ms =& ms();
     $user_id = $ms->user->auth($user_info['uname'], $Content);
       if (!$user_id)
       {
        
	$contentStr ="密码不正确：" . $Content."\n退出绑定回复【quit】";
  echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);	
	
	   }else{
		   
     $member = $this->user_mod->get("user_name  ='".$user_info['uname']."'");		   
		   
	 $this->weixin_user->edit( "wxid='".$this->FromUserName."'","setp=3"); 
	 $this->weixin_user->edit( "wxid='".$this->FromUserName."'","user_id='".$member[user_id]."'");   
	 $contentStr = $user_info['uname'] . '，您的账号已经绑定成功！';
  echo $this->send($this->ToUserName, $this->FromUserName, $contentStr); 
		 
		   }

}
	 
 //echo $this->send($this->ToUserName, $this->FromUserName, "成功");	
		
}	
	
if ($Content == 'cxye')
{

$epay=&m('epay');	
$epayye = $epay->get(array('conditions'=>"user_id='".$user_info[user_id]."'"));

$integral_log = & m('integral_log');
$integralye = $integral_log->get("user_id=".$user_info['user_id']);

 $contentStr = "余额：$epayye[money]\r\n积分：$integralye[point]";

 echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);	
}			
if ($Content == 'member')
{
	  
  

$contentStr = "<a href='".$url."'>点击进入会员中心</a>";

 echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);		  
}

if($Content =='kdcx')
{
	
$contentStr="查询物流输入dd:+物流号".'列如：dd:1234567';
echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);

}

if($dd)
{
	
	 
	  $order_mod = &m('order');
	  $order_info  = $order_mod->get(array(
            'conditions' => "(status=40 OR (status=30 )) AND invoice_no='$dd' AND (seller_id=$user_info[user_id] OR buyer_id=$user_info[user_id])",
			'fields'=>'invoice_no,express_company,buyer_id,seller_id',
        ));
		
		// 如果快递公司或者快递单号为空，则返回空
if(empty($order_info['invoice_no']) || empty($order_info['express_company'])){
	     $contentStr = '订单号：' . $order_info['order_sn'] . '还没有快递单号，不能查询';
		  echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);	
			  
 }

   $k_arr = $this->kuaidi($order_info['invoice_no'],$order_info['express_company']);
 if ($k_arr['message'] == 'ok') {
      $count = count($k_arr['data']) - 1;
      for ($i = $count; $i >= 0; $i--) {
     $contents.= "\r\n" . $k_arr['data'][$i]['time'] . "\r\n" . $k_arr['data'][$i]['context'];
                  
	     }
		 
		   $contentStr = "快递信息" . $contents;
		   
 echo $this->send($this->ToUserName, $this->FromUserName, $contentStr);	
	
    }
	


}


if($Content == 'ddcx')
{
	
	

	
	 $model_order= &m('order');
		$orders = $model_order->findAll(array(
            'conditions'    => "buyer_id='$user_info[user_id]'",
            'fields'        => 'this.*',
            'count'         => true,
            'limit'         => '10',
            'order'         => 'add_time DESC',
            'include'       =>  array(
                'has_ordergoods',       //取出商品
            ),
        ));
		
		$refund_mod = &m('refund');
        foreach ($orders as $key1 => $order)
        {
            foreach ($order['order_goods'] as $key2 => $goods)
            {   
                empty($goods['goods_image']) && $orders[$key1]['order_goods'][$key2]['goods_image'] = Conf::get('default_goods_image');
				
				
				
				/* 是否申请过退款 */
				$refund = $refund_mod->get(array('conditions'=>'order_id='.$goods['order_id'].' and goods_id='.$goods['goods_id'].' and spec_id='.$goods['spec_id'],'fields'=>'status,order_id'));
				if($refund) {
					$orders[$key1]['order_goods'][$key2]['refund_status'] = $refund['status'];
					$orders[$key1]['order_goods'][$key2]['refund_id'] = $refund['refund_id'];
				}
            }
    }
		
		

	foreach ($orders as $vv)
   {
	   
	   foreach ($vv['order_goods'] as $v){
		   
		         if ($vv['status'] == ORDER_SUBMITTED) {
                        $pay_status = '支付状态：已发货';
                    } elseif ($vv['status'] == ORDER_PENDING) {
                        $pay_status = '支付状态：等待买家付款';
                    } elseif ($vv['status'] == ORDER_ACCEPTED) {
                        $pay_status = '支付状态：等待卖家发货';
                    }elseif ($vv['status']== ORDER_SHIPPED) {
                        $pay_status = '支付状态：卖家已发货';
                    }elseif ($vv['status']==ORDER_FINISHED) {
                        $pay_status = '支付状态：交易成功';
                    }elseif ($vv['status']==ORDER_CANCELED) {
                        $pay_status = '支付状态：交易已取消';
                    }
		   $goods_image= SITE_URL.'/'.$v['goods_image'];
		   
		   $title='订单号:'.$vv['order_sn'].' 商品价格:'.$v['price'].$pay_status;
		   
	    $url=SITE_URL.'/index.php?app=buyer_order&act=view&order_id='.$vv['order_id']."&wxid=".$wxid;
		$news[]=array('title'=>$title,'description'=>$v['goods_name'],'picurl'=>$goods_image,'url'=>"$url");	
		
	   }
  
   }
	
	
	
	
	
	
	 echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
	
	
}

			
            //判断是否为系统默认的功能  
            if ($Content == '会员卡') {
                $store_id = $user_id;
                $membership_setting_mod = &m('membership_setting');
                $membership_setting = $membership_setting_mod->get($store_id);

                if (!empty($membership_setting)) {
                    $news[0]['title'] = $membership_setting['title'];
                    $news[0]['picurl'] = "http://" . $_SERVER['SERVER_NAME'] . '/' . $membership_setting['cover_image'];
                    $news[0]['url'] = SITE_URL . '/index.php?app=membership&id=' . $store_id;
                    echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
                    return;
                }
            }
            
      
            
            $weixin_info = $this->my_wxkeyword_mod->get_kword($Content, $user_id);
            if (!empty($weixin_info)) {
				
					

                if (is_array($weixin_info)) {
                    if (!empty($weixin_info['kecontent']) && $weixin_info['type'] == 1) {
                        echo $this->send($this->ToUserName, $this->FromUserName, $weixin_info['kecontent']);
                    } else {
                        $titles = unserialize($weixin_info['titles']);
                        $imageinfo = unserialize($weixin_info['imageinfo']);
                        $linkinfo = unserialize($weixin_info['linkinfo']);
                        $news = array();
                        for ($i = 0; $i < count($titles); $i++) {
                            $news[$i]['title'] = $titles[$i];
                            if (stristr($imageinfo[$i], $_SERVER['SERVER_NAME'])) {
                                $news[$i]['picurl'] = $imageinfo[$i];
                            } else {
                                $news[$i]['picurl'] = "http://" . $_SERVER['SERVER_NAME'] . '/' . $imageinfo[$i];
                            }
                            $news[$i]['url'] = $linkinfo[$i];
                        }

                        echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
                    }
                }
            } else {
				
		
			
	
				
   
	
		   $id= $this->my_wxkeyword_mod->get('user_id='.$user_id.' and ismess = 1');
               // $id = $this->my_wxkeyword_mod->get_mess_id($user_id);
				/*	 $postData = var_export($id, true);
						 echo $this->send($this->ToUserName, $this->FromUserName,$postData);*/	
                $id = empty($id) ? 0 : $id;
                if ($id) {
		
                    $wxmess = $this->my_wxkeyword_mod->get('user_id='.$user_id.' and ismess = 1');
					
                    if (is_array($wxmess)) {
                        if (!empty($wxmess['kecontent']) && $wxmess['type'] == 1) {
                            echo $this->send($this->ToUserName, $this->FromUserName, $wxmess['kecontent']);
                        } else {
                            $titles = unserialize($wxmess['titles']);
                            $imageinfo = unserialize($wxmess['imageinfo']);
                            $linkinfo = unserialize($wxmess['linkinfo']);
							
							
							//$postData = var_export($titles, true);
						// echo $this->send($this->ToUserName, $this->FromUserName,$postData);
                            $news = array();
                            for ($i = 0; $i < count($titles); $i++) {
                                $news[$i]['title'] = $titles[$i];
                                if (stristr($imageinfo[$i], $_SERVER['SERVER_NAME'])) {
                                    $news[$i]['picurl'] = $imageinfo[$i];
                                } else {
                                    $news[$i]['picurl'] = "http://" . $_SERVER['SERVER_NAME'] . '/' . $imageinfo[$i];
                                }
                                //$news[$i]['picurl'] =  str_replace('..',SITE_URL, $imageinfo[$i]);
                                $news[$i]['url'] = $linkinfo[$i];
                            }

                            echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
                        }
                    }//判断数组
                }//判断自动回复
            }//自动回复
			

			
        }else if ($MsgType == 'event') {
            if ($MsgEvent == 'subscribe') {
              /*关注 并注册*/ 
			   
	
	 $user_info=$this->weixin_user->get(array('conditions'=>" wxid ='".$this->FromUserName."'"));

	if (isset($xmlObj->EventKey)){
		
		
		$scene_id_arr = explode("qrscene_", $xmlObj->EventKey);
		$scene_id = $scene_id_arr[1];
		
		if($scene_id){
	  $wxch_qr_info= $this->wxchqr->get("scene_id=".$scene_id);
	  
      $tuijian_id=$wxch_qr_info['scene_id'];
	      $tj_info=  $this->weixin_user->get("user_id=".$scene_id);
	     $is_qr='1';
		 
	  
	   $this->wxchqr->edit($wxch_qr_info['qid'],"subscribe=subscribe+1");
	  } 
	  	  // echo $this->send($this->ToUserName, $this->FromUserName, $tuijian_id);
	  }

    if(!$user_info)
	{
	
	   $local_user=time().rand(1,10000);
   
 // echo $this->send($this->ToUserName, $this->FromUserName, 'yyyyyy');
     $ms =& ms(); //连接用户中心
     
	 $password='000000';
	 
	 	$redadd=array(
		
		'portrait'=>$wxid_info->headimgurl,
		//'sid'=>$this->_store_id,
		//'sname'=>$sname,
		//'tuijian_id'=>$tuijian_id,
		//'is_qr'=>$is_qr,
		'referid'=>$tuijian_id,
		  );
		  
	  
     $user_id_id = $ms->user->register($local_user, $password, time().'@vchuang.cn',$redadd);
     
            import('integral.lib');
            $integral=new Integral();
            $integral->change_integral_reg($user_id_id);
            /*用户注册如果有推荐人，则推荐人增加积分*/
            if($tuijian_id){
                $integral->change_integral_recom($tuijian_id);
            }
			
	     $data = array(
                    'user_id' => $user_id_id,
                    'wxid' => $this->FromUserName,
                    'setp' => '3',
                    'uname' => $local_user,
					'subscribe'=>$wxid_info->subscribe,
					'nickname'=>$wxid_info->nickname,
					'sex'=>$wxid_info->sex,
					'city'=>$wxid_info->city,
					'country'=>$wxid_info->country,
					'headimgurl'=>$wxid_info->headimgurl,
					'subscribe_time'=>$wxid_info->subscribe_time,
               
          );
		  
	$this->weixin_user->add($data);
	
	 if($is_qr)
{
	
	    $this->tjspen($tuijian_id,'恭喜您已成功推荐会员：'.$wxid_info->nickname);
	
	$memberzo= $this->user_mod->getOne("SELECT COUNT(*) FROM " . DB_PREFIX . "member ");
$tj_deil=$wxid_info->nickname.'，恭喜您由'.$tj_info['nickname'].'推荐成为'.$this->wx_name.'的会员！目前已经有【'.$memberzo.'】位会员，推广您的二维码，让您每天睡觉也能赚大钱！';
		echo $this->send($this->ToUserName, $this->FromUserName, $tj_deil);exit();
} 
	
	
		   
  $id = $this->my_wxkeyword_mod->get_follow_id($this->_store_id);
                if ($id > 0) {
					
						 
                    $wxfollow = $this->my_wxkeyword_mod->get($id);
                    if (is_array($wxfollow)) {
					
                        if ($wxfollow['type'] == 1) {
                            echo $this->send($this->ToUserName, $this->FromUserName, $wxfollow['kecontent']);
                        } else {
	 
                            $titles = unserialize($wxfollow['titles']);
                            $imageinfo = unserialize($wxfollow['imageinfo']);
                            $linkinfo = unserialize($wxfollow['linkinfo']);
                            $news = array();
                            for ($i = 0; $i < count($titles); $i++) {
                                $news[$i]['title'] = $titles[$i];
                                if (stristr($imageinfo[$i], $_SERVER['SERVER_NAME'])) {
                                    $news[$i]['picurl'] = $imageinfo[$i];
                                } else {
                                    $news[$i]['picurl'] = "http://" . $_SERVER['SERVER_NAME'] . '/' . $imageinfo[$i];
                                }
                                $news[$i]['url'] = $linkinfo[$i];
                            }

                            echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
                        }
                    }//判断数组
                }//判断是否成在关注
	
	
   // echo $this->send($this->ToUserName, $this->FromUserName, 'eeeeee');	 
	
		
	}else
	{
			 
		  
		$gongneng= "功能表 \r\n输入【help】查看帮助\r\n输入【cxbd】绑定会员\r\n输入【quit】退出绑定\r\n输入【member】会员中心\r\n输入【ddcx】查询订单\r\n输入【kdcx】快递查询\r\n输入【cxye】查询积分、余额";
		
		 $data = array(
                   
                    'wxid' => $this->FromUserName,
                    'setp' => '3',
                    'uname' => $local_user,
					'subscribe'=>$wxid_info->subscribe,
					'nickname'=>$wxid_info->nickname,
					'sex'=>$wxid_info->sex,
					'city'=>$wxid_info->city,
					'country'=>$wxid_info->country,
					'headimgurl'=>$wxid_info->headimgurl,
					'subscribe_time'=>$wxid_info->subscribe_time,
               
          );
		  
		   $this->weixin_user->edit("user_id=".$user_info['user_id'],$data);
		  
	 
	}
	//////
	

	
	              $id = $this->my_wxkeyword_mod->get_follow_id($this->_store_id);
                if ($id > 0) {
                    $wxfollow = $this->my_wxkeyword_mod->get($id);
                    if (is_array($wxfollow)) {
                        if ($wxfollow['type'] == 1) {
                            echo $this->send($this->ToUserName, $this->FromUserName, $wxfollow['kecontent']);
                        } else {

                            $titles = unserialize($wxfollow['titles']);
                            $imageinfo = unserialize($wxfollow['imageinfo']);
                            $linkinfo = unserialize($wxfollow['linkinfo']);
                            $news = array();
                            for ($i = 0; $i < count($titles); $i++) {
                                $news[$i]['title'] = $titles[$i];
                                if (stristr($imageinfo[$i], $_SERVER['SERVER_NAME'])) {
                                    $news[$i]['picurl'] = $imageinfo[$i];
                                } else {
                                    $news[$i]['picurl'] = "http://" . $_SERVER['SERVER_NAME'] . '/' . $imageinfo[$i];
                                }
                                $news[$i]['url'] = $linkinfo[$i];
                            }

                            echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
                        }
                    }//判断数组
                }//判断是否成在关注
	
	
	
	
			   
			   
			     
			   
            }//关注事件
            elseif ($MsgEvent == 'CLICK') {
				
				 	
				
				
                if ($EventKey != '') {
                    $this->my_wxmenu_mod = & m('wxmenu');
                    $custom_key = $this->my_wxmenu_mod->getOne("select weixin_keyword from {$this->my_wxmenu_mod->table} where weixin_key='" . $EventKey . "'");
                    $key_list = $this->my_wxkeyword_mod->get_kword($custom_key, $user_id);
                    if (is_array($key_list)) {
                        if ($key_list['type'] == 1) {//文本
                            echo $this->send($this->ToUserName, $this->FromUserName, $key_list['kecontent']);
                        } else { //图文
                            $titles = unserialize($key_list['titles']);
                            $imageinfo = unserialize($key_list['imageinfo']);
                            $linkinfo = unserialize($key_list['linkinfo']);
                            $news = array();
                            for ($i = 0; $i < count($titles); $i++) {
                                $news[$i]['title'] = $titles[$i];
                                if (stristr($imageinfo[$i], $_SERVER['SERVER_NAME'])) {
                                    $news[$i]['picurl'] = $imageinfo[$i];
                                } else {
                                    $news[$i]['picurl'] = "http://" . $_SERVER['SERVER_NAME'] . '/' . $imageinfo[$i];
                                }
                                $news[$i]['url'] = $linkinfo[$i];
                            }
                            echo $this->send_pic($this->ToUserName, $this->FromUserName, $news);
                        }
                    }
                }
            }
      //end
	     }
  
  //end结束
    }

    /* 内部函数 */

    private function send($ToUserName, $FromUserName, $content) {
        $content = $this->wx_content($content);
        //global $ToUserName,$FromUserName;
        $str = "<xml>
				 <ToUserName><![CDATA[%s]]></ToUserName>
				 <FromUserName><![CDATA[%s]]></FromUserName>
				 <CreateTime>%s</CreateTime>
				 <MsgType><![CDATA[text]]></MsgType>
				 <Content><![CDATA[%s]]></Content>
				</xml>";
        return $resultstr = sprintf($str, $FromUserName, $ToUserName, time(), $content);
    }

   private function send_img($ToUserName, $FromUserName, $content) {
     
        //global $ToUserName,$FromUserName;
        $str ="<xml>
                            <ToUserName><![CDATA[%s]]></ToUserName>
                            <FromUserName><![CDATA[%s]]></FromUserName>
                            <CreateTime>%s</CreateTime>
                            <MsgType><![CDATA[image]]></MsgType>
                            <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                            </Image>
                            </xml>";
        return $resultstr = sprintf($str, $FromUserName, $ToUserName, time(), $content);
    }


    private function send2($ToUserName, $FromUserName, $content) {
       
        //global $ToUserName,$FromUserName;
        $str = "<xml>
				 <ToUserName><![CDATA[%s]]></ToUserName>
				 <FromUserName><![CDATA[%s]]></FromUserName>
				 <CreateTime>%s</CreateTime>
				 <MsgType><![CDATA[transfer_customer_service]]></MsgType>
				 <Content><![CDATA[%s]]></Content>
				</xml>";
				
				
				
        return $resultstr = sprintf($str, $FromUserName, $ToUserName, time(), $content);
    }
    private function send_pic($ToUserName, $FromUserName, $arr) {
        //global $ToUserName,$FromUserName;
        $str = "<xml>
				 <ToUserName><![CDATA[" . $FromUserName . "]]></ToUserName>
				 <FromUserName><![CDATA[" . $ToUserName . "]]></FromUserName>
				 <CreateTime>" . time() . "</CreateTime>
				 <MsgType><![CDATA[news]]></MsgType>
				 <ArticleCount>" . count($arr) . "</ArticleCount>
				 <Articles>";
        foreach ($arr as $k => $v) {
            if ($k == 0) {
                $picurl = $v['picurl'];
            } else {
                $picurl = $v['picurl'];
            }
            $v['url'] = $this->wx_links($v['url']);
            $str .="
					 <item>
					 <Title><![CDATA[" . $v['title'] . "]]></Title> 
					 <Description><![CDATA[" . $v['description'] . "]]></Description>
					 <PicUrl><![CDATA[" . $picurl . "]]></PicUrl>
					 <Url><![CDATA[" . $v['url'] . "]]></Url>
					 </item>";
        }

        $str .= "</Articles></xml>";


        return $str;
    }
    
    
	
	 public function kuaidi($invoice_no, $shipping_name) {
        switch ($shipping_name) {
            case 'ems':
                $logi_type = 'ems';
                break;

            case 'shentong':
                $logi_type = 'shentong';
                break;

            case 'yuantong':
                $logi_type = 'yuantong';
                break;

            case 'shunfeng':
                $logi_type = 'shunfeng';
                break;

            case 'yunda':
                $logi_type = 'yunda';
                break;

            case 'tiantian':
                $logi_type = 'tiantian';
                break;

            case 'zhongtong':
                $logi_type = 'zhongtong';
                break;

            case 'zengyisudi':
                $logi_type = 'zengyisudi';
                break;
        }
       $kurl = 'http://www.kuaidi100.com/query?type='.$logi_type.'&postid=' . $invoice_no;
     
	   $ret= ecm_fopen($kurl);
		//$ret = $this->curl_get_contents($kurl);
        $k_arr = json_decode($ret, true);
		
	
        return $k_arr;
    }
    
    
	
	 public function curl_get_contents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 1);
        curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);
        curl_setopt($ch, CURLOPT_REFERER, _REFERER_);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        $r = curl_exec($ch);
        curl_close($ch);
        return $r;
    }
    /*
     * 链接处理  对用户新增的链接，加上  特定数值 用于自动登录  
     * 此处是处理 用户自动回复
     * user_openid    FromUserName
     * store_openid   ToUserName
     */
 private function wx_links($linkinfo) {//链接处理
        if (stristr($linkinfo, $_SERVER['SERVER_NAME'])) {
            if (stristr($linkinfo, "?")) {
                $links = $linkinfo . "&wxid=" . $this->FromUserName . "&store_openid=" . $this->ToUserName."&key=".$this->_key;
            } else {
                $links = $linkinfo . "?wxid=" . $this->FromUserName . "&store_openid=" . $this->ToUserName."&key=".$this->_key;
            }
        } else {
            $links = $linkinfo;
        }
        return $links;
    }
    
    private function wx_content($contentStr) {
        $str = $contentStr;
        $reg = '/\shref=[\'\"]([^\'"]*)[\'"]/i';
        preg_match_all($reg, $str, $out_ary); //正则：得到href的地址
        $src_ary = $out_ary[1];
        if (!empty($src_ary)) {//存在
            $comment = $src_ary[0];
            if (stristr($comment, $_SERVER['SERVER_NAME'])) {
                if (stristr($comment, "?")) {
                    $links = $comment . "&wxid=" . $this->FromUserName . "&store_openid=" . $this->ToUserName."&key=".$this->_key;
                    $contentStr = str_replace($comment, $links, $str);
                } else {
                    $links = $comment . "?wxid=" . $this->FromUserName . "&store_openid=" . $this->ToUserName."&key=".$this->_key; 
                    $contentStr = str_replace($comment, $links, $str);
                }
            }
        }
        return $contentStr;
    }



 function wxkf()
{
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
 curl_setopt($ch, CURLOPT_TIMEOUT, 1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 if ($proxystatus == 'true') {
     curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
     curl_setopt($ch, CURLOPT_PROXY, $proxy);
 }
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_URL, $url);
if(!empty($ref_url)){
     curl_setopt($ch, CURLOPT_HEADER, TRUE);
     curl_setopt($ch, CURLOPT_REFERER, $ref_url);
}
 curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
 @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
 curl_setopt($ch, CURLOPT_POST, TRUE);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 ob_start();
 return curl_exec ($ch); // execute the curl command
 ob_end_clean();
 curl_close ($ch);
 unset($ch);


}

    
 private function curl_grab_page($url,$data,$proxy='',$proxystatus='',$ref_url='')
{
 $ch = curl_init();
 curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
 curl_setopt($ch, CURLOPT_TIMEOUT, 1);
 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 if ($proxystatus == 'true') {
     curl_setopt($ch, CURLOPT_HTTPPROXYTUNNEL, TRUE);
     curl_setopt($ch, CURLOPT_PROXY, $proxy);
 }
 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
 curl_setopt($ch, CURLOPT_URL, $url);
if(!empty($ref_url)){
     curl_setopt($ch, CURLOPT_HEADER, TRUE);
     curl_setopt($ch, CURLOPT_REFERER, $ref_url);
}
 curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
 @curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
 curl_setopt($ch, CURLOPT_POST, TRUE);
 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
 ob_start();
 return curl_exec ($ch); // execute the curl command
 ob_end_clean();
 curl_close ($ch);
 unset($ch);
}
   
  
 
 
 function tjspen($user_id,$content)
{
$weixin_user_mod =& m('weixinuser');
$weixin_user_info=$weixin_user_mod->get("user_id=".$user_id);


 $wxid = $weixin_user_info['wxid'];

 $config =$this->my_wxconfig_mod->get_info_user($this->_store_id);
	 
	      if (empty($config)) {
            exit;
        }
	     $token = $config['token'];
        $ACCESS_LIST = Init_Weixin::curl($config['appid'], $config['appsecret']);
		
           $access_token= $ACCESS_LIST['access_token'];
	
	  
	   
        $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
        
        $post_msg = '{
            "touser":"'.$wxid.'",
            "msgtype":"text",
            "text":
            {
                 "content":"'.$content.'"
            }
        }';
	
	
		
		 $ret_json = $this->curl_grab_page($url, $post_msg);
     
 // header('Location: index.php?app=member');
//$this->display('my_fx.html');
}

    
 
 

 function head($file_url, $save_to)
	{
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_POST, 0); 
		curl_setopt($ch,CURLOPT_URL,$file_url); 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
		$file_content = curl_exec($ch);
		curl_close($ch);
 
		$downloaded_file = fopen($save_to, 'w');
		fwrite($downloaded_file, $file_content);
		fclose($downloaded_file);
	}    

 
  private function download_remote_file($file_url, $save_to)
	{
		$content = file_get_contents($file_url);
		file_put_contents($save_to, $content);
	}    

}

?>