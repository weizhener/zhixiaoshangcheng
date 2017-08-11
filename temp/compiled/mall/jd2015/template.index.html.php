<?php echo $this->fetch('member.header.html'); ?>
<style type="text/css">
<!--
body {background: none}
#rightTop p {padding-top: 5px;}
#rightCon {list-style:none;}
#rightCon li {float:left; margin:10px;}
#rightCon .page_item {margin:5px; text-align:center; width:90px; height:120px;}
#rightCon .page_item h3 {background:#eee; border:#ddd 1px solid; color:#4DA1E0; margin-bottom:3px; height:20px; line-height:20px; font-size:13px;}
#rightCon .page_item div {background:#eee; border:#ddd 1px solid; height:85px; line-height:97px;}
#rightCon .page_item input {padding:0px 5px; margin-top:50px;}
-->
</style>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.submenu.html'); ?>
    <div class="wrap">
    	<div class="public">
            <ul id="rightCon">
                <?php $_from = $this->_var['pages']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('page', 'page_url');if (count($_from)):
    foreach ($_from AS $this->_var['page'] => $this->_var['page_url']):
?>
                <li>
        <div class="page_item">
            <h3><?php echo $this->_var['lang'][$this->_var['page']]; ?></h3>
            <div>
                            <form action="index.php" target="_blank">
                            <input type="hidden" name="app" value="template" />
                            <input type="hidden" name="act" value="edit" />
                            <input type="hidden" name="page" value="<?php echo $this->_var['page']; ?>" />
                            <input type="submit" value="编辑" />
                            </form>
                        </div>
                    </div>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
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
<?php echo $this->fetch('footer.html'); ?>
