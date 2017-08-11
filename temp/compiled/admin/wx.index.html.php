<?php echo $this->fetch('header.html'); ?>
<div class="main">

    
    <div id="rightTop">
  <p>会员管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=user">管理</a></li>
    	<li><span> 微信会员 </span></li>
    <li><a class="btn1" href="index.php?app=user&amp;act=add">新增</a></li>
  </ul>
</div>
	<div class="fixed-empty"></div>
    
    
    
	<div class="mrightTop">
	  <div class="fontl">
		<form method="get" name="search_form">
		   <div class="left">
			  <input type="hidden" name="app" value="user" />
			  <input type="hidden" name="act" value="weixin" />
			  <select class="querySelect" name="field_name"><?php echo $this->html_options(array('options'=>$this->_var['query_fields'],'selected'=>$_GET['field_name'])); ?>
			  </select>
			  <input class="queryInput" type="text" name="field_value" value="<?php echo htmlspecialchars($_GET['field_value']); ?>" />
			  排序:
			  <select class="querySelect" name="sort"><?php echo $this->html_options(array('options'=>$this->_var['sort_options'],'selected'=>$_GET['sort'])); ?>
			  </select>
			   <a href="JavaScript:void(0);" class="btn-search" onclick="document.search_form.submit()">查询</a>
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
		
	 <td>性别</td>
         <td>头像</td>
         
           <td>地区</td>
		  <td>关注时间</td>

		  <td>操作</td>
		</tr>
		<?php endif; ?>
		<?php $_from = $this->_var['users']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'user');if (count($_from)):
    foreach ($_from AS $this->_var['user']):
?>
		<tr class="tatr2">
		  <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['user']['user_id']; ?>" /></td>
		  <td><?php echo htmlspecialchars($this->_var['user']['user_name']); ?> | <?php echo htmlspecialchars($this->_var['user']['nickname']); ?></td>
	
         <td>
         <?php if ($this->_var['user']['subscribe']): ?>
         
         男
         <?php else: ?>
         女
         <?php endif; ?>
         </td>
    
        

        <td>
        
      <?php if ($this->_var['user']['headimgurl']): ?>
     
         <img width="50" height="50" src="<?php echo $this->_var['user']['headimgurl']; ?>"  />
       <?php else: ?>
        
             <img width="50" height="50" src="../data/files/mall/settings/default_user_portrait.gif?600906552"  />
       <?php endif; ?>
        
        
        
        
        </td>
        
             <td><?php echo htmlspecialchars($this->_var['user']['country']); ?> &nbsp;<?php echo htmlspecialchars($this->_var['user']['city']); ?></td>
      <td><?php echo local_date("Y.m.d H:i:s",$this->_var['user']['subscribe_time']); ?></td>
   
		
	      <td><a href="index.php?app=user&act=view&wxid=<?php echo $this->_var['user']['wxid']; ?>" > 查看消息</a> | <a href="index.php?app=user&act=send&wxid=<?php echo $this->_var['user']['wxid']; ?>">回复消息</a></td>


		
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
			<a href="javaScript:void(0);" class="formbtn batchButton" name="id" uri="index.php?app=user&act=drop" presubmit="confirm('你确定要删除它吗？该操作不会删除ucenter及其他整合应用中的用户')"><span>删除</span></a>
		</div>
		<div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
		<div class="clear"></div>
	  </div>
	  <?php endif; ?>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>