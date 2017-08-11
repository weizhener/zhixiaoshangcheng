<div class="cartbox w mt20 mb10">
   <div class="title clearfix mb10">
      <span class="col-desc">店铺商品</span>
      <span>价格</span>
      <span>数量</span>
      <span>小计</span>
      <span>操作</span>
   </div>
   <div class="content">
      <div class="store-each">
            <div class="store-name pb10">
               店铺：<a href="<?php echo url('app=store&id=' . $this->_var['goods_info']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods_info']['store_name']); ?></a>
               <?php if ($this->_var['goods_info']['store_im_qq']): ?>
               <a href="http://wpa.qq.com/msgrd?V=1&amp;uin=<?php echo htmlspecialchars($this->_var['goods_info']['store_im_qq']); ?>&amp;Site=<?php echo htmlspecialchars($this->_var['goods_info']['store_name']); ?>&amp;Menu=yes" target="_blank"><img align="absmiddle" src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['goods_info']['store_im_qq']); ?>:4" alt="qq"></a>
               <?php endif; ?>
            </div>
            <?php $_from = $this->_var['goods_info']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
            <dl class="goods-each clearfix" <?php if (! ($this->_foreach['fe_goods']['iteration'] <= 1)): ?> style="border-top:0;"<?php endif; ?>>
               <dd class="pic"><a class="block" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_image']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" width="80" height="80" /></a></dd>
               <dd class="desc">
                  <p><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                  <span class="f66"><?php echo htmlspecialchars($this->_var['goods']['specification']); ?></span>
               </dd>
               <dd class="price"><?php echo price_format($this->_var['goods']['price']); ?></dd>
               <dd class="quantity"><?php echo $this->_var['goods']['quantity']; ?></dd>
               <dd class="subtotal fs14 strong"><?php echo price_format($this->_var['goods']['subtotal']); ?></dd>
               <dd class="handle"></dd>
            </dl>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
         </div>
   </div>
</div>