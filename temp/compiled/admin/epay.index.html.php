<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function () {
        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    });
</script>

<div id="rightTop">
    <ul class="subnav">
        <li><span>资金用户</span></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_add">增加金额</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_log">资金流水</a></li>
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
                <input name="act" type="hidden" id="act" value="index" />
                会员名称:<input class="queryInput" type="text" name="search_name" value="<?php echo htmlspecialchars($this->_var['query']['search_name']); ?>" />
                时间从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
                至:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />
                金额从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['order_amount_from']; ?>" name="order_amount_from" />
                至:<input class="queryInput2" type="text" style="width:60px;" value="<?php echo $this->_var['query']['order_amount_to']; ?>" name="order_amount_to" class="pick_date" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=epay&act=index">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">

    </div>
</div>

<div class="tdare">
    <table width="100%" cellspacing="0">

        <tr class="tatr1" align="center">
            <td width="19" class="firstCell"></td>
            <td align="left">会员名称</td>
            <td align="center">金额</td>
            <td align="center">冻结金额</td>
            <td align="center">开通时间</td>
            <td  class="handler">管理操作</td>
        </tr>

        <?php $_from = $this->_var['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
        <tr class="tatr2">
            <td width="19" class="firstCell">&nbsp;</td>
            <td align="left"><b><?php echo $this->_var['val']['user_name']; ?></b></td>
            <td align="center"><font color="#FF0000"><?php echo $this->_var['val']['money']; ?></font></td>
            <td align="center"><font color="#FF0000"><?php echo $this->_var['val']['money_dj']; ?></font></td>
            <td align="center"><?php echo local_date("y-m-d H:i",$this->_var['val']['add_time']); ?></td>

            <td class="handler">
                <a href="index.php?app=epay&act=money_add&user_id=<?php echo $this->_var['val']['user_id']; ?>&user_name=<?php echo $this->_var['val']['user_name']; ?>">增加金额</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="6">没有符合条件的记录</td>
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