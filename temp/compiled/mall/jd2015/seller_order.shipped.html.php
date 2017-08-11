<script type="text/javascript">
$(function(){
    $('#cancel_button').click(function(){
        DialogManager.close('seller_order_shipped');
    });
    $('#seller_order_shipped').validate({
    errorLabelContainer: $('#warning'),
    invalidHandler: function(form, validator) {
           $('#warning').show();
    },
     rules : {
            invoice_no : {
                required   : true
            }
        },
        messages : {
            invoice_no  : {
                required   : '请输入发货单号'
            }
        }
    });
});
</script>
<div class="content1">
    <div id="warning"></div>
    <form method="post" action="index.php?app=seller_order&amp;act=shipped&amp;order_id=<?php echo $this->_var['order']['order_id']; ?>" target="seller_order" id="seller_order_shipped">
    <h1>请输入您的物流单号</h1>
    <p>订单号&nbsp;&nbsp;&nbsp;&nbsp;:<span><?php echo $this->_var['order']['order_sn']; ?></span></p>
    
    
    <?php if ($this->_var['enable_express']): ?>
    <dl>
        <dt>物流公司:</dt>
        <dd>
        	<select name="express_company">
            	<option value="">选择物流公司</option>
                <?php $_from = $this->_var['express_company']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'company');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['company']):
?>
                <option value="<?php echo $this->_var['key']; ?>" <?php if ($this->_var['key'] == $this->_var['order']['express_company']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['company']; ?></option>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </select>
        </dd>
    </dl>
    <?php endif; ?>
    <dl>
        <dt>物流单号:</dt>
        <dd>  <input type="text" class="text" name="invoice_no" id="invoice_no_input" style="width:195px;" value="<?php echo $this->_var['order']['invoice_no']; ?>" /></dd>
    </dl>
    <dl>
        <dt>操作原因:</dt>
        <dd><textarea id="remark_input" class="text" style="width:200px;" name="remark"></textarea></dd>
    </dl>
    <div class="btn">
        <input type="submit" id="confirm_button" class="btn1" value="确认" />
        <input type="button" id="cancel_button" class="btn2" value="取消" />
    </div></form>
</div>