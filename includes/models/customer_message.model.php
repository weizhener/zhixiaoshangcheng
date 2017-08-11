<?php

class Customer_messageModel extends BaseModel {

    var $table = 'customer_message';
    var $prikey = 'customer_message_id';
    var $_name = 'customer_message';

    var $_relation  = array(
        'belongs_to_store' => array(
            'model'             => 'store',
            'type'              => BELONGS_TO,
            'foreign_key'       => 'store_id',
            'reverse'           => 'has_customer_message',
        ),
        'belongs_to_goods' => array(
            'model'             => 'goods',
            'type'              => BELONGS_TO,
            'foreign_key'       => 'goods_id',
            'reverse'           => 'has_customer_message',
        ),
    );
    
    
}

?>
