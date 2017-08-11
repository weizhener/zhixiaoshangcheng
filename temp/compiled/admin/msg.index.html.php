<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <ul class="subnav" style="margin-left:0px;">
        <li><span>发送记录</span></li>
        <li><a class="btn1" href="index.php?app=msg&act=user">短信用户</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=add">增加短信</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=send">短信发送</a></li>
        <li><a class="btn1" href="index.php?app=msg&act=setting">设置接口</a></li>
    </ul>
</div>

<div class="mrightTop">
    <div class="fontl">
        <form method="get">
            <div class="left">
                <input name="app" type="hidden" value="msg" />
                <input name="act" type="hidden" value="index" />
                接收手机:
                <input class="queryInput" type="text" name="to_mobile" value="<?php echo htmlspecialchars($this->_var['query']['to_mobile']); ?>" />
                <!--发送时间:
    <input name="time" type="text" id="time" value="" size="10" maxlength="10" />-->
                <input type="submit" class="formbtn" value="查询" />
            </div>
        </form>
    </div>
    <div class="fontr">
        <?php echo $this->fetch('page.top.html'); ?>
    </div>
</div>

<div class="tdare">
    <table width="100%" cellspacing="0">

        <tr class="tatr1">
            <td width="140">接收手机</td>
            <td>内容</td>
            <td width="118">时间</td>
            <td width="109">用户名</td>
            <td width="72">状态</td>
        </tr>

        <?php $_from = $this->_var['index']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
        <tr class="tatr2">
            <td><b><?php echo $this->_var['val']['to_mobile']; ?></b></td>
            <td align="left"><?php echo $this->_var['val']['content']; ?></td>
            <td><?php echo local_date("y-m-d H:i:s",$this->_var['val']['time']); ?></td>
            <td><?php echo $this->_var['val']['user_name']; ?></td>
            <td><?php echo $this->_var['val']['state']; ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="5">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <?php if ($this->_var['index']): ?>
    <div id="dataFuncs">
        <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
        <div class="clear"></div>
    </div>
    <?php endif; ?>
</div>
<?php echo $this->fetch('footer.html'); ?>