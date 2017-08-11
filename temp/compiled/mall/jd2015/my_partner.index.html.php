<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="<?php echo $this->_var['charset']; ?>"></script>
        <div class="wrap">
            <div class="eject_btn_two eject_pos1" ><b class="ico4" ectype="dialog" dialog_id="my_partner_add" dialog_width="460" dialog_title="新增合作伙伴" uri="index.php?app=my_partner&amp;act=add">新增合作伙伴</b></div>
            <div class="public table">
                <table class="table_head_line">
                    <?php if ($this->_var['partners']): ?>
                    <tr class="line_bold">
                        <th class="width1"><input id="all" type="checkbox" class="checkall" /></th>
                        <th class="align1" colspan="5">
                            <span class="all"><label for="all">全选</label></span>
                            <a href="javascript:void(0);" class="delete" uri="index.php?app=my_partner&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a>
                        </th>
                    </tr>
                    <tr class="gray">
                        <th></th>
                        <th>标题</th>
                        <th>链接</th>
                        <th>标识</th>
                        <th>排序</th>
                        <th>操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['partners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'partner');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['partner']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                        <td class="align2"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['partner']['partner_id']; ?>" /></td>
                        <td><?php echo htmlspecialchars($this->_var['partner']['title']); ?></td>
                        <td class="color1"><?php echo $this->_var['partner']['link']; ?></td>
                        <td class="align2">
                        <?php if ($this->_var['partner']['logo']): ?>
                        <img src="<?php echo $this->_var['partner']['logo']; ?>" height="30"/>
                        <?php endif; ?>
                        </td>
                        <td class="align2"><span><?php echo $this->_var['partner']['sort_order']; ?></span></td>
                        <td class="width13">
                        <div class="">
                            <a href="javascript:void(0);" uri="index.php?app=my_partner&amp;act=edit&partner_id=<?php echo $this->_var['partner']['partner_id']; ?>" dialog_id="my_partner_edit" dialog_title="编辑" dialog_width="460" ectype="dialog" class="edit1">编辑</a><a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_partner&amp;act=drop&id=<?php echo $this->_var['partner']['partner_id']; ?>');" class="delete">删除</a>
                        </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="member_no_records padding6">没有符合条件的合作伙伴</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['partners']): ?>
                    <tr>
                        <th><input id="all2" type="checkbox" class="checkall" /></th>
                        <th colspan="5">
                        <p class="position1">
                            <span class="all"><label for="all2">全选</label></span>
                            <a href="javascript:void(0);" class="delete" uri="index.php?app=my_partner&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a>

                        </p>
                        <p class="position2">
                            <?php echo $this->fetch('member.page.bottom.html'); ?>
                        </p>
                        </th>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <iframe name="my_partner" style="display:none"></iframe>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
