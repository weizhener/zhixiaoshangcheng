<?php echo $this->fetch('header.html'); ?>
<style>
    #coupon{margin: 10px auto;}
    .coupon_list{}
    .coupon_list ul{}
    .coupon_list li{float:left;margin:10px;border:4px solid #fff;width: 210px;}
    .coupon_list li:hover{border: 4px solid #ce1c00;}
    .coupon_list li .p_img{}
    .coupon_list li .p_name{text-align: center;height: 30px;line-height: 30px;overflow: hidden;}
    .coupon_list li .p_info{text-align: center;height: 30px;line-height: 30px;overflow: hidden;}
</style>

<div id="main" class="w-full">
    <div id="coupon" class="w">
        <?php echo $this->fetch('curlocal.html'); ?>
        <div class="coupon_list clearfix">
            <ul>
                <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');$this->_foreach['fe_coupon'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_coupon']['total'] > 0):
    foreach ($_from AS $this->_var['coupon']):
        $this->_foreach['fe_coupon']['iteration']++;
?>
                <li>
                    <a href="<?php echo url('app=coupon&act=view&id=' . $this->_var['coupon']['coupon_id']. ''); ?>" target="_blank">
                        <div class="p_img">
                            <img src="<?php echo $this->_var['coupon']['coupon_bg']; ?>" width="210" height="160"/>
                        </div>
                        <div class="p_name">
                            <?php echo $this->_var['coupon']['store_name']; ?>
                        </div>
                        <div class="p_info">
                            满<?php echo price_format($this->_var['coupon']['min_amount']); ?>可抵扣<?php echo price_format($this->_var['coupon']['coupon_value']); ?>
                        </div>
                    </a>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
        <?php echo $this->fetch('page.bottom.html'); ?>
    </div>
</div>


<?php echo $this->fetch('footer.html'); ?>