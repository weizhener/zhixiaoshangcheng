<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>旗舰店</p>
  <ul class="subnav">
    <li><span>管理</span></li>
    <li><a class="btn1" href="index.php?app=ultimate_store&act=add">新增</a></li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?> </div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['ultimate_store']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td><span ectype="order_by" fieldname="store_name">店铺名称</span></td>
      <td><span ectype="order_by" fieldname="region_id">选择相关联的品牌</span></td>
      <td><span ectype="order_by" fieldname="sgrade">选择相关联的商品分类</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="add_time">设置店铺的关键字</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="state">开启状态</span></td>
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['ultimate_store']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['store']['ultimate_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['store']['brand_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['store']['cate_name']); ?></td>
      <td class="table-center"><?php echo $this->_var['store']['keyword']; ?></td>
      <td class="table-center"><?php if ($this->_var['store']['status'] == '1'): ?>开启<?php else: ?>关闭<?php endif; ?></td>
      <td class="handler">
        <a href="index.php?app=ultimate_store&amp;act=edit&amp;id=<?php echo $this->_var['store']['ultimate_id']; ?>">编辑</a> | <a href="javascript:drop_confirm('确认删除该旗舰店的信息', 'index.php?app=ultimate_store&amp;act=drop&amp;id=<?php echo $this->_var['store']['ultimate_id']; ?>');">删除</a>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="7">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['ultimate_store']): ?>
  <div id="dataFuncs">
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    <div id="batchAction" class="left paddingT15">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=ultimate_store&act=drop" presubmit="confirm('确认删除该旗舰店的信息');" />
    </div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>

</div>
<?php echo $this->fetch('footer.html'); ?>