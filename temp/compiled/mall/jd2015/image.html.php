<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo $this->_var['charset']; ?>" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_var['charset']; ?>" />
<link href="<?php echo $this->res_base . "/" . 'css/user.css'; ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="index.php?act=jslang"></script>
<style type="text/css">
body {margin: 0px; padding: 0px; font-size:12px;}
<?php if ($this->_var['act'] == 'remote_image'): ?>
form {margin: 0px; padding: 8px; background-color:#F9F9F9;}
<?php endif; ?>
input {background: #ECE9D8;}
.upload_wrap{padding: 0; border: 0}
</style>
<script type="text/javascript">
function submit_form(obj)
{
    obj.attr('disabled', 'disabled');
    $('#image_form').submit();
    obj.removeAttr('disabled');
}
</script>
</head>
<body>
<form action="index.php?app=comupload&act=<?php echo $this->_var['act']; ?>&instance=<?php echo $this->_var['instance']; ?>" method="post" enctype="multipart/form-data" id="image_form">
<input type="hidden" name="id" value="<?php echo $this->_var['id']; ?>">
<input type="hidden" name="belong" value="<?php echo $this->_var['belong']; ?>">
<?php if ($this->_var['act'] == 'uploadedfile'): ?>
<span style="height: 28px; position: absolute; left: 3px; top: 0; width: 120px; z-index: 2; ">
<input onchange="$('#submit_button').click();" type="file" name="file" style="width: 120px; *width:0px; height: 28px; cursor: hand; cursor: pointer;  opacity:0; filter: alpha(opacity=0)" size="1" hidefocus="true" maxlength="0">
</span>
<div class="upload_wrap">
<ul>
<li class="btn1">普通上传</li>
</ul>
</div>
<?php endif; ?>
<?php if ($this->_var['act'] == 'remote_image'): ?>
<input type="text" name="remote_url" size="27" value="http://">
<?php endif; ?>
<input id="submit_button" <?php if ($this->_var['act'] == 'uploadedfile'): ?>style="display:none"<?php endif; ?> type="button" value="<?php if ($this->_var['act'] == 'uploadedfile'): ?>上传<?php endif; ?><?php if ($this->_var['act'] == 'remote_image'): ?>提交<?php endif; ?>" onclick="submit_form($(this))">
</form>
</body>
</html>