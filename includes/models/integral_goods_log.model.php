<?php

/**
 * 积分产品兑换记录
 */
class Integral_goods_logModel extends BaseModel {

    var $table = 'integral_goods_log';
    var $prikey = 'id';
    var $_name = 'integral_goods_log';
    
    
    var $_relation = array(
        // 一个订单日志只能属于一个订单
        'belongs_to_integral_goods' => array(
            'model' => 'integral_goods',
            'type' => BELONGS_TO,
            'foreign_key' => 'goods_id',
            'reverse' => 'has_integral_goods_log',
        ),
    );

}
