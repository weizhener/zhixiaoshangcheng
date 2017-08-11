<?php echo $this->fetch('member.header.html'); ?>
<style>
.txt {margin-right:20px}
.spec ul {width: 530px; overflow: hidden;}
.spec .td {padding-bottom: 10px;}
.spec li {float: left; margin-left: 6px; display: inline;}
.spec li input {text-align: center;}
.spec .th {padding: 3px 0; margin-bottom: 10px; border-top: 2px solid #e3e3e3; border-bottom: 1px solid #e3e3e3; background: #f8f8f8;}
</style>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $('#start_time input').datepicker({dateFormat: 'yy-mm-dd'});
    $('#end_time input').datepicker({dateFormat: 'yy-mm-dd'});
    if_show();
    //check_spec();
    $('input[name="if_publish"]').click(function(){
        if_show();
    });


    $('#group_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup : false,
        rules : {
            group_name : {
                required   : true
            },
            group_desc : {
                maxlength   : 255
            },
            end_time      : {
                required     : true
            },
            goods_id      : {
                required   :true,
                min    : 1
            },
            min_quantity :{
                required   :true,
                min    :1
            }
        },
        messages : {
            group_name  : {
                required   : '请填写团购名称'
            },
            group_desc  : {
                maxlength   : '团购说明字数不能大于255个'
            },
            end_time       : {
                required     : '请填写结束时间'
            },
            goods_id      : {
                required:  '请先搜索团购商品',
                min   : '请先搜索团购商品'
            },
            min_quantity: {
                required : '请正确填写成团件数',
                min   : '请正确填写成团件数'
            }
        }
    });

});

function gs_callback(){
    query_spec($('#goods_id').val());
}
function if_show(){
    if($('input[name="if_publish"]:checked').val() == 1){
            $('#start_time').hide();
        }else{
            $('#start_time').show();
    }
}

function check_spec(){
    $('input[name="spec_id[]"]').click(function(){
        var obj_group_price = $(this).parent().parent().find('input[name="group_price[]"]')
        if($(this).attr('checked') == true){
            obj_group_price.show();
            obj_group_price.attr('disabled', false);
        }else{
            obj_group_price.hide();
            obj_group_price.attr('disabled', true);
            obj_group_price.val('');
            $('label.error').remove();
        }
    });

    $('#submit_group').unbind('click');
    $('#submit_group').click(function(){
        $('label.error').remove();
        var qty = 0;
        var error = false;
        var price_empty = false;

        $('*[ectype="spec_item"]').each(function(){
            var obj_group_price = $(this).find('input[name="group_price[]"]');
            var group_price = obj_group_price.val();
            var if_checked = $(this).find('input[name="spec_id[]"]').attr('checked');
            if_checked && qty++;
            if(group_price != '' && (group_price < 0 || isNaN(group_price))){
                error = obj_group_price;
            }
            if(if_checked && group_price == ''){
                price_empty = obj_group_price;
            return false;
            }
        })
        if(qty == 0){
            alert('请先勾选团购商品规格');
            return false;
        }
        if(error != false){
            error.focus();
            error.addClass('error');
            error.after('<label class="error" for="group_price[]" generated="true">请正确填写团购价格</label>');
            return false;
        }
        if(price_empty != false){
            price_empty.focus();
            price_empty.addClass('error');
            price_empty.after('<label class="error" for="group_price[]" generated="true">请填写团购价格</label>');
            return false;
        }

    });
}

function query_spec(goods_id){
    $.getJSON('index.php?app=seller_groupbuy&act=query_goods_info',{
        'goods_id':goods_id
        },
        function(data){
            if(data.done){
                var goods = data.retval;
                $('#spec_name').html(goods.spec_name);
                $('ul[ectype="spec_item"]').remove();
                    $.each(goods._specs,function(i,item){
                        $('#group_spec').append('<ul ectype="spec_item" class="td"><li class="distance2"><input name="spec_id[]" value="'+ item.spec_id +'" type="checkbox" checked="checked" />'+ item.spec +'</li><li class="distance1">' + item.stock + '</li><li class="distance1">'+ item.price +'</li><li><input name="group_price[]" type="text" class="text width2" /></li></ul>');
                });
                check_spec();
            }
        });
}
//]]>
</script>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right">
     <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>

        <div id="seller_groupbuy_form" class="wrap">

            <div class="public">
                <form method="post" id="group_form" enctype="multipart/form-data">
                    <div class="information_index">
                        <h4>团购基本信息</h4>
                        <div class="add_wrap">
                            <div class="assort">
                                <p class="txt">活动名称:
                                <input type="text" name="group_name" value="<?php echo htmlspecialchars($this->_var['group']['group_name']); ?>" class="text width7" /> <span class="red">*</span></p>
                            </div>
							<div class="assort">
                                <p class="txt">活动图片:
                                <input type="file" name="group_image" /> <span class="red">*</span>（大小：300像素*200像素）</p>
                                <?php if ($this->_var['group']['group_image']): ?><p><img src="<?php echo $this->_var['group']['group_image']; ?>" width="10" /></p><?php endif; ?>
                            </div>
                            <div class="assort">
                                <p class="txt">
                                    立即发布:
                                    <span class="distance">
                                        <label for="publish"><input id="publish" name="if_publish" value="1" type="radio" <?php if (! $this->_var['group']['group_id']): ?>checked="checked" <?php endif; ?>/> 是</label>
                                        <label for="not_publish"><input id="not_publish" name="if_publish" value="0" type="radio" <?php if ($this->_var['group']['group_id']): ?>checked="checked" <?php endif; ?>/> 否</label> <span class="red">*</span>
                                        <span class="field_notice">如果“立即发布”，除“团购说明”外的信息将不能再被更改</span>
                                    </span>
                                </p>
                            </div>
                            <div class="assort">
                                <p class="txt" id="start_time">
                                    开始时间:
                                    <input name="start_time" value="<?php echo local_date("Y-m-d",$this->_var['group']['start_time']); ?>" type="text" class="text width2" />
                                </p>
                                <p class="txt" id="end_time">
                                    结束时间:
                                    <input name="end_time" value="<?php echo local_date("Y-m-d",$this->_var['group']['end_time']); ?>" type="text" class="text width2" /> <span class="red">*</span>
                                </p>
                            </div>
                            <div class="assort">
                                <p class="txt" id="start_time">
                                    团购说明:
                                    <textarea style="height: 150px; overflow-y: auto; width: 250px; vertical-align: top;" id="group_desc" name="group_desc" class="text"><?php echo htmlspecialchars($this->_var['group']['group_desc']); ?></textarea>
                                </p>
                            </div>
                        </div>

                        <h4>团购商品信息</h4>
                        <div class="add_wrap">

                            <div class="assort">
                                <p class="txt">选择商品:
                                <?php if (! $this->_var['goods']): ?>
                                    <input gs_id="goods_id" gs_name="goods_name" gs_callback="gs_callback" gs_title="gselector" gs_width="480" gs_type="store" gs_store_id="<?php echo $this->_var['store_id']; ?>" ectype="gselector" type="text" name="goods_name" id="goods_name" value="<?php echo htmlspecialchars($this->_var['group']['goods_name']); ?>" class="text" /> <span class="red">*</span>
                                <?php else: ?>
                                    <?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>
                                <?php endif; ?>
                                <input type="hidden" id="goods_id" name="goods_id" value="<?php echo $this->_var['group']['goods_id']; ?>" />
                                </p>
                            </div>
                            <div class="assort">
                                <p class="txt">成团件数:
                                <input type="text" name="min_quantity" value="<?php echo $this->_var['group']['min_quantity']; ?>" class="text width2" /> <span class="red">*</span><span class="field_notice">能完成团购的期望订购件数</span></p>
                            </div>
                            <div class="assort">
                                <p class="txt">每人限购:
                                <input type="text" name="max_per_user" value="<?php echo $this->_var['group']['max_per_user']; ?>" class="text width2" /><span class="field_notice">每个参团者最多能订购的件数，0为不限制</span></p>
                            </div>
                            <div class="assort">
                                <p class="txt" style="float:left">规格价格:
                                </p>
                                    <div id="group_spec" class="spec" style="float:left">
                                        <ul class="th">
                                            <li id="spec_name" class="distance2"><?php if ($this->_var['goods']): ?><?php echo $this->_var['goods']['spec_name']; ?><?php else: ?>规格<?php endif; ?></li>
                                            <li class="distance1">库存</li>
                                            <li class="distance1">原价</li>
                                            <li class="distance1">团购价</li>
                                        </ul>
                                        <?php $_from = $this->_var['goods']['_specs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec']):
?>
                                        <ul ectype="spec_item" class="td">
                                        <li class="distance2"><input name="spec_id[]" value="<?php echo $this->_var['spec']['spec_id']; ?>" type="checkbox"<?php if ($this->_var['spec']['group_price']): ?> checked="checked"<?php endif; ?> /><?php echo $this->_var['spec']['spec']; ?></li>
                                        <li class="distance1"><?php echo $this->_var['spec']['stock']; ?></li>
                                        <li class="distance1"><?php echo $this->_var['spec']['price']; ?></li>
                                        <li><input ectype="group_price" name="group_price[]" type="text" class="text width2" value="<?php echo $this->_var['spec']['group_price']; ?>"/></li>
                                        </ul>
                                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </div>
                            </div>
                            <div class="issuance"><input id="submit_group" type="submit" class="btn" value="提交" /></div>
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