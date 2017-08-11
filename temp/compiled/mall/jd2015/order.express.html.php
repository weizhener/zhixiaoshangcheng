<?php echo $this->fetch('member.header.html'); ?>
<style>
.express-info{margin-bottom:10px;}
.express-info span{color:#2979B1}
.express-body{width:515px;font-size:12px;}
.express-body dl:after{content:'20'; display:block; height:0; overflow:hidden; clear:both}
.express-body dl{width:513px;border:1px #ddd solid;border-top:0;}
.express-body .title{background:#64AADB;color:#fff; height:28px;}
.express-body dt,.express-body dd{float:left;padding-left:10px;line-height:28px;}
.express-body dt{width:140px;}
.express-body dd{border-left:1px #ddd solid;width:350px;}
.express-from{border:1px #FFCC7F solid; height:20px; line-height:20px;margin-top:20px;width:503px;padding-left:10px;color:#666;}
.express-from a{text-decoration:none}
.express-from a:hover{text-decoration:underline}
</style>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right"><?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            
         <div class="public_index table">
         		<div class="express-info">物流公司：<span><?php echo $this->_var['kuaidi_info']['express_company']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;物流单号：<span><?php echo $this->_var['kuaidi_info']['express_num']; ?></span></div>
         		<?php if ($this->_var['kuaidi_info']['url']): ?>
                <iframe src="<?php echo $this->_var['kuaidi_info']['url']; ?>" width="534" height="340" frameborder="0" ></iframe>
                <?php else: ?>
                	<?php if ($this->_var['kuaidi_info']['status'] == 1): ?>
                	<div class="express-body">
                		<dl class="title">
                    		<dt><strong>时间</strong></dt><dd><strong>地点和跟踪进度</strong></dd>
                    	</dl>
                		<?php $_from = $this->_var['kuaidi_info']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'kuaidi');$this->_foreach['fe_kuaidi'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_kuaidi']['total'] > 0):
    foreach ($_from AS $this->_var['kuaidi']):
        $this->_foreach['fe_kuaidi']['iteration']++;
?>
                		<dl <?php if (($this->_foreach['fe_kuaidi']['iteration'] == $this->_foreach['fe_kuaidi']['total'])): ?> style="color:<?php if ($this->_var['kuaidi_info']['state'] == 3): ?>#1B730C<?php else: ?>#FF6600<?php endif; ?>"<?php endif; ?>>
                    		<dt><?php echo $this->_var['kuaidi']['time']; ?></dt><dd><?php echo $this->_var['kuaidi']['context']; ?></dd>
                    	</dl>
                		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                	</div>
                	<?php else: ?>
                    <div class=""><?php echo $this->_var['kuaidi_info']['message']; ?></div>
                	<?php endif; ?>
                <?php endif; ?>
        </div>
        
    	<div class="wrap_bottom"></div>
    </div>
</div>
</div>
<div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>