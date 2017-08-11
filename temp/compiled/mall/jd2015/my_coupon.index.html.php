<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right"> 
        <?php echo $this->fetch('member.curlocal.html'); ?>
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="eject_btn_two eject_pos1" title="优惠券登记"><b class="ico3" ectype="dialog" dialog_title="优惠券登记" dialog_id="my_coupon_bind" dialog_width="480" uri="index.php?app=my_coupon&act=bind">优惠券登记</b></div>
            <div class="public table">
                <table>
                    <?php if ($this->_var['coupons']): ?>
                    <tr class="line_bold" >
                        <th class="width1"><input id="all" type="checkbox" class="checkall" /></th>
                        <th class="align1" colspan="10">
                            <label for="all"> <span class="all">全选</span> </label>
                            <a href="javascript:void(0);" class="delete" ectype="batchbutton" uri="index.php?app=my_coupon&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')">删除</a>
                        </th>
                    </tr>
                    <tr class="gray">
                        <th></th>
                        <th>优惠券号码</th>
                        <th>优惠金额</th>
                        <th>使用期限</th>
                        <th>使用条件</th>
                        <th>发放店铺</th>
                        <th>可用次数</td>                    
                        <th>是否有效</th>
                        <th>操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php if ($this->_var['gcategories']): ?>
                    <tbody>
                        <?php endif; ?>
                        <?php $_from = $this->_var['coupons']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'coupon');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['coupon']):
        $this->_foreach['v']['iteration']++;
?>
                        <tr class="line<?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?> last_line<?php endif; ?>">
                            <td class="align2"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['coupon']['coupon_sn']; ?>" /></td>
                            <td><?php echo $this->_var['coupon']['coupon_sn']; ?></td>
                            <td class="align2"><?php if ($this->_var['coupon']['coupon_value']): ?><?php echo $this->_var['coupon']['coupon_value']; ?><?php else: ?>没有限制<?php endif; ?></td>
                            <td class="align2"><?php echo local_date("Y-m-d",$this->_var['coupon']['start_time']); ?> 至 <?php if ($this->_var['coupon']['end_time']): ?><?php echo local_date("Y-m-d",$this->_var['coupon']['end_time']); ?><?php else: ?>没有限制<?php endif; ?></td>
                            <td class="align2"><?php if ($this->_var['coupon']['min_amount']): ?><?php echo sprintf('一次购物满 %s ', $this->_var['coupon']['min_amount']); ?><?php else: ?>没有限制<?php endif; ?></td>
                            <td class="align2"><a href="<?php echo url('app=store&id=' . $this->_var['coupon']['store_id']. ''); ?>"><?php echo $this->_var['coupon']['store_name']; ?></a></td>
                            <td class="align2"><?php if ($this->_var['coupon']['remain_times'] == - 1): ?>没有限制<?php else: ?><?php echo $this->_var['coupon']['remain_times']; ?><?php endif; ?></td>
                            <td class="align2"><?php if ($this->_var['coupon']['valid']): ?><img src="<?php echo $this->res_base . "/" . 'images'; ?>/usable.gif" /><?php else: ?><img src="<?php echo $this->res_base . "/" . 'images'; ?>/unusable.gif" /><?php endif; ?></td>
                            <td class="align2"><a href="javascript:javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_coupon&act=drop&id=<?php echo $this->_var['coupon']['coupon_sn']; ?>');" class="delete">删除</a></td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="10" class="member_no_records padding6">没有符合条件的记录</td>
                        </tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php if ($this->_var['coupons']): ?>
                    </tbody>
                    <?php endif; ?>
                    <?php if ($this->_var['coupons']): ?>
                    <tr class="line_bold line_bold_bottom">
                        <td colspan="11">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><input id="all2" type="checkbox" class="checkall" /></th>
                        <th colspan="10"><p class="position1"><label for="all2"><span class="all">全选</span></label>
                        <a href="javascript:void(0);" ectype="batchbutton" class="delete" uri="index.php?app=my_coupon&act=drop" name="id" presubmit="confirm('您确定要删除它吗？')">删除</a></p>
                    <p class="position2">
                        <?php echo $this->fetch('member.page.bottom.html'); ?>
                    </p> 
                    </th>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <iframe name="my_coupon" style="display:none"></iframe>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>