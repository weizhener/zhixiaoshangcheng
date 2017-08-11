<?php

class Init_Weixin
{
	 function uploadfile($para)
	 {
		import('image.func');
		import('uploader.lib');
		$uploader = new Uploader();
		$uploader->allowed_type(IMAGE_FILE_TYPE);
		$uploader->allowed_size(2097152); // 2M
		$files = $para; //$_FILES['activity_banner'];
		if ($files['error'] == UPLOAD_ERR_OK)
		{
				  /* 处理文件上传 */
				  $file = array(
					  'name'      => $files['name'],
					  'type'      => $files['type'],
					  'tmp_name'  => $files['tmp_name'],
					  'size'      => $files['size'],
					  'error'     => $files['error']
				  );
				  $uploader->addFile($file);
				  if (!$uploader->file_info())
				  {
					  $data = current($uploader->get_error());
					  $res = Lang::get($data['msg']);
					  $this->view_iframe();
					  echo "<script type='text/javascript'>alert('{$res}');</script>";
					  return false;
				  }
  
				  $uploader->root_dir(ROOT_PATH);
				  $dirname = 'data/files/mall/weixin';
				  $filename  = $uploader->random_filename();
				  $file_path = $uploader->save($dirname, $filename);
				  
		}
		return $file_path;
	 }
	
	  function _return_mimetype($filename)
	  {
		  preg_match("|\.([a-z0-9]{2,4})$|i", $filename, $fileSuffix);
		  switch(strtolower($fileSuffix[1]))
		  {
			  case "js" :
				  return "application/x-javascript";
  
			  case "json" :
				  return "application/json";
  
			  case "jpg" :
			  case "jpeg" :
			  case "jpe" :
				  return "image/jpeg";
  
			  case "png" :
			  case "gif" :
			  case "bmp" :
			  case "tiff" :
				  return "image/".strtolower($fileSuffix[1]);
  
			  case "css" :
				  return "text/css";
  
			  case "xml" :
				  return "application/xml";
  
			  case "doc" :
			  case "docx" :
				  return "application/msword";
  
			  case "xls" :
			  case "xlt" :
			  case "xlm" :
			  case "xld" :
			  case "xla" :
			  case "xlc" :
			  case "xlw" :
			  case "xll" :
				  return "application/vnd.ms-excel";
  
			  case "ppt" :
			  case "pps" :
				  return "application/vnd.ms-powerpoint";
  
			  case "rtf" :
				  return "application/rtf";
  
			  case "pdf" :
				  return "application/pdf";
  
			  case "html" :
			  case "htm" :
			  case "php" :
				  return "text/html";
  
			  case "txt" :
				  return "text/plain";
  
			  case "mpeg" :
			  case "mpg" :
			  case "mpe" :
				  return "video/mpeg";
  
			  case "mp3" :
				  return "audio/mpeg3";
  
			  case "wav" :
				  return "audio/wav";
  
			  case "aiff" :
			  case "aif" :
				  return "audio/aiff";
  
			  case "avi" :
				  return "video/msvideo";
  
			  case "wmv" :
				  return "video/x-ms-wmv";
  
			  case "mov" :
				  return "video/quicktime";
  
			  case "rar" :
				  return "application/x-rar-compressed";
  
			  case "zip" :
			  return "application/zip";
  
			  case "tar" :
				  return "application/x-tar";
  
			  case "swf" :
				  return "application/x-shockwave-flash";
  
			  default :
			  if(function_exists("mime_content_type"))
			  {
				  $fileSuffix = mime_content_type($filename);
			  }
			  return "unknown/" . trim($fileSuffix[0], ".");
		  }
	  }
	  
	  /**
     * 微信菜单AJAX返回数据标准
     *
     * @param int $status
     * @param string $msg
     * @param mixed $data
     * @param string $dialog
     */
    function ajaxReturn($status=1, $msg='', $data='', $dialog='') {
        $data = array(
            'status' => $status,
            'msg' => $msg,
            'data' => $data,
            'dialog' => $dialog,
        );
		header('Content-Type:text/html; charset=utf-8');
        exit(json_encode($data));
    }
	
	function curl($appid,$secret)
    {
		 $ch = curl_init(); 
		 curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$secret); 
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
		// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		 $tmpInfo = curl_exec($ch); 
		 if (curl_errno($ch)) {  
			echo 'Errno'.curl_error($ch);
		 }
		 curl_close($ch); 
		 $arr= json_decode($tmpInfo,true);
		 return $arr;
    }
	
	function curl_menu($ACCESS_TOKEN,$data)
    {
		$ch = curl_init(); 
		 curl_setopt($ch, CURLOPT_URL, "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$ACCESS_TOKEN); 
		 curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
		 curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
		 curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		 curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
		 curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		 curl_setopt($ch, CURLOPT_AUTOREFERER, 1); 
		 curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		 curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
		 $tmpInfo = curl_exec($ch); 
		 if (curl_errno($ch)) {  
		 
			echo 'Errno'.curl_error($ch);
		 }
		 curl_close($ch); 
		$arr= json_decode($tmpInfo,true);
		return $arr;
    }
	
	

 function curl_grab_page($url,$data,$proxy='',$proxystatus='',$ref_url='')
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



 function wxsend($access_token,$wxid,$content)
{

  $url = 'https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token='.$access_token;
  
  $post_msg = '{
            "touser":"'.$wxid.'",
            "msgtype":"text",
            "text":
            {
                 "content":"'.$content.'"
            }
          }';


   $ret_json =$this->curl_grab_page($url, $post_msg);
   $ret = json_decode($ret_json);
   
   return $ret;
}
	
	
function wxtj($access_token,$user_info,$wxconfig='')
{
	
	$wxchqr_mod= &m('wxchqr');

	$wxuser_id= $user_info['user_id'];
  $scene_id = $wxuser_id;
    $affiliate=$wxuser_id;
  
  $wxch_qr_info= $wxchqr_mod->get("scene_id=".$wxuser_id);
	
	
     $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
     $scene=$user_info['user_name'];
	 $action_name="QR_LIMIT_SCENE";
	 $qrcode = array('action_name'=>$action_name,'action_info'=>array('scene'=>array('scene_id'=>$scene_id)));
	  
     $qrcode = json_encode($qrcode);

	 $ticket=$this->https_post($url,$qrcode); 
	  $ticket_url = urlencode($ticket);
	 $url= "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$ticket_url;
	   $imageinfo= file_get_contents($url);

      $time = time();	
	 $timepath = $time.'.jpg';
	 
	
	 $path = ROOT_PATH.'/data/weixin_qrcode/'.$timepath;
	 
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
		 
		
	 }
	 
	 
	          $imgsrc = $path;
	          $h_imgsrc=$user_info['headimgurl'];
	 
	 
		
               $width = 250; 
				$height = 250;
				$time=time();
				
	           $name=$this->resizejpg($imgsrc,$width,$height,$time);
	        
			
			
	 		    $imgs = $name;				
				//处理头像     
				$width = 80; 
				$height = 80;
				$h_time=$time."_1";
			
				$h_name=$this->resizejpg($h_imgsrc,$width,$height,$h_time); 
				
				$h_imgs = $h_name;				
				$target = 'qrcode/qrcode.jpg';//背景图片
				
					
			   $target=$wxconfig['pic'] ? $wxconfig['pic'] : $target;
				
				$target_img = Imagecreatefromjpeg($target);
				$source = Imagecreatefromjpeg($imgs);
				$h_source = Imagecreatefromjpeg($h_imgs);
				imagecopy($target_img,$source,137,367,0,0,250,250);
				imagecopy($target_img,$h_source,60,28,0,0,80,80);
				$fontfile = "qrcode/simsun.ttf";
				#水印文
				
				$nickname='我是'.$user_info['nickname'];
				
			    $nickname_store ="我为某某代言";
				
								$nickname_store=$wxconfig['name'] ? "我为".$wxconfig['name']."代言"  : $nickname_store;
				
    	        $textcolor = imagecolorallocate($target_img, 0, 0, 255);
				
				imagettftext($target_img,18,0,268,59,$textcolor,$fontfile,$nickname);
				
				imagettftext($target_img,18,0,268,90,$textcolor,$fontfile,$nickname_store);	
				
					$tj_pic="qrcode/images/head/".$wxuser_id.'/'.$wxuser_id.'_qr.jpg';	
									
				Imagejpeg($target_img,$tj_pic);
				
				
				
$data=ROOT_PATH.'/'.$tj_pic;
$filedata=array("media"=>"@".$data);
$url = 'http://file.api.weixin.qq.com/cgi-bin/media/upload?access_token='.$access_token.'&type=image';
					
$res_json =$this->https_request($url, $filedata);

$json = json_decode($res_json);	
 $msgType = "image";
$iipp = $_SERVER["REMOTE_ADDR"];
$phone_state=$_SERVER['HTTP_USER_AGENT'];
 $contentStr = $json->media_id;
  
	if($wxch_qr_info)
	{
	
	 $qrdata=array(
		 'wxid'=>$wxid,
		 'action_name'=>$action_name,
		 'scene_id'=>$scene_id,
		 'ticket'=>$ticket,
		 'scene'=>$scene,
		 'qr_path'=>$tj_pic,
		// 'media_id'=>$contentStr,
		 );
	 $wxchqr_mod->edit($wxch_qr_info['qid'],$qrdata);
	}else{
		 $qrdata=array(
		 'wxid'=>$wxid,
		 'action_name'=>$action_name,
		 'scene_id'=>$scene_id,
		 'ticket'=>$ticket,
		 'scene'=>$scene,
		 'qr_path'=>$tj_pic,
		// 'media_id'=>$contentStr,
		 );
		 
		 $wxchqr_mod->add($qrdata);
		
		}
	
	   
	
	
		$h_time="qrcode/".$h_time.'.jpg';
		
		$name="qrcode/".$name.'.jpg';
	if(file_exists($h_time))
	{
		
	unlink($h_time);
	}
	
	if(file_exists($name))
	{
		
	unlink($name);
	}  
  
  if(file_exists($path))
	{
		
	unlink($path);
	}

return $contentStr;
}	
	
	
	
	

   function resizejpg($imgsrc,$imgwidth,$imgheight,$time) 
	{ 
		//$imgsrc jpg格式图像路径 $imgdst jpg格式图像保存文件名 $imgwidth要改变的宽度 $imgheight要改变的高度 
		//取得图片的宽度,高度值 
		$arr = getimagesize($imgsrc); 
		header("Content-type: image/jpg"); 
		$imgWidth = $imgwidth; 
		$imgHeight = $imgheight; 
		$imgsrc = imagecreatefromjpeg($imgsrc); 
		$image = imagecreatetruecolor($imgWidth, $imgHeight);
		imagecopyresampled($image, $imgsrc, 0, 0, 0, 0,$imgWidth,$imgHeight,$arr[0], $arr[1]);
		$name="qrcode/".$time.".jpg";  
		Imagejpeg($image,$name);
		return $name;
	}
	
	
	
	 function https_post($url,$data){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); 
    $result = curl_exec($curl); 
    if (curl_errno($curl)) { 
        return 'Errno'.curl_error($curl);
    }
    curl_close($curl); 
    $result=json_decode($result,true);
    $ticket = empty($result['ticket'])? '':$result['ticket'];
    return $ticket;
} 


  function https_request($url, $data = null)
{
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}	


 function download_remote_file($file_url, $save_to)
	{
		$content = file_get_contents($file_url);
		file_put_contents($save_to, $content);
	} 
	
}
?>
