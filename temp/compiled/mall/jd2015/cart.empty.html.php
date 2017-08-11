<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
.mall-nav{display:none}
</style>
<div id="main" class="w-full">
<div id="page-cart" class="cart-empty w">
   <div class="step step1 mt10 clearfix">
      <span class="fs14 strong fff">1.查看购物车</span>
      <span class="fs14 strong">2.确认订单信息</span>
      <span class="fs14 strong">3.付款</span>
      <span class="fs14 strong">4.确认收货</span>
      <span class="fs14 strong">5.评价</span>
   </div>
   <div class="empty-notice w clearfix">
      <div class="empty-ico"></div>
      <div class="empty-text">
         <p class="fs14 strong">您的购物车是空的，您可以</p>
         <a href="index.php">选购商品>></a>
         <a href="<?php echo url('app=buyer_order'); ?>">查看订单>></a>
      </div>
   </div>
   
   <div class="interest mt20 mb10">
      <div class="title border fs14 padding5 f66 strong"><span class="arr"></span>你可能感兴趣的商品</div>
      <div class="content border border-t-0 clearfix">
         <?php $_from = $this->_var['interest']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
         <dl class="float-left">
           <dt><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img width="160" height="160" src="<?php echo $this->_var['goods']['default_image']; ?>" /></a></dt>
           <dd class="desc"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['goods']['goods_name']),42); ?></a></dd>
           <dd class="price clearfix"><em><?php echo $this->_var['goods']['price']; ?></em><span>最新成交<?php echo $this->_var['goods']['sales']; ?>笔</span></dd>
           <dd class="service"></dd>
         </dl> 
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div>
   </div>
</div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>