<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
var template_name = '<?php echo $this->_var['curr_template_name']; ?>';
var style_name = '<?php echo $this->_var['curr_style_name']; ?>';
function use_theme(template, style){
    if (template != template_name)
    {
        if (!confirm('您选择的该主题模板与当前使用的主题模板不一致，因此您当前的挂件设置将不能在新主题中显示，您需要重新设置，您确定要使用该模板吗？'))
        {
            return;
        }

    }
    window.location.href = 'index.php?app=waptheme&act=set&template_name=' + template + '&style_name=' + style;
}
function preview_theme(template, style){
    $('#template_name').val(template);
    $('#style_name').val(style);
    $('#preview_form').submit();
}
function go_index(){
    $('#go_index').submit();
}
</script>
<style type="text/css">
<!--
body {background: none}
#rightTop p {padding-top: 5px;}
#rightCon {list-style:none; width:100%;}
#rightCon li {float:left; margin:10px;}
#rightCon .title_name {font-size:15px; font-weight:bold; color:#4DA1E0; text-align:center;}
#rightCon .templet_style {margin:5px; background:#eee; border:#ddd 1px solid; padding:3px;}
#rightCon .templet_btn {text-align:center;}
-->
</style>
<div id="rightTop">
<p>
    <b>主题设置</b><br />
当前您使用的主题是:<?php echo $this->_var['curr_template_name']; ?>&nbsp;<?php echo $this->_var['curr_style_name']; ?>
</p>

</div>
<ul id="rightCon">
    <?php $_from = $this->_var['theme_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('template_name', 'styles');if (count($_from)):
    foreach ($_from AS $this->_var['template_name'] => $this->_var['styles']):
?>
    <?php $_from = $this->_var['styles']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'style_name');if (count($_from)):
    foreach ($_from AS $this->_var['style_name']):
?>
    <li>
        <div class="title_name"><?php echo $this->_var['template_name']; ?>&nbsp;<?php echo $this->_var['style_name']; ?></div>
        <div class="templet_style"><img src="<?php echo $this->_var['site_url']; ?>/themes/wapmall/<?php echo $this->_var['template_name']; ?>/styles/<?php echo $this->_var['style_name']; ?>/preview.jpg" onclick="preview_theme('<?php echo $this->_var['template_name']; ?>', '<?php echo $this->_var['style_name']; ?>');" /></div>
        <div class="templet_btn">
        <?php if ($this->_var['curr_template_name'] != $this->_var['template_name'] || $this->_var['curr_style_name'] != $this->_var['style_name']): ?>
        <input type="button" value="使用" onclick="use_theme('<?php echo $this->_var['template_name']; ?>', '<?php echo $this->_var['style_name']; ?>');" class="formbtn" />&nbsp;&nbsp;
        <input type="button" value="预览" onclick="preview_theme('<?php echo $this->_var['template_name']; ?>', '<?php echo $this->_var['style_name']; ?>');" class="formbtn" />
        <?php else: ?>
        <input type="button" value="查看商城" onclick="go_index()" class="formbtn" />
        <?php endif; ?>
        </div>
    </li>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</ul>
<form id="preview_form" method="POST" action="index.php?app=waptheme&act=preview" target="_blank"><input type="hidden" name="template_name" id="template_name" /><input type="hidden" name="style_name" id="style_name" /></form>

<form id="go_index" method="GET" action="<?php echo $this->_var['site_url']; ?>" target="_blank"></form>
<?php echo $this->fetch('footer.html'); ?>
