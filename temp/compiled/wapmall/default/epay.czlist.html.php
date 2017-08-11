<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">充值</div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>
<script language = "JavaScript">
    $(function(){
    function online_chongzhi()
    {
    if (document.online_form.cz_money.value == "")
    {
    alert("填写要充值的金额");
            document.online_form.cz_money.focus();
            return false;
    }
    return true;
    }
</script>
<style>
    .epay_czlist{margin: 10px;}
    .epay_czlist li{margin-bottom: 10px;}
</style>
<body class="gray" style="overflow-x:hidden;">
    <div class="w320">
        <form name="online_form" action="index.php?app=epay&act=czfs" method="post" ectype="online">
            <ul class="epay_czlist">
                <li>
                    <input type="text" class="text" name="cz_money" value="0.01" style="width:100%;">
                </li>
                <li>
                    <select class="querySelect" name="czfs">
                        <?php if ($this->_var['epay_wxjs_enabled']): ?>
                        <option value="wxjs">微信充值</option>
                        <?php endif; ?>
                        <?php if ($this->_var['epay_alipay_enabled']): ?>
                        <option value="alipay">支付宝</option>
                        <?php endif; ?>
                    </select>
                </li>
                <li>
                    <input  value="充值" name="Submit"  type="submit" class="red_btn"/>
                </li>
            </ul>
        </form>
    </div>
</body>


<?php echo $this->fetch('member.footer.html'); ?>