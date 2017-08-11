<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>商品品牌</p>
    <ul class="subnav">
        <li><?php if ($this->_var['wait_verify']): ?><a class="btn1" href="index.php?app=brand">管理</a><?php else: ?><span>管理</span><?php endif; ?></li>
        <li><a class="btn1" href="index.php?app=brand&amp;act=add">新增</a></li>
        <li><?php if ($this->_var['wait_verify']): ?><span>待审核</span><?php else: ?><a class="btn1" href="index.php?app=brand&amp;wait_verify=1">待审核</a><?php endif; ?></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="brand" />
                <input type="hidden" name="act" value="index" />
                <input type="hidden" name="wait_verify" value="<?php echo $this->_var['wait_verify']; ?>">
                品牌名称:
                <input class="queryInput" type="text" name="brand_name" value="<?php echo htmlspecialchars($this->_var['query']['brand_name']); ?>" />
                类别:
                <input class="queryInput" type="text" name="tag" value="<?php echo htmlspecialchars($this->_var['query']['tag']); ?>">
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=brand&wait_verify=<?php echo $this->_var['wait_verify']; ?>">撤销检索</a>
            <?php endif; ?>
      <span>
              </span></form>
    </div>
    <div class="fontr">
        <?php if ($this->_var['brands']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['brands']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left"><span ectype="order_by" fieldname="brand_name">品牌名称</span></td>
            <td align="left"><span ectype="order_by" fieldname="tag">类别</span></td>
            <td align="left" class="table-center">图片标识</td>
            <?php if (! $this->_var['wait_verify']): ?>
             <td class="table-center"><span ectype="order_by" fieldname="sort_order">排序</span></td>
            <td class="table-center"><span ectype="order_by" fieldname="recommended">推荐</span></td>
            <?php endif; ?>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input value="<?php echo $this->_var['brand']['brand_id']; ?>" class='checkitem' type="checkbox" /></td>
            <td align="left"><span ectype="inline_edit" fieldname="brand_name" fieldid="<?php echo $this->_var['brand']['brand_id']; ?>" required="1" class="editable" title="可编辑"><?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?></span></td>
            <td align="left"><span ectype="inline_edit" fieldname="tag" fieldid="<?php echo $this->_var['brand']['brand_id']; ?>" required="1" class="editable" title="可编辑"><?php echo htmlspecialchars($this->_var['brand']['tag']); ?><span></td>
            <td align="left" class="table-center"><?php if ($this->_var['brand']['brand_logo']): ?><img src="<?php echo $this->_var['brand']['brand_logo']; ?>" height="30"/><?php endif; ?></td>
            <?php if (! $this->_var['wait_verify']): ?>
            <td class="table-center"><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['brand']['brand_id']; ?>" datatype="pint" maxvalue="255" class="editable" title="可编辑"><?php echo $this->_var['brand']['sort_order']; ?></span></td>  
            <td class="table-center"><?php if ($this->_var['brand']['if_show']): ?><?php if ($this->_var['brand']['recommended']): ?><img src="templates/style/images/positive_enabled.gif" ectype="inline_edit" fieldname="recommended" fieldid="<?php echo $this->_var['brand']['brand_id']; ?>" fieldvalue="1" title="可编辑"/><?php else: ?><img src="templates/style/images/positive_disabled.gif" ectype="inline_edit" fieldname="recommended" fieldid="<?php echo $this->_var['brand']['brand_id']; ?>" fieldvalue="0" title="可编辑"/><?php endif; ?><?php endif; ?></td>
            <?php endif; ?>
            <td class="handler">
            <?php if ($this->_var['brand']['if_show'] == 1): ?>
            <a href="index.php?app=brand&amp;act=edit&amp;id=<?php echo $this->_var['brand']['brand_id']; ?>">编辑</a>  |  <a name="drop" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=brand&amp;act=drop&amp;id=<?php echo $this->_var['brand']['brand_id']; ?>');">删除</a>
            <?php else: ?>
            <a href="index.php?app=brand&amp;act=pass&amp;id=<?php echo $this->_var['brand']['brand_id']; ?>">通过</a>  |  <a href="index.php?app=brand&amp;act=refuse&amp;id=<?php echo $this->_var['brand']['brand_id']; ?>">拒绝</a>       
            <?php endif; ?>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['brands']): ?>
    <div id="dataFuncs">
        <div id="batchAction" class="left paddingT15">
            <?php if ($this->_var['wait_verify']): ?>
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="通过" name="id" uri="index.php?app=brand&act=pass" />
             &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="拒绝" name="id" uri="index.php?app=brand&act=refuse" />
            <?php else: ?>
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=brand&act=drop" presubmit="confirm('您确定要删除它吗？');" />
            <?php endif; ?>
        </div>
        <div class="pageLinks">
            <?php if ($this->_var['brands']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
