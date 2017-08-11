<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['editor_upload']; ?>
<style>
    .eject_con .adds .coupon{width: 720px;}
    .eject_con .adds .coupon li{width: 720px;}
</style>
<script type="text/javascript">
//<!CDATA[
$(function(){
    trigger_uploader();
    $('#coupon_form').validate({
         errorLabelContainer: $('#warning'),
        invalidHandler: function(form, validator) {
           var errors = validator.numberOfInvalids();
           if(errors)
           {
               $('#warning').show();
           }
           else
           {
               $('#warning').hide();
           }
        },
        rules : {
            coupon_name : {
                required : true
            },
            coupon_value : {
                required : true,
                number : true
            },
            use_times : {
                required : true,
                digits : true
            },
            min_amount : {
                required : true,
                number : true
            },
            end_time : {
                required : true
            }
        },
            messages : {
            coupon_name : {
                required : '优惠券名称不能为空'
            },
            coupon_value : {
                required : '优惠金额必填且必须大于0',
                number : '优惠金额仅能为数字'
            },
            use_times : {
                required : '使用次数不能为空',
                digits : '使用次数仅能为整数'
            },
            min_amount : {
                required : '使用条件不能为空',
                number : '商品最低金额仅能为数字'
            },
            end_time : {
                required : '结束时间不能为空'
            }
        }
    });

    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});

function add_uploadedfile(file_data)
{
   $('#desc_images').append('<li file_name="'+ file_data.file_name +'" file_path="'+ file_data.file_path +'" ectype="handle_pic" file_id="'+ file_data.file_id +'"><input type="hidden" name="file_id[]" value="'+ file_data.file_id +'"><div class="pic" style="z-index: 2;"><img src="<?php echo $this->_var['site_url']; ?>/'+ file_data.file_path +'" width="50" height="50" alt="'+ file_data.file_name +'" /></div><div ectype="handler" class="bg" style="z-index: 3;display:none"><img src="<?php echo $this->_var['site_url']; ?>/'+ file_data.file_path +'" width="50" height="50" alt="'+ file_data.file_name +'" /><p class="operation"><a href="javascript:void(0);" class="cut_in" ectype="insert_editor" ecm_title="插入编辑器"></a><span class="delete" ectype="drop_image" ecm_title="删除"></span></p><p class="name">'+ file_data.file_name +'</p></div></li>');
   trigger_uploader();
        if(EDITOR_SWFU.getStats().files_queued == 0){
            window.setTimeout(function(){
                $('#editor_uploader').hide();
            },5000);
        }
}
function drop_image(file_id)
{
    if (confirm(lang.uploadedfile_drop_confirm))
        {
            var url = SITE_URL + '/index.php?app=seller_coupon&act=drop_uploadedfile';
            $.getJSON(url, {'file_id':file_id}, function(data){
                if (data.done)
                {
                    $('*[file_id="' + file_id + '"]').remove();
                }
                else
                {
                    alert(data.msg);
                }
            });
        }
}

//]]>
</script>
<div class="eject_con">
    <div class="adds">
        <div id="warning"></div>
        <form method="post" enctype="multipart/form-data" action="index.php?app=seller_coupon&act=<?php echo $_GET['act']; ?>&id=<?php echo $_GET['id']; ?>" target="coupon" id="coupon_form">
            <ul class="coupon">
            <li>
                <h3>优惠券名称:</h3>
                <p><input type="text" class="text width14" name="coupon_name" value="<?php echo htmlspecialchars($this->_var['coupon']['coupon_name']); ?>"/><b class="strong">*</b></p>
            </li>
            <li>
                <h3>优惠金额:</h3>
                <p><input type="text" class="text width2" name="coupon_value" value="<?php echo $this->_var['coupon']['coupon_value']; ?>" /><b class="strong">*</b></p>
            </li>
            <li>
                <h3>使用次数:</h3>
                <p><input type="text" class="text width2" name="use_times" value="<?php if ($this->_var['coupon']['use_times']): ?><?php echo $this->_var['coupon']['use_times']; ?><?php else: ?>1<?php endif; ?>" /><span class="field_notice">一个优惠券号码可以使用的次数</span><b class="strong">*</b></p>
            </li>
            <li>
                <h3>使用期限:</h3>
                <p><input type="text" class="text width2" name="start_time" value="<?php if ($this->_var['coupon']['start_time']): ?><?php echo local_date("Y-m-d",$this->_var['coupon']['start_time']); ?><?php else: ?><?php echo local_date("Y-m-d",$this->_var['today']); ?><?php endif; ?>" id="add_time_from" readonly="readonly" />
                 至 <input type="text" class="text width2" name="end_time" value="<?php if ($this->_var['coupon']['end_time']): ?><?php echo local_date("Y-m-d",$this->_var['coupon']['end_time']); ?><?php endif; ?>" id="add_time_to" readonly="readonly" /><b class="strong">*</b>
                </p>
            </li>
            <li>
                <h3>使用条件:</h3>
                <p><span class="field_notice" style="padding-left: 0px; ">一次购物满  <input type="text" class="text width1" name="min_amount" value="<?php echo $this->_var['coupon']['min_amount']; ?>" />   才可使用</span><b class="strong">*</b></p>
            </li>
            <li>
                <h3>发布:</h3>
                <p style="line-height:25px;"><input type="checkbox" name="if_issue" value="1" />立即发布 <span class="field_notice">一旦发布将不能修改优惠券信息</span></p>
                <div class="clear"></div>
            </li>
            <li>
                <h3>背景图:</h3>
                <p>
                    <input type="file" name="coupon_bg"/>
                    <?php if ($this->_var['coupon']['coupon_bg']): ?>
                    <img src="<?php echo $this->_var['coupon']['coupon_bg']; ?>" height="50" alt="<?php echo htmlspecialchars($this->_var['coupon']['coupon_name']); ?>"/>
                    <?php endif; ?>
                </p>
            </li>
            <li>
                <h3>内容:</h3>
                <p><textarea  name="content" id="content" style="width:570px; height:250px;"><?php echo htmlspecialchars($this->_var['coupon']['content']); ?></textarea></p>
            </li>
        </ul>
            <div class="editor">
            <div style="position: relative; top: 10px; z-index: 5;">
                <a class="btn3" id="open_editor_uploader">上传文件</a>
                   <div class="upload_con" id="editor_uploader" style="display:none">
                    <div class="upload_con_top"></div>
                    <div class="upload_wrap">
                     <ul>
                        <li><iframe src="index.php?app=comupload&act=view_iframe&id=<?php echo $this->_var['id']; ?>&belong=<?php echo $this->_var['belong']; ?>&instance=desc_image" width="86" height="30" scrolling="no" frameborder="0"></iframe></li>
                        <li id="open_editor_remote" class="btn2">远程地址</li>
                    </ul>
                    <div id="editor_remote" class="upload_file" style="display:none">
                    <iframe src="index.php?app=comupload&act=view_remote&id=<?php echo $this->_var['id']; ?>&belong=<?php echo $this->_var['belong']; ?>&instance=desc_image" width="272" height="39" scrolling="no" frameborder="0"></iframe>
                    </div>
                    <div id="editor_upload_progress"></div>
                    <div class="upload_txt">
                        <span>支持JPEG和静态的GIF格式图片，不支持GIF动画图片，上传图片大小不能超过2M.浏览文件时可以按住ctrl或shift键多选</span>
                    </div>

                </div>
                <div class="upload_con_bottom"></div>
            </div>
        </div>
         <ul id="desc_images" class="preview">
            <?php $_from = $this->_var['files_belong_coupon']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'file');if (count($_from)):
    foreach ($_from AS $this->_var['file']):
?>
            <li ectype="handle_pic" file_name="<?php echo htmlspecialchars($this->_var['file']['file_name']); ?>" file_path="<?php echo $this->_var['file']['file_path']; ?>" file_id="<?php echo $this->_var['file']['file_id']; ?>">
            <input type="hidden" name="file_id[]" value="<?php echo $this->_var['file']['file_id']; ?>">
                <div class="pic">
                <img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['file']['file_path']; ?>" width="50" height="50" alt="<?php echo htmlspecialchars($this->_var['file']['file_name']); ?>" title="<?php echo htmlspecialchars($this->_var['file']['file_name']); ?>" /></div>
                <div ectype="handler" class="bg">
                <img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['file']['file_path']; ?>" width="50" height="50" alt="<?php echo htmlspecialchars($this->_var['file']['file_name']); ?>" title="<?php echo htmlspecialchars($this->_var['file']['file_name']); ?>" />
                    <p class="operation">
                        <a href="javascript:void(0);" class="cut_in" ectype="insert_editor" ecm_title="插入编辑器"></a>
                        <span class="delete" ectype="drop_image" ecm_title="删除"></span>
                    </p>
                    <p title="<?php echo htmlspecialchars($this->_var['file']['file_name']); ?>" class="name"><?php echo htmlspecialchars($this->_var['file']['file_name']); ?></p>
                </div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        <div class="clear"></div>
        </div>
        <div class="submit"><input type="submit" class="btn" value="提交" /></div>
        </form>
    </div>
    <div style="border:0px; height:70px; width:10px;"></div>
</div>