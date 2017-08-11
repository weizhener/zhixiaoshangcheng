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
                    邮件标题:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="title" type="text" name="subject" value="<?php echo htmlspecialchars($this->_var['mailtemplate']['subject']); ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="link">邮件正文:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <textarea style="width:650px;height:300px;" name="content"><?php echo $this->_var['mailtemplate']['content']; ?></textarea>
                </td>
            </tr>
            <?php if ($this->_var['cycleimg']['img']): ?>
            <?php endif; ?>
            <tr>
            <th></th>
            <td class="ptb20">
                <input type="hidden" name="version" value="<?php echo $this->_var['mailtemplate']['version']; ?>" />
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="reset" value="重置" />
            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
