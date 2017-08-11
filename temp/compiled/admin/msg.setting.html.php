<?php echo $this->fetch('header.html'); ?>


<div id="rightTop">
    <ul class="subnav" style="margin:0;">
        <li><a class="btn1" href="index.php?app=msg">发送记录</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=user">短信用户</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=add">增加短信</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=send">短信发送</a></li>
        <li><span>设置接口</span></li>
    </ul>
</div>

<div class="info">

    <table class="infoTable">
        <form method="post">
            <tr>
                <th class="paddingT15">
                    是否开启短信:</th>
                <td class="paddingT15 wordSpacing5">
                    <input id="msg_enabled0" type="radio" name="msg_enabled" <?php if ($this->_var['setting']['msg_enabled'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="msg_enabled0">关闭</label>
                    <input id="msg_enabled1" type="radio" name="msg_enabled" <?php if ($this->_var['setting']['msg_enabled'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="msg_enabled1">开启</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">短信用户名:</th>
                <td class="paddingT15 wordSpacing5">
                    <input name="msg_pid" type="text" value="<?php echo $this->_var['setting']['msg_pid']; ?>" size="20">
                </td>
            </tr>
            <tr>
                <th class="paddingT15">短信密钥:</th>
                <td class="paddingT15 wordSpacing5">
                    <input name="msg_key" type="text" value="<?php echo $this->_var['setting']['msg_key']; ?>" size="20">
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="提交" />
                    <input class="formbtn" type="reset" name="Submit2" value="重置" />
                </td>
            </tr>
        </form>
    </table>	
</div>
<?php echo $this->fetch('footer.html'); ?>