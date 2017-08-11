<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<div class="main">
	<div class="fixed-bar">
		<div class="item-title">
			<h3><a href="index.php?act=welcome" style="text-decoration:none;"><?php echo $this->_var['setting']['site_name']; ?></a> &nbsp;>&nbsp;报表统计&nbsp;&nbsp;>&nbsp;&nbsp; 会员排行</h3>
		</div>
	</div>
	<div class="fixed-empty"></div>
	<div class="mrightTop">
		<div class="fontl">
			<form method="get" name="search_form">
				 <div class="left">
					<input type="hidden" name="app" value="user_order" />
					<input type="hidden" name="act" value="index" />


				   开始日期:
					<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
					结束日期:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />

					 <a href="JavaScript:void(0);" class="btn-search" onclick="document.search_form.submit()">查询</a>
				</div>
				<?php if ($this->_var['filtered']): ?>
				<a class="left formbtn1" href="index.php?app=user_order">撤销检索</a>
				<?php endif; ?>
			</form>
		</div>
		<div class="fontr">
			<?php if ($this->_var['orders']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
		</div>
	</div>
	<div class="tdare">
		<table width="100%" cellspacing="0" class="dataTable">
			<?php if ($this->_var['orders']): ?>
			<tr class="tatr1">
				<td width="15%" class="firstCell"><span>排行</span></td>
				<td width="10%"><span>买家名称</span></td>
				<td width="15%"><span>订单数</span></td>
				<td width="15%"><span>订单总价</span></td>
			</tr>
			<?php endif; ?>
			<?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');$this->_foreach['val'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['val']['total'] > 0):
    foreach ($_from AS $this->_var['order']):
        $this->_foreach['val']['iteration']++;
?>
			<tr class="tatr2">
				<td><?php echo $this->_foreach['val']['iteration']; ?></td>
				<td ><?php echo htmlspecialchars($this->_var['order']['buyer_name']); ?></td>
				<td><?php echo htmlspecialchars($this->_var['order']['have_order_num']); ?></td>

				<td><?php echo price_format($this->_var['order']['order_all_amount']); ?></td>
			</tr>
			<?php endforeach; else: ?>
			<tr class="no_data">
				<td colspan="7">没有符合条件的记录</td>
			</tr>
			<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</table>
		<div id="dataFuncs">
			<div class="pageLinks">
				<?php if ($this->_var['orders']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>
