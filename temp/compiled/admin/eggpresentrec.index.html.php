<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>砸蛋礼品兑换查询</p>
    <ul class="subnav">
        <li><?php if ($this->_var['wait_verify']): ?><a class="btn1" href="index.php?app=eggpresentrec">管理</a><?php else: ?><span>管理</span><?php endif; ?></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="eggpresentrec" />
                <input type="hidden" name="act" value="index" />
                <input type="hidden" name="wait_verify" value="<?php echo $this->_var['wait_verify']; ?>">
                会员名:
                <input class="queryInput" type="text" name="username" value="<?php echo htmlspecialchars($this->_var['query']['username']); ?>" />
                所属蛋类:
                <input class="queryInput" type="text" name="eggname" value="<?php echo htmlspecialchars($this->_var['query']['eggname']); ?>" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=eggpresentrec&wait_verify=<?php echo $this->_var['wait_verify']; ?>">撤销检索</a>
            <?php endif; ?>
            <span>
            </span></form>
    </div>
    <div class="fontr">
        <?php if ($this->_var['eggpresentrecs']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['eggpresentrecs']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">会员名</td>
            <td align="left">礼品名称</td>
            <td align="left">所属蛋类</td>
            <td align="left">添加时间</td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['eggpresentrecs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'eggpresentrec');if (count($_from)):
    foreach ($_from AS $this->_var['eggpresentrec']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input value="<?php echo $this->_var['eggpresentrec']['id']; ?>" class='checkitem' type="checkbox" /></td>

            <td align="left"><?php echo htmlspecialchars($this->_var['eggpresentrec']['username']); ?> | <?php echo htmlspecialchars($this->_var['eggpresentrec']['real_name']); ?></td>

            <td align="left"><?php echo htmlspecialchars($this->_var['eggpresentrec']['presentname']); ?></td>

            <td align="left"><?php echo htmlspecialchars($this->_var['eggpresentrec']['eggname']); ?></td>

            <td align="left"><?php echo local_date("Y-m-d",$this->_var['eggpresentrec']['add_time']); ?></td>

            <td class="handler">
                <a style="display:none" href="index.php?app=eggpresentrec&amp;act=edit&amp;id=<?php echo $this->_var['eggpresentrec']['id']; ?>">编辑</a>  |  <a name="drop" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=eggpresentrec&amp;act=drop&amp;id=<?php echo $this->_var['eggpresentrec']['id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['eggpresentrecs']): ?>
    <div id="dataFuncs">
        <div id="batchAction"  class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=eggpresentrec&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
            <!-- <input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div class="clear"></div>
    </div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
