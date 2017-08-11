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

dl {line-height: 40px; background: url(templates/style/images/welcome.gif) no-repeat left 10px; padding-left: 40px; margin: 35px 0 45px 15%}

dt {color: #009de6}

dd {color: #444;}

a {color: #06c}

a:hover {color: #09f}

p {color: #999; border-top: 1px solid #cbe4f5; text-align: center; padding-top: 20px;}

-->

</style>

</head>



<body>

<h1>系统消息</h1>

<dl>

    <dt>通知信息</dt>

    <?php if ($this->_var['auto_redirect'] == 1): ?>

    <dd><a href="<?php echo $this->_var['auto_link']; ?>" class="forwrd">如果您的浏览器没有自动跳转，请您点击浏览器上方的刷新按钮</a></dd>

    <script type="text/javascript">

    setTimeout("window.location.replace('<?php echo $this->_var['auto_link']; ?>');", 1250);

    </script>

    <?php endif; ?>

    <?php if ($this->_var['auto_redirect'] == 2): ?>

    <dd><a href="<?php echo $this->_var['auto_link']; ?>" class="forward">通知发送成功。</a></dd>

    <script type="text/javascript">

    setTimeout("window.location.replace('<?php echo $this->_var['auto_link']; ?>');", 5000);

    </script>

    <?php endif; ?>

</dl>

<p>Copyright 2016 ykt.anduowang.com,All rights reserved.</p>

</body>

</html>

