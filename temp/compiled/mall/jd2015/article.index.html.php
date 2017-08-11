<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
    <div id="page-article" class="w mb20 clearfix">
        <div class="col-sub">
            <div area="col-left-1" widget_type="area">
                <?php $this->display_widgets(array('page'=>'article','area'=>'col-left-1')); ?>
            </div>
            <div class="title mt10">文章分类</div>
            <ul class="content mb10">
                <?php $_from = $this->_var['acategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'acategory');if (count($_from)):
    foreach ($_from AS $this->_var['acategory']):
?>
                <li><a href="<?php echo url('app=article&cate_id=' . $this->_var['acategory']['cate_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['acategory']['cate_name']); ?></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <div area="col-left-2" widget_type="area">
                <?php $this->display_widgets(array('page'=>'article','area'=>'col-left-2')); ?>
            </div>
            <div class="title">最新文章</div>
            <ul class="content">
                <?php $_from = $this->_var['new_articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'new_article');if (count($_from)):
    foreach ($_from AS $this->_var['new_article']):
?>
                <li><a <?php if ($this->_var['new_article']['link']): ?>target="_blank"<?php endif; ?> href="<?php echo url('app=article&act=view&article_id=' . $this->_var['new_article']['article_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['new_article']['title']); ?></a></li>
                <?php endforeach; else: ?>
                <li>暂无新文章</li>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <div area="col-left-3" widget_type="area">
                <?php $this->display_widgets(array('page'=>'article','area'=>'col-left-3')); ?>
            </div>
        </div>
        <div class="col-main mt10">
            <div class="title"><?php echo $this->fetch('curlocal.html'); ?></div>
            <ul class="content">
                <?php $_from = $this->_var['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
                <li><b></b><a <?php if ($this->_var['article']['link']): ?>target="_blank"<?php endif; ?> href="<?php echo url('app=article&act=view&article_id=' . $this->_var['article']['article_id']. ''); ?>" class="lebioa"><?php echo htmlspecialchars($this->_var['article']['title']); ?></a> <span><?php echo local_date("Y.m.d",$this->_var['article']['add_time']); ?></span></li>
                <?php endforeach; else: ?>
                <li>没有符合条件的记录</li>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
    </div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>