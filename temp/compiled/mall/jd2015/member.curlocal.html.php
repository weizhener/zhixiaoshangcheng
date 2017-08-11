<?php if ($this->_var['_curlocal']): ?>
<div class="location">
	<?php $_from = $this->_var['_curlocal']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'lnk');if (count($_from)):
    foreach ($_from AS $this->_var['lnk']):
?>
	<?php if ($this->_var['lnk']['url']): ?>
	<a href="<?php echo $this->_var['lnk']['url']; ?>"><?php echo htmlspecialchars($this->_var['lnk']['text']); ?></a>
	<?php else: ?>
	<?php echo htmlspecialchars($this->_var['lnk']['text']); ?>
	<?php endif; ?>
	<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
	</div>
<?php endif; ?>

