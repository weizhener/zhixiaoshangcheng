<div class="page page-top">
	<b class="total"><?php echo $this->_var['page_info']['curr_page']; ?>/<?php echo $this->_var['page_info']['page_count']; ?></b>
    <?php if ($this->_var['page_info']['prev_link']): ?>
    <a class="former" href="<?php echo $this->_var['page_info']['prev_link']; ?>"><</a>
    <?php else: ?>
    <span class="former_no"><</span>
    <?php endif; ?>
    <?php if ($this->_var['page_info']['next_link']): ?>
    <a class="down" href="<?php echo $this->_var['page_info']['next_link']; ?>">></a>
    <?php else: ?>
    <span class="down_no">></span>
    <?php endif; ?>
</div>