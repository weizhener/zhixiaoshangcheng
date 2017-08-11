<?php if ($this->_var['page_info']['page_count'] > 1): ?>
<div class="page">
    <div class="pagination">
        <a href="javascript:;" class="page-num"><?php echo $this->_var['page_info']['curr_page']; ?> / <?php echo $this->_var['page_info']['page_count']; ?><i class="icon-down"></i></a>
        <a href="<?php if ($this->_var['page_info']['prev_link']): ?><?php echo $this->_var['page_info']['prev_link']; ?><?php else: ?>javascript:void(0)<?php endif; ?>" class="last">上一页</a>
        <a href="<?php if ($this->_var['page_info']['next_link']): ?><?php echo $this->_var['page_info']['next_link']; ?><?php else: ?>javascript:void(0)<?php endif; ?>" class="next">下一页</a>
    </div>
</div>
<?php endif; ?>