<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ajax_tree_prop.js'; ?>" charset="utf-8"></script>
<div id="rightTop">
    <p>商品属性</p>
    <ul class="subnav">
        <li><span>属性列表</span></li>
        <li><a class="btn1" href="index.php?app=props&amp;act=add">添加属性</a></li>
        <li><a class="btn1" href="index.php?app=gcategory">分配属性</a></li>
    </ul>
</div>

<div class="info2">
   <form method="get">
     <input type="hidden" name="app" value="props" />
     <input type="hidden" name="act" value="batch_drop" />
    <table  class="distinction">
        <?php if ($this->_var['prop_list']): ?>
        <thead>
        <tr class="tatr1">
            <td class="w30"><input id="checkall_1" type="checkbox" class="checkall" /></td>
            <td width="50%"><span class="all_checkbox"><label for="checkall_1">全选</label></span>属性名 / 属性值</td>
            <td>排序</td>
            <td>启用</td>
            <td class="handler">操作</td>
        </tr>
        </thead>
        <?php endif; ?>
        <?php if ($this->_var['prop_list']): ?><tbody id="treet1"><?php endif; ?>
        <?php $_from = $this->_var['prop_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'prop');if (count($_from)):
    foreach ($_from AS $this->_var['prop']):
?>
        <tr>
            <td class="align_center w30"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['prop']['pid']; ?>"  name="pid[]"/></td>
            <td class="node" width="50%"><img src="templates/style/images/treetable/tv-expandable.gif" ectype="flex" status="open" fieldid="<?php echo $this->_var['prop']['pid']; ?>"><span><?php echo htmlspecialchars($this->_var['prop']['name']); ?></span></td>
            <td class="align_center"><span><?php echo $this->_var['prop']['sort_order']; ?></span></td>
            <td class="align_center"><?php if ($this->_var['prop']['status']): ?><img src="templates/style/images/positive_enabled.gif" /><?php else: ?><img src="templates/style/images/positive_disabled.gif"/><?php endif; ?></td>
            <td  width="200"><span><a href="index.php?app=props&amp;act=edit&amp;pid=<?php echo $this->_var['prop']['pid']; ?>">编辑</a>
                |
                <a href="javascript:if(confirm('删除该属性会同时删除该属性下面的所有属性值，你确定要删除吗？'))window.location = 'index.php?app=props&amp;act=drop&amp;pid=<?php echo $this->_var['prop']['pid']; ?>';">删除</a> | <a href="index.php?app=props&amp;act=add_value&amp;pid=<?php echo $this->_var['prop']['pid']; ?>">新增属性值</a></span>
            </td>
        </tr>  
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if ($this->_var['prop_list']): ?></tbody><?php endif; ?>
        <tfoot>
            <tr class="tr_pt10">
            <?php if ($this->_var['prop_list']): ?>
                <td class="align_center"><label for="checkall1"><input id="checkall_2" type="checkbox" class="checkall"></label></td>
                <td colspan="4" id="batchAction">
                    <span class="all_checkbox"><label for="checkall_2">全选</label></span>&nbsp;&nbsp;
                    <input class="formbtn batchButton" type="submit" value="删除" presubmit="confirm('你确定要删除这些数据么？删除后不可恢复');" />
                </td>
            <?php endif; ?>
            </tr>
        </tfoot>
    </table>
    </form>
</div>

<?php echo $this->fetch('footer.html'); ?>