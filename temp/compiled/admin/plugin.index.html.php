<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p><strong>插件管理</strong></p>
</div>
<div class="tdare info">
    <table width="100%" cellspacing="0">
        <?php if ($this->_var['plugins']): ?>
        <tr class="tatr1">
            <td width="15%">插件名称</td>
            <td align="left">插件描述</td>
            <td width="10%">作者</td>
            <td width="10%">版本</td>
            <td class="handler">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['plugins']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'plugin');if (count($_from)):
    foreach ($_from AS $this->_var['plugin']):
?>
        <tr class="tatr2">
            <td><?php echo htmlspecialchars($this->_var['plugin']['name']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['plugin']['desc']); ?></td>
            <td><a href="<?php echo $this->_var['plugin']['website']; ?>" target="_blank" title="作者链接"><?php echo htmlspecialchars($this->_var['plugin']['author']); ?></a></td>
            <td><?php echo htmlspecialchars($this->_var['plugin']['version']); ?></td>
            <td class="handler">
                <?php if (! $this->_var['plugin']['enabled']): ?>
            <a href="index.php?app=plugin&amp;act=enable&amp;id=<?php echo $this->_var['plugin']['id']; ?>">启用</a>
                <?php else: ?>
                <a href="javascript:if(confirm('您确定要禁用它吗？'))window.location='index.php?app=plugin&act=disable&id=<?php echo $this->_var['plugin']['id']; ?>';">禁用</a>
                <?php if ($this->_var['plugin']['config']): ?>
                |
                <a href="index.php?app=plugin&amp;act=config&id=<?php echo $this->_var['plugin']['id']; ?>">配置</a>
                <?php endif; ?>
                <?php endif; ?>
                </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td class="no_records" colspan="5">尚未安装任何插件</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
<?php echo $this->fetch('footer.html'); ?>