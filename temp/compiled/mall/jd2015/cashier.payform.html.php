<?php if ($this->_var['payform']['online']): ?>
  <h3>正在连接支付网关, 请稍等...</h3>
  <form action="<?php echo $this->_var['payform']['gateway']; ?>" id="payform" method="<?php echo $this->_var['payform']['method']; ?>" style="display:none">
  <?php $_from = $this->_var['payform']['params']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('_k', 'value');if (count($_from)):
    foreach ($_from AS $this->_var['_k'] => $this->_var['value']):
?>
    <input type="hidden" name="<?php echo $this->_var['_k']; ?>" value="<?php echo $this->_var['value']; ?>" />
  <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
  </form>
  <script type="text/javascript">
      document.getElementById('payform').submit();
  </script>
<?php else: ?>
<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
.mall-nav{display:none}
</style>
<div id="main" class="w-full">
<div id="page-cashier" class="w">
   <?php echo $this->fetch('curlocal.html'); ?>
   <div class="order-form payform clearfix border mt10 mb20">
      <div class="title padding5 strong">支付方式简介</div>
      <div class="detail padding10">
            <?php echo $this->_var['payform']['desc']; ?>
      </div>
      <div class="form padding10">
         <form id="pay_message_form" action="index.php?app=cashier&act=offline_pay&order_id=<?php echo $this->_var['order']['order_id']; ?>" method="POST">
            <table class="table_form" width="100%" border="0" cellspacing="0" cellpadding="5">
                <tr>
                    <td valign="top" width="90">
                         请输入支付信息
                    <span class="desc">(如:转账的账号,时间等)</span></td>
                    <td>
                    <textarea name="pay_message" cols="60" rows="5" class="border"><?php echo htmlspecialchars($this->_var['order']['pay_message']); ?></textarea></td>
                </tr>
                <tr>
                	<td></td>
                    <td>
                        <input type="submit" class="btn-step fff strong fs14" value="提交" />
                    </td>
                </tr>
            </table>
           </form>
        </div>
    </div>
</div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>
<?php endif; ?>
