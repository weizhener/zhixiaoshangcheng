<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
.dataTable td{text-align:center;}
</style>
<div id="rightTop">
    <p>供求信息</p>
    <ul class="subnav">
        <li><span>信息管理</span></li>
        <li><a class="btn1" href="index.php?app=supply_demand&amp;act=wait_verify">待审核</a></li>
        <li><a class="btn1" href="index.php?app=supply_demand&amp;act=cate">分类管理</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="supply_demand" />
                <input type="hidden" name="act" value="index" />
                <select class="querySelect" name="field"><?php echo $this->html_options(array('options'=>$this->_var['search_options'],'selected'=>$_GET['field'])); ?>
                </select>:<input class="queryInput" type="text" name="search_name" value="<?php echo htmlspecialchars($this->_var['query']['search_name']); ?>" />
                选择分类:
                <select class="querySelect" id="cate_id" name="cate_id">
                <option value="">请选择...</option>
                <?php echo $this->html_options(array('options'=>$this->_var['parents'],'selected'=>$_GET['cate_id'])); ?>
                </select>
                选择类型:
                <select class="querySelect" name="type">
                <option value="">请选择...</option>
                <?php echo $this->html_options(array('options'=>$this->_var['type'],'selected'=>$_GET['type'])); ?>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=supply_demand">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['infos']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">标题</td>
            <td>类型</td>
            <td>价格</td>
            <td>所属分类</td>
            <td>用户名</td>
            <td>联系人</td>
            <td>电话</td>
            <td>添加时间</td>
            <td>排序</td>
            <td>操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['infos']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'info');if (count($_from)):
    foreach ($_from AS $this->_var['info']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php if (! $this->_var['info']['code']): ?><input type="checkbox" class="checkitem" value="<?php echo $this->_var['info']['info_id']; ?>"/><?php endif; ?></td>
            <td><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=sdemand&amp;act=view&amp;id=<?php echo $this->_var['info']['id']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['info']['title']); ?></a></td>
            <td align="center"><?php if ($this->_var['info']['type'] == 1): ?>供应<?php else: ?>求购<?php endif; ?></td>
            <td align="center"><?php if ($this->_var['info']['type'] == 2): ?><?php if ($this->_var['info']['price_from'] == 0 && $this->_var['info']['price_to'] == 0): ?>面议<?php else: ?><?php echo price_format($this->_var['info']['price_from']); ?> - <?php echo price_format($this->_var['info']['price_to']); ?><?php endif; ?><?php else: ?><?php if ($this->_var['info']['price'] == 0): ?>面议<?php else: ?><?php echo price_format($this->_var['info']['price']); ?><?php endif; ?><?php endif; ?></td>
            <td><?php echo htmlspecialchars($this->_var['info']['cate_name']); ?></td>
            <td><?php echo $this->_var['info']['user_name']; ?></td>
            <td><?php echo $this->_var['info']['name']; ?></td>
            <td><?php echo $this->_var['info']['phone']; ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['info']['add_time']); ?></td>
            <td><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['info']['id']; ?>" datatype="pint" maxvalue="255" class="editable"><?php echo $this->_var['info']['sort_order']; ?></span></td>
            <td>
            	<a href="<?php echo $this->_var['site_url']; ?>/index.php?app=sdemand&amp;act=view&amp;id=<?php echo $this->_var['info']['id']; ?>" target="_blank">查看</a> |
                <a href="javascript:drop_confirm('删除该分类将会同时删除该分类的所有下级分类，您确定要删除吗', 'index.php?app=supply_demand&amp;act=drop&amp;id=<?php echo $this->_var['info']['id']; ?>');">删除</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有相关数据</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['infos']): ?>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <div id="batchAction" class="left paddingT15">
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=supply_demand&act=drop" presubmit="confirm('删除该分类将会同时删除该分类的所有下级分类，您确定要删除吗');" />
        </div>
    </div>
    <div class="clear"></div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>
