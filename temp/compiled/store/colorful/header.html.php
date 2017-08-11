<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<base href="<?php echo $this->_var['site_url']; ?>/" />



<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo $this->_var['charset']; ?>" />

<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $this->_var['charset']; ?>" />

<?php echo $this->_var['page_seo']; ?>

<meta name="copyright" content="<?php echo $this->_var['ecmall_version']; ?>" />

<link href="<?php echo $this->res_base . "/" . 'shop.css'; ?>" rel="stylesheet" type="text/css" />

<style>

#notice .notice_left{float:left;position:relative; margin-left:200px;}

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

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'kissy/build/kissy.js'; ?>"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'kissy/build/switchable/switchable-pkg.js'; ?>"></script>

<!--[if lte IE 6]>

<script type="text/javascript" language="Javascript" src="<?php echo $this->res_base . "/" . 'js/hoverForIE6.js'; ?>"></script>

<![endif]-->

<script type="text/javascript">

//<!CDATA[

var SITE_URL = "<?php echo $this->_var['site_url']; ?>";

var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";

var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';



//]]>

	$(function(){

		$('.skin_box .backtop').hide();

		$(window).scroll(function(){

			var t=$(window).scrollTop();

			if(t > 500){

				$('.skin_box .backtop').show();

			}else{

				$('.skin_box .backtop').hide();	

			}

		});

		$("#search-form input[name='keyword']").focus(function(){

		   $('#search-form').addClass("form-focus");

		   $('#search-form .search-tips').hide();

	   }).blur(function(){

		   if($.trim($(this).val())=="") {

			   $('#search-form').removeClass("form-focus");

			   $('#search-form .search-tips').show();

		   }

	   });

	   $('#search-form .search-tips').click(function(){

		   $("#search-form input[name='keyword']").focus();

		});

		

		$('#shop-info-new').hover(function(){

			$('.headerNav #shop-info-new .con-out').show();

			$(this).addClass('hover');

		},function(){

			$('.headerNav #shop-info-new .con-out').hide();

			$(this).removeClass('hover');

		});

	});

	function mallSearch(){

		var keyword = $("#search-form input[name='keyword']").val();

		return location.href='<?php echo $this->_var['site_url']; ?>/index.php?app=search&keyword='+keyword;

	}

</script>

<?php echo $this->_var['_head_tags']; ?>

<!--<editmode></editmode>-->

</head>



<body>

<div id="site-nav" class="w-full">

   <div class="shoptop w clearfix">

      <div class="login_info">

         

      </div>

      <ul class="quick-menu">

      

         <li style="line-height:23px;" class="login_area">您好，欢迎您！,

         <?php if (! $this->_var['visitor']['user_id']): ?>

         <?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?></li>

         <li class="login_area">[<a class="ml5 mr5" href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>">请登录</a>]</li>

         <li class="login_area">[<a class="ml5 mr5" href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>">注册</a>]</li>

         <?php else: ?>

         <a href="<?php echo url('app=member'); ?>"><span><?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?></span></a></li>

         <li class="login_area"><a href="<?php echo url('app=member&act=logout'); ?>">退出</a></li>

         <li class="login_area"><a href="<?php echo url('app=message&act=newpm'); ?>">站内消息<?php if ($this->_var['new_message']): ?>(<span><?php echo $this->_var['new_message']; ?></span>)<?php endif; ?></a></li>

         <?php endif; ?>

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

               <a class="menu-hd" href="<?php echo url('app=member'); ?>">我是买家<b></b></a>

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

               <a class="menu-hd" href="<?php echo url('app=member'); ?>">卖家中心<b></b></a>

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

                     <?php $_from = $this->_var['carts_top']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cart');if (count($_from)):
    foreach ($_from AS $this->_var['cart']):
?>

                     <dd class="mini-cart-each clearfix" id="cart_goods<?php echo $this->_var['cart']['rec_id']; ?>">

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

                           <div class="mini-cart-del"><a href="javascript:;" onclick="drop_cart_item(<?php echo $this->_var['cart']['store_id']; ?>, <?php echo $this->_var['cart']['rec_id']; ?>, <?php echo $this->_var['cart']['goods_id']; ?>);">删除</a></div>

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

</div>

<div id="store-head" class="w-full">

	<div class="w clearfix">

        <h1 class="logo">

            <a href="<?php echo $this->_var['site_url']; ?>" target="_blank" class="mlogo"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a>

            <span class="slogo">

                <a title="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?>

                	<span class="flagship-icon"><?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" /><?php endif; ?></span>

                </a>

            </span>

        </h1>

        <div class="shop-search" id="shop-search">

            <form class="search-form form-hover" id="search-form" action="index.php" method="get">

                <label class="search-tips" for="shop-q">想找什么宝贝?</label>

                <input type="text" class="search-input" name="keyword">

                <input type="hidden" value="store" name="app">

				<input type="hidden" value="search" name="act">

                <input type="hidden" name="id" value="<?php echo $this->_var['store']['store_id']; ?>" />

                <input type="button" class="search-button searchtb" onclick="mallSearch()" value=""/>

                <input type="submit" class="search-button searchmy" value=""/>

            </form>

        </div>

    </div>

    <div class="headerNav w-full">

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

	

        <div class="w">

             <ul class="headerPromise">

                 <li class="hPicon1"><a href="javascript:;" title="正品行货" target="_blank"></a></li>

                 <li class="hPicon2"><a href="javascript:;" title="提供发票" target="_blank"></a></li>

                 <li class="hPicon3"><a href="javascript:;" title="七天退换" target="_blank">七天退换</a></li>

             </ul>

    		<div id="shop-info-new">

    			<div class="main-info"><label class="shop">店铺：</label><span class="dsr-info"><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&nbsp;&nbsp;&nbsp;<span class="rateinfo">好评率：<em class="lower"><?php echo $this->_var['store']['praise_rate']; ?> %</em></span></a></span><i class="icon-triangle"></i>

                </div>

                <div class="con-out">

                    <div class="shop-intro clearfix">

                        <div class="intro">

                            <dl>

                                <dt>掌&nbsp;&nbsp;&nbsp;柜:</dt>

                                <dd><span><?php echo htmlspecialchars($this->_var['store']['store_owner']['user_name']); ?></span></dd>

                            </dl>

                            <dl>

                                <dt>商品数量:</dt>

                                <dd><span><?php echo $this->_var['store']['goods_count']; ?></span></dd>

                            </dl>

                            <dl>

                                <dt>创店时间:</dt>

                                <dd><span><?php echo local_date("Y-m-d",$this->_var['store']['add_time']); ?></span></dd>

                            </dl>

                            <?php if ($this->_var['store']['certifications']): ?>

                            <dl>

                                <dt>认&nbsp;&nbsp;&nbsp;证: </dt>

                                <?php $_from = $this->_var['store']['certifications']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cert');if (count($_from)):
    foreach ($_from AS $this->_var['cert']):
?>

                                    <?php if ($this->_var['cert'] == "autonym"): ?>

                                    <dd class="auth-dd"><a href="<?php echo url('app=article&act=system&code=cert_autonym'); ?>" target="_blank" title="实名认证"><img src="<?php echo $this->res_base . "/" . 'images/cert_autonym.gif'; ?>" /></a></dd>

                                    <?php elseif ($this->_var['cert'] == "material"): ?>

                                    <dd class="auth-dd"><a href="<?php echo url('app=article&act=system&code=cert_material'); ?>" target="_blank" title="实体店铺"><img src="<?php echo $this->res_base . "/" . 'images/cert_material.gif'; ?>" /></a></dd>

                                    <?php endif; ?>

                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                            </dl>

                            <?php endif; ?>

                            <dl>

                                <dt>所在地区:</dt>

                                                                           

                                <dd><span><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></span></dd>

                            </dl>

                            <?php if ($this->_var['store']['address']): ?>

<!--                            <dl>

                                <dt>详细地址:</dt>

                                <dd><?php echo htmlspecialchars($this->_var['store']['address']); ?></dd>

                            </dl>-->

                            <?php endif; ?>

                            <?php if ($this->_var['store']['tel']): ?>

<!--                            <dl>

                                <dt>联系电话:</dt>

                                <dd><?php echo htmlspecialchars($this->_var['store']['tel']); ?></dd>

                            </dl>-->

                            <?php endif; ?>

                            <?php if ($this->_var['store']['im_qq'] || $this->_var['store']['im_ww'] || $this->_var['store']['im_msn']): ?>

                            <dl>

                                <dt>客&nbsp;&nbsp;&nbsp;服:</dt>

                                <?php if ($this->_var['store']['im_qq']): ?>

                                <dd><a href="http://wpa.qq.com/msgrd?V=1&amp;uin=<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>&amp;Site=<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>:4" alt="QQ"></a></dd>

                                <?php endif; ?>

                                <?php if ($this->_var['store']['im_ww']): ?>

                                <dd><a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" alt="Wang Wang" /></a></dd>

                                <?php endif; ?>

                                <?php if ($this->_var['store']['im_msn']): ?>

                                <dd><a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>"><img src="http://messenger.services.live.com/users/<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>/presenceimage/" alt="status" /></a></dd>

                                <?php endif; ?>

                            </dl>

                            <?php endif; ?>

                        </div>

                        <div class="other">

                            <p>好评率:<?php echo $this->_var['store']['praise_rate']; ?> %</p>

                            <a target="_blank" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>">进入店铺</a>

                            <a href="javascript:collect_store(<?php echo $this->_var['store']['store_id']; ?>)" class="collect-store">收藏店铺</a>

                        </div>

                    </div>

                </div>

    		</div>

        </div>

    </div>

</div>

<?php if (! $this->_var['store_index']): ?>

<div class="skin_box">

        <div class="backtop">

            <span onclick="window.scrollTo(0,0);" style="border-width:1px;"></span>

        </div>

</div>

<?php endif; ?>



