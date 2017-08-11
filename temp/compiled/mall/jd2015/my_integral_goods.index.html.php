<?php echo $this->fetch('member.header.html'); ?>

<style type="text/css">

    .my_integral_goods{}

    .my_integral_goods li{height: 160px;margin:10px 0 20px 0;}

    .my_integral_goods li .block_1{width:160px;height: 160px;overflow: hidden;float:left;}

    .my_integral_goods li .block_2{width:600px;height: 160px;float:left;}

    .my_integral_goods li .block_2 span{width:260px;height:40px;padding-left:40px;float: left;line-height:40px;text-align:left;}

    .my_integral_goods li .block_2 span a{background: #000;color: #fff;height: 20px;width: 100px;line-height: 20px;margin: 10px auto 0;display: block;float: left;text-align: center;text-decoration:none;}

    .my_integral_goods li .block_2 span a:hover{background:#ce1c00}

</style>

<div class="content">

    <?php echo $this->fetch('member.menu.html'); ?>

    <div id="right">

        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">

            <div class="public">

                <ul class="my_integral_goods">

                    <?php $_from = $this->_var['integral_goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'integral_goods');if (count($_from)):
    foreach ($_from AS $this->_var['integral_goods']):
?>

                    <li>

                        <div class="block_1">

                            <?php if ($this->_var['integral_goods']['goods_logo']): ?><img src="<?php echo $this->_var['integral_goods']['goods_logo']; ?>" height="160" width="160"/><?php endif; ?>

                        </div>

                        <div class="block_2">

                            <span>产品名称：<?php echo htmlspecialchars($this->_var['integral_goods']['goods_name']); ?></span>


                            <span>兑换积分：<?php echo htmlspecialchars($this->_var['integral_goods']['goods_point']); ?></span>


                            <span>产品价值：<?php echo price_format($this->_var['integral_goods']['goods_price']); ?></span>

                            <span><a href="<?php echo url('app=my_integral_goods&act=add&id=' . $this->_var['integral_goods']['goods_id']. ''); ?>">我要兑换</a></span>

                        </div>

                    </li>

                    <?php endforeach; else: ?>

                    <li class="member_no_records">

                        没有符合条件的记录

                    </li>

                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

                </ul>

                <?php echo $this->fetch('member.page.bottom.html'); ?>

                <div class="clear"></div>

            </div>

            <div class="wrap_bottom"></div>

        </div>

        <div class="clear"></div>

    </div>

    <div class="clear"></div>

</div>

<?php echo $this->fetch('footer.html'); ?>

