<?php echo $this->fetch('member.header.html'); ?>
<style>
.member_no_records {border-top: 0px !important;}
.table td{padding-left: 5px;}
</style>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right">
    	<?php echo $this->fetch('member.curlocal.html'); ?>
		<?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public_select table">
                <table>
                    <tr class="line_bold">
                        <th colspan="7">
                            <div class="select_div clearfix" style="padding-top:0;margin-bottom:20px;">
                            	<form method="get" class="fleft">
                            	<div>
                           			<input type="text" class="text_normal" name="group_name" value="<?php echo htmlspecialchars($_GET['group_name']); ?>"/>
                            		<select name="state">
                            			<?php echo $this->html_options(array('options'=>$this->_var['state'],'selected'=>$_GET['state'])); ?>
                            		</select>
                           			<input type="hidden" name="app" value="buyer_groupbuy" />
                            		<input type="hidden" name="act" value="index" />
                            		<input type="submit" class="btn" value="搜索" />
                            	</div>
                            	</form>
                                <?php if ($this->_var['filtered']): ?>
                            	<a class="detlink" href="<?php echo url('app=buyer_groupbuy'); ?>">取消检索</a>
                            	<?php endif; ?>
                            </div>
                        </th>
                    </tr>
                    <?php if ($this->_var['groupbuy_list']): ?>
                    <tr class="gray">
                        <th width="50"> </th>
                        <th width="100"><span>活动名称</span></th>
                        <th width="50"><span>活动状态</span></th>
                        <th width="80"><span>结束日期</span></th>
                    <th width="80"><span>订购数/成团数</span></th>
                        <th width="130">订购详情</th>
                        <th width="135">操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['groupbuy_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'group');$this->_foreach['_group_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_group_f']['total'] > 0):
    foreach ($_from AS $this->_var['group']):
        $this->_foreach['_group_f']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['_group_f']['iteration'] == $this->_foreach['_group_f']['total'])): ?> last_line<?php endif; ?>">
                        <td width="50" class="align2">
                        <a href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>" target="_blank"><img alt="<?php echo htmlspecialchars($this->_var['group']['group_name']); ?>" src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['group']['default_image']; ?>" width="50" height="50" /></a></td>
                        <td width="100" align="align2">
                          <p class="ware_text"><span class="color2" ectype="editobj"><a target="_blank" href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['group']['group_name']); ?></a></span></p>
                        </td>
                        <td width="50"><span class="color2"><?php echo call_user_func("group_state",$this->_var['group']['state']); ?></span></td>
                        <td width="80" class="align2">
                        <span class="color2" ectype="editobj"><?php echo local_date("Y-m-d",$this->_var['group']['end_time']); ?></span></td>
                    <td width="80" class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?><span class="color2" ectype="editobj"><?php endif; ?>
                    <?php echo $this->_var['group']['quantity']; ?>/<?php echo $this->_var['group']['min_quantity']; ?></span></td>
                        <td width="130">
                        <?php $_from = $this->_var['group']['spec_quantity']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'spec');if (count($_from)):
    foreach ($_from AS $this->_var['spec']):
?>
                        <?php if ($this->_var['spec']['qty'] > 0): ?><?php if ($this->_var['spec']['spec']): ?><?php echo $this->_var['spec']['spec']; ?><?php else: ?>默认规格<?php endif; ?>: <?php echo $this->_var['spec']['qty']; ?>件<?php endif; ?><br />
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </td>
                        <td width="135"><div>
                        <?php $_from = $this->_var['group']['ican']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'name');if (count($_from)):
    foreach ($_from AS $this->_var['name']):
?>
                        <?php if ($this->_var['name'] == 'view'): ?>
                        <a target="_blank" href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>" class="view">查看</a>
                        <?php elseif ($this->_var['name'] == 'buy'): ?>
                        <a target="_blank" href="<?php echo url('app=order&goods=groupbuy&group_id=' . $this->_var['group']['group_id']. ''); ?>" class="buy">购买</a>
                        <?php elseif ($this->_var['name'] == 'view_order'): ?>
                        <a target="_blank" href="<?php echo url('app=buyer_order&act=view&order_id=' . $this->_var['group']['order_id']. ''); ?>" class="view_order">查看订单</a>
                        <?php elseif ($this->_var['name'] == 'exit_group'): ?>
                        <a href="javascript:drop_confirm('您确定要退出该团购活动吗？','<?php echo url('app=buyer_groupbuy&act=exit_group&id=' . $this->_var['group']['group_id']. ''); ?>')" class="delete">退出团购</a>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="7">没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['groupbuy_list']): ?>
                    <tr class="line_bold line_bold_bottom">
                        <td colspan="7"></td>
                    </tr>
                    <tr>
                        <th colspan="7">
                            <p class="position2">
                                <?php echo $this->fetch('member.page.bottom.html'); ?>
                            </p>
                        </th>
                    </tr>
                    <?php endif; ?>
                </table>
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
<iframe name="iframe_post" id="iframe_post" width="0" height="0"></iframe>
<?php echo $this->fetch('footer.html'); ?>