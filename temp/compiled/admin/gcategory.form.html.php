<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#gcategory_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        onfocusout : false,
        onkeyup    : false,
        rules : {
            cate_name : {
                required : true,
                remote   : {                
                url :'index.php?app=gcategory&act=check_gcategory',
                type:'get',
                data:{
                    cate_name : function(){
                        return $('#cate_name').val();
                    },
                    parent_id : function() {
                        return $('#parent_id').val();
                    },
                    id : '<?php echo $this->_var['gcategory']['cate_id']; ?>'
                  }
                }
            },
            sort_order : {
                number   : true
            }
        },
        messages : {
            cate_name : {
                required : '分类名称不能为空',
                remote   : '该分类名称已经存在了，请您换一个'
            },
            sort_order  : {
                number   : '分类排序仅能为数字'
            }
        }
    });
});
</script>
<div id="rightTop">
    <p>商品分类</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=gcategory">管理</a></li>
        <li><?php if ($this->_var['gcategory']['cate_id']): ?><a class="btn1" href="index.php?app=gcategory&amp;act=add">新增</a><?php else: ?><span>新增</span><?php endif; ?></li>
    </ul>
</div>
<div class="info">
    <form method="post" enctype="multipart/form-data" id="gcategory_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    分类名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="cate_name" type="text" name="cate_name" value="<?php echo htmlspecialchars($this->_var['gcategory']['cate_name']); ?>" /> <label class="field_notice">分类名称</label>               </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="parent_id">上级分类:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <select id="parent_id" name="parent_id"><option value="0">请选择...</option><?php echo $this->html_options(array('options'=>$this->_var['parents'],'selected'=>$this->_var['gcategory']['parent_id'])); ?></select> <label class="field_notice">上级分类</label>               </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['gcategory']['sort_order']; ?>" />  <label class="field_notice">更新排序</label>              </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    分类图标:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableFile2" id="cate_logo" type="file" name="cate_logo" />
                    <label class="field_notice">支持格式gif,jpg,jpeg,png</label>
                </td>
            </tr>
            <?php if ($this->_var['gcategory']['cate_logo']): ?>
            <tr>
                <th class="paddingT15">
                </th>
                <td class="paddingT15 wordSpacing5">
                    <img src="<?php echo $this->_var['gcategory']['cate_logo']; ?>" class="makesmall" max_width="120" max_height="90" />
                </td>
            </tr>
            <?php endif; ?>
            <tr>
              <th class="paddingT15">显示:</th>
              <td class="paddingT15 wordSpacing5"><p>
                <label>
                  <input type="radio" name="if_show" value="1" <?php if ($this->_var['gcategory']['if_show']): ?>checked="checked"<?php endif; ?> />
                  是</label>
                <label>
                  <input type="radio" name="if_show" value="0" <?php if (! $this->_var['gcategory']['if_show']): ?>checked="checked"<?php endif; ?> />
                  否</label> <label class="field_notice">新增的分类名称是否显示</label>
              </p></td>
            </tr>

          <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="reset" value="重置" />            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
