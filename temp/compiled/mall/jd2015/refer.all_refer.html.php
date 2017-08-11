<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public">
                <div class="information">
                    <div class="info">
                        <table>
                            <tr>
                                <td>
                                    <?php if ($this->_var['all_refers']): ?>
                                    <?php $_from = $this->_var['all_refers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'refer');$this->_foreach['fe_refer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_refer']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['refer']):
        $this->_foreach['fe_refer']['iteration']++;
?>
                                    <span style="line-height: 30px;height: 30px;display: block"><?php echo $this->_var['refer']; ?>&nbsp;&nbsp;&nbsp;(ID:<?php echo $this->_var['key']; ?>)</span>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    <?php else: ?>
                                    <div class="align2 member_no_records padding6">没有符合条件的记录</div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="wrap_bottom"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
