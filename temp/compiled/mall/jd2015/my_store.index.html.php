<?php echo $this->fetch('member.header.html'); ?>
<style>
.information .info table{width :auto;}
</style>
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
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
    <div class="wrap">
        <div class="public">
            <div class="information">
            <form method="post" enctype="multipart/form-data" id="my_store_form">
                    <div class="setup">
                        <div class="photo relative1">
                            <p><img src="<?php if ($this->_var['store']['store_logo'] != ''): ?><?php echo $this->_var['store']['store_logo']; ?><?php else: ?>data/system/default_store_logo.gif<?php endif; ?>" width="120" height="120" ectype="store_logo" /></p>
                            <b>
                            	<input ectype="change_store_logo" type="file" name="file" size="1" hidefocus="true" maxlength="0" style="display:block;z-index:10; position:absolute;width: 120px; *width:0px; height: 28px; cursor: hand; cursor: pointer;  opacity:0; filter: alpha(opacity=0);">
                                <div class="txt" style="position:absolute;z-index:9">更换店标</div>
                            </b>
                            <span class="explain">此处为您的店铺标志，将显示在店铺信息栏里建议尺寸100*100像素</span>
                        </div>        
                        
                        <div class="photo relative2">
                            <p><img src="<?php if ($this->_var['store']['store_banner'] != ''): ?><?php echo $this->_var['store']['store_banner']; ?><?php else: ?><?php echo $this->res_base . "/" . 'images/member/banner.gif'; ?><?php endif; ?>" width="480" height="120" ectype="store_banner" /></p>
                            <b>
                                <input ectype="change_store_banner" type="file" name="file" size="1" hidefocus="true" maxlength="0" style="display:block;z-index:10; position:absolute;width: 120px; *width:0px; height: 28px; cursor: hand; cursor: pointer;  opacity:0; filter: alpha(opacity=0);">
                                <span class="txt">更换店铺条幅</span>
                            </b>
                            <span class="explain">此处为您的店铺条幅，将显示在店铺导航上方的banner位置，建议尺寸1000*120像素</span>
                        </div>
                        
                        <?php if ($this->_var['store']['qrcode_image']): ?>
                        <div class="photo relative1">
							<p style=" margin-left:10px;"><img width="120" height="120" src="<?php echo $this->_var['store']['qrcode_image']; ?>" /></p>
                        	<span style=" margin-left:30px;">店铺二维码</span>
                        </div>
                        <?php endif; ?>
                        
                        <div class="clear"></div>
                    </div>
                    <div class="setup info shop">

                        <table style="width: 100%">
                            <?php if ($this->_var['subdomain_enable']): ?>
                            <tr>
                              <th>二级域名:</th>
                              <td><input type="text" name="domain" value="<?php echo htmlspecialchars($this->_var['store']['domain']); ?>"<?php if ($this->_var['store']['domain']): ?> disabled<?php endif; ?> class="text width11" />&nbsp;<?php if (! $this->_var['store']['domain']): ?>可留空,注意！设置后将不能修改，域名长度应为:<?php echo $this->_var['domain_length']; ?><?php else: ?><?php endif; ?></td>
                            </tr>
                            <?php endif; ?>
                            <tr>
                                <th class="width2">店铺名称:</th>
                                <td>
                                    <p class="td_block"><input id="store_name" type="text" class="text width_normal" name="store_name" value="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>"/><label class="field_notice">店铺名称</label></p>
                                    <b class="padding1">*</b><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" target="_blank" class="btn1">我的店铺首页</a>
                                </td>
                            </tr>
                            
                             <tr>
                                <th class="width2">店铺二维码:</th>
                                <td>
                                    <p class="td_block"><input id="qrcode_image" type="file" class="text width_normal" name="qrcode_image" /></p>
                                </td>
                            </tr>
                            
                            <tr>
                                <th>所在地区:</th>
                                <td><div id="region">
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
                                    <?php endif; ?></div>
                                </td>
                            </tr>
                            <tr>
                                <th>详细地址:</th>
                                <td>
                                    <p class="td_block"><input type="text" name="address" class="text width_normal" id="address" value="<?php echo htmlspecialchars($this->_var['store']['address']); ?>" /><span class="field_notice">不必重复填写所在地区</span></p>
                                </td>
                            </tr>
                            <tr>
                                <th>联系电话:</th>
                                <td><input name="tel" type="text" class="text width_normal" id="tel" value="<?php echo htmlspecialchars($this->_var['store']['tel']); ?>" /></td>
                            </tr>
                            <tr>
                                  <th>联系QQ:</th>
                                  <td><input name="im_qq" type="text" class="text width_normal" id="im_qq" value="<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>" /></td>
                            </tr>
                           
                            <tr>
                                  <th>营业时间:</th>
                                  <td>
                                      <input name="service_begin" type="text" class="text width_short" id="service_begin" value="<?php echo htmlspecialchars($this->_var['store']['service_begin']); ?>" />
                                      -
                                      <input name="service_end" type="text" class="text width_short" id="service_end" value="<?php echo htmlspecialchars($this->_var['store']['service_end']); ?>" />
                                  </td>
                            </tr>
                            <tr>
                                  <th>到达时间:</th>
                                  <td>
                                      <input name="service_arrive" type="text" class="text width_short" id="service_arrive" value="<?php echo htmlspecialchars($this->_var['store']['service_arrive']); ?>" />
                                      <span class="field_notice">分钟</span>
                                  </td>
                            </tr>
                            <tr>
                                  <th>人均消费:</th>
                                  <td>
                                      <input name="service_consumption" type="text" class="text width_short" id="service_consumption" value="<?php echo htmlspecialchars($this->_var['store']['service_consumption']); ?>" />
                                      <span class="field_notice">元</span>
                                  </td>
                            </tr>

                            <?php if ($this->_var['store']['functions']['enable_free_fee']): ?>
                             <tr>
                                  <th>满金额包邮:</th>
                                  <td><input name="amount_for_free_fee" type="text" class="text width_normal" id="amount_for_free_fee" value="<?php echo htmlspecialchars($this->_var['store']['amount_for_free_fee']); ?>" /><span class="field_notice">购买商品的总金额大于该数值即可以免除运费</span></td>
                             </tr>
                             <tr>
                                  <th>满数量包邮:</th>
                                  <td><input name="acount_for_free_fee" type="text" class="text width_normal" id="acount_for_free_fee" value="<?php echo htmlspecialchars($this->_var['store']['acount_for_free_fee']); ?>" /><span class="field_notice">购买商品的总数量大于该数值即可以免除运费</span></td>
                             </tr>
                             <?php endif; ?>
                             
                             <?php if ($this->_var['store']['functions']['enable_radar']): ?>
                             
                             <tr>
                                  <th>启用商品雷达:</th>
                                  <td><label>
					                 <input type="radio" name="enable_radar" value="1" <?php if ($this->_var['store']['enable_radar']): ?>checked="checked"<?php endif; ?> />
					                是</label>
					                <label>
					                <input type="radio" name="enable_radar" value="0" <?php if (! $this->_var['store']['enable_radar']): ?>checked="checked"<?php endif; ?> />
					                否</label></td>
                             </tr>
                             
                             <?php endif; ?>
                             <tr>
                                <th class="align3">店铺简介:</th>
                                <td><div class="editor"><div>
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
                                    <div class="issuance"><input type="submit" class="btn" value="提交" /></div>
                                 </td>
                             </tr>
                         </table>
                    	</div>
          			</form>
                </div>

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