<div class="table_common">
    <table>
        <tr class="bg2">
            <th>买家</th>
            <th>购买价</th>
            <th>购买数量</th>
            <th>购买时间</th>
            <th>评价</th>
        </tr>
        <?php $_from = $this->_var['sales_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sales');if (count($_from)):
    foreach ($_from AS $this->_var['sales']):
?>
        <tr>
            <td><?php if ($this->_var['sales']['anonymous']): ?>***<?php else: ?><?php echo htmlspecialchars($this->_var['sales']['buyer_name']); ?><?php endif; ?><img src="<?php echo $this->_var['sales']['buyer_credit_image']; ?>" title="<?php echo $this->_var['sales']['buyer_credit_value']; ?>" /></td>
            <td><?php echo price_format($this->_var['sales']['price']); ?></td>
            <td><?php echo $this->_var['sales']['quantity']; ?> <span class="fontColor5"><?php if ($this->_var['sales']['specification']): ?>（<?php echo htmlspecialchars($this->_var['sales']['specification']); ?>）<?php endif; ?></span></td>
            <td><?php echo local_date("Y-m-d",$this->_var['sales']['add_time']); ?></td>
            <td><?php if ($this->_var['sales']['evaluation'] > 0): ?><img src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
                <?php if ($this->_var['sales']['evaluation'] > 1): ?><img src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
                <?php if ($this->_var['sales']['evaluation'] > 2): ?><img src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
                <?php if ($this->_var['sales']['evaluation'] < 3): ?><img src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?>
                <?php if ($this->_var['sales']['evaluation'] < 2): ?><img src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?>
                <?php if ($this->_var['sales']['evaluation'] < 1): ?><img src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?> </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="6"><span class="light">没有符合条件的记录</span></td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
