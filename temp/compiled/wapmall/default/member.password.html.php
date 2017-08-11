<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">个人中心</div>
    <a href="javascript" class="r_b"></a>
</div>
<script type="text/javascript">
    $(function () {
        $('#password_form').validate({
            errorPlacement: function (error, element) {
                $(element).next('.field_notice').hide();
                $(element).after(error);
            },
            success: function (label) {
                label.addClass('validate_right').text('OK!');
            },
            rules: {
                orig_password: {
                    required: true
                },
                new_password: {
                    required: true,
                    minlength: 6,
                    maxlength: 20
                },
                confirm_password: {
                    required: true,
                    equalTo: '#new_password'
                }
            },
            messages: {
                orig_password: {
                    required: '原始密码不能为空'
                },
                new_password: {
                    required: '密码不能为空',
                    minlength: '密码长度应在6-20个字符之间'
                },
                confirm_password: {
                    required: '密码不能为空',
                    equalTo: '两次输入的密码不相符'
                }
            }
        });
    });
</script>
<style>
    .member_password{margin:10px 16px;}
</style>
<div class="member_password">

    <form method="post" id="password_form">
        <ul class="form_content">
            <li><h3>您的密码:</h3>
                <p><input type="password"  name="orig_password" /></p>
            </li>
            <li>
                <h3>新密码:</h3>
                <p><input type="password"  name="new_password" id="new_password"/></p>
            </li>
            <li>
                <h3>确认密码:</h3>
                <p><input type="password"  name="confirm_password" /></p>
            </li>
        </ul>
            <input class="red_btn" type="submit" value="提交" />
    </form>
</div>
<?php echo $this->fetch('member.footer.html'); ?>