<?php echo $this->fetch('member.header.html'); ?>

<div class="content">

    <?php echo $this->fetch('member.menu.html'); ?>

    <div id="right">

        <?php echo $this->fetch('member.curlocal.html'); ?>



        <div class="profile clearfix">

            <div class="photo">

                <p><img src="<?php echo $this->_var['user']['portrait']; ?>" width="80" height="80" alt="" /></p>

            </div>

            <div class="info clearfix">

                <dl class="col-1 fleft">

                    <dt>
                       <span>欢迎您，</span><strong><?php echo htmlspecialchars($this->_var['user']['user_name']); ?></strong>     
					   <?php if ($this->_var['yesstore'] == '1'): ?>
					   
					   <?php if ($this->_var['storetime'] == '1'): ?>
					   <span class="epay_btn" style="vertical-align:middle;"><a href="<?php echo url('app=store&act=coupon'); ?>">签到</a></span>
					   <?php else: ?>           
                       <span class="epay_btn" style="vertical-align:middle;"><a href="<?php echo url('app=renew'); ?>">店铺续费</a></span>
					   <?php endif; ?>
					   
					   
					   
					   <?php else: ?>           
                       <span class="epay_btn" style="vertical-align:middle;"><a href="<?php echo url('app=apply'); ?>">开通店铺</a></span>
					   <?php endif; ?>
                    
                    </dt>

                    <dd>

                        <span>上次登录时间：<?php echo local_date("Y-m-d H:i:s",$this->_var['user']['last_login']); ?></span>

                        <span>上次登录 IP：<?php echo $this->_var['user']['last_ip']; ?></span>

                    </dd>

                    <dd><?php echo sprintf('您有 <em class="red">%s</em> 条短消息，<a href="index.php?app=message&act=newpm">点击查看</a>', $this->_var['new_message']); ?></dd>
                    
                    
                    <dd>
                        <?php $_from = $this->_var['epay']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['val']):
?>
                        余额：<span style="font-size:16px;font-weight:bold;color:#FE5400; padding-right:0;"><?php echo $this->_var['val']['money']; ?></span> <span class="epay_btn" style="vertical-align:middle;"><a href="<?php echo url('app=epay&act=withdraw'); ?>">提现</a></span> 
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </dd>

                    <dd>
		
		                积分：<span style="font-size:16px;font-weight:bold;color:#FE5400; padding-right:0;"><?php echo $this->_var['user']['integral']; ?></span>

                    </dd>
					

                    <!--<dd>
		
		                星币：<span style="font-size:16px;font-weight:bold; color:#FE5400;"><?php echo $this->_var['user']['shopmoney']; ?></span>

                    </dd>-->
					

                </dl>

                <?php if ($this->_var['store'] && $this->_var['member_role'] == 'seller_admin'): ?>

                <dl class="col-2 fleft">

                    <dt><strong>店铺动态评分</strong></dt>

                    <dd>卖家信用：<a href="<?php echo url('app=store&act=credit&id=' . $this->_var['store']['store_id']. ''); ?>" target="_blank"><?php echo $this->_var['store']['credit_value']; ?></a><?php if ($this->_var['store']['credit_value'] >= 0): ?> <img src="<?php echo $this->_var['store']['credit_image']; ?>" align="absmiddle" /> <?php endif; ?>

                    </dd>

                    <dd>卖家好评率：<?php echo $this->_var['store']['praise_rate']; ?>%</dd>

                </dl>

                <?php endif; ?>

            </div>

        </div>



        <div class="platform clearfix">

            <div class="col-1">

                <div class="buyer-notice box-notice box">

                    <div class="hd clearfix"><h2>买家提醒</h2></div>

                    <div class="bd dealt">

                        <div class="list">

                            <h4>您需要立即处理：</h4>

                            <dl class="clearfix">

                                <dt>订单提醒：</dt>

                                <dd>

                                    <span><?php echo sprintf('<a href="index.php?app=buyer_order&type=pending">待付款订单(<em>%s</em>)</a>', $this->_var['buyer_stat']['pending']); ?></span>

                                    <span><?php echo sprintf('<a href="index.php?app=buyer_order&type=shipped">待确认的订单(<em>%s</em>)</a>', $this->_var['buyer_stat']['shipped']); ?></span>

                                    <span><?php echo sprintf('<a href="index.php?app=buyer_order&type=finished">待评价的订单(<em>%s</em>)</a>', $this->_var['buyer_stat']['finished']); ?></span>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>团购提醒：</dt>

                                <dd>

                                    <span><?php echo sprintf('<a href="index.php?app=buyer_groupbuy&state=finished">待付款的团购(<em>%s</em>)</a>', $this->_var['buyer_stat']['groupbuy_finished']); ?></span>

                                    <span><?php echo sprintf('<a href="index.php?app=buyer_groupbuy&state=canceled">已取消的团购(<em>%s</em>)</a>', $this->_var['buyer_stat']['groupbuy_canceled']); ?></span>

                                </dd>

                            </dl>

                        </div>

                        <div class="extra"></div>

                    </div>

                </div>

                <?php if ($this->_var['store'] && $this->_var['member_role'] == 'seller_admin'): ?>

                <div class="seller-notice box-notice box">

                    <div class="hd clearfix">

                        <h2>卖家提醒</h2>

                        <p></p>

                    </div>

                    <div class="bd">

                        <div class="list">

                            <dl class="clearfix">

                                <dt>订单提醒：</dt>

                                <dd>

                                    <span><?php echo sprintf('<a href="index.php?app=seller_order&type=submitted">待处理的订单(<em>%s</em>)</a>', $this->_var['seller_stat']['submitted']); ?></span>

                                    <span><?php echo sprintf('<a href="index.php?app=seller_order&type=accepted">待发货的订单(<em>%s</em>)</a>', $this->_var['seller_stat']['accepted']); ?></span>

                                </dd>

                            </dl>

                            <dl class="clearfix">

                                <dt>团购提醒：</dt>

                                <dd>

                                    <span><?php echo sprintf('<a href="index.php?app=seller_groupbuy&state=end">待确认的团购(<em>%s</em>)</a>', $this->_var['seller_stat']['groupbuy_end']); ?></span>

                                </dd>

                            </dl>

                        </div>

                        <div class="extra">

                            <span>店铺等级：<?php echo $this->_var['sgrade']['grade_name']; ?></span>

                            <span>有效期：<?php if ($this->_var['sgrade']['add_time']): ?><?php echo sprintf('剩余 %s 天', $this->_var['sgrade']['add_time']); ?><?php else: ?>不限制<?php endif; ?></span>

                            <span>商品发布：<?php echo $this->_var['sgrade']['goods']['used']; ?>/<?php if ($this->_var['sgrade']['goods']['total']): ?><?php echo $this->_var['sgrade']['goods']['total']; ?><?php else: ?>不限制<?php endif; ?></span>

                            <span>空间使用：<?php echo $this->_var['sgrade']['space']['used']; ?>M/<?php if ($this->_var['sgrade']['space']['total']): ?><?php echo $this->_var['sgrade']['space']['total']; ?>M<?php else: ?>不限制<?php endif; ?></span>

                        </div>

                    </div>

                </div>

                <?php endif; ?>

                <?php if ($this->_var['_member_menu']['overview']): ?>

                <div class="apply-notice box-notice box">

                    <div class="hd clearfix"><h2>开店提醒</h2></div>

                    <div class="bd">

                        <div class="extra">

                            <?php if ($this->_var['applying']): ?>

                            <?php echo sprintf('您的店铺正在审核中。你可以：<a href="index.php?app=apply&step=2&id=%s">查看或修改店铺信息</a>', $this->_var['user']['sgrade']); ?>

                            <?php else: ?>

                            您目前不是卖家，您可以：<a href="<?php echo $this->_var['_member_menu']['overview']['url']; ?>" title="<?php echo $this->_var['_member_menu']['overview']['text']; ?>"><?php echo $this->_var['_member_menu']['overview']['text']; ?></a>

                            <?php endif; ?>

                        </div> 

                    </div>

                </div>

                <?php endif; ?>

            </div>

            <div class="col-2">

                <div class="mall-notice box">

                    <div class="hd clearfix"><h2>商城公告</h2></div>

                    <ul class="bd">

                        <?php $_from = $this->_var['system_notice']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'article');if (count($_from)):
    foreach ($_from AS $this->_var['article']):
?>

                        <li><a href="<?php echo url('app=article&act=view&article_id=' . $this->_var['article']['article_id']. ''); ?>" target="_blank"><?php echo sub_str(htmlspecialchars($this->_var['article']['title']),30); ?></a></li>

                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                    </ul>

                </div>

                <div class="mall-customer box">

                    <div class="hd"><h2>平台客服联系方式</h2></div>

                    <ul class="bd">

                        <li>联系电话：<?php echo $this->_var['site_phone_tel']; ?></li>

                        <li>电子邮件：<?php echo $this->_var['site_email']; ?></li>

                    </ul>

                </div>

            </div>

        </div>

    </div>

    <div class="clear"></div>

</div>

<?php echo $this->fetch('footer.html'); ?>

