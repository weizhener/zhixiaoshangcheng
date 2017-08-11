<?php echo $this->fetch('member.header.html'); ?>
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
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table epay">
                <div class="notice-word">将您的账户余额转出到另外的预存款账户上，请慎重填写。</div>
                <form name="to_users" onSubmit="return tousers();" method="post">
                    <div class="title clearfix">
                        <h2 class="float-left">转账</h2>
                        <p class="float-left">余额：<strong><?php echo $this->_var['epay']['money']; ?></strong> 元</p>
                        <div class="float-right link">
                            <a  href="<?php echo url('app=epay&act=logall&type=50'); ?>">转账记录</a>
                        </div>
                    </div>
                    <div class="form">
                        <dl class="clearfix">
                            <dt>目标用户：</dt>
                            <dd><input name="to_user" type="text" id="to_user" size="10" /></dd>
                        </dl>
                        <dl class="clearfix">
                            <dt> 转出金额：</dt>
                            <dd> <input name="to_money" type="text" id="to_money" size="10" /></dd>
                        </dl>
                        <dl class="clearfix">
                            <dt>支付密码：</dt>
                            <dd><input name="zf_pass" type="password" id="zf_pass"  size="16" maxlength="16"/></dd>
                        </dl>
                        <dl class="clearfix">
                            <dt>&nbsp;</dt>
                            <dd class="submit">
                                <span class="epay_btn">
                                    <input type="submit" value="提交" />
                                </span>
                            </dd>
                        </dl>
                    </div>
                </form>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
