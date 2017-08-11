<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <ul class="subnav" style="margin:0;">
        <li><a class="btn1" href="index.php?app=epay">资金用户</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_add">增加金额</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_log">资金流水</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=txlog">提现记录</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=setting">账户设置</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=statistics">资金安检</a></li>
    </ul>
</div>

<div class="info">
    <form method="post">
        <table class="infoTable">
            <tr>        
                <th class="paddingT15">会员名称:</th>
                <td class="paddingT15 wordSpacing5"><?php echo $this->_var['epaylog']['user_name']; ?>&nbsp;&nbsp;<a href="index.php?app=epay&act=logs_user_shouru&user_name=<?php echo $this->_var['epaylog']['user_name']; ?>"></a></td>
            </tr>

            <tr>
                <th class="paddingT15">提现金额:</th>
                <td class="paddingT15 wordSpacing5"><font color="#FF0000"><?php echo $this->_var['epaylog']['money']; ?> 元</font>
                    <input name="money" type="hidden" id="money" value="<?php echo $this->_var['epaylog']['money']; ?>" /></td>
            </tr>
            <tr>
                <th class="paddingT15">申请时间:</th>
                <td class="paddingT15 wordSpacing5"><?php echo local_date("Y-m-d H:i:s",$this->_var['epaylog']['add_time']); ?></td>
            </tr>
            <tr>
                <th class="paddingT15">转账成功交易号:</th>
                <td class="paddingT15 wordSpacing5">
                    <input name="order_id" type="text" id="order_id" value="<?php echo $this->_var['epaylog']['order_id']; ?>" size="30" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">日志内容</th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->_var['epaylog']['log_text']; ?>
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="审核" />
                    <input class="formbtn" type="reset" name="Submit2" value="重置" />
                </td>
            </tr>

        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
