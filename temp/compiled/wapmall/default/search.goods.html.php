<?php echo $this->fetch('header.html'); ?>    
<div class="mb-head">
    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>
    <div class="tit">产品搜索</div>
    <a href="<?php echo url('app=category'); ?>" class="r_b">分类</a>
</div>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_goods.js'; ?>" charset="utf-8"></script>
<script>
    $(function () {
        $("*[ectype='wap_order_by'] a").click(function () {
            replaceParam('order', this.id + " desc");
            return false;
        });
    });
</script>

<section class="search_goods_options" id="sort_order">
    <ul class="s-items" ectype='wap_order_by'>
        <li><a href="javascript:void(0);" <?php if ($_GET['order'] == ' sales desc '): ?>class="selected" <?php endif; ?>id="sales" >销量<span class="decollator">|</span></a></li>
        <li><a href="javascript:void(0);" id="price">价格<span class="decollator">|</span></a></li>
        <li><a href="javascript:void(0);" id="add_time">新品<span class="decollator">|</span></a></li>
        <li><a href="javascript:void(0);" id="comments">好评<span class="decollator">|</span></a></li>
    </ul>
</section>


<section class="search_goods">
    <?php if (! $this->_var['goods_list_order']): ?>
    <ul class="list">

        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
        <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>">
            <li>
                <img src="<?php echo $this->_var['goods']['default_image']; ?>" alt="<?php echo $this->_var['goods']['name']; ?>"/>
                <div class="detail">
                    <p class="title"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p>
                    <p class="price"><?php echo price_format($this->_var['goods']['price']); ?></p>
                    <p class="sales">已售：<em><?php echo htmlspecialchars($this->_var['goods']['sales_info']); ?></em></p>
                </div>
            </li>
        </a>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </ul>
    <?php else: ?>
    <center style="font-size:16px;">没有找到相关的商品！</center>
    <?php endif; ?>
    <?php echo $this->fetch('page.bottom.html'); ?>
</section>

<?php echo $this->fetch('footer.html'); ?>