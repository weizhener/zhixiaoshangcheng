<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">店铺设置</div>
    <a href="javascript" class="r_b"></a>
</div>
<script type="text/javascript">
//<!CDATA[
$(function(){
        $('input[ectype="change_store_logo"]').change(function(){
            var src = getFullPath($(this)[0]);
            $('img[ectype="store_logo"]').attr('src', src);
            $('input[ectype="change_store_logo"]').removeAttr('name');
            $(this).attr('name', 'store_logo');
        });
        $('input[ectype="change_store_banner"]').change(function(){
            var src = getFullPath($(this)[0]);
            $('img[ectype="store_banner"]').attr('src', src);
            $('input[ectype="change_store_banner"]').removeAttr('name');
            $(this).attr('name', 'store_banner');
        });

        $('#my_store_form').validate({
            errorPlacement: function(error, element){
                $(element).next('.field_notice').hide();
                if($(element).parent().parent().is('b'))
                {
                    $(element).parent().parent('b').next('.explain').hide();
                    $(element).parent().parent('b').after(error);
                }
                else
                {
                    $(element).after(error);
                }
            },
            success       : function(label){
                if($(label).attr('for') != 'store_logo' && $(label).attr('for') != 'store_banner'  ){
                    label.addClass('validate_right').text('OK!');
                    }
            },
            rules : {
                store_name : {
                    required   : true,
                    remote : {
                        url  : 'index.php?app=apply&act=check_name&ajax=1',
                        type : 'get',
                        data : {
                            store_name : function(){
                                return $('#store_name').val();
                            },
                            store_id : <?php echo $this->_var['store']['store_id']; ?>
                        }
                    },
                    maxlength: 20
                },
                tel      : {
                    required     : true,
                    checkTel     : true
                },
                store_banner : {
                    accept   : 'png|jpe?g|gif'
                },
                store_logo   : {
                    accept   : 'png|jpe?g|gif'
                }
            },
            messages : {
                store_name  : {
                    required   : '此项不允许为空',
                    remote: '店铺名称已经存在，请换一个',
                    maxlength: '请控制在20个字以内'
                },
                tel      : {
                    required   : '此项不允许为空',
                    checkTel   : '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位'
                },
                store_banner : {
                    accept  : '请上传格式为 jpg,jpeg,png,gif 的文件'
                },
                store_logo  : {
                    accept : '请上传格式为 jpg,jpeg,png,gif 的文件'
                }
            }
    });
   regionInit("region");
        $(".right").mouseover(function(){
            $(this).next("div").show();
        });
        $(".right").mouseout(function(){
            $(this).next("div").hide();
        });
});
function add_uploadedfile(file_data)
{
        $('#desc_images').append('<li file_name="'+ file_data.file_name +'" file_path="'+ file_data.file_path +'" ectype="handle_pic" file_id="'+ file_data.file_id +'"><input type="hidden" name="desc_file_id[]" value="'+ file_data.file_id +'"><div class="pic" style="z-index: 2;"><img src="<?php echo $this->_var['site_url']; ?>/'+ file_data.file_path +'" width="50" height="50" alt="'+ file_data.file_name +'" /></div><div ectype="handler" class="bg" style="z-index: 3;display:none"><img src="<?php echo $this->_var['site_url']; ?>/'+ file_data.file_path +'" width="50" height="50" alt="'+ file_data.file_name +'" /><p class="operation"><a href="javascript:void(0);" class="cut_in" ectype="insert_editor" ecm_title="插入编辑器"></a><span class="delete" ectype="drop_image" ecm_title="删除"></span></p><p class="name">'+ file_data.file_name +'</p></div></li>');
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
            var url = SITE_URL + '/index.php?app=my_store&act=drop_uploadedfile';
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
<?php echo $this->_var['editor_upload']; ?>
<?php echo $this->_var['build_editor']; ?>
<style>
    .my_store{margin:10px 16px;}
    .form_content .edit_region {width: 100%;height: 38px;display: block;text-align: center;background: #fefefe;background: linear-gradient(to bottom,#fefefe,#f5f5f5);background: -moz-linear-gradient(top, #fefefe,#f5f5f5);background: -webkit-gradient(linear, 0 0, 0 100%, from(#fefefe), to(#f5f5f5));border: #ddd solid 1px;border-radius: 3px;color: #333;}
</style>
<div class="my_store">
    <form name="my_store" method="post"  enctype="multipart/form-data" id="my_store_form">
        <ul class="form_content">
            <li>
                <h3>店铺名称:</h3>
                <p><input id="store_name" type="text"   name="store_name" value="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>" /></p>
            </li>
            <li>
                <h3>店铺名称:</h3>
                <p>
                    <img src="<?php if ($this->_var['store']['store_logo'] != ''): ?><?php echo $this->_var['store']['store_logo']; ?><?php else: ?>data/system/default_store_logo.gif<?php endif; ?>" width="120" height="120" ectype="store_logo" />
                    <input name="store_logo" type="file"/>
                </p>
                <p></p>
            </li>
            <li>
                <h3>所在地区:</h3>
                <p id="region">
                    <input type="hidden" name="region_id" value="<?php echo $this->_var['store']['region_id']; ?>" class="mls_id" />
                    <input type="hidden" name="region_name" value="<?php echo htmlspecialchars($this->_var['store']['region_name']); ?>" class="mls_names" />
                    <?php if ($this->_var['store']['store_id']): ?>
                    <span><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></span>
                    <input type="button" value="编辑" class="edit_region" />
                    <select style="display:none">
                        <option>请选择...</option>
                        <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                    </select>
                    <?php else: ?>
                    <select class="select">
                        <option>请选择...</option>
                        <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                    </select>
                    <?php endif; ?>
                </p>
            </li>
            <li>
                <h3>详细地址:</h3>
                <p><input id="address" type="text"   name="address" value="<?php echo htmlspecialchars($this->_var['store']['address']); ?>" /></p>
            </li>
            <li>
                <h3>联系电话:</h3>
                <p><input id="tel" type="text"   name="tel" value="<?php echo htmlspecialchars($this->_var['store']['tel']); ?>" /></p>
            </li>
            
            <li>
                <h3>联系QQ:</h3>
                <p><input id="im_qq" type="text"   name="im_qq" value="<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>" /></p>
            </li>
            <li>
                <h3>阿里旺旺:</h3>
                <p><input id="im_ww" type="text"   name="im_ww" value="<?php echo htmlspecialchars($this->_var['store']['im_ww']); ?>" /></p>
            </li>
            <li>
                <h3>满金额包邮:</h3>
                <p><input name="amount_for_free_fee" type="text" id="amount_for_free_fee" value="<?php echo htmlspecialchars($this->_var['store']['amount_for_free_fee']); ?>" /></p>
            </li>
            <li>
                <h3>满数量包邮:</h3>
                <p><input name="acount_for_free_fee" type="text" id="acount_for_free_fee" value="<?php echo htmlspecialchars($this->_var['store']['acount_for_free_fee']); ?>" /></p>
            </li>
            
            
            <li>
                <h3>店铺简介:</h3>
                <p>
                <div class="editor"><div  style="width:100%;overflow: scroll">
                        <textarea name="description" id="description" style="width:100%; height:350px;"><?php echo htmlspecialchars($this->_var['store']['description']); ?></textarea></div>
                    <div style=" position: relative; top: 10px; z-index: 5;"><a class="btn3" id="open_editor_uploader">上传图片</a>
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
                                    <li id="open_editor_remote" class="btn4">远程地址</li>
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
                        <?php $_from = $this->_var['files_belong_store']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'file');if (count($_from)):
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
                </p>
            </li>
            
        </ul>
        <input class="red_btn" type="submit" value="提交" />
    </form>
</div>

<?php echo $this->fetch('member.footer.html'); ?>