<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>推荐类型</p>
  <ul class="subnav">
    <li><span>管理</span></li>
    <li><a class="btn1" href="index.php?app=recommend&amp;act=add">新增</a></li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl">
    <form method="get">
       <div class="left">
          <input type="hidden" name="app" value="recommend" />
          <input type="hidden" name="act" value="index" />
          推荐类型名称:
          <input class="queryInput" type="text" name="recom_name" value="<?php echo htmlspecialchars($_GET['recom_name']); ?>" />
          <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?app=recommend">撤销检索</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['recommends']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td>推荐类型名称</td>
      <td>商品数</td>
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['recommends']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'recommend');if (count($_from)):
    foreach ($_from AS $this->_var['recommend']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['recommend']['recom_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['recommend']['recom_name']); ?></td>
      <td><?php echo ($this->_var['recommend']['goods_count'] == '') ? '0' : $this->_var['recommend']['goods_count']; ?></td>
      <td class="handler"><a href="index.php?app=recommend&amp;act=edit&amp;id=<?php echo $this->_var['recommend']['recom_id']; ?>">编辑</a> | <a href="javascript:drop_confirm('您确定要删除该推荐类型吗？', 'index.php?app=recommend&amp;act=drop&amp;id=<?php echo $this->_var['recommend']['recom_id']; ?>');">删除</a> | <a href="index.php?app=recommend&amp;act=view_goods&amp;id=<?php echo $this->_var['recommend']['recom_id']; ?>">查看推荐商品</a></td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="10">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['recommends']): ?>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=recommend&act=drop" presubmit="confirm('您确定要删除该推荐类型吗？');" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
  </div>
  <?php endif; ?>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?> 