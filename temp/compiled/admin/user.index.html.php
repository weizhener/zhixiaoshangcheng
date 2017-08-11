<?php echo $this->fetch('header.html'); ?>

<div id="rightTop">

  <p>会员管理</p>

  <ul class="subnav">

    <li><span>管理</span></li>

    <!--<li><a class="btn1" href="index.php?app=user&amp;act=weixin">微信会员</a></li>-->

    <li><a class="btn1" href="index.php?app=user&amp;act=add">新增</a></li>

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

    <?php if ($this->_var['users']): ?>

    <tr class="tatr1">

      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>

      <td>会员名 | 真实姓名</td>
	  
	  <td>推荐人</td>

      <td><span ectype="order_by" fieldname="email">电子邮箱</span></td>

      <td>即时通讯</td>

      <td><span ectype="order_by" fieldname="reg_time">注册时间</span></td>

      <td><span ectype="order_by" fieldname="last_login">最后登录</span></td>

      <td><span ectype="order_by" fieldname="logins">登录次数</span></td>

      <td>是否是管理员</td>

      <td class="handler">操作</td>

    </tr>

    <?php endif; ?>

    <?php $_from = $this->_var['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>

    <tr class="tatr2">

      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['user']['user_id']; ?>" /></td>

      <td><?php echo htmlspecialchars($this->_var['user']['user_name']); ?> | <?php echo htmlspecialchars($this->_var['user']['real_name']); ?></td>
	  
	  <td><?php echo htmlspecialchars($this->_var['user']['_user_name']); ?> | <?php echo htmlspecialchars($this->_var['user']['_real_name']); ?></td>

      <td><?php echo htmlspecialchars($this->_var['user']['email']); ?></td>

      <td> <?php if ($this->_var['user']['im_qq']): ?>QQ: <?php echo htmlspecialchars($this->_var['user']['im_qq']); ?><br />

        <?php endif; ?>

        <?php if ($this->_var['user']['im_msn']): ?>MSN: <?php echo htmlspecialchars($this->_var['user']['im_msn']); ?><br />

        <?php endif; ?></td>

      <td><?php echo local_date("Y-m-d",$this->_var['user']['reg_time']); ?></td>

      <td><?php if ($this->_var['user']['last_login']): ?><?php echo local_date("Y-m-d",$this->_var['user']['last_login']); ?><?php endif; ?><br />

        <?php echo $this->_var['user']['last_ip']; ?></td>

      <td><?php echo $this->_var['user']['logins']; ?></td>

      <td><?php if ($this->_var['user']['if_admin']): ?>  是

      <?php else: ?><a href="index.php?app=admin&amp;act=add&amp;id=<?php echo $this->_var['user']['user_id']; ?>" onclick="parent.openItem('admin_manage', 'user');">设为管理员</a><?php endif; ?>

      </td>

      <td class="handler">

      <?php if (! $this->_var['if_system_manager'] && $this->_var['user']['privs'] == all): ?>系统管理员

      </td>

      <?php else: ?>

      <span style="width: 100px">

      <a href="index.php?app=user&amp;act=edit&amp;id=<?php echo $this->_var['user']['user_id']; ?>">编辑</a> | <a href="index.php?app=user&amp;act=super_login&amp;user_id=<?php echo $this->_var['user']['user_id']; ?>" target=_blank>登陆</a> |<a href="javascript:drop_confirm('你确定要删除它吗？该操作不会删除ucenter及其他整合应用中的用户', 'index.php?app=user&amp;act=drop&amp;id=<?php echo $this->_var['user']['user_id']; ?>');">删除</a>

        <?php if ($this->_var['user']['store_id']): ?>

        | <a href="index.php?app=store&amp;act=edit&amp;id=<?php echo $this->_var['user']['store_id']; ?>" onclick="parent.openItem('store_manage', 'store');">店铺</a>

        <?php endif; ?>

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