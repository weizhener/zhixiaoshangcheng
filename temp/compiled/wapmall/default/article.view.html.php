<?php echo $this->fetch('header.html'); ?>
<div class="mb-head">
    <a href="<?php echo url('app=article'); ?>" class="l_b">返回</a>
    <div class="tit"><?php echo htmlspecialchars($this->_var['article']['title']); ?></div>
    <a href="javascript" class="r_b"></a>
</div>
<style>
    .shop_detail{margin-top:50px; padding:10px 15px; color:#999; font-size:14px; background:#FFF;}
    .shop_detail img{width:100%;  margin:0 auto;}
    .shop_detail table{border-collapse: collapse; width:100%;}
    .shop_img_bg{background:#333; height:200px; position:absolute; top:45px; width:100%; left:0; z-index:-1;}
</style>
<div class="shop_detail">
    <?php echo html_filter($this->_var['article']['content']); ?>
</div>

<?php echo $this->fetch('footer.html'); ?>