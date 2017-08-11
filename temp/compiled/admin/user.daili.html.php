<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>区域代理</p>
  <ul class="subnav">
   <li>管理</li>
    <li>
   
      <a class="btn1" href="index.php?app=user&amp;act=dailiadd">新增</a>
    
    </li>
  </ul>
</div>

<div class="mrightTop">
  <div class="fontl">
    <form method="get">
       <div class="left">
          <input type="hidden" name="app" value="user" />
          <input type="hidden" name="act" value="index" />
          <select class="querySelect" name="field_name"><?php echo $this->html_options(array('options'=>$this->_var['query_fields'],'selected'=>$_GET['field_name'])); ?>
          </select>
          <input class="queryInput" type="text" name="field_value" value="<?php echo htmlspecialchars($_GET['field_value']); ?>" />
          排序:
          <select class="querySelect" name="sort"><?php echo $this->html_options(array('options'=>$this->_var['sort_options'],'selected'=>$_GET['sort'])); ?>
          </select>
          <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
      <a class="left formbtn1" href="index.php?app=user">撤销检索</a>
      <?php endif; ?>
    </form>
  </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['daili_list']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td>会员名 | 真实姓名</td>
      <td>代理名称</td>
      
  <td>代理地区</td>
      <td class="handler">操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['daili_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['user']['user_id']; ?>" /></td>
      <td><?php echo htmlspecialchars($this->_var['user']['user_name']); ?> | <?php echo htmlspecialchars($this->_var['user']['real_name']); ?></td>
      <td><?php echo htmlspecialchars($this->_var['user']['title']); ?></td>
     
     <td><?php $_from = $this->_var['user']['dqlist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'dqs');if (count($_from)):
    foreach ($_from AS $this->_var['dqs']):
?><?php echo $this->_var['dqs']; ?>,<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  </td>
    
      <td class="handler">
      <?php if (! $this->_var['if_system_manager'] && $this->_var['user']['privs'] == all): ?>系统管理员
      </td>
      <?php else: ?>
      <span style="width: 100px">
      <a href="index.php?app=user&amp;act=dailiadd&amp;id=<?php echo $this->_var['user']['id']; ?>">编辑</a> |<a href="javascript:drop_confirm('你确定要删除它吗？该操作不会删除ucenter及其他整合应用中的用户', 'index.php?app=user&amp;act=drop&amp;id=<?php echo $this->_var['user']['user_id']; ?>');">删除</a>
       
      </span>
      </td>
      <?php endif; ?>
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
      <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=user&act=drop" presubmit="confirm('你确定要删除它吗？该操作不会删除ucenter及其他整合应用中的用户');" />
    </div>
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    <div class="clear"></div>
  </div>
  <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>