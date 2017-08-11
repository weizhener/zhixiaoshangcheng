<?php echo $this->fetch('header.html'); ?>
<div class="main">
	<div class="fixed-bar">
		<div class="item-title">
			<h3><a href="index.php?act=welcome" style="text-decoration:none;"><?php echo $this->_var['setting']['site_name']; ?></a> &nbsp;>&nbsp;报表统计&nbsp;&nbsp;>&nbsp;&nbsp; 客户统计</h3>
		</div>
	</div>
	<div class="fixed-empty"></div>
	<div class="list-div">
	  <table width="100%" cellspacing="1" cellpadding="3">
		<tr>
		<th colspan="5" align="left" style="padding-left:10px;">
		会员购买率<span style="font:12px;color:#777;">（会员购买率 = 有订单会员数 ÷ 会员总数）</span>
		</th>
		</tr>
		<tr align="center">
		  <td>会员总数</td>
		  <td>有订单会员数</td>
		  <td>会员订单总数</td>
		  <td>会员购买率</td>
		</tr>
		<tr align="center">
		  <td><?php echo $this->_var['user_num']; ?></td>
		  <td><?php echo $this->_var['have_order_usernum']; ?></td>
		  <td><?php echo $this->_var['user_all_order']; ?></td>
		  <td><?php echo $this->_var['user_ratio']; ?>%</td>
		</tr>
	  </table>
	</div>
	<div class="list-div">
	  <table width="100%" cellspacing="1" cellpadding="3">
		<tr>
		<th colspan="5" align="left" style="padding-left:10px;">
		每会员平均订单数及购物额<span style="font:12px;color:#777;">（每会员订单数 = 会员订单总数 ÷ 会员总数）
		（每会员购物额 = 会员购物总额 ÷ 会员总数）</span>
		</th>
		</tr>
		<tr align="center">
		  <td>会员购物总额</td>
		  <td>每会员订单数</td>
		  <td>每会员购物额</td>
		</tr>
		<tr align="center">
		  <td><?php echo price_format($this->_var['order_amount']); ?></td>
		  <td><?php echo $this->_var['ave_user_ordernum']; ?></td>
		  <td><?php echo price_format($this->_var['ave_user_turnover']); ?></td>
		</tr>
	  </table>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>
