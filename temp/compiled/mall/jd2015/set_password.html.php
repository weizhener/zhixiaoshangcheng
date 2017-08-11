<?php echo $this->fetch('top.html'); ?>
<script type="text/javascript">
$(function(){
    $('#set_password_form').validate({
        errorPlacement: function(error, element){
          var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        rules : {
            new_password : {
                required : true,
                maxlength: 20,
                minlength: 6
            },
            confirm_password : {
                required : true,
                equalTo  : '#new_password'
            }
        },
        messages : {
            new_password : {
                required : '密码不能为空',
                maxlength: '密码长度应在6-20个字符之间',
                minlength: '密码长度应在6-20个字符之间'
            },
            confirm_password  : {
                required : '密码不能为空',
                equalTo  : '两次输入的密码不一致'
			}
        }
    });
});
</script>
<style>
.w{width:990px;}
</style>
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
            	<form action="" method="POST" id="set_password_form">
                            <input type="hidden" value="<?php echo $this->_var['id']; ?>" name="id">
                            <input type="hidden" value="<?php echo $this->_var['activation']; ?>" name="activation">
                	<dl class="clearfix">
                    	<dt>新密码:</dt>
                        <dd>
                        	<input class="input" type="password"  name="new_password" id="new_password"/>
                            <div class="clr"></div><label></label>
                        </dd>
                    </dl>
               		<dl class="clearfix">
                    	<dt>重复密码:</dt>
                        <dd>
                        	<input class="input" type="password" name="confirm_password"/>
                            <div class="clr"></div><label></label>
                        </dd>
                    </dl>
                    <dl class="clearfix">
                  		<dt>&nbsp;</dt>
                  		<dd class="clearfix">
                     		<input type="submit" class="fp-submit" name="Submit" value="确认" title="提交" />
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