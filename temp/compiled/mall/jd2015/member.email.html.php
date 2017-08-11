<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#email_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        rules : {
            orig_password : {
                required : true
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
        },
        messages : {
            orig_password : {
                required : '原始密码不能为空'
            },
			    confirm_code: {
                    required: '短信验证码不能为空',
                    number: '短信验证码必须是数字',
                    byteRange: '短信验证码必须为6位',
                    remote: '短信验证码错误'
                },
			
           email : {
                required : '您必须提供您的电子邮箱',
                email    : '这不是一个有效的电子邮箱',
				remote   : '您提供的邮箱已存在'
            },
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
        <div class="wrap">
        	<div class="eject_con bgwhite">
            <div class="add">
                <form method="post" id="email_form">
                    <ul>
                        <li><h3>您的密码:</h3>
                        <p><input class="text width_normal" type="password" name="orig_password" /></p>
                        </li>
                        <li><h3>电子邮箱:</h3>
                        <p><input class="text width_normal" type="text" id="email" name="email" /></p>
                        </li>
                        
                        <li><h3>验证码:</h3>
                        <p><input class="input" type="text" id="confirm_code" name="confirm_code" value=""/>
                                    <br /><label></label></p>
                        </li>
                        
                         <li><h3>验证码:</h3>
                        <p> <input type="button" id="sendsms" value="免费发送验证码"/>
                                    <br /><label></label></p>
                        </li>
                        
                         
                        
                    </ul>
                    <div class="submit">
                                    <input class="btn" type="submit" value="提交" />
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
