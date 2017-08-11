<?php echo $this->fetch('header.html'); ?>

<?php echo $this->fetch('top.html'); ?>

<style>
    .coupon{}
    .coupon li{margin: 0 auto;position: relative;height: 159px;text-align: left;width: 267px;float:left;margin:20px 60px;}
    .coupon li .cardbg {height: 159px;width: 267px;position: absolute;border-radius: 8px;-webkit-border-radius: 8px;-moz-border-radius: 8px;box-shadow: 0 0 4px rgba(0, 0, 0, 0.6);-moz-box-shadow: 0 0 4px rgba(0, 0, 0, 0.6);-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, 0.6);top: 0;left: 0;z-index: 1;}
    .coupon li p{background-color:#fff; opacity:0.8;filter:alpha(opacity=80);}
    .coupon li .name{position: absolute;right: 10px;top: 7px;text-align: center;z-index:22;margin:10px 0;font-size: 16px;font-weight: bold;}
    .coupon li .price{position: absolute;right: 10px;top: 50px;text-align: center;z-index:22;margin:10px 0;font-size:30px;font-weight: bold;color: red;}
    .coupon li .time{position: absolute;right: 10px;top:100px;text-align: center;z-index:22;margin:10px 0;font-size: 16px;font-weight: bold;}
</style>


<script>
    function add_coupon(coupon_id){
        
        <?php if (! $this->_var['visitor']['user_id']): ?>
        alert('请先登录');
        return;
        <?php endif; ?>
        
        var url = SITE_URL + '/index.php?app=my_coupon&act=add';
            $.getJSON(url, {'coupon_id': coupon_id}, function (data) {
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
    <div id="left">
        <?php echo $this->fetch('left.html'); ?>
    </div>
    
    <div id="right">
        
        <ul class="coupon">
            <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');$this->_foreach['fe_coupon'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_coupon']['total'] > 0):
    foreach ($_from AS $this->_var['coupon']):
        $this->_foreach['fe_coupon']['iteration']++;
?>
            <li onclick="add_coupon(<?php echo $this->_var['coupon']['coupon_id']; ?>)">
                <img class="cardbg" src="<?php echo htmlspecialchars($this->_var['coupon']['coupon_bg']); ?>">
                <p class="name" ><?php echo $this->_var['coupon']['coupon_name']; ?></p>
                <p class="price" ><?php if ($this->_var['coupon']['coupon_value']): ?><?php echo price_format($this->_var['coupon']['coupon_value']); ?><?php else: ?>no_limit<?php endif; ?></p>
                <p class="time" ><?php echo local_date("Y-m-d",$this->_var['coupon']['start_time']); ?> 至 <?php if ($this->_var['coupon']['end_time']): ?><?php echo local_date("Y-m-d",$this->_var['coupon']['end_time']); ?><?php else: ?>no_limit<?php endif; ?></p>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        
    </div>
    
    <div class="clear"></div>
</div>

<?php echo $this->fetch('footer.html'); ?>