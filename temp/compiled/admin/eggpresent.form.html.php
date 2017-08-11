<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">

    $(function () {

        $('#eggpresent_form').validate({

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

                eggpresent_logo: {

                    accept: 'gif|png|jpe?g'

                }

            },

            messages: {

                name: {

                    required: '不能为空'

                },

                eggpresent_logo: {

                    accept: 'gif|png|jpeg'

                }

            }

        });

    });

</script>

<div id="rightTop">

    <p>砸蛋礼品管理</p>

    <ul class="subnav">

        <li><a class="btn1" href="index.php?app=eggpresent">管理</a></li>

        <?php if ($this->_var['eggpresent']['eggpresent_id']): ?>

        <li><a class="btn1" href="index.php?app=eggpresent&amp;act=add">新增</a></li>

        <?php else: ?>

        <li><span>新增</span></li>

        <?php endif; ?>

    </ul>

</div>



<div class="info">

    <form method="post" enctype="multipart/form-data" id="eggpresent_form">

        <table class="infoTable">

            <tr>

                <th class="paddingT15">

                    名称:</th>

                <td class="paddingT15 wordSpacing5">

                    <input class="infoTableInput2" id="name" type="text" name="name" value="<?php echo htmlspecialchars($this->_var['eggpresent']['name']); ?>" />

                    <label class="field_notice">名称</label>

                </td>

            </tr>

            <tr>

                <th class="paddingT15">

                    赠送积分:</th>

                <td class="paddingT15 wordSpacing5">

                    <input class="infoTableInput2" id="money" type="text" name="money" value="<?php echo htmlspecialchars($this->_var['eggpresent']['money']); ?>" />

                    <label class="field_notice">赠送积分</label>

                </td>

            </tr>



            <tr>

                <th class="paddingT15">

                    所属活动蛋类:</th>

                <td class="paddingT15 wordSpacing5">

                    <select name="egg" id="egg">

                        <?php echo $this->html_options(array('options'=>$this->_var['eggs'],'selected'=>$this->_var['eggpresent']['egg'])); ?>

                    </select>

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

