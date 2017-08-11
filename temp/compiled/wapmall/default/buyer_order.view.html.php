<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">订单详情</div>
    <a href="javascript" class="r_b"></a>
</div>



<body style="background:#eceded">
    <div class="w320">
        <div class="goods_info">
            <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
            <div class="goods">
                <img src="<?php echo $this->_var['goods']['goods_image']; ?>" />
                <p class="title"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p>
                <p><?php echo htmlspecialchars($this->_var['goods']['specification']); ?></p>
                <p>价格：<strong><?php echo price_format($this->_var['goods']['price']); ?></strong>数量：<?php echo $this->_var['goods']['quantity']; ?></p>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <p class="pay">
                <!-- <a href="<?php echo url('app=cashier&order_id=' . $this->_var['order']['order_id']. ''); ?>" class="white_btn">现在付款</a>
                   <a href="#" class="white_btn cancel">取消订单</a>-->
            </p>
        </div>
        <div class="goods_line"></div>

        <ul class="orderlist orderinfo">
            <li><b>订单状态</b><span><?php echo call_user_func("order_status",$this->_var['order']['status']); ?></span></li>
            <li><b>订单号</b><span><?php echo $this->_var['order']['order_sn']; ?></span></li>
            <?php if ($this->_var['order']['payment_code']): ?>
            <li><b>支付方式</b><span><?php echo htmlspecialchars($this->_var['order']['payment_name']); ?></span></li>
            <?php endif; ?>
            <?php if ($this->_var['order']['pay_message']): ?>
            <li><b>支付消息</b><span><?php echo htmlspecialchars($this->_var['order']['pay_message']); ?></span></li>
            <?php endif; ?>

            <li><b>订单时间</b><span><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['order_add_time']); ?></span></li>
            <?php if ($this->_var['order']['pay_time']): ?>
            <li><b>支付时间</b><span><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['pay_time']); ?></span></li>
            <?php endif; ?>
            <?php if ($this->_var['order']['ship_time']): ?>
            <li><b>发货时间</b><span><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['ship_time']); ?></span></li>
            <?php endif; ?>
            <?php if ($this->_var['order']['finished_time']): ?>
            <li><b>完成时间</b><span><?php echo local_date("Y-m-d H:i:s",$this->_var['order']['finished_time']); ?></span></li>
            <?php endif; ?>
        </ul>
        <ul class="orderlist orderinfo">
            <li><b>卖家ID</b><span><?php echo htmlspecialchars($this->_var['order']['store_name']); ?></span></li>
            <li><b>联系电话</b><span><?php echo (htmlspecialchars($this->_var['order']['tel']) == '') ? '-' : htmlspecialchars($this->_var['order']['tel']); ?></span></li>
        </ul>
        <ul class="orderlist orderinfo">
            <li><b>收货地址</b><span><?php echo htmlspecialchars($this->_var['order_extm']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['address']); ?></span></li>
            <li><b>收货人</b><span><?php echo htmlspecialchars($this->_var['order_extm']['consignee']); ?></span></li>
            <?php if ($this->_var['order_extm']['phone_mob']): ?>   <li><b>手机号码</b><span><?php echo $this->_var['order_extm']['phone_mob']; ?></span></li><?php endif; ?>
            <?php if ($this->_var['order_extm']['phone_tel']): ?>  <li><b>电话号码</b><span><?php echo $this->_var['order_extm']['phone_tel']; ?></span></li><?php endif; ?>
            <?php if ($this->_var['order_extm']['zipcode']): ?>  <li><b>邮编</b><span><?php echo htmlspecialchars($this->_var['order_extm']['zipcode']); ?></span></li><?php endif; ?>
            <?php if ($this->_var['order']['postscript']): ?><li ><b style="width:87px">给卖家的附言</b><span><?php echo htmlspecialchars($this->_var['order']['postscript']); ?></span></li> <?php endif; ?>
            <?php if ($this->_var['order']['invoice_no']): ?>
            <li > <b> 物流单号</b><span><?php echo htmlspecialchars($this->_var['order']['invoice_no']); ?></span></li>
            <?php endif; ?>
        </ul>

        <ul class="orderlist orderinfo" id='shipping_detail'>

        </ul>
        <p class="total_price">
            物流（<?php echo htmlspecialchars($this->_var['order_extm']['shipping_name']); ?>）：<strong><?php echo price_format($this->_var['order_extm']['shipping_fee']); ?></strong><br />
            总价：<strong><?php echo price_format($this->_var['order']['order_amount']); ?></strong>
        </p>
        
    </div>

    
<?php echo $this->fetch('member.footer.html'); ?>
