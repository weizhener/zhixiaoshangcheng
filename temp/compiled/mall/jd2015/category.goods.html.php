<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
    <div id="page-category-goods" class="w mt10">
        <?php echo $this->fetch('curlocal.html'); ?>
        <div class="w" area="top" widget_type="area">
            <?php $this->display_widgets(array('page'=>'gcategory','area'=>'top')); ?>
        </div>
        <div class="gcategory w mt10">
            <div class="search-type mb10 clearfix">
                <div class="float-left btn-type">
                    <a href="<?php echo url('app=category'); ?>" class="current">商品分类</a>
                    <a href="<?php echo url('app=category&act=store'); ?>">店铺分类</a>	
                </div>                       
            </div>
            <div class="float-left">
                <?php $_from = $this->_var['gcategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['gcategory']):
        $this->_foreach['fe_category']['iteration']++;
?>
                <?php if ($this->_foreach['fe_category']['iteration'] % 2 == '1'): ?>
                <div class="m">
                    <div class="mt">
                        <h2><a href="<?php echo url('app=search&cate_id=' . $this->_var['gcategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></a></h2>
                    </div>
                    <div class="mc">
                        <?php $_from = $this->_var['gcategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
                        <dl <?php if (($this->_foreach['fe_child']['iteration'] <= 1)): ?>class="first"<?php endif; ?>>
                            <dt><a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a></dt>
                            <dd>
                                <?php $_from = $this->_var['child']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child2');$this->_foreach['fe_child2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child2']['total'] > 0):
    foreach ($_from AS $this->_var['child2']):
        $this->_foreach['fe_child2']['iteration']++;
?>
                                <a href="<?php echo url('app=search&cate_id=' . $this->_var['child2']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child2']['value']); ?></a>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </dd>
                        </dl>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>

            <div class="float-right">
                <?php $_from = $this->_var['gcategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['gcategory']):
        $this->_foreach['fe_category']['iteration']++;
?>
                <?php if ($this->_foreach['fe_category']['iteration'] % 2 == '0'): ?>
                <div class="m">
                    <div class="mt">
                        <h2><a href="<?php echo url('app=search&cate_id=' . $this->_var['gcategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></a></h2>
                    </div>
                    <div class="mc">
                        <?php $_from = $this->_var['gcategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
                        <dl <?php if (($this->_foreach['fe_child']['iteration'] <= 1)): ?>class="first"<?php endif; ?>>
                            <dt><a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a></dt>
                            <dd>
                                <?php $_from = $this->_var['child']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child2');$this->_foreach['fe_child2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child2']['total'] > 0):
    foreach ($_from AS $this->_var['child2']):
        $this->_foreach['fe_child2']['iteration']++;
?>
                                <a href="<?php echo url('app=search&cate_id=' . $this->_var['child2']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child2']['value']); ?></a>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </dd>
                        </dl>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </div>
                </div>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>

        </div>
        <div class="w mb20" area="bottom" widget_type="area">
            <?php $this->display_widgets(array('page'=>'gcategory','area'=>'bottom')); ?>
        </div>
    </div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>