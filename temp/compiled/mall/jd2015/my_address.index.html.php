<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
		<?php echo $this->fetch('member.curlocal.html'); ?>
        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">
            <div class="eject_btn" title="新增地址"><b class="ico1" ectype="dialog" dialog_title="新增地址" dialog_id="my_address_add" dialog_width="600" uri="index.php?app=my_address&act=add">新增地址</b></div>

            <div class="public table">
                <table class="table_head_line">
                    <?php if ($this->_var['addresses']): ?>
                    <tr class="line_bold">
                        <th colspan="6"></th>
                    </tr>
                    <tr class="gray line tr_color">
                        <th>收货人姓名</th>
                        <th>所在地区</th>
                        <th class="width3">详细地址</th>
                        <th>邮政编码</th>
                        <th class="width5">电话/手机</th>
                        <th>操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['addresses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'address');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['address']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold tr_align"><?php else: ?><tr class="line tr_align"><?php endif; ?>
                        <td><?php echo htmlspecialchars($this->_var['address']['consignee']); ?></td>
                        <td><?php echo htmlspecialchars($this->_var['address']['region_name']); ?></td>
                        <td><?php echo htmlspecialchars($this->_var['address']['address']); ?></td>
                        <td><?php echo htmlspecialchars($this->_var['address']['zipcode']); ?></td>
                        <td><?php echo $this->_var['address']['phone_tel']; ?> / <?php echo $this->_var['address']['phone_mob']; ?></td>
                        <td> <a href="javascript:void(0);" ectype="dialog" dialog_id="my_address_edit" dialog_title="编辑地址" dialog_width="700" uri="index.php?app=my_address&act=edit&addr_id=<?php echo $this->_var['address']['addr_id']; ?>" class="edit1 float_none">编辑</a>
                            <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_address&amp;act=drop&addr_id=<?php echo $this->_var['address']['addr_id']; ?>');" class="delete float_none">删除</a></td>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="member_no_records padding6"><?php echo $this->_var['lang'][$_GET['act']]; ?>您没有添加收货地址</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>

        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>

    <div class="clear"></div>




</div>
<iframe id='iframe_post' name="iframe_post" frameborder="0" width="0" height="0">
</iframe>
<?php echo $this->fetch('footer.html'); ?>
