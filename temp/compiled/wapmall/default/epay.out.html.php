<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">修改支付密码</div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>


<script language = "JavaScript">
    function tousers()
    {
        if (document.to_users.to_user.value == "")
        {
            alert("转移的用户名不能为空！");
            document.to_users.to_user.focus();
            return false;
        }
        if (document.to_users.to_money.value == "")
        {
            alert("填写转移的金额！");
            document.to_users.to_money.focus();
            return false;
        }
        return true;
    }
</script>

<style>
    .epay_out{margin:10px 16px;}
</style>

<div class="epay_out">
    <form name="to_users" onSubmit="return tousers();" method="post">
        <ul class="form_content">
            <li>
                <h3>目标用户</h3>
                <p><input type="text" name="to_user"  value=""  id="to_user"/></p>
            </li>
            <li>
                <h3> 转出金额</h3>
                <p><input type="text" name="to_money"  value=""  id="to_money"/></p>
            </li>
            <li>
                <h3>支付密码</h3>
                <p><input type="password" name="zf_pass"  value=""  id="zf_pass"/></p>
            </li>
        </ul>
        <input class="red_btn" type="submit" value="提交" />
    </form>
</div>







<?php echo $this->fetch('member.footer.html'); ?>