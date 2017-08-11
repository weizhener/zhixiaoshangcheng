<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">所有成员</div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>

<div class="table">
    <table>
        <?php if ($this->_var['all_refers']): ?>
        <?php $_from = $this->_var['all_refers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'refer');$this->_foreach['fe_refer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_refer']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['refer']):
        $this->_foreach['fe_refer']['iteration']++;
?>
        <tr>
            <td style="text-align: left;">
                <?php echo $this->_var['refer']; ?>&nbsp;&nbsp;&nbsp;(ID:<?php echo $this->_var['key']; ?>)
            </td>
        </tr>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php endif; ?>
    </table>
</div>



<?php echo $this->fetch('member.footer.html'); ?>