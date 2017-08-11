<?php

/*分类控制器*/
class GetuserinfoApp extends MallbaseApp
{
	/* 商品分类 */
    function index()
    {
		 
          $member_mod = &m('member');
		  $userid = $this->visitor->get("user_id");
          $member = $member_mod->get($userid);
		  
		  echo ecm_json_encode($member);
		  exit;
		 
	
		
    }
 
  
		 
		
}

?>