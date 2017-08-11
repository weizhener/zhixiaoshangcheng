<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
    $(function () {
        $('#ad_form').validate({
            errorPlacement: function (error, element) {
                $(element).next('.field_notice').hide();
                $(element).after(error);
            },
            success: function (label) {
                label.addClass('right').text('OK!');
            },
            onkeyup: false,
            rules: {
                ad_name: {
                    required: true,
                },
                ad_link: {
                    required: true,
                },
                <?php if (! $this->_var['ad']['ad_logo']): ?>
                ad_logo: {
                    required: true,
                    accept: 'gif|png|jpe?g'
                },
                <?php endif; ?>
                sort_order: {
                    number: true
                }
            },
            messages: {
                ad_name: {
                    required: '广告名称不能为空',
                },
                ad_link: {
                    required: '广告链接地址不能为空',
                },
                <?php if (! $this->_var['ad']['ad_logo']): ?>
                ad_logo: {
                    required: '广告图片不能为空',
                    accept: '支持格式gif,jpg,jpeg,png'
                },
                <?php endif; ?>
                sort_order: {
                    number: 'number_only'
                }
            }
        });
    });
</script>
<div id="rightTop">
    <p>素材管理</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=ad">管理</a></li>
        <?php if ($this->_var['ad']['ad_id']): ?>
        <li><a class="btn1" href="index.php?app=ad&amp;act=add">新增</a></li>
        <?php else: ?>
        <li><span>新增</span></li>
        <?php endif; ?>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="ad_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    广告图位置:</th>
                <td class="paddingT15 wordSpacing5">
                    <select class="querySelect" name="ad_type">
                        <?php echo $this->html_options(array('options'=>$this->_var['ad_type_list'],'selected'=>$this->_var['ad']['ad_type'])); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    广告图名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="ad_name" type="text" name="ad_name" value="<?php echo htmlspecialchars($this->_var['ad']['ad_name']); ?>" /> <label class="field_notice">广告图名称</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    广告图链接:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput" id="ad_link" type="text" name="ad_link" value="<?php echo htmlspecialchars($this->_var['ad']['ad_link']); ?>" /> <label class="field_notice">广告图链接</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    广告图片:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableFile2" id="ad_logo" type="file" name="ad_logo" />
                    <label class="field_notice">支持格式gif,jpg,jpeg,png</label>
                </td>
            </tr>
            <?php if ($this->_var['ad']['ad_logo']): ?>
            <tr>
                <th class="paddingT15">
                </th>
                <td class="paddingT15 wordSpacing5">
                    <img src="<?php echo $this->_var['ad']['ad_logo']; ?>" class="makesmall" max_width="120" max_height="90" />
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="paddingT15">
                    广告描述:</th>
                <td class="paddingT15 wordSpacing5">
                    <textarea name="ad_description" id="ad_description"><?php echo $this->_var['ad']['ad_description']; ?></textarea>
                    <label class="field_notice">广告描述</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['ad']['sort_order']; ?>" />
                    <label class="field_notice">更新排序</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    显示:</th>
                <td class="paddingT15 wordSpacing5">
                <?php echo $this->html_radios(array('options'=>$this->_var['yes_or_no'],'checked'=>$this->_var['ad']['if_show'],'name'=>'if_show')); ?></td>
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
