<?php echo $this->_var['build_editor']; ?>
<?php echo $this->_var['editor_upload']; ?>
<style type="text/css">
.editor {margin:0px 22px 0px 125px;}
.info_table_wrap .submit {width:720px;}
.info_table {width:720px;}
.info_table li {width:720px;}
</style>
<script type="text/javascript">
$(function(){
    trigger_uploader();
    $('#navigation_form').validate({
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
            title : {
                required   : true
            },
            sort_order : {
                number     : true
            }
        },
        messages : {
            title  : {
                required   : '导航名称不能为空。'
            },
            sort_order : {
                number    : '排序仅能为数字。'
            }
        }
    });
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
            var url = SITE_URL + '/index.php?app=my_navigation&act=drop_uploadedfile';
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

</script>
<style type="text/css">
.padding2{padding-left:25px;}
</style>
<div class="eject_con">
    <div class="info_table_wrap">

        <form method="post" action="index.php?app=my_navigation&amp;act=<?php echo $_GET['act']; ?>&amp;nav_id=<?php echo $this->_var['id']; ?>" target="my_navigation" name="navigation_form" id="navigation_form" enctype="multipart/form-data">
        <div id="warning"></div>
        <ul class="info_table">
            <li>
                <h4>导航名称:</h4>
                <p><input type="text" class="text width_normal" name="title" value="<?php echo htmlspecialchars($this->_var['navigation']['title']); ?>" /></p>
            </li>
            <li>
                <h4>是否显示:</h4>
                <p><?php echo $this->html_radios(array('options'=>$this->_var['yes_or_no'],'checked'=>$this->_var['navigation']['if_show'],'name'=>'if_show')); ?></p>
            </li>
             <li>
                <h4>排序:</h4>
                <p><input type="text" class="text width_short" name="sort_order" value="<?php echo $this->_var['navigation']['sort_order']; ?>"/></p>
            </li>

            <li>
                <h4>内容:</h4>
                <div style="float:left;"><textarea  name="nav_content" id="nav_content" style="width:570px; height:250px;"><?php echo htmlspecialchars($this->_var['navigation']['content']); ?></textarea></div>
            </li>
        </ul>
        <div class="editor">
            <div style="position: relative; top: 10px; z-index: 5;">
                <a class="btn3" id="open_editor_uploader">上传文件</a>
                   <div class="upload_con" id="editor_uploader" style="display:none">
                    <div class="upload_con_top"></div>
                    <div class="upload_wrap">
                     <ul>
                        <li>
                            <div id="divSwfuploadContainer">
                                <div id="divButtonContainer">
                                    <span id="editor_upload_button"></span>
                                </div>
                            </div>
                        </li>
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
            <?php $_from = $this->_var['files_belong_article']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'file');if (count($_from)):
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
</div>