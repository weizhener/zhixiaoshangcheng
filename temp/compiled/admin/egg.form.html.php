<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function () {
        $('#egg_form').validate({
            errorPlacement: function (error, element) {
                $(element).next('.field_notice').hide();
                $(element).after(error);
            },
            success: function (label) {
                label.addClass('right').text('OK!');
            },
            onkeyup: false,
            rules: {
                name: {
                    required: true
                },
                noun: {
                    required: true,
                    maxlength: 5,
                    digits: true
                },
                rate: {
                    required: true,
                    maxlength: 4
                }
            },
            messages: {
                name: {
                    required: '不能为空'
                },
                noun: {
                    required: '不能为空',
                    maxlength: '积分长度最多为5位',
                    digits: '必须为正整数'
                },
                rate: {
                    required: '不能为空',
                    maxlength: '内容过长'
                }
            }
        });
    });
</script>
<div id="rightTop">
    <p>砸蛋设置</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=egg">管理</a></li>
        <?php if ($this->_var['egg']['egg_id']): ?>
        <li><a class="btn1" href="index.php?app=egg&amp;act=add">新增</a></li>
        <?php else: ?>
        <li><span>新增</span></li>
        <?php endif; ?>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="egg_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="name" type="text" name="name" value="<?php echo htmlspecialchars($this->_var['egg']['name']); ?>" />
                    <label class="field_notice">名称</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    积分:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="noun" type="text" name="noun" value="<?php echo htmlspecialchars($this->_var['egg']['noun']); ?>" />
                    <label class="field_notice">积分</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    中奖比例（千分比，请填1-1000的数）:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="rate" type="text" name="rate" value="<?php echo htmlspecialchars($this->_var['egg']['rate']); ?>" />
                    <label class="field_notice">中奖比例（千分比，请填1-1000的数）</label>
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
