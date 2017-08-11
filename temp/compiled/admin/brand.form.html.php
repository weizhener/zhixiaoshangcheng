<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#brand_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        onkeyup    : false,
        rules : {
            brand_name : {
                required : true,
                remote   : {                //唯一
                url :'index.php?app=brand&act=check_brand',
                type:'get',
                data:{
                    brand_name : function(){
                        return $('#brand_name').val();
                        },
                    id  : '<?php echo $this->_var['brand']['brand_id']; ?>'
                    }
                }
            },
            logo : {
                accept  : 'gif|png|jpe?g'
            },
            sort_order : {
                number   : true
            }
        },
        messages : {
            brand_name : {
                required : '品牌名称不能为空',
                remote   : '该品牌名称已经存在了，请您换一个'
            },
            logo : {
                accept : '支持格式gif,jpg,jpeg,png'
            },
            sort_order  : {
                number   : '排序仅可以为数字'
            }
        }
    });
});
</script>
<div id="rightTop">
    <p>商品品牌</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=brand">管理</a></li>
        <?php if ($this->_var['brand']['brand_id']): ?>
        <li><a class="btn1" href="index.php?app=brand&amp;act=add">新增</a></li>
        <?php else: ?>
        <li><span>新增</span></li>
        <?php endif; ?>
        <li><a class="btn1" href="index.php?app=brand&wait_verify=1">待审核</a></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="brand_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    品牌名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="brand_name" type="text" name="brand_name" value="<?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?>" /> <label class="field_notice">品牌名称</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    类别:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="tag" type="text" name="tag" value="<?php echo htmlspecialchars($this->_var['brand']['tag']); ?>" /> <label class="field_notice">类别</label>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    图片标识:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableFile2" id="brand_logo" type="file" name="logo" />
                    <label class="field_notice">支持格式gif,jpg,jpeg,png</label>
                </td>
            </tr>
            <?php if ($this->_var['brand']['brand_logo']): ?>
            <tr>
                <th class="paddingT15">
                </th>
                <td class="paddingT15 wordSpacing5">
                <img src="<?php echo $this->_var['brand']['brand_logo']; ?>" class="makesmall" max_width="120" max_height="90" />
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="paddingT15">
                    是否推荐:</th>
                <td class="paddingT15 wordSpacing5">
                <?php echo $this->html_radios(array('options'=>$this->_var['yes_or_no'],'checked'=>$this->_var['brand']['recommended'],'name'=>'recommended')); ?></td>
            </tr>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['brand']['sort_order']; ?>" />
                    <label class="field_notice">更新排序</label>
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
