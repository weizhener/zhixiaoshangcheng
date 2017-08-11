<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">财务明细</div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>
<style>
    .epay_select{border-radius: 5px;position: relative;overflow: hidden;color: #6b6b6b;margin: 0px 10px 0;font-size: 14px;margin-top:10px;}
    .epay_select select{margin-bottom: 5px;}
</style>

<div class="epay_select">
    <form method="get">
        <select class="querySelect" name="type">
            <option value="">交易类型</option>
            <?php echo $this->html_options(array('options'=>$this->_var['epay_type_list'],'selected'=>$_GET['type'])); ?>
        </select>
        <select class="querySelect" name="complete">
            <option value="">交易状态</option>
            <?php echo $this->html_options(array('options'=>$this->_var['complete_list'],'selected'=>$_GET['complete'])); ?>
        </select>
        <input type="hidden" name="app" value="epay" />
        <input type="hidden" name="act" value="logall" />
        <input type="submit" class="white_btn" value="搜  索" />
        <?php if ($this->_var['filtered']): ?>
        <a class="red_btn" href="<?php echo url('app=epay&act=logall'); ?>">取消检索</a>
        <?php endif; ?>
    </form>

</div>

<div class="table">
    <table>
        <tbody>
            <?php if ($this->_var['epaylog_list']): ?>
            <tr>
                <th style="width:20%;text-align: center">单号</th>
                <th style="width:10%">操作时间</th>
                <th style="width:40%">操作日志</th>
                <th style="width:20%">金额</th>
                <th style="width:10%">状态</th>
            </tr>
            <?php endif; ?>
            <?php $_from = $this->_var['epaylog_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'epaylog');$this->_foreach['fe_epaylog'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_epaylog']['total'] > 0):
    foreach ($_from AS $this->_var['epaylog']):
        $this->_foreach['fe_epaylog']['iteration']++;
?>
            <tr>
                <td><?php echo $this->_var['epaylog']['order_sn']; ?></td>
                <td><?php echo local_date("Y-m-d H:i",$this->_var['epaylog']['add_time']); ?></td>
                <td><?php echo $this->_var['epaylog']['log_text']; ?></td>
                <td><?php if ($this->_var['epaylog']['money_flow'] == 'income'): ?>收入<?php else: ?>支出<?php endif; ?><?php echo $this->_var['epaylog']['money']; ?><?php echo $this->_var['epaylog']['yuan']; ?></td>
                <td align="center"><?php if ($this->_var['epaylog']['complete'] == 0): ?>未完成<?php else: ?>已完成<?php endif; ?></td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td colspan="5" style="text-align: center;padding: 20px 0;">没有符合条件的记录</td>
            </tr>
            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </tbody>
    </table>
</div>
<?php echo $this->fetch('member.page.bottom.html'); ?>



<?php echo $this->fetch('member.footer.html'); ?>