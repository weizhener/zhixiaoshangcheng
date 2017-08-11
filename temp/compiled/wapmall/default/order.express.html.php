<?php echo $this->fetch('member.header.html'); ?>
<style>
.express-info{margin-bottom:10px;}
.express-info span{color:#2979B1}
.express-body{width:100%;font-size:12px;}
.express-body dl:after{content:'20'; display:block; height:0; overflow:hidden; clear:both}
.express-body dl{width:100%;border:1px #ddd solid;border-top:0;}
.express-body .title{background:#64AADB;color:#fff; height:28px;}
.express-body dt,.express-body dd{float:left;padding-left:10px;line-height:28px;}
.express-body dt{width:20%;}
.express-body dd{border-left:1px #ddd solid;width:80%;}
</style>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">快递跟踪</div>
    <a href="javascript" class="r_b"></a>
</div>


    <div class="w320">
         		<div class="express-info">物流公司：<span><?php echo $this->_var['kuaidi_info']['express_company']; ?></span>&nbsp;&nbsp;&nbsp;&nbsp;物流单号：<span><?php echo $this->_var['kuaidi_info']['express_num']; ?></span></div>
         		<?php if ($this->_var['kuaidi_info']['url']): ?>
                <iframe src="<?php echo $this->_var['kuaidi_info']['url']; ?>" width="100%" height="260" frameborder="0" scrolling="auto" ></iframe>
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
        
    </div>
<?php echo $this->fetch('member.footer.html'); ?>