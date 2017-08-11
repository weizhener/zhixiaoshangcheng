<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="particular">
        <div class="particular_wrap">
            <h2>订单详情</h2>
            <div class="mb10">
                <div class="state">订单状态&nbsp;:&nbsp;<strong><?php echo call_user_func("order_status",$this->_var['order']['status']); ?></strong></div>
                <div class="num">订单号&nbsp;:&nbsp;<?php echo $this->_var['order']['order_sn']; ?></div>
                <div class="time">下单时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['order_add_time']); ?></div>

            </div>
            <h3>订单信息</h3>
            <dl class="info">
                <dt>卖家信息</dt>
                <dd>店铺名&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['store_name']); ?></dd>
                <dd>电话号码&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['tel']) == '') ? '-' : htmlspecialchars($this->_var['order']['tel']); ?></dd>
                <dd>QQ&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['im_qq']) == '') ? '-' : htmlspecialchars($this->_var['order']['im_qq']); ?></dd>
                <dd>旺旺&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['im_ww']) == '') ? '-' : htmlspecialchars($this->_var['order']['im_ww']); ?></dd>
                <dd>所在地区&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['region_name']) == '') ? '-' : htmlspecialchars($this->_var['order']['region_name']); ?></dd>
                <dd>手机号码&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['phone_mob']) == '') ? '-' : htmlspecialchars($this->_var['order']['phone_mob']); ?></dd>
                <dd>MSN&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['im_msn']) == '') ? '-' : htmlspecialchars($this->_var['order']['im_msn']); ?></dd>
                <dd>详细地址&nbsp;:&nbsp;<?php echo (htmlspecialchars($this->_var['order']['address']) == '') ? '-' : htmlspecialchars($this->_var['order']['address']); ?></dd>
            </dl>
            <div class="ware_line">
                <div class="ware">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
                    <div class="ware_list">
                        <div class="ware_pic"><img src="<?php echo $this->_var['goods']['goods_image']; ?>" width="50" height="50"  /></div>
                        <div class="ware_text">
                            <div class="ware_text1">
                                <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>
                                <?php if ($this->_var['group_id']): ?><a target="_blank" href="<?php echo url('app=groupbuy&id=' . $this->_var['group_id']. ''); ?>"><strong class="color8">[团购]</strong></a><?php endif; ?>
                                <br />
                                <span><?php echo htmlspecialchars($this->_var['goods']['specification']); ?></span>
                            </div>
                            <div class="ware_text2">
                                <span>数量&nbsp;:&nbsp;<strong><?php echo $this->_var['goods']['quantity']; ?></strong></span>
                                <span>价格&nbsp;:&nbsp;<strong><?php echo price_format($this->_var['goods']['price']); ?></strong></span>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <div class="transportation">运费&nbsp;:&nbsp;<span><?php echo price_format($this->_var['order_extm']['shipping_fee']); ?><strong>(<?php echo htmlspecialchars($this->_var['order_extm']['shipping_name']); ?>)</strong></span>优惠打折&nbsp;:&nbsp;<span><?php echo price_format($this->_var['order']['discount']); ?></span>总价&nbsp;:&nbsp;<b><?php echo price_format($this->_var['order']['order_amount']); ?></b></div>
                    <ul class="order_detail_list">
                       <?php if ($this->_var['order']['payment_code']): ?>
                        <li>支付方式&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['payment_name']); ?><?php if ($this->_var['order']['status'] == ORDER_PENDING): ?>&nbsp;&nbsp;(&nbsp;<a href="<?php echo url('app=cashier&order_id=' . $this->_var['order']['order_id']. ''); ?>">付款</a>&nbsp;)<?php endif; ?></li>
                        <?php endif; ?>
                        <?php if ($this->_var['order']['pay_message']): ?>
                        <li>支付消息&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['pay_message']); ?></li>
                        <?php endif; ?>
                        <li>下单时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['order_add_time']); ?></li>
                        <?php if ($this->_var['order']['pay_time']): ?>
                        <li>支付时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['pay_time']); ?></li>
                        <?php endif; ?>
                        <?php if ($this->_var['order']['ship_time']): ?>
                        <li>发货时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['ship_time']); ?></li>
                        <?php endif; ?>
                        <?php if ($this->_var['order']['finished_time']): ?>
                        <li>完成时间&nbsp;:&nbsp;<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['finished_time']); ?></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>

            <h3>物流信息</h3>
            <div class="goods">
                收货地址&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['consignee']); ?><?php if ($this->_var['order_extm']['phone_mob']): ?>, &nbsp;<?php echo $this->_var['order_extm']['phone_mob']; ?><?php endif; ?><?php if ($this->_var['order_extm']['phone_tel']): ?>,&nbsp;<?php echo $this->_var['order_extm']['phone_tel']; ?><?php endif; ?>
                ,&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['region_name']); ?>&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['address']); ?>
                <?php if ($this->_var['order_extm']['zipcode']): ?>,&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['zipcode']); ?><?php endif; ?><br />
                配送方式&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order_extm']['shipping_name']); ?>
                <?php if ($this->_var['order']['invoice_no']): ?>
                <br />
                物流单号&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['invoice_no']); ?><!--&nbsp;&nbsp;&nbsp;&nbsp;<a href="<?php echo $this->_var['shipping_info']['query_url']; ?>&amp;<?php echo $this->_var['order']['invoice_no']; ?>" target="_blank">query_logistics</a>-->
                <?php endif; ?>
                <?php if ($this->_var['order']['postscript']): ?>
                <br />
                给卖家的附言&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['order']['postscript']); ?><br />
                <?php endif; ?>
            </div>

            <div class="particular_bottom"></div>
        </div>

        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>