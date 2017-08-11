<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">提交订单</div>
    <a href="javascript" class="r_b"></a>
</div>

<form method="post" id="order_form">
    <?php echo $this->fetch('order.shipping.html'); ?>
    <script type="text/javascript">
        function postscript_activation(tt) {
            if (!tt.name)
            {
                tt.value = '';
                tt.name = 'postscript';
            }

        }
    </script>
    <div class="orderlist">
        <ul>
            <li>给卖家的附言</li>
            <li>  <textarea  class="com_text" id="postscript" placeholder="附注：选填，可以告诉卖家您对商品的特殊需求，如颜色、尺码等" onclick="postscript_activation(this);"></textarea></li>
        </ul>
    </div>

    <div class="orderlist">
        <ul>
            <li>店铺：<a href="<?php echo url('app=store&id=' . $this->_var['goods_info']['store_id']. ''); ?>" ><?php echo htmlspecialchars($this->_var['goods_info']['store_name']); ?></a></li>
            <?php $_from = $this->_var['goods_info']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
            <li>
                <a  href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>">	<img src="<?php echo $this->_var['goods']['goods_image']; ?>" /></a>
                <p>  <a  href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                <p>单价：<?php echo price_format($this->_var['goods']['price']); ?></p>
                <p>数量：<?php echo $this->_var['goods']['quantity']; ?>件<strong><?php echo price_format($this->_var['goods']['subtotal']); ?></strong></p>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <span style="margin-left:10px;"> 配送方式：</span>

            <?php if ($this->_var['is_free_fee']): ?>
            <ul class="shipping_item">
                <li>
                    <input type="radio" name="is_free_fee" checked="checked" value="1" />
                    <?php echo htmlspecialchars($this->_var['shipping_method']['shipping_name']); ?>
                    <input type="hidden" name="is_free_fee" value="1" />
                    配送费用：<span class="money" ectype="shipping_fee">&yen; 0.00</span>(<?php echo htmlspecialchars($this->_var['free_fee_name']); ?>)
                </li>
            </ul>
            <?php else: ?> 
                            <?php $_from = $this->_var['shipping_methods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'logist');$this->_foreach['fe_logist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_logist']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['logist']):
        $this->_foreach['fe_logist']['iteration']++;
?>
                            <li shipping_id="<?php echo $this->_var['shipping_method']['shipping_id']; ?>">
                                <input type="radio" name="logist_fees" value="<?php echo $this->_var['key']; ?>:<?php echo $this->_var['logist']['logist_fees']; ?>"  <?php if (($this->_foreach['fe_logist']['iteration'] <= 1)): ?> checked="checked"<?php endif; ?> />
                                <?php echo htmlspecialchars($this->_var['logist']['shipping_name']); ?>
                                配送费用:&nbsp;<span class="money" ectype="shipping_fee">&yen;<?php echo $this->_var['lang'][$this->_var['key']]; ?>：<?php echo price_format($this->_var['logist']['logist_fees']); ?></span>                                                                                                首件：<?php echo price_format($this->_var['logist']['start_fees']); ?>/<?php echo $this->_var['logist']['start_standards']; ?>件, 续件：<?php echo price_format($this->_var['logist']['add_fees']); ?>/<?php echo $this->_var['logist']['add_standards']; ?>件
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>                                                                                
            <?php endif; ?>
            
            <?php if ($this->_var['goods_info']['integral_enabled']): ?>
            <li>当前用户可用积分<em style="font-weight:bold;color:red;padding: 0 5px;"><?php echo $this->_var['member_integral']; ?></em>,</li>
            <li>本次订单最多可使用积分<em style="font-weight:bold;color:red;padding: 0 5px;"><?php echo $this->_var['total_integral_max_exchange']; ?></em></li>
            <li>积分比例为<em style="font-weight:bold;color:red;padding: 0 5px;"><?php echo ($this->_var['integral_seller'] == '') ? '0' : $this->_var['integral_seller']; ?></em></li>
            <li>使用积分：<input type="text" name="use_integral" id="use_integral" onkeyup="set_order_amount_total();" class="text" /></li>
            <?php endif; ?>
            <li>
                <?php if ($this->_var['goods_info']['allow_coupon']): ?>
                <select name="coupon_sn">
                    <option value="">选择您可用的优惠券</option>
                    <?php $_from = $this->_var['coupon_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');if (count($_from)):
    foreach ($_from AS $this->_var['coupon']):
?>
                    <option value="<?php echo $this->_var['coupon']['coupon_sn']; ?>">SN:<?php echo $this->_var['coupon']['coupon_sn']; ?>(<?php echo price_format($this->_var['coupon']['coupon_value']); ?>)</option>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </select>
                <?php endif; ?>
            </li>
            <li>合计：<strong id="order_amount2"><?php echo price_format($this->_var['goods_info']['amount']); ?></strong></li>
        </ul>

    </div>
    <p class="total_price">实付款：<strong id="order_amount"><?php echo price_format($this->_var['goods_info']['amount']); ?></strong></p>
    <a href="javascript:void($('#order_form').submit());" class="red_btn">提交订单</a>
</form >
<?php echo $this->fetch('member.footer.html'); ?>