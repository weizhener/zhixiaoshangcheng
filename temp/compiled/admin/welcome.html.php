<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
<p>
    您好<b><?php echo $this->_var['admin']['user_name']; ?></b>，欢迎使用    智芸商城 。
    您上次登录的时间是 <?php echo local_date("Y-m-d H:i:s",$this->_var['admin']['last_login']); ?> ，IP 是 <?php echo $this->_var['admin']['last_ip']; ?>
</p>
</div>
<dl id="rightCon">
<dt>动态</dt>
<dd>
    <ul id="news">
    </ul>
</dd>
<?php if ($this->_var['remind_info']): ?>
<dt>站长提醒</dt>
<dd>
    <ul>
        <?php $_from = $this->_var['remind_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'remind');if (count($_from)):
    foreach ($_from AS $this->_var['remind']):
?>
        <li><?php echo $this->_var['remind']; ?></li>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
</dd>
<?php endif; ?>
<dt>一周动态</dt>
<dd>
    <table>
        <tr>
            <th>新增会员数:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_user_qty']; ?></td>
            <th>新增店铺数/申请数:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_store_qty']; ?>/<?php echo $this->_var['news_in_a_week']['new_apply_qty']; ?></td>
        </tr>
        <tr>
            <th>新增商品数:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_goods_qty']; ?></td>
            <th>新增订单数:</th>
            <td class="td"><?php echo $this->_var['news_in_a_week']['new_order_qty']; ?></td>
        </tr>
    </table>
</dd>
<dt>统计信息</dt>
<dd>
    <table>
        <tr>
            <th>会员总数:</th>
            <td class="td"><?php echo $this->_var['stats']['user_qty']; ?></td>
            <th>店铺总数/申请总数:</th>
            <td class="td"><?php echo $this->_var['stats']['store_qty']; ?>/<?php echo $this->_var['stats']['apply_qty']; ?></td>
        </tr>
        <tr>
            <th>商品总数:</th>
            <td class="td"><?php echo $this->_var['stats']['goods_qty']; ?></td>
            <th>订单总数:</th>
            <td class="td"><?php echo $this->_var['stats']['order_qty']; ?></td>
        </tr>
        <tr>
            <th>订单总金额:</th>
            <td class="td"><?php echo price_format($this->_var['stats']['order_amount']); ?></td>
            <th></th>
            <td class="td"></td>
        </tr>
    </table>
</dd>
<dt>系统信息</dt>
<dd>
    <table>
        <tr>
            <th>服务器操作系统:</th>
            <td class="td"><?php echo $this->_var['sys_info']['server_os']; ?></td>
            <th>WEB 服务器:</th>
            <td class="td"><?php echo $this->_var['sys_info']['web_server']; ?></td>
        </tr>
        <tr>
            <th>PHP 版本:</th>
            <td class="td"><?php echo $this->_var['sys_info']['php_version']; ?></td>
            <th>MYSQL 版本:</th>
            <td class="td"><?php echo $this->_var['sys_info']['mysql_version']; ?></td>
        </tr>
        <tr>
            <th>版本:</th>
            <td class="td"><?php echo $this->_var['sys_info']['ecmall_version']; ?></td>
            <th>安装日期:</th>
            <td class="td"><?php echo $this->_var['sys_info']['install_date']; ?></td>
        </tr>
    </table>
</dd>
</dl>
<?php echo $this->fetch('footer.html'); ?>
