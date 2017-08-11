<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right"> 
    	<?php echo $this->fetch('member.curlocal.html'); ?>
    	<?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="eject_btn_two eject_pos1" title="品牌申请" style="top:15px"><b class="ico3" ectype="dialog" dialog_title="品牌申请" dialog_id="my_goods_brand_apply" dialog_width="480" uri="index.php?app=my_goods&act=brand_apply">品牌申请</b></div>
            <div class="public table">
                <table>
                    
                    <tr class="line_bold">
                        <th colspan="4">
                            <div class="select_div clearfix" style="padding-top:0;margin-bottom:20px;">
                            <form method="get" class="fleft">
                            <input type="hidden" name="app" value="my_goods">
                            <input type="hidden" name="act" value="brand_list">
                            品牌名称:
                            <input type="text" class="text_normal" name="brand_name" value="<?php echo htmlspecialchars($_GET['brand_name']); ?>"/>
                            <select class="select1" name='store'>
                                <?php echo $this->html_options(array('options'=>$this->_var['lang']['all_me'],'selected'=>$_GET['store'])); ?>
                            </select>
                            <input type="submit" class="btn" value="搜索" />
                            </form>
                            <?php if ($this->_var['filtered']): ?>
                            <a class="detlink" href="<?php echo url('app=my_goods&act=brand_list'); ?>">取消检索</a>
                            <?php endif; ?>
                            </div>
                        </th>
                    </tr>
                    <?php if ($this->_var['brands']): ?>
                    <tr class="gray">
                        <th class="width11 cursor_pointer" column="brand_name" title="排序"><span ectype="order_by">品牌名称</span></th>
                        <th>品牌图标</th>
                        <th class="width11 cursor_pointer" column='tag' title="排序"><span ectype="order_by">类别</span></th>
                        <th class="width13">操作</th>
                    </tr>
                   <?php endif; ?>
                <?php $_from = $this->_var['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['brand']):
        $this->_foreach['v']['iteration']++;
?>
                <tr class="line<?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?> last_line<?php endif; ?>">
                    <td class="padding2 first"><?php echo $this->_var['brand']['brand_name']; ?></td>
                    <td class="padding2"><img src="<?php echo $this->_var['brand']['brand_logo']; ?>" height="30" /></td>
                    <td class="padding2"><?php echo $this->_var['brand']['tag']; ?></td>
                    <td class="align2"><?php if (! $this->_var['brand']['if_show']): ?><a class="edit1" href="javascript:void(0);" ectype="dialog" dialog_title="编辑品牌" dialog_id="my_goods_brand_edit" dialog_width="480" uri="index.php?app=my_goods&act=brand_edit&id=<?php echo $this->_var['brand']['brand_id']; ?>">编辑</a> <a class="delete" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_goods&act=brand_drop&id=<?php echo $this->_var['brand']['brand_id']; ?>');">删除</a><?php endif; ?></td>
                </tr>
                <?php endforeach; else: ?>
                <tr>
                    <td colspan="4" class="member_no_records padding6">没有符合条件的商品</td>
                </tr>
                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php if ($this->_var['brands']): ?>
                <tr class="line_bold line_bold_bottom">
                    <td colspan="4">&nbsp;
                        
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <p class="position2">
                                    <?php echo $this->fetch('member.page.bottom.html'); ?>
                        </p>
                    </td>
                <tr>
                <?php endif; ?>
                </table>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <iframe name="my_goods" style="display:none"></iframe>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>