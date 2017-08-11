<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>积分记录</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=integral_log">管理</a></li>
        <li><span>积分设置</span></li>
    </ul>
</div>
<div class="info">
    <form method="post" >
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    是否开启积分:</th>
                <td class="paddingT15 wordSpacing5">
                    <input id="integral_enabled0" type="radio" name="integral_enabled" <?php if ($this->_var['setting']['integral_enabled'] == 0): ?>checked<?php endif; ?> value="0" /> <label for="integral_enabled0">关闭</label>
                    <input id="integral_enabled1" type="radio" name="integral_enabled" <?php if ($this->_var['setting']['integral_enabled'] == 1): ?>checked<?php endif; ?> value="1" /> <label for="integral_enabled1">开启</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    注册奖励:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" type="text" name="integral_reg" value="<?php echo $this->_var['setting']['integral_reg']; ?>"/>
                    <span class="grey">用户第一次注册赠送的积分数额</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    登录奖励:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" type="text" name="integral_login" value="<?php echo $this->_var['setting']['integral_login']; ?>"/>
                    <span class="grey">每天登录一次赠送的积分数额。</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    推荐奖励:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" type="text" name="integral_recom" value="<?php echo $this->_var['setting']['integral_recom']; ?>"/>
                    <span class="grey">推荐用户注册赠送的积分数额</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    购买奖励:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" type="text" name="integral_buy" value="<?php echo $this->_var['setting']['integral_buy']; ?>"/>
                    <span class="grey">用户购买产品交易成功后，按照产品总额×赠送比例 获得积分,精确到0.01</span>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    购买抵扣:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" type="text" name="integral_seller" value="<?php echo $this->_var['setting']['integral_seller']; ?>"/>
                    <span class="grey">购买产品现金抵扣比例，实际抵扣金额 = 按照产品总额×积分抵扣比例 精确到0.01</span>
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