<?php

/* 店铺等级 sgrade */
class UgradeModel extends BaseModel
{
    var $table  = 'ugrade';
    var $prikey = 'grade_id';
    var $_name  = 'ugrade';
	/*
     * 判断名称是否唯一
     */
    function unique($field,$value, $grade_id = 0)
    {
        $conditions = " ".$field." = '" . $value . "'";
        $grade_id && $conditions .= " AND grade_id <> '" . $grade_id . "'";
        return count($this->find(array('conditions' => $conditions))) == 0;
    }
	function get_option($fields='grade')
	{
		$ugrades=$this->find(array('order'=>'grade_id ASC'));
		$data=array();
		if($ugrades){
			foreach($ugrades as $key => $val){	
				$data[$val['grade_id']]=$val[$fields]; 
			}
		}
		return $data;
	}
	function get_arange_growth($grade,$growth_needed)
	{
		if(!$grade)
		{
			return;
		}
		$last_grade=$this->get(array('conditions'=>'grade='.$grade-1));
		$data=$growth_needed+$last_grade['floor_growth'];
		return $data;
	}
}
?>