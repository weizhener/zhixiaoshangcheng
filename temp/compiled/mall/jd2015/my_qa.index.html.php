<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
		<?php echo $this->fetch('member.submenu.html'); ?>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="<?php echo $this->_var['charset']; ?>"></script>
        <div class="wrap">
            <div class="public_index table1">
                <table>
                    <?php if ($this->_var['my_qa_data']): ?>
                    <tr class="line_bold">
                        <th class="width1"><input id="all" type="checkbox" class="checkall" /></th>
                        <th class="align1" colspan="3">
                            <label for="all"><span class="all">全选</span></label>
                            <a href="javascript:void(0);" class="delete" ectype="batchbutton" uri="index.php?app=my_qa&amp;act=drop" name="id" presubmit="confirm('您确定要删除这些咨询吗')">删除</a>
                        </th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['my_qa_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'my_qa_list');$this->_foreach['qa'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['qa']['total'] > 0):
    foreach ($_from AS $this->_var['my_qa_list']):
        $this->_foreach['qa']['iteration']++;
?>
                    <tr class="bgcolor">
                        <td class="align2"><input type="checkbox"  value="<?php echo $this->_var['my_qa_list']['ques_id']; ?>" class="checkitem" /></td>
                        <td >
                        <a href="<?php if ($this->_var['my_qa_list']['type'] == 'goods'): ?><?php echo url('app=' . $this->_var['my_qa_list']['type']. '&id=' . $this->_var['my_qa_list']['item_id']. '&act=qa'); ?><?php else: ?><?php echo url('app=' . $this->_var['my_qa_list']['type']. '&id=' . $this->_var['my_qa_list']['item_id']. ''); ?><?php endif; ?>" target="_blank" class="link3"><?php echo $this->_var['my_qa_list']['item_name']; ?></a> &nbsp;&nbsp;[<?php echo $this->_var['lang'][$this->_var['my_qa_list']['type']]; ?>]
                        </td>
                        <td width="150">
                            <span class="table_user"><?php if ($this->_var['my_qa_list']['user_name'] != ''): ?><?php echo htmlspecialchars($this->_var['my_qa_list']['user_name']); ?><?php else: ?>游客<?php endif; ?></span></td>
                        <td style="width:130px">
                            <a href="javascript:drop_confirm('您确定要删除这些咨询吗', 'index.php?app=my_qa&amp;act=drop&id=<?php echo $this->_var['my_qa_list']['ques_id']; ?>');" class="delete">删除</a>&nbsp;&nbsp;
                            <?php if ($this->_var['my_qa_list']['reply_content'] == ''): ?><a href="javascript:void(0);" class="add1_ico reply" ectype="dialog" dialog_id="my_qa_reply" dialog_title="回复咨询" dialog_width="400" uri="index.php?app=my_qa&amp;act=reply&amp;ques_id=<?php echo $this->_var['my_qa_list']['ques_id']; ?>">回复</a>
                            <?php else: ?>
                             <a href="javascript:void(0);" class="add1_ico reply" ectype="dialog" dialog_id="my_qa_edit_reply" dialog_title=" 编辑回复" dialog_width="400" uri="index.php?app=my_qa&amp;act=edit_reply&amp;ques_id=<?php echo $this->_var['my_qa_list']['ques_id']; ?>"> 编辑回复</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <h3>咨询内容:</h3>
                            <p><?php echo htmlspecialchars($this->_var['my_qa_list']['question_content']); ?></p>
                        </td>
                        <td><span class="time"><?php echo local_date("Y-m-d H:i:s",$this->_var['my_qa_list']['time_post']); ?></span></td>
                        <td></td>
                    </tr>
                    <?php if ($this->_var['my_qa_list']['reply_content'] != ''): ?>
                    <tr <?php if (($this->_foreach['qa']['iteration'] == $this->_foreach['qa']['total'])): ?>class="line_bold"<?php endif; ?>>
                        <td></td>
                        <td>
                            <h3><span class="color8">我的回复:</span></h3>
                            <p><span class="color3"><?php echo htmlspecialchars($this->_var['my_qa_list']['reply_content']); ?></span></p>
                        </td>
                        <td><span class="time"><?php echo local_date("Y-m-d H:i:s",$this->_var['my_qa_list']['time_reply']); ?></span></td>
                        <td></td>
                    </tr>
                    <?php else: ?>
                    <?php if (($this->_foreach['qa']['iteration'] == $this->_foreach['qa']['total'])): ?>
                    <tr class="line_bold">
                        <td colspan="4">&nbsp;</td>
                    </tr>
                    <?php endif; ?>
                    <?php endif; ?>
                    <?php endforeach; else: ?>
                    <tr><td colspan="4" class="member_no_records">没有符合条件的记录</td></tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['my_qa_data']): ?>
                    <tr>
                        <th><input id="all2" type="checkbox" class="checkall" /></th>
                        <th colspan="3">
                            <p class="position1">
                                <label for="all2"><span class="all">全选</span></label>
                                <a href="javascript:void(0);" class="delete" ectype="batchbutton" uri="index.php?app=my_qa&amp;act=drop" name="id" presubmit="confirm('您确定要删除这些咨询吗')">删除</a>
                            </p>
                            <p class="position2">
                                <?php echo $this->fetch('member.page.bottom.html'); ?>
                            </p>
                        </th>
                    </tr>
                    <?php endif; ?>
                </table>
              </div>
            <iframe name="pop_warning" style="display:none;"></iframe>
            <div class="wrap_bottom"></div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>