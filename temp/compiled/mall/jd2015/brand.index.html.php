<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
<div id="page-brand" class="w mb20 mt10">
    <?php echo $this->fetch('curlocal.html'); ?>
    <div class="rec-brands">
    	<div class="title border padding5 mt10 strong fs14">
        	推荐品牌
        </div>
        <div class="content border border-t-0 clearfix">
           <?php $_from = $this->_var['recommended_brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');$this->_foreach['brand'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brand']['total'] > 0):
    foreach ($_from AS $this->_var['brand']):
        $this->_foreach['brand']['iteration']++;
?>
           <dl  class="float-left">
           		<dt class="pic"><a href="<?php echo url('app=search&brand=' . urlencode($this->_var['brand']['brand_name']). ''); ?>" target="_blank"><img src="<?php echo $this->_var['brand']['brand_logo']; ?>" width="100" height="50" alt="<?php echo $this->_var['brand']['brand_name']; ?>" /></a></dt>
                <dd class="desc"><a href="<?php echo url('app=search&brand=' . urlencode($this->_var['brand']['brand_name']). ''); ?>" target="_blank"><?php echo $this->_var['brand']['brand_name']; ?></a></dd>
           </dl>
           <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php $_from = $this->_var['brand_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
    <div class="all-brands mt10">
    	<div class="title border padding5 strong fs14">
        	<?php if ($this->_var['list']['tag'] == ''): ?>其它<?php else: ?><?php echo $this->_var['list']['tag']; ?><?php endif; ?>(<?php echo $this->_var['list']['count']; ?>)
        </div>
        <div class="content border border-t-0 clearfix">
            <?php $_from = $this->_var['list']['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');$this->_foreach['brand'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['brand']['total'] > 0):
    foreach ($_from AS $this->_var['brand']):
        $this->_foreach['brand']['iteration']++;
?>
            <dl  class="float-left">
           		<dt class="pic"><a href="<?php echo url('app=search&brand=' . urlencode($this->_var['brand']['brand_name']). ''); ?>" target="_blank"><img src="<?php echo $this->_var['brand']['brand_logo']; ?>" width="100" height="50" alt="<?php echo $this->_var['brand']['brand_name']; ?>" /></a></dt>
                <dd class="desc"><a href="<?php echo url('app=search&brand=' . urlencode($this->_var['brand']['brand_name']). ''); ?>" target="_blank"><?php echo $this->_var['brand']['brand_name']; ?></a></dd>
            </dl>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
    </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>
