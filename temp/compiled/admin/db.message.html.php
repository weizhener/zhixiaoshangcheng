<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_var['charset']; ?>" />

<title> 系统消息</title>

<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />

<style>

<!--

body {background: none}

h1 {font-size: 12px; color: #444; line-height: 55px; background: url(templates/style/images/welcome_h1.gif); padding-left: 2%}

dl {background: url(templates/style/images/welcome.gif) no-repeat left 10px; padding-left: 40px; margin: 35px 0 45px 15%}

dt {line-height: 60px; color: #009de6; font-weight:bold;}

dd {line-height: 18px; color: #444;}

a {color: #06c}

p {color: #999; border-top: 1px solid #cbe4f5; text-align: center; padding-top: 20px;}

-->

</style>

</head>



<body>

<div id="rightTop">

    <p>数据库</p>

    <ul class="subnav">

        <li><a class="btn1" href="index.php?app=db&amp;act=backup">备份</a></li>

        <li><a class="btn1" href="index.php?app=db&amp;act=restore">恢复</a></li>

    </ul>

</div>

<div class="info">

<dl>

    <dt><?php echo $this->_var['title']; ?></dt>

    <?php if ($this->_var['auto_redirect']): ?>

    <dd>如果您的浏览器没有自动跳转，请点击顶部刷新按钮</dd>

    <script>setTimeout("window.location.replace('<?php echo $this->_var['auto_link']; ?>');", 1250);</script>

    <?php else: ?>

    <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'file');if (count($_from)):
    foreach ($_from AS $this->_var['file']):
?>

    <dd><a target="_blank" href="<?php echo $this->_var['file']['href']; ?>"><?php echo $this->_var['file']['name']; ?></a></dd>

    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    <?php endif; ?>

</dl>

</div>

<p>Copyright 2016 ykt.anduowang.com,All rights reserved.</p>

</body>

</html>

