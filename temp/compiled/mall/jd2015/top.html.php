<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<base href="<?php echo $this->_var['site_url']; ?>/" />
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_var['charset']; ?>" />
<?php echo $this->_var['page_seo']; ?>
<meta name="generator" content="<?php echo $this->_var['ecmall_version']; ?>" />
<link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /> 
<link type="text/css" href="<?php echo $this->res_base . "/" . 'css/header.css'; ?>" rel="stylesheet" />
<link type="text/css" href="<?php echo $this->res_base . "/" . 'css/main.css'; ?>" rel="stylesheet"  />
<link type="text/css" href="<?php echo $this->res_base . "/" . 'css/footer.css'; ?>" rel="stylesheet" />

<script type="text/javascript" src="index.php?act=jslang"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'cart.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/main.js'; ?>" charset="utf-8"></script> 
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
      
         
             <li class="item">
            <div class="menu mytb">
               <a class="menu-hd" href="javascript:;">客户端<b></b></a>
               <div class="menu-bd" style="width:auto;height:auto">
                  <div class="menu-bd-panel">
                   
                        <img src="<?php echo $this->res_base . "/" . 'images/qr.png'; ?>"  />
                     
                  </div>
               </div>
            </div>
         </li>
      
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