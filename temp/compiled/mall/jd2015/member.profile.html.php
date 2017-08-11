<?php echo $this->fetch('member.header.html'); ?>
<style>
.borline td {padding:10px 0px;}
.ware_list th {text-align:left;}
</style>
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
    $('input[ectype="change_avatar"]').change(function(){

        var src = getFullPath($(this)[0]);
        $('img[ectype="avatar"]').attr('src', src);
        $('input[ectype="change_avatar"]').removeAttr('name');
        $(this).attr('name', 'portrait');
    });
});
</script>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
    		<?php echo $this->fetch('member.curlocal.html'); ?>
            <?php echo $this->fetch('member.submenu.html'); ?>
            <div class="wrap">
                <div class="public">
                <form method="post" enctype="multipart/form-data" id="profile_form">
                    <div class="information">
                        <?php if (! $this->_var['edit_avatar']): ?>
                        <div class="photo width13">
                            <p><img src="<?php if ($this->_var['profile']['portrait']): ?><?php echo $this->_var['profile']['portrait']; ?>?<?php echo $this->_var['random_number']; ?><?php else: ?><?php echo $this->_var['site_url']; ?>/data/system/default_user_portrait.gif<?php endif; ?>" width="120" height="120" alt="" ectype="avatar" /></p>
                            <b>
                                <span class="file1"><input type="file" size="1" maxlength="0" hidefocus="true" ectype="change_avatar" name="portrait1" /></span>
                                <span class="file2"><input type="file" size="1" maxlength="0" hidefocus="true" ectype="change_avatar" name="portrait2" /></span>
                                <div class="txt">更换头像</div>
                            </b>
                        </div>
                        <?php endif; ?>
                        <div class="info individual">
                            <table>
                                <tr>
                                    <th class="width4">用户名: </th>
                                    <td><?php echo htmlspecialchars($this->_var['profile']['user_name']); ?></td>
                                </tr>
                                <tr>
                                    <th>电子邮箱:</th>
                                    <td><?php echo $this->_var['profile']['email']; ?></td>
                                </tr>
                                <tr>
                                    <th>真实姓名:</th>
                                    <td><input type="text" class="text width_normal" name="real_name" value="<?php echo htmlspecialchars($this->_var['profile']['real_name']); ?>" /></td>
                                </tr>
                                <tr>
                                    <th>性别: </th>
                                    <td class="label">
                                        <label>
                                           <input type="radio" name="gender" value="0" <?php if ($this->_var['profile']['gender'] == 0): ?>checked="checked"<?php endif; ?> />保密  </label>
                                            <label>
                                            <input type="radio" name="gender" value="1" <?php if ($this->_var['profile']['gender'] == 1): ?>checked="checked"<?php endif; ?> />男   </label>
                                            <label>
                                            <input type="radio" name="gender" value="2" <?php if ($this->_var['profile']['gender'] == 2): ?>checked="checked"<?php endif; ?> />女 </label>
                                    </td>
                                </tr>
                                <tr>
                                    <th>生日: </th>
                                    <td>
                                        <input type="text" class="text width_normal" name="birthday" id="birthday" value="<?php echo htmlspecialchars($this->_var['profile']['birthday']); ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <th>QQ:</th>
                                    <td> <input type="text" class="text width_normal" name="im_qq" value="<?php echo htmlspecialchars($this->_var['profile']['im_qq']); ?>" /></td>
                                </tr>
                                
                                <?php if ($this->_var['edit_avatar']): ?>
                                <tr>
                                    <th>头像:</th>
                                    <td><?php echo $this->_var['edit_avatar']; ?></td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <th></th>
                                    <td><input type="submit" class="btn" value="保存修改" /></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </form>
                </div>
                <div class="wrap_bottom"></div>
            </div>

            <div class="clear"></div>
            <div class="adorn_right1"></div>
            <div class="adorn_right2"></div>
            <div class="adorn_right3"></div>
            <div class="adorn_right4"></div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
