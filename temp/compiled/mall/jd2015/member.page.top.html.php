<div class="page">
	<span class="stat"><?php echo $this->_var['page_info']['curr_page']; ?>/<?php echo $this->_var['page_info']['page_count']; ?></span>
	<?php if ($this->_var['page_info']['prev_link']): ?>
	<a class="former" href="<?php echo $this->_var['page_info']['prev_link']; ?>"></a>
	<?php else: ?>
	<span class="former_no"></span>
	<?php endif; ?>
	<?php if ($this->_var['page_info']['next_link']): ?>
	<a class="down" href="<?php echo $this->_var['page_info']['next_link']; ?>">下一页</a>
	<?php else: ?>
	<span class="down_no">下一页</span>
	<?php endif; ?>
</div>	
