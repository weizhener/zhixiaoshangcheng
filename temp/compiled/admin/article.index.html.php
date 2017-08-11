<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>文章管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=article&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="article" />
                <input type="hidden" name="act" value="index" />
                标题:
                <input class="queryInput" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['query']['title']); ?>" />
                文章分类:
                <select class="querySelect" id="cate_id" name="cate_id">
                <option value="">请选择...</option>
                <?php echo $this->html_options(array('options'=>$this->_var['parents'],'selected'=>$_GET['cate_id'])); ?>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=article">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['articles']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">标题</td>
            <td>所属分类</td>
            <td align="left">显示</td>
            <td>添加时间</td>
            <td>排序</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['articles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php if (! $this->_var['article']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['article']['article_id']; ?>"/><?php endif; ?></td>
            <td><?php echo htmlspecialchars($this->_var['article']['title']); ?></td>
            <td><?php echo htmlspecialchars($this->_var['article']['cate_name']); ?></td>
            <td><?php echo $this->_var['article']['if_show']; ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['article']['add_time']); ?></td>
            <td><?php if (! $this->_var['article']['code']): ?><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['article']['article_id']; ?>" datatype="pint" maxvalue="255" class="editable"><?php echo $this->_var['article']['sort_order']; ?></span><?php endif; ?></td>
            <td><a href="index.php?app=article&amp;act=edit&amp;id=<?php echo $this->_var['article']['article_id']; ?>">编辑</a>
                <?php if (! $this->_var['article']['code']): ?>|
                <a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=article&amp;act=drop&amp;id=<?php echo $this->_var['article']['article_id']; ?>');">删除</a><?php endif; ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['articles']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=article&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            &nbsp;&nbsp;
            <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
