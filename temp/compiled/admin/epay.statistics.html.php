<?php echo $this->fetch('header.html'); ?>

<div id="rightTop">
    <ul class="subnav" style="margin:0;">
        <li><a class="btn1" href="index.php?app=epay">资金用户</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_add">增加金额</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_log">资金流水</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=txlog">提现记录</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=setting">账户设置</a></li>
        <li><span>资金安检</span></li>
    </ul>
</div>

<div class="info">

    
    
    
    
    <table class="infoTable">
        
        <tr>
            <th class="paddingT15">资金计算公式1</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:blue">收入资金</strong> = <strong style="color:red">支出资金 + 用户可用金额 + 用户冻结金额</strong>
            </td>
        </tr>
        <tr>
            <th class="paddingT15">检测结果</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:blue"><?php echo $this->_var['epay_check_1']['income_money']; ?></strong> = <strong style="color:red"><?php echo $this->_var['epay_check_1']['outlay_money']; ?> + <?php echo $this->_var['epay_check_1']['money']; ?> + <?php echo $this->_var['epay_check_1']['money_dj']; ?></strong>
            </td>
        </tr>
        <tr>
            <th class="paddingT15"></th>
            <td class="paddingT15 wordSpacing5"></td>
        </tr>
        <tr>
            <th class="paddingT15"></th>
            <td class="paddingT15 wordSpacing5"></td>
        </tr>
        <tr>
            <th class="paddingT15"></th>
            <td class="paddingT15 wordSpacing5"></td>
        </tr>
        
        
        
        
        <tr>
            <th class="paddingT15">资金计算公式2</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:blue">管理员增加金额 + 系统充值金额</strong> = <strong style="color:red">审核提现金额 + 用户可用金额 + 用户冻结金额 + 管理员减少金额</strong>
            </td>
        </tr>
        <tr>
            <th class="paddingT15">检测结果</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:blue"><?php echo $this->_var['epay_check_2']['type10']; ?> + <?php echo $this->_var['epay_check_2']['type60']; ?></strong> = <strong style="color:red"><?php echo $this->_var['epay_check_2']['type71']; ?> + <?php echo $this->_var['epay_check_2']['typeusermoney']; ?> + <?php echo $this->_var['epay_check_2']['typeusermoney_dj']; ?> + <?php echo $this->_var['epay_check_2']['type11']; ?></strong>
            </td>
        </tr>
        <tr>
            <th class="paddingT15">管理员增加金额</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:blue"><?php echo $this->_var['epay_check_2']['type10']; ?></strong> 元
            </td>
        </tr>
        <tr>
            <th class="paddingT15">系统充值金额</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:blue"><?php echo $this->_var['epay_check_2']['type60']; ?></strong> 元
            </td>
        </tr>
        <tr>
            <th class="paddingT15">审核提现金额</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:red"><?php echo $this->_var['epay_check_2']['type71']; ?></strong> 元
            </td>
        </tr>
        <tr>
            <th class="paddingT15">用户可用金额</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:red"><?php echo $this->_var['epay_check_2']['typeusermoney']; ?></strong> 元
            </td>
        </tr>
        <tr>
            <th class="paddingT15">用户冻结金额</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:red"><?php echo $this->_var['epay_check_2']['typeusermoney_dj']; ?></strong> 元
            </td>
        </tr>
        <tr>
            <th class="paddingT15">管理员减少金额</th>
            <td class="paddingT15 wordSpacing5">
                <strong style="color:red"><?php echo $this->_var['epay_check_2']['type11']; ?></strong> 元
            </td>
        </tr>
        <tr>
            <th class="paddingT15">待处理</th>
            <td class="paddingT15 wordSpacing5">
                您有 <strong style="color:red"><?php echo $this->_var['epay_check_2']['typecount70']; ?></strong> 比提现等待处理，共计金额 <strong style="color:red"><?php echo $this->_var['epay_check_2']['type70']; ?></strong>
            </td>
        </tr>
    </table>
</div>
<?php echo $this->fetch('footer.html'); ?>