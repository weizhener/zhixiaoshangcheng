<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">银行卡设置</div>
    <a href="javascript" class="r_b"></a>
</div>

<?php echo $this->fetch('member.submenu.html'); ?>
<script>
    $(function () {
        $('#epay-withdraw').submit(function () {
            if ($(this).find('input[name="tx_money"]').val() == '' || $(this).find('input[name="tx_money"]').val() <= 0) {
                alert('withdraw_money_error');
                return false;
            }
        });
    })
</script>

<style>
    .epay_bank_form{margin:10px 16px;position: relative;}
    .epay_bank_form dl{display: block;}
    .epay_bank_form dl dt{display: block;font-size: 14px;color: #333;font-weight: bold;margin-bottom: 10px;}
    .epay_bank_form dl dd{margin-bottom: 10px;width:50%;float:left;}
    .epay_bank_form dl dd input{float: left;margin-top: 10px;margin-right: 5px;}
    .epay_bank_form dl dd label{display: inline-block;width: 140px;position: relative;}




</style>

<div class="epay_bank_form">
    <div class="notice-word">当您申请提现时平台会向您这里设置的银行卡汇款，请确保您的银行卡是正确的。</div>
    <form method="post">

        <dl class="clearfix">
            <dt>选择银行</dt>
            <?php $_from = $this->_var['bank_inc']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'bank');$this->_foreach['fe_bank'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_bank']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['bank']):
        $this->_foreach['fe_bank']['iteration']++;
?>
            <dd>
                <input type="radio" name="short_name" id="<?php echo $this->_var['key']; ?>" value="<?php echo $this->_var['key']; ?>" <?php if (($this->_foreach['fe_bank']['iteration'] <= 1)): ?>checked="checked" <?php endif; ?> <?php if ($_GET['short_name'] == $this->_var['key']): ?> checked="checked" <?php endif; ?>  />
                       <label class="" for="<?php echo $this->_var['key']; ?>" >
                    <span class="icon-cashier icon-cashier-<?php echo $this->_var['key']; ?>" title="<?php echo $this->_var['bank']; ?>">&nbsp;</span>
                </label>
            </dd>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </dl>
        <ul class="form_content">
            <li>
                <h3>卡 号</h3>
                <p><input type="text" name="bank_num"  value="<?php echo $this->_var['card']['bank_num']; ?>" /></p>
            </li>
            <li>
                <h3>户 名</h3>
                <p><input type="text" name="account_name"  value="<?php echo $this->_var['card']['account_name']; ?>" /></p>
            </li>


            <li>
                <h3>开户支行</h3>
                <p><input type="text" name="open_bank"  value="<?php echo $this->_var['card']['open_bank']; ?>" /></p>
            </li>
            <li>
                <h3>卡类型</h3>
                <p><label><input type="radio" name="bank_type" value="debit" <?php if ($_GET['bank_type'] == 'debit' || $this->_var['card']['bank_type'] == 'debit'): ?> checked="checked" <?php endif; ?> />储蓄卡（借记卡）</label>
                    <label><input type="radio" name="bank_type" value="credit" <?php if ($_GET['bank_type'] == 'credit' || $this->_var['card']['bank_type'] == 'credit'): ?> checked="checked" <?php endif; ?> />信用卡（贷记卡）</label>
                </p>
            </li>
            <li>
                <h3>验证码</h3>
                <p><input type="text" name="captcha"  id="captcha1" />
                    <a href="javascript:change_captcha($('#captcha'));" class="renewedly"><img id="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" /></a>
                </p>
            </li>

        </ul>
        <input class="red_btn" type="submit" value="提交" />
    </form>
</div>





<?php echo $this->fetch('member.footer.html'); ?>