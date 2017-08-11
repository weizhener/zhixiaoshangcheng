<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>网站设置</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_setting">系统设置</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=base_information">基本信息</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=email_setting">Email</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=captcha_setting">验证码</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=store_setting">开店设置</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=buyer_credit_setting">买家等级</a></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=seller_credit_setting">卖家等级</a></li>
        <li><span>二级域名</span></li>
    </ul>
</div>

<div class="info">
    <form method="post">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    是否启用二级域名:</th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->html_radios(array('name'=>'enabled_subdomain','options'=>$this->_var['yes_or_no'],'checked'=>$this->_var['config']['enabled_subdomain'])); ?>
                    <span class="grey">启用二级域名需要您的服务器支持，具体配置方便请查看安装包中docs目录中的二级域名配置文档</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    二级域名后缀:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="subdomain_suffix" type="text" name="subdomain_suffix" value="<?php echo $this->_var['config']['subdomain_suffix']; ?>"/>
                    <span class="grey">例如:用户的二级域名将是"test.mall.example.com", 则您只需要在此填写"mall.example.com"</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    保留域名:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="subdomain_reserved" type="text" name="subdomain_reserved" value="<?php echo $this->_var['setting']['subdomain_reserved']; ?>"/>
                    <span class="grey">请输入您欲保留的二级域名，多个保留域名之间请用","号隔开</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    长度限制:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="subdomain_length" type="text" name="subdomain_length" value="<?php echo $this->_var['setting']['subdomain_length']; ?>"/>
                    <span class="grey">形如"3-12"，代表注册的域名限制在3到12个字符长度之间</span>
                </td>
            </tr>
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
