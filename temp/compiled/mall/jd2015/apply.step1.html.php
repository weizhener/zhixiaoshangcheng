<?php echo $this->fetch('header.html'); ?>

<div id="main" class="w-full">

<div id="page-apply" class="w mt10 mb20">

   <div class="title padding5 strong fs14">我要开店</div>
   <div class="content border padding10 border-t-0 linehei20">
      <?php $_from = $this->_var['sgrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgrade');$this->_foreach['fe_sgrade'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_sgrade']['total'] > 0):
    foreach ($_from AS $this->_var['sgrade']):
        $this->_foreach['fe_sgrade']['iteration']++;
?>
	  <?php if ($this->_var['sgrade']['grade_id'] != 6): ?>
      <dl class="clearfix mb10" <?php if (($this->_foreach['fe_sgrade']['iteration'] == $this->_foreach['fe_sgrade']['total'])): ?> style="border-bottom:0;"<?php endif; ?>>
         <dt class="float-left strong"><?php echo $this->_var['sgrade']['grade_name']; ?></dt>
         <dd class="float-left">
            <p>商品数：<span><?php echo $this->_var['sgrade']['goods_limit']; ?></span></p>

            <p>收费标准：<span><?php echo $this->_var['sgrade']['charge']; ?></span></p>

         </dd>

         <dd class="float-left">

            <p>附加功能：</p>

            <p>
               <?php $_from = $this->_var['sgrade']['functions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('k', 'functions');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['k'] => $this->_var['functions']):
        $this->_foreach['v']['iteration']++;
?>

               <?php if ($this->_var['domain'] && $this->_var['k'] == 'subdomain'): ?>

               <span>二级域名</span>

               <?php else: ?>

               <span><?php echo $this->_var['lang'][$this->_var['k']]; ?></span>

               <?php endif; ?>

               <?php if (! ($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?>

               <?php endif; ?>

               <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </p>

         </dd>
         <dd class="float-left" style="width:100px;"><a href="<?php echo url('app=apply&step=2&id=' . $this->_var['sgrade']['grade_id']. ''); ?>" class="btn-apply fs14 strong fff center">立即开店</a></dd>

      </dl>
	  <?php endif; ?>

      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

   </div>

</div>

</div>

<?php echo $this->fetch('server.html'); ?>

<?php echo $this->fetch('footer.html'); ?>