<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
function selectAll(param)
{
    
    var obj = document.getElementById(param).getElementsByTagName('input');
    var obj1 = document.getElementById('h'+param);
    for (i = 0; i < obj.length; i++ )
    {
      obj[i].checked = obj1.checked;
    }
}
$(function(){
    $('#article_relate').click(function(){
        $('.relate').attr('checked', $(this).attr('checked'));
    });
});
</script>
<div id="rightTop">
  <p>管理员管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=admin">管理</a></li>
    <?php if ($this->_var['act'] == edit): ?>
    <li><a class="btn1" href="index.php?app=admin&amp;act=add">添加</a></li>
    <?php else: ?>
    <li><span>添加</span></li>
    <?php endif; ?>
  </ul>
</div>

<div class="mrightTop">
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data" id="admin_form">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> 用户名:</th><input type="hidden" name="priv" value="priv">
        <td class="paddingT15 wordSpacing5"><?php echo htmlspecialchars($this->_var['admin']['user_name']); ?></td>
      </tr>
       <?php $_from = $this->_var['priv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'priv1');$this->_foreach['privs1'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['privs1']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['priv1']):
        $this->_foreach['privs1']['iteration']++;
?>
           <tr id="<?php echo $this->_var['key']; ?>">
           <?php if (($this->_foreach['privs1']['iteration'] - 1) == 0): ?>
           <th class="paddingT15">权限管理</th>
           <?php else: ?>
           <th></th>
           <?php endif; ?>
           <td class="paddingT15 floatleft wordSpacing5" >
           <input type="checkbox" onclick="selectAll('<?php echo $this->_var['key']; ?>')" id="h<?php echo $this->_var['key']; ?>"><b><?php echo $this->_var['lang'][$this->_var['key']]; ?></b></td>
           <?php $_from = $this->_var['priv1']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key1', 'priv11');if (count($_from)):
    foreach ($_from AS $this->_var['key1'] => $this->_var['priv11']):
?>
            <td class="paddingT15 floatleft">
            <?php if ($this->_var['key1'] == 'article'): ?>
            <label><input type="checkbox" value="<?php echo $this->_var['priv11']['article']; ?>" id="article_relate" name="priv[<?php echo $this->_var['key1']; ?>]"
            <?php $_from = $this->_var['checked_priv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'check_priv');if (count($_from)):
    foreach ($_from AS $this->_var['check_priv']):
?>
                <?php if ($this->_var['check_priv'] == $this->_var['priv11']['article']): ?>
                checked
                <?php endif; ?> 
             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            ><?php echo $this->_var['lang'][$this->_var['key1']]; ?>
            </label>
            <div style="display:none;">
            <?php $_from = $this->_var['priv11']['upload']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key11', 'priv111');if (count($_from)):
    foreach ($_from AS $this->_var['key11'] => $this->_var['priv111']):
?>
            <label><input type="checkbox" value="<?php echo $this->_var['priv111']; ?>" class="relate" name="priv[<?php echo $this->_var['key11']; ?>]"
            <?php $_from = $this->_var['checked_priv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'check_priv');if (count($_from)):
    foreach ($_from AS $this->_var['check_priv']):
?>
                <?php if ($this->_var['check_priv'] == $this->_var['priv11']['article']): ?>
                checked
                <?php endif; ?> 
             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            >
            </label>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </div>
            <?php else: ?>
            <label><input type="checkbox" value="<?php echo $this->_var['priv11']; ?>" name="priv[<?php echo $this->_var['key1']; ?>]"
            <?php $_from = $this->_var['checked_priv']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'check_priv');if (count($_from)):
    foreach ($_from AS $this->_var['check_priv']):
?>
                <?php if ($this->_var['check_priv'] == $this->_var['priv11']): ?>
                checked
                <?php endif; ?> 
             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            ><?php echo $this->_var['lang'][$this->_var['key1']]; ?>
            </label>
            <?php endif; ?>    
            </td>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
           </tr>
        <?php endforeach; else: ?>
            <tr class="no_data">
            <td colspan="10">没有符合条件的记录</td>
            </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" />        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 