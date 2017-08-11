<?php

class Epay {

    var $_epay_mod;
    var $_epaylog_mod;

    function __construct() {
        $this->_epay_mod = & m('epay');
        $this->_epaylog_mod = & m('epaylog');
    }
    
    /**
     * 扣除佣金
     */
    function trade_charges($order_info) {
        //未开启
        if (!Conf::get('epay_trade_charges_ratio')) {
            return;
        }
        $epay_trade_charges_ratio = Conf::get('epay_trade_charges_ratio');
        //当前佣金
        $epay_trade_charges = round($order_info['goods_amount'] * $epay_trade_charges_ratio, 2);
        if (empty($epay_trade_charges)) {
            return;
        }

        $order_sn = EPAY_TRADE_CHARGES . date('YmdHis',gmtime()+8*3600).rand(1000,9999);
        //卖家当前信息
           $seller_epay = $this->_epay_mod->get('user_id='.$order_info['seller_id']);


        $add_epaylog = array(
            'user_id' => $seller_epay['user_id'],
            'user_name' => $seller_epay['user_name'],
            'order_sn' => $order_sn,
            'add_time' => gmtime(),
            'type' => EPAY_TRADE_CHARGES, 
            'money_flow' => 'outlay',//转出	
            'money' => $epay_trade_charges,
            'complete' => 1,
            'log_text' => "扣除交易佣金-你有一笔订单交易成功,扣除佣金".$epay_trade_charges.",订单号为:".$order_info['order_sn']."商品金额为：".$order_info['goods_amount'].",佣金比例为".$epay_trade_charges_ratio,
            'states' => EPAY_TRADE_CHARGES,
        );
        $this->_epaylog_mod->add($add_epaylog);
        
        $new_seller_epay = array(
            'money' => $seller_epay['money'] - $epay_trade_charges,
        );
        $this->_epay_mod->edit('user_id=' . $order_info['seller_id'], $new_seller_epay);
    }

}

?>
