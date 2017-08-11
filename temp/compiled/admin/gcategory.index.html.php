<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ajax_tree.js'; ?>" charset="utf-8"></script>
<div id="rightTop">
    <p>商品分类</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=gcategory&amp;act=add">新增</a></li>
        <li><a class="btn1" href="index.php?app=gcategory&amp;act=export">导出</a></li>
        <li><a class="btn1" href="index.php?app=gcategory&amp;act=import">导入</a></li>
    </ul>
</div>

<div class="info2">
    <table  class="distinction">
        <?php if ($this->_var['gcategories']): ?>
        <thead>
        <tr class="tatr1">
            <td class="w30"><input id="checkall_1" type="checkbox" class="checkall" /></td>
            <td width="50%"><span class="all_checkbox"><label for="checkall_1">全选</label></span>分类名称</td>
            <td>排序</td>
            <td>显示</td>
            <td class="handler">操作</td>
        </tr>
        </thead>
        <?php endif; ?>
        <?php if ($this->_var['gcategories']): ?><tbody id="treet1"><?php endif; ?>
        <?php $_from = $this->_var['gcategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['gcategory']):
?>
        <tr>
            <td class="align_center w30"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['gcategory']['cate_id']; ?>" /></td>
            <td class="node" width="50%"><?php if ($this->_var['gcategory']['switchs']): ?><img src="templates/style/images/treetable/tv-expandable.gif" ectype="flex" status="open" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>"><?php else: ?><img src="templates/style/images/treetable/tv-item.gif"><?php endif; ?><span class="node_name editable" ectype="inline_edit" fieldname="cate_name" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" required="1" title="可编辑"><?php echo htmlspecialchars($this->_var['gcategory']['cate_name']); ?></span></td>
            <td class="align_center"><span class="editable" ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" datatype="number" title="可编辑"><?php echo $this->_var['gcategory']['sort_order']; ?></span></td>
            <td class="align_center"><?php if ($this->_var['gcategory']['if_show']): ?><img src="templates/style/images/positive_enabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" fieldvalue="1" title="可编辑"/><?php else: ?><img src="templates/style/images/positive_disabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['gcategory']['cate_id']; ?>" fieldvalue="0" title="可编辑"/><?php endif; ?></td>
            
            <td  width="200"><span><a href="index.php?app=gcategory&amp;act=edit&amp;id=<?php echo $this->_var['gcategory']['cate_id']; ?>">编辑</a>
                |
                <a href="javascript:if(confirm('删除该分类将会同时删除该分类的所有下级分类，您确定要删除吗'))window.location = 'index.php?app=gcategory&amp;act=drop&amp;id=<?php echo $this->_var['gcategory']['cate_id']; ?>';">删除</a><?php if ($this->_var['region']['layer'] < $this->_var['max_layer']): ?> | <a href="index.php?app=gcategory&amp;act=add&amp;pid=<?php echo $this->_var['gcategory']['cate_id']; ?>">新增下级</a><?php endif; ?>
                
                | <a href='index.php?app=props&act=distribute&cate_id=<?php echo $this->_var['gcategory']['cate_id']; ?>'>分配属性</a>
                
                
             
                </span>
                </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">暂无商品分类</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if ($this->_var['gcategories']): ?></tbody><?php endif; ?>
        <tfoot>
            <tr class="tr_pt10">
            <?php if ($this->_var['gcategory']): ?>
                <td class="align_center"><label for="checkall1"><input id="checkall_2" type="checkbox" class="checkall"></label></td>
                <td colspan="4" id="batchAction">
                    <span class="all_checkbox"><label for="checkall_2">全选</label></span>&nbsp;&nbsp;
                    <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=gcategory&act=drop" presubmit="confirm('删除该分类将会同时删除该分类的所有下级分类，您确定要删除吗');" />
                    <input class="formbtn batchButton" type="button" value="编辑" name="id" uri="index.php?app=gcategory&act=batch_edit" />
                    <!--<input class="formbtn batchButton" type="button" value="lang.update_order" name="id" presubmit="updateOrder(this);" />-->
                </td>
            <?php endif; ?>
            </tr>
        </tfoot>
    </table>
</div>

<?php echo $this->fetch('footer.html'); ?>