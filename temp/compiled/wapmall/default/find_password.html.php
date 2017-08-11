<?php echo $this->fetch('header.html'); ?>

<div class="mb-head">

    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>

    <div class="tit">邮件找回密码</div>

    <a href="<?php echo url('app=member&act=login'); ?>" class="r_b">请登录</a>

</div>

<script type="text/javascript">

    $(function() {

        $('#find_password_form').validate({

            errorPlacement: function(error, element) {

                var error_td = element.parent('td');

                error_td.find('.field_notice').hide();

                error_td.append(error);

            },

            success: function(label) {

                label.addClass('validate_right').text('OK!');

            },

            rules: {

                username: {

                    required: true

                },

                email: {

                    required: true,

                    email: true

                },

                captcha: {

                    required: true,

                    remote: {

                        url: 'index.php?app=captcha&act=check_captcha',

                        type: 'get',

                        data: {

                            captcha: function() {

                                return $('#captcha1').val();

                            }

                        }

                    }

                }

            },

            messages: {

                username: {

                    required: '用户名不能为空'

                },

                email: {

                    required: '电子邮箱不能为空',

                    email: '电子邮箱填写错误'

                },

                captcha: {

                    required: '验证码不能为空',

                    remote: '验证码错误'

                }

            }

        });

    });

</script>







<div class="login_panel" >

    <form class="login_box" id="find_password_form" method="post">

        <table  width="100%">

            <tr>

                <td> <input placeholder="登录账号" type="text" name="username" id="username" class="text">

                    <label class="field_notice"></label></td>

            </tr>

            <tr>

                <td> <input placeholder="电子邮箱" type="text" name="email" id="email" class="text">

                    <label class="field_notice"></label></td>

            </tr>

            <tr>

                <td><input placeholder="验证码" type="text" name="captcha" class="text" id="captcha1" />

                    <a href="javascript:change_captcha($('#captcha'));" class="renewedly"><img id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" /></a>

                    <label class="field_notice"></label>

                </td>

            </tr>



            <tr>

                <td>

                    <input  value="邮件找回"  type="submit" class="red_btn">

                </td>

            </tr>

        </table>

        <input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />

        <p>已有账号？<a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>" >直接登录</a></p>


    </form>

</div>





<?php echo $this->fetch('footer.html'); ?>