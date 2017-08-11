<?php

class CouponsnModel extends BaseModel
{
    var $table  = 'coupon_sn';
    var $prikey = 'coupon_sn';
    var $_name  = 'couponsn';
    var $_relation  = array(
        // 一个优惠券编号只能属于一种优惠券
        'belongs_to_coupon' => array(
            'model'         => 'coupon',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'coupon_id',
            'reverse'       => 'has_couponsn',
        ),
    );
}

?>
