<?php echo $this->fetch('header.html'); ?>    
<div class="mb-head">
    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>
    <div class="tit">店铺</div>
    <a href="javascript" class="r_b"></a>
</div>            
<div class="radius">
    <ul>
        <?php $_from = $this->_var['stores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
        <li style="padding: 10px;border-top: none;overflow: hidden;<?php if ($this->_foreach['fe_goods']['iteration'] != 1): ?>border-top: 1px solid #DED6C9;<?php endif; ?>line-height: 1.6em;">
            <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" style="display: block;overflow: hidden;lear: both;padding: .22em 0;">
                <span class="mu-tmb" style="float:left;margin-right:8px;">
                    <img src="<?php echo $this->_var['store']['store_logo']; ?>" alt="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>" width="100" height="100"/>
                </span>
                <span><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></span>
                <span class="red" style="display: block;"><?php echo htmlspecialchars($this->_var['store']['user_name']); ?></span>
                <span><?php echo htmlspecialchars($this->_var['store']['region_name']); ?><img src="<?php echo $this->_var['store']['credit_image']; ?>"/></span>
            </a>
        </li>
        <?php endforeach; else: ?>
        暂无此类商品
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</div>
<?php echo $this->fetch('page.bottom.html'); ?>

<?php echo $this->fetch('footer.html'); ?>