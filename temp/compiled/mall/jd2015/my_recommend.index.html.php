<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="<?php echo $this->_var['charset']; ?>"></script>
        <div class="wrap">
            <div class="eject_btn_two eject_pos1" ><b class="ico4"><a uri="index.php?app=my_recommend&amp;act=add" ectype="dialog" dialog_id="my_recommend_add" dialog_width="460" dialog_title="新增推荐类型">新增推荐类型</a></b></div>
            <div class="public table">
                <table class="table_head_line">
                    <?php if ($this->_var['recommends']): ?>
                    <tr class="line_bold">
                        <th class="width1"><input id="all" type="checkbox" class="checkall" /></th>
                        <th class="align1" colspan="5">
                            <span class="all"><label for="all">全选</label></span>
                            <a href="javascript:void(0);" class="delete" uri="index.php?app=my_recommend&act=drop" name="id" presubmit="confirm('您确定要删除该推荐类型吗？')" ectype="batchbutton">删除</a>
                        </th>
                    </tr>
                    <tr class="gray">
                        <th></th>
                        <th align="left">推荐类型名称</th>
                        <th>商品数</th>
                        <th>操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['recommends']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'recom');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['recom']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                        <td class="align2"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['recom']['recom_id']; ?>" /></td>
                        <td><?php echo htmlspecialchars($this->_var['recom']['recom_name']); ?></td>
                        <td align="center"><?php echo ($this->_var['recom']['goods_count'] == '') ? '0' : $this->_var['recom']['goods_count']; ?></td>
                        <td width="200">
                        <div style="width:200px;">
                            <a href="javascript:void(0);" uri="index.php?app=my_recommend&amp;act=edit&id=<?php echo $this->_var['recom']['recom_id']; ?>" dialog_id="my_recommend_edit" dialog_title="编辑" dialog_width="460" ectype="dialog" class="edit1">编辑</a>
                            <a href="javascript:drop_confirm('您确定要删除该推荐类型吗？', 'index.php?app=my_recommend&amp;act=drop&id=<?php echo $this->_var['recom']['recom_id']; ?>');" class="delete">删除</a>
                            <a href="index.php?app=my_recommend&act=view_goods&id=<?php echo $this->_var['recom']['recom_id']; ?>" class="log">查看推荐商品</a>
                        </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="6" class="member_no_records padding6">没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['recommends']): ?>
                    <tr>
                        <th><input id="all2" type="checkbox" class="checkall" /></th>
                        <th colspan="5">
                        <p class="position1">
                            <span class="all"><label for="all2">全选</label></span>
                            <a href="javascript:void(0);" class="delete" uri="index.php?app=my_recommend&act=drop" name="id" presubmit="confirm('您确定要删除该推荐类型吗？')" ectype="batchbutton">删除</a>

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
        <iframe name="my_recommend" style="display:none"></iframe>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
