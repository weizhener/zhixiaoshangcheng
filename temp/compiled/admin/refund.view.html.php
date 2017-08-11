<?php echo $this->fetch('header.html'); ?>
<script>
$(function(){
	$("#refund_form").submit(function(){
		var re = /^[0-9]+.?[0-9]*$/;   //判断字符串是否为数字  
     	if (($('input[name="refund_goods_fee"]').val() !='' && !re.test($('input[name="refund_goods_fee"]').val())) || ($('input[name="refund_shipping_fee"]').val() !='' && !re.test($('input[name="refund_shipping_fee"]').val())))
    	{
        	alert("请输入数字(例:0.02)");
        	return false;
     	}
		if($('input[name="refund_goods_fee"]').val()<0 || $('input[name="refund_goods_fee"]').val()==''){
			alert('退款金额不能为空且必须大于0');
			return false;
		} else if($('input[name="refund_goods_fee"]').val() > <?php echo $this->_var['refund']['goods_fee']; ?>){
			alert('退款金额不能大于商品总额:<?php echo $this->_var['refund']['goods_fee']; ?>');
			return false;
		}
		if($('input[name="refund_shipping_fee"]').val()<0){
			alert('退运费金额不能小于0');
			return false;
		} else if($('input[name="refund_shipping_fee"]').val() > <?php echo $this->_var['refund']['shipping_fee']; ?>){
			alert('退运费金额不能大于该商品分摊的运费金额:<?php echo $this->_var['refund']['shipping_fee']; ?>');
			return false;
		}
	});	
});
</script>
<style type="text/css">
.refund_form{margin:0 auto;width:100%;}
.clearfix:after{content:'20'; display:block; height:0; overflow:hidden; clear:both}
.float_right {float: right;}
.datafuncs{float:left;width:768px;}
.refund_info{border:1px #ddd solid;padding:10px; line-height:20px;border-bottom:0;margin-top:20px;width:746px;}
.refund_btn{border:1px #ddd solid;border-top:0;border-bottom:0;padding:10px;width:746px;}
ul{line-height:none}
.refund_form input{vertical-align:middle}
.refund_message{background:#FFF7EB;padding:20px;border:1px #ddd solid;width:726px; clear:both}
.refund_message form{height:220px; line-height:20px;}
.message_form{margin-bottom:10px; height:100px;}
.message_form textarea{vertical-align:middle;width:660px; height:40px;margin-top:10px;}
.message_form .refund-submit{margin-top:8px;margin-left:644px;}
.messge_list{border:1px #ddd solid;}
.message_list .title{border:1px #ddd solid; line-height:30px; height:30px; background:#fff;}
.message_list .title h3{float:left;width:300px;font-size:12px;padding-left:5px;}
.message_list .title span{float:right;padding-right:5px;}
.message_list .content{background:#fff;padding:10px;border:1px #ddd solid;border-top:0;width:704px;border-bottom:0;}
.refund_btn a,.refund_message_btn{ display:inline-block; background:url('<?php echo $this->res_base . "/" . 'style/images/refund_btn.jpg'; ?>') no-repeat; width:83px; height:30px; line-height:30px; text-align:center;color:#fff; text-decoration:none;font-weight:bold;border:0; cursor:pointer}
.refund_btn a.blue{background-position:-102px 0}
.curr_refund_goods{position:absolute;top:18px;left:130px;}
.order_info{float:left;border:1px #ddd solid;margin-top:20px;margin-left:10px;width:305px;}
.order_info h3{height:25px; line-height:25px; background:#E0E0E0;border-bottom:1px #ddd solid;padding-left:5px;width:300px;}
.order_info ul{padding:10px; line-height:20px;}
.order_info a{text-decoration:none;color:#06C}
.refund-order-goods{padding:5px;width:290px;}
.refund-order-goods .each{width:290px;margin-bottom:5px;}
.refund-order-goods .each .pic{border:1px #ddd solid;width:60px;height:60px;float:left;}
.refund-order-goods .each .goodsinfo{float:left;margin-left:5px; line-height:18px; position:relative; width:222px;}
</style>
<div id="rightTop">
    <p>退款管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        
    </div>
</div>
<div class="tdare clearfix">
    
    <div id="dataFuncs" class="datafuncs">
    	<div class="public refund_form clearfix">
            <ul class="refund_info">
                	<li>退款编号：<?php echo $this->_var['refund']['refund_sn']; ?></li>
                    <li>申请时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['refund']['created']); ?></li>
                    <li>退款状态：<?php if ($this->_var['refund']['status'] == 'CLOSED'): ?>退款关闭
                        <?php elseif ($this->_var['refund']['status'] == 'SUCCESS'): ?>退款成功
                        <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_AGREE'): ?>买家已经申请退款，等待卖家同意
                        <?php elseif ($this->_var['refund']['status'] == 'SELLER_REFUSE_BUYER'): ?>卖家拒绝退款，等待买家修改中
                        <?php elseif ($this->_var['refund']['status'] == 'WAIT_ADMIN_AGREE'): ?>
                        卖家已经同意退款，等待管理员审核
                        <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_CONFIRM'): ?>退款申请等待卖家确认中
                        <?php endif; ?>	
                    </li>
                    <li>商品总额：<?php echo price_format($this->_var['refund']['total_fee']); ?> <span class="gray">(含分摊的运费)</span></li>
                    <li>退款金额：<?php echo price_format($this->_var['refund']['refund_goods_fee']); ?> <span class="gray">(商品金额：<?php echo price_format($this->_var['refund']['goods_fee']); ?>)</span></li>
                    <li>退&nbsp;&nbsp;运&nbsp;&nbsp;费：<?php echo price_format($this->_var['refund']['refund_shipping_fee']); ?> <span class="gray">(分摊的运费：<?php echo price_format($this->_var['refund']['shipping_fee']); ?>)</span></li>
                    <li>收货情况：<?php echo $this->_var['refund']['shipped_text']; ?></li>
                    <li>退款原因：<?php echo $this->_var['refund']['refund_reason']; ?></li>
                    <li>退款说明：<?php echo $this->_var['refund']['refund_desc']; ?></li>
            </ul>
            <div class="refund_message clearfix">
                	<?php if ($this->_var['refund']['status'] != 'SUCCESS' && $this->_var['refund']['status'] != 'CLOSED'): ?>
                	<form method="post" id="refund_form">
                    <input type="hidden" name="refund_id" value="<?php echo $this->_var['refund']['refund_id']; ?>" />
                	<ul class="message_form clearfix">
                    	<li>退款金额：<input type="text" name="refund_goods_fee" value="<?php echo $this->_var['refund']['refund_goods_fee']; ?>" class="text" /><span class="gray">最多<?php echo $this->_var['refund']['goods_fee']; ?>元，客服与买卖双方协商后的商品退款金额。</span></li>
                        <li>退&nbsp;&nbsp;运&nbsp;&nbsp;费：<input type="text" name="refund_shipping_fee" value="<?php echo $this->_var['refund']['refund_shipping_fee']; ?>" /><span class="gray">最多<?php echo $this->_var['refund']['shipping_fee']; ?>元，如果不是商品质量问题，买家承担寄送运费，则建议为&yen;0元。（注：如果一个订单中有多个商品，买家只退其中一个或几个商品，那么需要计算分摊运费，所以，至于退多少，管理员与买卖双方协商。）</span></li>
                    	<li>客服留言：<textarea name="content" class="text"></textarea></li>
                        <li class="refund-submit"><input onclick="return confirm('提交后相关货款将立即退还给买家和卖家，是否继续？')" type="submit" name=""  value="提交" class="refund_message_btn"/></li>
                    </ul>
                    </form>
                    <?php endif; ?>
                	<div class="message_list">
                    	<?php $_from = $this->_var['refund']['message']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'message');$this->_foreach['fe_message'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_message']['total'] > 0):
    foreach ($_from AS $this->_var['message']):
        $this->_foreach['fe_message']['iteration']++;
?>
                    	<div class="title clearfix">
                        	<h3>
                            <?php if ($this->_var['message']['owner_id'] == $this->_var['visitor']['user_id']): ?>
                            自己
                            <?php elseif ($this->_var['message']['owner_role'] == 'buyer'): ?>
                            买家
                            <?php elseif ($this->_var['message']['owner_role'] == 'seller'): ?>
                            卖家
                            <?php elseif ($this->_var['message']['owner_role'] == 'admin'): ?>
                            商家客服
                            <?php endif; ?>
                            </h3>
                            <span><?php echo local_date("Y-m-d H:i:s",$this->_var['message']['created']); ?></span>
                        </div>
                        <div class="content" <?php if (($this->_foreach['fe_message']['iteration'] == $this->_foreach['fe_message']['total'])): ?> style="border-bottom:1px #ddd solid"<?php endif; ?>>
                        	<?php echo $this->_var['message']['content']; ?>
                            <?php if ($this->_var['message']['pic_url']): ?>
                            <p style="margin-top:10px;"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['message']['pic_url']; ?>" width="200" /></p>
                            <?php endif; ?>
                        </div>      
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>              
                    </div>
                    <div class="pageLinks clearfix">
            		<?php if ($this->_var['refund']['message']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
        			</div>
                </div>
        </div>
    </div>
    <div class="order_info">
    	<h3>订单信息</h3>
    	<ul>
        	<li>订单编号：<?php echo $this->_var['order']['order_sn']; ?></li>
            <li>支付方式：<?php echo $this->_var['order']['payment_name']; ?></li>
            <li>订单总额：<?php echo price_format($this->_var['order']['order_amount']); ?></li>
            <li>商品总额：<?php echo price_format($this->_var['order']['goods_amount']); ?></li>
            <li>商品优惠：<?php echo price_format($this->_var['order']['discount']); ?></li>
            <li>下单时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['order']['add_time']); ?></li>
            <li>物流方式：<?php echo $this->_var['order']['shipping']['shipping_name']; ?></li>
            <li>物流费用：<?php echo price_format($this->_var['order']['shipping']['shipping_fee']); ?></li>
            <li>运送地点：<?php echo $this->_var['order']['shipping']['region_name']; ?><?php echo $this->_var['order']['shipping']['address']; ?></li>
            
            <li>卖家信息：<a href="<?php echo $this->_var['site_url']; ?>/index.php?app=store&id=<?php echo $this->_var['order']['seller_id']; ?>" target="_blank"><?php echo $this->_var['order']['seller_name']; ?></a></li>
            <li>买家昵称：<?php echo $this->_var['order']['buyer_name']; ?></li>
            <li>收货人姓名：<?php echo $this->_var['order']['shipping']['consignee']; ?></li>
            <li>收货人电话：<?php echo $this->_var['order']['shipping']['phone_tel']; ?></li>
            <li>收货人手机：<?php echo $this->_var['order']['shipping']['phone_mob']; ?></li>
        </ul>
        <h3>订单商品</h3>
        <div class="refund-order-goods">
       		<?php $_from = $this->_var['order']['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
            <div class="each clearfix">
            	<div class="pic"><a href=""><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods']['goods_image']; ?>" width="60" height="60" /></a></div>
            	<div class="goodsinfo">
            		<a href="<?php echo $this->_var['site_url']; ?>/index.php?app=goods&id=<?php echo $this->_var['goods']['goods_id']; ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['goods']['goods_name']),60); ?></a>
                	<br />
                	规格：<?php if ($this->_var['goods']['specification']): ?><?php echo $this->_var['goods']['specification']; ?><?php else: ?>默认规格<?php endif; ?>
                	<br />
                	价格：<?php echo price_format($this->_var['goods']['price']); ?> X <?php echo $this->_var['goods']['quantity']; ?> 件
                    <?php if ($this->_var['refund']['goods_id'] == $this->_var['goods']['goods_id'] && $this->_var['refund']['spec_id'] == $this->_var['goods']['spec_id']): ?>
                    <span class="gray curr_refund_goods">当前退款商品</span>
                    <?php endif; ?>
            	</div>
            </div>
       		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
       </div>
    </div>
    
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
