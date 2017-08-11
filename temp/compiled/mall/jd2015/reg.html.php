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

                    required: 'user_name_required',

                    byteRange: 'user_name_limit',

                    remote: 'user_already_taken'

                },

                phone_mob: {

                    required: 'phone_mob_required',

                    number: 'phone_mob_number',

                    byteRange: 'phone_mob_limit',

                    remote: 'mobile_already_exsit'

                },

                confirm_code: {

                    required: 'mobile_code_required',

                    number: 'mobile_code_must_be_number',

                    byteRange: 'mobile_code_limit',

                    remote: 'mobile_code_error'

                },

                real_name: {

                    required: 'real_name_required',

                    minlength: 'real_name_length_limit'

                },
                identity_card: {

                    required: 'identity_card_required',

                    minlength: 'identity_card_length_limit'

                },
                telephone: {

                    required: 'telephone_required',

                    minlength: 'telephone_length_limit'

                },
                password: {

                    required: 'password_required',

                    minlength: 'password_length_limit'

                },

                password_confirm: {

                    required: 'password_confirm_please',

                    equalTo: 'password_inconsistent'

                },

                email : {

                required : 'email_required',

                email    : 'email_invalid',

				remote   : 'email_already_taken'

            },

                captcha: {

                    required: 'captcha_required',

                    remote: 'captcha_error'

                },

                agree: {

                    required: 'agree_required'

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

                    <li class="icon_1"><i></i>buy_goods_and_pay</li>

                    <li class="icon_2"><i></i>open_store_and_sale</li>

                    <li class="icon_3"><i></i>collect_your_favorite_goods</li>

                    <li class="icon_4"><i></i>collect_your_favorite_store</li>

                    <li class="icon_5"><i></i>goods_consulting_services_evaluation</li>

                    <li class="icon_6"><i></i>security_transaction_integrity_carefree</li>

                </ul>

                <h4>if_member</h4>

                <div class="login-field">

                    <span>im_member_go_register<a href="index.php?app=member&act=login" class="login-field-btn">请登录</a></span>

                    <span>huozhe <a href="index.php?app=find_password" class="find-password">find_password</a></span>

                </div>

            </div>

            <div class="col-sub">

                <div class="form">

                    <div class="title">user_register</div>

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

                                    <input type="text" style="width:245px;height:26px;" id="user_name" class="input"  name="user_name" title="user_name_tip"  />

                                    <br /><label></label>

                                </dd>

                            </dl>
                            
                            <dl class="clearfix">

                                <dt>real_name</dt>

                                <dd>

                                    <input type="text" style="width:245px;height:26px;" id="real_name" class="input"  name="real_name" title="real_name_tip"  />

                                    <br /><label></label>

                                </dd>

                            </dl> 
                            
                            <dl class="clearfix">

                                <dt>telephone</dt>

                                <dd>

                                    <input type="text" style="width:245px;height:26px;" id="telephone" class="input"  name="telephone" title="telephone_tip"  />

                                    <br /><label></label>

                                </dd>

                            </dl>    
                            
                            <dl class="clearfix">

                                <dt>identity_card</dt>

                                <dd>

                                    <input type="text" style="width:245px;height:26px;" id="identity_card" class="input"  name="identity_card" title="identity_card_tip"  />

                                    <br /><label></label>

                                </dd>

                            </dl>


                            <dl class="clearfix">

                                <dt>密&nbsp;&nbsp;&nbsp;码</dt>

                                <dd>

                                    <input class="input" type="password" id="password" name="password" title="password_tip" />

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>password_confirm</dt>

                                <dd>

                                    <input class="input" type="password" id="password_confirm" name="password_confirm" title="password_confirm_tip" />

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

                                <dt>confirm_code</dt>

                                <dd>

                                    <input class="input" type="text" id="confirm_code" name="confirm_code" value=""/>

                                    <br /><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd>

                                    <input type="button" id="sendsms" value="send_code"/>

                                    <br /><label></label>

                                </dd>

                            </dl>

                            <?php endif; ?>
                            
                            
                            
                            
<!-- 此处为箱验证区域
                            <dl class="clearfix">

                                <dt>电子邮件</dt>

                                <dd>

                                    <input class="input" type="text" id="email" name="email" title="email_tip" />

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            

                            <dl class="clearfix">

                                <dt>confirm_code</dt>

                                <dd>

                                    <input class="input" type="text" id="confirm_code" name="confirm_code" value=""/>

                                    <br /><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd>

                                    <input type="button" id="sendsms" value="send_code"/>

                                    <br /><label></label>

                                </dd>

                            </dl>

   -->                          

                            <?php if ($this->_var['captcha']): ?>

                            <dl class="clearfix">

                                <dt>验证码</dt>

                                <dd class="captcha clearfix">

                                    <input type="text" class="input float-left" name="captcha"  id="captcha1" title="captcha_tip" />

                                    <img height="26" id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" class="float-left" />

                                    <a href="javascript:change_captcha($('#captcha'));" class="float-left">next_captcha</a>

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            <?php endif; ?>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd class="mall-eula">

                                    <input id="clause" type="checkbox" name="agree" value="1" class="agree-checkbox" checked="checked" />

                                    <span>i_have_read <a href="<?php echo url('app=article&act=system&code=eula'); ?>" target="_blank">mall_eula</a></span>

                                    <div class="clr"></div><label></label>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>&nbsp;</dt>

                                <dd>

                                    <input type="submit" name="Submit"value="register_now"class="register-submit"title="register_now" />

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

