<?php echo $this->fetch('header.html'); ?>
<div id="main" class="w-full">
    <div id="page-search-promotion" class="w mt10 mb20">
        <?php echo $this->fetch('curlocal.html'); ?>
        <div class="w mt10">
            <!--
            <div class="search-type clearfix">
                <div class="float-left btn-type">
                    <a href="javascript:;" class="current">促销商品列表</a>
                </div>
                <?php echo $this->fetch('page.top.html'); ?>                              
            </div>
            -->
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
                        <div class="item-prices">
                            <span class="price"><?php echo price_format($this->_var['goods']['pro_price']); ?></span><em><?php echo price_format($this->_var['goods']['price']); ?></em>
                            <div class="action">马上抢</div>
                        </div>   
                        
                        <!--
                        <div class="buy"><span class="price"></span><del><?php echo $this->_var['goods']['price']; ?></del><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"></a></div>
                        -->
                    </li>
                    </a>
                    <?php endforeach; else: ?>
                    <div>没有促销商品</div>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
                <?php echo $this->fetch('page.bottom.html'); ?>
            </div>    
        </div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>