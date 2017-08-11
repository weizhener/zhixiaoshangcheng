<div class="list-page">
    <?php if ($this->_var['page_info']['prev_link']): ?>
    <a class="pg-prev" href="<?php echo $this->_var['page_info']['prev_link']; ?>"><i class="trigger"></i><s>上一页</s></a>
    <?php else: ?>
    <span class="pg-prev"><i class="trigger"></i></span>
    <?php endif; ?>
    <?php $_from = $this->_var['page_info']['page_links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('page', 'link');if (count($_from)):
    foreach ($_from AS $this->_var['page'] => $this->_var['link']):
?>
    <?php if ($this->_var['page_info']['curr_page'] == $this->_var['page']): ?>
    <a class="on" href="<?php echo $this->_var['link']; ?>"><span><?php echo $this->_var['page']; ?></span></a>
    <?php else: ?>
    <a href="<?php echo $this->_var['link']; ?>"><span><?php echo $this->_var['page']; ?></span></a>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['page_info']['last_link']): ?>
    <a class="page_link" href="<?php echo $this->_var['page_info']['last_link']; ?>"><?php echo $this->_var['page_info']['last_suspen']; ?>&nbsp;<?php echo $this->_var['page_info']['page_count']; ?></a>
    <?php endif; ?>
    <?php if ($this->_var['page_info']['next_link']): ?>
    <a class="pg-next" href="<?php echo $this->_var['page_info']['next_link']; ?>">
    	<s>下一页</s>
		<i class="trigger"></i>
    </a>
    <?php else: ?>
    <span class="pg-next">
    	<s>下一页</s>
		<i class="trigger"></i>
    </span>
    <?php endif; ?>
</div>