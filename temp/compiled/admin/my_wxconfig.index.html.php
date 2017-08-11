<?php echo $this->fetch('header.html'); ?>

<div id="rightTop">
    <p>名称</p>
    <ul class="subnav">
        <li><span>微信接口配置</span></li>
        <li><a class="btn1"  href="index.php?app=my_wxfollow">关注自动回复</a></li>
        <li><a class="btn1"  href="index.php?app=my_wxkeyword">关键词自动回复</a></li>
        <li><a class="btn1"  href="index.php?app=my_wxmess">消息自动回复</a></li>
        <li><a class="btn1"  href="index.php?app=my_wxmenu">自定义菜单</a></li>
    </ul>
</div>


<div class="tdare">
    <form method="post"  id="my_wxconfig_form">
        <table style="width: 100%">
            <tr>
                <th class="width2">接口配置URL:</th>
                <td>
                    <p class="td_block"><input id="url" type="text" class="text width_normal" name="url" value="<?php echo htmlspecialchars($this->_var['wx_config']['url']); ?>" style="width:480px;" readonly/></p>

                </td>
            </tr>
            <tr>
                <th>接口配置Token:</th>
                <td>
                    <p class="td_block"><input type="text" name="token" class="text width_normal" id="token" value="<?php echo htmlspecialchars($this->_var['wx_config']['token']); ?>" readonly/></p>
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
                  </td>
            </tr>
        </table>
    </form>
</div>


<?php echo $this->fetch('footer.html'); ?>