<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">

        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">
            <div class="eject_btn" title="免费发布信息"><b class="ico1" onclick="go('index.php?app=supply_demand&amp;act=add');">免费发布信息</b></div>

            <div class="public table">
                <table class="table_head_line">
                    <?php if ($this->_var['sdinfo']): ?>
                    <tr class="line_bold">
                        <th colspan="8"></th>
                    </tr>
                    <tr class="line tr_color">
                        <th>标题</th>
                        <th>所属分类</th>
                        <th>价格</th>
                        <th>联系人</th>
                        <th>手机或电话</th>
                        <th>审核状态</th>
                        <th>审核说明</th>
                        <th>操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['sdinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'info');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['info']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold tr_align"><?php else: ?><tr class="line tr_align"><?php endif; ?>
                        <td><a href="<?php echo url('app=sdemand&act=view&id=' . $this->_var['info']['id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['info']['title']); ?></a></td>
                        <td><?php echo htmlspecialchars($this->_var['info']['cate_name']); ?></td>
                        <td><?php if ($this->_var['info']['type'] == 2): ?><?php if ($this->_var['info']['price_from'] == 0 && $this->_var['info']['price_to'] == 0): ?>面议<?php else: ?><?php echo price_format($this->_var['info']['price_from']); ?> - <?php echo price_format($this->_var['info']['price_to']); ?><?php endif; ?><?php else: ?><?php if ($this->_var['info']['price'] == 0): ?>面议<?php else: ?><?php echo price_format($this->_var['info']['price']); ?><?php endif; ?><?php endif; ?></td>
                        <td><?php echo htmlspecialchars($this->_var['info']['name']); ?></td>
                        <td><?php echo $this->_var['info']['phone']; ?></td>
                        <td class="align2">
                            <?php if ($this->_var['info']['verify'] == 1): ?>
                            <font color="#006633">已通过</font>
                            <?php elseif ($this->_var['info']['verify'] == 2): ?>
                            <font color="red">未通过</font>
                            <?php else: ?>
                            <font color="#FF6666">审核中</font>
                            <?php endif; ?>
                        </td>
                        <td class="align2"><font color="#999"><?php echo $this->_var['info']['verify_desc']; ?></font></td>
                        <td> <a href="index.php?app=supply_demand&act=edit&id=<?php echo $this->_var['info']['id']; ?>" class="edit1 float_none">编辑</a>
                            <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=supply_demand&amp;act=drop&id=<?php echo $this->_var['info']['id']; ?>');" class="delete float_none">删除</a></td>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8" class="member_no_records padding6"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的记录</td>
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
<?php echo $this->fetch('footer.html'); ?>
