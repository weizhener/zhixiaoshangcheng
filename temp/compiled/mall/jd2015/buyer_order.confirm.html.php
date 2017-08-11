<script type="text/javascript">
$(function(){
    $('#confirm_cancel').click(function(){
        DialogManager.close('buyer_order_confirm_order');
    });
});
</script>
<div class="content1">
<div id="warning"></div>
<form action="index.php?app=buyer_order&act=confirm_order&order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" method="post" target="iframe_post">
    <h1>您是否确已经收到以下订单的货品？</h1>
    <p>订单号:<span><?php echo $this->_var['order']['order_sn']; ?></span></p>
    <div class="clue_on">
        注意&nbsp;:&nbsp;如果你尚未收到货品请不要点击“确认”。大部分被骗案件都是由于提前确认付款被骗的，请谨慎操作！ 
    </div>
    <div class="btn">
        <input type="submit" id="confirm_yes" class="btn1" value="确认" />
        <input type="button" id="confirm_cancel" class="btn2" value="取消" />
    </div>
</form>
</div>

