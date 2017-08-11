<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo $this->_var['charset']; ?>" />
<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $this->_var['charset']; ?>" />
<title>商城后台</title>
<link href="templates/style/admin.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>

<script type="text/javascript">
var menu = <?php echo $this->_var['menu_json']; ?>;
</script>

<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/index.js'; ?>" charset="utf-8"></script>
</head>
<body>
<div class="back_nav">
    <div class="back_nav_list">
    <?php $_from = $this->_var['back_nav']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'menu');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['menu']):
?>
        <dl>
            <dt><?php echo $this->_var['menu']['text']; ?></dt>
            <?php $_from = $this->_var['menu']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('sub_key', 'sub_menu');if (count($_from)):
    foreach ($_from AS $this->_var['sub_key'] => $this->_var['sub_menu']):
?>
            <dd><a href="javascript:;" onclick="openItem('<?php echo $this->_var['sub_key']; ?>','<?php echo $this->_var['key']; ?>');none_fn();"><?php echo $this->_var['sub_menu']['text']; ?></a></dd>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </dl>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </div>
    <div class="shadow"></div>
    <div class="close_float"><img src="templates/style/images/close2.gif" /></div>
</div>
<div id="head">
    <div id="logo"><a href="index.php"><img src="templates/style/images/logos.png" /></a></div>
    <div id="menu"><span>您好<strong><?php echo $this->_var['visitor']['user_name']; ?></strong> <a href="index.php?act=logout">[退出]</a> <a href="<?php echo $this->_var['site_url']; ?>/index.php" target="_blank">[商城首页]</a></span>
    <a href="javascript:;" class="menu_btn1" id="iframe_refresh">刷新</a>
    <a href="javascript:;" class="menu_btn2" id="clear_cache">更新缓存</a>
    <a href="#" id="back_btn"><img src="templates/style/images/tiring_room_nav.gif" /></a>
    </div>
    <ul id="nav">
    </ul>
    <div id="headBg"></div>
</div>
<div id="content">
    <div id="left">
        <div id="leftMenus">
            <dl id="submenu">
                <dt><a class="ico1" id="submenuTitle" href="javascript:;"></a></dt>
            </dl>
            <!--
            <dl id="history" class="history">
                <dt>
                    <a class="ico2" id="historyText" href="#">操作历史</a>
                </dt>
            </dl>
            -->
         </div>
    </div>
    <div id="right">
        <iframe frameborder="0" style="display:none;" width="100%" id="workspace"></iframe>
    </div>
</div>
</body>
</html>
