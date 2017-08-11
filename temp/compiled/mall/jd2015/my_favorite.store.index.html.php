<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table">
                <table>
                    <?php if ($this->_var['collect_store']): ?>
                     <tr class="operations line_bold">
                        <th colspan="8">
                            <p class="position1 clearfix">
                            	<input type="checkbox" id="all" class="checkall"/>
                        		<label for="all">全选</label>
                            	<a href="javascript:void(0);" class="delete" uri="index.php?app=my_favorite&act=drop&type=store" name="item_id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a>
                            </p>
                            <p class="position2 clearfix">
                                <?php echo $this->fetch('member.page.top.html'); ?>
                            </p>
                        </th>
                    </tr>
                    
                    <?php endif; ?>
                    <?php $_from = $this->_var['collect_store']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['store']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                        <td class="align2" style="width:25px;"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['store']['store_id']; ?>"/></td>
                        <td>
                            <p class="ware_pic"><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['store']['store_logo']; ?>" width="50" height="50"  /></a></p>
                        </td>
                        <td>
                            <p class="ware_text"><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></a></p>
                        </td>
                        <td class="width2"><?php echo htmlspecialchars($this->_var['store']['user_name']); ?></td>
                        <td class="width2"><a target="_blank" href="<?php echo url('app=message&act=send&to_id=' . $this->_var['store']['store_id']. ''); ?>" class="email" title="发站内信"></a></td>
                        <td class="width5"><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></td>
                        <td class="width2"><img src="<?php echo $this->_var['store']['credit_image']; ?>" /></td>
                        <td class="width2"><a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_favorite&amp;act=drop&type=store&item_id=<?php echo $this->_var['store']['store_id']; ?>');" class="delete">删除</a></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="8" class="member_no_records">没有符合条件的店铺</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['collect_store']): ?>
                    <tr class="operations">
                        <th colspan="8">
                            <p class="position1 clearfix">
                            	<input type="checkbox" id="all2" class="checkall"/>
                        		<label for="all2">全选</label>
                            	<a href="javascript:void(0);" class="delete" uri="index.php?app=my_favorite&act=drop&type=store" name="item_id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a>
                            </p>
                            <p class="position2 clearfix">
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
<iframe name="iframe_post" width="0" height="0"></iframe>
<?php echo $this->fetch('footer.html'); ?>
