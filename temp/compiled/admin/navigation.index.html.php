<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>页面导航</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=navigation&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
            <input type="hidden" name="app" value="navigation" />
            <input type="hidden" name="act" value="index" />
            标题:
            <input class="queryInput" type="text" name="title" size="10" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
            所在位置:
            <select class="querySelect" name="type">
                <option value="">请选择...</option>
            <?php echo $this->html_options(array('options'=>$this->_var['type'],'selected'=>$this->_var['query']['type'])); ?>
            </select>
            <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=navigation">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
    <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['navigations']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">标题</td>
            <td>所在位置</td>
            <td align="left" width="40%">链接</td>
            <td class="table-center">新窗口打开</td>
            <td class="table-center">排序</td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['navigations']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'navigation');if (count($_from)):
    foreach ($_from AS $this->_var['navigation']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['navigation']['nav_id']; ?>"/></td>
            <td><?php echo htmlspecialchars($this->_var['navigation']['title']); ?></td>
            <td><?php echo $this->_var['navigation']['type']; ?></td>
            <td><?php echo htmlspecialchars($this->_var['navigation']['link']); ?></td>
            <td class="table-center"><?php echo $this->_var['navigation']['open_new']; ?></td>
            <td class="table-center"><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['navigation']['nav_id']; ?>" datatype="pint" maxvalue="255" class="editable" title="可编辑"><?php echo $this->_var['navigation']['sort_order']; ?></span></td>
            <td class="handler"><a href="index.php?app=navigation&amp;act=edit&amp;id=<?php echo $this->_var['navigation']['nav_id']; ?>">编辑</a>
                |
                <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=navigation&amp;act=drop&amp;id=<?php echo $this->_var['navigation']['nav_id']; ?>');">删除</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['navigations']): ?>
    <div id="dataFuncs">
        <div id="batchAction"  class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=navigation&act=drop" presubmit="confirm('您确定要删除它吗？');" />
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
