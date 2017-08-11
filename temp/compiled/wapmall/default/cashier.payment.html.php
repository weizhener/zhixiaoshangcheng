<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">订单提交</div>
    <a href="javascript" class="r_b"></a>
</div>
    <style>
        .pay_con{margin:10px; overflow:hidden; text-align:center;text-align:left; background: #fff;}
        .pay_con .succeed{margin-bottom:10px;  overflow:hidden;padding:0 10px;}
        .pay_con .succeed img{float:left; width:110px; margin-right:10px;}
        .pay_con .succeed  h4{margin:25px 0 5px 0; font-size:18px; font-weight:normal;}
        .pay_con .order_info{clear: both;margin: 5px; padding: 10px;}
        .pay_con .order_info p{font-size:14px; font-weight:bold; margin:5px 0;}
        .pay_con .order_info span{color:#b20005;}
        .pay_con .buy .pay_way p{float:left; vertical-align:middle; height:50px; line-height:50px;}
        .pay_con .buy .pay_way p .radio{margin-top:18px;}
        .pay_con .buy .pay_way dt{background:#eee;padding:6px 10px; font-size:16px; margin:5px 0; border-left:#b20005 solid 5px; font-weight:bold; color:#444;}
        .pay_con .buy .pay_way dd{padding:6px 10px;margin:5px 0; border-bottom:#ddd dashed 1px; overflow:hidden;}
        .pay_con .buy .pay_way dd:last-child{border:none;}
    </style>  
        <form action="index.php?app=cashier&act=goto_pay&order_id=<?php echo $this->_var['order']['order_id']; ?>" method="POST" id="goto_pay">
            
            <div class="pay_con">
                <div class="succeed">
                    <img src="<?php echo $this->res_base . "/" . 'images/clue_on.gif'; ?>"/>
                    <h4>订单提交成功！</h4>
                    <p>您的订单已成功生成，选择您想用的支付方式进行支付</p>
                </div>
                <div class="order_info">
                    <p>订单号：<span><?php echo $this->_var['order']['order_sn']; ?></span></p>
                    <p>订单总价：<span><?php echo price_format($this->_var['order']['order_amount']); ?></span></p>
                </div>
                <div class="buy">
                    <dl class="pay_way">
                        <dt>余额支付&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>帐户余额：<span style=" color:#FF4D0F"> <?php echo $this->_var['money']['money']; ?>&nbsp;</span>元</b></dt>
                        <dd>
                            <p><input id="payment_epay" type="radio" name="payment_id" checked="checked" value="0" class="radio"/></p>
                            <p><label for="payment_epay"><img src="<?php echo $this->res_base . "/" . 'images_bk/yuerzhifu.gif'; ?>"/></label></p>
                            <p>（使用余额支付）</p>
                        </dd>
                    </dl>
                    <dl class="pay_way">
                        <dt>选择支付方式并付款</dt>
                        <?php if ($this->_var['payments']['online']): ?>
                        <?php $_from = $this->_var['payments']['online']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['payment']):
?>
                        <dd>
                            <p>
                                <label for="payment_alipay"><input type="radio" name="payment_id" value="<?php echo $this->_var['payment']['payment_id']; ?>"  id="payment_<?php echo $this->_var['payment']['payment_code']; ?>" class="radio" />
                                <img src="<?php echo $this->_var['site_url']; ?>/includes/payments/<?php echo $this->_var['payment']['payment_code']; ?>/logo.gif"/></label>
                            </p>
                            <p>（在线支付）</p>
                        </dd>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php endif; ?>
                        <?php if ($this->_var['payments']['offline']): ?>

                        <?php $_from = $this->_var['payments']['offline']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>
                        <dd>
                            
                            <p>
                                <label for="payment_alipay">
                                    <input type="radio" name="payment_id" value="<?php echo $this->_var['payment']['payment_id']; ?>"  id="payment_<?php echo $this->_var['payment']['payment_code']; ?>" class="radio"/>
                                    <img src="<?php echo $this->_var['site_url']; ?>/includes/payments/<?php echo $this->_var['payment']['payment_code']; ?>/logo.gif"/>
                                </label>
                            </p>
                            <p>（线下支付）</p>
                        </dd>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                        <?php endif; ?>

                    </dl>                
                </div>
                <a class="red_btn" href="javascript:$('#goto_pay').submit();">确认支付</a><!--<a class="white_btn" href="#">查看订单</a>-->
            </div>
        </form>
    <?php echo $this->fetch('member.footer.html'); ?>