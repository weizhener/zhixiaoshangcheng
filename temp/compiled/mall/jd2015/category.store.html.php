<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
    <div id="page-category-store" class="w mt10">
        <?php echo $this->fetch('curlocal.html'); ?>
        <div class="w" area="top" widget_type="area">
            <?php $this->display_widgets(array('page'=>'scategory','area'=>'top')); ?>
        </div>
        <div class="scategory w mt10">
            <div class="search-type mb10 clearfix">
                <div class="float-left btn-type">
                    <a href="<?php echo url('app=category'); ?>">商品分类</a>
                    <a href="<?php echo url('app=category&act=store'); ?>" class="current">店铺分类</a>	
                </div>                       
            </div>
            <?php $_from = $this->_var['scategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'scategory');if (count($_from)):
    foreach ($_from AS $this->_var['scategory']):
?>
            <dl class="content mb10">
                <dt class="fs14 strong"><a href="<?php echo url('app=search&act=store&cate_id=' . $this->_var['scategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['scategory']['value']); ?></a></dt>
                <dd>
                    <?php $_from = $this->_var['scategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');if (count($_from)):
    foreach ($_from AS $this->_var['child']):
?>
                    <a href="<?php echo url('app=search&act=store&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </dd>
            </dl>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
        <div class="w mb20" area="bottom" widget_type="area">
            <?php $this->display_widgets(array('page'=>'scategory','area'=>'bottom')); ?>
        </div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
