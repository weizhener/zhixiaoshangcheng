<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function() {
        $('#send_test_email').click(send_test_email);
    });
    function send_test_email() {
        var email_type = $('input[name="email_type"]:checked').val();
        $.ajax({
            type: "POST",
            url: "index.php",
            data: 'app=setting&act=send_test_email&email_type=' + email_type + '&email_host=' + $("#email_host").val() + '&email_port=' + $("#email_port").val() + '&email_addr=' + $("#email_addr").val() + '&email_id=' + $("#email_id").val() + '&email_pass=' + $("#email_pass").val() + '&email_test=' + $("#email_test").val(),
            dataType: "json",
            success: function(data) {
                if (data.done) {
                    alert(data.msg);
                }
                else {
                    alert(data.msg);
                }
            },
            error: function() {
                alert('测试邮件发送失败，请重新配置邮件服务器');
            }
        });
    }
</script>



<div id="rightTop">
    <p>网站设置</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">系统设置</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">基本信息</a></li>
        <li><span>Email</span></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=captcha_setting">验证码</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">开店设置</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=buyer_credit_setting">买家等级</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=seller_credit_setting">卖家等级</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">二级域名</a></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    <label for="email_type">邮件发送方式:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->html_radios(array('name'=>'email_type','options'=>$this->_var['mail_type'],'checked'=>$this->_var['setting']['email_type'])); ?>
                    <label class="field_notice">如果您选择服务器内置方式则无须填写以下选项</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP 服务器:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_host" type="text" name="email_host" value="<?php echo $this->_var['setting']['email_host']; ?>"/>
                    <label class="field_notice">设置 SMTP 服务器的地址</label></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP 端口:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_port" type="text" name="email_port" value="<?php echo $this->_var['setting']['email_port']; ?>"/>
                    <label class="field_notice">设置 SMTP 服务器的端口，默认为 25</label></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    发信人邮件地址:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_addr" type="text" name="email_addr" value="<?php echo $this->_var['setting']['email_addr']; ?>"/>
                    <label class="field_notice">如果 SMTP 服务器要求身份验证，必须为本服务器的邮件地址</label></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP 身份验证用户名:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_id" type="text" name="email_id" value="<?php echo $this->_var['setting']['email_id']; ?>"/></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    SMTP 身份验证密码:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_pass" type="password" name="email_pass" value="<?php echo $this->_var['setting']['email_pass']; ?>"/></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    测试邮件地址:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="email_test" type="text" name="email_test" value="<?php echo $this->_var['setting']['email_test']; ?>"/>&nbsp;&nbsp;<input id="send_test_email" class="formbtn" type="button" name="send_test_email" value="测试" /></td>
            </tr>
            <tr>
                <th></th>
                <td class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="提交" />
                    <input class="formbtn" type="reset" name="Submit2" value="重置" />
                </td>
            </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
