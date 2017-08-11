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
            <div style="clear:both;"></div>
            <div class="public_select table">
                <table>

                    <tr class="line_bold">
                        <th class="align1" colspan="2"></th>
                        <th colspan="4">
                    <div class="select_div">
                        <form method="get">
                            <?php if ($this->_var['filtered']): ?>
                            <a class="detlink_with_no_bg" style="float:right" href="<?php echo url('app=seller_mix'); ?>">取消检索</a>
                            <?php endif; ?>
                            <div style="float:right">自由搭配名称：
                                <input style="*position:relative;*top:5px;*z-index:0;" type="text" class="text_normal" name="mix_name" value="<?php echo htmlspecialchars($_GET['mix_name']); ?>"/>

                                <input type="hidden" name="app" value="seller_mix" />
                                <input type="hidden" name="act" value="index" />
                                <input type="submit" class="btn" value="搜索" />
                            </div>
                        </form>
                    </div>
                    </th>
                    </tr>
                    <?php if ($this->_var['mix_list']): ?>
                    <tr class="gray">
                        <th width="30"></th>
                        <th width="160"><span>自由搭配名称</span></th>
                        <th width="250"><span>自由搭配描述</span></th>
                        <th width="150"><span>商品数</span></th>
                        <th width="240">操作</th>
                    </tr>
                    <?php endif; ?>
                    <?php $_from = $this->_var['mix_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'mix');$this->_foreach['_mix_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_mix_f']['total'] > 0):
    foreach ($_from AS $this->_var['mix']):
        $this->_foreach['_mix_f']['iteration']++;
?>
                    <tr class="line<?php if (($this->_foreach['_mix_f']['iteration'] == $this->_foreach['_mix_f']['total'])): ?> last_line<?php endif; ?>">
                        <td width="25" class="align2"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['mix']['mix_id']; ?>"/></td>
                        <td width="160" align="align2">
                            <p class="ware_text"><span class="color2">
                                    <a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['mix']['nav_goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['mix']['mix_name']); ?></a></span></p>
                        </td>
                        <td width="250"><span class="color2"><?php echo htmlspecialchars($this->_var['mix']['mix_desc']); ?></span></td>
                        <td width="150" class="align2"><span class="color2"><?php echo ($this->_var['mix']['goods_count'] == '') ? '0' : $this->_var['mix']['goods_count']; ?></span></td>
                        <td width="240"><div>
                                <a href="<?php echo url('app=seller_mix&act=edit&id=' . $this->_var['mix']['mix_id']. ''); ?>" >编辑</a> |
                                <a href="<?php echo url('app=seller_mix&act=drop&id=' . $this->_var['mix']['mix_id']. ''); ?>" >删除</a> | 
                                <a href="<?php echo url('app=seller_mix&act=view_goods&id=' . $this->_var['mix']['mix_id']. ''); ?>">查看自由搭配商品</a>
                            </div></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td class="align2 member_no_records padding6" colspan="6">没有符合条件的记录</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['mix_list']): ?>
                    <tr class="line_bold line_bold_bottom">
                        <td colspan="5">&nbsp;</td>
                    </tr>
                    <tr>
                        <th><input type="checkbox" id="all2" class="checkall"/></th>
                        <th colspan="4">
                    <p class="position1">
                        <span class="all"><label for="all2">全选</label></span>
                        <a href="javascript:;" class="delete" uri="index.php?app=seller_mix&act=drop" name="id" presubmit="confirm('您确定要删除该自由搭配吗？')" ectype="batchbutton">删除</a>                            
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
    </div>
    <div class="clear"></div>
</div>
<iframe name="iframe_post" id="iframe_post" width="0" height="0"></iframe>
<?php echo $this->fetch('footer.html'); ?>