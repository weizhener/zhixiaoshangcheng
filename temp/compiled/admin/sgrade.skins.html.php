<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>店铺等级</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=sgrade">管理</a></li>
    <li> <a class="btn1" href="index.php?app=sgrade&amp;act=add">新增</a> </li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data">
    <ul style="margin: 5px; width:100%"><?php $_from = $this->_var['skins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'skin');if (count($_from)):
    foreach ($_from AS $this->_var['skin']):
?>
      <li style="float: left; text-align: center; margin: 5px;"><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['skin']['screenshot']; ?>" target="_blank"><img style="border: 1px solid #ccc;" src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['skin']['preview']; ?>" width="160" height="120" /></a><br />
        <input type="checkbox" name="skins[]" value="<?php echo $this->_var['skin']['value']; ?>" <?php if ($this->_var['skin']['checked']): ?>checked="checked"<?php endif; ?> />
      </li>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <div class="clear"></div>
    <table class="infoTable">
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" />
        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 