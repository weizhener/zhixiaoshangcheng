<?php

/* 积分记录  */
class integral_logModel extends BaseModel
{
    var $table  = 'integral_log';
    var $prikey = 'integral_id';
    var $_name  = 'integral_log';
    var $_relation = array(
        // 一个积分记录只能属于一个用户
        'belongs_to_member' => array(
            'model'         => 'member',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'user_id',
            'reverse'       => 'has_integral_log',
        ),
    );

}

?>