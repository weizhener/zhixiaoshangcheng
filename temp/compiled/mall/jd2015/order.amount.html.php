<?php if ($this->_var['goods_info']['integral_enabled']): ?>

<script type="text/javascript">

    $(function () {

        $('#use_integral_button').click(function () {

            $(this).parent('p').next().toggle();

        });

    });

</script>

<div class="w price-promotion mt10 mb10 f60">

    <p class="mb10 mt10">

        <input id="use_integral_button" type="button" class="btn-allow-coupon center" value="使用积分" />

    </p>

    <p class="allow-coupon border padding10 mb10 hidden clearfix">

        <span class="note">
            &nbsp;可用积分<em style="font-weight:bold;color:red;padding: 0 5px;"><?php echo $this->_var['member_integral']; ?></em>,

            本单最多可用积分<em style="font-weight:bold;color:red;padding: 0 5px;"><?php echo $this->_var['total_integral_max_exchange']; ?></em>
        </span>

        <input type="text" name="use_integral" id="use_integral" onkeyup="set_order_amount_total();" class="text" />

    </p>

</div>

<?php endif; ?>

<script type="text/javascript">

    $(function () {

        $('#use_coupon').click(function () {

            $(this).parent('p').next().toggle();

            //$(this).hide();



            if ($(this).val() == '使用优惠券') {

                $(this).val('不使用优惠券');

                $("select[name='coupon_sn']")[0].selectedIndex = 0;

            } else {

                $(this).val('使用优惠券')

            }

        });

    });

</script>


<div class="make_sure w mb10">

    <p>

        <a href="<?php echo url('app=cart&store_id=' . $this->_var['goods_info']['store_id']. ''); ?>" class="back">返回购物车</a>

        <span class="ml20">订单总价：</span>

        <strong  id="order_amount"><?php echo price_format($this->_var['goods_info']['amount']); ?></strong>

        <a href="javascript:void($('#order_form').submit());" class="btn-step fff center strong fs14 ml20">下单完成并支付</a>

    </p>

</div>

<div class="w price-notice mt10 mb10 pt10 f60 pb10">若有价格变动（包括运费），请在点击确认订单后，联系卖家修改。卖家修改后，您可以至订单管理中查看、完成支付。</div>