<script type="text/javascript">
//<!CDATA[
$(function(){
    $('input[ectype="logo"]').change(function(){
            var src = getFullPath($(this)[0]);
            $('img[ectype="logo1"]').attr('src' , src);
            $(this).removeAttr('name');
            $(this).attr('name' , 'logo');
    });
    $(".ok").mouseover(function(){
        $(this).next("div").show();
    });
    $(".ok").mouseout(function(){
        $(this).next("div").hide();
    });
    $('#partner_form').validate({
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
                required : true,
                byteRange: ['',100,'<?php echo $this->_var['charset']; ?>']
            },
            link  : {
                required : true,
                url      : true
            },
            logo  : {
                accept : 'png|jpe?g|gif'
            },
            sort_order : {
                number   : true
            }
        },
        messages : {
            title : {
                required : '请填写合作伙伴标题. ',
                byteRange: '标题不能超过100个字符. '
            },
            link  : {
                required : '填写合作伙伴的链接地址. ',
                url      : '链接地址无效. '
            },
            logo  : {
                accept   : '只接受图片文件gif, jpg, jpeg, png. '
            },
            sort_order  : {
                number   : '只能使用数字. '
            }
        }
    });
});
//]]>
</script>
<div class="eject_con">
    <div class="adds">
        <div id="warning"></div>
        <form method="post" action="index.php?app=my_partner&amp;act=<?php echo $_GET['act']; ?><?php if ($_GET['partner_id'] != ''): ?>&amp;partner_id=<?php echo $_GET['partner_id']; ?><?php endif; ?>" target="my_partner" enctype="multipart/form-data" id="partner_form">
        <ul>
            <li>
                <h3>标题:</h3>
                <p><input type="text" class="text width14" name="title" value="<?php echo htmlspecialchars($this->_var['partner']['title']); ?>"/><b class="strong">*</b></p>
            </li>
            <li>
                <h3>链接:</h3>
                <p><input type="text" class="text width14" name="link" value="<?php echo $this->_var['partner']['link']; ?>" /><b class="strong">*</b></p>
            </li>
            <li>
                <h3>排序:</h3>
                <p><input type="text" class="text width1" name="sort_order" value="<?php echo $this->_var['partner']['sort_order']; ?>" /><span>排序,只能是数字,值越大越靠后</span></p>
            </li>
            <li>
                <h3>标识:</h3>
                <div class="sign_box">
                    <div class="sign_con">
                        <div class="sign"><img src="<?php if ($this->_var['partner']['logo']): ?><?php echo $this->_var['partner']['logo']; ?><?php else: ?>data/system/no_pic.gif<?php endif; ?>" width="150" height="50" alt="" ectype="logo1"/></div>
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
        </ul>
        <div class="submit"><input type="submit" class="btn" value="提交" /></div>
        </form>
    </div>
</div>