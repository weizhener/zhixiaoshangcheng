<?php echo $this->fetch('member.header.html'); ?>
<style>
.member_no_records {border-top: 0px !important;}
.table td{padding-left: 5px;}
.table .ware_text {width: 155px;}
</style>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right">
    <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public_select table">
                <table id="my_goods">
                    <?php if ($this->_var['goods_list']): ?>
                    <tr class="gray"  ectype="table_header">
                        <th width="30"></th>
                        <th width="55"></th>
                        <th>商品名称</th>
                        <th>商品分类</th>
                        <th width="100">品牌</th>
                        <th width="30">上架</th>
                        <th width="30">禁售</th>
                        <th width="50">浏览数</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['_goods_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_goods_f']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['_goods_f']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['_goods_f']['iteration'] == $this->_foreach['_goods_f']['total'])): ?> last_line<?php endif; ?>" ectype="table_item" idvalue="<?php echo $this->_var['goods']['goods_id']; ?>">
                        <td width="25" class="align2"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>"/></td>
                        <td width="50" class="align2"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods']['default_image']; ?>" width="50" height="50"  /></a></td>
                        <td width="160" align="center">
                          <p class="ware_text"><span class="color2"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span></p>
                        </td>
                        <td  align="center"><?php echo $this->_var['goods']['cate_name']; ?></td>
                        <td  class="align2"><span class="color2"><?php echo htmlspecialchars($this->_var['goods']['brand']); ?></span></td>
                        <td  class="align2"><span style="margin:0px 5px;" <?php if ($this->_var['goods']['if_show']): ?>class="right_ico" status="on"<?php else: ?>class="wrong_ico" stauts="off"<?php endif; ?>></span></td>
                        
                        <td class="align2"><span style="margin:0px 5px;" <?php if ($this->_var['goods']['closed']): ?>class="no_ico"<?php else: ?>class="no_ico_disable"<?php endif; ?>></span></td>
                        <td class="align2"><?php echo $this->_var['goods']['views']; ?></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="10"><?php echo $this->_var['lang'][$_GET['act']]; ?>没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['goods_list']): ?>
                    <tr class="line_bold line_bold_bottom">
                        <td colspan="11"> </td>
                    </tr>
                    <tr>
                        <th><input type="checkbox" id="all2" class="checkall"/></th>
                        <th colspan="10">
                            <p class="position1">
                                <span class="all"><label for="all2">全选</label></span>
                                <a href="javascript:void(0);" class="edit" ectype="batchbutton" uri="index.php?app=my_recommend&amp;act=drop_goods_from&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>&id=<?php echo $_GET['id']; ?>" name="goods_id">取消推荐</a>
                            </p>
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