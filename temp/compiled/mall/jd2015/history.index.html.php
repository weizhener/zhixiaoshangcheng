<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
    <div id="page-search-promotion" class="w mt10 mb20">
        <?php echo $this->fetch('curlocal.html'); ?>
        <div class="w mt10">
            <div class="group-list mt10 mb10 clearfix">
                <ul class="clearfix">
                    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
                    <a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>">
                        <li class="item mb20" <?php if ($this->_foreach['fe_goods']['iteration'] % 4 == 0): ?> style="margin-right:0"<?php endif; ?>>
                            <img src="<?php echo $this->_var['goods']['default_image']; ?>" alt="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>" />
                            <h3><?php echo sub_str(htmlspecialchars($this->_var['goods']['goods_name']),60); ?></h3>
                        </li>
                    </a>
                    <?php endforeach; else: ?>
                    <div>没有浏览记录</div>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>    
        </div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>