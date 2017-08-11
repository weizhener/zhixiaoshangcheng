<?php echo $this->fetch('header.html'); ?>    

<style>
    .shop_detail{margin-top:15px; color:#999; font-size:14px;}
    .shop_detail img{width:100%;  margin:0 auto ;}
    .shop_detail table{border-collapse: collapse; width:100%;}
    .shop_img_bg{background:#333; height:200px; position:absolute; top:45px; width:100%; left:0; z-index:-1;}
    .nav_btn_img{background: linear-gradient(#FFFFFF, #F1F1F1) repeat scroll 0 0 #EEEEEE;border: 1px solid #CCCCCC;color: #222222;font-weight: bold;height: 70px;margin-bottom: -1px;overflow: hidden;text-overflow: ellipsis; text-shadow: 0 1px 0 #FFFFFF;white-space: nowrap;position: relative;}
    .nav_btn_img .t {font-size: 18px;left: 15px;position: absolute;top: 21px;}
    .nav_btn_img .s {bottom: 15px;color: #BBBBBB;font-size: 13px;left: 15px;overflow: hidden;position: absolute;width: 70%;}
    .header3{text-align:center; line-height:45px;}
</style>
<div class="mb-head">
    <a href="<?php echo url('app=default'); ?>" class="l_b">返回</a>
    <div class="tit">文章列表</div>
    <a href="javascript" class="r_b"></a>
</div>
<div class="shop_detail">
    <ul>
        <?php $_from = $this->_var['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
        <li class="nav_btn_img">
            <a href="<?php echo url('app=article&act=view&article_id=' . $this->_var['article']['article_id']. ''); ?>">
                <span class="t"><?php echo $this->_var['article']['title']; ?></span>

            </a>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</div>


<?php echo $this->fetch('footer.html'); ?>
