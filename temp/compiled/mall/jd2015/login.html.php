<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function () {
        $('#login_form').validate({
            errorPlacement: function (error, element) {
                var error_td = element.parent('dd');
                error_td.find('label').hide();
                error_td.append(error);
            },
            success: function (label) {
                label.addClass('validate_right').text('OK!');
            },
            onkeyup: false,
            rules: {
                user_name: {
                    required: true
                },
                password: {
                    required: true
                },
                captcha: {
                    required: true,
                    remote: {
                        url: 'index.php?app=captcha&act=check_captcha',
                        type: 'get',
                        data: {
                            captcha: function () {
                                return $('#captcha1').val();
                            }
                        }
                    }
                }
            },
            messages: {
                user_name: {
                    required: '您必须提供一个用户名'
                },
                password: {
                    required: '您必须提供一个密码'
                },
                captcha: {
                    required: '请输入右侧图片中的文字',
                    remote: '验证码错误'
                }
            }
        });
    });
</script>
<div id="main" class="w-full">
    <div id="page-login" class="w login-register mt20 mb20">
        <div class="w clearfix">
            <div class="col-main">
                <div class="login-edit-field" area="login_left" widget_type="area">
                    <?php $this->display_widgets(array('page'=>'login','area'=>'login_left')); ?>
                </div>
            </div>
            <div class="col-sub">
                <div class="form">
                    <div class="title">用户登录</div>
                    <div class="content">
                        <form method="post" id="login_form">
                            <dl class="clearfix">
                                <dt>用户名</dt>
                                <dd>
                                    <input class="input" type="text" name="user_name"  />
                                    <div class="clr"></div><label></label>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt>密&nbsp;&nbsp;&nbsp;码</dt>
                                <dd>
                                    <input class="input" type="password" name="password"/>
                                    <div class="clr"></div><label></label>
                                </dd>
                            </dl>

                            <?php if ($this->_var['captcha']): ?>
                            <dl class="clearfix">
                                <dt>验证码</dt>
                                <dd class="captcha clearfix">
                                    <input type="text" class="input float-left" name="captcha" id="captcha1" />
                                    <img height="26" id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" class="float-left" />
                                    <a href="javascript:change_captcha($('#captcha'));" class="float-left">看不清，换一张</a>
                                    <div class="clr"></div><label></label>
                                </dd>
                            </dl>
                            <?php endif; ?>
                            <dl class="clearfix">
                                <dt>&nbsp;</dt>
                                <dd class="clearfix">
                                    <input type="submit" class="login-submit" name="Submit" value="请登录" title="请登录" />
                                    <a href="<?php echo url('app=find_password'); ?>" class="find-password">忘记密码？</a>
                                    <input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt>&nbsp;</dt>
                                <dd class="register-now">
                                    如果您还不是会员，请<a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>" title="注册">注册</a>
                                </dd>
                            </dl>                            <!-- 
                            <div class="partner-login">
                                <h3>你可以用合作伙伴账号登陆</h3>
                                <p><a class="qq-login" href="<?php echo url('app=third_login&act=qq'); ?>"></a><a class="weibo-login" href="<?php echo url('app=third_login&act=sina'); ?>"></a></p>
                            </div>                                                        -->
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>