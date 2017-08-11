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
<form action="index.php?app=epay&act=payment&order_id=<?php echo $this->_var['order']['order_id']; ?>" method="POST" id="zft_pay">
    
    <div class="pay_con">
        <div class="order_info">
            <p>订单号：<span><?php echo $this->_var['order']['order_sn']; ?></span></p>
            <p>订单总价：<span><?php echo price_format($this->_var['order']['order_amount']); ?></span></p>
            <input name="post_money" type="hidden" value="<?php echo $this->_var['order']['order_amount']; ?>" />
            <p><a href="<?php echo url('app=buyer_order'); ?>" >您可以在用户中心中的我的订单查看该订单</a></p>
        </div>
        <div class="buy">
            <dl class="pay_way">
                <dt><b>帐户余额：<span style=" color:#FF4D0F"> <?php echo $this->_var['money']['money']; ?> </span></b></dt>
                <dd>
                    <p>支付密码：</p>
                    <p><input name="zf_pass" type="password" id="zf_pass" class="text width5"/></p>
                </dd>
            </dl>
        </div>
        <a class="red_btn" href="javascript:$('#zft_pay').submit();">确认支付</a><!--<a class="white_btn" href="#">查看订单</a>-->
    </div>
</form>

<?php echo $this->fetch('member.footer.html'); ?>