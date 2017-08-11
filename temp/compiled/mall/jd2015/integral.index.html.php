<?php echo $this->fetch('header.html'); ?>

<link type="text/css" href="<?php echo $this->res_base . "/" . 'css/integral.css'; ?>" rel="stylesheet"  />

<div id="integral"  class="w-full">

    <div  class="col-1 clearfix" area="col-1" widget_type="area">

        <?php $this->display_widgets(array('page'=>'integral','area'=>'col-1')); ?>

    </div>





    <div  class="col-2 w clearfix" area="col-2" widget_type="area">

        <?php $this->display_widgets(array('page'=>'integral','area'=>'col-2')); ?>

    </div>





    <div class="integral_floor w clearfix">

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

                        <a href="javascript:;" target="_blank" ><img src="<?php echo $this->_var['goods']['goods_logo']; ?>" /></a>

                    </div>



                    <div class="goods_name">

                        <a href="javascript:;" target="_blank"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a>

                        <span class="icon"></span>

                    </div>

                    <div class="goods_price">

                        <?php echo price_format($this->_var['goods']['goods_point']); ?>

                    </div>

                    <div class="btn">

                        <a href="index.php?app=integral&act=view&id=<?php echo $this->_var['goods']['goods_id']; ?>" >立即兑换</a>

                    </div>

                </li>

                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            </ul>

            <?php if (! $this->_var['goods_list_order']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>

        </div>



    </div>















    <div  class="col-3 w clearfix" area="col-3" widget_type="area">

        <?php $this->display_widgets(array('page'=>'integral','area'=>'col-3')); ?>

    </div>





</div>





<?php echo $this->fetch('footer.html'); ?>