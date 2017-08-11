<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>网站设置</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">系统设置</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">基本信息</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
        <li><span>验证码</span></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">开店设置</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=buyer_credit_setting">买家等级</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=seller_credit_setting">卖家等级</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">二级域名</a></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    启用时机:</th>
                <td class="paddingT15 wordSpacing5">
                    <input id="captcha_status1" type="checkbox" name="captcha_status[login]" value="1" <?php if ($this->_var['setting']['captcha_status']['login']): ?>checked<?php endif; ?>/> <label for="captcha_status1">前台登录</label>
                    <input id="captcha_status2" type="checkbox" name="captcha_status[register]" value="1" <?php if ($this->_var['setting']['captcha_status']['register']): ?>checked<?php endif; ?>/> <label for="captcha_status2">前台注册</label>
                    <input id="captcha_status3" type="checkbox" name="captcha_status[goodsqa]" value="1" <?php if ($this->_var['setting']['captcha_status']['goodsqa']): ?>checked<?php endif; ?>/> <label for="captcha_status3">商品咨询</label> 
                    <input id="captcha_status4" type="checkbox" name="captcha_status[backend]" value="1" <?php if ($this->_var['setting']['captcha_status']['backend']): ?>checked<?php endif; ?>/> <label for="captcha_status4">后台登录</label>                </td>
            </tr>
            <!--<tr>
                <th class="paddingT15">
                    允许登录失败次数:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="captcha_error_login" type="text" name="captcha_error_login" value="<?php echo $this->_var['setting']['captcha_error_login']; ?>"/></td>
            </tr>-->
            <tr>
                <th></th>
                <td class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="提交" />
                    <input class="formbtn" type="reset" name="Submit2" value="重置" />
                </td>
            </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
