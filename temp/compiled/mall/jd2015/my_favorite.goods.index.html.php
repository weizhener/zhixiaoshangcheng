<?php echo $this->fetch('member.header.html'); ?>
<style>
.table .ware_text {width:290px;}
</style>
<script type="text/javascript">
//<!CDATA[
function add_to_cart(spec_id, quantity)
{
    var url = SITE_URL + '/index.php?app=cart&act=add';
    $.getJSON(url, {'spec_id':spec_id, 'quantity':quantity}, function(data){
        alert(data.msg);
    });
}
</script>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public table">
                <table>
                    <?php if ($this->_var['collect_goods']): ?>
                    <tr class="operations line_bold">
                        <th colspan="7">
                            <p class="position1 clearfix">
                            	<input type="checkbox" id="all" class="checkall"/>
                        		<label for="all">全选</label>
                            	<a href="javascript:void(0);" class="delete" uri="index.php?app=my_favorite&act=drop&type=goods" name="item_id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a>
                            </p>
                            <p class="position2 clearfix">
                                <?php echo $this->fetch('member.page.top.html'); ?>
                            </p>
                        </th>
                    </tr>

                    <?php endif; ?>
                    <?php $_from = $this->_var['collect_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['v'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['v']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['v']['iteration']++;
?>
                    <?php if (($this->_foreach['v']['iteration'] == $this->_foreach['v']['total'])): ?><tr class="line_bold"><?php else: ?><tr class="line"><?php endif; ?>
                        <td class="align2" style="width:25px"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>"/></td>
                        <td>
                            <p class="ware_pic"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['goods']['default_image']; ?>" width="50" height="50"  /></a></p>
                        </td>
                        <td>
                            <p class="ware_text"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                        </td>
                        <td class="width3"><?php echo htmlspecialchars($this->_var['goods']['store_name']); ?></td>
                        <td class="width2"><a target="_blank" href="<?php echo url('app=message&act=send&to_id=' . $this->_var['goods']['store_id']. ''); ?>" class="email" title="发站内信"></a></td>
                        <td class="width2"><?php echo price_format($this->_var['goods']['price']); ?></td>
                        <td class="width2"><a href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=my_favorite&amp;act=drop&type=goods&item_id=<?php echo $this->_var['goods']['goods_id']; ?>');" class="delete">删除</a></td>
                    </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="7" class="member_no_records">没有符合条件的商品</td>
                    </tr>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php if ($this->_var['collect_goods']): ?>
                    <tr class="operations">
                        <th colspan="7">
                            <p class="position1 clearfix">
                            	<input type="checkbox" id="all2" class="checkall"/>
                        		<label for="all2">全选</label>
                            	<a href="javascript:void(0);" class="delete" uri="index.php?app=my_favorite&act=drop&type=goods" name="item_id" presubmit="confirm('您确定要删除它吗？')" ectype="batchbutton">删除</a>
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
<iframe id='iframe_post' name="iframe_post" src="about:blank" frameborder="0" width="0" height="0"></iframe>
<?php echo $this->fetch('footer.html'); ?>
