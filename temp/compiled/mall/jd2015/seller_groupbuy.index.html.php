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
                        <th class="align1" colspan="2"></th>
                        <th colspan="4">
                            <div class="select_div">
                            <form method="get">
                            <?php if ($this->_var['filtered']): ?>
                            <a class="detlink_with_no_bg" style="float:right" href="<?php echo url('app=seller_groupbuy'); ?>">取消检索</a>
                            <?php endif; ?>
                            <div style="float:right">
                            <input type="text" class="text_normal" name="group_name" value="<?php echo htmlspecialchars($_GET['group_name']); ?>"/>
                            <select name="state">
                            <?php echo $this->html_options(array('options'=>$this->_var['state'],'selected'=>$_GET['state'])); ?>
                            </select>
                            <input type="hidden" name="app" value="seller_groupbuy" />
                            <input type="hidden" name="act" value="index" />
                            <input type="submit" class="btn" value="搜索" />
                            </div>
                            </form>
                            </div>
                        </th>
                    </tr>
                    <?php if ($this->_var['groupbuy_list']): ?>
                    <tr class="gray">
                        <th width="50"> </th>
                        <th width="160"><span>活动名称</span></th>
                        <th width="50"><span>活动状态</span></th>
                        <th width="150"><span>起始时间</span></th>
                    <th width="80"><span>订购数/成团数</span></th>
                        <th width="240">操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['groupbuy_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'group');$this->_foreach['_group_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_group_f']['total'] > 0):
    foreach ($_from AS $this->_var['group']):
        $this->_foreach['_group_f']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['_group_f']['iteration'] == $this->_foreach['_group_f']['total'])): ?> last_line<?php endif; ?>">
                        <td width="50" class="align2">
                        <a href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['group']['default_image']; ?>" width="50" height="50"  /></a></td>
                        <td width="160" align="align2">
                          <p class="ware_text"><span class="color2" ectype="editobj">
                            <a target="_blank" href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['group']['group_name']); ?></a></span></p>
                        </td>
                        <td width="50"><span class="color2"><?php echo call_user_func("group_state",$this->_var['group']['state']); ?></span></td>
                        <td width="150" class="align2"><span class="color2" ectype="editobj"><?php echo local_date("Y-m-d",$this->_var['group']['start_time']); ?>至<?php echo local_date("Y-m-d",$this->_var['group']['end_time']); ?></span></td>
                    <td width="55" class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?><span class="color2" ectype="editobj"><?php endif; ?>
                    <?php echo $this->_var['group']['quantity']; ?>/<?php echo $this->_var['group']['min_quantity']; ?></span></td>
                        <td width="240"><div>
                        <?php $_from = $this->_var['group']['ican']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'name');if (count($_from)):
    foreach ($_from AS $this->_var['name']):
?>
                        <?php if ($this->_var['name'] == 'drop'): ?>
                        <a href="javascript:drop_confirm('若该团购已完成，则删除该团购将导致未下单的用户无法下单，您确定要这么做吗？', 'index.php?app=seller_groupbuy&amp;act=drop&id=<?php echo $this->_var['group']['group_id']; ?>');" class="delete">删除</a>
                        <?php elseif ($this->_var['name'] == 'start'): ?>
                        <a href="javascript:drop_confirm('发布后除修改说明外不能再被编辑，您确定要发布吗？', 'index.php?app=seller_groupbuy&amp;act=start&id=<?php echo $this->_var['group']['group_id']; ?>');" class="start">发布</a>
                        <?php elseif ($this->_var['name'] == 'view_order'): ?>
                            <?php if ($this->_var['group']['order_count'] == 0): ?>
                                <a class="<?php echo $this->_var['name']; ?>">订单(<?php echo $this->_var['group']['order_count']; ?>)</a>
                            <?php else: ?>
                                <a href="<?php echo url('app=seller_order&ordertype=groupbuy&group_id=' . $this->_var['group']['group_id']. ''); ?>" class="<?php echo $this->_var['name']; ?>">订单(<?php echo $this->_var['group']['order_count']; ?>)</a>
                            <?php endif; ?>
                        <?php elseif ($this->_var['name'] == 'finished'): ?>
                        <a href="javascript:drop_confirm('该操作将要把团购设置为成功状态，您确定要完成吗？', 'index.php?app=seller_groupbuy&amp;act=finished&id=<?php echo $this->_var['group']['group_id']; ?>');" class="finished">完成</a>
                        <?php elseif ($this->_var['name'] == 'log'): ?>
                        <a href="javascript:;" dialog_id="log" dialog_title="log" dialog_width="430" ectype="dialog" uri="index.php?app=seller_groupbuy&amp;act=log&id=<?php echo $this->_var['group']['group_id']; ?>" class="log">订购情况</a>
                        <?php elseif ($this->_var['name'] == 'export_ubbcode'): ?>
                        <a  href="javascirpt:;" ectype="dialog" dialog_id="export_ubbcode" dialog_title="导出UBB" dialog_width="380" uri="<?php echo url('app=seller_groupbuy&act=export_ubbcode&id=' . $this->_var['group']['group_id']. ''); ?>" class="export">导出UBB</a>
                        <?php else: ?>
                        <a href="<?php echo url('app=seller_groupbuy&act=' . $this->_var['name']. '&id=' . $this->_var['group']['group_id']. ''); ?>" class="<?php echo $this->_var['name']; ?>"><?php echo $this->_var['lang'][$this->_var['name']]; ?></a>
                        <?php endif; ?>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </div></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="6">没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['groupbuy_list']): ?>
                    <tr class="line_bold line_bold_bottom">
                        <td colspan="6"></td>
                    </tr>
                    <tr>
                        <th colspan="6">
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