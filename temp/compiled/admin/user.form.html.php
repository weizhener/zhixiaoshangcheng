<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#user_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        onkeyup    : false,
        rules : {
            user_name : {
                required : true,
                byteRange: [3,15,'<?php echo $this->_var['charset']; ?>'],
                remote   : {
                    url :'index.php?app=user&act=check_user',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#user_name').val();
                        },
                        id : '<?php echo $this->_var['user']['user_id']; ?>'
                    }
                }
            },
	    grade_id  : {
                required : true
            },
            password: {
                <?php if ($_GET['act'] == 'add'): ?>
                required : true,
                <?php endif; ?>
                maxlength: 20,
                minlength: 6
            },
            email   : {
                required : true,
                email : true
            }
            <?php if (! $this->_var['set_avatar']): ?>
            ,
            portrait : {
                accept : 'png|gif|jpe?g'
            }
            <?php endif; ?>
        },
        messages : {
            user_name : {
                required : '会员名称不能为空',
                byteRange: '用户名的长度应在3-15个字符之间',
                remote   : '该会员名已经存在了，请您换一个'
            },
            grade_id: {
                required : '会员等级不能为空',
            },
            password : {
                <?php if ($_GET['act'] == 'add'): ?>
                required : '密码不能为空',
                <?php endif; ?>
                maxlength: '密码长度应在6-20个字符之间',
                minlength: '密码长度应在6-20个字符之间'
            },
            email  : {
                required : '电子邮箱不能为空',
                email   : '请您填写有效的电子邮箱'
            }
            <?php if (! $this->_var['set_avatar']): ?>
            ,
            portrait : {
                accept : '支持格式gif,jpg,jpeg,png'
            }
            <?php endif; ?>
        }
    });
	$('.edit_grade').click(function(){
		$(this).next('select').show();
		$(this).parent('td').children('.ugrade').remove();
		$(this).parent('td').children('span').remove();
		$(this).remove();
	})
});
</script>
<div id="rightTop">
  <p>会员管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=user">管理</a></li>
    <li>
      <?php if ($this->_var['user']['user_id']): ?>
      <a class="btn1" href="index.php?app=user&amp;act=add">新增</a>
      <?php else: ?>
      <span>新增</span>
      <?php endif; ?>
    </li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data" id="user_form">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> 会员名:</th>
        <td class="paddingT15 wordSpacing5"><?php if ($this->_var['user']['user_id']): ?>
          <?php echo htmlspecialchars($this->_var['user']['user_name']); ?>
          <?php else: ?>
          <input class="infoTableInput2" id="user_name" type="text" name="user_name" value="<?php echo htmlspecialchars($this->_var['user']['user_name']); ?>" />
          <label class="field_notice">会员名</label>
          <?php endif; ?>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> 密码:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="password" type="text" id="password" />
          <?php if ($this->_var['user']['user_id']): ?>
          <span class="grey">留空表示不修改密码</span>
          <?php endif; ?>        </td>
      </tr>
     
      
      <tr>
        <th class="paddingT15"> 电子邮箱:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="email" type="text" id="email" value="<?php echo htmlspecialchars($this->_var['user']['email']); ?>" />
            <label class="field_notice">电子邮箱</label>        </td>
      </tr>
      <tr>
        <th class="paddingT15"> 真实姓名:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="real_name" type="text" id="real_name" value="<?php echo htmlspecialchars($this->_var['user']['real_name']); ?>" />        </td>
      </tr>
      <tr>
        <th class="paddingT15"> 性别:</th>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input name="gender" type="radio" value="0" <?php if ($this->_var['user']['gender'] == 0): ?>checked="checked"<?php endif; ?> />
            保密</label>
            <label>
            <input type="radio" name="gender" value="1" <?php if ($this->_var['user']['gender'] == 1): ?>checked="checked"<?php endif; ?> />
            男</label>
            <label>
            <input type="radio" name="gender" value="2" <?php if ($this->_var['user']['gender'] == 2): ?>checked="checked"<?php endif; ?> />
            女</label>
          </p></td>
      </tr>
      <!--<tr>
        <th class="paddingT15"> <label for="phone_tel">固定电话:</label></th>
        <td class="paddingT15 wordSpacing5"><input name="phone_tel[]" id="phone_tel" type="text" size="4" value="<?php echo $this->_var['phone_tel']['0']; ?>" />
          -
          <input class="infoTableInput2" name="phone_tel[]" type="text" value="<?php echo $this->_var['phone_tel']['1']; ?>" />
          -
          <input name="phone_tel[]" type="text" size="4" value="<?php echo $this->_var['phone_tel']['2']; ?>" />
        </td>
      </tr>-->
      <tr>
        <th class="paddingT15"> 手机:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="phone_mob" type="text" id="phone_mob" value="<?php echo htmlspecialchars($this->_var['user']['phone_mob']); ?>" />
        </td>
      </tr>
      <tr>
        <th class="paddingT15"> QQ:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="im_qq" type="text" id="im_qq" value="<?php echo htmlspecialchars($this->_var['user']['im_qq']); ?>" />        </td>
      </tr>
      <tr>
        <th class="paddingT15"> 推荐人ID:</th>
        <td class="paddingT15 wordSpacing5"><input class="referid" name="referid" type="text" id="referid" value="<?php echo htmlspecialchars($this->_var['user']['referid']); ?>" />        </td>
      </tr>

     <?php if (! $this->_var['set_avatar']): ?>
      <tr>
        <th class="paddingT15">头像:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableFile2" type="file" name="portrait" id="portrait" />
          <label class="field_notice">支持格式gif,jpg,jpeg,png</label>
          <?php if ($this->_var['user']['portrait']): ?><br /><img src="../<?php echo $this->_var['user']['portrait']; ?>" alt="" width="100" height="100" /><?php endif; ?>           </td>
      </tr>
     <?php else: ?>
        <?php if ($_GET['act'] == 'edit'): ?>
      <tr>
        <th class="paddingT15">头像:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $this->_var['set_avatar']; ?></td>
      </tr>
        <?php endif; ?>
     <?php endif; ?>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" />        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>