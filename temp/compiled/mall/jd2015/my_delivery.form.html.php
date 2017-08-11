<?php echo $this->fetch('member.header.html'); ?>
<div class="content clearfix">
	<div class="totline"></div>
	<div class="botline"></div>
  	<?php echo $this->fetch('member.menu.html'); ?>
	<div id="right">
    	<?php echo $this->fetch('member.submenu.html'); ?>
		<div class="wrap">
			<div class="eject_btn_two eject_pos1" title="添加运费模板"><b class="ico1" onclick="go('index.php?app=my_delivery&amp;act=add');">添加运费模板</b></div>
			<div class="public_select table">
				<div class="info2">
					<form method="post" id="delivery_template">
						<table class="infoTable" align="center">
							<tr>
								<td align="left" width="200" height="25">模板名称：</td>
                				<td align="left"><input type="text" name="name" class="input template_name" value="<?php echo htmlspecialchars($this->_var['delivery']['name']); ?>" /></td>
            				</tr>
            				<tr>
								<td align="left" width="200" height="25">运送方式：</td>
               					<td align="left"><p class="gray">除指定地区外，其余地区的运费采用"默认运费"</p></td>
            				</tr>
            				<tr>
            					<td></td>
                				<td>
                					<div class="section-list">
                        				<?php $_from = $this->_var['delivery']['area_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('type', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['type'] => $this->_var['item']):
?>
                    					<div class="section mb10">
											<p>
                             					<input type="hidden" name="template_types[]"  value="<?php echo $this->_var['type']; ?>" id="input_<?php echo $this->_var['type']; ?>" checked="checked"/>
												<label for="input_<?php echo $this->_var['type']; ?>"><?php echo $this->_var['lang'][$this->_var['type']]; ?></label>
											</p>
											<div class="postage-detail" id="<?php echo $this->_var['type']; ?>">
                            					<div class="default_fee">
                                					<label>默认运费：</label>
                                    				<input type="hidden" name="<?php echo $this->_var['type']; ?>_dests[]" value="1" />
                                    				<input type="text" class="input" value="<?php echo $this->_var['item']['default_fee']['start_standards']; ?>" name="<?php echo $this->_var['type']; ?>_start[]" />
                                    				<label>件内，</label>
                                   					<input type="text" class="input" value="<?php echo $this->_var['item']['default_fee']['start_fees']; ?>" name="<?php echo $this->_var['type']; ?>_postage[]" /> 
                                    				<label>元，</label>
                                    				<label>每增加</label>
                                    				<input type="text" class="input" value="<?php echo $this->_var['item']['default_fee']['add_standards']; ?>" name="<?php echo $this->_var['type']; ?>_plus[]" />
                                    				<label>个，</label>
                                    				<label>增加运费</label>
                                    				<input type="text" class="input" value="<?php echo $this->_var['item']['default_fee']['add_fees']; ?>" name="<?php echo $this->_var['type']; ?>_postageplus[]" />
                                    				<label>元</label>
                                				</div>
                                				<div class="other_fee">
                                					<div class="fee_list">
                                    					<?php if ($this->_var['item']['other_fee']): ?>
                                    					<table border="0" cellpadding="0" cellspacing="0">
				 											<thead>
																<tr>
																	<th class="cell-area">运送到</th>
																	<th>首件(个)</th>
																	<th>首费(元)</th>
																	<th>续件(个)</th>
																	<th>续费(元)</th>
																	<th>操作</th>
																</tr>
															</thead>
															<tbody>
                                            					<?php $_from = $this->_var['item']['other_fee']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'fee');$this->_foreach['fe_fee'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_fee']['total'] > 0):
    foreach ($_from AS $this->_var['fee']):
        $this->_foreach['fe_fee']['iteration']++;
?>
                                            					<tr>
				 													<td class="cell-area">
																		<div class="selected_area J_SelectedAreaName"><?php echo $this->_var['fee']['dests']; ?></div>
																		<input type="hidden" group="dests" name="<?php echo $this->_var['type']; ?>_dests[]" value="<?php echo $this->_var['fee']['dest_ids']; ?>" />
                                                        					<a href="javascript:;" gs_id="gselector-delivery-<?php echo $this->_var['type']; ?><?php echo $this->_foreach['fe_fee']['iteration']; ?>" gs_name="delivery_name" gs_callback="gs_callback" gs_title="编辑运费模板" gs_width="660" gs_type="delivery" gs_store_id="" ectype="gselector" gs_opacity="0.05" gs_class="simple-blue" name="gselector-delivery" id="gselector-delivery" class="btn-add-product">编辑</a>
																	</td>
																	<td><input type="text" class="input" value="<?php echo $this->_var['fee']['start_standards']; ?>" name="<?php echo $this->_var['type']; ?>_start[]" /></td>
																	<td><input type="text" class="input" value="<?php echo $this->_var['fee']['start_fees']; ?>" name="<?php echo $this->_var['type']; ?>_postage[]" /></td>
																	<td><input type="text" class="input" value="<?php echo $this->_var['fee']['add_standards']; ?>" name="<?php echo $this->_var['type']; ?>_plus[]" /></td>
																	<td><input type="text" class="input" value="<?php echo $this->_var['fee']['add_fees']; ?>" name="<?php echo $this->_var['type']; ?>_postageplus[]" /></td>
																	<td><a href="javascript:;" class="del_area" type="<?php echo $this->_var['type']; ?>">删除</a></td>
				 												</tr>
                                                				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                             				</tbody>
                                          				</table>
                                        				<?php endif; ?>
                                    				</div>
                                					<p class="add_area" type="<?php echo $this->_var['type']; ?>">为指定地区城市设置运费</p>
                                				</div>
                            				</div>
										</div>
                        				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        
                        				<?php $_from = $this->_var['delivery']['plus_type']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>																																																																	 										<div class="section">
											<p>
												<input type="hidden" name="template_types[]"  value="<?php echo $this->_var['item']; ?>" id="input_<?php echo $this->_var['item']; ?>"/>
                                				<label for="input_<?php echo $this->_var['item']; ?>"><?php echo $this->_var['lang'][$this->_var['item']]; ?></label>
											</p>
											<div class="postage-detail" id="<?php echo $this->_var['item']; ?>">
                            					<div class="default_fee">
                                					<label>默认运费：</label>
                                    				<input type="hidden" name="<?php echo $this->_var['item']; ?>_dests[]" value="1" />
                                    				<input type="text" class="input" value="1" name="<?php echo $this->_var['item']; ?>_start[]" /> <label>件内，</label>
                                    				<input type="text" class="input" value="10" name="<?php echo $this->_var['item']; ?>_postage[]" /> <label>元，</label>
                                    				<label>每增加</label>
                                    				<input type="text" class="input" value="1" name="<?php echo $this->_var['item']; ?>_plus[]" /> <label>件，</label>
                                    				<label>增加运费</label>
                                    				<input type="text" class="input" value="0" name="<?php echo $this->_var['item']; ?>_postageplus[]" /> <label>元</label>
                                				</div>
                                				<div class="other_fee">
                                					<div class="fee_list"></div>
                                    				<p class="add_area" type="<?php echo $this->_var['item']; ?>">为指定地区城市设置运费</p>
                                				</div>
                            				</div>
										</div>
                        				<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
                   					</div>                 
                				</td>
           					</tr>
           					<tr>
            					<td></td>
               					<td height="50"><span class="btn-alipay"><input type="submit" value="提交" class="submit" /></span></td>
           					</tr>
        				</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>