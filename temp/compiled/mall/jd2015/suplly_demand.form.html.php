<?php echo $this->fetch('member.header.html'); ?>
<style>
.add_wrap .assort .txt{float:left; padding:0; line-height:26px;}
.assort h3,.add_bewrite h3{width:70px; text-align:right; float:left; padding-right:10px; font-size:12px; font-weight:normal; line-height:26px; color:#646665;}
.add_wrap{margin-bottom:0;}
.add_bewrite{padding-top:0;}
.editor{margin:0;}
.add_bewrite .add_wrap{float:left; width:668px;}
</style>
<script type="text/javascript">
//<!CDATA[
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
            var url = SITE_URL + '/index.php?app=supply_demand&act=drop_uploadedfile';
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

$(function(){
	sdcategoryInit("sdcategory");
	regionInit("region");
    $('#suplly_demand_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup : false,
        rules : {
			cate_id : {
                required   : true
            },
			title : {
                required   : true
            },
			region_id : {
                required   : true
            },
            phone      : {
                required     : true
            },
            name      : {
                required   :true
            }
        },
        messages : {
            cate_id       : {
                required     : '此项不能为空'
            },
            title      : {
                required:  '此项不能为空'
            },
			region_id      : {
                required:  '此项不能为空'
            },
			phone      : {
                required:  '此项不能为空'
            },
			name      : {
                required:  '此项不能为空'
            }
        }
    });
	$("[name='type']").change(function(){
		if(this.value==1){
			$("[ectype='demand']").hide();
			$("[ectype='supply']").show();
		}
		else{
			$("[ectype='demand']").show();
			$("[ectype='supply']").hide();
		}
	});
	

});
//]]>
</script>
<?php echo $this->_var['editor_upload']; ?>
<?php echo $this->_var['build_editor']; ?>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right">
     <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public">
                <form method="post" id="suplly_demand_form" enctype="multipart/form-data">
                    <div class="information_index">
                        <div class="add_wrap">
                        	<div class="assort">
                            	<h3>信息类型:</h3>
                            	<p class="txt">
                                <input type="radio" name="type" <?php if ($this->_var['info']['type'] == 1 || $this->_var['info']['type'] == 0): ?>checked<?php endif; ?> value="1" />
          <label>供应</label>&nbsp;&nbsp;
          <input type="radio" name="type" value="2" <?php if ($this->_var['info']['type'] == 2): ?>checked<?php endif; ?> />
          <label>求购</label>
                                <span class="red">*</span>
                                </p>
                            </div>
                            <div class="assort">
                            	<h3>所属分类:</h3>
                            	<p class="select" id="sdcategory">
                                	<?php if ($this->_var['info']['cate_id']): ?>
                                    <span><?php echo htmlspecialchars($this->_var['info']['cate_name']); ?></span>
                                    <input type="button" value="编辑" class="edit_gcategory" />
                                    <select style="display:none">
                                        <option>请选择...</option>
                                        <?php echo $this->html_options(array('options'=>$this->_var['sdcategories'])); ?>
                                    </select>
                                    <?php else: ?>
                                    <select>
                                        <option>请选择...</option>
                                        <?php echo $this->html_options(array('options'=>$this->_var['sdcategories'])); ?>
                                    </select>
                                    <?php endif; ?>
                                    <input type="hidden" id="cate_id" name="cate_id" value="<?php echo $this->_var['info']['cate_id']; ?>" class="mls_sdid" />
                                    <input type="hidden" id="cate_name" name="cate_name" value="<?php echo $this->_var['info']['cate_name']; ?>" class="mls_sdnames" />
                                    <span class="red">*</span><span class="field_notice">选择信息分类</span>
                                </p>
                            </div>
                            <div class="assort" ectype="demand" style="display:none;">
                            	<h3>求购价格:</h3>
                                <p class="txt">
                                <input type="text" class="text width_short" name="price_from" value="<?php echo $this->_var['info']['price_from']; ?>"/>
                                -
                                <input type="text" class="text width_short" name="price_to" value="<?php echo $this->_var['info']['price_to']; ?>"/>&nbsp;&nbsp;元
                                </p>
                            </div>
                            <div class="assort" ectype="supply">
                            	<h3>价格:</h3>
                                <p class="txt">
                                <input type="text" name="price" value="<?php echo $this->_var['info']['price']; ?>" class="text width_short" />&nbsp;&nbsp;元</p>
                            </div>
                            <div class="assort">
                            	<h3>标题:</h3>
                                <p class="txt">
                                <input type="text" name="title" value="<?php echo htmlspecialchars($this->_var['info']['title']); ?>" class="text width7" /><span class="red">*</span></p>
                            </div>
                            <div class="assort">
                            	<h3>所在地区:</h3>
                            	<p class="select" id="region">

                                    <?php if ($this->_var['info']['region_id']): ?>
                                    <span><?php echo htmlspecialchars($this->_var['info']['region_name']); ?></span>
                                    <input type="button" value="编辑" class="edit_region" />
                                    <select style="display:none">
                                      <option>请选择...</option>
                                      <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                                    </select>
                                    <?php else: ?>
                                    <select>
                                      <option>请选择...</option>
                                      <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                                    </select>
                                    <?php endif; ?>
                                    <input type="hidden" name="region_id" value="<?php echo $this->_var['info']['region_id']; ?>" class="mls_id" />
                                    <input type="hidden" name="region_name" value="<?php echo htmlspecialchars($this->_var['info']['region_name']); ?>" class="mls_names" />
                                    <span class="red">*</span>
                                </p>
                            </div>
                            <div class="assort">
                            	<h3>手机或电话:</h3>
                                <p class="txt">
                                <input type="text" name="phone" value="<?php echo htmlspecialchars($this->_var['info']['phone']); ?>" class="text width5" /> <span class="red">*</span></p>
                            </div>
                            <div class="assort">
                            	<h3>联系人:</h3>
                                <p class="txt">
                                <input type="text" name="name" value="<?php echo htmlspecialchars($this->_var['info']['name']); ?>" class="text width5" /> <span class="red">*</span></p>
                            </div>
                        </div>

                        <div class="add_bewrite">
                            <h3>详细说明:</h3>
                            <div class="add_wrap">
                                <div class="editor">
                                    <div>
                                    <textarea name="content" id="description"  style="width:100%; height:300px;">
                                    <?php echo htmlspecialchars($this->_var['info']['content']); ?>
                                    </textarea>
                                    </div>
                                    <?php if ($this->_var['is_store']): ?>
                                    <div style=" position: relative; top: 10px; z-index: 5;"><a class="btn3" id="open_editor_uploader">上传文件</a>
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
                                        
                                    </ul>
                                    <?php endif; ?>
                                    <div class="clear"></div>
                                </div>
                                <div class="issuance"><input type="submit" class="btn" value="提交" /></div>
                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>