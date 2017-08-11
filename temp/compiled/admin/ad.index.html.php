<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>素材管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=ad&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="ad" />
                <input type="hidden" name="act" value="index" />
                广告图名称:
                <input class="queryInput" type="text" name="ad_name" value="<?php echo htmlspecialchars($this->_var['query']['ad_name']); ?>" />
                <select class="querySelect" name="ad_type">
                    <option value="">广告位置</option>
                    <?php echo $this->html_options(array('options'=>$this->_var['ad_type_list'],'selected'=>$_GET['ad_type'])); ?>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=ad&wait_verify=<?php echo $this->_var['wait_verify']; ?>">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php if ($this->_var['ads']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['ads']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td class="align_center" width="20%"><span ectype="order_by" fieldname="ad_name">广告图名称</span></td>
            <td class="align_center" width="20%">广告图链接</td>
            <td class="align_center" width="10%"><span ectype="order_by" fieldname="ad_type">广告图位置</span></td>
            <td class="align_center" width="10%"><span ectype="order_by" fieldname="if_show">显示</span></td>
            <td class="align_center" width="10%"><span ectype="order_by" fieldname="sort_order">排序</span></td>
            <td class="align_center" width="10%">广告图片</td>
            <td class="handler" width="10%">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['ads']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ad');if (count($_from)):
    foreach ($_from AS $this->_var['ad']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input value="<?php echo $this->_var['ad']['ad_id']; ?>" class='checkitem' type="checkbox" /></td>
            <td><span ectype="inline_edit" fieldname="ad_name" fieldid="<?php echo $this->_var['ad']['ad_id']; ?>" required="1" class="editable" title="单击可以编辑"><?php echo htmlspecialchars($this->_var['ad']['ad_name']); ?></span></td>
            <td><span ectype="inline_edit" fieldname="ad_link" fieldid="<?php echo $this->_var['ad']['ad_id']; ?>" required="1" class="editable" title="单击可以编辑"><?php echo htmlspecialchars($this->_var['ad']['ad_link']); ?></span></td>
            <td><?php echo $this->_var['ad']['ad_type']; ?></td>
            <td><?php if ($this->_var['ad']['if_show']): ?><img src="templates/style/images/positive_enabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['ad']['ad_id']; ?>" fieldvalue="1" title="单击可以编辑"/><?php else: ?><img src="templates/style/images/positive_disabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['ad']['ad_id']; ?>" fieldvalue="0" title="单击可以编辑"/><?php endif; ?></td>
            <td><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['ad']['ad_id']; ?>" datatype="pint" maxvalue="255" class="editable" title="单击可以编辑"><?php echo $this->_var['ad']['sort_order']; ?></span></td>  
            <td><?php if ($this->_var['ad']['ad_logo']): ?><img src="<?php echo $this->_var['ad']['ad_logo']; ?>" height="30"/><?php endif; ?></td>
            <td class="handler">
                <a href="index.php?app=ad&amp;act=edit&amp;id=<?php echo $this->_var['ad']['ad_id']; ?>&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>&ad_type=<?php echo $_GET['ad_type']; ?>">编辑</a>  |  
                <a name="drop" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=ad&amp;act=drop&amp;id=<?php echo $this->_var['ad']['ad_id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['ads']): ?>
    <div id="dataFuncs">
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=ad&act=drop" presubmit="confirm('您确定要删除它吗？');" />
        </div>
        <div class="pageLinks">
            <?php if ($this->_var['ads']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
