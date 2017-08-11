<?php

/*分类控制器*/
class jinhuaApp extends MallbaseApp
{
    
    function index()
    {
		

		
		$userid = $this->visitor->get("user_id");		
		

		
        $member_mod = &m('member');
        $member = $member_mod->get($userid);
		
		if(!$userid){
			$this->show_warning('请登录后操作');
		  	
	    }

	 
		$db = &db();	
		
		$jinhua = $db->getOne2("select * from ecm_jinhua where uid='{$userid}' and checked='0' order by id desc limit 1");	
		
		if(!$jinhua){
			exit('error');
		  	
	    }
		
		$v = $db->num_rows($db->query("select * from ecm_jinhua where uid='{$userid}' and checked='0'"));
		$this->assign('v',$v);
	    $this->assign('jinhua',$jinhua);  
        $this->display('jinhua.index.html');
		
    }
 
     function xmlh(){
		$userid = $this->visitor->get("user_id");
        $id = $_GET['id'];
		if(!$userid){
		  $error['error'] = "未登录";
		  echo ecm_json_encode($error);
		  exit;
		}			
        $member_mod = &m('member');
        $member = $member_mod->get($userid);		
		$db = &db();			  
		$jinhua = $db->getOne2("select * from ecm_jinhua where uid='{$userid}' and checked='0' and id='{$_GET['id']}' order by id desc limit 1");	
		if(!$jinhua){
		  $arr['error'] = "数据出错";
		  echo ecm_json_encode($arr);
		  exit;
		}
		$g = array();
		for($i=1;$i<5;$i++){
		  $j = rand(1,4);
		  while(in_array($j,$g)){
			$j = rand(1,4);  
		  }
		  $g[$i] = $j;
			
		}
		$arr['z'] = $_GET['t'];
		$arr['1'] = $jinhua['jinhua'.$g['1']];
		$arr['2'] = $jinhua['jinhua'.$g['2']];
		$arr['3'] = $jinhua['jinhua'.$g['3']];
		$arr['4'] = $jinhua['jinhua'.$g['4']];
		//$arr['5'] = $jinhua['jinhua'.$g['5']];
		$money = $arr[$arr['z']];
        $member_mod->edit($userid, array('integral' => $member['integral'] + $money));
        $integral_log_mod = &m('integral_log');
        $integral_log = array(
           'user_id' => $userid,
           'user_name' => $member['user_name'],
           'point' => $money,
           'add_time' => gmtime(),
           'remark' => '购物开金花',
           'integral_type' => INTEGRAL_DZP2,
         );
         $integral_log_mod->add($integral_log);
		 
		 
		 $db->query("update ecm_jinhua set checked='1',zhong='{$arr['z']}' where id='{$_GET['id']}'");
		 
		 $arr['n'] = $db->num_rows($db->query("select * from ecm_jinhua where uid='{$userid}' and checked='0'"));
		 
		 $arr['error'] = "0";
			  
		 echo ecm_json_encode($arr);
		 exit;
      }

  
		 
		
}

?>