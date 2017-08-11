<?php echo $this->fetch('header.html'); ?>

<?php echo $this->fetch('curlocal.html'); ?>

<link href="<?php echo $this->res_base . "/" . 'css/epay.css'; ?>" rel="stylesheet" type="text/css" />

<style type="text/css">

    .content {width: 1200px; margin: 10px auto 0;}

    .module_common {padding: 5px; border: 4px solid #f8dbc6; overflow: hidden; margin-bottom: 10px; clear: both;}

    .defrays {margin-bottom: 20px; overflow:hidden;}

    /* 灰色线下支付 css类 */

    .defrays dt {height:65px; line-height:65px; background: #f5f5f5; padding-left: 20px; font-weight: bold; color: #333; font-size:14px;}

    .defrays dd {overflow: hidden; padding: 10px;}

    .defrays dd .radio {float: left; width: 40px; text-align: center; padding-top: 14px;}

    .defrays dd .logo {float: left; width: 140px;}

    .defrays dd .explain {float: left; line-height: 20px; color: #787878;}

    .defrays dd .dongtai {float: left; width: 677px; line-height: 40px;}

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

            <div class="order_info border mt20 clearfix">

                <div class="ico">

                </div>

                <div class="text">

                    <div class="clue_on"><h4>确认支付，输入支付密码</h4></div>

                    <p class="fs14 strong">订单总价 <span class="f60"><?php echo price_format($this->_var['order']['order_amount']); ?></span></p>
                    
                    <p>* 需要现金：<?php echo price_format($this->_var['order']['lost_money']); ?>，需要积分：<?php echo price_format($this->_var['order']['use_integral']); ?></p>

                    <p>* <a href="<?php echo url('app=buyer_order'); ?>" target="_blank">您可以在用户中心中的我的订单查看该订单</a></p>

                </div>

            </div>

        </div>

        <form action="index.php?app=epay&act=payment&payment_id=<?php echo $this->_var['payment_id']; ?>&order_id=<?php echo $this->_var['order']['order_id']; ?>" method="POST" id="zft_pay">

            <div class="border padding10 mt10">

                <dl class="defrays">

                    <dt>
                    <?php if ($this->_var['payment_id'] == 10): ?>

                    购物积分余额<strong style=" color:#FF4D0F;padding-right: 20px;"> <?php echo $this->_var['money']['moneyjf']; ?> </strong>
                    
                    <?php else: ?>
                    
                    帐户余额：<strong style=" color:#FF4D0F;padding-right: 20px;"> <?php echo $this->_var['money']['money']; ?> </strong>

                    <?php endif; ?>
               <!-- 
                    <span class="epay_btn" style="margin-top:10px;"><a href="<?php echo url('app=epay&act=czlist'); ?>">充值</a></span>

                    <span class="epay_btn epay_btn_white" style="margin-top:10px;"><a href="<?php echo url('app=epay&act=withdraw'); ?>">提现</a></span>
               -->
                    </dt>



                    <dd style="padding:50px;">

                        支付密码：<input name="zf_pass" type="password" id="zf_pass" class="text width5">

                        <input name="post_money" type="hidden" value="<?php echo $this->_var['order']['order_amount']; ?>" />

                    </dd>

                    <dd>

                        <div class="make_sure">

                            <p>

                                <a href="javascript:$('#zft_pay').submit();" class="btn btn-step">确认付款</a>

                            </p>

                        </div>

                    </dd>

                </dl>

            </div>

        </form>













    </div>

</div>



<?php echo $this->fetch('footer.html'); ?>