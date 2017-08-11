<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="particular">
        <div class="particular_wrap">
            <form method="POST">
            <h2>订单评价</h2>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
            <div class="evaluate_obj">
                <dl class="info">
                    <dt>卖家评价</dt>
                    <dd>买家: <a href="#"><?php echo htmlspecialchars($this->_var['order']['buyer_name']); ?></a></dd>
                </dl>

                <div class="ware_line">
                    <div class="ware">
                        <div class="ware_list">
                            <div class="ware_pic"><img src="<?php echo $this->_var['goods']['goods_image']; ?>" width="50" height="50"  /></div>
                            <div class="ware_text">
                                <div class="ware_text4">
                                    <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a><br />
                                    <span><?php echo htmlspecialchars($this->_var['goods']['specification']); ?></span>
                                </div>
                                <div class="ware_text3">
                                    <span>数量&nbsp;:&nbsp;<strong><?php echo $this->_var['goods']['quantity']; ?></strong></span>
                                    <span>价格&nbsp;:&nbsp;<strong><?php echo price_format($this->_var['goods']['price']); ?></strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="evaluate_wrap">
                    <div class="my_evaluate">
                        <div class="fill_in">
                            <h4>评价管理</h4>
                            <div>
                                <b><label for="g<?php echo $this->_var['goods']['rec_id']; ?>_op1"><input id="g<?php echo $this->_var['goods']['rec_id']; ?>_op1" type="radio" name="seller_evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][seller_evaluation]" value="3" checked  />好评<span>(加一分)</span></label></b>
                                <b><label for="g<?php echo $this->_var['goods']['rec_id']; ?>_op2"><input id="g<?php echo $this->_var['goods']['rec_id']; ?>_op2" type="radio" name="seller_evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][seller_evaluation]" value="2" /> 中评<span>(不加分)</span></label></b>
                                <b><label for="g<?php echo $this->_var['goods']['rec_id']; ?>_op3"><input id="g<?php echo $this->_var['goods']['rec_id']; ?>_op3" type="radio" name="seller_evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][seller_evaluation]" value="1" /> 差评<span>(扣一分)</span></label></b>
                            </div>
                            <div class="textarea"><textarea name="seller_evaluations[<?php echo $this->_var['goods']['rec_id']; ?>][seller_comment]"></textarea></div>
                        </div>
                        <dl>
                            <dt>注意&nbsp;:&nbsp;</dt>
                            <dd>
                                 请您根据本次交易，给予真实、客观、仔细地评价。<br />
                您的评价将是其他会员的参考，也将影响卖家的信用。 <br />
                累积信用和计分规则： <br />
                中评不计分，但会影响卖家的好评率，请慎重给予。
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <div class="evaluate_footer">
                <input type="submit" value="提交" class="btn1" />
                <input type="button" onclick="window.close();" value="以后再评" class="btn2" />
            </div>
            <div class="particular_bottom"></div>
            </form>
        </div>

        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>

    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>