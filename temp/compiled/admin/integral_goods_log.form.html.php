<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">

    $(function () {

        $('#integral_goods_log_form').validate({

            errorPlacement: function (error, element) {

                $(element).next('.field_notice').hide();

                $(element).after(error);

            },

            success: function (label) {

                label.addClass('right').text('OK!');

            },

            onkeyup: false,

            rules: {

                goods_stock: {

                    required: true,

                    number: true

                },

                goods_stock_exchange: {

                    required: true,

                    number: true

                },

                goods_price: {

                    required: true,

                    number: true

                },

                goods_point: {

                    required: true,

                    number: true

                },

            },

            messages: {

                goods_stock: {

                    required: 'empty',

                    number: 'need_number'

                },

                goods_stock_exchange: {

                    required: 'empty',

                    number: 'need_number'

                },

                goods_price: {

                    required: 'empty',

                    number: 'need_number'

                },

                goods_point: {

                    required: 'empty',

                    number: 'need_number'

                },

            }

        });

    });

</script>

<div id="rightTop">

    <p>积分产品兑换</p>

    <ul class="subnav">

        <li><a class="btn1" href="index.php?app=integral_goods_log">管理</a></li>

        <li><span>编辑</span></li>

    </ul>

</div>

<div class="info">

    <form method="post" id="integral_goods_log_form">

        <table class="infoTable">

            <tr>

                <th class="paddingT15">积分产品名称:</th>

                <td class="paddingT15 wordSpacing5">

                    <?php echo $this->_var['integral_goods_log']['goods_name']; ?>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">用户名:</th>

                <td class="paddingT15 wordSpacing5">

                    <?php echo $this->_var['integral_goods_log']['user_name']; ?>

                </td>

            </tr>
			
            <tr>

                <th class="paddingT15">回购金额:</th>

                <td class="paddingT15 wordSpacing5">

                    <?php echo $this->_var['integral_goods_log']['money']; ?>

                </td>

            </tr>
			
            <tr>

                <th class="paddingT15">

                    收货信息:</th>

                <td class="paddingT15 wordSpacing5">收货人：<?php echo htmlspecialchars($this->_var['integral_goods_log']['my_name']); ?><br />收货地址：<?php echo htmlspecialchars($this->_var['integral_goods_log']['my_address']); ?><br />联系电话：<?php echo htmlspecialchars($this->_var['integral_goods_log']['my_mobile']); ?></td>

            </tr>
			
			
            <tr>

                <th class="paddingT15">

                    银行信息:</th>

                <td class="paddingT15 wordSpacing5">银行户名：<?php echo htmlspecialchars($this->_var['integral_goods_log']['truename']); ?><br />开户银行：<?php echo htmlspecialchars($this->_var['integral_goods_log']['bankname']); ?><br />开户行名称：<?php echo htmlspecialchars($this->_var['integral_goods_log']['bankadd']); ?><br />银行卡号：<?php echo htmlspecialchars($this->_var['integral_goods_log']['bankcard']); ?></td>

            </tr>
            


            <tr>

                <th class="paddingT15">

                    状态:</th>

                <td class="paddingT15 wordSpacing5">

                <?php echo $this->html_radios(array('options'=>$this->_var['states'],'checked'=>$this->_var['integral_goods_log']['state'],'name'=>'state')); ?></td>

            </tr>

            

            

            <tr>

                <th></th>

                <td class="ptb20">

                    <input class="formbtn" type="submit" name="Submit" value="提交" />

                    <input class="formbtn" type="reset" name="Submit2" value="重置" />

                </td>

            </tr>

        </table>

    </form>

</div>

<?php echo $this->fetch('footer.html'); ?>

