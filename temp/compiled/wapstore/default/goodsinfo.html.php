<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'goodsinfo.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
//<!CDATA[
    /* buy */
    function buy()
    {
        if (goodsspec.getSpec() == null)
        {
            alert(lang.select_specs);
            return;
        }
        var spec_id = goodsspec.getSpec().id;

        var quantity = $("#quantity").val();
        if (quantity == '')
        {
            alert(lang.input_quantity);
            return;
        }
        if (parseInt(quantity) < 1)
        {
            alert(lang.invalid_quantity);
            return;
        }

        add_to_cart(spec_id, quantity);
    }

    /* add cart */
    function add_to_cart(spec_id, quantity)
    {
        var url = '<?php echo $this->_var['site_url']; ?>/index.php?app=cart&act=add';

        $.getJSON(url, {'spec_id': spec_id, 'quantity': quantity}, function(data) {
            if (data.done)
            {
                $('.bold_num').text(data.retval.cart.kinds);
                $('.bold_mly').html(price_format(data.retval.cart.amount));
                $(".buynow .msg").slideDown().delay(5000).slideUp();
                // $('.msg').slideDown('slow');
                // setTimeout(slideUp_fn, 5000);
            }
            else
            {
                alert(data.msg);
            }
        });
    }

         /*buy_now*/
        function buy_now()
        {
            //验证数据
            if (goodsspec.getSpec() == null)
            {
                alert(lang.select_specs);
                return;
            }
            var spec_id = goodsspec.getSpec().id;

            var quantity = $("#quantity").val();
            if (quantity == '')
            {
                alert(lang.input_quantity);
                return;
            }
            if (parseInt(quantity) < 1)
            {
                alert(lang.invalid_quantity);
                return;
            }
            buy_now_add_cart(spec_id, quantity);
        }

        /* add buy_now_add_cart */
        function buy_now_add_cart(spec_id, quantity)
        {
            var url = SITE_URL + '/index.php?app=cart&act=add';
            $.getJSON(url, {'spec_id': spec_id, 'quantity': quantity}, function(data) {
                if (data.done)
                {
                    location.href = SITE_URL + '/index.php?app=order&goods=cart&store_id=<?php echo $this->_var['store']['store_id']; ?>';
                } else {
                    alert(data.msg);
                }
            });
        }



var specs = new Array();
<?php $_from = $this->_var['goods']['_specs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec']):
?>
<?php if ($this->_var['spec']['is_pro']): ?>
specs.push(new spec(<?php echo $this->_var['spec']['spec_id']; ?>, '<?php echo htmlspecialchars($this->_var['spec']['spec_1']); ?>', '<?php echo htmlspecialchars($this->_var['spec']['spec_2']); ?>', <?php echo $this->_var['spec']['price']; ?>,<?php echo $this->_var['spec']['pro_price']; ?>, <?php echo $this->_var['spec']['stock']; ?>,true,<?php echo ($this->_var['spec']['discount'] == '') ? '0' : $this->_var['spec']['discount']; ?>));
<?php else: ?>
specs.push(new spec(<?php echo $this->_var['spec']['spec_id']; ?>, '<?php echo htmlspecialchars($this->_var['spec']['spec_1']); ?>', '<?php echo htmlspecialchars($this->_var['spec']['spec_2']); ?>', <?php echo $this->_var['spec']['price']; ?>,0, <?php echo $this->_var['spec']['stock']; ?>,false,<?php echo ($this->_var['spec']['discount'] == '') ? '0' : $this->_var['spec']['discount']; ?>));
<?php endif; ?>
<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
var specQty = <?php echo $this->_var['goods']['spec_qty']; ?>;
var defSpec = <?php echo htmlspecialchars($this->_var['goods']['default_spec']); ?>;
var goodsspec = new goodsspec(specs, specQty, defSpec);
//]]>
</script>
<div class="detail_img">
    <div id="slider" class="slider" >
        <ul id="sliderlist" class="sliderlist" >
            <?php $_from = $this->_var['goods']['_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_image');$this->_foreach['fe_goods_image'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods_image']['total'] > 0):
    foreach ($_from AS $this->_var['goods_image']):
        $this->_foreach['fe_goods_image']['iteration']++;
?>
            <li><img src="<?php echo $this->_var['goods_image']['image_url']; ?>"></li>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
    <script type="text/javascript">
        var t2 = new TouchSlider({id: 'sliderlist', speed: 600, timeout: 3000, before: function(index) {
            }});
    </script>
    <div class="fav">
        <a href="javascript:collect_goods(<?php echo $this->_var['goods']['goods_id']; ?>);">
            <img src="<?php echo $this->res_base . "/" . 'images/favorite.png'; ?>"/><span>收藏</span>
        </a>
    </div>
    <p class="line"></p>
</div>

<div class="detail_tit">
    <p><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p>
    <p>市场价: <strong style="text-decoration:line-through;"><?php echo price_format($this->_var['goods']['market_price']); ?></strong></p>
    <p>价格：<strong ectype="goods_price"><?php echo price_format($this->_var['goods']['_specs']['0']['price']); ?></strong></p>
    <?php if ($this->_var['goods']['_specs']['0']['is_pro']): ?>
    <span class="letter1">促销: </span>
    <em class="promo-price-type" title="<?php echo $this->_var['goods']['pro_desc']; ?>"><?php echo $this->_var['goods']['pro_name']; ?></em>
    <span class="promo-price" ectype="goods_pro_price"><?php echo price_format($this->_var['goods']['_specs']['0']['pro_price']); ?></span>
    <div class="countdown J_Countdown_GoodsPromotion">
        <span class="lefttime">还剩</span>
        <span class="flip-top J_NumDays"><?php echo $this->_var['goods']['lefttime']['d']; ?></span><em>天</em>
        <span class="flip-top J_NumHours"><?php echo $this->_var['goods']['lefttime']['h']; ?></span><em>小时</em>
        <span class="flip-top J_NumMins"><?php echo $this->_var['goods']['lefttime']['m']; ?></span><em>分</em>
        <span class="flip-top J_NumSeconds"><?php echo $this->_var['goods']['lefttime']['s']; ?></span><em>秒</em>
    </div>
    <?php endif; ?>

    <?php if ($this->_var['goods']['if_open']): ?>
    <span class="letter1">会员价: </span>
    <?php if ($this->_var['visitor']['user_id']): ?>
    <em class="promo-price-type" title="<?php echo $this->_var['goods']['grade_name']; ?>"><?php echo $this->_var['goods']['grade_name']; ?></em><span class="promo-price" ectype="member_price"><?php echo price_format($this->_var['goods']['_specs']['0']['member_price']); ?></span><br />
    <?php else: ?>
    <em class="promo-price-type" >登录后查看是否享受该优惠</em>
    <?php endif; ?>
    <?php endif; ?>
    <div style="width: 100%;color:#e4393c;">
        <?php if ($this->_var['store']['amount_for_free_fee']): ?>满<?php echo price_format($this->_var['store']['amount_for_free_fee']); ?>元包邮<?php endif; ?><?php if ($this->_var['store']['acount_for_free_fee']): ?>,满<?php echo htmlspecialchars($this->_var['store']['acount_for_free_fee']); ?>件包邮<?php endif; ?>
    </div>
    <?php if ($this->_var['goods']['integral_max_exchange']): ?><p>可使用积分:<strong style="color:red;font-weight: bold;padding-left:10px;"><?php echo htmlspecialchars($this->_var['goods']['integral_max_exchange']); ?></strong></p><?php endif; ?>
    <p>销量：<?php echo $this->_var['sales_info']; ?><?php echo $this->_var['comments']; ?></p>
    <p><span>所在地区：<?php echo htmlspecialchars($this->_var['store']['region_name']); ?></span><!--<span>快递：10.00</span>--></p>
    <?php if ($this->_var['shipping']): ?>
    <p>物流运费：
        <?php $_from = $this->_var['shipping']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'shippings');if (count($_from)):
    foreach ($_from AS $this->_var['shippings']):
?>
        <span><?php echo $this->_var['shippings']['shipping_name']; ?>：¥<?php echo $this->_var['shippings']['first_price']; ?></span>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </p>
    <?php endif; ?>
</div>
<style>
.list_entry{border-bottom: 1px solid #dedede;padding:20px 10px;position: relative;margin: 12px 0;background: #fff;}
</style>
<dl class="list_entry">
    <dt>
        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></a>
    </dt>				
    <dd>
        <?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" /><?php endif; ?>
    </dd>
</dl>
<div class="detail_size">
    <div class="size_con">
        <div class="handle">
            <?php if ($this->_var['goods']['spec_qty'] > 0): ?>
            <ul>
                <li class="handle_title"><?php echo htmlspecialchars($this->_var['goods']['spec_name_1']); ?>: </li><br />
            </ul>
            <?php endif; ?>
            <?php if ($this->_var['goods']['spec_qty'] > 1): ?>
            <ul>
                <li class="handle_title"><?php echo htmlspecialchars($this->_var['goods']['spec_name_2']); ?>: </li>
            </ul>
            <?php endif; ?>
            <ul class="quantity">
                <li class="handle_title">购买数量: </li>
                <li>
                    <input type="text" class="text width1" name="" id="quantity" value="1" />
                    件 （库存<span class="stock" ectype="goods_stock"><?php echo $this->_var['goods']['_specs']['0']['stock']; ?></span>件）
                </li>
            </ul>
            <?php if ($this->_var['goods']['spec_qty'] > 0): ?>
            <ul class="selected">
                <li class="handle_title">您已选择: </li>
                <li class="aggregate" ectype="current_spec"></li>
            </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="buynow">
        <a href="javascript:buy_now();" class="buy">立即购买</a><a href="javascript:buy();" class="add">加入购物车</a>
        <div class="msg" style="display:none;">
            <p><b></b>购物车内共有<span class="bold_num"></span>种商品 共计 <span class="bold_mly" style="color:#8D0303;"></span>！</p>
            <a href="<?php echo url('app=cart'); ?>" class="white_btn">查看购物车</a>
            <a  onclick="$('.msg').css({'display': 'none'});" class="white_btn">继续购物</a>
        </div>
    </div>

</div>