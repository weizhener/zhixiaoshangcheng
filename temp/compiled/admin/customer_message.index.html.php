<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>投诉及建议</p>
    <ul class="subnav">
        <li><span>用户建议</span></li>
        <li><a class="btn1" href="index.php?app=customer_message&amp;act=store">店铺投诉</a></li>
        <li><a class="btn1" href="index.php?app=customer_message&amp;act=goods">商品投诉</a></li>
        <li><a class="btn1" href="index.php?app=customer_message&amp;act=epay">汇款审核</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="customer_message" />
                <input type="hidden" name="act" value="index" />
                <select class="querySelect" name="status">
                    <option value="">处理状态</option>
                    <?php echo $this->html_options(array('options'=>$this->_var['status_list'],'selected'=>$this->_var['query']['status'])); ?>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=customer_message">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php if ($this->_var['customer_message_list']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['customer_message_list']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">真实姓名</td>
            <td align="left">联系电话</td>
            <td align="left">内容</td>
            <td align="left">提交时间</td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['customer_message_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'customer_message');if (count($_from)):
    foreach ($_from AS $this->_var['customer_message']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input value="<?php echo $this->_var['customer_message']['customer_message_id']; ?>" class='checkitem' type="checkbox" /></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['customer_message']['realname']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['customer_message']['mobile']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['customer_message']['message']); ?></td>
            <td align="left"><?php echo local_date("Y-m-d H:i:s",$this->_var['customer_message']['add_time']); ?></td>
            <td class="handler">
                <?php if ($this->_var['customer_message']['status'] != 1): ?>
                <a href="index.php?app=customer_message&amp;act=status&amp;id=<?php echo $this->_var['customer_message']['customer_message_id']; ?>">处理</a>
                <?php endif; ?>
                <a name="drop" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=customer_message&amp;act=drop&amp;id=<?php echo $this->_var['customer_message']['customer_message_id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['customer_message_list']): ?>
    <div id="dataFuncs">
        <div id="batchAction" class="left paddingT15">
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=customer_message&act=drop" presubmit="confirm('您确定要删除它吗？');" />
        </div>
        <div class="pageLinks">
            <?php if ($this->_var['customer_message_list']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
