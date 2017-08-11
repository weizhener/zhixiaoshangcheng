<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">收货地址</div>
    <a  ectype="dialog" dialog_title="新增地址" dialog_id="my_address_add" dialog_width="100%" uri="index.php?app=my_address&act=add" class="add_address r_b">新增地址</a>
</div>

<div id="my_address_index">
    
    <div class="address_con">
        <?php $_from = $this->_var['addresses']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'address');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['address']):
        $this->_foreach['v']['iteration']++;
?>
        <div class="address_box" >
            <div class="address_info">
                <p><?php echo htmlspecialchars($this->_var['address']['consignee']); ?>（<?php if ($this->_var['address']['phone_tel']): ?><?php echo $this->_var['address']['phone_tel']; ?> <?php else: ?> <?php echo $this->_var['address']['phone_mob']; ?><?php endif; ?> ）</p>
                <p><?php echo htmlspecialchars($this->_var['address']['region_name']); ?></p>
                <p><?php echo htmlspecialchars($this->_var['address']['address']); ?></p>
            </div>
            <p class="oprate"><a href="javascript:void(0);" ectype="dialog" dialog_id="my_address_edit" dialog_title="编辑地址" dialog_width="100%" uri="index.php?app=my_address&act=edit&addr_id=<?php echo $this->_var['address']['addr_id']; ?>" class="edit_address"><b></b>编辑<i></i></a><a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_address&amp;act=drop&addr_id=<?php echo $this->_var['address']['addr_id']; ?>');" class="del_address"><b></b>删除</a></p>
        </div>
        <?php endforeach; else: ?>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?> 
    </div>
    <iframe id='iframe_post' name="iframe_post" frameborder="0" width="0" height="0">
    
</div>

<?php echo $this->fetch('member.footer.html'); ?>