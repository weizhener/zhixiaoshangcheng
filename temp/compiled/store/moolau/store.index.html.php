<?php echo $this->fetch('header.html'); ?>
<?php echo $this->fetch('top.html'); ?>

<div id="mystore" class="w auto clearfix">
   <div class="col-sub w190">
      <?php echo $this->fetch('left.html'); ?>
   </div>
   <div class="col-main w750">    
       <!--<div><?php echo html_filter($this->_var['store']['description']); ?></div>-->
       
       <?php echo $this->fetch('store.slides.html'); ?>
		
        <?php if ($this->_var['recommended_goods']): ?>
        <div class="module_special">
            <h2 class="common_title veins2">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">推荐商品</span></span>
            </h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="major">
                        <ul class="list">
                            <?php $_from = $this->_var['recommended_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'rgoods');if (count($_from)):
    foreach ($_from AS $this->_var['rgoods']):
?>
                            <li>
                                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['rgoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['rgoods']['default_image']; ?>" width="160" height="160" /></a></div>
                                <h3><a href="<?php echo url('app=goods&id=' . $this->_var['rgoods']['goods_id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['rgoods']['goods_name']),50); ?></a></h3>
                                <p><em></em><?php echo price_format($this->_var['rgoods']['price']); ?></p>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
        
        <?php if ($this->_var['hot_sale_goods']): ?>
        <div class="module_special">
            <h2 class="common_title veins2">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">热卖商品</span></span>
            </h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="major">
                        <ul class="list">
                            <?php $_from = $this->_var['hot_sale_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'hsgoods');if (count($_from)):
    foreach ($_from AS $this->_var['hsgoods']):
?>
                            <li>
                                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['hsgoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['hsgoods']['default_image']; ?>" width="160" height="160" /></a></div>
                                <h3><a href="<?php echo url('app=goods&id=' . $this->_var['hsgoods']['goods_id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['hsgoods']['goods_name']),50); ?></a></h3>
                                <p><em></em><?php echo price_format($this->_var['hsgoods']['price']); ?></p>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <div class="module_special">
            <h2 class="common_title veins2">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">新品</span></span>
            </h2>
            <div class="wrap">
                <div class="wrap_child">
                    <?php if ($this->_var['new_goods']): ?>
                    <div class="major">
                        <ul class="list">
                            <?php $_from = $this->_var['new_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ngoods');if (count($_from)):
    foreach ($_from AS $this->_var['ngoods']):
?>
                            <li>
                                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['ngoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['ngoods']['default_image']; ?>" width="160" height="160" /></a></div>
                                <h3><a href="<?php echo url('app=goods&id=' . $this->_var['ngoods']['goods_id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['ngoods']['goods_name']),50); ?></a></h3>
                                <p><em></em><?php echo price_format($this->_var['ngoods']['price']); ?></p>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <?php else: ?>
                    <div class="nothing"><p>很抱歉! 没有找到相关商品</p></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
      
        <?php if ($this->_var['new_groupbuy']): ?>
        <div class="module_special">
            <h2 class="common_title veins2">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">最新团购</span></span>
            </h2>
            <div class="wrap">
                <div class="wrap_child">
                <div class="major">
                    <ul class="list groupbuy">
                        <?php $_from = $this->_var['new_groupbuy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'groupbuy');if (count($_from)):
    foreach ($_from AS $this->_var['groupbuy']):
?>
                        <li>
                            <div class="pic"><a href="<?php echo url('app=groupbuy&id=' . $this->_var['groupbuy']['group_id']. ''); ?>"><img width="160" height="160" src="<?php echo $this->_var['groupbuy']['default_image']; ?>" /></a></div>
                            <h3><a href="<?php echo url('app=groupbuy&id=' . $this->_var['groupbuy']['group_id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['groupbuy']['group_name']),50); ?></a></h3>
                            <p><em></em><?php echo price_format($this->_var['groupbuy']['price']); ?></p>
                            <div class="auto center">剩余：<?php echo $this->_var['groupbuy']['lefttime']; ?></div>
                        </li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
      
   </div>
</div>

<?php echo $this->fetch('footer.html'); ?>
