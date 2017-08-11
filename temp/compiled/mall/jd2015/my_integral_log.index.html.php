<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
    $(function() {
        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>
<style type="text/css">
    .table .line td{border:none;}
    .float_right {float: right;}
    .line{border-bottom:1px solid #E2E2E2}
</style>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public_select table">
                    <form method="get">
                            <div class="user_search">
                                
                                <span>时间从: </span>
                                <input type="text" class="text1 width2" name="add_time_from" id="add_time_from" value="<?php echo $this->_var['query']['add_time_from']; ?>"/> &#8211;
                                <input type="text" class="text1 width2" name="add_time_to" id="add_time_to" value="<?php echo $this->_var['query']['add_time_to']; ?>"/>
                                <select class="querySelect" name="integral_type">
                                    <option value="">积分类型</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['integral_type_list'],'selected'=>$this->_var['query']['integral_type'])); ?>
                                </select>
                                <input type="hidden" name="app" value="my_integral_log" />
                                <input type="hidden" name="act" value="index" />
                                <input type="submit" class="btn" value="搜索" />
                                <?php if ($this->_var['filtered']): ?>
                                <a class="detlink float_right" href="<?php echo url('app=my_integral_log'); ?>">取消检索</a>
                                <?php endif; ?>
                            </div>
                    </form>
                <table>



                    <?php if ($this->_var['integral_logs']): ?>
                    <tr class="gray">
                        <th align='center' width='10%'>用户名</th>
                        <th align='center' width='10%'>积分</th>
                        <th align='center' width='20%'>添加时间</th>
                        <th align='center' width='20%'>积分类型</th>
                        <th align='center' width='40%'>备注</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['integral_logs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'integral_log');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['integral_log']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line_bold"><?php endif; ?>
                        <td align='center'><?php echo $this->_var['integral_log']['user_name']; ?></td>
                        <td align='center'><?php echo $this->_var['integral_log']['point']; ?></td>
                        <td align='center'><?php echo local_date("Y-m-d H:i:s",$this->_var['integral_log']['add_time']); ?></td>
                        <td align='center'><?php $_from = $this->_var['integral_type_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'integral_type');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['integral_type']):
?><?php if ($this->_var['key'] == $this->_var['integral_log']['integral_type']): ?><?php echo $this->_var['integral_type']; ?><?php endif; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
                        <td align='center'><?php echo $this->_var['integral_log']['remark']; ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="member_no_records padding6"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
                <?php echo $this->fetch('member.page.bottom.html'); ?>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php echo $this->fetch('footer.html'); ?>
