<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit"><?php echo $this->_var['lang'][$this->_var['_curmenu']]; ?></div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>



<div class="list1">
    <?php $_from = $this->_var['refunds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'refund');if (count($_from)):
    foreach ($_from AS $this->_var['refund']):
?>
    <div class="box">
        <h2>退款编号：<?php echo $this->_var['refund']['refund_sn']; ?></h2>
        <div class="detail">
            <p><?php echo $this->_var['refund']['order_sn']; ?><br /><a href="<?php echo url('app=goods&id=' . $this->_var['refund']['goods_id']. ''); ?>" target="_blank"><?php echo $this->_var['refund']['goods_name']; ?></a></p>
            <p>卖家：<a href="<?php echo url('app=store&id=' . $this->_var['refund']['seller_id']. ''); ?>" target="_blank"><?php echo $this->_var['refund']['store_name']; ?></a></p>
            <p>交易金额：<?php echo $this->_var['refund']['total_fee']; ?></p>
            <p>退款总额：<?php echo $this->_var['refund']['refund_fee']; ?></p>
            <p>申请时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['refund']['created']); ?></p>
            <p>
                退款状态：
                <?php if ($this->_var['refund']['status'] == 'CLOSED'): ?>
                退款关闭
                <?php elseif ($this->_var['refund']['status'] == 'SUCCESS'): ?>
                退款成功
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_AGREE'): ?>
                买家申请退款，等待卖家同意
                <?php elseif ($this->_var['refund']['status'] == 'SELLER_REFUSE_BUYER'): ?>
                卖家拒绝退款，等待买家修改中
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_ADMIN_AGREE'): ?>
                卖家同意退款，等待管理员审核
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_CONFIRM'): ?>
                退款申请等待卖家确认中
                <?php endif; ?>	
                <?php if ($this->_var['refund']['status'] != 'CLOSED' && $this->_var['refund']['status'] != 'SUCCESS' && $this->_var['refund']['status'] != 'WAIT_ADMIN_AGREE' && $this->_var['refund']['ask_customer'] == 1): ?>（客服已介入处理）<?php endif; ?>
        </p>
        </div>
        <div class="opr">
            <a href="<?php echo url('app=refund&act=view&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" class="white_btn" >查看</a> 
            <?php if ($this->_var['refund']['status'] != 'SUCCESS' && $this->_var['refund']['status'] != 'CLOSED' && $this->_var['refund']['status'] != 'WAIT_ADMIN_AGREE'): ?>
            | <a href="<?php echo url('app=refund&act=edit&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>" class="white_btn" >修改</a>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; else: ?>
    <div class="null">
        <p>没有符合条件的记录~</p>
    </div>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>



<?php echo $this->fetch('member.page.bottom.html'); ?>
<?php echo $this->fetch('footer.html'); ?>