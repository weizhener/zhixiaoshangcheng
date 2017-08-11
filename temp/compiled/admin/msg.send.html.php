<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
    .info th{width:80px;}
</style>
<div id="rightTop">
    <ul class="subnav" style="margin-left:0px;">
        <li><a class="btn1" href="index.php?app=msg">发送记录</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=user">短信用户</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=add">增加短信</a></li>
        <li><span>短信发送</span></li>
        <li><a class="btn1" href="index.php?app=msg&act=setting">设置接口</a></li>
    </ul>
</div>

<div class="info">
    <table class="infoTable">
        <form method="post">
            <tr>
                <th class="paddingT15">手机号码:</th>
                <td class="paddingT15 wordSpacing5">
                    <input type="text" class="text width_normal" name="to_mobile" value=""/><span style="margin-left:10px; color:#999;">填写接收手机信息的号码</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">内 容: </th>
                <td class="paddingT15 wordSpacing5">
                    <textarea class="text width_long" name="msg_content" /></textarea>
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="确定发送" />
                    <input class="formbtn" type="reset" name="Submit2" value="重置" />
                </td>
            </tr>
        </form>
    </table>	
</div>
<?php echo $this->fetch('footer.html'); ?>