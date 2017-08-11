<?php echo $this->fetch('footer_order_notice.html'); ?>
<div id="footer" class="w">
   <div class="foot-group">

   </div>
   <div class="foot-copyright"><?php echo $this->_var['copyright']; ?><br/><?php if ($this->_var['icp_number']): ?><?php echo $this->_var['icp_number']; ?><?php endif; ?> <?php echo $this->_var['statistics_code']; ?></div>
	<div class="foot-parter mb20">
		<a href="javascript:;"><img src="static/images/bt_logo_1.png" /></a>
		<a href="javascript:;"><img src="static/images/bt_logo_2.png" /></a>
		<a href="javascript:;"><img src="static/images/bt_logo_3.png" /></a>
	</div>
</div>
<?php echo $this->_var['store']['statistics_url']; ?>
<?php echo $this->_var['async_sendmail']; ?>
</body>
</html>