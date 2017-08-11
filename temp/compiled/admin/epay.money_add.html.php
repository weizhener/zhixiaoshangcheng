<?php echo $this->fetch('header.html'); ?>


<div id="rightTop">
    <ul class="subnav" style="margin:0;">
        <li><a class="btn1" href="index.php?app=epay">资金用户</a></li>
        <li><span>增加金额</span></li>
        <li><a class="btn1" href="index.php?app=epay&act=money_log">资金流水</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=txlog">提现记录</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=setting">账户设置</a></li>
        <li><a class="btn1" href="index.php?app=epay&act=statistics">资金安检</a></li>
    </ul>
</div>

<div class="info">

    <table class="infoTable">
        <form method="post">
            <tr>
                <th class="paddingT15">会员名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input name="user_name" type="text" value="<?php $_from = $this->_var['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?><?php echo $this->_var['val']['user_name']; ?><?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>" size="20">
                </td>
            </tr>
            <tr>
                <th class="paddingT15">操作金额:</th>
                <td class="paddingT15 wordSpacing5">
                    <input name="post_money" type="text" id="post_money" value="" size="10">
                     元
                </td>
            </tr>
            <tr>
                <th class="paddingT15">操作类型:</th>
                <td class="paddingT15 wordSpacing5"><input name="jia_or_jian" type="radio" value="jia" checked="CHECKED" /> 增加 
                    <input type="radio" name="jia_or_jian" value="jian" /> 减少
                </td>
            </tr>
            <?php $_from = $this->_var['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
            <tr>
                <th class="paddingT15">可用余额:</th>
                <td class="paddingT15 wordSpacing5">
                    <font color="#FF0000"><?php echo $this->_var['val']['money']; ?></font>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">冻结金额:</th>
                <td class="paddingT15 wordSpacing5"><?php echo $this->_var['val']['money_dj']; ?>
                </td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
                <th class="paddingT15">操作日志:</th>		
                <td class="paddingT15 wordSpacing5">



                    <input name="log_text" type="text" id="log_text" value="管理员：<?php echo $this->_var['visitor']['user_name']; ?>手工操作用户资金" size="60">



                    <div id="time_from2">

                    </div>
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