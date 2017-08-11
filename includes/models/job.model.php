<?php
class JobModel extends BaseModel
{
    var $table  = 'job';
    var $prikey = 'job_id';
    var $_name  = 'job';
    
    var $_relation = array(
        // 一个职位有多个申请
        'has_job_apply' => array(
            'model'         => 'job_apply',
            'type'          => HAS_MANY,
            'foreign_key' => 'job_id',
            'dependent' => true
        ),
    );
}
?>