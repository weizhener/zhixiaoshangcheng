<?php echo $this->fetch('footer_order_notice.html'); ?>
<div id="footer" class="w-full">

    <div id="service-2014" class="clearfix">
        <div class="slogen">
            <span class="item fore1">
                <i></i><b>多</b>品类齐全，轻松购物
            </span>
            <span class="item fore2">
                <i></i><b>快</b>多仓直发，极速配送
            </span>
            <span class="item fore3">
                <i></i><b>好</b>正品行货，精致服务
            </span>
            <span class="item fore4">
                <i></i><b>省</b>天天低价，畅选无忧
            </span>
        </div>
        <div class="w" style="width:1000px">
           
           <?php $_from = $this->_var['foot_acategory_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'acategory');$this->_foreach['fe_hot_acategory'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_hot_acategory']['total'] > 0):
    foreach ($_from AS $this->_var['acategory']):
        $this->_foreach['fe_hot_acategory']['iteration']++;
?>
    <dl class="fore1">
      <dt><?php echo $this->_var['acategory']['cate_name']; ?></dt>
      <dd> 
        <?php $_from = $this->_var['acategory']['news']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'news');$this->_foreach['fe_hot_news'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_hot_news']['total'] > 0):
    foreach ($_from AS $this->_var['news']):
        $this->_foreach['fe_hot_news']['iteration']++;
?>
        <div><a style="font-size:16px;line-height:30px" target="_blank" href="index.php?app=article&act=view&article_id=<?php echo $this->_var['news']['article_id']; ?>"><?php echo $this->_var['news']['title']; ?></a></div>
        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
      </dd>
    </dl>
    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
           
            
            <span class="clr"></span>
        </div>
    </div>

    <div id="footer-2014" class="w" style="width">
        <div class="copyright"><?php echo $this->_var['copyright']; ?><br> <?php if ($this->_var['icp_number']): ?><?php echo $this->_var['icp_number']; ?><?php endif; ?> <?php echo $this->_var['statistics_code']; ?></div>

        <div class="authentication">
			<a href="javascript:;"><img src="static/images/bt_logo_1.png" /></a>
			<a href="javascript:;"><img src="static/images/bt_logo_2.png" /></a>
			<a href="javascript:;"><img src="static/images/bt_logo_3.png" /></a>
        </div>
    </div>

<?php echo $this->_var['async_sendmail']; ?>

    <div class="mui-mbar-tabs clearfix">
        <div class="mui-mbar-tabs-mask ">
            <div class="mui-mbar-tab mui-mbar-tab-cart" style="top: 120px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-cart"></div>
                <div class="mui-mbar-tab-txt"><a href="<?php echo url('app=cart'); ?>">购物车</a></div>
                <div class="mui-mbar-tab-sup">
                    <div class="mui-mbar-tab-sup-bg">
                        <div class="mui-mbar-tab-sup-bd"><?php echo $this->_var['cart_goods_kinds']; ?></div>
                    </div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-asset" style="top: 260px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-asset"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=member'); ?>">我的资产</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-brand" style="top: 300px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-brand"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=my_favorite&type=store'); ?>">收藏的店铺</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-favor" style="top: 340px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-favor"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=my_favorite'); ?>">收藏的产品</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-foot" style="top: 380px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-foot"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=history'); ?>">我看过的</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-qrcode" style="top: 420px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-qrcode"></div>
                <div class="mui-mbar-tab-tip mui-mbarp-qrcode-tip" style="right: 35px;  display: none;">
                    <div class="mui-mbarp-qrcode-hd">
                        <img src="<?php echo $this->_var['default_qrcode']; ?>" width="140" height="140">
                    </div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-ue" style="top: 460px;">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-ue"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="<?php echo url('app=customer_message&type=1'); ?>">用户反馈</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>
            <div class="mui-mbar-tab mui-mbar-tab-top" style="bottom: 180px;" id="gotop">
                <div class="mui-mbar-tab-logo mui-mbar-tab-logo-top"></div>
                <div class="mui-mbar-tab-tip" style="right: 35px;  display: none;">
                    <a href="javascript:void(0)">返回顶部</a>
                    <div class="mui-mbar-arr mui-mbar-tab-tip-arr">◆</div>
                </div>
            </div>

        </div>
    </div>
    <script>
        $(function() {
            var screen_height = window.screen.height;
            $(".mui-mbar-tabs-mask").css("height", screen_height);
            $('.mui-mbar-tab').hover(function() {
                $(this).addClass("mui-mbar-tab-hover");
                $(this).find('.mui-mbar-tab-tip').fadeIn(500);
            }, function() {
                $(this).removeClass("mui-mbar-tab-hover");
                $(this).find('.mui-mbar-tab-tip').fadeOut(500);
            });
        });

    </script>
</div>

</body>
</html>