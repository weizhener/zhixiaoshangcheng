<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'mlselection.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'dialog/dialog.js'; ?>" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.ui/jquery.ui.js'; ?>" id="dialog_js" charset="utf-8"></script>
<script type="text/javascript">
                var shippings = <?php echo $this->_var['shippings']; ?>;
                var addresses = <?php echo $this->_var['addresses']; ?>;
                var goods_amount = <?php echo $this->_var['goods_info']['amount']; ?>;
                var goods_quantity = <?php echo $this->_var['goods_info']['quantity']; ?>;
                $(function(){
                    regionInit("region");
                    $('#order_form').validate({
                        invalidHandler:function(e, validator){
                         var err_count = validator.numberOfInvalids();
                         var msg_tpl = '很抱歉，您填写的订单信息中有&nbsp;<strong>{0}</strong>&nbsp;个错误(如红色斜体部分所示)，请检查并修正后再提交！:)';
                         var d = DialogManager.create('show_error');
                         d.setWidth(400);
                         d.setTitle(lang.error);
                         d.setContents('message', {type:'warning', text:$.format(msg_tpl, err_count)});
                         d.show('center');
                        },
                        errorPlacement: function(error, element){
                            var _message_box = $(element).parent().find('.field_message');
                            _message_box.find('.field_notice').hide();
                            _message_box.append(error);
                        },
                        success       : function(label){
                            label.addClass('validate_right').text('OK!');
                        },
                        rules : {
                            consignee : {
                                required : true
                            },
                            region_id : {
                                required : true,
                                min   : 1
                            },
                            address   : {
                                required : true
                            },
                            phone_tel : {
                                required : check_phone,
                                minlength:6,
                                checkTel : true
                            },
                            phone_mob : {
                                required : check_phone,
                                minlength:6,
                                digits : true
                            }
                        },
                        messages : {
                            consignee : {
                                required : '请如实填写您的收货人姓名'
                            },
                            region_id : {
                                required : '请选择所在地区',
                                min  : '请选择所在地区'
                            },
                            address   : {
                                required : '请如实填写收货人详细地址'
                            },
                            phone_tel : {
                                required : '固定电话和手机号码至少填一个',
                                minlength: '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位',
                                checkTel : '电话号码由数字、加号、减号、空格、括号组成,并不能少于6位'
                            },
                            phone_mob : {
                                required : '固定电话和手机号码至少填一个',
                                minlength: '错误的手机号码,只能是数字,并且不能少于6位',
                                digits : '错误的手机号码,只能是数字,并且不能少于6位'
                            }
                        }
                    });

					$('*[ectype="logist_fees"]').live('click', function(){
						fill_order_amount();
					});

					// tyioocom
					fill_order_amount();
                });
				function select_logist_type(){
					fill_order_amount();
				}
                // tyioocom 根据不同的收货地址加载不同的运费情况
				function fill_logist_fee_by_address(addr_id)
				{
					i=1;
					obj = $('div[ectype="logist_fees"]');
					obj.children().remove();
					shipping_data = shippings[addr_id];
					$.each(shipping_data,function(k,v){
						if(i++==1){checked="checked='checked'"} else {checked = '';}
						html = '<ul class="receive_add"> ' +
                        			'<li class="radio"><input type="radio" name="logist_fees" value="'+k+':'+v.logist_fees+'" '+checked+ '/></li>'+
                        			'<li class="pay">'+v.name+'：'+price_format(v.logist_fees)+'</li>'+
                        			'<li class="explain">首件：'+price_format(v.start_fees)+'/'+v.start_standards+'件, 续件：'+price_format(v.add_fees)+'/'+v.add_standards+'件</li>'+
                    			'</ul>';
						obj.append(html);
					});
					fill_order_amount();
				}
				// tyioocom 设置总费用
				function fill_order_amount()
				{
					logist_fee = coupon_value = 0;
					
					logist_info = $('div[ectype="logist_fees"]').find('input:checked').val();
					if(logist_info!='' && logist_info!=undefined){
						logist_info = logist_info.split(':');
						//logist_type = logist_info[0];
						logist_fee  = parseFloat(logist_info[1]);
						//alert(logist_type+':'+logist_fee);
					} else {
						logist_fee = 0;
					}
					$("#order_amount").html(price_format(parseFloat(goods_amount+logist_fee)));
				}
                function check_phone(){
                    return ($('#phone_tel').val() == '' && $('#phone_mob').val() == '');
                }
                function hide_error(){
                    $('#region').find('.error').hide();
                }
                </script>
<script type="text/javascript">
                //<![CDATA[
                $(function(){
                    //$("input[name='address_options']").click(set_address);
                    $('.address_item').click(function(){
                        $(this).find("input[name='address_options']").attr('checked', true);
                        $('.address_item').removeClass('selected_address');
                        $(this).addClass('selected_address');
                        set_address();
						
						// tyioocom 加载该收货地址对应的运费
						var addr_id = $("input[name='address_options']:checked").val();
						fill_logist_fee_by_address(addr_id); 
                    });
                    //init
                    set_address();
                });
                function set_address(){
                    var addr_id = $("input[name='address_options']:checked").val();
                    if(addr_id == 0)
                    {
                        $('#consignee').val("");
                        $('#region_name').val("");
                        $('#region_id').val("");
                        $('#region select').show();
                        $("#edit_region_button").hide();
                        $('#region_name_span').hide();

                        $('#address').val("");
                        $('#zipcode').val("");
                        $('#phone_tel').val("");
                        $('#phone_mob').val("");

                        $('#address_form').show();
                    }
                    else
                    {
                        $('#address_form').hide();
                        fill_address_form(addr_id);
                    }
                }
                function fill_address_form(addr_id){
                    var addr_data = addresses[addr_id];
                    for(k in addr_data){
                        switch(k){
                            case 'consignee':
                            case 'address':
                            case 'zipcode':
                            case 'email':
                            case 'phone_tel':
                            case 'phone_mob':
                            case 'region_id':
                                $("input[name='" + k + "']").val(addr_data[k]);
                            break;
                            case 'region_name':
                                $("input[name='" + k + "']").val(addr_data[k]);
                                $('#region select').hide();
                                $('#region_name_span').text(addr_data[k]).show();
                                $("#edit_region_button").show();
                            break;
                        }
                    }
                }
                //]]>
              </script>
<div id="select-address" class="w mt20">
   <div class="title w mb10">
      <b class="fs14">收货人地址</b>
	  <a href="<?php echo url('app=my_address'); ?>" target="_blank">[管理收货地址]</a>
   </div>
   <?php if ($this->_var['my_address']): ?>
   <div class="oldaddress w">
      <?php $_from = $this->_var['my_address']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'address');$this->_foreach['address_select'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['address_select']['total'] > 0):
    foreach ($_from AS $this->_var['address']):
        $this->_foreach['address_select']['iteration']++;
?>
      <dl class="f66 clearfix address_item<?php if ($this->_foreach['address_select']['iteration'] == 1): ?> selected_address<?php endif; ?>">
         <dt class="float-left"><input id="address_<?php echo $this->_var['address']['addr_id']; ?>" type="radio"<?php if ($this->_foreach['address_select']['iteration'] == 1): ?> checked="true"<?php endif; ?> name="address_options" value="<?php echo $this->_var['address']['addr_id']; ?>" /></dt>
		 <dd class="float-left">
         	<?php echo htmlspecialchars($this->_var['address']['consignee']); ?>
         	<?php echo htmlspecialchars($this->_var['address']['region_name']); ?><?php echo htmlspecialchars($this->_var['address']['address']); ?>
         	<?php if ($this->_var['address']['phone_mob']): ?><?php echo $this->_var['address']['phone_mob']; ?><?php else: ?><?php echo $this->_var['address']['phone_tel']; ?><?php endif; ?>
         </dd>
      </dl>
      <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
   </div>
   <?php endif; ?>
   
                <ul class="fill_in_content" id="address_form">
                    <li>
                        <p class="title">收货人姓名</p>
                        <p class="fill_in"><input type="text" name="consignee" id="consignee" class="text1" /><span class="field_message explain"><span class="field_notice">请填写真实姓名</span></span></p>
                    </li>
                    <li>
                        <p class="title">所在地区</p>
                        <p class="fill_in">
                            <div id="region">
                                <span style="display:none;" id="region_name_span"></span>
                                <input id="edit_region_button" type="button" class="edit_region" value="编辑" style="display:none;" />
                                <select onchange="hide_error();">
                                    <option value="0">请选择...</option>
                                    <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                                </select>
                                <input type="hidden" class="mls_id" name="region_id" id="region_id"/><input type="hidden" name="region_name" class="mls_names" id="region_name"/>
                                <b style="font-weight:normal;" class="field_message explain"><span class="field_notice">请选择地区</span></b>
                            </div>
                        </p>
                    </li>
                    <li>
                        <p class="title">详细地址</p>
                        <p class="fill_in"><input type="text" name="address" id="address" class="text1 width1" /><span class="field_message explain"><span class="field_notice">请填写真实地址，不需要重复填写所在地区</span></span></p>
                    </li>
                    <li>
                        <p class="title">邮政编码</p>
                        <p class="fill_in"><input type="text" name="zipcode" id="zipcode" class="text1" /><span class="field_message explain"><span class="field_notice">邮政编码</span></span></p>
                    </li>
                    <li>
                        <p class="title">电话号码</p>
                        <p class="fill_in"><input type="text" name="phone_tel" id="phone_tel" class="text1" /><span class="field_message explain"><span class="field_notice">固定电话和手机至少填一项</span></span></p>
                    </li>
                    <li>
                        <p class="title">手机号码</p>
                        <p class="fill_in"><input type="text" id="phone_mob" name="phone_mob" class="text1" /><span class="field_message explain"><span class="field_notice">手机和固定电话至少填一项</span></span></p>
                    </li>
                    <li>
                        <p class="title">&nbsp;</p>
                        <p class="fill_in">
                            <label>
                                <input type="checkbox" value="1" id="save_address" name="save_address">&nbsp;自动保存收货地址
                                <span class="explain">&nbsp;(&nbsp;选择后该地址将会保存到您的收货地址列表&nbsp;)&nbsp;</span>
                            </label>
                        </p>
                    </li>
                </ul>

   
<div id="select-shipping" class="mt10">
   <div class="title fs14 strong mb10">选择配送方式</div>
   <div class="content f66">
	
	<?php if ($this->_var['is_free_fee']): ?>
	<ul class="shipping_item">
		<li>
        	<input class="mb5" type="radio" name="is_free_fee" checked="checked" value="1" />
			<?php echo htmlspecialchars($this->_var['shipping_method']['shipping_name']); ?>
			<input type="hidden" name="is_free_fee" value="1" />
			配送费用：<span class="money">&yen; 0.00</span><span class="ml5">(<?php echo htmlspecialchars($this->_var['free_fee_name']); ?>)</span>
		</li>
	</ul>
	<?php else: ?> 
                <div class="fashion_list" ectype="logist_fees">
                    <?php $_from = $this->_var['shipping_methods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'logist');$this->_foreach['fe_logist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_logist']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['logist']):
        $this->_foreach['fe_logist']['iteration']++;
?>
                    <ul class="receive_add">
                        <li class="radio"><input type="radio" name="logist_fees" value="<?php echo $this->_var['key']; ?>:<?php echo $this->_var['logist']['logist_fees']; ?>" <?php if (($this->_foreach['fe_logist']['iteration'] <= 1)): ?> checked="checked"<?php endif; ?> /></li>
                        <li class="pay"><?php echo $this->_var['lang'][$this->_var['key']]; ?>：<?php echo price_format($this->_var['logist']['logist_fees']); ?></li>
                        <li class="explain">首件：<?php echo price_format($this->_var['logist']['start_fees']); ?>/<?php echo $this->_var['logist']['start_standards']; ?>件, 续件：<?php echo price_format($this->_var['logist']['add_fees']); ?>/<?php echo $this->_var['logist']['add_standards']; ?>件</li>
                    </ul>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    
                </div> 
	<?php endif; ?>
   </div> 
</div>
