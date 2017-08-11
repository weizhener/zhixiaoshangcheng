<?php echo $this->fetch('header.html'); ?>

<?php echo $this->fetch('top.html'); ?>
<?php echo $this->fetch('goodsinfo.html'); ?>
<div id="content">
    <?php echo $this->fetch('goods.relation.html'); ?>

    <div id="left">
        <?php echo $this->fetch('left.html'); ?>
    </div>

    <div id="right">

        <div id="module">
            <ul class="user_menu">
                <li><a class="active" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>商品详情</span></a></li>
                <li><a class="normal" href="<?php echo url('app=goods&act=comments&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>商品评论</span></a></li>
                <li><a class="normal" href="<?php echo url('app=goods&act=saleslog&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>销售记录</span></a></li>
                <li><a class="normal" href="<?php echo url('app=goods&act=qa&id=' . $this->_var['goods']['goods_id']. ''); ?>#module"><span>产品咨询</span></a></li>
            </ul>
        </div>

        <div class="option_box">


            
            <?php if ($this->_var['props']): ?>
            <div style="background:#F5F5F5;margin-bottom:20px;margin-top:10px;border:1px #E2E2E2 solid;">
                <?php $_from = $this->_var['props']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'prop');if (count($_from)):
    foreach ($_from AS $this->_var['prop']):
?>
                <div style="float:left;width:32%;padding:5px; height:20px; line-height:20px;background:#F5F5F5">
                    <?php echo $this->_var['prop']['name']; ?>：<?php echo $this->_var['prop']['value']; ?>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <div style="clear:both;height:0; display:block; overflow:hidden"></div>
            </div>
            <?php endif; ?>
            


            <div class="default"><?php echo html_filter($this->_var['goods']['description']); ?></div>
        </div>
        <?php if ($this->_var['goods']['related_info']['count'] > 0): ?>
        <div class="module_currency">
            <h2 class="common_title veins1">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">相关信息(TAG相关)</span></span>
            </h2>
            <dl class="related_list">
                <?php $_from = $this->_var['goods']['related_info']['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'app_data');if (count($_from)):
    foreach ($_from AS $this->_var['app_data']):
?>
                <?php if ($this->_var['app_data']['data'] && $this->_var['app_data']['app_type'] != 'ECMALL'): ?>
                <dt><a href="<?php echo $this->_var['app_data']['app_url']; ?>"><?php echo $this->_var['app_data']['app_name']; ?></a></dt>
                <?php $_from = $this->_var['app_data']['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                <dd><?php echo $this->_var['item']; ?></dd>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </dl>
        </div>
        <?php endif; ?>
        <div class="clear"></div>
    </div>

    <div class="clear"></div>
</div>

<?php echo $this->fetch('footer.html'); ?>
