<div id="store-owner" class="w190 box">
    <div class="title">商家信息</div>
    <div class="content border">
        <div class="user-service clearfix">
            <a href="javascript：;" class="service-1">正品保障</a>
            <a href="javascript：;" class="service-2">提供发票</a>
            <a href="javascript：;" class="service-3">七天退换</a>
        </div>
        <div class="user_evaluation clearfix">
            <h4>动态评价</h4>
            <dl class="rate">
                <dt>描述相符：</dt>
                <dd class="rate-star"><em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['average_score']; ?>分"><i style=" width: <?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['5']; ?>%;"></i></em><span><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['average_score']; ?>分</span></dd>
                <dt>服务态度：</dt>
                <dd class="rate-star"><em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_service']['average_score']; ?>分"><i style=" width: <?php echo $this->_var['store']['store_evaluation']['evaluation_service']['5']; ?>%;"></i></em><span><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['average_score']; ?>分</span></dd>
                <dt>发货速度：</dt>
                <dd class="rate-star"><em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['average_score']; ?>分"><i style=" width: <?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['5']; ?>%;"></i></em><span><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['average_score']; ?>分</span></dd>
            </dl>
        </div>
        <div class="user_data">
            <p>
                <span>店主：</span><?php echo htmlspecialchars($this->_var['store']['store_owner']['user_name']); ?>
                <a target="_blank" href="<?php echo url('app=message&act=send&to_id=' . htmlspecialchars($this->_var['store']['store_owner']['user_id']). ''); ?>"><img src="<?php echo $this->res_base . "/" . 'images/web_mail.gif'; ?>" alt="发站内信" align="absmiddle"/></a>
            </p>
            <p>
                <span>信用度：</span><span class="fontColor1"><?php echo $this->_var['store']['credit_value']; ?></span>
                <?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" align="absmiddle"/><?php endif; ?>
            </p>
            <p>店铺等级：<?php echo $this->_var['store']['sgrade']; ?></p>
            <p>商品数量：<?php echo $this->_var['store']['goods_count']; ?></p>
            <p>所在地区：<?php echo htmlspecialchars($this->_var['store']['region_name']); ?></p>
            <p>创店时间：<?php echo local_date("Y-m-d",$this->_var['store']['add_time']); ?></p>
            <?php if ($this->_var['store']['certifications']): ?>
            <p>
                <span>认证：</span>
                <span>
                    <?php $_from = $this->_var['store']['certifications']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cert');if (count($_from)):
    foreach ($_from AS $this->_var['cert']):
?>
                    <?php if ($this->_var['cert'] == "autonym"): ?>
                    <a href="<?php echo url('app=article&act=system&code=cert_autonym'); ?>" target="_blank" title="实名认证"><img src="<?php echo $this->res_base . "/" . 'images/cert_autonym.gif'; ?>" /></a>
                    <?php elseif ($this->_var['cert'] == "material"): ?>
                    <a href="<?php echo url('app=article&act=system&code=cert_material'); ?>" target="_blank" title="实体店铺"><img src="<?php echo $this->res_base . "/" . 'images/cert_material.gif'; ?>" /></a>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </span>
            </p>
            <?php endif; ?>
            <?php if ($this->_var['store']['address']): ?>
            <!--<p>详细地址：<?php echo htmlspecialchars($this->_var['store']['address']); ?></p>-->
            <?php endif; ?>
            <?php if ($this->_var['store']['tel']): ?>
            <!--<p>联系电话：<?php echo htmlspecialchars($this->_var['store']['tel']); ?></p>-->
            <?php endif; ?>
            <p>
                客服：<?php if ($this->_var['store']['im_qq']): ?>
                <a href="http://wpa.qq.com/msgrd?V=1&amp;uin=<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>&amp;Site=<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>:4" alt="QQ" align="absmiddle"></a>
                <?php endif; ?>
                <?php if ($this->_var['store']['im_ww']): ?>
                <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" alt="Wang Wang" align="absmiddle"/></a>
                <?php endif; ?>
                <?php if ($this->_var['store']['im_msn']): ?>
                <a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>"><img src="http://messenger.services.live.com/users/<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>/presenceimage/" alt="status" align="absmiddle"/></a>
                <?php endif; ?>
            </p>
        </div>
        <div class="enter-store"><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"></a></div>
        <div class="collect-the-store"><a href="javascript:collect_store(<?php echo $this->_var['store']['store_id']; ?>)">收藏该店铺</a></div>       
    </div>
</div>

        <div class="user_data">
            <p>
                <span>店主：</span><?php echo htmlspecialchars($this->_var['store']['store_owner']['user_name']); ?>
                <a target="_blank" href="<?php echo url('app=message&act=send&to_id=' . htmlspecialchars($this->_var['store']['store_owner']['user_id']). ''); ?>"><img src="<?php echo $this->res_base . "/" . 'images/web_mail.gif'; ?>" alt="发站内信" align="absmiddle"/></a>
            </p>
            <p>
                <span>信用度：</span><span class="fontColor1"><?php echo $this->_var['store']['credit_value']; ?></span>
                <?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" align="absmiddle"/><?php endif; ?>
            </p>
            <p>店铺等级：<?php echo $this->_var['store']['sgrade']; ?></p>
            <p>商品数量：<?php echo $this->_var['store']['goods_count']; ?></p>
            <p>所在地区：<?php echo htmlspecialchars($this->_var['store']['region_name']); ?></p>
            <p>创店时间：<?php echo local_date("Y-m-d",$this->_var['store']['add_time']); ?></p>
            <?php if ($this->_var['store']['certifications']): ?>
            <p>
                <span>认证：</span>
                <span>
                    <?php $_from = $this->_var['store']['certifications']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cert');if (count($_from)):
    foreach ($_from AS $this->_var['cert']):
?>
                    <?php if ($this->_var['cert'] == "autonym"): ?>
                    <a href="<?php echo url('app=article&act=system&code=cert_autonym'); ?>" target="_blank" title="实名认证"><img src="<?php echo $this->res_base . "/" . 'images/cert_autonym.gif'; ?>" /></a>
                    <?php elseif ($this->_var['cert'] == "material"): ?>
                    <a href="<?php echo url('app=article&act=system&code=cert_material'); ?>" target="_blank" title="实体店铺"><img src="<?php echo $this->res_base . "/" . 'images/cert_material.gif'; ?>" /></a>
                    <?php endif; ?>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </span>
            </p>
            <?php endif; ?>
            <?php if ($this->_var['store']['address']): ?>
            <p>详细地址：<?php echo htmlspecialchars($this->_var['store']['address']); ?></p>
            <?php endif; ?>
            <?php if ($this->_var['store']['tel']): ?>
            <p>联系电话：<?php echo htmlspecialchars($this->_var['store']['tel']); ?></p>
            <?php endif; ?>
            <p>
                客服：<?php if ($this->_var['store']['im_qq']): ?>
                <a href="http://wpa.qq.com/msgrd?V=1&amp;uin=<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>&amp;Site=<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>:4" alt="QQ" align="absmiddle"></a>
                <?php endif; ?>
                <?php if ($this->_var['store']['im_ww']): ?>
                <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" alt="Wang Wang" align="absmiddle"/></a>
                <?php endif; ?>
                <?php if ($this->_var['store']['im_msn']): ?>
                <a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>"><img src="http://messenger.services.live.com/users/<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>/presenceimage/" alt="status" align="absmiddle"/></a>
                <?php endif; ?>
            </p>
        </div>

<div class="module_common">
    <h2 class="common_title">
        <span class="ico1"><span class="ico2">店内搜索</span></span>
    </h2>
    <div class="wrap">
        <div class="wrap_child">
            <div class="web_search" style="margin-top:0;">
                <form id="" name="" method="get" action="index.php">
                    <input type="hidden" name="app" value="store" />
                    <input type="hidden" name="act" value="search" />
                    <input type="hidden" name="id" value="<?php echo $this->_var['store']['store_id']; ?>" />
                    <label>关键字</label>
                    <input type="text" name="keyword" style="width:110px;border:1px #ccc solid; height:20px; line-height:20px;" value="<?php echo $_GET['keyword']; ?>" />
                    <input class="btn" type="submit" value="搜索" />
                </form>
            </div>
        </div>
    </div>
</div>

<div class="module_common store-category">
    <h2 class="common_title">
        <div class="ornament1"></div>
        <div class="ornament2"></div>
        <span class="ico1">商品分类</span>
    </h2>
    <div class="wrap">
        <div class="wrap_child">
            <ul class="submenu">
                <li><a class="none_ico" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search'); ?>">全部商品</a></li>
                <?php $_from = $this->_var['store']['store_gcates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['gcategory']):
?>
                <?php if ($this->_var['gcategory']['children']): ?>
                <li>
                    <a class="block_ico" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search&cate_id=' . $this->_var['gcategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></a>
                    <ul>
                        <?php $_from = $this->_var['gcategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child_gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['child_gcategory']):
?>
                        <li><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search&cate_id=' . $this->_var['child_gcategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['child_gcategory']['value']); ?></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </li>
                <?php else: ?>
                <li><a class="none_ico" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search&cate_id=' . $this->_var['gcategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></a></li>
                <?php endif; ?>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
</div>


<?php if ($this->_var['store']['hot_saleslist'] || $this->_var['store']['collect_goodslist']): ?>
<div class="module_common">
    <div class="gindex_lefttitle common_title"><span class="ico2">商品排行榜</span></div>
    <div class="gindex_leftcontent wrap" id="rank">
        <ul class="rank-nav" id="rank-11">
            <li class="curr" id="one"><a><span>热门销售排行</span></a></li>
            <li id="two"><a><span>热门收藏排行</span></a></li>
        </ul>
        <ul class="rank-c clearfix" id="rank-one">
            <?php $_from = $this->_var['store']['hot_saleslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'h_goods');$this->_foreach['fe_saleslist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_saleslist']['total'] > 0):
    foreach ($_from AS $this->_var['h_goods']):
        $this->_foreach['fe_saleslist']['iteration']++;
?>
            <li <?php if (($this->_foreach['fe_saleslist']['iteration'] == $this->_foreach['fe_saleslist']['total'])): ?>style="border:0;"<?php endif; ?>>
                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['h_goods']['goods_id']. ''); ?>">
                        <img width="60" height="60" style="border:1px #ddd solid;" src="<?php echo $this->_var['h_goods']['default_image']; ?>"alt="<?php echo htmlspecialchars(sub_str($this->_var['h_goods']['goods_name'],20)); ?>" title="<?php echo htmlspecialchars($this->_var['h_goods']['goods_name']); ?>" /></a></div>
                <div class="desc"><a href="<?php echo url('app=goods&id=' . $this->_var['h_goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['h_goods']['goods_name']); ?></a></div>
                <div class="price"><strong><?php echo $this->_var['h_goods']['price']; ?>元</strong></div>
                <div class="sale">已售出 <strong><?php echo $this->_var['h_goods']['sales']; ?></strong> 件</div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
        <ul class="rank-c clearfix" id="rank-two" style="display:none;">
            <?php $_from = $this->_var['store']['collect_goodslist']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'c_goods');$this->_foreach['fe_collectlist'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_collectlist']['total'] > 0):
    foreach ($_from AS $this->_var['c_goods']):
        $this->_foreach['fe_collectlist']['iteration']++;
?>
            <li <?php if (($this->_foreach['fe_collectlist']['iteration'] == $this->_foreach['fe_collectlist']['total'])): ?>style="border:0;"<?php endif; ?>>
                <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['c_goods']['goods_id']. ''); ?>">
                        <img width="60" height="60" style="border:1px #ddd solid;" src="<?php echo $this->_var['c_goods']['default_image']; ?>"alt="<?php echo htmlspecialchars(sub_str($this->_var['c_goods']['goods_name'],20)); ?>" title="<?php echo htmlspecialchars($this->_var['c_goods']['goods_name']); ?>" /></a></div>
                <div class="desc"><a href="<?php echo url('app=goods&id=' . $this->_var['c_goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['c_goods']['goods_name']); ?></a></div>
                <div class="price"><strong><?php echo $this->_var['c_goods']['price']; ?>元</strong></div>
                <div class="collecter">收藏人气&nbsp;&nbsp;<?php echo $this->_var['c_goods']['collects']; ?></div>
            </li>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </ul>
    </div>
</div>
<script>
    $(function() {
        $('#rank #one').hover(function() {
            $(this).parent().find('li').attr('class', '');
            $(this).attr('class', 'curr');

            $('#rank').find('.rank-c').hide();
            $('#rank #rank-' + this.id).show();
        });

        $('#rank #two').hover(function() {
            $(this).parent().find('li').attr('class', '');
            $(this).attr('class', 'curr');

            $('#rank').find('.rank-c').hide();
            $('#rank #rank-' + this.id).show();
        });
    });
</script>
<?php endif; ?>

<?php if ($this->_var['store']['left_rec_goods'] && ( $_GET['act'] == 'index' || $_GET['app'] == 'goods' )): ?>
<div class="module_common">
    <h2 class="common_title">
        <div class="ornament1"></div>
        <div class="ornament2"></div>
        <span class="ico1"><span class="ico2">热门商品</span></span>
    </h2>
    <div class="wrap">
        <div class="major">
            <ul class="list" style="width:188px; text-align:center">
                <?php $_from = $this->_var['store']['left_rec_goods']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'recgoods');if (count($_from)):
    foreach ($_from AS $this->_var['recgoods']):
?>
                <li>
                    <div class="pic"><a href="<?php echo url('app=goods&id=' . $this->_var['recgoods']['goods_id']. ''); ?>" target="_blank"><img src="<?php echo $this->_var['recgoods']['default_image']; ?>" width="160" height="160" /></a></div>
                    <h3><a href="<?php echo url('app=goods&id=' . $this->_var['recgoods']['goods_id']. ''); ?>" target="_blank"><?php echo htmlspecialchars($this->_var['recgoods']['goods_name']); ?></a></h3>
                    <p><em></em><?php echo price_format($this->_var['recgoods']['price']); ?></p>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($_GET['app'] == "store" && $_GET['act'] == "index"): ?>
<div class="module_common">
    <h2 class="common_title">
        <div class="ornament1"></div>
        <div class="ornament2"></div>
        <span class="ico1"><span class="ico2">友情链接</span></span>
    </h2>
    <div class="wrap">
        <div class="wrap_child">
            <ul class="submenu">
                <?php $_from = $this->_var['partners']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'partner');if (count($_from)):
    foreach ($_from AS $this->_var['partner']):
?>
                <li><a class="link_ico" href="<?php echo $this->_var['partner']['link']; ?>" target="_blank"><?php echo htmlspecialchars($this->_var['partner']['title']); ?></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>

<?php if ($_GET['app'] == "goods" && $this->_var['goods_history']): ?>
<div class="module_common">
    <h2 class="common_title">
        <div class="ornament1"></div>
        <div class="ornament2"></div>
        <span class="ico1"><span class="ico2">浏览历史</span></span>
    </h2>
    <div class="wrap">
        <div class="wrap_child">
            <ul class="annals">
                <?php $_from = $this->_var['goods_history']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gh_goods');if (count($_from)):
    foreach ($_from AS $this->_var['gh_goods']):
?>
                <li><a href="<?php echo url('app=goods&id=' . $this->_var['gh_goods']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['gh_goods']['default_image']; ?>" width="40" height="40" alt="<?php echo htmlspecialchars(sub_str($this->_var['gh_goods']['goods_name'],20)); ?>" title="<?php echo htmlspecialchars($this->_var['gh_goods']['goods_name']); ?>" /></a></li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
        </div>
    </div>
</div>
<?php endif; ?>