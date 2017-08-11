<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>分享链接</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=share&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
    </div>
    <div class="fontr">
    <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['shares']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left" width="200">分享名称</td>
            <td width="80">类别</td>
            <td align="left">图片标识</td>
            <td align="left">接口地址</td>
            <td class="table-center">排序</td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['shares']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('share_id', 'share');if (count($_from)):
    foreach ($_from AS $this->_var['share_id'] => $this->_var['share']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['share_id']; ?>"/></td>
            <td><?php echo htmlspecialchars($this->_var['share']['title']); ?></td>
            <td><?php echo $this->_var['type'][$this->_var['share']['type']]; ?></td>
            <td><img class="makesmall" max_width="16" max_height="16" src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['share']['logo']; ?>" /></td>
            <td><?php echo htmlspecialchars($this->_var['share']['link']); ?></td>
            <td class="table-center"><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['share_id']; ?>" datatype="pint" maxvalue="255" class="editable" title="单击可以编辑"><?php echo $this->_var['share']['sort_order']; ?></span></td>
            <td class="handler"><a href="index.php?app=share&amp;act=edit&amp;id=<?php echo $this->_var['share_id']; ?>">编辑</a>
                |
                <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=share&amp;act=drop&amp;id=<?php echo $this->_var['share_id']; ?>');">删除</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['shares']): ?>
    <div id="dataFuncs">
        <div id="batchAction"  class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=share&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
        </div>
        <div class="clear"></div>
    </div>
    <?php endif; ?>
</div>

<?php echo $this->fetch('footer.html'); ?>
