<?php echo $this->fetch('member.header.html'); ?>



<div class="content">

    <?php echo $this->fetch('member.menu.html'); ?>

    <div id="right">

        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">

            <div class="public table">

                <table class="table_head_line">

                    <tbody>

                        <?php if ($this->_var['integral_goods_log_list']): ?>

                        <tr class="line_bold">

                            <th class="align1" colspan="7">

                            </th>

                        </tr>

                        <tr class="line tr_color">

                            <th class="align1">物品名称</th>

                            <th>收货信息</th>

                            <th>银行信息</th>

                            <th align="center">操作时间</th>

                            <th align="center">当前状态</th>

                        </tr>

                        <?php endif; ?>

                        <?php $_from = $this->_var['integral_goods_log_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'integral_goods_log');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['integral_goods_log']):
        $this->_foreach['v']['iteration']++;
?>

                        <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>              

                            <td class="link1"><?php echo htmlspecialchars($this->_var['integral_goods_log']['goods_name']); ?></td>

                            <td align="center">收货人：<?php echo htmlspecialchars($this->_var['integral_goods_log']['my_name']); ?><br />收货地址：<?php echo htmlspecialchars($this->_var['integral_goods_log']['my_address']); ?><br />联系电话：<?php echo htmlspecialchars($this->_var['integral_goods_log']['my_mobile']); ?></td>
							
							
	                            <td align="center">银行户名：<?php echo htmlspecialchars($this->_var['integral_goods_log']['truename']); ?><br />开户银行：<?php echo htmlspecialchars($this->_var['integral_goods_log']['bankname']); ?><br />开户行名称：<?php echo htmlspecialchars($this->_var['integral_goods_log']['bankadd']); ?><br />银行卡号：<?php echo htmlspecialchars($this->_var['integral_goods_log']['bankcard']); ?></td>


                            <td align="center"><?php echo local_date("Y-m-d H:i:s",$this->_var['integral_goods_log']['add_time']); ?></td>

                            <td align="center"><?php echo htmlspecialchars($this->_var['integral_goods_log']['state']); ?>
							
							
							<?php if ($this->_var['integral_goods_log']['state'] == '待发货'): ?>
							
							<a href='index.php?app=my_integral_goods&act=tui&id=<?php echo $this->_var['integral_goods_log']['id']; ?>' style="color:#FF0000;">退货</a>
							
							
							<?php endif; ?>  
							</td>

                        </tr>

                        <?php endforeach; else: ?>

                        <tr>

                            <td colspan="7" class="member_no_records">没有符合条件的记录</td>

                        </tr>

                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

                    </tbody>

                </table>

                <?php echo $this->fetch('member.page.bottom.html'); ?>

                <div class="clear"></div>

            </div>

            <div class="wrap_bottom"></div>

        </div>

        <div class="clear"></div>

    </div>

    <div class="clear"></div>

</div>

<?php echo $this->fetch('footer.html'); ?>

