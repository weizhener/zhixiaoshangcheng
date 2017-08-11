<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#acategory_form').validate({
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
                url :'index.php?app=acategory&act=check_acategory',
                type:'get',
                data:{
                    cate_name : function(){
                        return $('#cate_name').val();
                    },
                    parent_id : function() {
                        return $('#parent_id').val();
                    },
                    id : '<?php echo $this->_var['acategory']['cate_id']; ?>'
                  }
                }
            },
            sort_order : {
                number   : true
            }
        },
        messages : {
            cate_name : {
                required : '文章分类名称不能为空',
                remote   : '该分类名称已经存在了，请您换一个'
            },
            sort_order  : {
                number   : '排序仅能为数字'
            }
        }
    });
});
</script>
<div id="rightTop">
    <p>文章分类</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=acategory">管理</a></li>
        <li><?php if ($this->_var['acategory']['cate_id']): ?><a class="btn1" href="index.php?app=acategory&amp;act=add">新增</a><?php else: ?><span>新增</span><?php endif; ?></li>
    </ul>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data" id="acategory_form">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    分类名称:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="infoTableInput2" id="cate_name" type="text" name="cate_name" value="<?php echo htmlspecialchars($this->_var['acategory']['cate_name']); ?>" />
                    <label class="field_notice">文章分类的名称</label>              </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="parent_id">上级分类:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <select id="parent_id" name="parent_id"><option value="0">请选择...</option><?php echo $this->html_options(array('options'=>$this->_var['parents'],'selected'=>$this->_var['acategory']['parent_id'])); ?></select>                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['acategory']['sort_order']; ?>" />
                    <label class="field_notice">更新排序</label>             </td>
            </tr>
            
            <tr>
			<td>是否底部显示:</td>
			  <td>
				  <input id="is_foot" class="radio_input" name="is_foot" <?php if (! $this->_var['acategory']['is_foot']): ?>checked<?php endif; ?> value="0" type="radio">
				  <label for="radar_disabled">否</label>
				  <input id="is_foot" class="radio_input" name="is_foot" <?php if ($this->_var['acategory']['is_foot']): ?>checked<?php endif; ?> value="1" type="radio">
				  <label for="enable_radar">是</label></td>
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
