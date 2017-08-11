<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">

    $(function() {

        $('#register_form').validate({

            errorPlacement: function(error, element) {

                var error_td = element.parent('dd');

                error_td.find('label').hide();

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
					
					digits:true,

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

<script type="text/javascript">

    $(function() {

        poshytip_message($('#user_name'));

        poshytip_message($('#password'));

        poshytip_message($('#password_confirm'));

        poshytip_message($('#email'));

        poshytip_message($('#captcha1'));
        
        poshytip_message($('#real_name'));
        
        poshytip_message($('#telephone'));
        
        poshytip_message($('#identity_card'));
        

    });

</script>

<div id="main" class="w-full">

    <div id="page-register" class="w login-register mt20 mb20">

        <div class="w clearfix">

            <div class="col-main">

                <ul class="clearfix">

                    <li class="icon_1"><i></i>购买商品支付订单</li>

                    <li class="icon_2"><i></i>申请开店销售商品</li>

                    <li class="icon_3"><i></i>收藏你喜欢的商品</li>

                    <li class="icon_4"><i></i>收藏你喜欢的店铺</li>

                    <li class="icon_5"><i></i>商品咨询服务评价</li>

                    <li class="icon_6"><i></i>安全交易诚信无忧</li>

                </ul>

                <h4>如果您是本站用户</h4>

                <div class="login-field">

                    <span>我已经注册过帐号，立即<a href="index.php?app=member&act=login" class="login-field-btn">请登录</a></span>

                    <span>或者 <a href="index.php?app=find_password" class="find-password">找回密码</a></span>

                </div>

            </div>

            <div class="col-sub">

                <div class="form">

                    <div class="title">用户注册</div>

                    <div class="content">

                        <form name="" id="register_form" method="post" action="">
                        
                        
                	<dl class="clearfix">
                		<dt>推荐人</dt>
                    	<dd>
                    		<input type="text" style="width:245px;height:26px;" id="tname" class="input"  name="tname" title="tname"  />
                        	<br /><label></label>
                    	 </dd>
                	</dl>
                        

                            <dl class="clearfix">

                                <dt>用户名</dt>

                                <dd>

                                    <input type="text" style="width:245px;height:26px;" id="user_name" class="input"  name="user_name" title="3-15位字符，由中文、英文、数字以及'-'、'_'组成"  />

                                    <br /><label></label>

                                </dd>

                            </dl>
                            
                            <dl class="clearfix">

                                <dt>真实姓名</dt>

                                <dd>

                                    <input type="text" style="width:245px;height:26px;" id="real_name" class="input"  name="real_name" title="请输入真实姓名、方便找回密码"  />

                                    <br /><label></label>

                                </dd>

                            </dl> 
                            
                            <dl class="clearfix">

                                <dt>手机号码</dt>

                                <dd>

                                    <input type="text" style="width:245px;height:26px;" id="telephone" class="input"  name="telephone" title="请输入有效11位手机号码"  />

                                    <br /><label></label>

                                </dd>

                            </dl>    
                            
                            <dl class="clearfix">

                                <dt>身份证号码</dt>

                                <dd>

                                    <input type="text" style="width:245px;height:26px;" id="identity_card" class="input"  name="identity_card" title="请输入身份证号码、方便找回密码"  />

                                    <br /><label></label>

                                </dd>

                            </dl>


                            <dl class="clearfix">

                                <dt>密&nbsp;&nbsp;&nbsp;码</dt>

                                <dd>

                                    <input class="input" type="password" id="password" name="password" title="长度在6-20个字符之间,由字母、数字和标点符号组成" />

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>确认密码</dt>

                                <dd>

                                    <input class="input" type="password" id="password_confirm" name="password_confirm" title="请再次输入你的密码" />

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            <?php if ($this->_var['msg_enabled']): ?>

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

                                    <input class="input" type="text" id="confirm_code" name="confirm_code" value=""/>

                                    <br /><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd>

                                    <input type="button" id="sendsms" value="免费发送验证码"/>

                                    <br /><label></label>

                                </dd>

                            </dl>

                            <?php endif; ?>
                            
                            
                            
                            
<!-- 此处为箱验证区域
                            <dl class="clearfix">

                                <dt>电子邮箱</dt>

                                <dd>

                                    <input class="input" type="text" id="email" name="email" title="请输入你的常用电邮，将来用于找回密码和接收商城信息" />

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            

                            <dl class="clearfix">

                                <dt>验证码</dt>

                                <dd>

                                    <input class="input" type="text" id="confirm_code" name="confirm_code" value=""/>

                                    <br /><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd>

                                    <input type="button" id="sendsms" value="免费发送验证码"/>

                                    <br /><label></label>

                                </dd>

                            </dl>

   -->                          

                            <?php if ($this->_var['captcha']): ?>

                            <dl class="clearfix">

                                <dt>验证码</dt>

                                <dd class="captcha clearfix">

                                    <input type="text" class="input float-left" name="captcha"  id="captcha1" title="请输入验证码，不区分大小写" />

                                    <img height="26" id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" class="float-left" />

                                    <a href="javascript:change_captcha($('#captcha'));" class="float-left">看不清，换一张</a>

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            <?php endif; ?>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd class="mall-eula">

                                    <input id="clause" type="checkbox" name="agree" value="1" class="agree-checkbox" checked="checked" />

                                    <span>我已阅读并同意 <a href="<?php echo url('app=article&act=system&code=eula'); ?>" target="_blank">用户服务协议</a></span>

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd>

                                    <input type="submit" name="Submit"value="立即注册"class="register-submit"title="立即注册" />

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

