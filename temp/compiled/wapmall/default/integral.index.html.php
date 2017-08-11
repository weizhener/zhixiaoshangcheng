<?php echo $this->fetch('header.html'); ?>

<link type="text/css" href="<?php echo $this->res_base . "/" . 'css/integral.css'; ?>" rel="stylesheet"  />

<div id="integral">   

    

    <div class="integral_floor">

        <div class="mt">

            <h3>积分回购</h3>

        </div>

        <div class="mc clearfix" style="padding: 20px 0">

            <ul class="clearfix">

                <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>

                <li>

                    <div class="pic">

                        <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['goods']['goods_logo']; ?>" /></a>

                    </div>



                    <div class="goods_name">

                        <a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>

                        <span class="icon"></span>

                    </div>

                    <div class="goods_price">

                        <?php echo price_format($this->_var['goods']['goods_point']); ?>

                    </div>

                    <div class="goods_integral">

                        <a href="index.php?app=integral&act=view&id=<?php echo $this->_var['goods']['goods_id']; ?>" >立即兑换</a>

                    </div>

                </li>

                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            </ul>

            <?php if (! $this->_var['goods_list_order']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>

        </div>

        

    </div>

    

    

</div>





<?php echo $this->fetch('footer.html'); ?>