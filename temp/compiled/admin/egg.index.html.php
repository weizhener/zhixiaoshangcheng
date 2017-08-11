<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>砸蛋设置</p>
    <ul class="subnav">
        <li><?php if ($this->_var['wait_verify']): ?><a class="btn1" href="index.php?app=egg">管理</a><?php else: ?><span>管理</span><?php endif; ?></li>
        <li style="display:none"><a class="btn1" href="index.php?app=egg&amp;act=add">新增</a></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">

    </div>
    <div class="fontr">
        <?php if ($this->_var['eggs']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['eggs']): ?>
        <tr class="tatr1">
            <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
            <td align="left"><span ectype="order_by" fieldname="name">名称</span></td>
            <td align="left"><span ectype="order_by" fieldname="noun">积分</span></td>
            <td align="left"><span ectype="order_by" fieldname="rate">中奖比例（千分比，请填1-1000的数）</span></td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['eggs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'egg');if (count($_from)):
    foreach ($_from AS $this->_var['egg']):
?>
        <tr class="tatr2">
            <td class="firstCell"><input value="{egg.id}" class='checkitem' type="checkbox" /></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['egg']['name']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['egg']['noun']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['egg']['rate']); ?></td>
            <td class="handler">
                <a href="index.php?app=egg&amp;act=edit&amp;id=<?php echo $this->_var['egg']['id']; ?>">编辑</a>  |  <a  style="display:none" name="drop" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=egg&amp;act=drop&amp;id=<?php echo $this->_var['egg']['id']; ?>');">删除</a>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['eggs']): ?>
    <div id="dataFuncs">
        <div id="batchAction" class="left paddingT15">
            <?php if ($this->_var['wait_verify']): ?>
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="通过" name="id" uri="index.php?app=card&act=pass" />
            &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="拒绝" name="id" uri="index.php?app=card&act=refuse" />
            <?php else: ?>
            &nbsp;&nbsp;
            <input  style="display:none" class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=egg&act=drop" presubmit="confirm('确定要删除吗？');" />
            <?php endif; ?>
        </div>
        <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
