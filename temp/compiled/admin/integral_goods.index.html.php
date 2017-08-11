<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>积分产品</p>
    <ul class="subnav">
        <li><?php if ($this->_var['wait_verify']): ?><a class="btn1" href="index.php?app=integral_goods">管理</a><?php else: ?><span>管理</span><?php endif; ?></li>
        <li><a class="btn1" href="index.php?app=integral_goods&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input type="hidden" name="app" value="integral_goods" />
                <input type="hidden" name="act" value="index" />
                产品名称:
                <input class="queryInput" type="text" name="goods_name" value="<?php echo htmlspecialchars($this->_var['query']['goods_name']); ?>" />
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=integral_goods">撤销检索</a>
            <?php endif; ?>
            <span>
            </span></form>
    </div>
    <div class="fontr">
        <?php if ($this->_var['integral_goods_list']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['integral_goods_list']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left">产品名称</td>
            <td align="left" class="table-center">产品图片</td>
            <td align="left">产品库存</td>
            <td align="left">已兑换</td>
            <td align="left">产品价值</td>
            <td align="left">兑换积分</td>
            <td align="left">添加时间</td>
            <td class="table-center">排序</td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['integral_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'integral_goods');if (count($_from)):
    foreach ($_from AS $this->_var['integral_goods']):
?>
        <tr class="tatr2">
            <td class="firstCell">
                <input value="<?php echo $this->_var['integral_goods']['goods_id']; ?>" class='checkitem' type="checkbox" />
            </td>
            <td align="left"><?php echo htmlspecialchars($this->_var['integral_goods']['goods_name']); ?></td>
            <td align="left" class="table-center"><?php if ($this->_var['integral_goods']['goods_logo']): ?><img src="<?php echo $this->_var['integral_goods']['goods_logo']; ?>" height="30"/><?php endif; ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['integral_goods']['goods_stock']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['integral_goods']['goods_stock_exchange']); ?></td>
            <td align="left"><?php echo price_format($this->_var['integral_goods']['goods_price']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['integral_goods']['goods_point']); ?></td>
            <td align="left"><?php echo local_date("Y-m-d",$this->_var['integral_goods']['add_time']); ?></td>

            <td class="table-center"><?php echo $this->_var['integral_goods']['sort_order']; ?></td>  
            <td class="handler">
                <a href="index.php?app=integral_goods&amp;act=edit&amp;id=<?php echo $this->_var['integral_goods']['goods_id']; ?>">编辑</a>  |  <a name="drop" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=integral_goods&amp;act=drop&amp;id=<?php echo $this->_var['integral_goods']['goods_id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="7">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['integral_goods_list']): ?>
    <div id="dataFuncs">
        <div id="batchAction" class="left paddingT15">
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=integral_goods&act=drop" presubmit="confirm('您确定要删除它吗？');" />
        </div>
        <div class="pageLinks">
            <?php if ($this->_var['integral_goods_list']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
        </div>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
