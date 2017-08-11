<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">我的优惠卷</div>
    <a href="javascript" class="r_b"></a>
</div>



<style>
    .my_coupon{border-radius: 5px;position: relative;overflow: hidden;color: #6b6b6b;margin: 0px 10px 0;font-size: 14px;margin-top:10px;}
    .my_coupon select{margin-bottom: 5px;}
</style>

<div class="table">
    <table>
        <tbody>
            <tr>
                <th style="width:30%;text-align: center">优惠券号码</th>
                <th style="width:20%">优惠金额</th>
                <th style="width:20%">可用次数</th>
                <th style="width:20%">是否有效</th>
                <th style="width:10%">操作</th>
            </tr>
            <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['coupon']):
        $this->_foreach['v']['iteration']++;
?>
            <tr>
                <td><?php echo $this->_var['coupon']['coupon_sn']; ?></td>
                <td><?php echo $this->_var['coupon']['coupon_value']; ?></td>
                <td><?php if ($this->_var['coupon']['remain_times'] == - 1): ?>没有限制<?php else: ?><?php echo $this->_var['coupon']['remain_times']; ?><?php endif; ?></td>
                <td><?php if ($this->_var['coupon']['valid']): ?>有效<?php else: ?>失效<?php endif; ?></td>
                <td align="center"><a href="javascript:javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_coupon&act=drop&id=<?php echo $this->_var['coupon']['coupon_sn']; ?>');" class="delete">删除</a></td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </tbody>
    </table>
</div>


<div class="page">
    <?php echo $this->fetch('member.page.bottom.html'); ?>
</div>
<?php echo $this->fetch('member.footer.html'); ?>