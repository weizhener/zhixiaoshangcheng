<?php echo $this->fetch('header.html'); ?>



<div class="mb-head">

    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>

    <div class="tit">申请开店</div>

    <a href="javascript" class="r_b"></a>

</div>

<script type="text/javascript">

    //<!CDATA[

    var SITE_URL = "<?php echo $this->_var['site_url']; ?>";

    var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";

    $(function() {

        regionInit("region");



        $("#apply_form").validate({

            errorPlacement: function(error, element) {

                element.append(error);

            },

            success: function(label) {

                label.addClass('validate_right').text('OK!');

            },

            onkeyup: false,

            rules: {

                owner_name: {

                    required: true

                },

                store_name: {

                    required: true,

                    remote: {

                        url: 'index.php?app=apply&act=check_name&ajax=1',

                        type: 'get',

                        data: {

                            store_name: function() {

                                return $('#store_name').val();

                            },

                            store_id: '<?php echo $this->_var['store']['store_id']; ?>'

                        }

                    },

                    maxlength: 20

                },

                tel: {

                    required: true,

                    minlength: 6,

                    checkTel: true

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

                    required: true

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

<style>

    .apply_form{border-radius: 5px;position: relative;border: #aaa solid 1px;background: #fff;overflow: hidden;color: #6b6b6b;margin: 10px;font-size: 14px;padding:10px;}

    .apply_form li{width:100%;}

    .apply_form h2 {text-align:left;font-size: 12px;height: 30px;line-height: 30px;}

    .apply_form input[type="text"] {margin:6px 0;padding: 5px 0px;border: #ccc solid 1px;color: #777;width:100%;}

    .apply_form select {border: 1px solid #A7A6AA;height:30px;padding: 1px;line-height:30px;margin-right: 2px;width:100%;margin:5px 0;}

    .apply_form .btn{width: 100%;padding: 8px 0;background: #b00005;background: linear-gradient(to bottom,#9f0207,#b00005);background: -moz-linear-gradient(top, #9f0207,#b00005);background: -webkit-gradient(linear, 0 0, 0 100%, from(#9f0207), to(#b00005));border: #8d0303 solid 1px;border-radius: 3px;color: #fff;}

</style>

<div class="apply_form">

    <form method="post" enctype="multipart/form-data" id="apply_form">

        <ul>

            <li>

                <h2>店主姓名</h2>

                <div class="arrange"><input type="text" class="text" name="owner_name" value="<?php echo htmlspecialchars($this->_var['store']['owner_name']); ?>"/></div>

            </li>

            <li>

                <h2>身份证号</h2>

                <div class="arrange"><input type="text" class="text" name="owner_card" value="<?php echo htmlspecialchars($this->_var['store']['owner_card']); ?>"></div>

            </li>

            <li>

                <h2>店铺名称</h2>

                <div class="arrange"><input type="text" class="text" name="store_name" id="store_name" value="<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>"/></div>

            </li>

            <li>

                <h2>所属分类</h2>

                <div class="arrange">

                    <select name="cate_id">

                        <option value="0">请选择...</option>

                        <?php echo $this->html_options(array('options'=>$this->_var['scategories'],'selected'=>$this->_var['scategory']['cate_id'])); ?>

                    </select>

                </div>

            </li>

            <li>

                <h2>所在地区</h2>

                <div class="arrange" id="region">

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

            </li>

            

            <li>

                <h2>详细地址</h2>

                <div class="arrange"><input type="text" class="text" name="address" value="<?php echo htmlspecialchars($this->_var['store']['address']); ?>"/></div>

            </li>

            <li>

                <h2>邮政编码</h2>

                <div class="arrange"><input type="text" class="text" name="zipcode" value="<?php echo htmlspecialchars($this->_var['store']['zipcode']); ?>"/></div>

            </li>

            <li>

                <h2>联系电话</h2>

                <div class="arrange"><input type="text" class="text" name="tel"  value="<?php echo htmlspecialchars($this->_var['store']['tel']); ?>"/></div>

            </li>

            <li>

                <h2>上传证件 </h2>

                <div class="arrange"><input type="file" name="image_1" /><?php if ($this->_var['store']['image_1']): ?><p style="display:inline;"><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_1']; ?>" >查看</a></p><?php endif; ?></div>

            </li>

            <li>

                <h2>上传执照</h2>

                <div class="arrange"><input type="file" name="image_2" /><?php if ($this->_var['store']['image_2']): ?><p style="display:inline;"><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_2']; ?>" >查看</a></p><?php endif; ?></div>

            </li>

            <li>

                <div class="arrange" style="margin:10px 0;"><input type="checkbox"<?php if ($this->_var['store']): ?> checked="checked"<?php endif; ?> name="notice" value="1" id="warning" /> <label for="warning">我已认真阅读并完全同意<a href="index.php?app=article&act=system&code=setup_store" target="_blank">开店协议</a>中的所有条款</label></div>

            </li>

        </ul>

        <input class="btn" type="submit" value="申请" />

    </form>

</div>













<?php echo $this->fetch('footer.html'); ?>