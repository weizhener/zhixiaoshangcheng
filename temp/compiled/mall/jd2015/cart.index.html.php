<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
.mall-nav{display:none}
</style>
<script type="text/javascript">
$(function(){
	$(".btn-batch input[name='sellectAll']").click(function(){
		$(".goods-each .select input[name='s"+$(this).val()+"']").attr("checked",$(this).attr("checked"));
	});
	$(".btn-batch a").click(function(){
		var name = this.name;
		var checked = 0;
		$(".goods-each .select input").each(function(){
			if($(this).attr("checked")==true){
				srg = $(this).val().split(":");
				if(name=="batch_del"){
					drop_cart_item(srg[0], srg[1]);
				} else {
					batch_move_favorite(srg[0], srg[1], srg[2],checked==0);
				}
				checked++;
			}
		});
		if(!checked) {
			alert('你未选择任何项');
		}
	});
});

</script>
<div id="main" class="w-full">
<div id="page-cart" class="w cart-index mb20">
   <div class="step step1 mt10 clearfix">
      <span class="fs14 strong fff">1.查看购物车</span>
      <span class="fs14 strong">2.确认订单信息</span>
      <span class="fs14 strong">3.付款</span>
      <span class="fs14 strong">4.确认收货</span>
      <span class="fs14 strong">5.评价</span>
   </div>
   
   <div class="cartbox w mt20 mb10">
      <div class="amount">
         
      </div>
      <div class="title clearfix mb10">
         <span class="sellect-all">选择</span>
         <span class="col-desc">店铺商品</span>
         <span>价格</span>
         <span>数量</span>
         <span>小计</span>
         <span>操作</span>
      </div>
      <div class="content">
         <?php $_from = $this->_var['carts']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('store_id', 'cart');if (count($_from)):
    foreach ($_from AS $this->_var['store_id'] => $this->_var['cart']):
?>
         <div class="store-each">
            <div class="store-name pb10">店铺：<a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['cart']['store_name']); ?></a></div>
            <?php $_from = $this->_var['cart']['goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
            <dl class="goods-each clearfix" id="cart_item_<?php echo $this->_var['goods']['rec_id']; ?>">
               <dd class="select"><input type="checkbox" name="s<?php echo $this->_var['store_id']; ?>" value="<?php echo $this->_var['store_id']; ?>:<?php echo $this->_var['goods']['rec_id']; ?>:<?php echo $this->_var['goods']['goods_id']; ?>" /></dd>
               <dd class="pic"><a class="block" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['goods']['goods_image']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" width="80" height="80" /></a></dd>
               <dd class="desc">
                  <p><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                  <span class="f66"><?php echo htmlspecialchars($this->_var['goods']['specification']); ?></span>
               </dd>
               
               <dd class="price"><?php echo price_format($this->_var['goods']['price']); ?></dd>
               <dd class="quantity">
                  <img src="<?php echo $this->res_base . "/" . 'images/subtract.gif'; ?>" onclick="decrease_quantity(<?php echo $this->_var['goods']['rec_id']; ?>);" alt="减少" width="11" height="11"/>
                  <input class="input" id="input_item_<?php echo $this->_var['goods']['rec_id']; ?>" value="<?php echo $this->_var['goods']['quantity']; ?>" orig="<?php echo $this->_var['goods']['quantity']; ?>" changed="<?php echo $this->_var['goods']['quantity']; ?>" onkeyup="change_quantity(<?php echo $this->_var['store_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>, <?php echo $this->_var['goods']['spec_id']; ?>, this);" type="text" />
                  <img src="<?php echo $this->res_base . "/" . 'images/adding.gif'; ?>" onclick="add_quantity(<?php echo $this->_var['goods']['rec_id']; ?>);" alt="增加" width="11" height="11" />
               </dd>
               <dd class="subtotal fs14 strong" id="item<?php echo $this->_var['goods']['rec_id']; ?>_subtotal"><?php echo price_format($this->_var['goods']['subtotal']); ?></dd>
               <dd class="handle">
                   <a class="move" href="javascript:;" onclick="move_favorite(<?php echo $this->_var['store_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>, <?php echo $this->_var['goods']['goods_id']; ?>);">加入收藏夹</a>
                   <br />
                   <a class="del" href="javascript:;" onclick="drop_cart_item(<?php echo $this->_var['store_id']; ?>, <?php echo $this->_var['goods']['rec_id']; ?>);">删除</a>
               </dd>
            </dl>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <div class="cart-amount mt20 w auto mb10 clearfix">
               <div class="btn-batch mt5">
                  <label class="pl10"><input value="<?php echo $this->_var['store_id']; ?>" type="checkbox" name="sellectAll" />全选/反选</label>
                  <a href="javascript:;" name="batch_del" class="center" title="批量删除">批量删除</a>
                  <a href="javascript:;" name="batch_collect" class="center" title="批量收藏">批量收藏</a>
               </div>
               <div class="btn-amount">
                  <p>
                     <a href="<?php echo url('app=store&id=' . $this->_var['store_id']. ''); ?>" class="inline-block back center">继续购物</a>
                     <span class="ml20">商品总价：</span>
                     <strong class="price fs14 strong mr20"  id="cart<?php echo $this->_var['store_id']; ?>_amount"><?php echo price_format($this->_var['cart']['amount']); ?></strong>
                     <a href="<?php echo url('app=order&goods=cart&store_id=' . $this->_var['store_id']. ''); ?>" class="inline-block btn fs14 center fff strong">填写并确认订单</a>
                  </p>
               </div>
            </div>
         </div>
         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
      </div>
   </div>
   <div class="interest mt20">
      <div class="title border fs14 padding5 f66 strong"><span class="arr"></span>你可能感兴趣的商品</div>
      <div class="content border border-t-0 clearfix">
         <?php $_from = $this->_var['interest']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
         <dl class="float-left">
           <dt><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img width="160" height="160" src="<?php echo $this->_var['goods']['default_image']; ?>" /></a></dt>
           <dd class="desc"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['goods']['goods_name']),50); ?></a></dd>
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