<?php echo $this->fetch('header.html'); ?>
<script language="javascript">
$(function(){
    $("input[name='backup_type']").each(function(){
    $(this).click(function(){
        if($(this).val() == 'backup_custom'){
            $("*[ectype='tables']").show();
            $("*[ectype='tables']").find('input').removeAttr('disabled');
        }else{
            $("*[ectype='tables']").hide();
            $("*[ectype='tables']").find('input').attr('disabled','true');
        }
    });
    });
});
</script>
<div id="rightTop">
    <p>数据库</p>
    <ul class="subnav">
        <?php if ($_GET['act'] == 'backup'): ?>
        <li><span>备份</span></li>
        <?php else: ?>
        <li><a class="btn1" href="index.php?app=db&amp;act=backup">
        备份</a></li>
        <?php endif; ?>
        <?php if ($_GET['act'] == 'restore'): ?>
        <li><span>恢复</span></li>
        <?php else: ?>
        <li><a class="btn1" href="index.php?app=db&amp;act=restore">
        恢复</a></li>
        <?php endif; ?>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
              <th class="paddingT15">备份方式:</th>
              <td class="paddingT15 wordSpacing5"><input name="backup_type" type="radio" id="backup_all" value="backup_all" checked="checked" />
              <label for="backup_all">备份全部数据</label> <input type="radio" name="backup_type" id="backup_custom" value="backup_custom" />
              <label for="backup_custom">备份选定的表</label></td>
            </tr>
            <tr style="display:none" ectype="tables">
                <th class="paddingT15">
                    数据表:</th>
                <td class="paddingT15 wordSpacing5">
                <ul>
                <li style="height:20px;"><input id="checkall" disabled="true" type="checkbox" class="checkall" checked="checked" />
                <label for="checkall">全选</label>
                </li>
                <?php $_from = $this->_var['tables']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('table', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['table'] => $this->_var['item']):
?>
                <li style="float:left; width:28%; height:20px;"><input name="tables[<?php echo $this->_var['table']; ?>]" class="checkitem" disabled="true" type="checkbox" value="-1" checked="checked" /><?php echo $this->_var['table']; ?></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>                </td>
            </tr>

            <tr style="display:none">
            <th class="paddingT15">扩展插入:</th>
            <td class="paddingT15 wordSpacing5">
            <input id="yes" type="radio" name="ext_insert" value="1" />
            <label for="yes">是</label>
            <input id="no" type="radio" name="ext_insert" value="0" checked="checked" />
            <label for="no">否</label>
            <label class="field_notice">扩展插入方式可以减小备份文件大小</label>
            </td>
        </tr>

        <tr>
            <th class="paddingT15">分卷大小(kb):</th>
            <td class="paddingT15 wordSpacing5">
            <input name="vol_size" value="<?php echo $this->_var['vol_size']; ?>" />
            <label class="field_notice">分卷大小至少为10K</label>
            </td>
        </tr>
        <tr>
            <th class="paddingT15">备份名:</th>
            <td class="paddingT15 wordSpacing5">
             <input name="backup_name" value="<?php echo $this->_var['backup_name']; ?>" />
             <label class="field_notice">备份名字由1到20位数字、字母或下划线组成</label>
             </td>
        </tr>
        <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" value="提交" onclick="return drop_confirm('为保证数据完整性请确保您的站点处于关闭状态，您确定要马上执行当前操作吗？');"/>
                <input class="formbtn" type="reset" name="Submit2" value="重置" />            </td>
        </tr>
        </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
