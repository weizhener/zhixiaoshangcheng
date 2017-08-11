<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>店铺排行榜</p>
  
</div>

<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['stores']): ?>
    <tr class="tatr1">
      
      <td>店铺名称</td>
      <td>总流量</td>

    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['stores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
    <tr class="tatr2">
    
      <td><?php echo htmlspecialchars($this->_var['store']['store_name']); ?> </td>
      <td><?php echo htmlspecialchars($this->_var['store']['hot']); ?></td>
     
    </tr>
    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="12">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </table>
  <?php if ($this->_var['stores']): ?>
  <div id="dataFuncs">
    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    
  </div>
  <div class="clear"></div>
  <?php endif; ?>

</div>
<?php echo $this->fetch('footer.html'); ?>