<?php echo $this->fetch('header.html'); ?>    
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'cart.js'; ?>" charset="utf-8"></script>
<div class="mb-head">
    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>
    <div class="tit">购物车</div>
    <a href="javascript" class="r_b"></a>
</div>


<div class="null" >
    <p><img src="<?php echo $this->res_base . "/" . 'images/cart_null.png'; ?>" /></p>
    <p>你的购物车是空的<br />现在就去购物吧~</p>
    <p><a href="<?php echo url('app=category'); ?>" class="white_btn">去购物<?php echo $this->_var['store_id']; ?></a></p>
</div>
<?php echo $this->fetch('footer.html'); ?>