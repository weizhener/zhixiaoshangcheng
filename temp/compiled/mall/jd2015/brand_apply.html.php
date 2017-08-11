<script type="text/javascript">
//<!CDATA[
$(function(){
    $('input[ectype="logo"]').change(function(){
            var src = getFullPath($(this)[0]);
            $('img[ectype="logo1"]').attr('src' , src);
            $(this).removeAttr('name');
            $(this).attr('name' , 'brand_logo');
    });
    $(".ok").mouseover(function(){
        $(this).next("div").show();
    });
    $(".ok").mouseout(function(){
        $(this).next("div").hide();
    });
    $('#brand_apply_form').validate({
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
            brand_name : {
                required : true,
                byteRange: ['',100,'<?php echo $this->_var['charset']; ?>']
            },
            brand_logo  : {
                required : true,
                accept : 'jpe?g|png|gif'
            }
        },
        messages : {
            brand_name : {
                required : '品牌名称不能为空. ',
                byteRange: 'brand_maxlength_error. '
            },
            brand_logo  : {
                required : '品牌图标不能为空',
                accept   : '图标类型不允许。. '
            }
        }
    });
});
//]]>
</script>
<div class="eject_con">
    <div class="adds">
        <div id="warning"></div>
        <form method="post" action="index.php?app=my_goods&act=<?php echo $_GET['act']; ?><?php if ($_GET['id'] != ''): ?>&id=<?php echo $_GET['id']; ?><?php endif; ?>" target="my_goods" enctype="multipart/form-data" id="brand_apply_form">
        <ul>
            <li>
                <h3>品牌名称:</h3>
                <p><input type="text" class="text width14" name="brand_name" value="<?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?>" id="brand_name" /><b class="strong">*</b></p>
            </li>
            <li>
                <h3>类别:</h3>
                <p><input type="text" class="text width14" name="tag" value="<?php echo htmlspecialchars($this->_var['brand']['tag']); ?>" /></p>
            </li>
            <li>
                <h3>品牌图标:</h3>
                <div class="sign_box">
                    <div class="sign_con">
                        <div class="sign"><img src="<?php if ($this->_var['brand']['brand_logo']): ?><?php echo $this->_var['brand']['brand_logo']; ?><?php else: ?>data/system/no_pic.gif<?php endif; ?>" width="150" height="50" alt="<?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?>" ectype="logo1"/></div>
                        <div class="upload_pic">
                            <span class="file1"><input type="file" size="1" maxlength="0" hidefocus="true" ectype="logo"/></span>
                            <span class="file2"><input type="file" size="1" maxlength="0" hidefocus="true" ectype="logo"/></span>
                            <div class="txt">图片上传</div>
                        </div>
                    </div>
                    <div class="sign_con">
                        <span class="color5"></span><br />
                        <span class="color7"></span>
                    </div>
                </div>
            </li>
            <li>
               <span class="field_notice">申请品牌的目的是方便买家通过品牌索引页查找商品，申请时请填写品牌所属的类别，方便站长归类。在站长审核前，您可以编辑或撤销申请。</span>
            </li>
        </ul>
        <div class="submit"><input type="submit" class="btn" value="提交" /></div>
        </form>
    </div>
</div>