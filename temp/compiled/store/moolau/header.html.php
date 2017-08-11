<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<base href="<?php echo $this->_var['site_url']; ?>/" />



<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo $this->_var['charset']; ?>" />

<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $this->_var['charset']; ?>" />

<?php echo $this->_var['page_seo']; ?>

<meta name="copyright" content="<?php echo $this->_var['ecmall_version']; ?>" />

<link href="<?php echo $this->res_base . "/" . 'css/global.css'; ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->res_base . "/" . 'shop.css'; ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->res_base . "/" . 'css/footer.css'; ?>" rel="stylesheet" type="text/css" />

<style>

#notice .notice_left{float:left;position:relative;}

#notice span{color:#333;padding:0 5px;height:20px;line-height:20px;display:block;float:left;}

#notice span.mun_code{border:1px solid #bfbfbf;cursor:pointer; background:#FFF;}

#notice span.current{border:1px solid #bfbfbf;border-bottom:none;background:#fff;position:relative;z-index:99999;}

.ncs_ctain{position:absolute;left:-75px;top:20px;height:270px;z-index:66;width:240px;border:1px solid #bfbfbf;background:#fff;display:none;}

.ncs_ctain p{padding:5px;text-align:center;font-size:12px;}

.ncs_ctain p img{width:230px;height:230px;overflow:hidden;}

</style>

<script type="text/javascript" src="index.php?act=jslang"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->_var['site_url']; ?>/themes/mall/taocz/styles/default/js/main.js" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'cart.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'kissy/build/kissy.js'; ?>"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'kissy/build/switchable/switchable-pkg.js'; ?>"></script>

<script type="text/javascript">

//<!CDATA[

var SITE_URL = "<?php echo $this->_var['site_url']; ?>";

var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";

var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';

//]]>

</script>

<?php echo $this->_var['_head_tags']; ?>

</head>

<style>

#footer .footer-fixed{margin-left:485px; display:none}

</style>

<body>

<div id="site-nav" class="w-full">

   <div class="shoptop w clearfix">

      <div class="login_info">

         您好，欢迎您！,

         <?php if (! $this->_var['visitor']['user_id']): ?>

         <?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?>

         <a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>">请登录</a>

         <a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>">注册</a>

         <?php else: ?>

         <a href="<?php echo url('app=member'); ?>"><span><?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?></span></a>

         <a href="<?php echo url('app=member&act=logout'); ?>">退出</a>

         <a href="<?php echo url('app=message&act=newpm'); ?>">站内消息<?php if ($this->_var['new_message']): ?>(<span><?php echo $this->_var['new_message']; ?></span>)<?php endif; ?></a>

         <?php endif; ?>

      </div>

      

<div id="notice">  

      <div class="notice_left">

		<span class="mun_code">店铺二维码</span>

		<div class="ncs_ctain" style="display:none;">

        <p><img src="<?php if ($this->_var['store']['qrocde_image']): ?><?php echo $this->_var['store']['qrocde_image']; ?> <?php else: ?> http://qr.liantu.com/api.php?bg=ffffff&fg=000000&gc=000000&el=l&w=150&m=10&text=<?php echo $this->_var['store']['store_url']; ?> <?php endif; ?>"  /></p>

        <p>手机扫描二维码</p>

        </div>

		<script type="text/javascript">

          $(function(){

			$('#notice .mun_code').hover(function(){

			$("#notice .mun_code").addClass(' current'); 

			$("#notice .ncs_ctain").css('display','block');

			},function(){

			$("#notice .mun_code").removeClass(' current'); 

			$("#notice .ncs_ctain").css('display','none');

			});

			});

        </script>

       </div>

</div>

      

      <ul class="quick-menu">

        <?php if (! $this->_var['index']): ?><li class="home"><a href="<?php echo $this->_var['site_url']; ?>">回到首页</a></li><?php endif; ?>

        <li class="item">

           <div class="menu iwantbuy">

              <a class="menu-hd" href="<?php echo url('app=category'); ?>">我要买<b></b></a>

              <div class="menu-bd">

                 <div class="menu-bd-panel">

                    <div>

                       <p><a href="<?php echo url('app=category'); ?>">商品分类</a></p>

                       <p><a href="<?php echo url('app=category&act=store'); ?>">店铺分类</a></p>

                       <p><a href="<?php echo url('app=brand'); ?>">品牌</a></p>

                    </div>

                 </div>

              </div>

           </div>

         </li>

         <li class="item">

            <div class="menu mytb">

               <a class="menu-hd" href="<?php echo url('app=buyer_admin'); ?>">我是买家<b></b></a>

               <div class="menu-bd">

                  <div class="menu-bd-panel">

                     <div>

                        <p><a href="<?php echo url('app=buyer_order'); ?>">已买到的宝贝</a></p>

                        <p><a href="<?php echo url('app=friend'); ?>">我的好友</a></p>

                        <p><a href="<?php echo url('app=my_question'); ?>">我的咨询</a></p>

                     </div>

                  </div>

               </div>

            </div>

         </li>

         <li class="item">

            <div class="menu seller-center">

               <a class="menu-hd" href="<?php echo url('app=seller_admin'); ?>">卖家中心<b></b></a>

               <div class="menu-bd">

                  <div class="menu-bd-panel">

                     <div>

                        <p><a href="<?php echo url('app=seller_order'); ?>">已卖出的宝贝</a></p>

                        <p><a href="<?php echo url('app=my_goods'); ?>">出售中的宝贝</a></p>

                     </div>

                  </div>

               </div>

            </div>

         </li>

         <li class="item">

            <div class="menu mini-cart">

               <a class="ac" href="<?php echo url('app=cart'); ?>">

                  <s></s>购物车<strong><?php echo $this->_var['cart_goods_kinds']; ?></strong>件<b></b>

               </a>

               <div class="mini-cart-content menu-bd">

                  <dl class="mini-cart-bd">

                     <?php if ($this->_var['cart_goods_kinds']): ?>

                     <dt class="mini-cart-hd">最近加入的宝贝：</dt>

                     <?php $_from = $this->_var['carts_top']['cart_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cart');$this->_foreach['fe_cart'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_cart']['total'] > 0):
    foreach ($_from AS $this->_var['cart']):
        $this->_foreach['fe_cart']['iteration']++;
?>

                     <dd class="clearfix" id="cart_goods<?php echo $this->_var['cart']['rec_id']; ?>">

                        <div class="mini-cart-img">

                           <a href="<?php echo url('app=goods&id=' . $this->_var['cart']['goods_id']. ''); ?>" target="_top">

                              <img alt="<?php echo $this->_var['cart']['goods_name']; ?>" src="<?php echo $this->_var['cart']['goods_image']; ?>" width="40" height="40">

                           </a>

                        </div>

                        <div class="mini-cart-title">

                           <a title="<?php echo $this->_var['cart']['goods_name']; ?>" href="<?php echo url('app=goods&id=' . $this->_var['cart']['goods_id']. ''); ?>" target="_top"><?php echo $this->_var['cart']['goods_name']; ?></a>

                        </div>

                        <div class="price-admin">

                           <div class="mini-cart-count"><strong class="mini-cart-price"><?php echo price_format($this->_var['cart']['price']); ?></strong></div>

                           <div class="mini-cart-del"><a href="javascript:;" onclick="drop_cart_item(<?php echo $this->_var['cart']['store_id']; ?>, <?php echo $this->_var['cart']['rec_id']; ?>);">删除</a></div>

                        </div>

                     </dd>

                     <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                     <?php else: ?>

                     <dt class="mt10 float-left mini-cart-empty">您购物车里还没有任何宝贝</dt>

                     <?php endif; ?>

                     <dd class="mini-cart-bt">

                        <a href="<?php echo url('app=cart'); ?>">查看我的购物车</a>

                     </dd>                          

                  </dl>

               </div>

            </div>

         </li>

         <li class="item">

            <div class="menu favorite">

               <a class="menu-hd" href="<?php echo url('app=my_favorite'); ?>">收藏夹<b></b></a>

               <div class="menu-bd">

                  <div class="menu-bd-panel">

                     <div>

                       <p><a href="<?php echo url('app=my_favorite'); ?>">收藏的宝贝</a></p>

                       <p><a href="<?php echo url('app=my_favorite&type=store'); ?>">收藏的店铺</a></p>

                    </div>

                 </div>

               </div>

           </div>

         </li>

         <li class="service">

            <a href="<?php echo url('app=article&code=help'); ?>">帮助中心</a>

         </li>

         <li class="item" style="background:none">

            <div class="menu sites">

               <a class="menu-hd" href="javascript:;">网站导航<b></b></a>

               <div class="menu-bd padding10">

                  <?php $_from = $this->_var['navs']['header']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>

                  <a href="<?php echo $this->_var['nav']['link']; ?>"<?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?></a>

                  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

               </div>

            </div>

        </li>

     </ul>

   </div>

   <style>

.fixed-top /* 头部固定 */{position:fixed;bottom:auto;top:200px;}

.fixed-bottom /* 底部固定 */{position:fixed;bottom:0px;top:auto;}

.fixed-left /* 左侧固定 */{position:fixed;right:auto;left:0px;}

.fixed-right /* 右侧固定 */{position:fixed;right:0px;left:auto;}

/* 上面的是除了IE6的主流浏览器通用的方法 */

* html,* html body /* 修正IE6振动bug */{background-image:url(about:blank);background-attachment:fixed;}

* html .fixed-top /* IE6 头部固定 */{position:absolute;bottom:auto;top:expression(eval(document.documentElement.scrollTop)+200);}

* html .fixed-right /* IE6 右侧固定 */ {position:absolute;right:auto;left:expression(eval(document.documentElement.scrollLeft+document.documentElement.clientWidth-this.offsetWidth)-(parseInt(this.currentStyle.marginLeft,10)||0)-(parseInt(this.currentStyle.marginRight,10)||0));}

* html .fixed-bottom /* IE6 底部固定  */{position:absolute;bottom:auto;top:expression(eval(document.documentElement.scrollTop+document.documentElement.clientHeight-this.offsetHeight-(parseInt(this.currentStyle.marginTop,10)||0)-(parseInt(this.currentStyle.marginBottom,10)||0)));}

* html .fixed-left /* IE6 左侧固定 */{position:absolute;right:auto;left:expression(eval(document.documentElement.scrollLeft));}

</style>

   <div class="kefufixed fixed-top fixed-right">

      <div class="show-1">

      	<div class="title">

        	<h3></h3>

            <span></span>

        </div>

        <div class="content">

        	<div class="im">

        	<?php $_from = $this->_var['store']['online_service']['qq']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'qq');if (count($_from)):
    foreach ($_from AS $this->_var['qq']):
?>

            <a href="http://wpa.qq.com/msgrd?V=1&amp;uin=<?php echo htmlspecialchars($this->_var['qq']); ?>&amp;Site=<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['qq']); ?>:1" alt="有事咨询我" align="absmiddle"></a>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            

            <?php $_from = $this->_var['store']['online_service']['ww']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ww');if (count($_from)):
    foreach ($_from AS $this->_var['ww']):
?>

            <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo urlencode($this->_var['ww']); ?>&site=cntaobao&s=1&charset=<?php echo $this->_var['charset']; ?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo urlencode($this->_var['ww']); ?>&site=cntaobao&s=1&charset=<?php echo $this->_var['charset']; ?>" alt="有事咨询我" align="absmiddle" /></a>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            

            </div>

            <?php if ($this->_var['store']['hotline']): ?>

            <div class="tel">

            	<h3>服务热线</h3>

                <p><?php echo $this->_var['store']['hotline']; ?></p>

            </div>

            <?php endif; ?>

        </div>

        <div class="bottom">

        	<h3><a href="<?php echo url('app=order'); ?>" class="gotoorder"></a><a href="<?php echo url('app=cart'); ?>" class="gotocart"></a></h3>

            <p onclick="javascript:scroll(0,0)"></p>

        </div>

      </div>

      <div class="show-2 hidden">

      	 <h3></h3>

      </div>

   </div>

   <script>

   		$(function(){

			$('.kefufixed .show-1 .title h3').click(function(){

				$('.kefufixed .show-1').hide();

				$('.kefufixed .show-2').show();

			});

			$('.kefufixed .show-2').click(function(){

				$(this).hide();

				$('.kefufixed .show-1').show();

			});

		});

  </script>

</div>

