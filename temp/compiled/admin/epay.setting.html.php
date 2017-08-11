<?php echo $this->fetch('header.html'); ?>



<div id="rightTop">

    <ul class="subnav" style="margin:0;">

        <li><a class="btn1" href="index.php?app=epay">资金用户</a></li>

        <li><a class="btn1" href="index.php?app=epay&act=money_add">增加金额</a></li>

        <li><a class="btn1" href="index.php?app=epay&act=money_log">资金流水</a></li>

        <li><a class="btn1" href="index.php?app=epay&act=txlog">提现记录</a></li>

        <li><span>账户设置</span></li>

        <li><a class="btn1" href="index.php?app=epay&act=statistics">资金安检</a></li>

    </ul>

</div>



<div class="info">



    <table class="infoTable">

        <form method="post">

            <tr>

                <th class="paddingT15">交易佣金比例:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_trade_charges_ratio" type="text" value="<?php echo $this->_var['setting']['epay_trade_charges_ratio']; ?>" size="20">

                    <span class="grey">交易扣除佣金比例，佣金 = 按照产品总额×佣金比例 精确到0.01</span>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">是否开启支付宝充值:</th>

                <td class="paddingT15 wordSpacing5">

                    <input id="epay_alipay_enabled0" type="radio" name="epay_alipay_enabled" <?php if ($this->_var['setting']['epay_alipay_enabled'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="epay_alipay_enabled0">关闭</label>

                    <input id="epay_alipay_enabled1" type="radio" name="epay_alipay_enabled" <?php if ($this->_var['setting']['epay_alipay_enabled'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="epay_alipay_enabled1">开启</label>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">是否开启网银在线充值:</th>

                <td class="paddingT15 wordSpacing5">

                    <input id="epay_chinabank_enabled0" type="radio" name="epay_chinabank_enabled" <?php if ($this->_var['setting']['epay_chinabank_enabled'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="epay_chinabank_enabled0">关闭</label>

                    <input id="epay_chinabank_enabled1" type="radio" name="epay_chinabank_enabled" <?php if ($this->_var['setting']['epay_chinabank_enabled'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="epay_chinabank_enabled1">开启</label>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">是否开启财付通充值:</th>

                <td class="paddingT15 wordSpacing5">

                    <input id="epay_tenpay_enabled0" type="radio" name="epay_tenpay_enabled" <?php if ($this->_var['setting']['epay_tenpay_enabled'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="epay_tenpay_enabled0">关闭</label>

                    <input id="epay_tenpay_enabled1" type="radio" name="epay_tenpay_enabled" <?php if ($this->_var['setting']['epay_tenpay_enabled'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="epay_tenpay_enabled1">开启</label>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">是否开启微信直接充值:</th>

                <td class="paddingT15 wordSpacing5">

                    <input id="epay_wxjs_enabled0" type="radio" name="epay_wxjs_enabled" <?php if ($this->_var['setting']['epay_wxjs_enabled'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="epay_wxjs_enabled0">关闭</label>

                    <input id="epay_wxjs_enabled1" type="radio" name="epay_wxjs_enabled" <?php if ($this->_var['setting']['epay_wxjs_enabled'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="epay_wxjs_enabled1">开启</label>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">是否开启微信直接充值:</th>

                <td class="paddingT15 wordSpacing5">

                    <input id="epay_wxnative_enabled0" type="radio" name="epay_wxnative_enabled" <?php if ($this->_var['setting']['epay_wxnative_enabled'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="epay_wxnative_enabled0">关闭</label>

                    <input id="epay_wxnative_enabled1" type="radio" name="epay_wxnative_enabled" <?php if ($this->_var['setting']['epay_wxnative_enabled'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="epay_wxnative_enabled1">开启</label>

                </td>

            </tr>


            

            <tr>

                <th class="paddingT15">支付宝帐号:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_alipay_seller_email" type="text" value="<?php echo $this->_var['setting']['epay_alipay_seller_email']; ?>" size="20">

                </td>

            </tr>

            <tr>

                <th class="paddingT15">支付宝PID:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_alipay_partner" type="text" value="<?php echo $this->_var['setting']['epay_alipay_partner']; ?>" size="20">

                </td>

            </tr>

            <tr>

                <th class="paddingT15">支付宝KEY:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_alipay_key" type="text" value="<?php echo $this->_var['setting']['epay_alipay_key']; ?>" size="20">

                </td>

            </tr>

            <tr>

                <th class="paddingT15">网银在线PID:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_chinabank_mid" type="text" value="<?php echo $this->_var['setting']['epay_chinabank_mid']; ?>" size="20">

                </td>

            </tr>

            <tr>

                <th class="paddingT15">网银在线KEY:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_chinabank_key" type="text" value="<?php echo $this->_var['setting']['epay_chinabank_key']; ?>" size="20">

                </td>

            </tr>

            <tr>

                <th class="paddingT15">财付通PID:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_tenpay_bargainor_id" type="text" value="<?php echo $this->_var['setting']['epay_tenpay_bargainor_id']; ?>" size="20">

                </td>

            </tr>

            <tr>

                <th class="paddingT15">财付通KEY:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_tenpay_key" type="text" value="<?php echo $this->_var['setting']['epay_tenpay_key']; ?>" size="20">

                </td>

            </tr>

            <tr>

                <th class="paddingT15">微信公众号ID:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_wx_appid" type="text" value="<?php echo $this->_var['setting']['epay_wx_appid']; ?>" size="20">

                    APPID：绑定支付的APPID（必须配置，开户邮件中可查看）

                </td>

            </tr>

            <tr>

                <th class="paddingT15">商户支付密钥:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_wx_key" type="text" value="<?php echo $this->_var['setting']['epay_wx_key']; ?>" size="20">

                    KEY：商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）<a href="https://pay.weixin.qq.com/index.php/account/api_cert" target="_blank">设置地址</a>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">微信商户号:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_wx_mch_id" type="text" value="<?php echo $this->_var['setting']['epay_wx_mch_id']; ?>" size="20">

                    MCHID：商户号（必须配置，开户邮件中可查看）

                </td>

            </tr>

            <tr>

                <th class="paddingT15">公众帐号secert:</th>

                <td class="paddingT15 wordSpacing5">

                    <input name="epay_wx_secret" type="text" value="<?php echo $this->_var['setting']['epay_wx_secret']; ?>" size="20">

                    APPSECRET：公众帐号secert（仅JSAPI支付的时候需要配置， 登录公众平台，进入开发者中心可设置），

                    <a href="https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN" target="_blank">获取地址</a>

                </td>

            </tr>

            


          

            

            <tr>

                <th class="paddingT15"></th>

                <td class="paddingT15 wordSpacing5">

                    请填写配置文件，否则用户无法正常进行充值

                </td>

            </tr>

            <tr>

                <th class="paddingT15">汇款信息:</th>

                <td class="paddingT15 wordSpacing5">

                    <textarea name="epay_offline_info" style="width:500px;height: 100px;"><?php echo $this->_var['setting']['epay_offline_info']; ?></textarea>

                </td>

            </tr>

            <tr>

                <th></th>

                <td class="ptb20">

                    <input class="formbtn" type="submit" name="Submit" value="提交" />

                    <input class="formbtn" type="reset" name="Submit2" value="重置" />

                </td>

            </tr>

        </form>

    </table>	

</div>

<?php echo $this->fetch('footer.html'); ?>