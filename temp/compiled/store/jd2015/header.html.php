<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<base href="<?php echo $this->_var['site_url']; ?>/" />



<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7 charset=<?php echo $this->_var['charset']; ?>" />

<meta http-equiv="Content-Type" content="text/html;charset=<?php echo $this->_var['charset']; ?>" />

<?php echo $this->_var['page_seo']; ?>

<meta name="generator" content="<?php echo $this->_var['ecmall_version']; ?>" />

<link href="<?php echo $this->res_base . "/" . 'css/header.css'; ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->res_base . "/" . 'shop.css'; ?>" rel="stylesheet" type="text/css" />

<link href="<?php echo $this->res_base . "/" . 'css/footer.css'; ?>" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="index.php?act=jslang"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'cart.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/main.js'; ?>" charset="utf-8"></script>

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

<!--<editmode></editmode>-->

</head>



<body>

<div id="site-nav" class="w-full">

   <div class="shoptop w clearfix">

      <div class="login_info">

         您好，欢迎您！

         <?php if (! $this->_var['visitor']['user_id']): ?>

         <a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>">请登录</a>

         <a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>">注册</a>

         <?php else: ?>

         <a href="<?php echo url('app=member'); ?>"><?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?></a>

         <a href="<?php echo url('app=message&act=newpm'); ?>">站内消息<?php if ($this->_var['new_message']): ?>(<span><?php echo $this->_var['new_message']; ?></span>)<?php endif; ?></a>

         <a href="<?php echo url('app=member&act=logout'); ?>">退出</a>

         <?php endif; ?>

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

    

    

<div id="header" class="w-full">

    <div class="shop-t w clearfix pb10 mb5 mt5">

        <div class="logo">

            <a href="<?php echo $this->_var['site_url']; ?>" title="<?php echo $this->_var['site_title']; ?>"><img alt="<?php echo $this->_var['site_title']; ?>" src="<?php echo $this->_var['site_logo']; ?>" /></a>

        </div>

        <div class="top-search">

            <div class="top-search-box clearfix">

                <ul class="top-search-tab clearfix">

                    <li id="index" class="current"><span>商品</span></li>

                    <li id="store"><span>店铺</span></li>

                    <li id="groupbuy"><span>团购</span></li>

                </ul>

                <div class="form-fields">

                    <form method="GET" action="<?php echo url('app=search'); ?>">

                        <input type="hidden" name="app" value="search" />

                        <input type="hidden" name="act" value="<?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>" />

                        <input type="text"   name="keyword" value="<?php echo $_GET['keyword']; ?>" class="keyword <?php if (! $_GET['keyword']): ?>kw_bj <?php if ($_GET['act'] == 'store'): ?>store<?php elseif ($_GET['act'] == 'groupbuy'): ?>groupbuy<?php else: ?>index<?php endif; ?>_bj <?php endif; ?>" />

                        <input type="submit" value="搜索" class="submit" hidefocus="true" />

                    </form>

                </div>

            </div>

            <div class="top-search-keywords">

                <?php $_from = $this->_var['hot_keywords']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');$this->_foreach['fe_keyword'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_keyword']['total'] > 0):
    foreach ($_from AS $this->_var['keyword']):
        $this->_foreach['fe_keyword']['iteration']++;
?>

                <a <?php if ($this->_foreach['fe_keyword']['iteration'] % 3 == 1): ?>style="color:#c40000;"<?php endif; ?> href="<?php echo url('app=search&keyword=' . urlencode($this->_var['keyword']). ''); ?>"><?php echo $this->_var['keyword']; ?></a>|

                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            </div>

        </div>

        <div class="header_cart">

            <div class="title clearfix">

                <b></b><a href="<?php echo url('app=cart'); ?>">去购物车结算</a><em></em>

            </div>

            <div class="shoping"><span class="count-cart J_C_T_GoodsKinds"><?php echo $this->_var['cart_goods_kinds']; ?></span></div>

            <div class="cart-list">

                <?php if ($this->_var['carts_top']['cart_items']): ?>

                <div class="goods-list">

                    <h4>最新加入的商品</h4>

                    <?php $_from = $this->_var['carts_top']['cart_items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cart');$this->_foreach['fe_cart'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_cart']['total'] > 0):
    foreach ($_from AS $this->_var['cart']):
        $this->_foreach['fe_cart']['iteration']++;
?>

                    <div <?php if (($this->_foreach['fe_cart']['iteration'] == $this->_foreach['fe_cart']['total'])): ?>style="border:0px;"<?php endif; ?> class="clearfix list" id="cart_goods<?php echo $this->_var['cart']['rec_id']; ?>">

                        <div class="goods-img">

                            <a href="<?php echo url('app=goods&id=' . $this->_var['cart']['goods_id']. ''); ?>" target="_top"><img alt="<?php echo $this->_var['cart']['goods_name']; ?>" src="<?php echo $this->_var['cart']['goods_image']; ?>" width="40" height="40"></a>

                        </div>

                        <div class="goods-title">

                            <a title="<?php echo $this->_var['cart']['goods_name']; ?>" href="<?php echo url('app=goods&id=' . $this->_var['cart']['goods_id']. ''); ?>" target="_top"><?php echo $this->_var['cart']['goods_name']; ?></a>

                        </div>

                        <div class="goods-admin">

                            <div class="mini-cart-count"><strong class="mini-cart-price J_C_T_Price"><?php echo price_format($this->_var['cart']['price']); ?></strong> x <?php echo $this->_var['cart']['quantity']; ?></div>

                            <div class="mini-cart-del"><a href="javascript:;" onclick="drop_cart_item(<?php echo $this->_var['cart']['store_id']; ?>, <?php echo $this->_var['cart']['rec_id']; ?>);">删除</a></div>

                        </div>

                    </div>

                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                </div>

                <div class="total">

                    <span>共<strong class="J_C_T_GoodsKinds"><?php echo $this->_var['cart_goods_kinds']; ?></strong>件商品</span><span>共计<strong class="J_C_T_Amount"><?php echo price_format($this->_var['carts_top']['total']); ?></strong></span><br />

                    <a href="<?php echo url('app=cart'); ?>">去购物车结算</a>

                </div>

                <?php else: ?>

                <div class="nogoods clearfix">

                    <b></b>购物车中还没有商品，赶紧选购吧！

                </div>

                <?php endif; ?>

            </div>

        </div>

    </div>

    <div class="w-full mall-nav">

        <ul class="w clearfix">

            <li class="allcategory float-left">

                <a class="allsort" href="<?php echo url('app=category'); ?>" target="_blank">全部商品分类</a>

                <?php if (! $this->_var['index']): ?>

                <div class="allcategory-list hidden">

                    <div class="content clearfix">

                        <?php $_from = $this->_var['header_gcategories']['gcategories']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'category');$this->_foreach['fe_category'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_category']['total'] > 0):
    foreach ($_from AS $this->_var['category']):
        $this->_foreach['fe_category']['iteration']++;
?>

                        <div class="item item_<?php echo $this->_foreach['fe_category']['iteration']; ?>">

                            <div class="pborder">

                                <p><a href="<?php echo url('app=search&cate_id=' . $this->_var['category']['id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['category']['value']); ?></a><b>></b></p>

                            </div>

                            <div class="pop" <?php if ($this->_var['category']['top']): ?> style="top:<?php echo $this->_var['category']['top']; ?>"<?php endif; ?>>

                                <div class="item-channels">

                                    <?php $_from = $this->_var['category']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?> 

                                    <a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?><b>></b></a>

                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                </div>

                                <div class="catlist float-left">

                                    <?php $_from = $this->_var['category']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?> 

                                    <dl class="clearfix" <?php if (($this->_foreach['fe_child']['iteration'] == $this->_foreach['fe_child']['total'])): ?> style="border-bottom:0"<?php endif; ?>>

                                        <dt class="float-left"><a href="<?php echo url('app=search&cate_id=' . $this->_var['child']['id']. ''); ?>"><strong><?php echo htmlspecialchars($this->_var['child']['value']); ?></strong></a><b>></b></dt>

                                        <dd class="float-left">

                                            <?php $_from = $this->_var['child']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child2');$this->_foreach['fe_child2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child2']['total'] > 0):
    foreach ($_from AS $this->_var['child2']):
        $this->_foreach['fe_child2']['iteration']++;
?>

                                            <a href="<?php echo url('app=search&cate_id=' . $this->_var['child2']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child2']['value']); ?></a>

                                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                        </dd>

                                    </dl> 

                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                                </div>

                            </div>

                        </div>

                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                    </div>

                </div>

                <?php endif; ?>

            </li>



            <li class="each float-left inline-block"><a  href="<?php echo $this->_var['site_url']; ?>">首页</a></li>

            <?php $_from = $this->_var['navs']['middle']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'nav');if (count($_from)):
    foreach ($_from AS $this->_var['nav']):
?>

            <li class="each float-left inline-block"><a class="<?php if (! $this->_var['index'] && $this->_var['nav']['link'] == $this->_var['current_url']): ?>current<?php endif; ?>" href="<?php echo $this->_var['nav']['link']; ?>"<?php if ($this->_var['nav']['open_new']): ?> target="_blank"<?php endif; ?>><?php echo htmlspecialchars($this->_var['nav']['title']); ?><?php if ($this->_var['nav']['hot'] == 1): ?><span class="absolute block"></span><?php endif; ?></a></li>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        </ul>

    </div>

</div>