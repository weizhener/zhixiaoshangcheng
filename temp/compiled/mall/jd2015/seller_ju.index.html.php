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
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="eject_btn_two eject_pos1" title="新增"><b class="ico2" onclick="go('index.php?app=seller_ju&amp;act=add');">新增聚划算</b></div>
            <div class="public_select table">
                <table align="center">

                    <tr class="line_bold">
                        <th colspan="7">
                    <div class="select_div clearfix" style="padding-top:0;margin-bottom:20px;">
                        <form method="get">
                            <div style="float:left;">
                                <input type="text" class="text_normal" name="group_name" value="<?php echo htmlspecialchars($_GET['group_name']); ?>"/>
                                <select name="status">
                                    <?php echo $this->html_options(array('options'=>$this->_var['status'],'selected'=>$_GET['status'])); ?>
                                </select>
                                <input type="hidden" name="app" value="seller_ju" />
                                <input type="hidden" name="act" value="index" />
                                <input type="submit" class="btn" value="搜索" />
                            </div>
                            <?php if ($this->_var['filtered']): ?>
                            <a class="detlink_with_no_bg" href="<?php echo url('app=seller_ju'); ?>">取消检索</a>
                            <?php endif; ?>
                        </form>
                    </div>

                    </th>
                    </tr>
                    <?php if ($this->_var['groupbuy_list']): ?>
                    <tr class="gray">
                        <th width="50"> </th>
                        <th width="200"><span>聚划算名称</span></th>
                        <th width="150"><span>聚活动</span></th>
                        <th width="80"><span>已团购</span></th>
                        <th width="100"><span>状态</span></th>
                        <th width="100"><span>审核说明</span></th>
                        <th width="100">操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['groupbuy_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'group');$this->_foreach['_group_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_group_f']['total'] > 0):
    foreach ($_from AS $this->_var['group']):
        $this->_foreach['_group_f']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['_group_f']['iteration'] == $this->_foreach['_group_f']['total'])): ?> last_line<?php endif; ?>">
                        <td width="50" class="align2">
                            <a  href="<?php if ($this->_var['group']['status'] == 1): ?><?php echo url('app=ju&act=show&id=' . $this->_var['group']['group_id']. ''); ?><?php else: ?><?php echo url('app=goods&id=' . $this->_var['group']['goods_id']. ''); ?><?php endif; ?>" target="_blank"><img <?php if ($this->_var['group']['image']): ?>src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['group']['image']; ?>" width="75" height="50"<?php else: ?>src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['group']['default_image']; ?>" width="50" height="50"<?php endif; ?>  /></a></td>
                        <td width="200" align="center">
                            <p class="ware_text"><span class="color2" ectype="editobj">
                                    <a target="_blank" href="<?php if ($this->_var['group']['status'] == 1): ?><?php echo url('app=ju&act=show&id=' . $this->_var['group']['group_id']. ''); ?><?php else: ?><?php echo url('app=goods&id=' . $this->_var['group']['goods_id']. ''); ?><?php endif; ?>"><?php echo htmlspecialchars($this->_var['group']['group_name']); ?></a></span></p>
                        </td>
                        <td align="center">
                            <span  style="color:#555555; font-weight: 600;line-height: 20px; font-size:14px;"><?php echo $this->_var['group']['template_name']; ?>(<?php echo call_user_func("group_state",$this->_var['group']['state']); ?>)</span>
                            <p class="color2" style="color:#999999;"><?php echo local_date("Y-m-d",$this->_var['group']['start_time']); ?>~<?php echo local_date("Y-m-d",$this->_var['group']['end_time']); ?></p>
                        </td>

                        <td class="align2"><?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=my_goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_id="my_goods_spec_edit" class="cursor_pointer">
                                <?php else: ?><span class="color2" ectype="editobj"><?php endif; ?><?php echo $this->_var['group']['quantity']; ?></span></td>
                        <td class="align2">
                            <?php if ($this->_var['group']['status'] == 1): ?>
                            <font title="<?php echo $this->_var['group']['status_desc']; ?>" color="#006633">已通过</font>
                            <?php elseif ($this->_var['group']['status'] == 2): ?>
                            <font title="<?php echo $this->_var['group']['status_desc']; ?>" color="#999999">未通过</font>
                            <?php elseif ($this->_var['group']['status'] == 3): ?>
                            <font title="<?php echo $this->_var['group']['status_desc']; ?>" color="#CC9900">待修改</font>
                            <?php else: ?>
                            <font title="<?php echo $this->_var['group']['status_desc']; ?>" color="#FF6600">审核中</font>
                            <?php endif; ?>
                        </td>
                        <td class="align2"><font color="#999"><?php echo $this->_var['group']['status_desc']; ?></font></td>
                        <td width="200" align="center"><div>
                                <a style="float:none" href="<?php echo url('app=seller_ju&act=edit&id=' . $this->_var['group']['group_id']. ''); ?>" class="edit">编辑</a>
                                <a style="float:none" href="javascript:drop_confirm('若该团购已完成，则删除该团购将导致未下单的用户无法下单，您确定要这么做吗？', 'index.php?app=seller_ju&amp;act=drop&id=<?php echo $this->_var['group']['group_id']; ?>');" class="delete">删除</a>
                            </div></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="6">没有符合条件的记录</td>
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