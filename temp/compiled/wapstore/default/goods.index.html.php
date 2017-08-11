<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="<?php echo $this->_var['site_url']; ?>/" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
        <meta content="telephone=no" name="format-detection" />
        <meta name="apple-mobile-web-app-capable" content="yes" />
        <meta name="apple-mobile-web-app-status-bar-style" content="black" />
        <?php echo $this->_var['page_seo']; ?>
        <link href="<?php echo $this->res_base . "/" . 'css/common.css'; ?>" type="text/css" rel="stylesheet" />
        <link href="<?php echo $this->res_base . "/" . 'css/detail.css'; ?>" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/jquery-1.8.0.min.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/sub_menu.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/touchslider.dev.js'; ?>"></script>
        <script type="text/javascript" src="index.php?act=jslang"></script>


        <script type="text/javascript">
        //<!CDATA[
            var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
            var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";
            var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';

        //]]>
        </script>
        <?php echo $this->_var['_head_tags']; ?>

    </head>
    <body>

        <?php echo $this->fetch('header.html'); ?>


        
        <?php echo $this->fetch('goodsinfo.html'); ?>

        <div class="detail_con">
            <ul class="tab">
                <li class="cur">商品详情</li>
                <li><span><?php echo $this->_var['comments']; ?></span></li>
            </ul>
            <div class="tab_con">
                <?php echo html_filter($this->_var['goods']['description']); ?>
            </div>
            <div class="tab_con" style="display:none;">
                <ul class="comments_list">
                    <?php $_from = $this->_var['goods_comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'comment');if (count($_from)):
    foreach ($_from AS $this->_var['comment']):
?>
                    <li>
                        <p><span><?php if ($this->_var['comment']['anonymous']): ?>***<?php else: ?><?php echo htmlspecialchars($this->_var['comment']['buyer_name']); ?><?php endif; ?> (<?php echo local_date("Y-m-d H:i:s",$this->_var['comment']['evaluation_time']); ?>)</span><b style="float:right;margin-right:8px">评分:<?php if ($this->_var['comment']['evaluation'] > 0): ?><img style="width:11px;height:11px;" src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
                                <?php if ($this->_var['comment']['evaluation'] > 1): ?><img style="width:11px;height:11px;" src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
                                <?php if ($this->_var['comment']['evaluation'] > 2): ?><img style="width:11px;height:11px;" src="<?php echo $this->res_base . "/" . 'images/bit.gif'; ?>" /><?php endif; ?>
                                <?php if ($this->_var['comment']['evaluation'] < 3): ?><img style="width:11px;height:11px;" src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?>
                                <?php if ($this->_var['comment']['evaluation'] < 2): ?><img style="width:11px;height:11px;" src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?>
                                <?php if ($this->_var['comment']['evaluation'] < 1): ?><img style="width:11px;height:11px;" src="<?php echo $this->res_base . "/" . 'images/bit2.gif'; ?>" /><?php endif; ?></b></p>
                        <p class="con"><?php echo nl2br(htmlspecialchars($this->_var['comment']['comment'])); ?></p>
                    </li>
                    <?php endforeach; else: ?>
                    <li>该商品还没有评论!</li>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                

            </div>
        </div>
        
        <script type="text/javascript">
            jQuery(function(jq) {
                function changeTab(lis, divs) {
                    lis.each(function(i) {
                        var els = jq(this);
                        els.click(function() {
                            lis.removeClass();
                            divs.stop().hide().animate({'opacity': 0}, 0);
                            jq(this).addClass("cur");
                            divs.eq(i).show().animate({'opacity': 1}, 300);
                        });
                    });
                }
                var rrE = jq(".detail_con");
                changeTab(rrE.find(".tab li"), rrE.find(".tab_con"));

            });
        </script>
        
        <?php echo $this->fetch('footer.html'); ?>
    </body>
</html>
