<?php

class DazhuanpanModule extends AdminbaseModule
{
 

    function __construct()
    {
        $this->DazhuanpanModule();
    }
 
    function DazhuanpanModule()
    {
        parent::__construct();
		
        	
    } 
 
    function index()
    {   
		$model_setting = &af('settings');
        $setting = $model_setting->getAll(); //载入系统设置数据
        if (!IS_POST)
        {
            $this->assign('setting', $setting);
          	$this->display('dazhuanpan_setting.html');
			
        }
        else
        {
            /* 初始化 */
            // $data['dazhuanpan_power']  = empty($_POST['dazhuanpan_power']) ? '' : trim($_POST['dazhuanpan_power']);
             $data['dazhuanpan_gailv']  = empty($_POST['dazhuanpan_gailv'])   ? '' : trim($_POST['dazhuanpan_gailv']);
             $data['dazhuanpan_jifen']  = empty($_POST['dazhuanpan_jifen'])  ? '' : trim($_POST['dazhuanpan_jifen']);
			 $data['kongzhizhen']  = empty($_POST['kongzhizhen'])  ? '' : trim($_POST['kongzhizhen']);
			 $data['meizhongtishi']  = empty($_POST['meizhongtishi'])  ? '' : trim($_POST['meizhongtishi']);
            // $data['dandan_4']  = empty($_POST['dandan_4'])   ? '' : trim($_POST['dandan_4']);
           

		    /* Config */
            $config_file = ROOT_PATH . '/data/datacall.inc.php';
            $config = include($config_file);
            $new_config = var_export($config, true);
           
            /* 写入 */
            $model_setting->setAll($data);
            file_put_contents($config_file, "<?php\r\n\r\nreturn {$new_config};\r\n\r\n?>");

            $this->show_message('edit_dazhuanpan_setting_successed');
        }
    }
	
	function dazhuanpan_jiangpin()
    {   
		$db = &db();
		$count = 'select count(id) from ecm_dazhuanpan';
		
		$num = $db->getone($count);
		$page = $this->_get_page(10);//内置分页方法，将每页显示条数传入分页
		$page['item_count'] = $num;
		$this->_format_page($page);
		
		$sql = "select * from ecm_dazhuanpan order by time desc limit ".$page['limit'];
		$shangjia_lis = $db -> query($sql);
		$i = 0;
		while($row = $db-> fetchrow($shangjia_lis))
		{	$jiangpin_list[$i]['id']=$row['id'];
		    $jiangpin_list[$i]['money']=$row['money'];
			$jiangpin_list[$i]['title']=$row['title'];
			$jiangpin_list[$i]['gailv']=$row['gailv'];
			$jiangpin_list[$i]['num']=$row['num'];
			$jiangpin_list[$i]['time']=$row['time'];
			$i++;
		}
		 //print_r($shangjia_list);
		
		$this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条 
 		$this->assign('jiangpin_list', $jiangpin_list);
        $this->display('dazhuanpan_jiangpin.html');
		 
    }
	
	 function add()
    {   
		if($_POST){
		$title = trim($_POST['title']);
		$money = trim($_POST['money']);
		$gailv = trim($_POST['gailv']);
		$num = trim($_POST['num']);
		$zhizhen = trim($_POST['zhizhen']);
	    $time =  strtotime(date("y-m-d h:i:s",time()));//当前时间戳
		
		$add_sql = &db();
		$add_sql->query("insert into ecm_dazhuanpan(id, title, money,zhizhen, gailv, num, time) values('','$title', '$money', '$zhizhen' ,'$gailv','$num','$time')");
      	 
		$this->show_message('添加成功','返回列表','index.php?module=dazhuanpan&act=dazhuanpan_jiangpin');
	        return;
		 }
		 
        $this->display('add.form.html');  
    }
	function edit()
    {   
	
		$id = trim($_GET['id']);
		
		 if(empty($id)){
			$this->show_message('编辑失败','返回列表','index.php?module=dazhuanpan&act=dazhuanpan_shangjia');
	        return;			 
			 }
		if (!IS_POST){	
		 $edit_sql1 = &db();
		$jiangpin = $edit_sql1->getrow("select * from ecm_dazhuanpan where id=".$id);		
		//$this->assign('data', $data);
		$this->assign('jiangpin', $jiangpin);	
        $this->display('edit.form.html');
		}else{
		$id = trim($_POST['id']);	
		$title = trim($_POST['title']);
		$gailv = trim($_POST['gailv']);
		$num = trim($_POST['num']);
		$money = trim($_POST['money']);
		$zhizhen = trim($_POST['zhizhen']);
	    $time =  strtotime(date("y-m-d h:i:s",time()));//当前时间戳
		$edit_sql = &db();
		$edit_sql->query("UPDATE `ecm_dazhuanpan` SET `title` = '".$title."',`money` = '".$money."', `zhizhen` = $zhizhen , `time` = $time, `gailv` = $gailv, `num` = $num WHERE `id` = $id");
		$this->show_message('编辑成功','返回列表','index.php?module=dazhuanpan&act=dazhuanpan_jiangpin');
	        return;	
		 }
		 
	 
    }
	function fafang()
    {   
			 $id = trim($_GET['id']);
			 $edit_sql=&db();
			 $edit_sql->query("UPDATE `ecm_dazhuanpan_log` SET `is_fangfa` = 1 WHERE `id` = $id");
				 $this->show_message('设置发放成功','返回列表','index.php?module=dazhuanpan&act=dazhuanpan_log');
	        	 return;
    }
	
	function drop_log()
    {   
			 $pingpaitemai_id = trim($_GET['id']);
			 $Ids = explode(",",$pingpaitemai_id);
			 	
				 $drop_sql=&db();
				 for ($n=0;$n<count($Ids);$n++) {	
				 $drop_sql->query("delete from ecm_dazhuanpan_log where id = ".$Ids[$n]);
				 }
				 $this->show_message('删除成功','返回列表','index.php?module=dazhuanpan&act=dazhuanpan_log');
	        	 return;
    }
	
	function drop()
    {   
			 $pingpaitemai_id = trim($_GET['id']);
			 $Ids = explode(",",$pingpaitemai_id);
			 	
				 $drop_sql=&db();
				 for ($n=0;$n<count($Ids);$n++) {	
				 $drop_sql->query("delete from ecm_dazhuanpan where id = ".$Ids[$n]);
				 }
				 $this->show_message('删除成功','返回列表','index.php?module=dazhuanpan&act=dazhuanpan_jiangpin');
	        	 return;
    }
	
	
	
	function dazhuanpan_log()
    {   
		$db = &db();
		$count = 'select count(id) from ecm_dazhuanpan_log where is_zhong > 0';
		
		$num = $db->getone($count);
		$page = $this->_get_page(10);//内置分页方法，将每页显示条数传入分页
		$page['item_count'] = $num;
		$this->_format_page($page);
		
		$sql = "select A.*,B.user_name,C.title ,C.zhizhen from ecm_dazhuanpan_log A left join ecm_member B on A.userid = B.user_id 
		LEFT JOIN ecm_dazhuanpan C ON A.jiangpin_id = C.id where A.is_zhong > 0 order by A.time desc limit ".$page['limit'];
		$shangjia_lis = $db -> query($sql);
		 
		$i = 0;
		while($row = $db-> fetchrow($shangjia_lis))
		{	$shangjia_list[$i]['userid']=$row['userid'];
			$shangjia_list[$i]['title']=$row['title'];
			$shangjia_list[$i]['is_fangfa']=$row['is_fangfa'];
			$shangjia_list[$i]['is_zhong']=$row['is_zhong'];
			$shangjia_list[$i]['id']=$row['id'];
			$shangjia_list[$i]['time']=$row['time'];
			$shangjia_list[$i]['user_name']=$row['user_name'];
			$shangjia_list[$i]['zhizhen']=$row['zhizhen'];
			$i++;
		}
		//print_r($shangjia_list);
		
		$this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条 
 		$this->assign('shangjia_list', $shangjia_list);
        $this->display('dazhuanpan_log.html');
		 
    }
   
}

?>