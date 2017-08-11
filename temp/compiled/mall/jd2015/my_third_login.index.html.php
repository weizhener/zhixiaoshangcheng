<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public_index table1">
                <table>
                    <tbody>
                    <?php if ($this->_var['third_logins']): ?>
                    <tr class="line tr_bgcolor">
                        <th>绑定类型</th>
                        <th>绑定时间</th>
                        <th>最后登录时间</th>
                        <th>操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['third_logins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'third_login');$this->_foreach['fe_third_login'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_third_login']['total'] > 0):
    foreach ($_from AS $this->_var['third_login']):
        $this->_foreach['fe_third_login']['iteration']++;
?>
                    <tr style="height: 50px;">
                        <td class="align2"><?php echo $this->_var['third_login']['third_name']; ?></td>
                        <td class="align2"><?php echo local_date("Y-m-d H:i:s",$this->_var['third_login']['add_time']); ?></td>
                        <td class="align2"><?php echo local_date("Y-m-d H:i:s",$this->_var['third_login']['update_time']); ?></td>
                        <td class="align2"><a href="<?php echo url('app=my_third_login&act=drop&id=' . $this->_var['third_login']['id']. ''); ?>">解绑</a></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="member_no_records">此帐号未绑定任何第三方登录帐号进行登录</td></tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </tbody>
                </table>
              </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>