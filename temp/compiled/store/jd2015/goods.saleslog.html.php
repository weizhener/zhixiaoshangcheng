<?php echo $this->fetch('header.html'); ?>

<?php echo $this->fetch('top.html'); ?>

<div id="content">
    <?php echo $this->fetch('goodsinfo.html'); ?>
    <div id="left">
        <?php echo $this->fetch('left.html'); ?>
    </div>

    <div id="right">

        <div id="module">
            <ul class="user_menu">
                <li><a class="normal" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>商品详情</span></a></li>
                <li><a class="normal" href="<?php echo url('app=goods&act=comments&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>商品评论</span></a></li>
                <li><a class="active" href="<?php echo url('app=goods&act=saleslog&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>销售记录</span></a></li>
                <li><a class="normal" href="<?php echo url('app=goods&act=qa&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>产品咨询</span></a></li>
            </ul>
        </div>
        <div class="clear"></div>

        <div class="module_currency">
            <div class="wrap">
                <div class="wrap_child">
                    <?php echo $this->fetch('saleslog.html'); ?>
                    <div class="clear"></div>
                </div>
            </div>
        </div>
        <div class="clear"></div>

        <?php echo $this->fetch('page.bottom.html'); ?>
        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>

<?php echo $this->fetch('footer.html'); ?>