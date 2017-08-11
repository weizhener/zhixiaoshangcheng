<?php

/* 店铺等级 sgrade */
class GradegoodsModel extends BaseModel
{
    var $table  = 'grade_goods';
    var $prikey = 'grade_id';
    var $_name  = 'gradegoods';
	//获取商品的各级会员折扣
	function get_grade_goods_info($goods_id){
		$ugrade_mod=&m('ugrade');
		$ugrades=$ugrade_mod->find(array('order'=>'grade_id ASC'));
		if($goods_id > 0){
			foreach($ugrades as $key=>$val){
				$each_grade_goods=$this->get(array('conditions'=>'grade_id='.$val['grade_id'].' AND goods_id='.$goods_id));
				$ugrades[$key]['grade_discount']=$each_grade_goods['grade_discount'];
			}
		}
		return $ugrades;
	}
	function get_post_grade_info($ugrade_id=array(),$grade=array(),$grade_discount=array())
	{
		$gradegoods=array();
		for($i=0;$i<count($ugrade_id);$i++){
		  if($grade_discount[$i])
		  {
			if($grade_discount[$i] > $grade_discount[$i-1] && $i > 0 )
			{
				header("Content-type:text/html;charset=" . CHARSET, true);
				echo "<script LANGUAGE='JavaScript'>confirm('低级别的会员折扣不能大于高级别会员折扣，返回重新操作？',history.go(-1));</script>";
				exit;
			}
			$gradegoods[$i]=array('grade_id'=>$ugrade_id[$i],'grade'=>$grade[$i],'grade_discount'=>(is_numeric($grade_discount[$i]) && ($grade_discount[$i] <= 1))?$grade_discount[$i]:1);
		  }
		}
		return array_filter($gradegoods);
	}
	function save_grade_info($id,$data)
	{
		if(!empty($data))
		{	
			foreach($data as $k=>$price)
			{	
				$if_exist=$this->get(array('conditions'=>'goods_id='.$id.' AND grade_id='.$price['grade_id']));
				if($if_exist)
				{
					$this->edit(' grade_id='.$price['grade_id'].' AND goods_id='.$id,'grade_discount='.$price['grade_discount']);
				}else{
					$price['goods_id']=$id;
					$this->add($price);	
				}
			}
		}	
	}
	//某一会员等级为空时，则取其前一级的折扣为其折扣
	function get_pre_discount($grade,$goods_id)
	{
		if($grade == 1)
		{
			return 1;
		}
		$info=$this->getAll("SELECT min(grade_discount) as max_discount FROM {$this->table} gradegoods WHERE goods_id=".$goods_id." AND grade < ".$grade." AND grade_discount >= 0 ");
		$result=$info[0]['max_discount']?$info[0]['max_discount']:1;
		return $result;
	}
	function get_user_discount($user_id,$goods_id){
		if(!$user_id)
		{
			return ;	
		}
		$grade_discount=array();
		$member_mod=&m('member');
		$ugrade_mod=&m('ugrade');
		$member=$member_mod->get($user_id);
		$ugrade=$ugrade_mod->get(array('conditions'=>'grade='.$member['ugrade']));
		$grade_discount=$this->get(array('conditions'=>'goods_id='.$goods_id.' AND grade_id='.$ugrade['grade_id']));
		if(!$grade_discount['grade_discount'])
		{	
			$grade_discount['grade_discount']=$this->get_pre_discount($member['ugrade'],$goods_id);	
		}
		return $grade_discount['grade_discount'];
	}
}
?>