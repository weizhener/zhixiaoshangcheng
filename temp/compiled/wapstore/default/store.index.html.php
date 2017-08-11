<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <base href="<?php echo $this->_var['site_url']; ?>/" />

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

        <meta name="apple-mobile-web-app-capable" content="yes" />

        <meta name="apple-mobile-web-app-status-bar-style" content="black" />

        <?php echo $this->_var['page_seo']; ?>

        <link href="<?php echo $this->res_base . "/" . 'css/common.css'; ?>" rel="stylesheet" type="text/css" />

        <link href="<?php echo $this->res_base . "/" . 'css/flexslider.css'; ?>" rel="stylesheet" type="text/css" />

        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery-1.8.0.min.js'; ?>"></script>

        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery.flexslider.js'; ?>"></script>

        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/touchslider.dev.js'; ?>"></script>

        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/sub_menu.js'; ?>"></script>

        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>

        <script>

            $(window).load(function() {

                $('.flexslider').flexslider({

                    animation: "slide"

                });

            });

        </script>

    </head>



    <body>





        

        <div class="header clearfix">

            <a class="logo" href="<?php echo url('app=default'); ?>"></a>

            

            <div class="searchBar">

                <form id="" name="" method="get" action="index.php">

                    <input type="hidden" name="app" value="store" />

                    <input type="hidden" name="act" value="search" />

                    <input type="hidden" name="id" value="<?php echo $this->_var['store']['store_id']; ?>" />

                    <input name="keyword"  type="text" placeholder="搜搜看吧" class="search_text" /><input type="submit" value="" class="search_btn" />

                </form>

            </div>

            <a href="javascript:void(0)" class="icon-nav menu"></a>

            

            <div class="sub_menu">

                <p class="shop_name"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></p>

                <p style="text-align: center;margin-bottom: 10px;"><?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" /><?php endif; ?></p>

                <ul>

                    <?php $_from = $this->_var['store']['store_gcates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['gcategory']):
?>

                    <li>

                        <?php if ($this->_var['gcategory']['children']): ?>

                        <h2><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></h2>

                        <ol  class="sub_menu_list">

                            <?php $_from = $this->_var['gcategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child_gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['child_gcategory']):
?>

                            <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search&cate_id=' . $this->_var['child_gcategory']['id']. ''); ?>"><li><?php echo htmlspecialchars($this->_var['child_gcategory']['value']); ?></li></a>

                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                        </ol>

                        <?php else: ?>

                        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search&cate_id=' . $this->_var['gcategory']['id']. ''); ?>"><h2><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></h2></a>

                        <?php endif; ?>

                    </li>

                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                </ul>

            </div>

            

        </div>



        <script>

            $(function() {

                publicmain();

            });



            $(window).resize(function() {

                publicmain();

            });



            function publicmain() {

                var h = document.documentElement.clientHeight - 45;

                $('.sub_menu').css({'height': h});

            }

        </script>  









        <div class="store_info">

            <div class="info">

                <a class="store-block">

                    <img class="img" src="<?php echo $this->_var['store']['store_logo']; ?>"/>

                    <div class="store-text">

                        <div class="store-name"><?php echo $this->_var['store']['store_name']; ?></div>

                        <div class="store-info "><?php echo $this->_var['store']['sgrade']; ?><?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" /><?php endif; ?></div>

                    </div>

                </a>

                

            </div>

        </div>



        <div id="nav">

            <ul>

                <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><li  class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'index'): ?>active<?php else: ?>normal<?php endif; ?>" >首页</li></a>

                <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search'); ?>"><li  class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'coupon'): ?>active<?php else: ?>normal<?php endif; ?>" >所有商品</li></a>




            </ul>

        </div>



        

        <section class="slider">

            <div class="flexslider">

                <ul class="slides">

                    <?php $_from = $this->_var['goods_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_iamge');if (count($_from)):
    foreach ($_from AS $this->_var['goods_iamge']):
?>

                    <li>

                        <?php if ($this->_var['goods_iamge']['image_link']): ?>

                        <a href="<?php echo $this->_var['goods_iamge']['image_link']; ?>"> <img height="200px"  src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods_iamge']['image_url']; ?>"/></a>

                        <?php else: ?>

                        <img height="200px"  src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods_iamge']['image_url']; ?>"/>

                        <?php endif; ?>

                    </li>

                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                </ul>

            </div>

        </section>









        

        <?php if ($this->_var['recommended_goods']): ?>

        <div class="lists">

            <h2>橱窗推荐<a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&recommended=1">more+</a></h2>

            <ul>

                <?php $_from = $this->_var['recommended_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rgoods');if (count($_from)):
    foreach ($_from AS $this->_var['rgoods']):
?>

                <a href="<?php echo url('app=goods&id=' . $this->_var['rgoods']['goods_id']. ''); ?>">

                    <li>

                        <img src="<?php echo $this->_var['rgoods']['default_image']; ?>" />

                        <p><?php echo htmlspecialchars($this->_var['rgoods']['goods_name']); ?></p>

                        <span><?php echo price_format($this->_var['rgoods']['price']); ?></span>

                    </li>

                </a>

                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>



            </ul>

        </div>

        <?php endif; ?>



        <?php if ($this->_var['new_goods']): ?>

        <div class="lists">

            <h2>新品上市<a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&order=add_time%20desc">more+</a></h2>

            <ul>

                <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ngoods');if (count($_from)):
    foreach ($_from AS $this->_var['ngoods']):
?>

                <a href="<?php echo url('app=goods&id=' . $this->_var['ngoods']['goods_id']. ''); ?>">

                    <li>

                        <img src="<?php echo $this->_var['ngoods']['default_image']; ?>" />

                        <p><?php echo htmlspecialchars($this->_var['ngoods']['goods_name']); ?></p>

                        <span><?php echo price_format($this->_var['ngoods']['price']); ?></span>

                    </li>

                </a>

                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>



            </ul>

        </div>

        <?php endif; ?>

        

        <div class="all_category">

            <a href="<?php echo url('app=store&act=search&id=' . $this->_var['store']['store_id']. ''); ?>">

                <i class="icon-all"></i>

                <span>全部商品</span>

            </a>

        </div>

        <script>

            var t1 = new TouchSlider('slider1', {'auto': true, speed: 600, timeout: 6000})

        </script>





        <style>

            /*分享窗口样式*/

            .share_box_bg{width:100%;height:100%;left:0px;top:0px;opacity:0.5;z-index:1;position:fixed !important;background:#000;display:block;}

            .share_box{z-index:999;overflow:hidden;left:50%;top:40%;margin-left:-160px !important;margin-top:-120px !important;position:fixed !important;}

            .share_box .share_img{}

            .share_box .share_info{width:320px;border:#3d3d3c solid 1px;background:#efefef;}

            .share_box .box_title{width:320px;height:36px;line-height:36px;background:-webkit-gradient(linear, 0 0, 0 100%, from(#4c4e52), to(#6b6d73));background:-moz-linear-gradient(top, #4c4e52, #6b6d73);/* Firefox */filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#4c4e52,endColorstr=#6b6d73,grandientType=0);border-bottom:#7a7b81 solid 1px;}

            .share_box .box_title .name{width:90px;float:left;color:#fff;font-size:18px;font-weight:bold;padding-left:10px;}

            .share_box .box_title .close{width:30px;float:right;text-align:center;padding-top:2px;}

            .share_box .share_nr{width:280px;margin:15px auto 0px auto;text-align:center;}

            .share_box .share_nr a{display:block;height:40px;line-height:40px;overflow:hidden;margin-bottom:12px;color:#666;font-size:14px;width:100%;background:-webkit-gradient(linear, 0 0, 0 100%, from(#e6e6e6), to(#e5e5e5));background:-moz-linear-gradient(top, #e6e6e6, #e5e5e5);/* Firefox */filter:progid:DXImageTransform.Microsoft.gradient(startColorstr=#e6e6e6,endColorstr=#e5e5e5,grandientType=0);border:#c9c9c9 solid 1px;}

            .share_box .share_nr .share_ico{width:32px;padding-top:4px;float:left;padding-left:15px;}

            .share_box .share_nr .share_name{width:150px;padding-left:15px;text-align:left;float:left;}

        </style>

        <script>

            function showShare(areaid) {

                document.getElementById(areaid + "bg").style.display = "block";

                document.getElementById(areaid).style.display = "block";

            }



            function hideShare(areaid) {

                document.getElementById(areaid).style.display = "none";

                document.getElementById(areaid + "bg").style.display = "none";

            }

        </script>



        <div class="share_box_bg" id="shareboxbg" style="display: none;"></div>

        <div class="share_box" id="sharebox" style="display: none;">

            <div class="share_img">

                <img src="<?php echo $this->res_base . "/" . 'images/share_box_bg.png'; ?>" width="320"/>

            </div>

            <div class="share_info">

                <div class="box_title">

                    <p class="name">分享至：</p>

                    <p class="close"><a href="javascript:void(0);" title="关闭" onclick="hideShare('sharebox')" class="ui-link"><img src="<?php echo $this->res_base . "/" . 'images/fenxiang_close.png'; ?>" alt="关闭" /></a></p>

                </div>

                <div class="share_nr">

                    <a href="sms:?body=<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" id="smssharebox" title="分享到短信" class="ui-link">

                        <p class="share_ico"><img src="<?php echo $this->res_base . "/" . 'images/sms.png'; ?>" alt="分享到短信"/></p>

                        <p class="share_name">分享到短信</p>

                    </a>

                    <a href="http://service.weibo.com/share/share.php?&amp;title=<?php echo $this->_var['store']['store_name']; ?>" id="weibosharebox" title="分享到新浪微博" class="ui-link">

                        <p class="share_ico"><img src="<?php echo $this->res_base . "/" . 'images/sina.png'; ?>" alt="分享新浪微博"/></p>

                        <p class="share_name">分享到新浪微博</p>

                    </a>

                    <a href="http://share.v.t.qq.com/index.php?c=share&amp;a=index&amp;title=<?php echo $this->_var['store']['store_name']; ?>" id="tx_weibosharebox" title="分享到腾讯微博" class="ui-link">

                        <p class="share_ico"><img src="<?php echo $this->res_base . "/" . 'images/tengxun.png'; ?>" alt="分享腾讯微博"/></p>

                        <p class="share_name">分享到腾讯微博</p>

                    </a>

                </div>

            </div>

        </div>

<?php if ($this->_var['kmenus']['status'] == 0 || $this->_var['kmenus']['status'] == ''): ?>

<link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'css/kmenus.css'; ?>">

<div class="flo_btn_<?php if ($this->_var['kmenus']['stypeinfo'] == ''): ?>1<?php else: ?><?php echo $this->_var['kmenus']['stypeinfo']; ?><?php endif; ?>">

    <ul>

        <?php $_from = $this->_var['kmenusinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'info');if (count($_from)):
    foreach ($_from AS $this->_var['info']):
?>

        <li>

            <a style="background-color:#<?php echo $this->_var['info']['color']; ?>;" href="<?php if ($this->_var['info']['title'] == '导航'): ?>http://map.baidu.com/?newmap=1&ie=utf-8&s=s%26wd%3D<?php echo $this->_var['info']['loadurl']; ?><?php else: ?><?php echo $this->_var['info']['loadurl']; ?><?php endif; ?>"><span style="background:url('<?php echo $this->_var['info']['imgurl']; ?>') scroll no-repeat center center transparent;background-size:60%; bottom:0; left:0;"></span></a>

        </li>

        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </ul>

</div>

<?php endif; ?>

    </body>

</html>

