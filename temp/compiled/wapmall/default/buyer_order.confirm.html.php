<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<script type="text/javascript">
$(function(){
    $('#confirm_cancel').click(function(){
        DialogManager.close('buyer_order_confirm_order');
    });
});
</script>
<style>
.dialog_body{overflow:hidden;}
.dialog_content .tab{line-height:28px;}
.dialog_content .content1{margin-top:5px;}
.dialog_content .content1 h1{font-size:16px;font-weight:normal;}
.dialog_content .content1 .li{margin-top:5px;}
.dialog_content .content1 .li input{vertical-align:middle;}
.dialog_content .content1 dl{margin:5px 0;}
.dialog_content .content1 .btn1{width:49%;padding:8px 0;float:left; margin-right:2%;}
.dialog_content .content1 .btn2{width:49%;padding:8px 0;float:left;}
.clue_on{margin:5px 0;}
</style>
<ul class="tab">
    <li class="active">确认收货</li>
</ul>
<div class="content1">
<div id="warning"></div>
<form action="index.php?app=buyer_order&act=confirm_order&order_id=<?php echo $this->_var['order']['order_id']; ?>&ajax" method="post" target="iframe_post">
    <h1>您是否确已经收到以下订单的货品？</h1>
    <p>订单号:<span><?php echo $this->_var['order']['order_sn']; ?></span></p>
    <div class="clue_on">
        注意&nbsp;:&nbsp;如果你尚未收到货品请不要点击“确认”。大部分被骗案件都是由于提前确认付款被骗的，请谨慎操作！ 
    </div>
    <input type="submit" id="confirm_yes" class="red_btn btn1" value="确认" />
    <input type="button" id="confirm_cancel" class="white_btn btn2" value="取消" />
</form>
</div>

