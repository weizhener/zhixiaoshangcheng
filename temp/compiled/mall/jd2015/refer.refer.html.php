<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public_select table">
                <table>
                    <tr class="gray">
                        <th>ID</th><th>用户名</th><th>真实姓名</th><th>QQ</th><th>手机号</th><th>注册时间</th>
                    </tr>
                    <?php if ($this->_var['refers']): ?>
                    <?php $_from = $this->_var['refers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'refer');$this->_foreach['fe_refer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_refer']['total'] > 0):
    foreach ($_from AS $this->_var['refer']):
        $this->_foreach['fe_refer']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['fe_refer']['iteration'] == $this->_foreach['fe_refer']['total'])): ?> last_line<?php endif; ?>">
                        <td class="align2"><?php echo $this->_var['refer']['user_id']; ?></td>
                        <td class="align2"><?php echo htmlspecialchars($this->_var['refer']['user_name']); ?></td>
                        <td class="align2"><?php echo htmlspecialchars($this->_var['refer']['real_name']); ?></td>
                        <td class="align2"><?php echo htmlspecialchars($this->_var['refer']['im_qq']); ?></td>
                        <td class="align2"><?php echo htmlspecialchars($this->_var['refer']['phone_mob']); ?></td>
                        <td class="align2"><?php echo local_date("Y-m-d",$this->_var['refer']['reg_time']); ?></td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="7">没有符合条件的记录</td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <th colspan="7">
                        </th>
                    </tr>
                    <tr>
                        <th colspan="7">
                            <?php echo $this->fetch('member.page.bottom.html'); ?>
                        </th>
                    </tr>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
