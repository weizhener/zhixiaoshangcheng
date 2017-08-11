<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>团购</p>
    <ul class="subnav">
        <li><span>管理</span></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="groupbuy" />
                <input type="hidden" name="act" value="index" />
                团购名称:
                <input class="queryInput" type="text" name="group_name" value="<?php echo htmlspecialchars($this->_var['query']['group_name']); ?>" />
                状态:
                <select name="type">
                    <?php echo $this->html_options(array('options'=>$this->_var['types'],'selected'=>$this->_var['type'])); ?>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=groupbuy">撤销检索</a>
            <?php endif; ?>
            <span> </span>
        </form>
    </div>
    <div class="fontr"> <?php if ($this->_var['groupbuys']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?> </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['groupbuys']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">团购名称</td>
            <td align="left">店铺名称</td>
            <td align="left">状态</td>
            <td align="left" class="table-center">起止时间</td>
            <td class="table-center">订购/成团</td>
            <td class="handler">浏览数</td>
            <td class="table-center">推荐</td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['groupbuys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'groupbuy');if (count($_from)):
    foreach ($_from AS $this->_var['groupbuy']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input value="<?php echo $this->_var['groupbuy']['group_id']; ?>" class='checkitem' type="checkbox" /></td>
            <td align="left"><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=groupbuy&amp;id=<?php echo $this->_var['groupbuy']['group_id']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['groupbuy']['group_name']); ?></a></td>
            <td align="left"><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=store&amp;id=<?php echo $this->_var['groupbuy']['store_id']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['groupbuy']['store_name']); ?></a></td>
            <td align="left"><?php echo call_user_func("group_state",$this->_var['groupbuy']['state']); ?></td>
            <td align="left" class="table-center"> <?php echo local_date("Y-m-d",$this->_var['groupbuy']['start_time']); ?> 至 <?php echo local_date("Y-m-d",$this->_var['groupbuy']['end_time']); ?> </td>
            <td class="table-center"><?php echo $this->_var['groupbuy']['count']; ?>/<?php echo $this->_var['groupbuy']['min_quantity']; ?></td>
            <td class="handler"><?php echo $this->_var['groupbuy']['views']; ?></td>
            <td class="table-center">
             <?php if ($this->_var['groupbuy']['state'] == 1): ?>
                <?php if ($this->_var['groupbuy']['recommended']): ?>
                    <img src="templates/style/images/positive_enabled.gif" ectype="inline_edit" fieldname="recommended" fieldid="<?php echo $this->_var['groupbuy']['group_id']; ?>" fieldvalue="1" title="可编辑"/>
                    <?php else: ?>
                    <img src="templates/style/images/positive_disabled.gif" ectype="inline_edit" fieldname="recommended" fieldid="<?php echo $this->_var['groupbuy']['group_id']; ?>" fieldvalue="0" title="可编辑"/>
                    <?php endif; ?>
            <?php else: ?>
                -
            <?php endif; ?>
            </td>
            <td class="handler"><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=groupbuy&amp;id=<?php echo $this->_var['groupbuy']['group_id']; ?>" target="_blank">查看</a> | <a name="drop" href="javascript:drop_confirm('如果删除了已进行的团购，可能会对涉及该活动的卖家和买家产生影响，您确定要删除吗？', 'index.php?app=groupbuy&amp;act=drop&amp;id=<?php echo $this->_var['groupbuy']['group_id']; ?>');">删除</a> </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="10">没有数据</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['groupbuys']): ?>
    <div id="dataFuncs">
        <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=groupbuy&act=drop" presubmit="confirm('如果删除了已进行的团购，可能会对涉及该活动的卖家和买家产生影响，您确定要删除吗？');" />
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="推荐" name="id" uri="index.php?app=groupbuy&act=recommended"  presubmit="confirm('您确定要设置为推荐吗?')" />
            &nbsp;&nbsp; </div>

    </div>
    <?php endif; ?>
    <div class="pageLinks"><?php if ($this->_var['groupbuys']): ?> <?php echo $this->fetch('page.bottom.html'); ?> <?php endif; ?> </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>