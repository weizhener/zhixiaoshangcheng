<?php if ($this->_var['page_info']['page_count'] > 1): ?>
<div class="shop_list_page">
    <div class="page">
        <a class="stat"><?php echo sprintf('共 %s ', $this->_var['page_info']['item_count']); ?></a>
        <?php if ($this->_var['page_info']['prev_link']): ?>
        <a class="former" href="<?php echo $this->_var['page_info']['prev_link']; ?>#module"></a>
        <?php else: ?>
        <span class="former_no"></span>
        <?php endif; ?>
        <?php if ($this->_var['page_info']['first_link']): ?>
        <a class="page_link" href="<?php echo $this->_var['page_info']['first_link']; ?>">1&nbsp;<?php echo $this->_var['page_info']['first_suspen']; ?></a>
        <?php endif; ?>
        <?php $_from = $this->_var['page_info']['page_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('page', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['page'] => $this->_var['link']):
?>
        <?php if ($this->_var['page_info']['curr_page'] == $this->_var['page']): ?>
        <a class="page_hover" href="<?php echo $this->_var['link']; ?>#module"><?php echo $this->_var['page']; ?></a>
        <?php else: ?>
        <a class="page_link" href="<?php echo $this->_var['link']; ?>#module"><?php echo $this->_var['page']; ?></a>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if ($this->_var['page_info']['last_link']): ?>
        <a class="page_link" href="<?php echo $this->_var['page_info']['last_link']; ?>"><?php echo $this->_var['page_info']['last_suspen']; ?>&nbsp;<?php echo $this->_var['page_info']['page_count']; ?></a>
        <?php endif; ?>
        <a class="nonce"><?php echo $this->_var['page_info']['curr_page']; ?> / <?php echo $this->_var['page_info']['page_count']; ?></a>
        <?php if ($this->_var['page_info']['next_link']): ?>
        <a class="down" href="<?php echo $this->_var['page_info']['next_link']; ?>#module">下一页</a>
        <?php else: ?>
        <span class="down_no">下一页</span>
        <?php endif; ?>
    </div>
</div>
<?php endif; ?>