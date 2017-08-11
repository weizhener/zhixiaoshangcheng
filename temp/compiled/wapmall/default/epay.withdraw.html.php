<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">申请提现</div>
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
    .epay_withdraw{margin:10px 16px;}
    .epay_withdraw .title{text-align: center;margin-bottom: 10px;font-size: 14px;}
    .epay_withdraw .title strong{color:red;float:none;}
    .epay_withdraw dl{display: block;width: 100%;line-height: 20px;}
    .epay_withdraw dl dt{display: block;font-size: 14px;color: #333;font-weight: bold;margin-bottom: 10px;}
    .epay_withdraw dl dd{margin-bottom:20px;float:left;width: 100%}
    .epay_withdraw dl dd input{float: left;margin-top:3px;margin-right: 5px;}
    .epay_withdraw dl dd .float-left{float: left;margin-right: 10px;}

</style>
<div class="epay_withdraw">


    <?php if ($this->_var['epay']['money'] > 0): ?>
    <?php if (! $this->_var['bank_list']): ?>
    <div class="notice-word">您还没有设置提现银行卡，请先设置后再申请提现。<a  href="<?php echo url('app=epay&act=bank_add'); ?>">马上设置</a></div>
    <?php else: ?>
    <div class="notice-word">向商城交易宝提取余额到银行卡，请确保您的银行卡信息正确</div>
    <form method="post" id="epay-withdraw">

        <div class="title">提取余额到银行卡</div>
        <div class="title">余额：<strong><?php echo $this->_var['epay']['money']; ?></strong> 元</div>
        <div class="title"><a class="add-bank"  href="<?php echo url('app=epay&act=bank_add&type=debit'); ?>">添加银行卡</a></div>
        <div class="title"><a  href="<?php echo url('app=epay&act=logall&type=70'); ?>">提现记录</a></div>

        <dl class="clearfix">
            <dt>选择银行卡：</dt>
            <?php $_from = $this->_var['bank_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'bank');$this->_foreach['fe_bank'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_bank']['total'] > 0):
    foreach ($_from AS $this->_var['bank']):
        $this->_foreach['fe_bank']['iteration']++;
?>
            <dd>
                <input name="bank_id" type="radio" value="<?php echo $this->_var['bank']['bank_id']; ?>" <?php if (($this->_foreach['fe_bank']['iteration'] <= 1)): ?> checked="checked" <?php endif; ?>/>
                       <div class="float-left"><?php echo $this->_var['bank']['bank_name']; ?></div>
                <div class="float-left"><?php echo $this->_var['bank']['num']; ?></div>
                <div class="float-right">
                    <a  href="<?php echo url('app=epay&act=bank_edit&bank_id=' . $this->_var['bank']['bank_id']. ''); ?>">编辑</a>
                </div>

            </dd>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </dl>
        <ul class="form_content">
            <li>
                <h3>提现金额</h3>
                <p><input type="text" name="tx_money"  value="" /></p>
            </li>
            <li>
                <h3>支付密码</h3>
                <p><input type="password" name="post_zf_pass"  value="" /></p>
            </li>
        </ul>
        <input class="red_btn" type="submit" value="提交" />
    </form>
    <?php endif; ?>
    <?php else: ?>
    <div class="notice-word">您目前账户余额为<span class="f60">0</span>元，不能申请提现。</div>
    <?php endif; ?>

</div>

<?php echo $this->fetch('member.footer.html'); ?>