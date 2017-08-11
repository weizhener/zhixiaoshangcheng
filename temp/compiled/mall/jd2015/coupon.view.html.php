<?php echo $this->fetch('header.html'); ?>


<style>
    #coupon{margin: 10px auto}
    .coupon_view{border: #ccc solid 1px;margin:10px 0;padding:30px 160px;}
    .coupon_view h3{font-size: 16px;font-weight: bolder;color: #666;line-height: 26px;text-align: center;margin:10px 0;}
    .coupon_view .coupon_info{text-align: center;color: #888;}
    .coupon_view .scan_code{text-align: center;}
    .coupon_view .cut_line{border-bottom:1px dotted #888;margin: 10px 0px;}
    .coupon_view .youhui_sfun {padding: 0px;text-align: center;}
    .coupon_view .input_shopcart {background: url("<?php echo $this->res_base . "/" . 'images/btn_shopcart.gif'; ?>") no-repeat scroll 0 0 transparent;border: 0 none;color: #FFFFFF;font-size: 20px;height: 39px;text-align: center;text-indent: 10px;width: 168px;cursor: pointer;display:inline-block; line-height:39px;}
    .coupon_view .coupon_bg{text-align: center;}
</style>
<script>
    function add_coupon(coupon_id) {

<?php if (! $this->_var['visitor']['user_id']): ?>
        alert('请先登录');
        return;
<?php endif; ?>


        var url = SITE_URL + '/index.php?app=my_coupon&act=add';

        $.getJSON(url, {'coupon_id': coupon_id}, function(data) {
            if (data.done)
            {
                alert(data.retval);
            }
            else
            {
                alert(data.msg);
            }
        });
    }
</script>
<div id="main" class="w-full">
    <div id="coupon" class="w">
        <?php echo $this->fetch('curlocal.html'); ?>
        <div class="coupon_view">
            <h3><?php echo htmlspecialchars($this->_var['coupon']['coupon_name']); ?></h3>
            <?php if ($this->_var['coupon']['coupon_bg']): ?>
            <div class="coupon_bg">
                <img src="<?php echo $this->_var['coupon']['coupon_bg']; ?>" height="100" >
                <div class="cut_line"></div>
            </div>
            <?php endif; ?>
            <div class="coupon_info">
                有效期：<?php echo local_date("Y-m-d",$this->_var['coupon']['start_time']); ?>至<?php echo local_date("Y-m-d",$this->_var['coupon']['end_time']); ?> | 
                使用次数：<span style="color:#de2b2c;font-weight:bolder; font-family:verdana;"><?php echo htmlspecialchars($this->_var['coupon']['use_times']); ?></span> | 
                最低消费：<span style="color:#de2b2c;font-weight:bolder; font-family:verdana;"><?php echo price_format($this->_var['coupon']['min_amount']); ?></span> | 
                抵扣额度：<span style="color:#de2b2c;font-weight:bolder; font-family:verdana;"><?php echo price_format($this->_var['coupon']['coupon_value']); ?></span> | 
                已领取：<span style="color:#de2b2c;font-weight:bolder; font-family:verdana;"><?php echo ($this->_var['coupon']['hava_received'] == '') ? '0' : $this->_var['coupon']['hava_received']; ?></span> | 
                未领取：<span style="color:#de2b2c;font-weight:bolder; font-family:verdana;"><?php echo ($this->_var['coupon']['not_received'] == '') ? '0' : $this->_var['coupon']['not_received']; ?></span> | 
                发放店铺：<a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></a> 
            </div>
            <div class="scan_code" >
                <?php echo $this->_var['coupon']['scan_code']; ?><br/>
                <h2>扫描二维码手机领取</h2>
            </div>
            <div class="cut_line"></div>
            <div class="youhui_sfun">
                <div class="input_shopcart" onclick="add_coupon(<?php echo $this->_var['coupon']['coupon_id']; ?>)">领取</div>	
            </div>
            <div class="cut_line"></div>


            <div class="content">
                <?php echo html_filter($this->_var['coupon']['content']); ?>
            </div>

        </div>
    </div>

</div>

<?php echo $this->fetch('footer.html'); ?>