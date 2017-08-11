<div class="submenu">
    <ul class="tab">
        <?php $_from = $this->_var['_member_submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', '_s_m');$this->_foreach['member_submenu'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['member_submenu']['total'] > 0):
    foreach ($_from AS $this->_var['_s_m']):
        $this->_foreach['member_submenu']['iteration']++;
?>
        <?php if ($this->_var['_curmenu'] == $this->_var['_s_m']['name']): ?>
        <a href="javascript:;"><li class="active <?php if (($this->_foreach['member_submenu']['iteration'] <= 1)): ?>first<?php endif; ?>"><?php echo $this->_var['_s_m']['text']; ?><span></span></li></a>
        <?php else: ?>
        <a href="<?php echo $this->_var['_s_m']['url']; ?>"><li class="normal <?php if (($this->_foreach['member_submenu']['iteration'] <= 1)): ?>first<?php endif; ?>"><?php echo $this->_var['_s_m']['text']; ?><span></span></li></a>
        <?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</div>