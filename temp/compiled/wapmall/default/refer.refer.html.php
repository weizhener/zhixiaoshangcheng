<?php echo $this->fetch('member.header.html'); ?>

<div class="mb-head">

    <a href="javascript:history.back(-1)" class="l_b">返回</a>

    <div class="tit">推荐成员</div>

    <a href="javascript" class="r_b"></a>

</div>

<?php echo $this->fetch('member.submenu.html'); ?>



<div class="table">

    <table>

        <tbody>

            <tr>

                <th style="width:50%">会员名</th>

                <th style="width:30%">注册时间</th>

            </tr>

            <?php $_from = $this->_var['refers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'refer');$this->_foreach['fe_refer'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_refer']['total'] > 0):
    foreach ($_from AS $this->_var['refer']):
        $this->_foreach['fe_refer']['iteration']++;
?>

            <tr>


                <td><?php echo htmlspecialchars($this->_var['refer']['user_name']); ?></td>

                <td><?php echo local_date("Y-m-d",$this->_var['refer']['reg_time']); ?></td>

            </tr>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        </tbody>

    </table>

</div>





<?php echo $this->fetch('member.page.bottom.html'); ?>





<?php echo $this->fetch('member.footer.html'); ?>