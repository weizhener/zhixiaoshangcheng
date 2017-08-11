<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit"><?php echo $this->_var['lang'][$this->_var['_curmenu']]; ?></div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>

<script>
    $(function() {
        $('#refund_form').submit(function() {
            if ($('textarea[name="content"]').val() == '') {
                alert('留言内容不能为空！');
                return false;
            }
        });
    });
</script>


<style>
    .refund_view{margin:10px 16px 80px 16px;}
    .refund_view li {border-radius: 6px;}
    .refund_view li h3{display: block;font-size: 14px;color: #333;}
    .refund_view li p{width: 100%;margin-bottom:10px;}
    .refund_view li .text{border: 1px solid #DDDDDD;border-radius: 5px;text-indent: 10px;}
    .refund_view .red_btn{font-size: 16px;cursor: pointer;margin-bottom:10px;}
</style>


<div class="refund_view">
    <ul>
        <li>
            <h3>退款编号：<?php echo $this->_var['refund']['refund_sn']; ?></h3>
        </li>
        <li>
            <h3>申请时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['refund']['created']); ?></h3>
        </li>
        <li>
            <h3>
                退款状态：
                <?php if ($this->_var['refund']['status'] == 'CLOSED'): ?>退款关闭
                <?php elseif ($this->_var['refund']['status'] == 'SUCCESS'): ?>退款成功
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_AGREE'): ?>买家申请退款，等待卖家同意
                <?php elseif ($this->_var['refund']['status'] == 'SELLER_REFUSE_BUYER'): ?>卖家拒绝退款，等待买家修改中
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_ADMIN_AGREE'): ?>卖家同意退款，等待管理员审核
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_CONFIRM'): ?>退款申请等待卖家确认中
                <?php endif; ?>	
            </h3>
        </li>
        <li>
            <h3>商品总额：<?php echo price_format($this->_var['refund']['total_fee']); ?></h3>
        </li>
        <li>
            <h3>该商品退款总额：<?php echo price_format($this->_var['refund']['refund_fee']); ?></h3>
            <p>
                退款金额：<?php echo price_format($this->_var['refund']['refund_goods_fee']); ?>(商品金额：<?php echo price_format($this->_var['refund']['goods_fee']); ?>)<br/>
                退&nbsp;&nbsp;路&nbsp;&nbsp;费：<?php echo price_format($this->_var['refund']['refund_shipping_fee']); ?> (分摊的路费：<?php echo price_format($this->_var['refund']['shipping_fee']); ?>)
            </p>
        </li>
        <li>
            <h3>
                收货情况：<?php echo $this->_var['refund']['shipped_text']; ?>
            </h3>
        </li>
        <li>
            <h3>
                退款原因：<?php echo $this->_var['refund']['refund_reason']; ?>
            </h3>
        </li>
        <li>
            <h3>
                退款说明：<?php echo $this->_var['refund']['refund_desc']; ?>
            </h3>
        </li>
        <li>
            <?php if ($this->_var['refund']['status'] != 'SUCCESS' && $this->_var['refund']['status'] != 'CLOSED' && $this->_var['refund']['status'] != 'WAIT_ADMIN_AGREE'): ?>
            <?php if ($this->_var['refund']['buyer_id'] == $this->_var['visitor']['user_id']): ?>
            <a href="<?php echo url('app=refund&act=cancel&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" onclick="return confirm('您确定要取消退款么？')" class="red_btn">取消退款</a>
            <a href="<?php echo url('app=refund&act=edit&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" class="red_btn">修改退款</a>
            <?php else: ?>
            <a href="<?php echo url('app=refund&act=agree&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" class="red_btn" onclick="return confirm('点击“同意退款”按钮，相关货款将退还给买家，是否继续？')">同意退款</a>
            <a href="<?php echo url('app=refund&act=refuse&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" class="red_btn">拒绝退款</a>
            <?php endif; ?>
            <?php if ($this->_var['refund']['ask_customer'] != 1): ?>
            <a class="red_btn" onclick="return confirm('您确定需要平台客服介入处理么？');" href="<?php echo url('app=refund&act=ask_customer&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>">要求客服介入处理</a>
            <?php else: ?>
            <span>客服已介入处理</span>
            <?php endif; ?>
            <?php endif; ?>
        </li>
        <li>
            <?php if ($this->_var['refund']['status'] != 'SUCCESS' && $this->_var['refund']['status'] != 'CLOSED'): ?>
            <form method="post" enctype="multipart/form-data" id="refund_form">
                <h2>上传凭证：</h2>
                <p><input type="file" name="refund_cert" /></p>
                <h2>上传凭证：</h2>
                <p><textarea name="content" class="text" style="width:100%;height:60px;"></textarea></p>
                <input type="submit" name=""  value="提交" class="red_btn"/>
            </form>
            <?php endif; ?>
        </li>
    </ul>

    <ul>
        <li>
            <h2 style="font-size:16px;color:blue;">记录：</h2>
        </li>
        <?php $_from = $this->_var['refund']['message']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'message');$this->_foreach['fe_message'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_message']['total'] > 0):
    foreach ($_from AS $this->_var['message']):
        $this->_foreach['fe_message']['iteration']++;
?>
        <li>
            <h2>
                <?php if ($this->_var['message']['owner_id'] == $this->_var['visitor']['user_id']): ?>
                自己
                <?php elseif ($this->_var['message']['owner_role'] == 'buyer'): ?>
                买家
                <?php elseif ($this->_var['message']['owner_role'] == 'seller'): ?>
                卖家
                <?php elseif ($this->_var['message']['owner_role'] == 'admin'): ?>
                商家客服
                <?php endif; ?>
                <span><?php echo local_date("Y-m-d H:i:s",$this->_var['message']['created']); ?></span>
            </h2>
            <p>
                <?php echo $this->_var['message']['content']; ?>
            </p>
            <?php if ($this->_var['message']['pic_url']): ?>
            <p style="margin-top:10px;"><img src="<?php echo $this->_var['message']['pic_url']; ?>" width="200" /></p>
            <?php endif; ?>
            </p>
        </li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>  
    </ul>
    <?php echo $this->fetch('member.page.bottom.html'); ?>
</div>







<?php echo $this->fetch('footer.html'); ?>