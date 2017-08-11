<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">修改资料</div>
    <a href="javascript" class="r_b"></a>
</div>
<script type="text/javascript">
$(function(){
    $('#profile_form').validate({
        errorPlacement: function(error, element){
            $(element).parent('span').parent('b').after(error);
        },
        rules : {
            portrait : {
                accept   : 'gif|jpe?g|png'
            }
        },
        messages : {
            portrait  : {
                accept   : '支持gif、jpeg、jpg、png格式'
            }
        }
    });
});
</script>

<style>
    .member_profile{margin:10px 16px;}
</style>


<div class="member_profile">
    <form method="post" id="password_form">
        <ul class="form_content">
            <li>
                <h3>真实姓名:</h3>
                <p><input type="text"  name="real_name" id="real_name" value="<?php echo htmlspecialchars($this->_var['profile']['real_name']); ?>"/></p>
            </li>
            <li>
                <h3>生日:</h3>
                <p><input type="text"  name="birthday" id="birthday" value="<?php echo htmlspecialchars($this->_var['profile']['birthday']); ?>"/></p>
            </li>
            <li>
                <h3>QQ:</h3>
                <p><input type="text"  name="im_qq" id="real_name" value="<?php echo htmlspecialchars($this->_var['profile']['im_qq']); ?>"/></p>
            </li>
            <li>
                <h3>MSN:</h3>
                <p><input type="text"  name="im_msn" id="im_msn" value="<?php echo htmlspecialchars($this->_var['profile']['im_msn']); ?>"/></p>
            </li>
        </ul>
            <input class="red_btn" type="submit" value="提交" />
    </form>
</div>






<?php echo $this->fetch('member.footer.html'); ?>