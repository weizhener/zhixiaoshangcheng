<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit">商品管理</div>
    <a href="javascript" class="r_b"></a>
</div>
<div style="overflow-x:hidden;">


<div class="user_header">
    <div class="user_photo">
        <a href="<?php echo url('app=member'); ?>"><img src="<?php echo $this->res_base . "/" . 'images/user.jpg'; ?>" /></a>
    </div>
    <span class="user_name">
        您好,欢迎<?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?><br/>
        <a href="index.php?app=member&act=logout" style="color:#999;">退出</a>
    </span>
    <div class="order_panel">
        <ul class="orders">
            <a href="<?php echo url('app=my_goods'); ?>">
                <li  style="width:43%;">
                    <span class="num  on"></span>
                    <span>全部商品</span>
                </li>
            </a>
            <a href="<?php echo url('app=my_goods&act=add'); ?>">
                <li  style="width:43%;">
                    <span class="num"></span>
                    <span>新增商品</span>
                    <b></b>
                </li>
            </a>
        </ul>
    </div>
</div>

<div class="u_order">
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['_goods_f'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['_goods_f']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['_goods_f']['iteration']++;
?>
    <div class="orderbox">
        <div class="detail">
            <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"> <img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['goods']['default_image']; ?>" /></a>
            <p class="title"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></p>
            <p>​商品分类：<?php echo $this->_var['goods']['cate_name']; ?></p>​
            <p>价格：<?php echo $this->_var['goods']['price']; ?><span> 库存：<?php echo $this->_var['goods']['stock']; ?></span></p>
        </div>
        <p class="opr">
            <a href="<?php echo url('app=my_goods&act=edit&id=' . $this->_var['goods']['goods_id']. ''); ?>"  class="white_btn">编辑</a>
            <a href="index.php?app=my_goods&amp;act=drop&id=<?php echo $this->_var['goods']['goods_id']; ?>"  class="white_btn">删除</a>
        </p>
    </div>
    <?php endforeach; else: ?>
    <div class="null" style="display:none; margin-top:120px;">
        <p>你没有添加商品~</p>
    </div>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>

<div class="page">
    <?php echo $this->fetch('member.page.bottom.html'); ?>
</div>
</div>
<?php echo $this->fetch('member.footer.html'); ?>