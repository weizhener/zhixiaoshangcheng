<?php echo $this->fetch('header.html'); ?>
<?php echo $this->fetch('top.html'); ?>
<div class="w-full"  area="top_ad_area" widget_type="area">
    <?php $this->display_widgets(array('page'=>'index','area'=>'top_ad_area')); ?>
</div>
<div class="w"  area="top_main_area" widget_type="area">
    <?php $this->display_widgets(array('page'=>'index','area'=>'top_main_area')); ?>
</div>
<div id="content">
    <div id="left">
        <?php echo $this->fetch('left.html'); ?>
    </div>
    <div id="right">
        <div class="die6"><?php echo html_filter($this->_var['store']['description']); ?></div>
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
                                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['rgoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['rgoods']['default_image']; ?>" width="150" height="150" /></a></div>
                                <h3><a href="<?php echo url('app=goods&id=' . $this->_var['rgoods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['rgoods']['goods_name']); ?></a></h3>
                                <p><?php echo price_format($this->_var['rgoods']['price']); ?></p>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($this->_var['new_groupbuy'] && $this->_var['store']['functions']['groupbuy'] && $this->_var['store']['enable_groupbuy']): ?>
        <div class="module_special">
            <h2 class="common_title veins2">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">最新团购</span></span>
            </h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="group_major">
                        <ul class="list">
                            <?php $_from = $this->_var['new_groupbuy']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'groupbuy');if (count($_from)):
    foreach ($_from AS $this->_var['groupbuy']):
?>
                            <li>
                                <div class="pic"><a href="<?php echo url('app=groupbuy&id=' . $this->_var['groupbuy']['group_id']. ''); ?>"><img src="<?php echo $this->_var['groupbuy']['default_image']; ?>" /></a></div>
                                <h3><a href="<?php echo url('app=groupbuy&id=' . $this->_var['groupbuy']['group_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['groupbuy']['group_name']); ?></a></h3>
                                <p><span>团购价:&nbsp;</span><?php echo price_format($this->_var['groupbuy']['price']); ?></p>
                                <div class="time">剩余:&nbsp;<?php echo $this->_var['groupbuy']['lefttime']; ?></div>
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
                                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['ngoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['ngoods']['default_image']; ?>" width="150" height="150" /></a></div>
                                <h3><a href="<?php echo url('app=goods&id=' . $this->_var['ngoods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['ngoods']['goods_name']); ?></a></h3>
                                <p><?php echo price_format($this->_var['ngoods']['price']); ?></p>
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
    </div>

    <div class="clear"></div>
</div>

<?php echo $this->fetch('footer.html'); ?>
