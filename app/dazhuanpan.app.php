<?php

/*分类控制器*/
class DazhuanpanApp extends MallbaseApp
{
    
   
	/* 商品分类 */
    function index()
    {
        /* 取得导航 */
		
		
		$userid = $this->visitor->get("user_id");		
		

		
        $member_mod = &m('member');
        $member = $member_mod->get($userid);
		
		if(!$userid){
			$this->show_warning('请登录后操作');
		  	
	    }
		
		
        $this->assign('navs', $this->_get_navs());

         $this->_dazhuanpan_mod = &m('dazhuanpan');
		 
          $member_mod = &m('member');
		  $userid = $this->visitor->get("user_id");
          $member = $member_mod->get($userid);
		  
		  $this->assign('member',$member);
		 
		 

        /* 当前位置 */
        $_curlocal=array(
            array(
                'text'  => Lang::get('index'),
                'url'   => 'index.php',
            ),
            array(
                'text'  => Lang::get('mall_dazhuanpan'),
                'url'   => '/dazhuanpan/',
            ),
        );
	  
	 
		$db = &db();
		$sql = "select A.*,B.user_name,C.title ,C.zhizhen from ecm_dazhuanpan_log A left join ecm_member B on A.userid = B.user_id 
		LEFT JOIN ecm_dazhuanpan C ON A.jiangpin_id = C.id where A.is_zhong > 0 order by A.time desc limit 10";
		$zhongjiang_lis = $db -> query($sql);
	
		$i = 0;
		while($row = $db-> fetchrow($zhongjiang_lis))
		{	$zhongjiang_list[$i]['userid']=$row['userid'];
			$zhongjiang_list[$i]['title']=$row['title'];
			$zhongjiang_list[$i]['is_fangfa']=$row['is_fangfa'];
			$zhongjiang_list[$i]['is_zhong']=$row['is_zhong'];
			$zhongjiang_list[$i]['id']=$row['id'];
			$zhongjiang_list[$i]['time']=$row['time'];
			$zhongjiang_list[$i]['user_name']=$row['user_name'];
			$zhongjiang_list[$i]['zhizhen']=$row['zhizhen'];
			$i++;
		}
	
	
	
	    $this->assign('zhongjiang_list',$zhongjiang_list);
        $this->assign('_curlocal',$_curlocal);      
        $this->display('mall_dazhuanpan.html');
		
    }
	
	
	
     function json(){
		$userid = $this->visitor->get("user_id");
		if($userid){			
          $member_mod = &m('member');
          $member = $member_mod->get($userid);
          $json['error'] = "0";	
		  $json['meizhong'] = '0';
			
		  $db = &db();			
		  $gailv = rand(1,Conf::get('dazhuanpan_gailv')); 

		  $kongzhizhen = Conf::get('kongzhizhen');
		  $meizhongtishi = Conf::get('meizhongtishi');
		  $xiaohaojifen = Conf::get('dazhuanpan_jifen');		  
		  
		  $jiangpin = $db->getAll("select * from ecm_dazhuanpan where gailv>'{$gailv}'");
		  if($member['integral'] < $xiaohaojifen){
		    $json['error'] = "对不起,您的积分不足";				  
		  }else{		  
			$jiangping_id = rand(0,count($jiangpin)-1);			
			$z = $jiangpin[$jiangping_id];
			$jiangpin_num = $z['num'];
			$jiangpin_title = $z['title'];
			$jiangpin_zhizhen = $z['zhizhen'];
			$jiangpin_jid = $z['id']; 	
			if($gailv){
			  if($jiangpin_num<1){
		        $json['jiaodu'] = $kongzhizhen;	
				$json['tishi'] = $meizhongtishi;	
			    $json['meizhong'] = '1';	
			  }else{
		        $json['jiaodu'] = $jiangpin_zhizhen;	
				$json['tishi'] = "恭喜你，中了".$jiangpin_title;	
				$zhong = 1;
			  }			
			}else{
		      $json['jiaodu'] = $kongzhizhen;	
		      $json['tishi'] = $meizhongtishi;
			  $json['meizhong'] = '1';	
			}
            $member_mod->edit($userid, array('integral' => $member['integral'] - $xiaohaojifen));
            //操作记录入积分记录
            $integral_log_mod = &m('integral_log');
            $integral_log = array(
                'user_id' => $userid,
                'user_name' => $member['user_name'],
                'point' => $xiaohaojifen,
                'add_time' => gmtime(),
                'remark' => '大转盘抽奖',
                'integral_type' => INTEGRAL_DZP,
            );
            $integral_log_mod->add($integral_log);
			
			$member['integral'] = $member['integral']-$xiaohaojifen;
			
			if($zhong == 1){
			  $shuliang = $jiangpin_num-1;		
			  $time =  strtotime(date("y-m-d h:i:s",time()));//当前时间戳
			  $db->query("insert into ecm_dazhuanpan_log(id, userid ,is_zhong, jiangpin_id, is_fangfa, time) values('','$userid', '1' ,'$jiangpin_jid','0','$time')");
			  $db->query("UPDATE `ecm_dazhuanpan` SET `num` = $shuliang WHERE `id` = $jiangpin_jid");
			  $money = $z['money'];
              $member_mod->edit($userid, array('integral' => $member['integral'] + $money));
              //操作记录入积分记录
              $integral_log_mod = &m('integral_log');
              $integral_log = array(
                'user_id' => $userid,
                'user_name' => $member['user_name'],
                'point' => $money,
                'add_time' => gmtime(),
                'remark' => '大转盘中奖',
                'integral_type' => INTEGRAL_DZP,
              );
              $integral_log_mod->add($integral_log);
			  
			  
			  
		    } 		
	      }
	   	}else{
		  $json['error'] = "对不起,您还没有登陆";	
	    }
		$json['money'] = $member['integral'] + $money;
		$json['yizhuan'] = rand(360,1440);	
		echo ecm_json_encode($json);
		exit;
      }
	
 
     function xmlh(){
		$userid = $this->visitor->get("user_id");
	    header("Content-type: text/xml");  
		$xml= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>"; 
		$xml.="<root>";
		if($userid){			
          $member_mod = &m('member');
          $member = $member_mod->get($userid);

			
			
		  $db = &db();			
		  $gailv = rand(1,Conf::get('dazhuanpan_gailv')); 

		  $kongzhizhen = Conf::get('kongzhizhen');
		  $meizhongtishi = Conf::get('meizhongtishi');
		  $xiaohaojifen = Conf::get('dazhuanpan_jifen');		  
		  
		  $jiangpin = $db->getAll("select * from ecm_dazhuanpan where gailv>'{$gailv}'");
		  if($member['integral'] < $xiaohaojifen){			   
			$xml.="<jiaodu>0</jiaodu>";
			$xml.="<tishi>对不起 您的积分不足</tishi>";
		  }else{
		  

		  
		  
			$jiangping_id = rand(0,count($jiangpin)-1);
			
			$z = $jiangpin[$jiangping_id];

			$jiangpin_num = $z['num'];
			$jiangpin_title = $z['title'];
			$jiangpin_zhizhen = $z['zhizhen'];
			$jiangpin_jid = $z['id']; 	
			if($gailv){
			  if($jiangpin_num<1){
			    $xml.="<jiaodu>".$kongzhizhen."</jiaodu>";
				$xml.="<tishi>".$meizhongtishi."</tishi>";		
			  }else{
				$xml.="<jiaodu>".$jiangpin_zhizhen."</jiaodu>";
				$xml.="<tishi>恭喜您中了".$jiangpin_title."</tishi>";	
				$zhong = 1;
			  }			
			}else{
			  $xml.="<jiaodu>".$kongzhizhen."</jiaodu>";
			  $xml.="<tishi>".$meizhongtishi."</tishi>";	
			}
            $member_mod->edit($userid, array('integral' => $member['integral'] - $xiaohaojifen));
            //操作记录入积分记录
            $integral_log_mod = &m('integral_log');
            $integral_log = array(
                'user_id' => $userid,
                'user_name' => $member['user_name'],
                'point' => $xiaohaojifen,
                'add_time' => gmtime(),
                'remark' => '大转盘抽奖',
                'integral_type' => INTEGRAL_DZP,
            );
            $integral_log_mod->add($integral_log);
			
			$member['integral'] = $member['integral']-$xiaohaojifen;
			
			if($zhong == 1){
			  $shuliang = $jiangpin_num-1;		
			  $time =  strtotime(date("y-m-d h:i:s",time()));//当前时间戳
			  $db->query("insert into ecm_dazhuanpan_log(id, userid ,is_zhong, jiangpin_id, is_fangfa, time) values('','$userid', '1' ,'$jiangpin_jid','0','$time')");
			  $db->query("UPDATE `ecm_dazhuanpan` SET `num` = $shuliang WHERE `id` = $jiangpin_jid");
			  $money = $z['money'];
              $member_mod->edit($userid, array('integral' => $member['integral'] + $money));
              //操作记录入积分记录
              $integral_log_mod = &m('integral_log');
              $integral_log = array(
                'user_id' => $userid,
                'user_name' => $member['user_name'],
                'point' => $money,
                'add_time' => gmtime(),
                'remark' => '大转盘中奖',
                'integral_type' => INTEGRAL_DZP,
              );
              $integral_log_mod->add($integral_log);
			  
			  
			  
		    } 		
	      }
	   	}else{
		  $xml.="<jiaodu>0</jiaodu>";
		  $xml.="<tishi>对不起 您还没有登陆</tishi>";		
	    }
		$xml.="<tiaozhuan></tiaozhuan>";
		$xml.="<tiaozhuanleixing></tiaozhuanleixing>";
		$xml.="</root>";
        echo  $xml;
		exit;
      }

  
		 
		
}

?>