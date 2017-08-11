<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
    <div id="page-article" class="w clearfix mb20">
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
        <div class="col-main  mt10">
            <div class="title clearfix"><?php echo $this->fetch('curlocal.html'); ?></div>
            <div class="content">
                <div class="article-info">
                    <h1><?php echo htmlspecialchars($this->_var['article']['title']); ?></h1>
                    <h2>时间：<?php echo local_date("Y-m-d H:i",$this->_var['article']['add_time']); ?></h2>
                </div>
                <div class="article-detail">
                    <?php if ($this->_var['article']['store_id']): ?>
                    <?php echo html_filter($this->_var['article']['content']); ?>
                    <?php else: ?>
                    <?php echo $this->_var['article']['content']; ?>
                    <?php endif; ?>
                </div>
                <div class="more-article mt20">
                    <h3>上一篇：<?php if ($this->_var['pre_article']): ?><a target="<?php echo $this->_var['pre_article']['target']; ?>" href="<?php echo url('app=article&act=view&article_id=' . $this->_var['pre_article']['article_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['pre_article']['title']); ?></a><?php else: ?>没有符合条件的记录<?php endif; ?></h3>
                    <h3>下一篇：<?php if ($this->_var['next_article']): ?><a target="<?php echo $this->_var['next_article']['target']; ?>" href="<?php echo url('app=article&act=view&article_id=' . $this->_var['next_article']['article_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['next_article']['title']); ?></a><?php else: ?>没有符合条件的记录<?php endif; ?></h3>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>