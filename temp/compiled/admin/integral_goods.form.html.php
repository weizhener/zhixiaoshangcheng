<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function () {
        $('#integral_goods_form').validate({
            errorPlacement: function (error, element) {
                $(element).next('.field_notice').hide();
                $(element).after(error);
            },
            success: function (label) {
                label.addClass('right').text('OK!');
            },
            onkeyup: false,
            rules: {
                goods_name: {
                    required: true,
                    remote: {//唯一
                        url: 'index.php?app=integral_goods&act=check_integral_goods',
                        type: 'get',
                        data: {
                            goods_name: function () {
                                return $('#goods_name').val();
                            },
                            id: '<?php echo $this->_var['integral_goods']['goods_id']; ?>'
                        }
                    }
                },
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
                goods_logo: {
                    accept: 'gif|png|jpe?g'
                },
                sort_order: {
                    number: true
                }
            },
            messages: {
                goods_name: {
                    required: '名称不能为空',
                    remote: '产品名称已存在'
                },
                goods_stock: {
                    required: '不能为空',
                    number: '需要为数字'
                },
                goods_stock_exchange: {
                    required: '不能为空',
                    number: '需要为数字'
                },
                goods_price: {
                    required: '不能为空',
                    number: '需要为数字'
                },
                goods_point: {
                    required: '不能为空',
                    number: '需要为数字'
                },
                goods_logo: {
                    accept: 'limit_img'
                },
                sort_order: {
                    number: 'number_only'
                }
            }
        });
    });
</script>
<div id="rightTop">
    <p>积分产品</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=integral_goods">管理</a></li>
        <?php if ($this->_var['integral_goods']['goods_id']): ?>
        <li><a class="btn1" href="index.php?app=integral_goods&amp;act=add">新增</a></li>
        <?php else: ?>
        <li><span>新增</span></li>
        <?php endif; ?>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="integral_goods_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    产品名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="goods_name" type="text" name="goods_name" value="<?php echo htmlspecialchars($this->_var['integral_goods']['goods_name']); ?>" /> <label class="field_notice">积分产品名称</label>
                </td>
            </tr>
            
            
            <tr>
                <th class="paddingT15">
                    产品库存:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="goods_stock" type="text" name="goods_stock" value="<?php echo htmlspecialchars($this->_var['integral_goods']['goods_stock']); ?>" /> <label class="field_notice">积分产品可兑换的库存</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    已兑换:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="goods_stock_exchange" type="text" name="goods_stock_exchange" value="<?php echo htmlspecialchars($this->_var['integral_goods']['goods_stock_exchange']); ?>" /> <label class="field_notice">积分产品已经兑换的数量</label>
                </td>
            </tr>
            
            <tr>
                <th class="paddingT15">
                    产品价值:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="goods_price" type="text" name="goods_price" value="<?php echo htmlspecialchars($this->_var['integral_goods']['goods_price']); ?>" /> <label class="field_notice">积分产品的具体价值</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    兑换积分:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="goods_point" type="text" name="goods_point" value="<?php echo htmlspecialchars($this->_var['integral_goods']['goods_point']); ?>" /> <label class="field_notice">兑换积分产品所需要的积分</label>
                </td>
            </tr>
            
            <tr>
                <th class="paddingT15">
                    产品图片:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableFile2" id="goods_logo" type="file" name="goods_logo" />
                    <label class="field_notice">支持格式gif,jpg,jpeg,png</label>
                </td>
            </tr>
            <?php if ($this->_var['integral_goods']['goods_logo']): ?>
            <tr>
                <th class="paddingT15">
                </th>
                <td class="paddingT15 wordSpacing5">
                    <img src="<?php echo $this->_var['integral_goods']['goods_logo']; ?>" class="makesmall" max_width="120" max_height="90" />
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['integral_goods']['sort_order']; ?>" />
                    <label class="field_notice">积分产品排序</label>
                </td>
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
