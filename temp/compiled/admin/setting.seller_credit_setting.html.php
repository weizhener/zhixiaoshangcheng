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
        <li><span>卖家等级</span></li>
        <li><a class="btn1" href="index.php?app=setting&amp;act=subdomain_setting">二级域名</a></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">等级</th>
                <td class="paddingT15">信用介于</td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/heart_1.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_1_from" value="<?php echo $this->_var['setting']['s_level_1_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_1_to" value="<?php echo $this->_var['setting']['s_level_1_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/heart_2.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_2_from" value="<?php echo $this->_var['setting']['s_level_2_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_2_to" value="<?php echo $this->_var['setting']['s_level_2_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/heart_3.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_3_from" value="<?php echo $this->_var['setting']['s_level_3_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_3_to" value="<?php echo $this->_var['setting']['s_level_3_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/heart_4.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_4_from" value="<?php echo $this->_var['setting']['s_level_4_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_4_to" value="<?php echo $this->_var['setting']['s_level_4_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/heart_5.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_5_from" value="<?php echo $this->_var['setting']['s_level_5_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_5_to" value="<?php echo $this->_var['setting']['s_level_5_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/diamond_1.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_6_from" value="<?php echo $this->_var['setting']['s_level_6_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_6_to" value="<?php echo $this->_var['setting']['s_level_6_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/diamond_2.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_7_from" value="<?php echo $this->_var['setting']['s_level_7_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_7_to" value="<?php echo $this->_var['setting']['s_level_7_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/diamond_3.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_8_from" value="<?php echo $this->_var['setting']['s_level_8_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_8_to" value="<?php echo $this->_var['setting']['s_level_8_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/diamond_4.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_9_from" value="<?php echo $this->_var['setting']['s_level_9_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_9_to" value="<?php echo $this->_var['setting']['s_level_9_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/diamond_5.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_10_from" value="<?php echo $this->_var['setting']['s_level_10_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_10_to" value="<?php echo $this->_var['setting']['s_level_10_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/crown_1.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_11_from" value="<?php echo $this->_var['setting']['s_level_11_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_11_to" value="<?php echo $this->_var['setting']['s_level_11_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/crown_2.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_12_from" value="<?php echo $this->_var['setting']['s_level_12_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_12_to" value="<?php echo $this->_var['setting']['s_level_12_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/crown_3.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_13_from" value="<?php echo $this->_var['setting']['s_level_13_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_13_to" value="<?php echo $this->_var['setting']['s_level_13_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/crown_4.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_14_from" value="<?php echo $this->_var['setting']['s_level_14_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_14_to" value="<?php echo $this->_var['setting']['s_level_14_to']; ?>"/>
                </td>
            </tr>
            <tr>
                <th class="paddingT15"><img src='<?php echo $this->_var['site_url']; ?>/data/system/seller_evaluation/crown_5.gif'/></th>
                <td class="paddingT15">
                    <input size="1" type="text" name="s_level_15_from" value="<?php echo $this->_var['setting']['s_level_15_from']; ?>" />&nbsp;-&nbsp;<input size="1" type="text" name="s_level_15_to" value="<?php echo $this->_var['setting']['s_level_15_to']; ?>"/>
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
