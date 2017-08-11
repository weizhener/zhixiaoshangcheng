<div id="left">
    <?php $_from = $this->_var['_member_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');$this->_foreach['fe_item'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_item']['total'] > 0):
    foreach ($_from AS $this->_var['item']):
        $this->_foreach['fe_item']['iteration']++;
?>
    <?php if ($this->_var['item']['submenu']): ?>
    <dl class="menu">
        <dt <?php if (($this->_foreach['fe_item']['iteration'] <= 1)): ?> class="first"<?php endif; ?>><b></b><span><?php echo $this->_var['item']['text']; ?></span></dt>
        <?php $_from = $this->_var['item']['submenu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'subitem');if (count($_from)):
    foreach ($_from AS $this->_var['subitem']):
?>
        <dd><a href="<?php echo $this->_var['subitem']['url']; ?>" class="<?php if ($this->_var['subitem']['name'] == $this->_var['_curitem']): ?>active<?php else: ?>normal<?php endif; ?>"><span><?php echo $this->_var['subitem']['text']; ?></span></a></dd>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </dl>
    <?php endif; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>

