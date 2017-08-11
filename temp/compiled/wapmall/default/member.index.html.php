<?php echo $this->fetch('member.header.html'); ?>

<div class="mb-head">

    <a href="<?php echo url('app=default'); ?>" class="l_b">首页</a>

    <div class="tit">个人中心</div>

    <a href="javascript" class="r_b"></a>

</div>

<div style="overflow-x:hidden;">



<div class="user_header">

    <div class="user_photo">

        <a href="<?php echo url('app=member'); ?>"><img src="<?php echo $this->_var['user']['portrait']; ?>" /></a>

    </div>

    <span class="user_name">

        <div>会员名:<?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?> <a href="index.php?app=member&act=logout" style="color:#999;margin-left:5px;">退出</a></div>

		<div class="anniu"><a href="index.php?app=refer">分享</a>
		
		
					   <?php if ($this->_var['yesstore'] == '1'): ?>
					   
					   <?php if ($this->_var['storetime'] == '1'): ?>
					   <span class="epay_btn" style="vertical-align:middle;"><a href="<?php echo url('app=store&act=coupon'); ?>">签到</a></span>
					   <?php else: ?>           
                       <span class="epay_btn" style="vertical-align:middle;"><a href="<?php echo url('app=renew'); ?>">店铺续费</a></span>
					   <?php endif; ?>
					   
					   
					   
					   <?php else: ?>           
                       <span class="epay_btn" style="vertical-align:middle;"><a href="<?php echo url('app=apply'); ?>">开通店铺</a></span>
					   <?php endif; ?>
		
		
		</div>

    </span>

</div>



<section class="member_index">

    <div class="info">

       

        <?php $_from = $this->_var['epay']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>

        <dl>

            <dd>账户现金</dd>

            <dt><?php echo $this->_var['val']['money']; ?></dt>

        </dl>

        <dl>

            <dd>帐户积分</dd>

            <dt><?php echo $this->_var['user']['integral']; ?></dt>

        </dl>
		
        <!--<dl style="width:34%">

            <dd>帐户星币</dd>

            <dt><?php echo $this->_var['user']['shopmoney']; ?></dt>

        </dl>-->
		

        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        <dl>

            <dd>待付款订单</dd>

            <dt><?php echo $this->_var['buyer_stat']['pending']; ?></dt>

        </dl>

        <dl>

            <dd>待收货订单</dd>

            <dt><?php echo $this->_var['buyer_stat']['shipped']; ?></dt>

        </dl>

        <div class="clear"></div>

    </div>

    <ul>

        <li>

            <a href="<?php echo url('app=my_favorite'); ?>">

                <span class="ico" style="background:#993399"><em class="iconfont">&#xf00b9;</em></span>

                <span class="title">商品收藏</span>

            </a>

        </li>

        <li>

            <a href="<?php echo url('app=my_favorite&type=store'); ?>">

                <span class="ico" style="background:#99CC66"><em class="iconfont">&#xf00eb;</em></span>

                <span class="title">店铺收藏</span>

            </a>

        </li>

        <li>

            <a href="<?php echo url('app=my_address'); ?>">

                <span class="ico" style="background:#FF99CC"><em class="iconfont">&#x343a;</em></span>

                <span class="title">收货地址</span>

            </a>

        </li>

        <li>

            <a href="<?php echo url('app=buyer_order'); ?>">

                <span class="ico" style="background:#FF6666"><em class="iconfont">&#xf00b8;</em></span>

                <span class="title">我的订单</span>

            </a>

        </li>

        <li>

            <a href="http://m.kuaidi100.com/">

                <span class="ico" style="background:#CC6699"><em class="iconfont">&#x345d;</em></span>

                <span class="title">物流查询</span>

            </a>

        </li>

        <li>

            <a href="<?php echo url('app=member&act=password'); ?>">

                <span class="ico" style="background:#339999"><em class="iconfont">&#xf0109;</em></span>

                <span class="title">修改密码</span>

            </a>

        </li>

        <li>

            <a href="<?php echo url('app=member&act=profile'); ?>">

                <span class="ico" style="background:#FF99CC"><em class="iconfont">&#xf00fc;</em></span>

                <span class="title">修改信息</span>

            </a>

        </li>

      

        <li>

            <a href="<?php echo url('app=epay&act=czlist'); ?>">

                <span class="ico" style="background:#99CC66"><em class="iconfont">&#xf00ee;</em></span>

                <span class="title">资金管理</span>

            </a>

        </li>

       

     

    </ul>

</section>





<section class="member_index">



    <?php if ($this->_var['yesstore'] == '1'): ?>
	
	<?php if ($this->_var['storetime'] == '1'): ?>

    <div class="info">

        <dl>

            <dd>待处理的订单</dd>

            <dt><?php echo $this->_var['seller_stat']['submitted']; ?></dt>

        </dl>

        <dl>

            <dd>待发货的订单</dd>

            <dt><?php echo $this->_var['seller_stat']['accepted']; ?></dt>

        </dl>

        <dl>

            <dd>店铺等级</dd>

            <dt><?php echo $this->_var['sgrade']['grade_name']; ?></dt>

        </dl>

        <dl>

            <dd>有效期</dd>

            <dt><?php if ($this->_var['sgrade']['add_time']): ?><?php echo sprintf('剩余 %s 天', $this->_var['sgrade']['add_time']); ?><?php else: ?>不限制<?php endif; ?></dt>

        </dl>

        <dl>

            <dd>商品发布</dd>

            <dt><?php echo $this->_var['sgrade']['goods']['used']; ?>/<?php if ($this->_var['sgrade']['goods']['total']): ?><?php echo $this->_var['sgrade']['goods']['total']; ?><?php else: ?>不限制<?php endif; ?></dt>

        </dl>

        <dl>

            <dd>空间使用</dd>

            <dt><?php echo $this->_var['sgrade']['space']['used']; ?>M/<?php if ($this->_var['sgrade']['space']['total']): ?><?php echo $this->_var['sgrade']['space']['total']; ?>M<?php else: ?>不限制<?php endif; ?></dt>

        </dl>

        <div class="clear"></div>

    </div>

    <ul>

        <li>

            <a href="<?php echo url('app=my_store'); ?>">

                <span class="ico" style="background:#CC6699"><em class="iconfont">&#xf00eb;</em></span>

                <span class="title">店铺设置</span>

            </a>

        </li>

        <!--<li>

            <a href="<?php echo url('app=my_goods'); ?>">

                <span class="ico" style="background:#003399"><em class="iconfont">&#xf00b5;</em></span>

                <span class="title">商品管理</span>

            </a>

        </li>-->

        <li>

            <a href="<?php echo url('app=seller_order'); ?>">

                <span class="ico" style="background:#66CC99"><em class="iconfont">&#xf0133;</em></span>

                <span class="title">订单管理</span>

            </a>

        </li>
		

        <!--<li>

            <a href="<?php echo url('app=my_payment'); ?>">

                <span class="ico" style="background:#CC6699"><em class="iconfont">&#xf00ae;</em></span>

                <span class="title">支付管理</span>

            </a>

        </li>

        <li>

            <a href="<?php echo url('app=my_shipping'); ?>">

                <span class="ico" style="background:#FF6666"><em class="iconfont">&#xf0078;</em></span>

                <span class="title">配送管理</span>

            </a>

        </li>
-->
        <li>

            <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>">

                <span class="ico" style="background:#FF6666"><em class="iconfont">&#xf00b3;</em></span>

                <span class="title">我的店铺</span>

            </a>

        </li>


    </ul>



<?php endif; ?>

    <?php endif; ?>



</section>

</div>



<?php echo $this->fetch('member.footer.html'); ?>