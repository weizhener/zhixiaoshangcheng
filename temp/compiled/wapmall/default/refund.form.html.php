<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit"><?php echo $this->_var['lang'][$this->_var['_curmenu']]; ?></div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>


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
		if($('input[name="shipped"]:checked').val() =='' || $('input[name="shipped"]:checked').val() == undefined){
			alert('请选择收货情况');
			return false;
		}
		if($('input[name="refund_shipping_fee"]').val()<0){
			alert('退运费金额不能小于0');
			return false;
		} else if($('input[name="refund_shipping_fee"]').val() > <?php echo $this->_var['refund']['shipping_fee']; ?>){
			alert('退运费金额不能大于该商品分摊的运费金额:<?php echo $this->_var['refund']['shipping_fee']; ?>');
			return false;
		}
		
		if($('select[name="refund_reason"]').val()==''){
			alert('请选择退款原因');
			return false;
		}
	});	
});
</script>



<style>
    .refund_form{margin:10px;padding:10px;background:#fff;}
    .refund_form li {border-radius: 6px;}
    .refund_form li h3{display: block;font-size: 14px;color: #333;height:30px;line-height:30px;}
    .refund_form li p{width: 100%;margin-bottom:10px;}
    .refund_form li .text{border: 1px solid #DDDDDD;border-radius: 5px;text-indent: 10px;}
    .refund_form .red_btn{font-size: 16px;cursor: pointer;margin-bottom:10px;}
</style>
<div class="refund_form">
    <form id="refund_form" method="post" enctype="multipart/form-data">
        <ul>
            <li>
                <h3>退款金额:</h3>
                <p><input type="text" class="text" name="refund_goods_fee" id="refund_goods_fee" value="<?php echo $this->_var['refund']['refund_goods_fee']; ?>"/></p>
                <span class="gray">（最多<?php echo price_format($this->_var['refund']['goods_fee']); ?>元，退款金额=实际购买单价*件数）</span>
            </li>
            <li>
                <h3>收货/服务情况</h3>
                <p>
                    <input type="radio" name="shipped" value="2" id="shipped-2" <?php if ($this->_var['refund']['shipped'] == 2): ?> checked="checked"<?php endif; ?> /><label for="shipped-2">已收到货，需退货退款</label>
                    <input type="radio" name="shipped" value="1" id="shipped-1" class="ml10" <?php if ($this->_var['refund']['shipped'] == 1): ?> checked="checked"<?php endif; ?>/><label for="shipped-1">已收到货，不退货只退款</label>
                    <input type="radio" name="shipped" value="0" id="shipped-0" class="ml10" <?php if ($_GET['act'] == 'edit' && ! $this->_var['refund']['shipped']): ?> checked="checked"<?php endif; ?>/><label for="shipped-0">未收到货，需要退款</label>
                </p>
            </li>
            <li>
                <h3>退上门路费:</h3>
                <p><input type="text" class="text" name="refund_shipping_fee" id="refund_shipping_fee" value="<?php echo $this->_var['refund']['refund_shipping_fee']; ?>"/></p>
                <span class="gray">（最多<?php echo $this->_var['refund']['shipping_fee']; ?>元，分摊路费=退款商品/服务*商品/服务*总路费，如果不是质量问题，或服务出问题，卖家可以拒绝。）</span>
            </li>
            <li>
                <h3>退款原因:</h3>
                <p>
                    <select class="text" name="refund_reason" style="background:none">
                        <option value="" selected="selected">请选择退款原因</option>
                        <option value="缺货" <?php if ($this->_var['refund']['refund_reason'] == '缺货'): ?> selected="selected"<?php endif; ?>>缺货</option>
                        <option value="未按约定时间发货" <?php if ($this->_var['refund']['refund_reason'] == '未按约定时间发货'): ?> selected="selected"<?php endif; ?>>未按约定时间发货</option>
                        <option value="收到假货" <?php if ($this->_var['refund']['refund_reason'] == '收到假货'): ?> selected="selected"<?php endif; ?>>收到假货</option>
                        <option value="商品有质量问题" <?php if ($this->_var['refund']['refund_reason'] == '商品有质量问题'): ?> selected="selected"<?php endif; ?>>商品有质量问题</option>
                        <option value="商品错发/漏发" <?php if ($this->_var['refund']['refund_reason'] == '商品错发/漏发'): ?> selected="selected"<?php endif; ?>>商品错发/漏发</option>
                        <option value="收到的商品破损" <?php if ($this->_var['refund']['refund_reason'] == '收到的商品破损'): ?> selected="selected"<?php endif; ?>>收到的商品破损</option>
                        <option value="收到的商品描述不符" <?php if ($this->_var['refund']['refund_reason'] == '收到的商品描述不符'): ?> selected="selected"<?php endif; ?>>收到的商品描述不符</option>
                        <option value="其他" <?php if ($this->_var['refund']['refund_reason'] == '其他'): ?> selected="selected"<?php endif; ?>>其他</option>
                    </select>
                </p>
            </li>
            <li>
                <h3>退款说明</h3>
                <p>
                    <textarea name="refund_desc" class="textarea" rows="5" style=" background:none;"><?php echo $this->_var['refund']['refund_desc']; ?></textarea>
                </p>
            </li>
        </ul>
        <input class="red_btn" type="submit" value="<?php if ($_GET['act'] == 'edit'): ?>修改<?php else: ?>提交<?php endif; ?>申请" />
    </form>
</div>





<?php echo $this->fetch('footer.html'); ?>