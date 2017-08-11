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
			
         
        },
        messages : {
               confirm_code: {
                    required: '请输入验证吗',
                    number: '请输入数字',
                    byteRange: '长度',
                    remote: '错误'
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

<script language = "JavaScript">
    /*修改密码表单*/
    function editpass()
    {
        if (document.edit_pass.y_pass.value == "")
        {
            alert("密码不能为空！");
            document.edit_pass.y_pass.focus();
            return false;
        }

        if (document.edit_pass.my_pass.value == "")
        {
            alert("密码不能为空！");
            document.edit_pass.my_pass.focus();
            return false;
        }

        if (document.edit_pass.my_pass2.value == "")
        {
            alert("密码不能为空！");
            document.edit_pass.my_pass2.focus();
            return false;
        }
        return true;
    }
</script>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table epay">
                <div class="notice-word">将您的支付密码进行修改，请慎重填写。</div>
                <div class="title clearfix">
                    <h2 class="float-left">修改支付密码</h2>
                </div>
                <div class="form">
                    <form id="email_form" name="edit_pass" onSubmit="return editpass()" method="post">
                        <?php if ($this->_var['epay']['zf_pass']): ?>
                       
                         <?php if (! $_GET['ispas']): ?>
                        <dl class="clearfix">
                            <dt>原支付密码：</dt>
                            <dd><input name="y_pass" type="password" id="y_pass" /><label class="field_notice">当前使用的支付密码</label></dd>
                        </dl>
                        <?php endif; ?>
                        <?php endif; ?>
                        <dl class="clearfix">
                            <dt>新支付密码：</dt>
                            <dd><input name="zf_pass" type="password" id="zf_pass"/><label class="field_notice">支付密码建议密码采用字母和数字混合，且不短于6位</label></dd>
                        </dl>
                        <dl class="clearfix">
                            <dt>确认密码：</dt>
                            <dd><input name="zf_pass2" type="password" id="zf_pass2" /><label class="field_notice">再输入一次</label></dd>
                        </dl>
                        <?php if ($_GET['ispas']): ?>
                         <dl class="clearfix">
                            <dt>邮箱：</dt>
                            <dd><?php echo htmlspecialchars($this->_var['info']['email']); ?><input class="input" type="hidden" id="email" name="email"  value="<?php echo htmlspecialchars($this->_var['info']['email']); ?>" /></dd>
                        </dl>
                        
                        <dl class="clearfix">
                                <dt>验证码:</dt>
                                <dd>
                                    <input class="input" type="text" id="confirm_code" name="confirm_code" value=""/>
                                    <br /><label></label>
                                </dd>
                            </dl>
                            <dl class="clearfix">
                                <dt>&nbsp;</dt>
                                <dd>
                                    <input type="button" id="sendsms" value="发送验证码"/>
                                    <br /><label></label>
                                </dd>
                            </dl>
                        <?php endif; ?>
                        <dl class="clearfix">
                            <dt>&nbsp;</dt>
                            <dd class="submit">
                                <span class="epay_btn">
                                    <input type="submit" value="提交" />  
                                </span>
                                
                                <Br /><a href="index.php?app=epay&act=editpassword&ispas=1" >找回密码</a>
                            </dd>
                        </dl>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<?php echo $this->fetch('footer.html'); ?>
