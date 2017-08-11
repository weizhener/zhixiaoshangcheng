<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
//<!CDATA[
$(function(){
    $("select[ectype='order_by']").change(function(){
        var params = location.search.substr(1).split('&');
        var key    = 'order';
        var value  = this.value;
        var found  = false;
        for (var i = 0; i < params.length; i++)
        {
            param = params[i];
            arr   = param.split('=');
            pKey  = arr[0];
            if (pKey == 'page')
            {
                params[i] = 'page=1';
            }
            if (pKey == key)
            {
                params[i] = key + '=' + value;
                found = true;
            }
        }
        if (!found)
        {
            params.push(key + '=' + value);
        }
        location.assign(SITE_URL + '/index.php?' + params.join('&'));
    });
});
//]]>
</script>

<?php echo $this->fetch('top.html'); ?>

<div id="content">
    <div id="left">
        <?php echo $this->fetch('left.html'); ?>
    </div>
    
    <div id="right">
        <div class="module_special">
            <h2 class="common_title veins2">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2"><?php echo htmlspecialchars($this->_var['search_name']); ?></span></span>
            </h2>
            <div class="wrap">
                <div class="wrap_child">
                    <?php if ($this->_var['searched_goods']): ?>
                    <div class="major">
                        <ul class="list">
                            <?php $_from = $this->_var['searched_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'sgoods');if (count($_from)):
    foreach ($_from AS $this->_var['sgoods']):
?>
                            <li>
                                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['sgoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['sgoods']['default_image']; ?>" width="150" height="150" /></a></div>
                                <h3><a href="<?php echo url('app=goods&id=' . $this->_var['sgoods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['sgoods']['goods_name']); ?></a></h3>
                                <p><?php echo price_format($this->_var['sgoods']['price']); ?></p>
                            </li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <?php echo $this->fetch('page.bottom.html'); ?>
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