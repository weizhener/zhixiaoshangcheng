<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">商品管理</div>
    <a href="javascript" class="r_b"></a>
</div>
<div style="overflow-x:hidden;">
<?php echo $this->_var['images_upload']; ?>
<?php echo $this->_var['editor_upload']; ?>
<?php echo $this->_var['build_editor']; ?>
<script type="text/javascript">
//<!CDATA[
    var SPEC = <?php echo $this->_var['goods']['spec_json']; ?>;

    function add_uploadedfile(file_data)
    {
        if (file_data.instance == 'goods_image') {
            $('#goods_images').append('<li ectype="handle_pic" file_id="' + file_data.file_id + '" thumbnail="<?php echo $this->_var['site_url']; ?>/' + file_data.thumbnail + '"><input type="hidden" value="' + file_data.file_id + '" name="goods_file_id[]"/><div class="pic"><img src="<?php echo $this->_var['site_url']; ?>/' + file_data.thumbnail + '" width="55" height="55" alt="" /><div ectype="handler" class="bg"><p class="operation"><span class="cut_in" ectype="set_cover" ecm_title="设为封面"></span><span class="delete" ectype="drop_image" ecm_title="删除"></span></p></div></div></li>');
            trigger_uploader();
            if ($('#big_goods_image').attr('src') == '<?php echo $this->_var['goods']['default_goods_image']; ?>') {
                set_cover(file_data.file_id);
            }
            if (GOODS_SWFU.getStats().files_queued == 0) {
                window.setTimeout(function() {
                    $('#uploader').hide();
                    $('#open_uploader').find('.show').attr('class', 'hide');
                }, 4000);
            }
        } else if (file_data.instance == 'desc_image') {
            $('#desc_images').append('<li file_name="' + file_data.file_name + '" file_path="' + file_data.file_path + '" ectype="handle_pic" file_id="' + file_data.file_id + '"><input type="hidden" name="desc_file_id[]" value="' + file_data.file_id + '"><div class="pic" style="z-index: 2;"><img src="<?php echo $this->_var['site_url']; ?>/' + file_data.file_path + '" width="50" height="50" alt="' + file_data.file_name + '" /></div><div ectype="handler" class="bg" style="z-index: 3;display:none"><img src="<?php echo $this->_var['site_url']; ?>/' + file_data.file_path + '" width="50" height="50" alt="' + file_data.file_name + '" /><p class="operation"><a href="javascript:void(0);" class="cut_in" ectype="insert_editor" ecm_title="插入编辑器"></a><span class="delete" ectype="drop_image" ecm_title="删除"></span></p><p class="name">' + file_data.file_name + '</p></div></li>');
            trigger_uploader();
            if (EDITOR_SWFU.getStats().files_queued == 0) {
                window.setTimeout(function() {
                    $('#editor_uploader').hide();
                }, 5000);
            }
        }
    }


    function set_cover(file_id) {
        if (typeof(file_id) == 'undefined') {
            $('#big_goods_image').attr('src', '<?php echo $this->_var['goods']['default_goods_image']; ?>');
            return;
        }
        var obj = $('*[file_id="' + file_id + '"]');
        $('*[file_id="' + file_id + '"]').clone(true).prependTo('#goods_images');
        $('*[ectype="handler"]').hide();
        $('#big_goods_image').attr('src', obj.attr('thumbnail'));
        obj.remove();
    }

    $(function() {
        $('#goods_form').validate({
            errorPlacement: function(error, element) {
                $(element).next('.field_notice').hide();
                $(element).after(error);
            },
            success: function(label) {
                label.addClass('validate_right').text('OK!');
            },
            onkeyup: false,
            rules: {
                goods_name: {
                    required: true
                },
                price: {
                    number: true,
                    required: true,
                    min: 0
                },
                stock: {
                    digits: true
                },
                cate_id: {
                    remote: {
                        url: 'index.php?app=my_goods&act=check_mgcate',
                        type: 'get',
                        data: {
                            cate_id: function() {
                                return $('#cate_id').val();
                            }
                        }
                    }
                }
            },
            messages: {
                goods_name: {
                    required: '商品名称不能为空'
                },
                price: {
                    number: '此项仅能为数字',
                    required: '价格不能为空',
                    min: '价格必须大于或等于零'
                },
                stock: {
                    digits: '此项仅能为数字'
                },
                cate_id: {
                    remote: '请选择商品分类（必须选到最后一级）'
                }
            }
        });

        // init cover
        set_cover($("#goods_images li:first-child").attr('file_id'));

        // init spec
        spec_update();
    });
//]]>



/* 创建规格编辑器 */
function spec_editor(){
    var hide_drop_button = function ()
    {
        $('#dialog_object_spec_editor').find('*[ectype="drop_spec_item"]').show();
        $('#dialog_object_spec_editor').find('*[ectype="drop_spec_item"]:first').hide();
    }

    /* 规格名称 */
    $('*.[ectype="spec_editor"]').find('*[col="spec_name_1"]').val(SPEC.spec_name_1);
    $('*.[ectype="spec_editor"]').find('*[col="spec_name_2"]').val(SPEC.spec_name_2);

    /* 初始化规格项 */
    $('*.[ectype="spec_editor"]').find('*[ectype="data"]').remove(); // 移除所有规格项
    var d_spec_item = $('*.[ectype="spec_editor"]').find('*[ectype="spec_item"]'); // 规格项模板
    d_spec_item.hide(); // 隐藏模板
    var spec_item; // 规格项目json数组
    if(SPEC.spec_qty ==0){
        spec_item = ['','']; // 如果没有规格则显示两行空白规格项
    }else{
        spec_item = SPEC.specs;
    }
    spec_item && $.each(spec_item,function(i,item){ // 遍历生成规格项
        var tpl = d_spec_item.clone(true); // 克隆一个规格项
        tpl.attr('ectype', 'data'); // 赋值一个ectype与规格项模板区别
        item.spec_1 && tpl.find('*[item="spec_1"]').val(item.spec_1);
        item.spec_2 && tpl.find('*[item="spec_2"]').val(item.spec_2);
        tpl.find('*[item="price"]').val(item.price);
        tpl.find('*[item="stock"]').val(item.stock);
        tpl.find('*[item="sku"]').val(item.sku);
        tpl.find('*[item="spec_id"]').val(item.spec_id);
        tpl.show();
        d_spec_item.before(tpl); // 将克隆的规格项放到模板前面，新增的规格项能按正序排列
    });

    // 创建规格编辑对话框
    var _d = DialogManager.create('spec_editor');
    _d.setTitle($('*[ectype="dialog_contents"]').attr('dialog_title'));
    _d.setContents($('*[ectype="dialog_contents"]').children().clone(true));
    _d.setStyle('add_spec');
    //_d.setStyle({'padding' : '0'});
    _d.setWidth(320);
    //ScreenLocker.style.opacity = 0;
    _d.show('center');
    hide_drop_button();

    // 添加规格项
    $('*[ectype="add_spec_item"]').unbind('click');
    $('*[ectype="add_spec_item"]').click(function(){
        var new_spec = $('#dialog_object_spec_editor').find('*[ectype="data"]:last').clone(true);
        new_spec.find('input[item="spec_id"]').val('');
        new_spec.insertAfter($('#dialog_object_spec_editor').find('*[ectype="data"]:last'));
        hide_drop_button();
    });

    // 删除规格项
    $('*[ectype="drop_spec_item"]').click(function(){
        $('#dialog_object_spec_editor').find('*[ectype="data"]').length > 1 && $(this).parent().parent().remove();
        hide_drop_button();
    });

    // 规格项排序
    $('*[ectype="up_spec_item"]').click(function(){
        var prev = $(this).parent().parent().prev('*[ectype="data"]').clone(true);
        $(this).parent().parent().prev('*[ectype="data"]').remove();
        $(this).parent().parent().after(prev);
        hide_drop_button();
    });
    $('*[ectype="down_spec_item"]').click(function(){
        var prev = $(this).parent().parent().next('*[ectype="data"]').clone(true);
        $(this).parent().parent().next('*[ectype="data"]').remove();
        $(this).parent().parent().before(prev);
        hide_drop_button();
    });

    // 保存规格名称和规格项
    $('*[ectype="save_spec"]').unbind('click');
    $('*[ectype="save_spec"]').click(function(){

        var bak_spec =  SPEC; // 备份

        /* 保存规格名称 */
        var spec_name_1 = $.trim($('#dialog_object_spec_editor').find('*[col="spec_name_1"]').val());
        var spec_name_2 = $.trim($('#dialog_object_spec_editor').find('*[col="spec_name_2"]').val());

        /* 规格名称是否重复和为空 */
        if(!spec_name_1 && !spec_name_2){
            alert(lang.get('spec_name_required'));
            return;
        }else{
            if(spec_name_1 == spec_name_2){
                alert(lang.get('duplicate_spec_name') + '\n' + '[' + spec_name_1+ ']');
                return;
            }
        }
        SPEC = {};
        SPEC.spec_name_1 = spec_name_1;
        SPEC.spec_name_2 = spec_name_2;

        /* 保存规格数量 */
        if(SPEC.spec_name_1 && SPEC.spec_name_2){
            SPEC.spec_qty = "2";
        }else if(!SPEC.spec_name_1 && !SPEC.spec_name_2){
            SPEC.spec_qty = "0"; // 这种情况不会出现，因前面为空检查已经返回
        }else{
            SPEC.spec_qty = "1";
        }

        /* 保存规格项 */
        var arr_spec_name = new Array(); // 累积规格项名称。检查重复
        var spec_duplicate = new Array(); // 重复的规格项
        var price_error = new Array();
        var complate = true; // 是否完成
        SPEC.specs = [];
        $('#dialog_object_spec_editor').find('*[ectype="data"]').each(function(){
            var spec_1 = SPEC.spec_name_1 ? $.trim($(this).find('*[item="spec_1"]').val()) : null;
            var spec_2 = SPEC.spec_name_2 ? $.trim($(this).find('*[item="spec_2"]').val()) : null;
            var price = $.trim($(this).find('*[item="price"]').val());
            var stock = $.trim($(this).find('*[item="stock"]').val());
            var sku = $.trim($(this).find('*[item="sku"]').val());
            var spec_id = $.trim($(this).find('*[item="spec_id"]').val());

            var valid = (spec_1 || spec_2) ? true : false; // 该行数据是否有效

            if(SPEC.spec_qty == 1){ // 一个规格
                var spec_pos = SPEC.spec_name_1 ? 1 : 2;
                eval('if(spec_' + spec_pos + ' || (!spec_' + spec_pos + ' && !price && !stock && !sku)){}else{complate = false;}');
            }else{ // 两个规格
                if((spec_1 && spec_2) || (!spec_1 && !spec_2 && !price && !stock && !sku)){

                }else{
                    complate = false;
                }
            }

            var item = [spec_1,spec_2].join(';');
            if($.inArray(item, arr_spec_name) > -1){
                if($.inArray(item, spec_duplicate) == -1){
                    spec_duplicate.push(item);
                }
            }else{
                item != ';' && arr_spec_name.push(item);
            }
            /* 判断价格非法 */
            if(isNaN(price) || price <0 || !price){
                valid && price_error.push(item);
            }
            item != ';' && SPEC.specs.push({
                'spec_1':spec_1,
                'spec_2':spec_2,
                'price':number_format(price, 2),
                'stock':number_format(stock, 0),
                'sku':sku,
                'spec_id':spec_id
                });
        });
        if(arr_spec_name.length == 0){
                complate = false;
        }
        if(complate == false){
            alert(lang.get('spec_not_complate'));
            SPEC = {};
            SPEC = bak_spec; // 还原备份
            return;
        }
        if(spec_duplicate.length>0){
            var spec_msg = '';
            $.each(spec_duplicate,function(i,val){
                spec_msg += val + '\n';
            });

            alert(lang.duplicate_spec + '\n' + spec_msg);
            SPEC = {};
            SPEC = bak_spec; // 还原备份
            return;
        }
        /* 判断价格 */
        if(price_error.length>0){
            var msg = lang.follow_spec_price_invalid + '\n';
            $.each(price_error,function(i,val){
                msg += val + '\n';
            });

            alert(msg);
            SPEC = {};
            SPEC = bak_spec; // 还原备份
            return;
        }

        // 更新显示规格项
        spec_update();

        DialogManager.close('spec_editor');

    });
}
</script>
<body class="gray" style="overflow-x:hidden;">
    <div class="w320">

        
        <div class="user_header">
            <div class="user_photo">
                <a href="<?php echo url('app=member'); ?>"><img src="<?php echo $this->res_base . "/" . 'images/user.jpg'; ?>" /></a>
            </div>
            <span class="user_name">
        您好,欢迎<?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?><br/>
        <a href="index.php?app=member&act=logout" style="color:#999;">退出</a>
            </span>
            <div class="order_panel">
                <ul class="orders">
                    <a href="<?php echo url('app=my_goods'); ?>">
                        <li style="width:43%;">
                            <span class="num"></span>
                            <span>全部商品</span>
                        </li>
                    </a>
                    <a href="<?php echo url('app=my_goods&act=add'); ?>">
                        <li style="width:43%;">
                            <span class="num on "></span>
                            <span>新增商品</span>
                            <b></b>
                        </li>
                    </a>
                </ul>
            </div>
        </div>

        <div class="w320">
            <form method="post" id="goods_form">
                <div class="add_spec" dialog_title="编辑商品规格" ectype="dialog_contents" style="display: none">
                    <!--<form>-->
                    <p>您最多可以添加两种规格（如：颜色和尺码）规格名称可以自定义<br/>如只有一项规格另一项留空</p>
                    <div class="table" ectype="spec_editor">
                        <ul class="th">
                            <li><input col="spec_name_1" type="text" class="text width4" /></li>
                            <li><input col="spec_name_2" type="text" class="text width4" /></li>
                            <li class="distance3">价格</li>
                            <li class="distance3">库存</li>
                            <li class="distance3">货号</li>
                            <li class="distance3">操作</li>
                        </ul>
                        <ul class="td" ectype="spec_item">
                            <li><input item="spec_1" type="text" class="text width4" /></li>
                            <li><input item="spec_2" type="text" class="text width4" /></li>
                            <li><input item="price" type="text" class="text width4" /></li>
                            <li><input item="stock" type="text" class="text width4" /></li>
                            <li><input item="sku" type="text" class="text width4" /><input item="spec_id" type="hidden" /></li>
                            <li class="padding3">
                                <span ectype="up_spec_item" class="up_btn"></span>
                                <span ectype="down_spec_item" class="down_btn"></span>
                                <span ectype="drop_spec_item" class="delete_btn"></span>
                            </li>
                        </ul>
                        <ul>
                            <li class="add"><a href="javascript:;" ectype="add_spec_item" class="add_link">添加新的规格属性</a></li>
                        </ul>
                    </div>
                    <div class="btn_wrap"><input ectype="save_spec" type="submit" class="btn" value="保存规格" /></div>
                    <!--</form>-->
                </div>

                <div class="wapwrap">
                    <div class="add_wrap">
                        <div class="assort">
                            <p class="txt">商品分类: </p>
                            <p class="select" id="gcategory">
                                <?php if ($this->_var['goods']['cate_id']): ?>
                                <span class="f_l"><?php echo htmlspecialchars($this->_var['goods']['cate_name']); ?></span>
                                <a class="edit_gcategory btn" href="javascript:;">编辑</a>
                                <select style="display:none">
                                    <option>请选择...</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['mgcategories'])); ?>
                                </select>
                                <?php else: ?>
                                <select>
                                    <option>请选择...</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['mgcategories'])); ?>
                                </select>
                                <?php endif; ?>
                                <input type="hidden" id="cate_id" name="cate_id" value="<?php echo $this->_var['goods']['cate_id']; ?>" class="mls_id" />
                                <input type="hidden" name="cate_name" value="<?php echo htmlspecialchars($this->_var['goods']['cate_name']); ?>" class="mls_names" />
                            </p>
                        </div>
                        <div class="assort">
                            <p class="txt">本店分类: </p>
                            <p class="select">
                                <?php if ($this->_var['goods']['_scates']): ?>
                                <?php $_from = $this->_var['goods']['_scates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgcate');if (count($_from)):
    foreach ($_from AS $this->_var['sgcate']):
?>
                                <select name="sgcate_id[]" class="sgcategory">
                                    <option value="0">请选择...</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['sgcategories'],'selected'=>$this->_var['sgcate']['cate_id'])); ?>
                                </select>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                <?php else: ?>
                                <select name="sgcate_id[]" class="sgcategory">
                                    <option value="0">请选择...</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['sgcategories'])); ?>
                                </select>
                                <?php endif; ?>
                            </p>
                            <p class="new_add">
                                <a href="javascript:;" id="add_sgcategory" class="btn">新增分类</a>
                                <span>可以从属于多个本店分类</span>
                            </p>
                        </div>
                    </div>



                    <div class="add_wrap">
                        <div class="pic_list">
                            <div class="big_pic"><img id="big_goods_image" src="<?php echo $this->_var['goods']['default_goods_image']; ?>" width="300" height="300" alt="" /></div>
                            <div class="small_pic">
                                <ul id="goods_images">
                                    <?php $_from = $this->_var['goods_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods_iamge');if (count($_from)):
    foreach ($_from AS $this->_var['goods_iamge']):
?>
                                    <li ectype="handle_pic" file_id="<?php echo $this->_var['goods_iamge']['file_id']; ?>" thumbnail="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods_iamge']['thumbnail']; ?>">
                                        <input type="hidden" name="goods_file_id[]" value="<?php echo $this->_var['goods_iamge']['file_id']; ?>">
                                        <div class="pic">
                                            <img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods_iamge']['thumbnail']; ?>" width="55" height="55" />
                                            <div ectype="handler" class="bg">
                                                <p class="operation">
                                                    <span class="cut_in" ectype="set_cover" ecm_title="设为封面"></span>
                                                    <span class="delete" ectype="drop_image" ecm_title="删除"></span>
                                                </p>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </ul>
                                <div class="clear"></div>
                            </div>
                            <div class="upload_btn">
                                <div class="upload" id="open_uploader"><b class="hide">上传商品图片</b></div>
                                <div class="upload_con" id="uploader" style="display:none">
                                    <div class="upload_con_top"></div>
                                    <div class="upload_wrap">
                                        <ul>
                                            <li class="btn1">
                                                <div id="divSwfuploadContainer">
                                                    <div id="divButtonContainer">
                                                        <span id="spanButtonPlaceholder"></span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li><iframe src="index.php?app=comupload&act=view_iframe&id=<?php echo $this->_var['id']; ?>&belong=<?php echo $this->_var['belong']; ?>&instance=goods_image" width="86" height="30" scrolling="no" frameborder="0"></iframe></li>
                                            <li id="open_remote" class="btn2">远程地址</li>
                                        </ul>
                                        <div id="remote" class="upload_file" style="display:none">
                                            <iframe src="index.php?app=comupload&act=view_remote&id=<?php echo $this->_var['id']; ?>&belong=<?php echo $this->_var['belong']; ?>&instance=goods_image" width="272" height="39" scrolling="no" frameborder="0"></iframe>
                                        </div>
                                        <div id="goods_upload_progress"></div>
                                        <div class="upload_txt">
                                            <span>支持JPEG和静态的GIF格式图片，不支持GIF动画图片，上传图片大小不能超过2M.浏览文件时可以按住ctrl或shift键多选</span>
                                        </div>

                                    </div>
                                    <div class="upload_con_bottom"></div>
                                </div>
                            </div>
                        </div>
                    </div>
<br><br><br><br><br>
                    <div class="add_wrap">
                        <div class="products">
                            <ul>
                                <li>
                                    <h2>商品名称: </h2>
                                    <div class="arrange"><input title="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" type="text" name="goods_name" value="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" class="text width_normal" /><span class="red">*</span></div>
                                </li>
                                <li>
                                    <h2>品牌: </h2>
                                    <div class="arrange"><input type="text" name="brand" value="<?php echo htmlspecialchars($this->_var['goods']['brand']); ?>" class="text width_normal" /></div>
                                </li>
                                <li>
                                    <h2>标签(TAG): </h2>
                                    <div class="arrange"><input type="text" name="tags" value="<?php echo htmlspecialchars($this->_var['goods']['tags']); ?>" class="text width_normal" />
                                    </div>
                                </li>
                                <li>
                                     <h2>市场价: </h2>
                                     <div class="arrange"><input type="text" name="market_price" value="<?php echo $this->_var['goods']['market_price']; ?>" class="text width_normal" /></div>
                                </li>
                                <li>
                                    <h2  ectype="no_spec">价格: </h2>
                                    <div class="arrange"  ectype="no_spec"><input name="spec_id" value="<?php echo $this->_var['goods']['_specs']['0']['spec_id']; ?>" type="hidden" /><input name="price" value="<?php echo $this->_var['goods']['_specs']['0']['price']; ?>" type="text" class="text width_short" /></div>
                                </li>
                                <?php if ($this->_var['goods']['integral_enabled']): ?>
                                <li>
                                    <h2>抵扣积分:</h2>
                                    <div class="arrange"><input name="integral_max_exchange" value="<?php echo $this->_var['goods']['integral_max_exchange']; ?>" type="text" class="text width_short" /><span class="gray">设置允许买家最多可使用多少积分抵扣价款,抵扣金额为:积分×比例,设置为0时,不使用积分抵扣,当前系统设置积分抵扣比例为:<?php echo $this->_var['goods']['integral_seller']; ?></span></div>
                                </li>
                                <?php endif; ?>
                                <li ectype="no_spec">
                                    <h2>库存: </h2>
                                    <div class="arrange"><input name="stock" value="<?php echo $this->_var['goods']['_specs']['0']['stock']; ?>" type="text" class="text width_short" /></div>
                                </li>
                                <li ectype="no_spec">
                                    <h2>货号: </h2>
                                    <div class="arrange"><input name="sku" value="<?php echo $this->_var['goods']['_specs']['0']['sku']; ?>" type="text" class="text width_normal" /></div>
                                </li>

                                <li>
                                    <h2>规格: </h2>
                                    <div class="arrange">
                                        <div class="box_arr" ectype="no_spec">
                                            <p class="pos_btn"><a ectype="add_spec" href="javascript:;" class="add_btn">开启规格</a></p>
                                            <p class="pos_txt">您最多可以添加两种商品规格（如：颜色，尺码）如商品没有规格则不用添加</p>
                                        </div>
                                        <div class="box_arr" ectype="has_spec"  style="display: none;">
                                            <table ectype="spec_result">
                                                <tr>
                                                    <th col="spec_name_1">loading..</th>
                                                    <th col="spec_name_2">loading..</th>
                                                    <th col="price">价格</th>
                                                    <th col="stock">库存</th>
                                                    <th col="sku">货号</th>
                                                </tr>
                                                <tr ectype="spec_item" style="display:none">
                                                    <td item="spec_1"></td>
                                                    <td item="spec_2"></td>
                                                    <td item="price"></td>
                                                    <td item="stock"></td>
                                                    <td item="sku"></td>
                                                </tr>
                                            </table>
                                            <p class="table_btn">
                                                <a ectype="edit_spec" href="javascript:;" class="add_btn edit_spec">编辑规格</a>
                                                <a ectype="disable_spec" href="javascript:;" class="add_btn disable_spec">关闭规格</a>
                                            </p>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <h2>上架: </h2>
                                    <div class="arrange">
                                        <span class="distance">
                                            <label style="width:130px;display: block;float: left"><input name="if_show" value="1" type="radio" <?php if ($this->_var['goods']['if_show']): ?>checked="checked" <?php endif; ?>/> 是</label>
                                            <label style="width:130px;display: block;float: left"><input name="if_show" value="0" type="radio" <?php if (! $this->_var['goods']['if_show']): ?>checked="checked" <?php endif; ?>/> 否</label>
                                        </span>
                                    </div>
                                </li>
                                <li>
                                    <h2>推荐: </h2>
                                    <div class="arrange">
                                        <span class="distance">
                                            <label style="width:130px;display: block;float: left"><input name="recommended" value="1" <?php if ($this->_var['goods']['recommended']): ?>checked="checked" <?php endif; ?>type="radio" /> 是</label>
                                            <label style="width:130px;display: block;float: left"><input name="recommended" value="0" <?php if (! $this->_var['goods']['recommended']): ?>checked="checked" <?php endif; ?>type="radio" /> 否</label>
                                        </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="clear"></div>
                    <div class="add_bewrite">
                        <h5>商品描述</h5>
                        <div class="add_wrap">
                            <div class="editor">
                                <div style="width:320;overflow: scroll">
                                    <textarea name="description" id="description"  style="width:100%; height:400px;">
                                    <?php echo htmlspecialchars($this->_var['goods']['description']); ?>
                                    </textarea>
                                </div>
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
                                    <?php $_from = $this->_var['desc_images']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'desc_image');if (count($_from)):
    foreach ($_from AS $this->_var['desc_image']):
?>
                                    <li ectype="handle_pic" file_name="<?php echo htmlspecialchars($this->_var['desc_image']['file_name']); ?>" file_path="<?php echo $this->_var['desc_image']['file_path']; ?>" file_id="<?php echo $this->_var['desc_image']['file_id']; ?>">
                                        <input type="hidden" name="desc_file_id[]" value="<?php echo $this->_var['desc_image']['file_id']; ?>">
                                        <div class="pic">
                                            <img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['desc_image']['file_path']; ?>" width="50" height="50" alt="<?php echo htmlspecialchars($this->_var['desc_image']['file_name']); ?>" title="<?php echo htmlspecialchars($this->_var['desc_image']['file_name']); ?>" /></div>
                                        <div ectype="handler" class="bg">
                                            <a ectype="insert_editor" href="javascript:void(0);" ecm_title="插入编辑器"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['desc_image']['file_path']; ?>" width="50" height="50" alt="<?php echo htmlspecialchars($this->_var['desc_image']['file_name']); ?>" title="<?php echo htmlspecialchars($this->_var['desc_image']['file_name']); ?>" /></a>
                                            <p class="operation">
                                                <a class="cut_in" ectype="insert_editor" href="javascript:void(0);" ecm_title="插入编辑器"></a>
                                            </p>
                                            <p title="<?php echo htmlspecialchars($this->_var['desc_image']['file_name']); ?>" class="name"><a ectype="insert_editor" href="javascript:void(0);" ecm_title="插入编辑器">点击插入图片</a></p>
                                        </div>
                                    </li>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                </ul>
                                <div class="clear"></div>
                            </div><br><br>
                            <div class="issuance"><input type="submit" class="btn" value="提交" /></div>
                        </div>
                    </div>
            </form>
        </div>
    </div>




    <div class="page">
        <?php echo $this->fetch('member.page.bottom.html'); ?>
    </div>
</div>
</div>
<?php echo $this->fetch('member.footer.html'); ?>