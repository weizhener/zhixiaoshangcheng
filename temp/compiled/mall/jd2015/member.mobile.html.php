<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
    $(function() {
        $('#mobile_form').validate({
            errorPlacement: function(error, element) {
                $(element).next('.field_notice').hide();
                $(element).after(error);
            },
            success: function(label) {
                label.addClass('validate_right').text('OK!');
            },
            rules: {
                orig_password: {
                    required: true
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
                },
                phone_mob: {
                    required: true,
                    number: true,
                    byteRange: [11, 11, '<?php echo $this->_var['charset']; ?>'],
                    remote: {
                        url: 'index.php?app=member&act=check_mobile&type=change',
                        type: 'get',
                        data: {
                            phone_mob: function() {
                                return $('#phone_mob').val();
                            }
                        },
                        beforeSend: function() {
                            var _checking = $('#checking_mobile');
                            _checking.next('label').hide();
                            $(_checking).show();

                        },
                        complete: function() {
                            $('#checking_mobile').hide();
                        }
                    }
                }
            },
            messages: {
                orig_password: {
                    required: '原始密码不能为空'
                },
                confirm_code: {
                    required: '短信验证码不能为空',
                    number: '短信验证码必须是数字',
                    byteRange: '短信验证码必须为6位',
                    remote: '短信验证码错误'
                },
                phone_mob: {
                    required: '手机号码必须输入',
                    number: '手机号码必须是数字',
                    byteRange: '手机号码长度必须为11位',
                    remote: '您提供的手机号码已存在,<a href="index.php?app=find_password">点击找回密码</a>'
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
            $.ajax({
                type: "get",
                url: "index.php?app=member&act=send_code&type=change",
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
                    } else {
                        alert("短信发送失败，请检查手机号码是否正确！");
                    }
                }
            });
        });
    });


</script>
<style>
    .borline td {padding:10px 0px;}
    .ware_list th {text-align:left;}
    .bgwhite {background: #FFFFFF;}
</style>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap information">
            <div class="eject_con bgwhite info">
                <div class="add">
                    <form method="post" id="mobile_form">
                        <ul>
                            <li><h3>您的密码:</h3>
                                <p><input class="text width_normal" type="password" name="orig_password" /></p>
                            </li>
                            <?php if ($this->_var['user']['phone_mob']): ?>
                            <li><h3>原手机号码：:</h3>
                                <p><input class="text width_normal" type="text" disabled=disabled id="old_phone_mob" name="old_phone_mob" value="<?php echo htmlspecialchars($this->_var['user']['phone_mob']); ?>"/></p>
                            </li>
                            <?php endif; ?>
                            <li><h3>手机号码:</h3>
                                <p><input class="text width_normal" type="text" id="phone_mob" name="phone_mob" value=""/></p>
                                <label id="checking_mobile" class="checking">检查中...</label>
                            </li>
                            <li><h3></h3>
                                <p style="margin-left:100px;"><input type="button" id="sendsms" value="免费发送短信验证码"/></p>
                            </li>
                            <li><h3>验证码:</h3>
                                <p ><input class="text width_normal" type="text" id="confirm_code" name="confirm_code" value=""/></p>
                                <label id="checking_code" class="checking">检查中...</label>
                            </li>
                        </ul>
                        <p style="margin-left:100px;"><input class="btn" type="submit" value="绑定" /></p>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
