
<script type="text/javascript">
//<!CDATA[
$(function(){
    regionInit("region");
    $('#address_form').validate({
        /*errorPlacement: function(error, element){
            var _message_box = $(element).parent().find('.field_message');
            _message_box.find('.field_notice').hide();
            _message_box.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },*/
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        onkeyup : false,
        rules : {
            consignee : {
                required : true
            },
            region_id : {
                required : true,
                min   : 1
            },
            address   : {
                required : true
            },
            phone_tel : {
                required : check_phone,
                minlength:6,
                checkTel:true
            },
            phone_mob : {
                required : check_phone,
                minlength:6,
                digits : true
            }
        },
        messages : {
            consignee : {
                required : '请填写收货人姓名. '
            },
            region_id : {
                required : '请选择所在地区. ',
                min  : '请选择所在地区. '
            },
            address   : {
                required : '请填写详细地址. '
            },
            phone_tel : {
                required : '固定电话和手机请至少填写一项. ',
                minlength: '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位. ',
                checkTel: '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位. '
            },
            phone_mob : {
                required : '固定电话和手机请至少填写一项. ',
                minlength: '错误的手机号码,只能是数字,并且不能少于6位. ',
                digits : '错误的手机号码,只能是数字,并且不能少于6位. '
            }
        },
        groups:{
            phone:'phone_tel phone_mob'
        }
    });
});
function check_phone(){
    return ($('[name="phone_tel"]').val() == '' && $('[name="phone_mob"]').val() == '');
}
function hide_error(){
	
    $('#region').find('.error').hide();
}
//]]>
</script>
<style>
.dialog_wrapper{width:80%;}
#region select{margin-top:10px;}
</style>
 <form method="post" action="index.php?app=my_address&act=<?php echo $this->_var['act']; ?>&addr_id=<?php echo $this->_var['address']['addr_id']; ?>" id="address_form" target="iframe_post">
    <div class="add_box" style="margin-top:10px;">
    	<p style="margin-bottom:-10px;">
    	<input  name="consignee" value="<?php echo htmlspecialchars($this->_var['address']['consignee']); ?>" type="text" placeholder="请填写你的真实姓名"/>
    	<label class="field_message"><span class="field_notice"></span></label>
    	</p>
    	<p id="region">
                        <input type="hidden" name="region_id" value="<?php echo $this->_var['address']['region_id']; ?>" id="region_id" class="mls_id" />
                        <input type="hidden" name="region_name" value="<?php echo htmlspecialchars($this->_var['address']['region_name']); ?>" class="mls_names" />
                        <?php if ($this->_var['address']['region_id']): ?>
                        <span><?php echo htmlspecialchars($this->_var['address']['region_name']); ?></span>
                        <input type="button" value="编辑" class="edit_region" />
                        <select style="display:none;" onchange="hide_error();">
                          <option>请选择...</option>
                          <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                        </select>
                        <?php else: ?>
                        <select onchange="hide_error();">
                          <option>--请选择地区--</option>
                          <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                        </select>
                        
                        <?php endif; ?>
                        <b class="field_message" style="font-weight:normal;"><label class="field_notice"></label></b>
                      
        </p>
        <p>
            <input type="text" name="address" value="<?php echo htmlspecialchars($this->_var['address']['address']); ?>" placeholder="请填写详细地址" />
            <label class="field_message"><span class="field_notice"></span></label>
        </p>
    	<!--<p>
    	<input type="text"  name="zipcode" value="<?php echo htmlspecialchars($this->_var['address']['zipcode']); ?>" placeholder="邮政编码"/>
    	<label class="field_message"><span class="field_notice"></span></label>
    	</p>-->
    	<p>
    	<input type="text"   name="phone_tel" value="<?php echo $this->_var['address']['phone_tel']; ?>" placeholder="请填写你的手机号码" />
    	<label class="field_message"><span class="field_notice"></span></label>
    	</p>
    <p>
    <input type="text"  name="phone_mob" value="<?php echo $this->_var['address']['phone_mob']; ?>" placeholder="请填写你的电话号码" />
    <label class="field_message"><span class="field_notice"></span></label>
    </p>
        <p>
        <input type="submit" class="white_btn add_submit" value="<?php if ($this->_var['address']['addr_id']): ?>编辑地址<?php else: ?>新增地址<?php endif; ?>" />
        </p>
    </div>
 </form>