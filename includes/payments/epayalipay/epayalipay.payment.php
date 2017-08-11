<?php
class epayalipayPayment extends BasePayment {

    var $_code = 'epayalipay';
    
    var $_gateway = 'index.php?app=epay&act=czfs';
    
    function get_payform($order_info) {
        
        $params = array(
            'cz_money'=>$order_info['order_amount'],
            'czfs'=>'alipay',
            'order_sn'=>$order_info['order_sn'],
        );
        if(ECMALL_WAP ==1){
            $params['czfs'] = 'wapalipay';
        }
        
        return $this->_create_payform('POST', $params);
    }

}






/**
 *    支付宝免签支付方式 
 *
 *    @author    Garbin
 *    @usage    none
 */

/*
class epayalipayPayment extends BasePayment {

    var $_code = 'epayalipay';
    var $_gateway = 'index.php?app=epay&act=czfs';
    
    function get_payform($order_info) {

        ?>
        <body onLoad="javascript:document.E_FORM.submit()">
            <form name="E_FORM" action="index.php?app=epay&act=czfs" method="post">  
                <input type="hidden" name="cz_money" value="<?php echo $order_info['order_amount']; ?>">  
                <input type="hidden" name="czfs" value="alipay">  
                <input type="hidden" name="order_sn" value="<?php echo $order_info['order_sn'];?>">  
            </form>  
        </body>
        <?php
        exit;
        
        $params = array(
            'cz_money'=>$order_info['order_amount'],
            'czfs'=>'alipay',
            'order_sn'=>$order_info['order_sn'],
        );
        
        
        return $this->_create_payform('get', $params);
    }

}

*/













?>
