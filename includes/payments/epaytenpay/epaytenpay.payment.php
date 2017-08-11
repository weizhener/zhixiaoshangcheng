<?php

class epaytenpayPayment extends BasePayment {

    var $_code = 'epaytenpay';
    var $_gateway = 'index.php?app=epay&act=czfs';
    
    function get_payform($order_info) {
        
        $params = array(
            'cz_money'=>$order_info['order_amount'],
            'czfs'=>'tenpay',
            'order_sn'=>$order_info['order_sn'],
        );
        return $this->_create_payform('POST', $params);
    }

}

















?>
