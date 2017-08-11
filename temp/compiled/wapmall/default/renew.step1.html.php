<?php echo $this->fetch('header.html'); ?>



<div class="mb-head">

    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>

    <div class="tit">店铺续费</div>

    <a href="javascript" class="r_b"></a>

</div>





<style>

    .apply_step1{border-radius: 5px;position: relative;border: #aaa solid 1px;background: #fff;overflow: hidden;color: #6b6b6b;margin: 0px 10px 0;font-size: 14px;margin-top:10px;}

    .apply_step1 tr{height: 50px;}

    .apply_step1 th{height: 35px;}

    .apply_step1 td{text-align: center;line-height: 35px;}

</style>

<div class="apply_step1">

    <table style="width: 100%">

        <?php $_from = $this->_var['sgrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgrade');if (count($_from)):
    foreach ($_from AS $this->_var['sgrade']):
?>
<?php if ($this->_var['sgrade']['grade_id'] != 6): ?>
        <tr>

            <th><?php echo $this->_var['sgrade']['grade_name']; ?></th>
			
			<td><?php echo $this->_var['sgrade']['charge']; ?>元</td>

            <td>

                <p>需要审核: <span class="fontColor1"><?php if ($this->_var['sgrade']['need_confirm']): ?>是<?php else: ?>否<?php endif; ?></span></p>

            </td>

            <td><a href="<?php echo url('app=renew&step=2&id=' . $this->_var['sgrade']['grade_id']. ''); ?>" class="red_btn" style="width:6em; height:1em; line-height:1em; font-size:1em;">立即续费</a>

            </td>

        </tr>
<?php endif; ?>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </table>

</div>









<?php echo $this->fetch('footer.html'); ?>