<?php if ($this->_var['store']['pic_slides']): ?>
       <div class="pic_slides store-slides">
    		<div class="bd">
       			<div class="scroller">
          			<ul class="ks-content ks-switchable-content clearfix">
                    	<?php $_from = $this->_var['store']['pic_slides']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'slides');$this->_foreach['fe_slides'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_slides']['total'] > 0):
    foreach ($_from AS $this->_var['slides']):
        $this->_foreach['fe_slides']['iteration']++;
?>
            			<li class="clearfix">
       						<a href="<?php echo $this->_var['slides']['link']; ?>" target="_blank"><img width="750" height="300" src="<?php echo $this->_var['slides']['url']; ?>" /></a>  
             			</li> 
             			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         			 </ul>
       			</div>
       			<div class="ks-nav">
          			<a href="javascript:;" class="prev prev"></a>
         			<a href="javascript:;" class="next next"></a>
       			</div>
                <div class="ks-switchable-nav">
                	<?php $_from = $this->_var['store']['pic_slides']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'slides');$this->_foreach['fe_slides'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_slides']['total'] > 0):
    foreach ($_from AS $this->_var['slides']):
        $this->_foreach['fe_slides']['iteration']++;
?>
                    <span <?php if (($this->_foreach['fe_slides']['iteration'] <= 1)): ?>class="ks-active"<?php endif; ?>><?php echo $this->_foreach['fe_slides']['iteration']; ?></span>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </div>
    		</div>
		</div>
        <script type="text/javascript">
       		KISSY.ready(function(S) {
          		var carousel = new S.Carousel('.store-slides', {
              	effect: 'scrollx',
              	prevBtnCls: 'prev',
             	nextBtnCls: 'next',
			  	autoplay:true
           	});
	    });
    	</script>
        <?php endif; ?>
