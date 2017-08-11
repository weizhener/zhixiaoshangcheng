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
                        <th colspan="6">
                            <div class="select_div">
                            <form method="get">
                            <?php if ($this->_var['filtered']): ?>
                            <a class="detlink_with_no_bg" style="float:right" href="<?php echo url('app=seller_promotion'); ?>">取消检索</a>
                            <?php endif; ?>
                            <div style="float:right">
                            <input type="text" class="text_normal" name="pro_name" value="<?php echo htmlspecialchars($_GET['pro_name']); ?>"/>
                            <input type="hidden" name="app" value="seller_promotion" />
                            <input type="hidden" name="act" value="index" />
                            <input type="submit" class="btn" value="搜索" />
                            </div>
                            </form>
                            </div>
                        </th>
                    </tr>
                    <?php if ($this->_var['promotion_list']): ?>
                    <tr class="gray">
                        <th width="50">商品图片</th>
                        <th width="160"><span>促销名称</span></th>
                        <th width="100"><span>开始时间</span></th>
                        <th width="100"><span>结束时间</span></th>
                        <th width="80"><span>原价</span></th>
                        <th width="80"><span>促销价</span></th>
                        <th ><span>状态</span></th>
                        <th width="140"><span>操作</span></th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['promotion_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'promotion');$this->_foreach['_promotion_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_promotion_f']['total'] > 0):
    foreach ($_from AS $this->_var['promotion']):
        $this->_foreach['_promotion_f']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['_promotion_f']['iteration'] == $this->_foreach['_promotion_f']['total'])): ?> last_line<?php endif; ?>">
                        <td width="50" class="align2">
                        <a href="<?php echo url('app=goods&id=' . $this->_var['promotion']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['promotion']['default_image']; ?>" width="50" height="50"  /></a></td>
                        <td width="160" align="align2">
                          <p class="ware_text"><span class="color2" ectype="editobj">
                            <a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['promotion']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['promotion']['pro_name']); ?></a></span></p>
                        </td>
                        <td width="100"><span class="color2"><?php echo local_date("Y-m-d",$this->_var['promotion']['start_time']); ?></span></td>
                        <td width="100" class="align2"><span class="color2" ectype="editobj"><?php echo local_date("Y-m-d",$this->_var['promotion']['end_time']); ?></span></td>
                        <td width="80" class="align2"><?php echo $this->_var['promotion']['price']; ?></td>
                        <td width="80" class="align2"><?php echo $this->_var['promotion']['pro_price']; ?></td>
                        <td width="80" class="align2"><?php if ($this->_var['promotion']['pro_price'] > 0 && $this->_var['promotion']['end_time'] >= $this->_var['time_now']): ?>进行中<?php else: ?><span style="color:red">待修改</span><?php endif; ?></td>
                        <td width="140" class="align2">
                           <div><a href="<?php echo url('app=seller_promotion&act=edit&id=' . $this->_var['promotion']['pro_id']. ''); ?>" style="color:#3e3e3e; text-decoration:none">编辑促销</a> | 
                           <a href="<?php echo url('app=seller_promotion&act=drop&id=' . $this->_var['promotion']['pro_id']. ''); ?>" style="color:#3e3e3e; text-decoration:none">删除促销</a>
                           </div>
                        </td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="8">没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['promotion_list']): ?>
                    <tr class="line_bold line_bold_bottom">
                        <td colspan="8"></td>
                    </tr>
                    <tr>
                        <th colspan="8">
                            <p class="position2">
                                <?php echo $this->fetch('member.page.bottom.html'); ?>
                            </p>
                        </th>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
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