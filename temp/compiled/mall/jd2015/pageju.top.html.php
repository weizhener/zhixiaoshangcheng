<div class="list-page">
	<span class="sum"><em><?php echo $this->_var['page_info']['curr_page']; ?></em>/<?php echo $this->_var['page_info']['page_count']; ?></span>
    <?php if ($this->_var['page_info']['prev_link']): ?>
    <a class="pg-prev" href="<?php echo $this->_var['page_info']['prev_link']; ?>"><i class="trigger"></i></a>
    <?php else: ?>
    <span class="pg-prev"><i class="trigger"></i></span>
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