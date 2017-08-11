<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function () {
        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>

<div id="rightTop">
    <ul class="subnav" style="margin:0;">
        <li><a class="btn1" href="index.php?app=epay">资金用户</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_add">增加金额</a></li>
        <li><span>资金流水</span></li>
        <li><a class="btn1" href="index.php?app=epay&act=txlog">提现记录</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=setting">账户设置</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=statistics">资金安检</a></li>
    </ul>
</div>

<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input name="app" type="hidden" id="app" value="epay" />
                <input name="act" type="hidden" id="act" value="money_log" />
                <select class="querySelect" name="field">
                    <?php echo $this->html_options(array('options'=>$this->_var['search_options'],'selected'=>$_GET['field'])); ?>
                </select>
                <input class="queryInput" type="text" name="search_name" value="<?php echo htmlspecialchars($this->_var['query']['search_name']); ?>" />
                <select class="querySelect" name="type">
                    <option value="">日志类型</option>
                    <?php echo $this->html_options(array('options'=>$this->_var['epay_type_list'],'selected'=>$_GET['type'])); ?>
                </select>
                时间从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
                至:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />
                金额从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['order_amount_from']; ?>" name="order_amount_from" />
                至:<input class="queryInput2" type="text" style="width:60px;" value="<?php echo $this->_var['query']['order_amount_to']; ?>" name="order_amount_to" class="pick_date" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=epay&act=money_log">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>

<div class="tdare">
    <table width="100%" cellspacing="0">

        <tr class="tatr1">
            <td width="20" class="firstCell">&nbsp;</td>
            <td align="left">会员名称</td>
            <td>日志内容</td>
            <td>金额</td>
            <td width="120">订单号</td>
            <td width="120">操作时间</td>
        </tr>

        <?php $_from = $this->_var['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
        <tr class="tatr2">
            <td width="20" class="firstCell">&nbsp;</td>
            <td align="left"><b><?php echo $this->_var['val']['user_name']; ?></b></td>
            <td align="left"><?php echo $this->_var['val']['log_text']; ?></td>
            <td><font color="#FF0000"><?php echo $this->_var['val']['money']; ?></font></td>
            <td><?php echo $this->_var['val']['order_sn']; ?></td>
            <td><?php echo local_date("y-m-d H:i:s",$this->_var['val']['add_time']); ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="8">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['index']): ?>
    <div id="dataFuncs">
        <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
        <div class="clear"></div>
    </div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>