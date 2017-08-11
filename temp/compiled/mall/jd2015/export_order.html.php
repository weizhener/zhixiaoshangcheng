<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
    $('.checkall_s').click(function(){
        var if_check = $(this).attr('checked');
        $('.checkitem').each(function(){
            if(!this.disabled)
            {
                $(this).attr('checked', if_check);
            }
        });
        $('.checkall_s').attr('checked', if_check);
    });
    $('a[ectype="batchcancel"]').click(function(){
        if($('.checkitem:checked').length == 0){
            return false;
        }
        if($(this).attr('presubmit')){
            if(!eval($(this).attr('presubmit'))){
                return false;
            }
        }
        var items = '';
        $('.checkitem:checked').each(function(){
            items += this.value + ',';
        });
        items = items.substr(0, (items.length - 1));

        var uri = $(this).attr('uri');
        uri = uri + '&' + $(this).attr('name') + '=' + items;
        var id = 'seller_order_cancel_order';
        var title = $(this).attr('dialog_title') ? $(this).attr('dialog_title') : '';
        //var url = $(this).attr('uri');
        var width = '500';
        ajax_form(id, title, uri, width);
    });
});
</script>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="scarch_order">
                <form method="get">
                    <div style="height:150px;">
                        <span class="title">订单编号:</span>
                        <input class="text_normal" type="text" name="order_sn" value="<?php echo htmlspecialchars($this->_var['query']['order_sn']); ?>" />
                        <br><br>
                        <span class="title">添加时间:</span>
                        <input class="text_normal width2" type="text" name="add_time_from" id="add_time_from" value="<?php echo $this->_var['query']['add_time_from']; ?>" />
                        &#8211;
                        <input class="text_normal width2" id="add_time_to" type="text" name="add_time_to" value="<?php echo $this->_var['query']['add_time_to']; ?>" />
                        <br><br>
                        <span class="title">用&nbsp;&nbsp;户&nbsp;&nbsp;名:</span>
                        <input class="text_normal" type="text" name="buyer_name" value="<?php echo htmlspecialchars($this->_var['query']['buyer_name']); ?>" /><br><br>
                        <span class="title">订单类型:</span>
                        <select name="type" id="">
                            <option value="">请选择...</option>
                            <?php echo $this->html_options(array('options'=>$this->_var['ztype'],'selected'=>$this->_var['query']['type'])); ?>
                        </select>

                        <input type="hidden" name="app" value="export_excel" />
                        <input type="hidden" name="act" value="export" />
                        <input type="submit" class="btn" value="导出" />
                    </div>
                    <?php if ($this->_var['query']['buyer_name'] || $this->_var['query']['add_time_from'] || $this->_var['query']['add_time_to'] || $this->_var['query']['order_sn']): ?>
                    <a class="detlink" href="<?php echo url('app=seller_order&type=' . $this->_var['query']['type']. ''); ?>">取消检索</a>
                    <?php endif; ?> </form>

            </div>
            
            <div class="wrap_bottom"></div>
        </div>
    </div>
</div>
<div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>