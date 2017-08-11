<script type="text/javascript">
//<!CDATA[
$(function(){
	$(".ok").mouseover(function(){
        $(this).next("div").show();
    });
    $(".ok").mouseout(function(){
        $(this).next("div").hide();
    });
    $('#my_recommend_form').validate({
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
            recommend_name : {
                required : true,
                byteRange: ['',100,'<?php echo $this->_var['charset']; ?>']
            }
        },
        messages : {
            recommend_name : {
                required : '推荐类型不能为空. ',
                byteRange: '标题不能超过100个字符. '
            }
        }
    });
});
//]]>
</script>
<ul class="tab">
    <li class="active"><?php if ($_GET['act'] == edit): ?>编辑推荐类型<?php else: ?>新增推荐类型<?php endif; ?></li>
</ul>
<div class="eject_con">
    <div class="adds">
        <div id="warning"></div>
        <form method="post" action="index.php?app=my_recommend&amp;act=<?php echo $_GET['act']; ?><?php if ($_GET['id'] != ''): ?>&amp;id=<?php echo $_GET['id']; ?><?php endif; ?>" target="my_recommend" enctype="multipart/form-data" id="my_recommend_form">
        <ul>
            <li>
                <h3>推荐类型名称:</h3>
                <p><input type="text" class="text width14" name="recommend_name" value="<?php echo htmlspecialchars($this->_var['recommend']['recom_name']); ?>" id="recommend_name" /><b class="strong">*</b></p>
            </li>
        </ul>
        <div class="submit"><input type="submit" class="btn" value="提交" /></div>
        </form>
    </div>
</div>