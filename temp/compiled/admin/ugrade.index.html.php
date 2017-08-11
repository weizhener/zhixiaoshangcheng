<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <ul class="subnav">
    <li><span>等级管理</span></li>
    <li><a class="btn1" href="index.php?app=ugrade&amp;act=add">新增等级</a></li>
    <li><a class="btn1" href="index.php?app=ugrade&amp;act= growth_value">成长值</a></li>
  </ul>
</div>
<div class="mrightTop">
  <div class="fontl">
    <form method="get">
      <div class="left">
          <input type="hidden" name="app" value="ugrade" />
          <input type="hidden" name="act" value="index" />
          名称:
          <input class="queryInput" type="text" name="grade_name" value="<?php echo htmlspecialchars($_GET['grade_name']); ?>" />
          <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?app=ugrade">撤销检索</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['ugrades']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td>名称</td>
      <td style="width:250px;text-align:center;">等级</td>
      <td style="width:250px;text-align:center;">所需成长值</td>
      <td style="width:250px;text-align:center;">添加时间</td>
      <td class="handler" style="width: 250px;text-align:center;">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['ugrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ugrade');if (count($_from)):
    foreach ($_from AS $this->_var['ugrade']):
?>
    <tr class="tatr2">
      <td class="firstCell"><?php if ($this->_var['ugrade']['grade_id'] != 1): ?><input  disabled="disabled" type="checkbox" class="checkitem" value="<?php echo $this->_var['ugrade']['grade_id']; ?>" /><input style="display:none;" type="checkbox" class="checkitem" value="<?php echo $this->_var['ugrade']['grade_id']; ?>" /><?php endif; ?></td>
      <td><?php echo htmlspecialchars($this->_var['ugrade']['grade_name']); ?></td>
      <td style="width:250px;text-align:center;"><?php echo htmlspecialchars($this->_var['ugrade']['grade']); ?></td>
      <td style="width:250px;text-align:center;"><?php echo htmlspecialchars($this->_var['ugrade']['growth_needed']); ?></td>
      <td style="width:250px;text-align:center;"><?php echo local_date("Y-m-d H:i:s",$this->_var['ugrade']['add_time']); ?></td>
      <td class="handler" style="width: 250px;">
      <span style="width: 250px;text-align:center;">
      <a href="index.php?app=ugrade&amp;act=edit&amp;id=<?php echo $this->_var['ugrade']['grade_id']; ?>">编辑</a>
      </span>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="10">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['ugrade']): ?>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="全部删除" name="id" uri="index.php?app=ugrade&act=drop" presubmit="confirm('删除全部的会员等级会使会员的积分清零，你确定要删除吗？');" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
  </div>
  <div class="clear"></div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?> 