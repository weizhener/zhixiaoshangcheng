<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <div class="totline"></div>
    <div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
        <div class="submenu">
        <ul class="tab">
        	<li class="active first"><h2><a href="javascript:;">规则列表</a></h2></li>
            <li class="normal"><h2><a href="index.php?app=my_oauth&act=add">添加规则</a></h2></li>
        </ul>
		</div>
        <div class="wrap">
            <div class="public_select table">
                <table>
                    <tr class="sep-row" height="20"><td colspan="8"></td></tr>
                    <tr class="gray" >
                        <th width="10%" style=" text-align:center;">规则名称</th>
                        <th width="30%">网址</th>
                        <th width="45%">调用网址</th>
                        <th width="10%">操作</th>
                    </tr>
                    <tr class="sep-row"><td colspan="4"></td></tr>
                    
                    <?php $_from = $this->_var['partners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');$this->_foreach['_goods_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_goods_f']['total'] > 0):
    foreach ($_from AS $this->_var['list']):
        $this->_foreach['_goods_f']['iteration']++;
?>
					<tr class="line line-blue">
                        <th width="10%"><?php echo $this->_var['list']['name']; ?></th>
                        <th width="30%"><?php echo $this->_var['list']['url']; ?></th>
                        <th width="45%"><?php echo $this->_var['site_url']; ?>/index.php?app=wxoauth&store_id=<?php echo $this->_var['visitor']['user_id']; ?>&oid=<?php echo $this->_var['list']['id']; ?></th>
                        <th width="10%"><a href="index.php?app=my_oauth&act=add&id=<?php echo $this->_var['list']['id']; ?>" >编辑</a> |  <a  href="index.php?app=my_oauth&act=drop&id=<?php echo $this->_var['list']['id']; ?>" >删除</a></th>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>