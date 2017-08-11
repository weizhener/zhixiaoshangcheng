<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
    .mall-nav{display:none}
</style>
<div id="main" class="w-full">
    <div id="page-order" class="w">
        <div class="step step2 mt10 clearfix">
            <span class="fs14 strong f60">1.查看购物车</span>
            <span class="fs14 strong fff">2.确认订单信息</span>
            <span class="fs14 strong">3.付款</span>
            <span class="fs14 strong">4.确认收货</span>
            <span class="fs14 strong">5.评价</span>
        </div>
        <div class="order-form">
            <form method="post" id="order_form">
                <?php echo $this->fetch('order.shipping.html'); ?>
                <?php echo $this->fetch('order.goods.html'); ?>
                <?php echo $this->fetch('order.postscript.html'); ?>
                <?php echo $this->fetch('order.amount.html'); ?>
            </form>
        </div>
    </div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>