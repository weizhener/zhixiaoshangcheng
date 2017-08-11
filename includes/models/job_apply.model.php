<?php
class Job_applyModel extends BaseModel
{
    var $table  = 'job_apply';
    var $prikey = 'id';
    var $_name  = 'job_apply';
    
    
    
    var $_relation = array(
        // 一个申请只能属于一个职位
        'belongs_to_job' => array(
            'model'             => 'job',
            'type'              => BELONGS_TO,
            'foreign_key'       => 'job_id',
            'reverse'           => 'has_job_apply',
        ),
    );
    
    
    
}
?>