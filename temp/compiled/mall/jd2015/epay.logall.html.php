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
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table">
                <div class="user_search">
                    <form method="get">
                        <span>单号:</span>
                        <input type="text" class="text1 width8" width="30" name="order_sn" value="<?php echo htmlspecialchars($this->_var['query']['order_sn']); ?>">
                        <select class="querySelect" name="type">
                            <option value="">交易类型</option>
                            <?php echo $this->html_options(array('options'=>$this->_var['epay_type_list'],'selected'=>$_GET['type'])); ?>
                        </select>
                        <select class="querySelect" name="complete">
                            <option value="">交易状态</option>
                            <?php echo $this->html_options(array('options'=>$this->_var['complete_list'],'selected'=>$_GET['complete'])); ?>
                        </select>
                        <span>操作时间: </span>
                        <input type="text" class="text1 width2" name="add_time_from" id="add_time_from" value="<?php echo $this->_var['query']['add_time_from']; ?>"/> &#8211;
                        <input type="text" class="text1 width2" name="add_time_to" id="add_time_to" value="<?php echo $this->_var['query']['add_time_to']; ?>"/>
                        <input type="hidden" name="app" value="epay" />
                        <input type="hidden" name="act" value="logall" />
                        <input type="submit" class="btn" value="搜  索" />
                        <?php if ($this->_var['filtered']): ?>
                        <a class="detlink float_right" href="<?php echo url('app=epay&act=logall'); ?>">取消检索</a>
                        <?php endif; ?>
                    </form>
                </div>		

                <table>
                    <?php if ($this->_var['epaylog_list']): ?>
                    <tr class="line tr_bgcolor">
                        <th width="10%">单号</th>
                        <th width="10%" align="center">操作时间</th>
                        <th width="60%">操作日志</th>
                        <th width="10%">金额</th>
                        <th width="10%" align="center">状态</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['epaylog_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'epaylog');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['epaylog']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                        <td align="center"><?php echo $this->_var['epaylog']['order_sn']; ?></td>
                        <td align="center"><?php echo local_date("Y-m-d H:i",$this->_var['epaylog']['add_time']); ?></td>
                        <td align="center"><?php echo $this->_var['epaylog']['log_text']; ?></td>
                        <td align="center"><?php if ($this->_var['epaylog']['money_flow'] == 'income'): ?>收入<?php else: ?>支出<?php endif; ?><?php echo $this->_var['epaylog']['money']; ?><?php echo $this->_var['epaylog']['yuan']; ?></td>
                        <td align="center"><?php if ($this->_var['epaylog']['complete'] == 0): ?>未完成<?php else: ?>已完成<?php endif; ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5" class="member_no_records padding6"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['epaylog_list']): ?>
                    <tr class="sep-row">
                        <td colspan="7"></td>
                    </tr>
                    <tr class="operations">
                        <th colspan="7">
                            <p class="position2 clearfix">
                                <?php echo $this->fetch('member.page.bottom.html'); ?>
                            </p>
                        </th>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<div class="clear"></div>
<?php echo $this->fetch('footer.html'); ?>
