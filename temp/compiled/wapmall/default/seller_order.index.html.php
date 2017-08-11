<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">订单管理</div>
    <a href="javascript" class="r_b"></a>
</div>


<body class="gray" style="overflow-x:hidden;">
    <div class="w320">
        
        <div class="user_header">
            <div class="user_photo">
                <a href="<?php echo url('app=member'); ?>"><img src="<?php echo $this->res_base . "/" . 'images/user.jpg'; ?>" /></a>
            </div>
            <span class="user_name">
                您好,欢迎<?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?>。<a href="index.php?app=member&act=logout" style="color:#999;margin-left:5px;">退出</a>
            </span>
            <div class="order_panel">
                <ul class="orders">
                    <a href="<?php echo url('app=seller_order&act=index&type=pending'); ?>">
                        <li>
                            <span class="num  <?php if ($this->_var['type'] == pending): ?> on <?php endif; ?>"></span>
                            <span>待付款</span>
                        </li>
                    </a>
                    <a href="<?php echo url('app=seller_order&act=index&type=accepted'); ?>">
                        <li>
                            <span class="num <?php if ($this->_var['type'] == accepted): ?> on <?php endif; ?>"></span>
                            <span>待发货</span>
                        </li>
                    </a>
                    <a href="<?php echo url('app=seller_order&act=index&type=shipped'); ?>">
                        <li>
                            <span class="num <?php if ($this->_var['type'] == shipped): ?> on <?php endif; ?>"></span>
                            <span>已发货</span>
                        </li>
                    </a>
                    <a href="<?php echo url('app=seller_order&act=index&type=finished'); ?>">
                        <li>
                            <span class="num <?php if ($this->_var['type'] == finished): ?> on <?php endif; ?>"></span>
                            <span>已完成</span>
                        </li>
                    </a>
                </ul>
            </div>
        </div>


        




        <div class="u_order">
            <?php $_from = $this->_var['orders']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'order');if (count($_from)):
    foreach ($_from AS $this->_var['order']):
?>
            <div class="orderbox">
                <h2><span>买家：<?php echo htmlspecialchars($this->_var['order']['buyer_name']); ?></span><b>订单状态:<font style="color:#b20005;"><?php echo call_user_func("order_status",$this->_var['order']['status']); ?><?php if ($this->_var['order']['evaluation_status']): ?>,&nbsp;已评价<?php endif; ?></font></b></h2>
                <div class="detail">
                    <p>订单号：<?php echo $this->_var['order']['order_sn']; ?></p>
                    <p>电话号码：<?php if ($this->_var['order']['phone_mob'] != ''): ?><?php echo $this->_var['order']['phone_mob']; ?><?php else: ?><?php echo $this->_var['order']['phone_tel']; ?><?php endif; ?></p>
                    <p>​订单总价：<?php echo price_format($this->_var['order']['order_amount']); ?></p>​
                    <p>支付方式：<?php echo htmlspecialchars($this->_var['order']['payment_name']); ?></p>
                </div>
                <p class="opr">
                    <input type="button" value="收到货款" class="white_btn" ectype="dialog" dialog_id="seller_order_received_pay" dialog_width="100%" uri="index.php?app=seller_order&amp;act=received_pay&amp;order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" dialog_title="收到货款" id="order<?php echo $this->_var['order']['order_id']; ?>_action_received_pay"<?php if ($this->_var['order']['status'] != ORDER_PENDING): ?> style="display:none"<?php endif; ?> />
                           <input type="button" value="确认订单" class="white_btn" ectype="dialog" uri="index.php?app=seller_order&amp;act=confirm_order&amp;order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" dialog_id="seller_order_confirm_order" dialog_title="确认订单"  dialog_width="100%" id="order<?php echo $this->_var['order']['order_id']; ?>_action_confirm"<?php if ($this->_var['order']['status'] != ORDER_SUBMITTED): ?> style="display:none"<?php endif; ?> />
                           <input type="button" value="调整费用" class="white_btn" uri="index.php?app=seller_order&amp;act=adjust_fee&amp;order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" dialog_width="100%" dialog_title="调整费用" ectype="dialog"  dialog_id="seller_order_adjust_fee" id="order<?php echo $this->_var['order']['order_id']; ?>_action_adjust_fee"<?php if ($this->_var['order']['status'] != ORDER_PENDING && $this->_var['order']['status'] != ORDER_SUBMITTED): ?> style="display:none"<?php endif; ?> />
                           <input type="button" value="发货" class="white_btn" ectype="dialog" dialog_title="发货" dialog_id="seller_order_shipped" uri="index.php?app=seller_order&amp;act=shipped&amp;order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax"  dialog_width="100%" id="order<?php echo $this->_var['order']['order_id']; ?>_action_shipped"<?php if ($this->_var['order']['status'] != ORDER_ACCEPTED): ?> style="display:none"<?php endif; ?> />
                           
						   <?php if ($this->_var['enable_express']): ?>
						   <a class="white_btn"  href="<?php echo url('app=order_express&order_id=' . $this->_var['order']['order_id']. ''); ?>" <?php if ($this->_var['order']['status'] != ORDER_SHIPPED && $this->_var['order']['status'] != ORDER_FINISHED): ?> style="display:none"<?php endif; ?>>查看物流</a>
						   <?php endif; ?>
                           <input type="button" value="完成交易" class="white_btn" ectype="dialog" dialog_id="seller_order_finished"  dialog_title="完成交易" uri="index.php?app=seller_order&amp;act=finished&order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" dialog_width="100%"  id="order<?php echo $this->_var['order']['order_id']; ?>_action_finish"<?php if ($this->_var['order']['payment_code'] != 'cod' || $this->_var['order']['status'] != ORDER_SHIPPED): ?> style="display:none"<?php endif; ?> />
                           <input type="button" value="修改单号" class="white_btn" ectype="dialog" dialog_title="修改单号" uri="index.php?app=seller_order&amp;act=shipped&amp;order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" dialog_id="seller_order_shipped" dialog_width="100%" id="order<?php echo $this->_var['order']['order_id']; ?>_action_edit_invoice_no"<?php if ($this->_var['order']['status'] != ORDER_SHIPPED): ?> style="display:none"<?php endif; ?> />
                           
                           <input type="button" value="取消订单" class="white_btn" ectype="dialog" uri="index.php?app=seller_order&amp;act=cancel_order&order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" dialog_title="取消订单" dialog_id="seller_order_cancel_order" dialog_width="100%" id="order<?php echo $this->_var['order']['order_id']; ?>_action_cancel"<?php if ($this->_var['order']['status'] == ORDER_CANCELED || $this->_var['order']['status'] == ORDER_FINISHED): ?> style="display:none"<?php endif; ?> />
                           <a class="white_btn" href="<?php echo url('app=seller_order&act=view&order_id=' . $this->_var['order']['order_id']. ''); ?>" >查看订单</a>
                </p>
            </div>
            <?php endforeach; else: ?>

            <div class="null" style="margin-top:120px;">
                <p>你没有订单信息~</p>
            </div>
            <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>

        <div class="page">
            <?php echo $this->fetch('member.page.bottom.html'); ?>
        </div>

        <iframe name="seller_order" style="display:none;"></iframe>
    </div>
<?php echo $this->fetch('member.footer.html'); ?>