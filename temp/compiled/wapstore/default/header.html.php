
<div class="header clearfix" style="text-align: center;color: #fff;line-height: 40px;">
    <a class="logo" href="<?php echo url('app=default'); ?>"></a>
    
    商品详情
    <a href="javascript:void(0)" class="new-a-jd"><span>下拉</span></a>
</div>    
<script>
$(function () {
    $(".new-a-jd").click(function () {
        $(".new-jd-tab").fadeToggle();
    })
})
</script>
<div class="new-jd-tab" style="display:none;">
    <div class="new-tbl-type">
        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" class="new-tbl-cell">
            <span class="icon">首页</span>
            <p style="color:#6e6e6e;">首页</p>
        </a>
        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>" class="new-tbl-cell">
            <span class="icon2">分类搜索</span>
            <p style="color:#6e6e6e;">分类搜索</p>
        </a>
        <a href="<?php echo url('app=cart'); ?>" id="html5_cart" class="new-tbl-cell">
            <span class="icon3">购物车</span>
            <p style="color:#6e6e6e;">购物车</p>
        </a>
        <a href="<?php echo url('app=member'); ?>" class="new-tbl-cell">
            <span class="icon4">我的商城</span>
            <p style="color:#6e6e6e;">我的商城</p>
        </a>
    </div>
</div>


