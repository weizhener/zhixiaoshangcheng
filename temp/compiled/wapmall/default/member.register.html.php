<?php echo $this->fetch('header.html'); ?>

<div class="mb-head">

    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>

    <div class="tit">注册</div>

    <a href="<?php echo url('app=member&act=login'); ?>" class="r_b">请登录</a>

</div>



<script type="text/javascript">

//注册表单验证

    $(function() {

        $('#register_form').validate({

            errorPlacement: function(error, element) {

                var error_td = element.parent('td');

                error_td.find('.field_notice').hide();

                error_td.append(error);

            },

            success: function(label) {

                label.addClass('validate_right').text('OK!');

            },

            onkeyup: false,

            rules: {

                user_name: {

                    required: true,

                    byteRange: [3, 15, '<?php echo $this->_var['charset']; ?>'],

                    remote: {

                        url: 'index.php?app=member&act=check_user&ajax=1',

                        type: 'get',

                        data: {

                            user_name: function() {

                                return $('#user_name').val();

                            }

                        },

                        beforeSend: function() {

                            var _checking = $('#checking_user');

                            _checking.prev('.field_notice').hide();

                            _checking.next('label').hide();

                            $(_checking).show();

                        },

                        complete: function() {

                            $('#checking_user').hide();

                        }

                    }

                },

                phone_mob: {

                    required: true,

                    number: true,

                    byteRange: [11, 11, '<?php echo $this->_var['charset']; ?>'],

                    remote: {

                        url: 'index.php?app=member&act=check_mobile&type=register',

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

                            },

							   email: function() {

                                return $('#email').val();

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

                password: {

                    required: true,

                    minlength: 6

                },
                real_name: {

                    required: true,

                    rangelength:[1,10]

                },
                identity_card: {

                    required: true,

                    minlength: 18,
                    
                    maxlength:18

                },
                telephone: {

                    required: true,
					
					digits:true,

                    minlength: 11,
                    
                    maxlength:18

                },

                password_confirm: {

                    required: true,

                    equalTo: '#password'

                },

                 email: {

                required : true,

                email    : true,

				remote   : {

                    url :'index.php?app=member&act=check_email_info&ajax=1',

                    type:'get',

                    data:{

                        email : function(){

                            return $('#email').val();

                        }

                    },

                    beforeSend:function(){

                        var _checking = $('#checking_email');

                        _checking.prev('.field_notice').hide();

                        _checking.next('label').hide();

                        $(_checking).show();

                    },

                    complete :function(){

                        $('#checking_email').hide();

                    }

                }

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

                },

                agree: {

                    required: true

                }

            },

            messages: {

                user_name: {

                    required: '您必须提供一个用户名',

                    byteRange: '用户名必须在3-15个字符之间',

                    remote: '您提供的用户名已存在'

                },

                phone_mob: {

                    required: '手机号码必须输入',

                    number: '手机号码必须是数字',

                    byteRange: '手机号码长度必须为11位',

                    remote: '您提供的手机号码已存在,<a href="index.php?app=find_password">点击找回密码</a>'

                },

                confirm_code: {

                    required: '短信验证码不能为空',

                    number: '短信验证码必须是数字',

                    byteRange: '短信验证码必须为6位',

                    remote: '短信验证码错误'

                },
                real_name: {

                    required: '您必须输入真实姓名',

                    minlength: '真实姓名最少3个字符'

                },
                identity_card: {

                    required: '您必须输入身份证',

                    minlength: '身份证号码长度为18位'

                },
                telephone: {

                    required: '你必须提供电话号码',

                    minlength: '电话号码长度为11位'

                },

                password: {

                    required: '您必须提供一个密码',

                    minlength: '密码长度应在6-20个字符之间'

                },

                password_confirm: {

                    required: '您必须再次确认您的密码',

                    equalTo: '两次输入的密码不一致'

                },

                   email : {

                required : '您必须提供您的电子邮箱',

                email    : '这不是一个有效的电子邮箱',

				remote   : '您提供的邮箱已存在'

            },

                captcha: {

                    required: '请输入右侧图片中的文字',

                    remote: '验证码错误'

                },

                agree: {

                    required: '您必须阅读并同意该协议,否则无法注册'

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

            var sendaddress = $('#email').val();

            

            canSend = false;

            $.ajax({

                type: "get",

                url: "index.php?app=member&act=send_code&type=register",

                data: {

                    mobile: function() {

                        return sendaddress;

                    }

                },

                success: function(msg) {

                   

                    if (msg) {

						

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

                    }, 1000);

						

                        alert("邮件已发送至:" + sendaddress + " 请注意查收！");

                    } else {

                        canSend = true;

                        alert("邮件发送失败，请检查邮箱是否正确！");

                    }

                }

            });

        });

    



     

        

        

        

        

        

        

    });

</script>







<div class="login_panel" >

    <form class="login_box" id="register_form" method="post">

        <h2>填写注册信息</h2>

        <table  width="100%">

            <tr>

                <td> <input placeholder="用户名" type="text" name="user_name" id="user_name" class="text">

                    <label class="field_notice"></label></td>

            </tr>
            
            <tr>

                <td> <input placeholder="推荐人" type="text" name="tname" id="tname" class="text">

                    <label class="field_notice"></label></td>

            </tr>
                        
            
            <tr>

                <td> <input placeholder="真实姓名" type="text" name="real_name" id="real_name" class="text">

                    <label class="field_notice"></label></td>

            </tr>
            <tr>

                <td> <input placeholder="手机号码" type="text" name="telephone" id="telephone" class="text">

                    <label class="field_notice"></label></td>

            </tr>
            <tr>

                <td> <input placeholder="身份证" type="text" name="identity_card" id="identity_card" class="text">

                    <label class="field_notice"></label></td>

            </tr>
            

            <tr>  

                <td> <input placeholder="密 码"  id="password" name="password" type="password"  class="text">  

                    <label class="field_notice"></label></td>

            </tr>

            <tr> 

                <td>  

                    <input placeholder="确认密码"   name="password_confirm" type="password"  class="text">  

                    <label class="field_notice"></label>

                </td>

            </tr>

            <?php if ($this->_var['msg_enabled']): ?>

            <tr> 

                <td>  

                    <input placeholder="手机号码" id="phone_mob"  name="phone_mob" type="text"  class="text">  

                    <label class="field_notice"></label>

                </td>

            </tr>

            <tr> 

                <td>  

                    <input type="button" id="sendsms" value="免费发送验证码"/>

                </td>

            </tr>

            <tr> 

                <td>  

                    <input placeholder="验证码" id="confirm_code"  name="confirm_code" type="text"  class="text">  

                    <label class="field_notice"></label>

                </td>

            </tr>

            <?php endif; ?>

           
            
<!-- 
            <tr> 

                <td>  

                    <input placeholder="电子邮箱" id="email"  name="email" type="text"  class="text">  

                    <label class="field_notice"></label>

                </td>

            </tr>

            

             <tr> 

                <td>  

                    <input type="button" id="sendsms" value="免费发送验证码"/>

                </td>

            </tr>

            <tr> 

                <td>  

                    <input placeholder="验证码" id="confirm_code"  name="confirm_code" type="text"  class="text">  

                    <label class="field_notice"></label>

                </td>

            </tr>

            

            --<?php if ($this->_var['captcha']): ?>--

            <tr>

                <td>验证码:<input type="text" name="captcha" class="text" id="captcha1" />

                    <a href="javascript:change_captcha($('#captcha'));" class="renewedly"><img id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" /></a><label class="field_notice">请输入图片中的文字,点击图片以更换</label></td>

            </tr>

            --<?php endif; ?>--

 -->

            <tr>

                <td>

                    <input  value="立即注册"  type="submit" class="red_btn">

                </td>

            </tr>

        </table>

        <input type="hidden" name="ret_url" value="<?php echo $this->_var['ret_url']; ?>" />

        <p>已有账号？<a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>" >直接登录</a></p>

        <input type="hidden"  checked name="agree" value="1" > 

    </form>

</div>





<?php echo $this->fetch('footer.html'); ?>