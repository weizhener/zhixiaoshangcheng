<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>商品属性</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=props">属性列表</a></li>
        <li><a class="btn1" href="index.php?app=props&amp;act=add">添加属性</a></li>
        <li><span>分配属性</span></li>
    </ul>
</div>
<style>
.distribute .td{border:1px #ddd solid;border-bottom:0;padding-left:5px;}
a{text-decoration:none}
a:hover{text-decoration:underline}
</style>
<script>
$(function(){
	$('input[ectype="pid"]').click(function(){
		if($(this).attr('checked')) {
			$('input[ectype="pid'+$(this).attr("pid")+'"]').attr('checked',true);
		}
		else {
			$('input[ectype="pid'+$(this).attr("pid")+'"]').attr('checked',false);
		}
	})
});
</script>
<div class="info2 distribute">
   <form action="" method="post">
    <input type="hidden" name="cate_id" value="<?php echo $this->_var['cate_id']; ?>" />
    <table  class="distinction">
        <tr style="background:none">
           <td colspan="2" class="td" style="width:100%;background:none; height:40px;">
            当前分类：
            <?php $_from = $this->_var['distribute_cate']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcate');if (count($_from)):
    foreach ($_from AS $this->_var['gcate']):
?>
            / <a href="<?php echo url('app=props&act=distribute&cate_id=' . $this->_var['gcate']['cate_id']. ''); ?>"><?php echo $this->_var['gcate']['cate_name']; ?></a>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
           </td>
        </tr>
        <?php $_from = $this->_var['prop_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'prop');if (count($_from)):
    foreach ($_from AS $this->_var['prop']):
?>
        <tr>
            <td class="td" style="width:15%;">
            <input type="checkbox" name="pid[]" value="<?php echo $this->_var['prop']['pid']; ?>" id="pid<?php echo $this->_var['prop']['pid']; ?>" ectype="pid" pid="<?php echo $this->_var['prop']['pid']; ?>" <?php if ($this->_var['prop']['checked']): ?> checked="checked"<?php endif; ?> /><label for="pid<?php echo $this->_var['prop']['pid']; ?>"><?php echo $this->_var['prop']['name']; ?></label></td>
            <td class="td" id="pvs<?php echo $this->_var['prop']['pid']; ?>" style="width:80%">
            <?php $_from = $this->_var['prop']['prop_value']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            <input type="checkbox" name="vid[]" value="<?php echo $this->_var['prop']['pid']; ?>:<?php echo $this->_var['item']['vid']; ?>" id="vid<?php echo $this->_var['item']['vid']; ?>" ectype="pid<?php echo $this->_var['item']['pid']; ?>" <?php if ($this->_var['item']['checked']): ?> checked="checked"<?php endif; ?> /><label for="vid<?php echo $this->_var['item']['vid']; ?>"><?php echo $this->_var['item']['prop_value']; ?></label>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </td>
        </tr>  
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="2">没有符合条件的记录</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <tfoot>
        <?php if ($this->_var['prop_list']): ?>
        <tr class="tr_pt10">
           <td colspan="2" id="batchAction">
           <input class="formbtn" type="submit" value="保存" />
           <input class="formbtn" type="reset" name="reset" value="重置" />
           </td>
        </tr>    
        </tfoot>
        <?php endif; ?>
    </table>
    </form>
</div>

<?php echo $this->fetch('footer.html'); ?>