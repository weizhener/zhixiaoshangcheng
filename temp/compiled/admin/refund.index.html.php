<?php echo $this->fetch('header.html'); ?>
<style>
select,input{vertical-align:middle}
</style>
<div id="rightTop">
    <p>退款管理</p>
    <ul class="subnav">
        <li><span>管理</span></li>
    </ul>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
             <div class="left">
                <input type="hidden" name="app" value="refund" />
                <input type="hidden" name="act" value="index" />
                <label>是否要求客服介入</label>
                <select name="ask_customer">
                	<option value="yes" <?php if ($_GET['ask_customer'] == 'yes'): ?> selected="selected"<?php endif; ?>>是</option>
                	<option value="all" <?php if ($_GET['ask_customer'] == 'all'): ?> selected="selected"<?php endif; ?>>全部</option>
                    <option value="no" <?php if ($_GET['ask_customer'] == 'no'): ?> selected="selected"<?php endif; ?>>否</option>
                </select>
                <label>排序</label>
                 <select name="sort_order">
                	<option value="created_desc" <?php if ($_GET['sort_order'] == 'created_desc'): ?> selected="selected"<?php endif; ?>>申请时间倒序</option>
                    <option value="created_asc" <?php if ($_GET['sort_order'] == 'created_asc'): ?> selected="selected"<?php endif; ?>>申请时间顺序</option>
                </select>
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=refund">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
    <div class="fontr">
        <?php if ($this->_var['refunds']): ?><?php echo $this->fetch('page.top.html'); ?><?php endif; ?>
    </div>
</div>
<div class="tdare">
    <table width="100%" cellspacing="0" class="dataTable">
        <?php if ($this->_var['refunds']): ?>
        <tr class="tatr1">
            <td width="100" class="firstCell"><span>退款编号</span></td>
            <td width="150">订单编号/宝贝信息</td>
            <td width="100">买家</td>
            <td width="100">卖家</td>
            <td width="100">交易金额</td>
            <td width="100">退款金额</td>
            <td width="100">退运费</td>
            <td width="100">申请时间</td>
            <td width="100">退款状态</td>
            <td width="100">客服介入</td>
            <td width="100">操作</td>
        </tr>
        <?php endif; ?>
        <?php $_from = $this->_var['refunds']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'refund');if (count($_from)):
    foreach ($_from AS $this->_var['refund']):
?>
        <tr class="tatr2">
            <td class="firstCell"><?php echo $this->_var['refund']['refund_sn']; ?></td>
            <td><?php echo $this->_var['refund']['order_sn']; ?><br /><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=goods&id=<?php echo $this->_var['refund']['goods_id']; ?>" target="_blank"><?php echo $this->_var['refund']['goods_name']; ?></a></td>
            <td><?php echo $this->_var['refund']['buyer_name']; ?></td>
            <td><a href="<?php echo $this->_var['site_url']; ?>/index.php?app=store&id=<?php echo $this->_var['refund']['seller_id']; ?>" target="_blank"><?php echo $this->_var['refund']['store_name']; ?></a><br /><?php echo $this->_var['refund']['seller_name']; ?></td>
            <td><?php echo price_format($this->_var['refund']['total_fee']); ?></td>
            <td><?php echo price_format($this->_var['refund']['refund_goods_fee']); ?></td>
            <td><?php echo price_format($this->_var['refund']['refund_shipping_fee']); ?></td>
            <td><?php echo local_date("Y-m-d H:i:s",$this->_var['refund']['created']); ?></td>
            <td>
            	<?php if ($this->_var['refund']['status'] == 'CLOSED'): ?>
                <span style="color:gray">退款关闭</span>
                <?php elseif ($this->_var['refund']['status'] == 'SUCCESS'): ?>
                <span style="color:#62B44B">退款成功</span>
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_AGREE'): ?>
                买家已经申请退款，等待卖家同意
                <?php elseif ($this->_var['refund']['status'] == 'SELLER_REFUSE_BUYER'): ?>
                卖家拒绝退款，等待买家修改中
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_ADMIN_AGREE'): ?>
                 卖家已经同意退款，等待管理员审核
                <?php elseif ($this->_var['refund']['status'] == 'WAIT_SELLER_CONFIRM'): ?>
                退款申请等待卖家确认中
                <?php endif; ?>
            </td>
            <td><?php if ($this->_var['refund']['ask_customer'] == 1): ?>是<?php else: ?>否<?php endif; ?></td>
            <td><a href="<?php echo url('app=refund&act=view&refund_id=' . $this->_var['refund']['refund_id']. ''); ?>">查看</a></td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="11">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>
    <div id="dataFuncs">
        <div class="pageLinks">
            <?php if ($this->_var['refunds']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
