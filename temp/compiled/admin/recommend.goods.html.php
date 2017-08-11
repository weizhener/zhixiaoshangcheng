<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>推荐商品</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=recommend">推荐类型</a></li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl"> 推荐类型:
    <select class="infoTableSelect" onchange="location='index.php?app=recommend&act=view_goods&id=' + this.value"><?php echo $this->html_options(array('options'=>$this->_var['recommends'],'selected'=>$_GET['id'])); ?>

    </select>
  </div>
  <div class="fontr"> <?php if ($this->_var['goods_list']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?> </div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td width="30%">商品名称</td>
      <td width="100">排序</td>
      <td width="10%">店铺名称</td>
      <td width="10%">品牌</td>
      <td>所属分类</td>
      <td>上架</td>
      <td>禁售</td>
      <td>浏览数</td>
    </tr>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></td>
      <td><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $_GET['id']; ?>-<?php echo $this->_var['goods']['goods_id']; ?>" class="editable" title="单击可以编辑"><?php echo $this->_var['goods']['sort_order']; ?></span></td>
      <td><?php echo htmlspecialchars($this->_var['goods']['store_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['goods']['brand']); ?></td>
      <td><?php echo nl2br($this->_var['goods']['cate_name']); ?></td>
      <td><?php if ($this->_var['goods']['if_show']): ?><img src="<?php echo $this->res_base . "/" . 'style/images/positive_enabled.gif'; ?>" /><?php else: ?><img src="<?php echo $this->res_base . "/" . 'style/images/positive_disabled.gif'; ?>" /><?php endif; ?></td>
      <td><?php if ($this->_var['goods']['closed']): ?><img src="<?php echo $this->res_base . "/" . 'style/images/negative_enabled.gif'; ?>" /><?php else: ?><img src="<?php echo $this->res_base . "/" . 'style/images/negative_disabled.gif'; ?>" /><?php endif; ?></td>
      <td><?php echo ($this->_var['goods']['views'] == '') ? '0' : $this->_var['goods']['views']; ?></td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="5">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="取消推荐" name="goods_id" uri="index.php?app=recommend&act=drop_goods_from&id=<?php echo $_GET['id']; ?>" />
    </div>
  </div>
  <div class="pageLinks"> <?php if ($this->_var['goods_list']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?> </div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?> 