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
                    required: true
                },
                phone_mob: {
                    required: true,
                    number: true,
                    byteRange: [11, 11, '<?php echo $this->_var['charset']; ?>'],
                    remote: {
                        url: 'index.php?app=member&act=check_mobile&type=find',
                        type: 'get',
                        data: {
                            phone_mob: function() {
                                return $('#phone_mob').val();
                            }
                        },
                        beforeSend: function() {
                            var _checking = $('#checking_mobile');
                            _checking.prev('.field_notice').hide();
                            _checking.next('label').hide();
                            $(_checking).show();

                        },
                        complete: function() {

                            $('#checking_mobile').hide();
                        }
                    }
                },
                confirm_code: {
                    required: true,
                    number: true,
                    byteRange: [6, 6, '<?php echo $this->_var['charset']; ?>'],
                    remote: {
                        url: 'index.php?app=member&act=cmc&ajax=1',
                        type: 'get',
                        data: {
                            confirm_code: function() {
                                return $('#confirm_code').val();
                            }
                        },
                        beforeSend: function() {
                            var _checking = $('#checking_code');
                            _checking.next('label').hide();
                            $(_checking).show();

                        },
                        complete: function() {
                            $('#checking_code').hide();
                        }
                    }
                }
            },
            messages: {
                username: {
                    required: '用户名不能为空'
                },
                phone_mob: {
                    required: '手机号码不能为空',
                    number: 'phone_mob_number',
                    byteRange: 'phone_mob_limit',
                    remote: '手机号码不存在'
                },
                confirm_code: {
                    required: '手机验证码不能为空',
                    number: 'mobile_code_must_be_number',
                    byteRange: '短信验证码必须为6位',
                    remote: '短信验证码错误'
                }

            }
        });

        var canSend = true;
        var time = 60;
        var dtime = 60;
        $("#sendsms").bind('click', function() {
            var btn = $(this);
            if (!canSend)
                return;

            var sendaddress = $('#phone_mob').val();
            var fhm = $("[for='phone_mob']").text();
            if (fhm != '' && fhm != "OK!") {
                alert("请输入正确的手机号码！");
                return;
            }
            if (fhm == '' && $('#phone_mob').val() == "") {
                alert("请输入正确的手机号码！");
                return;
            }
            canSend = false;
            $.ajax({
                type: "get",
                url: "index.php?app=member&act=send_code&type=find",
                data: {
                    mobile: function() {
                        return sendaddress;
                    }
                },
                success: function(msg) {
                    var hander = setInterval(function() {
                        if (time <= 0) {
                            canSend = true;
                            clearInterval(hander);
                            btn.val("重新发送验证码");
                            btn.removeAttr("disabled");
                            time = dtime;
                        } else {
                            canSend = false;
                            btn.attr({
                                "disabled": "disabled"
                            });
                            btn.val(time + "秒后可重新发送");
                            time--;
                        }
                    },
                            1000);
                    if (msg) {
                        alert("短信已发送至:" + sendaddress + " 请注意查收！");
                        $('#phone_mob').attr({"readonly": "readonly"});
                    } else {
                        canSend = true;
                        alert("短信发送失败，请检查手机号码是否正确！");
                    }
                }
            });

        });
    });
</script>        


<div id="main" class="w-full">
    <div id="page-find-password" class="w login-register mt20 mb20">
        <div class="w clearfix">
            <div class="col-main">
                <div class="fp-edit-field" area="fp_left" widget_type="area">
                    <?php $this->display_widgets(array('page'=>'find_password','area'=>'fp_left')); ?>
                </div>
            </div>
            <div class="col-sub">
                <div class="form">
                    <div class="title">手机找回密码</div>
                    <div class="content">
                        <form action="" method="POST" id="find_password_form">
                            <dl class="clearfix">
                                <dt>登录账号</dt>
                                <dd>
                                    <input class="input" type="text" name="username" id="username" />
                                    <div class="clr"></div><label></label>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt>手机号码</dt>
                                <dd>
                                    <input type="text" id="phone_mob" name="phone_mob" class="input" maxlength="11" />
                                    <br /><label></label>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt>验证码</dt>
                                <dd>
                                    <input class="input" type="text" id="confirm_code" name="confirm_code" value="" maxlength="6"/>
                                    <br /><label></label>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt></dt>
                                <dd style="padding-left:88px;">
                                    <input type="button" id="sendsms" value="发送验证码" />
                                    <br /><label></label>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt>&nbsp;</dt>
                                <dd class="clearfix">
                                    <input type="submit" class="fp-submit" name="Submit" value="找回密码" title="找回密码" />
                                    <a href="index.php?app=find_password" style="color: #0081EF;">邮箱找回密码</a>
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