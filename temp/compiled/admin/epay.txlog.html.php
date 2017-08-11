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
        <li><a class="btn1" href="index.php?app=epay&act=money_log">资金流水</a></li>
        <li><span>提现记录</span></li>
        <li><a class="btn1" href="index.php?app=epay&act=setting">账户设置</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=statistics">资金安检</a></li>
    </ul>
</div>

<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input name="app" type="hidden" id="app" value="epay" />
                <input name="act" type="hidden" id="act" value="txlog" />
                <select class="querySelect" name="field"><?php echo $this->html_options(array('options'=>$this->_var['search_options'],'selected'=>$_GET['field'])); ?>
                </select>:<input class="queryInput" type="text" name="search_name" value="<?php echo htmlspecialchars($this->_var['query']['search_name']); ?>" />
                <select class="querySelect" name="status">
                    <option value="">审核状态</option>
                    <?php echo $this->html_options(array('options'=>$this->_var['tx_status_list'],'selected'=>$this->_var['query']['status'])); ?>
                </select>
                申请时间从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
                至:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />
                金额从:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['order_amount_from']; ?>" name="order_amount_from" />
                至:<input class="queryInput2" type="text" style="width:60px;" value="<?php echo $this->_var['query']['order_amount_to']; ?>" name="order_amount_to" class="pick_date" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=epay&act=txlog">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">

    </div>
</div>

<div class="tdare">
    <table width="100%" cellspacing="0">

        <tr class="tatr1">
            <td width="20" class="firstCell">&nbsp;</td>
            <td width="140">订单号</td>
            <td>会员名称</td>
            <td>提现金额</td>
            <td width="120">申请时间</td>


            <td width="120">审核时间</td>
            <td>审核状态</td>
            <td>转账单号</td>
            <td class="handler">管理操作</td>
        </tr>

        <?php $_from = $this->_var['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
        <tr class="tatr2">
            <td width="20" class="firstCell">&nbsp;</td>
            <td><?php echo $this->_var['val']['order_sn']; ?></td>
            <td><b><?php echo $this->_var['val']['user_name']; ?></b></td>
            <td><font color="#FF0000"><?php echo $this->_var['val']['money']; ?></font></td>
            <td><?php echo local_date("y-m-d H:i",$this->_var['val']['add_time']); ?></td>        
            <td><?php if ($this->_var['val']['add_time']): ?><?php echo local_date("y-m-d H:i",$this->_var['val']['add_time']); ?><?php else: ?>未审核<?php endif; ?></td>
            <td class="table_center">
                <?php if ($this->_var['val']['states'] == 71): ?>
                <img src="<?php echo $this->res_base . "/" . 'style/images/positive_enabled.gif'; ?>">
                <?php endif; ?>
                <?php if ($this->_var['val']['states'] == 70): ?>
                <img src="<?php echo $this->res_base . "/" . 'style/images/positive_disabled.gif'; ?>">
                <?php endif; ?>
            </td>
            <td><?php echo $this->_var['val']['to_id']; ?></td>  
            <td class="handler">
                <?php if ($this->_var['val']['states'] == 70): ?>
                <a href="index.php?app=epay&act=tx_view&user_id=<?php echo $this->_var['val']['user_id']; ?>&log_id=<?php echo $this->_var['val']['id']; ?>">审核</a>
                <?php else: ?>
                已审核
                <?php endif; ?>
            </td>
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