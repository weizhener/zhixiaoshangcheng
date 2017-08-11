        <div class="user">
            <div class="user_photo">
                <h2><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></h2>
                <div class="photo"><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><img src="<?php echo $this->_var['store']['store_logo']; ?>" width="100" height="100" /></a></div>
                <p><a href="javascript:collect_store(<?php echo $this->_var['store']['store_id']; ?>)">收藏该店铺</a></p>
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
                    <span>店主: </span><?php echo htmlspecialchars($this->_var['store']['store_owner']['user_name']); ?>
                    <a target="_blank" href="<?php echo url('app=message&act=send&to_id=' . htmlspecialchars($this->_var['store']['store_owner']['user_id']). ''); ?>"><img src="<?php echo $this->res_base . "/" . 'images/web_mail.gif'; ?>" alt="发站内信" /></a>
                </p>
                <p>
                    <span>信用度: </span><span class="fontColor1"><?php echo $this->_var['store']['credit_value']; ?></span>
                    <?php if ($this->_var['store']['credit_value'] >= 0): ?><img src="<?php echo $this->_var['store']['credit_image']; ?>" alt="" /><?php endif; ?>
                </p>
                <p>店铺等级: <?php echo $this->_var['store']['sgrade']; ?></p>
                <p>商品数量: <?php echo $this->_var['store']['goods_count']; ?></p>
                <p>所在地区: <?php echo htmlspecialchars($this->_var['store']['region_name']); ?></p>
                <p>创店时间: <?php echo local_date("Y-m-d",$this->_var['store']['add_time']); ?></p>
                <?php if ($this->_var['store']['certifications']): ?>
                <p>
                    <span>认证: </span>
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
                <!--<p>详细地址: <?php echo htmlspecialchars($this->_var['store']['address']); ?></p>-->
                <?php endif; ?>
                <?php if ($this->_var['store']['tel']): ?>
                <!--<p>联系电话: <?php echo htmlspecialchars($this->_var['store']['tel']); ?></p>-->
                <?php endif; ?>
                <p>
                    <?php if ($this->_var['store']['im_qq']): ?>
                    <a href="http://wpa.qq.com/msgrd?V=1&amp;uin=<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>&amp;Site=<?php echo htmlspecialchars($this->_var['store']['store_name']); ?>&amp;Menu=yes" target="_blank"><img src="http://wpa.qq.com/pa?p=1:<?php echo htmlspecialchars($this->_var['store']['im_qq']); ?>:4" alt="QQ"></a>
                    <?php endif; ?>
                    <?php if ($this->_var['store']['im_ww']): ?>
                    <a target="_blank" href="http://amos.im.alisoft.com/msg.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" ><img border="0" src="http://amos.im.alisoft.com/online.aw?v=2&uid=<?php echo urlencode($this->_var['store']['im_ww']); ?>&site=cntaobao&s=2&charset=<?php echo $this->_var['charset']; ?>" alt="Wang Wang" /></a>
                    <?php endif; ?>
                    <?php if ($this->_var['store']['im_msn']): ?>
                    <a target="_blank" href="http://settings.messenger.live.com/Conversation/IMMe.aspx?invitee=<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>"><img src="http://messenger.services.live.com/users/<?php echo htmlspecialchars($this->_var['store']['im_msn']); ?>/presenceimage/" alt="status" /></a>
                    <?php endif; ?>
                </p>
            </div>
            <div class="clear"></div>
        </div>

            <div class="message-bar">
                <h2 class="common_title veins1">
                    <div class="ornament1"></div>
                    <div class="ornament2"></div>
                    <span class="ico1"><span class="ico2">客服中心</span></span>
                </h2>
                <div class="content">
                    <?php if ($this->_var['store']['pre_connects']): ?>
                    <dl>
                        <dt>售前客服：</dt>
                        <?php $_from = $this->_var['store']['pre_connects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pre_connect');$this->_foreach['fe_pre_connect'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_pre_connect']['total'] > 0):
    foreach ($_from AS $this->_var['pre_connect']):
        $this->_foreach['fe_pre_connect']['iteration']++;
?>
                        <dd>
                            <span><?php echo htmlspecialchars($this->_var['pre_connect']['name']); ?></span>
                            <span>
                                <?php if ($this->_var['pre_connect']['type'] == '1'): ?>
                                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo htmlspecialchars($this->_var['pre_connect']['num']); ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo htmlspecialchars($this->_var['pre_connect']['num']); ?>:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
                                <?php elseif ($this->_var['pre_connect']['type'] == '2'): ?>
                                <a target="_blank" href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=<?php echo htmlspecialchars($this->_var['pre_connect']['num']); ?>&amp;siteid=cntaobao&amp;status=1&amp;charset=utf-8"><img border="0" src="http://amos.alicdn.com/realonline.aw?v=2&amp;uid=<?php echo htmlspecialchars($this->_var['pre_connect']['num']); ?>&amp;site=cntaobao&amp;s=1&amp;charset=utf-8" alt="有事点这里"></a>
                                <?php endif; ?>
                            </span>
                        </dd>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </dl>
                    <?php endif; ?>
                    <?php if ($this->_var['store']['after_connects']): ?>
                    <dl>
                        <dt>售后客服：</dt>
                        <?php $_from = $this->_var['store']['after_connects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'after_connect');$this->_foreach['fe_after_connect'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_after_connect']['total'] > 0):
    foreach ($_from AS $this->_var['after_connect']):
        $this->_foreach['fe_after_connect']['iteration']++;
?>
                        <dd>
                            <span><?php echo htmlspecialchars($this->_var['after_connect']['name']); ?></span>
                            <span>
                                <?php if ($this->_var['after_connect']['type'] == '1'): ?>
                                <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo htmlspecialchars($this->_var['after_connect']['num']); ?>&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo htmlspecialchars($this->_var['after_connect']['num']); ?>:51" alt="点击这里给我发消息" title="点击这里给我发消息"/></a>
                                <?php elseif ($this->_var['after_connect']['type'] == '2'): ?>
                                <a target="_blank" href="http://www.taobao.com/webww/ww.php?ver=3&amp;touid=<?php echo htmlspecialchars($this->_var['after_connect']['num']); ?>&amp;siteid=cntaobao&amp;status=1&amp;charset=utf-8"><img border="0" src="http://amos.alicdn.com/realonline.aw?v=2&amp;uid=<?php echo htmlspecialchars($this->_var['after_connect']['num']); ?>&amp;site=cntaobao&amp;s=1&amp;charset=utf-8" alt="有事点这里"></a>
                                <?php endif; ?>
                            </span>
                        </dd>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </dl>
                    <?php endif; ?>
                    <?php if ($this->_var['store']['working_time']): ?>
                    <dl>
                        <dt>工作时间：</dt>
                        <dd><p><?php echo $this->_var['store']['working_time']; ?></p></dd>
                    </dl>
                    <?php endif; ?>
                </div>
            </div>
        
        <div class="module_common">
            <h2 class="common_title veins1">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">店内搜索</span></span>
            </h2>
            <div class="wrap">
                <div class="wrap_child">
                    <div class="web_search">
                        <form id="" name="" method="get" action="index.php">
                            <input type="hidden" name="app" value="store" />
                            <input type="hidden" name="act" value="search" />
                            <input type="hidden" name="id" value="<?php echo $this->_var['store']['store_id']; ?>" />
                            <input class="text width4" type="text" name="keyword" />
                            <input class="btn" type="submit" value="" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="module_common">
            <h2 class="common_title veins1">
                <div class="ornament1"></div>
                <div class="ornament2"></div>
                <span class="ico1"><span class="ico2">商品分类</span></span>
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
        
        <?php if ($_GET['app'] == "store" && $_GET['act'] == "index"): ?>
        <div class="module_common">
            <h2 class="common_title veins1">
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
        
        <?php if ($_GET['app'] == "goods"): ?>
        <div class="module_common">
            <h2 class="common_title veins1">
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
                        <li><a href="<?php echo url('app=goods&id=' . $this->_var['gh_goods']['goods_id']. ''); ?>"><img src="<?php echo $this->_var['gh_goods']['default_image']; ?>" width="50" height="50" alt="<?php echo htmlspecialchars(sub_str($this->_var['gh_goods']['goods_name'],20)); ?>" title="<?php echo htmlspecialchars($this->_var['gh_goods']['goods_name']); ?>" /></a></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php endif; ?>