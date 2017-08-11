<?php echo $this->fetch('member.header.html'); ?>
<style type="text/css">
.clearfix:after{content:'20'; display:block; height:0; overflow:hidden; clear:both}
.float_right {float: right;}
.refund_info{border:1px #ddd solid;padding:10px; line-height:24px;border-bottom:0;}
.refund_btn{border:1px #ddd solid;border-top:0;border-bottom:0;padding:10px;}
ul{line-height:none}
.refund_form input{vertical-align:middle}
.refund_message{background:#FFF7EB;padding:20px;border:1px #ddd solid;width:726px;}
.message_form{margin-bottom:10px; height:100px;}
.messge_list{border:1px #ddd solid;}
.message_list .title{border:1px #ddd solid; line-height:30px; height:30px; background:#fff;}
.message_list .title h3{float:left;width:300px;font-size:12px;padding-left:5px;}
.message_list .title span{float:right;padding-right:5px;}
.message_list .content{background:#fff;padding:10px;border:1px #ddd solid;border-top:0;width:704px;border-bottom:0;}
.refund_btn a,.refund_message_btn{ display:inline-block; background:url('<?php echo $this->res_base . "/" . 'images/refund_btn.jpg'; ?>') no-repeat; width:83px; height:30px; line-height:30px; text-align:center;color:#fff; text-decoration:none;font-weight:bold;border:0; cursor:pointer}
.refund_btn a.blue{background-position:-102px 0}
.refund_btn .ask_customer_link{background:none;color:#285BCC;width:120px;}
.refund_btn span{color:#285BCC;width:120px;}
.refund_message textarea{vertical-align:middle;width:716px; height:40px; background:#fff}
.refund_fee_detail{border:1px #ddd solid;width:400px;}
.refund_fee_detail h3{font-size:12px; background:#f1f1f1;padding-left:5px;color:#444;}
.refund_fee_detail li{padding-left:5px;}
.refund_fee_detail li.first{border-bottom:1px #ddd solid;}
</style>
<script>
$(function(){
	$('#refund_form').submit(function(){
		if($('textarea[name="content"]').val()==''){
			alert('留言内容不能为空！');
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
            	<ul class="refund_info">
                	<li>退款编号：<?php echo $this->_var['refund']['refund_sn']; ?></li>
                    <li>申请时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['refund']['created']); ?></li>
                    <li>退款状态：<?php if ($this->_var['refund']['status'] == 'CLOSED'): ?>退款关闭
                        <?php elseif ($this->_var['refund']['status'] == 'SUCCESS'): ?>退款成功
                        <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_AGREE'): ?>买家申请退款，等待卖家同意
                        <?php elseif ($this->_var['refund']['status'] == 'SELLER_REFUSE_BUYER'): ?>卖家拒绝退款，等待买家修改中
                        <?php elseif ($this->_var['refund']['status'] == 'WAIT_ADMIN_AGREE'): ?>卖家同意退款，等待管理员审核
                        <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_CONFIRM'): ?>退款申请等待卖家确认中
                        <?php endif; ?>	
                    </li>
                    <li>商品总额：<?php echo price_format($this->_var['refund']['total_fee']); ?> <span class="gray">(含分摊的运费)</span></li>
                    <div class="refund_fee_detail">
                    	<h3>该商品退款总额 <?php echo price_format($this->_var['refund']['refund_fee']); ?></h3>
                    	<p>
                        	<li class="first">退款金额：<?php echo price_format($this->_var['refund']['refund_goods_fee']); ?> <span class="gray">(商品金额：<?php echo price_format($this->_var['refund']['goods_fee']); ?>)</span></li>
                    		<li>退&nbsp;&nbsp;运&nbsp;&nbsp;费：<?php echo price_format($this->_var['refund']['refund_shipping_fee']); ?> <span class="gray">(分摊的运费：<?php echo price_format($this->_var['refund']['shipping_fee']); ?>)</span></li>
                        </p>
                   	</div>
                    <li>收货情况：<?php echo $this->_var['refund']['shipped_text']; ?></li>
                    <li>退款原因：<?php echo $this->_var['refund']['refund_reason']; ?></li>
                    <li>退款说明：<?php echo $this->_var['refund']['refund_desc']; ?></li>
                </ul>
                <div class="refund_btn">
                 	<?php if ($this->_var['refund']['status'] != 'SUCCESS' && $this->_var['refund']['status'] != 'CLOSED' && $this->_var['refund']['status'] != 'WAIT_ADMIN_AGREE'): ?>
                	<?php if ($this->_var['refund']['buyer_id'] == $this->_var['visitor']['user_id']): ?>
                    <a href="<?php echo url('app=refund&act=cancel&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" onclick="return confirm('您确定要取消退款么？')">取消退款</a>
                    <a href="<?php echo url('app=refund&act=edit&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" class="blue">修改退款</a>
                    <?php else: ?>
                	<a href="<?php echo url('app=refund&act=agree&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" class="blue" onclick="return confirm('点击“同意退款”按钮，相关货款将退还给买家，是否继续？')">同意退款</a>
                    <a href="<?php echo url('app=refund&act=refuse&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>">拒绝退款</a>
                    <?php endif; ?>
                    <?php if ($this->_var['refund']['ask_customer'] != 1): ?>
                    <a class="ask_customer_link" onclick="return confirm('您确定需要平台客服介入处理么？');" href="<?php echo url('app=refund&act=ask_customer&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>">要求客服介入处理</a>
                    <?php else: ?>
                    <span>客服已介入处理</span>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
                <div class="refund_message">
                	<?php if ($this->_var['refund']['status'] != 'SUCCESS' && $this->_var['refund']['status'] != 'CLOSED'): ?>
                	<form method="post" enctype="multipart/form-data" id="refund_form">
                	<ul class="message_form clearfix">
                    	<li><textarea name="content" class="text"></textarea></li>
                        <li class="float-left mt10">上传凭证：<input type="file" name="refund_cert" /></li>
                        <li class="float-right mt10"><input type="submit" name=""  value="提交" class="refund_message_btn"/></li>
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
                            <p style="margin-top:10px;"><img src="<?php echo $this->_var['message']['pic_url']; ?>" width="200" /></p>
                            <?php endif; ?>
                        </div>      
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>              
                    </div>
                    <div class="page-bottom clearfix">
                        <?php echo $this->fetch('member.page.bottom.html'); ?>
                    </div>
                </div>
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
