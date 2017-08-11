<?php echo $this->fetch('header.html'); ?>    
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'cart.js'; ?>" charset="utf-8"></script>
<div class="mb-head">
    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>
    <div class="tit">购物车</div>
    <a href="javascript" class="r_b"></a>
</div>

<?php $_from = $this->_var['carts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('store_id', 'cart');if (count($_from)):
    foreach ($_from AS $this->_var['store_id'] => $this->_var['cart']):
?>
<section class="cart-list">
    <div class="mt">
        <a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>">店铺: <?php echo htmlspecialchars($this->_var['cart']['store_name']); ?></a>
    </div>
    <div class="mc">
        <?php $_from = $this->_var['cart']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
        <dl id="cart_item_<?php echo $this->_var['goods']['rec_id']; ?>">
            <dt>
                <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"> <img src="<?php echo $this->_var['goods']['goods_image']; ?>" /></a>
            </dt>
            <dd>
                <p class="name"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?><?php if ($this->_var['goods']['specification']): ?>(<?php echo htmlspecialchars($this->_var['goods']['specification']); ?>)<?php endif; ?></p>
                <p class="price">价格：<strong><?php echo price_format($this->_var['goods']['price']); ?></strong></p>
                <p class="c_oprate">
                    <span class="white_btn" onclick="decrease_quantity(<?php echo $this->_var['goods']['rec_id']; ?>);">-</span>
                    <input type="text" id="input_item_<?php echo $this->_var['goods']['rec_id']; ?>"  value="<?php echo $this->_var['goods']['quantity']; ?>" orig="<?php echo $this->_var['goods']['quantity']; ?>"  class="addtext"  id="input_item"  onkeyup="change_quantity(<?php echo $this->_var['store_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>, <?php echo $this->_var['goods']['spec_id']; ?>, this);"  changed="<?php echo $this->_var['goods']['quantity']; ?>"/>
                    <span class="white_btn" onclick="add_quantity(<?php echo $this->_var['goods']['rec_id']; ?>);">+</span>
                    <a href="#" onclick="drop_cart_item(<?php echo $this->_var['store_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>);"> <span class="close"><img src="<?php echo $this->res_base . "/" . 'images/close.jpg'; ?>" style="border:none; width:20px;height:20px;margin:0 0 5px 0;" /></span></a>
                </p>
            </dd>
        </dl>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <div class="count">
            <a>合计(不含运费): <strong id='cart<?php echo $this->_var['store_id']; ?>_amount'><?php echo price_format($this->_var['cart']['amount']); ?></strong></a>
            <a href="<?php echo url('app=order&goods=cart&store_id=' . $this->_var['store_id']. ''); ?>" class="jie">去结算</a>
       </div>
    </div>
</section>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>




<?php echo $this->fetch('footer.html'); ?>

