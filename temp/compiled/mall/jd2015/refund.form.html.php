<?php echo $this->fetch('member.header.html'); ?>
<style type="text/css">
.float_right {float: right;}
.refund_form table td{height:30px;}
.refund_form input{vertical-align:middle}
.refund_submit{ display:inline-block; background:url('<?php echo $this->res_base . "/" . 'images/refund_btn.jpg'; ?>') no-repeat -102px 0; width:83px; height:30px; line-height:30px; text-align:center;color:#fff; text-decoration:none;font-weight:bold;border:0; cursor:pointer}
</style>
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

<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public refund_form">
            	<form id="refund_form" method="post" enctype="multipart/form-data">
                	<table>
                    	<tr>
                        	<td>退款金额：</td>
                            <td>
                            	<input type="text" name="refund_goods_fee" class="text width_short" value="<?php echo $this->_var['refund']['refund_goods_fee']; ?>" style="background:none" /> 元
                                <span class="gray">（最多<?php echo price_format($this->_var['refund']['goods_fee']); ?>元，退款金额=实际购买单价*件数）</span>
                            </td>
                        </tr>
                        <tr>
                        	<td>收货情况：</td>
                            <td>
                            	<input type="radio" name="shipped" value="2" id="shipped-2" <?php if ($this->_var['refund']['shipped'] == 2): ?> checked="checked"<?php endif; ?> /><label for="shipped-2">已收到货，需退货退款</label>
                                <input type="radio" name="shipped" value="1" id="shipped-1" class="ml10" <?php if ($this->_var['refund']['shipped'] == 1): ?> checked="checked"<?php endif; ?>/><label for="shipped-1">已收到货，不退货只退款</label>
                                <input type="radio" name="shipped" value="0" id="shipped-0" class="ml10" <?php if ($_GET['act'] == 'edit' && ! $this->_var['refund']['shipped']): ?> checked="checked"<?php endif; ?>/><label for="shipped-0">未收到货，需要退款</label>
                            </td>
                        </tr>
                        <tr>
                        	<td>退&nbsp;&nbsp;运&nbsp;&nbsp;费：</td>
                            <td>
                            	<input type="text" name="refund_shipping_fee" class="text width_short" value="<?php echo $this->_var['refund']['refund_shipping_fee']; ?>" /> 元
                                <span class="gray">（最多<?php echo $this->_var['refund']['shipping_fee']; ?>元，分摊运费=退款商品/商品总额*总运费。如果不是质量问题，卖家可以拒绝）</span>
                            </td>
                        </tr>
                        <tr>
                        	<td>退款原因：</td>
                            <td>
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
                            </td>
                        </tr>
                        <tr>
                        	<td>退款说明：</td><td><textarea name="refund_desc" class="text" cols="80" rows="5" style=" background:none;"><?php echo $this->_var['refund']['refund_desc']; ?></textarea></td>
                        </tr>
                         <tr>
                        	<td></td><td><input type="submit" value="<?php if ($_GET['act'] == 'edit'): ?>修改<?php else: ?>提交<?php endif; ?>申请" class="refund_submit" /></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
