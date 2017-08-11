<?php echo $this->fetch('header.html'); ?>

<style type="text/css">

    .mall-nav{display:none}

</style>

<div id="main" class="w-full">

    <div id="page-cashier" class="w">

        <div class="step step3 mt10 clearfix">

            <span class="fs14 strong f60">1.查看购物车</span>

            <span class="fs14 strong f60">2.确认订单信息</span>

            <span class="fs14 strong fff">3.付款</span>

            <span class="fs14 strong">4.确认收货</span>

            <span class="fs14 strong">5.评价</span>

        </div>

        <div class="order-form cashier clearfix">

            <form action="index.php?app=cashier&act=goto_pay&order_id=<?php echo $this->_var['order']['order_id']; ?>" method="POST" id="goto_pay">

                <div class="order_info border mt20 clearfix">

                    <div class="ico">

                    </div>

                    <div class="text">

                        <p class="fs14 strong">订单提交成功！ 订单总价 <span class="f60"><?php echo price_format($this->_var['order']['order_amount']); ?></span></p>
                        
                        <p>* 需要现金：<?php echo price_format($this->_var['order']['lost_money']); ?>，需要积分：<?php echo price_format($this->_var['order']['use_integral']); ?></p>

                        <p>* 您的订单已成功生成，选择您想用的支付方式进行支付订单号<?php echo $this->_var['order']['order_sn']; ?></p>

                        <p>* <a href="<?php echo url('app=buyer_order'); ?>" target="_blank">您可以在用户中心中的我的订单查看该订单</a></p>

                    </div>

                </div>

                <div class="buy border padding10 mt10">

                    <h3><b class="ico">选择支付方式并付款</b></h3>

                    <dl class="defray">

                        <dt><input id="payment_epay" type="radio" name="payment_id" checked="checked" value="0" style="vertical-align:middle; margin-bottom:5px;" />使用余额支付&nbsp;&nbsp;<b>帐户余额：<span style=" color:#FF4D0F"> <?php echo $this->_var['money']['money']; ?>&nbsp;</span>元</b></dt>

                    </dl>
                    


                    <?php if ($this->_var['payments']['online']): ?>

                    <dl class="defray">

                        <dt>在线支付</dt>

                        <?php $_from = $this->_var['payments']['online']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>

                        <dd class="mb10 clearfix">

                            <p class="radio float-left"><input id="payment_<?php echo $this->_var['payment']['payment_code']; ?>" type="radio" name="payment_id" value="<?php echo $this->_var['payment']['payment_id']; ?>" /></p>

                            <p class="logo float-left"><label for="payment_<?php echo $this->_var['payment']['payment_code']; ?>"><img src="<?php echo $this->_var['site_url']; ?>/includes/payments/<?php echo $this->_var['payment']['payment_code']; ?>/logo.gif" alt="<?php echo htmlspecialchars($this->_var['payment']['payment_name']); ?>-<?php echo htmlspecialchars($this->_var['payment']['payment_desc']); ?>" title="<?php echo htmlspecialchars($this->_var['payment']['payment_name']); ?>-<?php echo htmlspecialchars($this->_var['payment']['payment_desc']); ?>" width="125" height="47" /></label></p>

                            <p class="explain float-left"><?php echo htmlspecialchars($this->_var['payment']['payment_desc']); ?></p>

                        </dd>

                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                    </dl>

                    <?php endif; ?>

                    <?php if ($this->_var['payments']['offline']): ?>

                    <dl class="defray">

                        <dt>线下支付</dt>

                        <?php $_from = $this->_var['payments']['offline']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'payment');if (count($_from)):
    foreach ($_from AS $this->_var['payment']):
?>

                        <dd class="mb10 clearfix">

                            <p class="radio float-left"><input type="radio" id="payment_<?php echo $this->_var['payment']['payment_code']; ?>" name="payment_id" value="<?php echo $this->_var['payment']['payment_id']; ?>" /></p>

                            <p class="logo float-left"><label for="payment_<?php echo $this->_var['payment']['payment_code']; ?>"><img alt="<?php echo htmlspecialchars($this->_var['payment']['payment_name']); ?>-<?php echo htmlspecialchars($this->_var['payment']['payment_desc']); ?>" title="<?php echo htmlspecialchars($this->_var['payment']['payment_name']); ?>-<?php echo htmlspecialchars($this->_var['payment']['payment_desc']); ?>" src="<?php echo $this->_var['site_url']; ?>/includes/payments/<?php echo $this->_var['payment']['payment_code']; ?>/logo.gif" width="125" height="47" align="absmiddle"/></label></p>

                            <p class="explain float-left"><?php echo htmlspecialchars($this->_var['payment']['payment_desc']); ?></p>

                        </dd>

                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                    </dl>

                    <?php endif; ?>



                </div>

                <div class="make_sure mt10 mb20">

                    <p>

                        <a href="javascript:$('#goto_pay').submit();" class="btn-step fff strong fs14">确认支付</a>

                    </p>

                </div>

            </form>

        </div>

    </div>

</div>

<?php echo $this->fetch('server.html'); ?>

<?php echo $this->fetch('footer.html'); ?>