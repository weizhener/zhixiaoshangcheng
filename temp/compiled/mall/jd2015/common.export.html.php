<script type="text/javascript">
$(function(){
        $('#cancel_button').click(function(){
            DialogManager.close('my_category_export');
         });
});
</script>
<div class="content1">
<form method="post" action="index.php?app=my_category&amp;act=export" target="seller_order">
    <dl style="line-height: 22px;">
        <dt><?php echo $this->_var['note_for_export']; ?>:</dt>
        <dd style="padding-top: 10px;">
            <div class="li"><label><input type="radio" name="if_convert" value="1" checked="checked" /> 是</label></div>
            <div class="li"><label><input type="radio" name="if_convert" value="0" />否</label></div>
        </dd>
    </dl>
    <div class="btn">
        <input type="submit" id="confirm_button" class="btn1" value="确认" />
        <input type="button" id="cancel_button" class="btn2" value="取消" />
    </div>
</form>    
</div>