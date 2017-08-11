<?php echo $this->fetch('header.html'); ?>

<div class="mb-head">
    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>
    <div class="tit">优惠卷</div>
    <a href="<?php echo url('app=category'); ?>" class="r_b">分类</a>
</div>

<style>
    .coupon_list{background: #fff;}
    .coupon_list ul{}
    .coupon_list ul li{padding: 8px 10px 9px 10px;border-bottom: 1px solid #f5f5f5;height: 80px;}
    .coupon_list ul li .pic{width: 100px;height: 80px;margin: 0px 12px 0 0;display: inline-block;overflow: hidden;position: relative;float:left;}
    .coupon_list ul li .info{-webkit-box-flex: 1;-moz-box-flex: 1;}
    .coupon_list ul li .info h2{font-size: 15px;color: #323232;height: 15px;overflow: hidden;display: -webkit-box;display: -moz-box;font-weight: bold;-webkit-line-clamp: 2;-moz-line-clamp: 2;-webkit-box-orient: vertical;-moz-box-orient: vertical;word-break: break-all;line-height: 15px;}
    .coupon_list ul li .info h3{font-size: 12px;color: #ff5c5b;height: 28px;line-height: 14px;overflow: hidden;display: -webkit-box;display: -moz-box;display: box;-webkit-line-clamp: 2;-webkit-box-orient: vertical;-moz-line-clamp: 2;-moz-box-orient: vertical;word-break: break-all;margin: 11px 0;}
</style>

<section class="coupon_list">
    <?php if ($this->_var['coupons']): ?>
    <ul class="list">

        <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');$this->_foreach['fe_coupon'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_coupon']['total'] > 0):
    foreach ($_from AS $this->_var['coupon']):
        $this->_foreach['fe_coupon']['iteration']++;
?>
        <a href="<?php echo url('app=coupon&act=view&id=' . $this->_var['coupon']['coupon_id']. ''); ?>">
            <li>
                <div class="pic">
                    <img src="<?php echo $this->_var['coupon']['coupon_bg']; ?>" width="100" height="80" />
                </div>
                <div class="info">
                    <h2><?php echo $this->_var['coupon']['store_name']; ?></h2>
                    <h3>满<?php echo price_format($this->_var['coupon']['min_amount']); ?>可抵扣<?php echo price_format($this->_var['coupon']['coupon_value']); ?></h3>
                </div>
            </li>
        </a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <?php else: ?>
    <center style="font-size:16px;">没有优惠卷！</center>
    <?php endif; ?>
    <?php echo $this->fetch('page.bottom.html'); ?>
</section>


<?php echo $this->fetch('footer.html'); ?>