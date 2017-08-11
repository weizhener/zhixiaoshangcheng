<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">修改支付密码</div>
    <a href="javascript" class="r_b"></a>
</div>
<?php echo $this->fetch('member.submenu.html'); ?>
<script language = "JavaScript">
    /*修改密码表单*/
    function editpass()
    {
        if (document.edit_pass.y_pass.value == "")
        {
            alert("密码不能为空！");
            document.edit_pass.y_pass.focus();
            return false;
        }

        if (document.edit_pass.my_pass.value == "")
        {
            alert("密码不能为空！");
            document.edit_pass.my_pass.focus();
            return false;
        }

        if (document.edit_pass.my_pass2.value == "")
        {
            alert("密码不能为空！");
            document.edit_pass.my_pass2.focus();
            return false;
        }
        return true;
    }
</script>

<style>
    .epay_password{margin:10px 16px;}
</style>
<div class="epay_password">
    <form name="edit_pass" onSubmit="return editpass()" method="post">
        <ul class="form_content">
            <?php if ($this->_var['epay']['zf_pass']): ?>
            <li><h3>原支付密码:</h3>
                <p><input type="password"  name="y_pass" /></p>
            </li>
            <?php endif; ?>
            <li>
                <h3>新支付密码:</h3>
                <p><input type="password"  name="zf_pass" /></p>
            </li>
            <li>
                <h3>确认密码:</h3>
                <p><input type="password"  name="zf_pass2" /></p>
            </li>
        </ul>
        <input class="red_btn" type="submit" value="提交" />
    </form>
</div>
<?php echo $this->fetch('member.footer.html'); ?>