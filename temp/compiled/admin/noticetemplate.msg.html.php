<?php echo $this->fetch('header.html'); ?>
<?php echo $this->_var['build_editor']; ?>
<div id="rightTop">
    <p>通知模板</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=mailtemplate&amp;type=<?php echo $this->_var['notice_mail']; ?>">邮件模板</a></li>
        <li><a class="btn1" href="index.php?app=mailtemplate&amp;type=<?php echo $this->_var['notice_msg']; ?>">短消息模板</a></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    <label for="link">消息内容:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea style="width:650px;height:300px;" name="msgtemplate"><?php echo $this->_var['msgtemplate']; ?></textarea>
                </td>
            </tr>
            <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="reset" value="重置" />
            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
