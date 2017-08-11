<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function() {
        $('#find_password_form').validate({
            errorPlacement: function(error, element) {
                var error_td = element.parent('dd');
                error_td.find('label').hide();
                error_td.append(error);
            },
            success: function(label) {
                label.addClass('validate_right').text('OK!');
            },
            rules: {
                username: {
                    required: true,                                        rangelength:[5,10]
                },                telephone: {required: true,                                        minlength: 11,                                        maxlength:11},                identity_card: {required: true,                                        minlength: 18,                                        maxlength:18},
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
                },                identity_card: {                    required: '您必须输入身份证',                    minlength: '身份证号码最少长度为18位'                },                telephone: {                    required: '你必须提供电话号码',                    minlength: '电话号码长度为11位'                },
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
<div id="main" class="w-full">
    <div id="page-find-password" class="w login-register mt20 mb20">
        <div class="w logo mb10">
            <a href="<?php echo $this->_var['site_url']; ?>" title="<?php echo $this->_var['site_title']; ?>"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a>
        </div>
        <div class="w clearfix">
            <div class="col-main">
                <div class="fp-edit-field" area="fp_left" widget_type="area">
                    <?php $this->display_widgets(array('page'=>'find_password','area'=>'fp_left')); ?>
                </div>
            </div>
            <div class="col-sub">
                <div class="form">
                    <div class="title">找回密码</div>
                    <div class="content">
                        <form action="" method="POST" id="find_password_form">
                            <dl class="clearfix">
                                <dt>登录账号</dt>
                                <dd>
                                    <input class="input" type="text" name="username" id="username" />
                                    <div class="clr"></div><label></label>
                                </dd>
                            </dl>                                                        <dl class="clearfix">                                <dt>手机号码</dt>                                <dd>                                    <input type="text" style="width:245px;height:26px;" id="telephone" class="input"  name="telephone" title="请输入有效11位手机号码"  />                                    <br /><label></label>                                </dd>                            </dl>                                                            <dl class="clearfix">                                <dt>身份证号码</dt>                                <dd>                                    <input type="text" style="width:245px;height:26px;" id="identity_card" class="input"  name="identity_card" title="请输入身份证号码、方便找回密码"  />                                    <br /><label></label>                                </dd>                            </dl>                                                        <!-- 
                            <dl class="clearfix">
                                <dt>电子邮箱</dt>
                                <dd>
                                    <input class="input" type="text" name="email" id="email" />
                                    <div class="clr"></div><label></label>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt>验证码</dt>
                                <dd class="captcha clearfix">
                                    <input type="text" class="input float-left" name="captcha" id="captcha1" />
                                    <img height="26" id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" class="float-left" />
                                    <a href="javascript:change_captcha($('#captcha'));" class="float-left">看不清，下一张</a>
                                    <div class="clr"></div><label></label>
                                </dd>
                            </dl>                             -->
                            <dl class="clearfix">
                                <dt>&nbsp;</dt>
                                <dd class="clearfix">
                                    <input type="submit" class="fp-submit" name="Submit" value="找回密码" title="找回密码" />
                                    <a href="index.php?app=find_password&act=mobile" style="color: #0081EF;">手机找回密码</a>
                                    <input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />
                                </dd>
                            </dl>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>