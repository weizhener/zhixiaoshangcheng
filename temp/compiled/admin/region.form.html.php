<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>地区设置</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=region">管理</a></li>
        <li><?php if ($this->_var['region']['region_id']): ?><a class="btn1" href="index.php?app=region&amp;act=add">新增</a><?php else: ?><span>新增</span><?php endif; ?></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    地区名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="region_name" type="text" name="region_name" value="<?php echo htmlspecialchars($this->_var['region']['region_name']); ?>" />                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="parent_id">上级地区:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <select id="parent_id" name="parent_id"><option value="0">请选择...</option><?php echo $this->html_options(array('options'=>$this->_var['parents'],'selected'=>$this->_var['region']['parent_id'])); ?></select>                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['region']['sort_order']; ?>" />                </td>
            </tr>
        <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="reset" value="重置" />            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
