<?php echo $this->fetch('header.html'); ?>    
<div class="mb-head">
    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>
    <div class="tit">促销产品</div>
    <a href="<?php echo url('app=category'); ?>" class="r_b">分类</a>
</div>


<section class="search_goods">
    <?php if (! $this->_var['goods_list_order']): ?>
    <ul class="list">
        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
        <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>">
            <li>
                <img src="<?php echo $this->_var['goods']['default_image']; ?>" alt="<?php echo $this->_var['goods']['name']; ?>"/>
                <div class="detail">
                    <p class="title"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p>
                    <p class="price"><?php echo price_format($this->_var['goods']['pro_price']); ?></p>
                </div>
            </li>
        </a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <?php else: ?>
    <center style="font-size:16px;">没有找到相关的商品！</center>
    <?php endif; ?>
    <?php echo $this->fetch('page.bottom.html'); ?>
</section>



<?php echo $this->fetch('footer.html'); ?>