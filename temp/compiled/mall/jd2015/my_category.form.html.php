<script type="text/javascript">
$(function(){
    $('#category_form').validate({
/*        errorPlacement: function(error, element){
            var _message_box = $(element).parent().parent().parent().parent().find('#warning');
            _message_box.find('#warning_info').hide();
            _message_box.append(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },*/
        errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           /*var errors = validator.numberOfInvalids();
           if(errors)
           {*/
               $('#warning').show();
           /*}
           else
           {
               $('#warning').hide();
           }*/
        },
        onfocusout : false,
        onkeyup    : false,
        rules : {
            cate_name : {
                required : true,
                remote   : {
                url :'index.php?app=my_category&act=check_category',
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
                remote   : '该分类名称已存在，请您重新输入。',
                required : '分类名称不能为空。'

            },
            sort_order  : {
                number   : '此项仅能为数字。'
            }
        }
    });
});
</script>
<div class="eject_con">
 <div class="adds">
        <div id="warning"></div>
        <form enctype="multipart/form-data"  id="category_form" method="post" target="pop_warning" action="index.php?app=my_category&amp;act=<?php echo $_GET['act']; ?><?php if ($_GET['id']): ?>&amp;id=<?php echo $_GET['id']; ?><?php endif; ?>">
        <ul>
            <li>
                <h3>分类名称:</h3>
                <p><input class="text width_normal" type="text" name="cate_name" id="cate_name" value="<?php echo htmlspecialchars($this->_var['gcategory']['cate_name']); ?>" /><label class="field_notice"></label></p>
            </li>
            
            <li>
                <h3>分类图片:</h3>
                <p><input class="text width_normal" type="file" name="catpic" id="catpic" /><label class="field_notice"></label></p>
            </li>
            
            <li>
                <h3>上级分类:</h3>
                <p><select name="parent_id" id="parent_id">
                <option>请选择...</option>
                <?php echo $this->html_options(array('options'=>$this->_var['parents'],'selected'=>$this->_var['gcategory']['parent_id'])); ?>
                </select></p>
            </li>
            <li>
                <h3>排序:</h3>
                <p><input type="text" name="sort_order" value="<?php echo $this->_var['gcategory']['sort_order']; ?>"  class="text width_short"/></p>
            </li>
            <li>
                <h3>显示:</h3>
                <p><label>
                 <input type="radio" name="if_show" value="1" <?php if ($this->_var['gcategory']['if_show']): ?>checked="checked"<?php endif; ?> />
                是</label>
                <label>
                <input type="radio" name="if_show" value="0" <?php if (! $this->_var['gcategory']['if_show']): ?>checked="checked"<?php endif; ?> />
                否</label></p>
            </li>
        </ul>
        <div class="submit"><input type="submit" class="btn" value="提交" /></div>
        </form>
    </div>
</div>