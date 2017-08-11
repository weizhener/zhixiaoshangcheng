<?php echo $this->fetch('header.html'); ?>

<div id="rightTop">

  <p>店铺等级</p>

  <ul class="subnav">

    <li><span>管理</span></li>

    <li><a class="btn1" href="index.php?app=sgrade&amp;act=add">新增</a></li>

  </ul>

</div>

<div class="mrightTop">

  <div class="fontl">

    <form method="get">

      <div class="left">

          <input type="hidden" name="app" value="sgrade" />

          <input type="hidden" name="act" value="index" />

          等级名称:

          <input class="queryInput" type="text" name="grade_name" value="<?php echo htmlspecialchars($_GET['grade_name']); ?>" />

          <input type="submit" class="formbtn" value="查询" />

      </div>

      <?php if ($this->_var['filtered']): ?>

      <a class="left formbtn1" href="index.php?app=sgrade">撤销检索</a>

      <?php endif; ?>

    </form>

  </div>

  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>

</div>

<div class="tdare">

  <table width="100%" cellspacing="0" class="dataTable">

    <?php if ($this->_var['sgrades']): ?>

    <tr class="tatr1">

      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>

      <td>等级名称</td>

      <td>允许发布商品数</td>

      <td>上传空间大小(MB)</td>

      <td>可选模板套数</td>
      
      <td>每日返利</td>

      <td>收费标准</td>

      <td class="table-center">需要审核</td>

      <td class="handler" style="width: 250px">操作</td>

    </tr>

    <?php endif; ?>

    <?php $_from = $this->_var['sgrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgrade');if (count($_from)):
    foreach ($_from AS $this->_var['sgrade']):
?>

    <tr class="tatr2">

      <td class="firstCell"><?php if ($this->_var['sgrade']['grade_id'] != 1): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['sgrade']['grade_id']; ?>" /><?php endif; ?></td>

      <td><?php echo htmlspecialchars($this->_var['sgrade']['grade_name']); ?></td>

      <td><?php echo $this->_var['sgrade']['goods_limit']; ?></td>

      <td><?php echo $this->_var['sgrade']['space_limit']; ?></td>

      <td><?php echo $this->_var['sgrade']['skin_limit']; ?></td>
      
      <td><?php echo $this->_var['sgrade']['money']; ?></td>

      <td><?php echo $this->_var['sgrade']['charge']; ?></td>

      <td class="table-center"><?php if ($this->_var['sgrade']['need_confirm']): ?>是<?php else: ?>否<?php endif; ?></td>

      <td class="handler" style="width: 250px">

      <span style="width: 230px">

      <a href="index.php?app=sgrade&amp;act=edit&amp;id=<?php echo $this->_var['sgrade']['grade_id']; ?>">编辑</a> | <?php if ($this->_var['sgrade']['grade_id'] == 1): ?>禁删<?php else: ?><a href="javascript:drop_confirm('您确定要删除该店铺等级吗？删除该店铺等级下的所有店铺会自动改为默认等级', 'index.php?app=sgrade&amp;act=drop&amp;id=<?php echo $this->_var['sgrade']['grade_id']; ?>');">删除</a><?php endif; ?> | <a href="index.php?app=sgrade&amp;act=set_skins&amp;id=<?php echo $this->_var['sgrade']['grade_id']; ?>">设置模板</a> | <a href="index.php?app=sgrade&amp;act=set_wapskins&amp;id=<?php echo $this->_var['sgrade']['grade_id']; ?>">设置Wap模板</a>

      </span>

      </td>

    </tr>

    <?php endforeach; else: ?>

    <tr class="no_data">

      <td colspan="10">没有符合条件的记录</td>

    </tr>

    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

  </table>

  <?php if ($this->_var['sgrade']): ?>

  <div id="dataFuncs">

    <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;

      <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=sgrade&act=drop" presubmit="confirm('您确定要删除该店铺等级吗？删除该店铺等级下的所有店铺会自动改为默认等级');" />

    </div>

    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>

  </div>

  <div class="clear"></div>

  <?php endif; ?>

</div>

<?php echo $this->fetch('footer.html'); ?> 