<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right">
    <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="eject_btn_two eject_pos1" title="添加运费模板"><b class="ico1" onclick="go('index.php?app=my_delivery&amp;act=add');">添加运费模板</b></div>
            <!--<div class="eject_btn_two eject_pos2" title="添加运费模板"><b class="ico2" onclick="go('index.php?app=my_delivery&amp;act=add');">添加运费模板</b></div>-->
            <div class="public_select table">

<div class="info2">
    <?php $_from = $this->_var['deliverys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'delivery');if (count($_from)):
    foreach ($_from AS $this->_var['delivery']):
?>
    <div  class="section">
    	<div class="tbl-prefix clearfix" >
        	<span class="meta">
            	<span>添加时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['delivery']['created']); ?></span>
                <a href="<?php echo url('app=my_delivery&act=copy_tpl&id=' . $this->_var['delivery']['template_id']. ''); ?>" onclick="return confirm('您确定要复制该运费模板吗？');">复制模板</a>
                <a href="<?php echo url('app=my_delivery&act=edit&id=' . $this->_var['delivery']['template_id']. ''); ?>">修改</a>
                <a href="<?php echo url('app=my_delivery&act=drop&id=' . $this->_var['delivery']['template_id']. ''); ?>" onclick="return confirm('删除后无法恢复，您确定要删除该运费模板吗？');">删除</a>
            </span>
            <h3 class="name"><strong><?php echo $this->_var['delivery']['name']; ?></strong></h3>
         </div>
         <div class="tbl-entity">
		 	<table border="0" cellpadding="0" cellspacing="0">
            	<?php $_from = $this->_var['delivery']['area_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');$this->_foreach['fe_item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_item']['total'] > 0):
    foreach ($_from AS $this->_var['item']):
        $this->_foreach['fe_item']['iteration']++;
?>
                <?php if (($this->_foreach['fe_item']['iteration'] <= 1)): ?>
                <tr class="tbl-head">
            		<th>运送方式</th>
                	<th class="cell-area">运送到</th>
					<th>首件(个)</th>
                	<th>运费(元)</th>
					<th>续件(个)</th>
                	<th>运费(元)</th>
             	</tr>
                <?php endif; ?>
        		<tr class="tbl-col">
					<td><?php echo $this->_var['lang'][$this->_var['item']['type']]; ?></td>
                	<td class="cell-area"><?php echo $this->_var['item']['dests']; ?></td>
                	<td><?php echo $this->_var['item']['start_standards']; ?></td>
                	<td><?php echo $this->_var['item']['start_fees']; ?></td>
                	<td><?php echo $this->_var['item']['add_standards']; ?></td>
                	<td><?php echo $this->_var['item']['add_fees']; ?></td>
            	</tr>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         	</table>
       </div>
	</div>
    <?php endforeach; else: ?>
    <div class="notice-word">没有符合条件的记录</div>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php if ($this->_var['deliverys']): ?><div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div><?php endif; ?>
</div>
</div>
</div>
</div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>