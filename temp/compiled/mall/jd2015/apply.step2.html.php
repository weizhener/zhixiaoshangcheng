<?php echo $this->fetch('header.html'); ?>
<script src="<?php echo $this->lib_base . "/" . 'mlselection.js'; ?>" charset="utf-8"></script>
<script src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="utf-8"></script>
<style type="text/css">
.d_inline{display:inline;}
</style>
<div class="content">
<script type="text/javascript">
//<!CDATA[
var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";
$(function(){
    regionInit("region");

    $("#apply_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parents('td').next('td');
            error_td.find('.field_notice').hide();
            error_td.find('.fontColor3').hide();
            error_td.append(error);
        },
        success: function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup: false,
        rules: {
            owner_name: {
                required: true
            },
            store_name: {
                required: true,
                remote : {
                    url  : 'index.php?app=apply&act=check_name&ajax=1',
                    type : 'get',
                    data : {
                        store_name : function(){
                            return $('#store_name').val();
                        },
                        store_id : '<?php echo $this->_var['store']['store_id']; ?>'
                    }
                },
                maxlength: 20
            },
			
			 owner_card: {
                required: true,
                number: true,
				byteRange: [18, 18, '<?php echo $this->_var['charset']; ?>'],
              },
			
            tel: {
                required: true,
                minlength:6,
                checkTel:true
            },
            image_1: {
                accept: "jpg|jpeg|png|gif"
            },
            image_2: {
                accept: "jpg|jpeg|png|gif"
            },
            image_3: {
                accept: "jpg|jpeg|png|gif"
            },
            notice: {
                required : true
            }
        },
        messages: {
            owner_name: {
                required: '请输入店主姓名'
            },
            store_name: {
                required: '请输入店铺名称',
                remote: '该店铺名称已存在，请您换一个',
                maxlength: '请控制在20个字以内'
            },
            tel: {
                required: '请输入联系电话',
                minlength: '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位',
                checkTel: '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位'
            },
			
			 owner_card: {
                required: '请填写身份证号码',
                number: '请填写数字',
				byteRange: '长度不够',
             
            },
			
            image_1: {
                accept: '请上传格式为 jpg,jpeg,png,gif 的文件'
            },
            image_2: {
                accept: '请上传格式为 jpg,jpeg,png,gif 的文件'
            },
            image_3: {
                accept: '请上传格式为 jpg,jpeg,png,gif 的文件'
            },
            notice: {
                required: '请阅读并同意开店协议'
            }
        }
    });
});
//]]>
</script>
<div id="main" class="w-full">
<div id="page-apply" class="w mt10 mb20">
   <div class="title border padding5 fs14 strong">
      我要开店
   </div>
   <div class="content border border-t-0 padding10 apply2">
      <form method="post" enctype="multipart/form-data" id="apply_form">
         <table>
           <tr>
              <th>店主姓名：</th>
              <td class="width7"><input type="text" class="input border" name="owner_name" value="<?php echo htmlspecialchars($this->_var['store']['owner_name']); ?>"/></td>
              <td class="padding3"><span class="fontColor3">*</span> <span class="field_notice">请填写真实姓名</span></td>
           </tr>
           <tr>
              <th>身份证号：</th>
              <td><input type="text" class="input border" name="owner_card" value="<?php echo htmlspecialchars($this->_var['store']['owner_card']); ?>" /></td>
              <td class="padding3"> <span class="field_notice">请填写真实准确的身份证号</span></td>
           </tr>
           <tr>
              <th>店铺名称：</th>
              <td><input type="text" class="input border" name="store_name" id="store_name" value="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>"/></td>
              <td class="padding3"><span class="fontColor3">*</span> <span class="field_notice">请控制在20个字以内</span></td>
           </tr>
           <tr>
              <th>所属分类：</th>
              <td>
                 <div class="select_add">
                    <select name="cate_id">
                       <option value="0">请选择...</option>
                       <?php echo $this->html_options(array('options'=>$this->_var['scategories'],'selected'=>$this->_var['scategory']['cate_id'])); ?>
                    </select>
                 </div>
              </td>
              <td></td>
           </tr>
           <tr>
              <th>所在地区：</th>
              <td>
                  <div class="select_add" id="region" style="width:500px;">
                      <input type="hidden" name="region_id" value="<?php echo $this->_var['store']['region_id']; ?>" class="mls_id" />
                      <input type="hidden" name="region_name" value="<?php echo $this->_var['store']['region_name']; ?>" class="mls_names" />
                      <?php if ($this->_var['store']['region_name']): ?>
                      <span><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></span>
                      <input type="button" value="编辑" class="edit_region" />
                      <?php endif; ?>
                      <select class="d_inline"<?php if ($this->_var['store']['region_name']): ?> style="display:none;"<?php endif; ?>>
                         <option value="0">请选择...</option>
                         <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                      </select>
                   </div>
               </td>
               <td></td>
            </tr>
            <tr>
                <th>详细地址：</th>
                <td><input type="text" class="input border" name="address" value="<?php echo htmlspecialchars($this->_var['store']['address']); ?>"/></td>
                <td></td>
            </tr>
          
             <tr>
                 <th>联系电话：</th>
                 <td>
                     <input type="text" class="input border" name="tel"  value="<?php echo htmlspecialchars($this->_var['store']['tel']); ?>"/>
                 </td>
                <td class="padding3"><span class="fontColor3">*</span> <span class="field_notice">请输入联系电话</span></td>
              </tr>
              <tr>
                 <th>上传证件：</th>
                 <td><input type="file" name="image_1" />
                       <?php if ($this->_var['store']['image_1']): ?><p class="d_inline"><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_1']; ?>" target="_blank">查看</a></p><?php endif; ?>
                 </td>
                 <td><span class="field_notice">支持格式jpg,jpeg,png,gif，请保证图片清晰且文件大小不超过400KB</span></td>
              </tr>
              <tr>
                 <th>上传执照：</th>
                 <td><input type="file" name="image_2" />
                     <?php if ($this->_var['store']['image_2']): ?><p class="d_inline"><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_2']; ?>" target="_blank">查看</a></p><?php endif; ?>
                 </td>
                 <td><span class="field_notice">支持格式jpg,jpeg,png,gif，请保证图片清晰且文件大小不超过400KB</span></td>
              </tr>
              <tr>
                 <td colspan="2" class="warning"><p><input type="checkbox"<?php if ($this->_var['store']): ?> checked="checked"<?php endif; ?> name="notice" value="1" id="warning" /> <label for="warning">我已认真阅读并完全同意<a href="index.php?app=article&act=system&code=setup_store" target="_blank">开店协议</a>中的所有条款</label></p></td>
                 <td class="padding3"></td>
              </tr>
              <tr>
                  <td colspan="3"><input class="btn-apply border0 fs14 strong fff pointer" type="submit" value="提交" /></td>
              </tr>
           </table>
       </form>
    </div>
</div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>