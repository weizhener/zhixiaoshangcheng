
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
        <?php echo $this->fetch('header.html'); ?>

        <script type="text/javascript">
            //<!CDATA[
            var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
            var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";
            var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';

            //]]>
        </script>
        <style>
            .coupon{margin-top:50px;}
            .coupon li{margin: 0 auto;position: relative;height:150px;text-align: left;width:100%;float:left;margin:10px 0;}
            .coupon li p{background-color:#fff; opacity:0.8;filter:alpha(opacity=80);}
            .coupon li .cardbg {height:150px;width:100%;position: absolute;border-radius: 8px;-webkit-border-radius: 8px;-moz-border-radius: 8px;box-shadow: 0 0 4px rgba(0, 0, 0, 0.6);-moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.6);-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);top: 0;left: 0;z-index: 1;}
            .coupon li .name{position: absolute;right: 10px;top: 0px;text-align: center;z-index:22;font-size: 12px;font-weight: bold;}
            .coupon li .price{position: absolute;right: 10px;top:20px;text-align: center;z-index:22;font-size:16px;font-weight: bold;color: red;}
            .coupon li .time{position: absolute;right: 10px;top:40px;text-align: center;z-index:22;font-size: 12px;font-weight: bold;}
        </style>


        <script>
            function add_coupon(coupon_id) {

<?php if (! $this->_var['visitor']['user_id']): ?>
                alert('请先登录');
                return;
<?php endif; ?>

                var url = SITE_URL + '/index.php?app=my_coupon&act=add';
                $.getJSON(url, {'coupon_id': coupon_id}, function(data) {
                    if (data.done)
                    {
                        alert(data.retval);
                    }
                    else
                    {
                        alert(data.msg);
                    }
                });
            }
        </script>

        <div id="content">
            <ul class="coupon">
                <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');$this->_foreach['fe_coupon'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_coupon']['total'] > 0):
    foreach ($_from AS $this->_var['coupon']):
        $this->_foreach['fe_coupon']['iteration']++;
?>
                <li onclick="add_coupon(<?php echo $this->_var['coupon']['coupon_id']; ?>)">
                    <img class="cardbg" src="<?php echo htmlspecialchars($this->_var['coupon']['coupon_bg']); ?>" height="150"/>
                        <p class="name" ><?php echo $this->_var['coupon']['coupon_name']; ?></p>
                        <p class="price" ><?php if ($this->_var['coupon']['coupon_value']): ?><?php echo price_format($this->_var['coupon']['coupon_value']); ?><?php else: ?>no_limit<?php endif; ?></p>
                        <p class="time" ><?php echo local_date("Y-m-d",$this->_var['coupon']['start_time']); ?> 至 <?php if ($this->_var['coupon']['end_time']): ?><?php echo local_date("Y-m-d",$this->_var['coupon']['end_time']); ?><?php else: ?>no_limit<?php endif; ?></p>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
<?php echo $this->fetch('page.bottom.html'); ?>
        </div>


<?php echo $this->fetch('footer.html'); ?>