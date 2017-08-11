<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
function clean_file()
{
    $.getJSON('index.php?app=widget&act=clean_file', function(data){
        if (!data.done)
        {
            alert(data.msg);

            return;
        }
        else
        {
            if (confirm(data.msg))
            {
                $.getJSON('index.php?app=widget&act=clean_file&continue', function(rzt){
                    alert(rzt.msg);
                });
            }
        }

    });
}
</script>
<div id="rightTop">
    <p>挂件管理</p>
    <ul class="subnav">
        <li><span>商城挂件</span></li>
        <li><a class="btn1" href="index.php?app=widget_store">店铺挂件</a></li>
        <li>[<a href="javascript:void(0);" onclick="clean_file();" title="孤立文件是指被上传到服务器上，但实际并没有被引用的文件，重复配置有上传文件的挂件，会产生孤立文件，因此需要定时清理这些文件以释放硬盘空间">清理孤立文件</a>]</li>
    </ul>
</div>
<div class="tdare info">
    <table width="100%" cellspacing="0">
        <?php if ($this->_var['widgets']): ?>
        <tr class="tatr1">
            <td width="15%">挂件名称</td>
            <td align="left">挂件描述</td>
            <td width="10%">作者</td>
            <td width="50">版本</td>
            <td class="handler" style="width:150px;">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['widgets']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'widget');if (count($_from)):
    foreach ($_from AS $this->_var['widget']):
?>
        <tr class="tatr2">
            <td><?php echo htmlspecialchars($this->_var['widget']['display_name']); ?></td>
            <td align="left"><?php echo htmlspecialchars($this->_var['widget']['desc']); ?></td>
            <td><a href="<?php echo $this->_var['widget']['website']; ?>" target="_blank" title="作者链接"><?php echo htmlspecialchars($this->_var['widget']['author']); ?></a></td>
            <td><?php echo htmlspecialchars($this->_var['widget']['version']); ?></td>
            <td class="handler">
                <a href="index.php?app=widget&amp;act=edit&name=<?php echo $this->_var['widget']['name']; ?>&file=script">编辑脚本</a>
                |
                <a href="index.php?app=widget&amp;act=edit&name=<?php echo $this->_var['widget']['name']; ?>&file=template">编辑模板</a>
                </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">尚未安装任何挂件</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
</div>
<?php echo $this->fetch('footer.html'); ?>
