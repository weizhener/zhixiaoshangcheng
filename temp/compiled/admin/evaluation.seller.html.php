<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>评价管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=evaluation&amp;act=get_evaluation_buyer">买家评价</a></li>
    <li><span>卖家评价</span></li>
  </ul>
</div>

<div class="mrightTop">
  <div class="fontl">
    <form method="get">
       <div class="left">
          <input type="hidden" name="app" value="evaluation" />
          <input type="hidden" name="act" value="get_evaluation_buyer" />
          买家用户名：
          <input class="queryInput" type="text" name="buyer_name" value="<?php echo htmlspecialchars($_GET['buyer_name']); ?>" />
          卖家店铺名：
          <input class="queryInput" type="text" name="seller_name" value="<?php echo htmlspecialchars($_GET['seller_name']); ?>" />
          评价：
          <select class="querySelect" name="evalscore">
              <option>全部</option>
              <option value="3" <?php if ($_GET['evalscore'] == '3'): ?>selected<?php endif; ?>>好评</option>
              <option value="2" <?php if ($_GET['evalscore'] == '2'): ?>selected<?php endif; ?>>中评</option>
              <option value="1" <?php if ($_GET['evalscore'] == '1'): ?>selected<?php endif; ?>>差评</option>
          </select>
          内容:
          <select class="querySelect" name="havecontent">
              <option>全部</option>
              <option value="1" <?php if ($_GET['havecontent'] == '1'): ?>selected<?php endif; ?>>无评论</option>
              <option value='2' <?php if ($_GET['havecontent'] == '2'): ?>selected<?php endif; ?>>有评论</option>
          </select>
          <input type="submit" class="formbtn" value="查询" />
      </div>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['goods_list']): ?>
    <tr class="tatr1">
      <td>评价店铺</td>
      <td>被评价人</td>
      <td>评价等级</td>
      <td>评价内容</td>
      <td>评价时间</td>
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <tr class="tatr2">
      <td><?php echo htmlspecialchars($this->_var['goods']['seller_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['goods']['buyer_name']); ?></td>
      <td> 
          <?php if ($this->_var['goods']['seller_evaluation'] == '3'): ?>好评<?php endif; ?>
          <?php if ($this->_var['goods']['seller_evaluation'] == '2'): ?>中评<?php endif; ?>
          <?php if ($this->_var['goods']['seller_evaluation'] == '1'): ?>差评<?php endif; ?>
      </td>
      <td><?php echo htmlspecialchars($this->_var['goods']['seller_comment']); ?></td>
      <td>
          <?php echo local_date("Y-m-d",$this->_var['goods']['seller_evaluation_time']); ?>
      </td>
      <td class="handler">
      <span style="width: 50px">
      <a href="index.php?app=evaluation&amp;act=edit_seller&amp;rec_id=<?php echo $this->_var['goods']['rec_id']; ?>">修改</a>
      </span>
      </td>
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="10">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['users']): ?>
  <div id="dataFuncs">
    <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
      <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=user&act=drop" presubmit="confirm('您确定要删除它吗？');" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    <div class="clear"></div>
  </div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>