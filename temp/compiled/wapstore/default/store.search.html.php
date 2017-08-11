
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
        <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/sub_menu.js'; ?>"></script>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
    </head>
    <body>

        
        <div class="header clearfix" style="text-align: center;color: #fff;line-height: 40px;">
            <a class="logo" href="<?php echo url('app=default'); ?>"></a>
            
            <?php echo $this->_var['store']['store_name']; ?>
            <a href="javascript:void(0)" class="new-a-jd"><span>下拉</span></a>
        </div>    
        <script>
            $(function() {
                $(".new-a-jd").click(function() {
                    $(".new-jd-tab").fadeToggle();
                })
            })
        </script>
        <div class="new-jd-tab" style="display:none;">
            <div class="new-tbl-type">
                <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" class="new-tbl-cell">
                    <span class="icon">首页</span>
                    <p style="color:#6e6e6e;">首页</p>
                </a>
                <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" class="new-tbl-cell">
                    <span class="icon2">分类搜索</span>
                    <p style="color:#6e6e6e;">分类搜索</p>
                </a>
                <a href="<?php echo url('app=cart'); ?>" id="html5_cart" class="new-tbl-cell">
                    <span class="icon3">购物车</span>
                    <p style="color:#6e6e6e;">购物车</p>
                </a>
                <a href="<?php echo url('app=member'); ?>" class="new-tbl-cell">
                    <span class="icon4">我的商城</span>
                    <p style="color:#6e6e6e;">我的商城</p>
                </a>
            </div>
        </div>
        <div class="paixu">
            <a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&keyword=<?php echo $this->_var['keyword']; ?>&cate_id=<?php echo $this->_var['cate_id']; ?>&order=sales%20desc" class=" <?php if ($this->_var['sort'] == '4'): ?>cur<?php endif; ?>"><i class="icon-volume"></i>销量</a>
            <a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&keyword=<?php echo $this->_var['keyword']; ?>&cate_id=<?php echo $this->_var['cate_id']; ?>&order=add_time%20desc" class=" <?php if ($this->_var['sort'] == '1'): ?>cur<?php endif; ?>"><i class="icon-price"></i>新品</a>
            <a href="index.php?app=store&act=search&id=<?php echo $this->_var['store']['store_id']; ?>&keyword=<?php echo $this->_var['keyword']; ?>&cate_id=<?php echo $this->_var['cate_id']; ?>&order=price%20desc" class=" <?php if ($this->_var['sort'] == '2'): ?>cur<?php endif; ?>"><i class="icon-new"></i>价格</a>
        </div>
        
        <div class="lists lists1">
            <ul>
                <?php if ($this->_var['searched_goods']): ?>
                <?php $_from = $this->_var['searched_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgoods');if (count($_from)):
    foreach ($_from AS $this->_var['sgoods']):
?>
                <a href="<?php echo url('app=goods&id=' . $this->_var['sgoods']['goods_id']. ''); ?>">
                    <li>
                        <img src="<?php echo $this->_var['sgoods']['default_image']; ?>" />
                        <p><?php echo htmlspecialchars($this->_var['sgoods']['goods_name']); ?></p>
                        <span><?php echo price_format($this->_var['sgoods']['price']); ?></span>
                    </li>
                </a>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php else: ?>
                <div style="padding:50px 60px; text-align:center;background:#fff;margin:5px 5px 0;">很抱歉! 没有找到相关商品</div>
                <?php endif; ?>
            </ul>
        </div>

        
        <div class="page">
            <?php echo $this->fetch('page.bottom.html'); ?>
        </div>
        <?php echo $this->fetch('footer.html'); ?>
    </body>
</html>