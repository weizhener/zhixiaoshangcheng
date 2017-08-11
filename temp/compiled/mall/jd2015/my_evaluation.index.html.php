<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
<?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap" style="border-top: 1px solid #e2e2e2;">
            <div class="personal-rating">
                <?php if ($this->_var['evaluation'] && $_GET['type'] == 'from_buyer'): ?>
                <h4>店铺动态评分</h4>
                <table class="seller-rate-info" id="sixmonth">
                    <tbody>
                        <tr>
                            <th><p>宝贝与描述相符</p>
                    <p class="rate-star mt5"><em><i style=" width:<?php echo $this->_var['evaluation']['evaluation_desc']['5']; ?>%;"></i></em></p></th>
                    <td><dl class="ncs-rate-column">
                            <dt><em style="left:<?php echo $this->_var['evaluation']['evaluation_desc']['5']; ?>%;"><?php echo $this->_var['evaluation']['evaluation_desc']['average_score']; ?></em></dt>
                            <dd>非常不满</dd>
                            <dd>不满意</dd>
                            <dd>一般</dd>
                            <dd>满意</dd>
                            <dd>非常满意</dd>
                        </dl></td>
                    </tr>
                    <tr>
                        <th><p>卖家的服务态度</p>
                    <p class="rate-star mt5"><em><i style="width:<?php echo $this->_var['evaluation']['evaluation_service']['5']; ?>%;"></i></em></p></th>
                    <td><dl class="ncs-rate-column">
                            <dt><em style="left:<?php echo $this->_var['evaluation']['evaluation_service']['5']; ?>%;"><?php echo $this->_var['evaluation']['evaluation_service']['average_score']; ?></em></dt>
                            <dd>非常不满</dd>
                            <dd>不满意</dd>
                            <dd>一般</dd>
                            <dd>满意</dd>
                            <dd>非常满意</dd>
                        </dl></td>
                    </tr>
                    <tr>
                        <th><p>卖家的发货速度</p>
                    <p class="rate-star mt5"><em><i style="width:<?php echo $this->_var['evaluation']['evaluation_speed']['5']; ?>%;"></i></em></p></th>
                    <td><dl class="ncs-rate-column">
                            <dt><em style="left:<?php echo $this->_var['evaluation']['evaluation_speed']['5']; ?>%;"><?php echo $this->_var['evaluation']['evaluation_speed']['average_score']; ?></em></dt>
                            <dd>非常不满</dd>
                            <dd>不满意</dd>
                            <dd>一般</dd>
                            <dd>满意</dd>
                            <dd>非常满意</dd>
                        </dl></td>
                    </tr>
                    </tbody>
                </table>
                <?php endif; ?>

                <?php if ($this->_var['store'] && $_GET['type'] == 'from_buyer'): ?>
                <h4><strong>卖家累积信用：<?php echo $this->_var['store']['credit_value']; ?></strong>
                    <img src='<?php echo $this->_var['store']['credit_image']; ?>' title='<?php echo $this->_var['store']['credit_value']; ?>'/>
                    <span class="rate-summary">好评率：<strong><?php echo $this->_var['store']['praise_rate']; ?>%</strong></span> </h4>
                <table class="buyer-rate-info ncgeval">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th class="ncgeval-good"><span class="ico"></span>好评</th>
                            <th class="ncgeval-normal"><span class="ico"></span>中评</th>
                            <th class="ncgeval-bad"><span class="ico"></span>差评</th>
                            <th>总计</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>最近1周</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['3']['in_a_week']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['2']['in_a_week']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['1']['in_a_week']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['0']['in_a_week']; ?></td>
                        </tr>
                        <tr>
                            <td>最近1个月</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['3']['in_a_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['2']['in_a_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['1']['in_a_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['0']['in_a_month']; ?></td>
                        </tr>
                        <tr>
                            <td>最近6个月</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['3']['in_six_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['2']['in_six_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['1']['in_six_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['0']['in_six_month']; ?></td>
                        </tr>
                        <tr>
                            <td>6个月前</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['3']['six_month_before']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['2']['six_month_before']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['1']['six_month_before']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['0']['six_month_before']; ?></td>
                        </tr>
                        <tr>
                            <td>总计</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['3']['total']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['2']['total']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['1']['total']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['seller_stats']['0']['total']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
                <?php if ($this->_var['member'] && $_GET['type'] == 'from_seller'): ?>
                <h4><strong>买家累积信用：<?php echo $this->_var['member']['buyer_credit_value']; ?></strong>
                    <img src="<?php echo $this->_var['member']['credit_image']; ?>" title='<?php echo $this->_var['member']['buyer_credit_value']; ?>'/>
                    <span class="rate-summary">好评率：<strong><?php echo $this->_var['member']['buyer_praise_rate']; ?>%</strong></span> </h4>
                <table class="buyer-rate-info ncgeval">
                    <thead>
                        <tr>
                            <th>&nbsp;</th>
                            <th class="ncgeval-good"><span class="ico"></span>好评</th>
                            <th class="ncgeval-normal"><span class="ico"></span>中评</th>
                            <th class="ncgeval-bad"><span class="ico"></span>差评</th>
                            <th>总计</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>最近1周</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['3']['in_a_week']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['2']['in_a_week']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['1']['in_a_week']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['0']['in_a_week']; ?></td>
                        </tr>
                        <tr>
                            <td>最近1个月</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['3']['in_a_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['2']['in_a_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['1']['in_a_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['0']['in_a_month']; ?></td>
                        </tr>
                        <tr>
                            <td>最近6个月</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['3']['in_six_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['2']['in_six_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['1']['in_six_month']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['0']['in_six_month']; ?></td>
                        </tr>
                        <tr>
                            <td>6个月前</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['3']['six_month_before']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['2']['six_month_before']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['1']['six_month_before']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['0']['six_month_before']; ?></td>
                        </tr>
                        <tr>
                            <td>总计</td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['3']['total']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['2']['total']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['1']['total']; ?></td>
                            <td bgcolor="#FFFFFF"><?php echo $this->_var['buyer_stats']['0']['total']; ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
                 
            </div>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_goods.js'; ?>" charset="utf-8"></script>
<script>
    $(function() {
        $("[ectype='evalscore']").change(function() {
            replaceParam('evalscore', this.value);
            return false;
        });
        $("[ectype='havecontent']").change(function() {
            replaceParam('havecontent', this.value);
            return false;
        });
    });
</script>
            <div class="goods-list-evaluation" id='list_pj'>
                <table class="ncu-table-style">
                    <thead>
                        <tr>
                            <th class="w70">
                                <select name="evalscore" ectype="evalscore">
                                    <option value="0">评价</option>
                                    <option value="3" <?php if ($_GET['evalscore'] == '3'): ?> selected="selected"<?php endif; ?>>好评</option>
                                    <option value="2" <?php if ($_GET['evalscore'] == '2'): ?> selected="selected"<?php endif; ?>>中评</option>
                                    <option value="1" <?php if ($_GET['evalscore'] == '1'): ?> selected="selected"<?php endif; ?>>差评</option>
                                </select>
                            </th>
                            <th class="w220 tl"> 
                                <select name="havecontent" ectype="havecontent">
                                    <option value="0">评论</option>
                                    <option value="1" <?php if ($_GET['havecontent'] == '1'): ?> selected="selected"<?php endif; ?>>无评论内容</option>
                                    <option value="2" <?php if ($_GET['havecontent'] == '2'): ?> selected="selected"<?php endif; ?>>有评论内容</option>
                                </select>
                            </th>
                            <th class="w100">评价人</th>
                            <th class="tl">宝贝信息</th>
                            <th class="w90">操作</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if ($_GET['type'] == 'from_buyer'): ?>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
                        <tr class="bd-line ncgeval">
                            <td class="<?php if ($this->_var['goods']['evaluation'] == '3'): ?>ncgeval-good<?php elseif ($this->_var['goods']['evaluation'] == '2'): ?>ncgeval-normal<?php elseif ($this->_var['goods']['evaluation'] == '1'): ?>ncgeval-bad<?php endif; ?>"><span class="ico"></span></td>
                            <td class="tl">
                                <p><?php echo $this->_var['goods']['comment']; ?></p>
                                <p class="date">[<?php echo local_date("Y-m-d H:i:s",$this->_var['goods']['evaluation_time']); ?>]</p>
                            </td>
                            <td>
                                <p><?php echo htmlspecialchars($this->_var['goods']['buyer_name']); ?></p>
                                <p><img src='<?php echo $this->_var['goods']['buyer_credit_image']; ?>' title='<?php echo $this->_var['goods']['buyer_credit_value']; ?>'/></p>
                            </td>
                            <td class="tl">
                                <p><a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                                <p><?php echo price_format($this->_var['goods']['price']); ?>元</p>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="20" class="norecord"><i>&nbsp;</i><span>暂无符合条件的数据记录</span></td>
                        </tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php endif; ?>
                        
                        <?php if ($_GET['type'] == 'from_seller'): ?>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
                        <tr class="bd-line ncgeval">
                            <td class="<?php if ($this->_var['goods']['seller_evaluation'] == '3'): ?>ncgeval-good<?php elseif ($this->_var['goods']['seller_evaluation'] == '2'): ?>ncgeval-normal<?php elseif ($this->_var['goods']['seller_evaluation'] == '1'): ?>ncgeval-bad<?php endif; ?>"><span class="ico"></span></td>
                            <td class="tl">
                                <p><?php echo $this->_var['goods']['seller_comment']; ?></p>
                                <p class="date">[<?php echo local_date("Y-m-d H:i:s",$this->_var['goods']['seller_evaluation_time']); ?>]</p>
                            </td>
                            <td>
                                <p><?php echo htmlspecialchars($this->_var['goods']['seller_name']); ?></p>
                                <p><img src='<?php echo $this->_var['goods']['seller_credit_image']; ?>' title='<?php echo $this->_var['goods']['seller_credit_value']; ?>'/></p>
                            </td>
                            <td class="tl">
                                <p><a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                                <p><?php echo price_format($this->_var['goods']['price']); ?>元</p>
                            </td>
                            <td>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="20" class="norecord"><i>&nbsp;</i><span>暂无符合条件的数据记录</span></td>
                        </tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php endif; ?>
                        
                        <?php if ($_GET['type'] == 'to_buyer'): ?>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
                        <tr class="bd-line ncgeval">
                            <td class="<?php if ($this->_var['goods']['seller_evaluation'] == '3'): ?>ncgeval-good<?php elseif ($this->_var['goods']['seller_evaluation'] == '2'): ?>ncgeval-normal<?php elseif ($this->_var['goods']['seller_evaluation'] == '1'): ?>ncgeval-bad<?php endif; ?>"><span class="ico"></span></td>
                            <td class="tl">
                                <p><?php echo $this->_var['goods']['seller_comment']; ?></p>
                                <p class="date">[<?php echo local_date("Y-m-d H:i:s",$this->_var['goods']['seller_evaluation_time']); ?>]</p>
                            </td>
                            <td>
                                <p><?php echo htmlspecialchars($this->_var['goods']['buyer_name']); ?></p>
                                <p><img src='<?php echo $this->_var['goods']['buyer_credit_image']; ?>' title='<?php echo $this->_var['goods']['buyer_credit_value']; ?>'/></p>
                            </td>
                            <td class="tl">
                                <p><a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                                <p><?php echo price_format($this->_var['goods']['price']); ?>元</p>
                            </td>
                            <td>
                                <?php if ($this->_var['goods']['seller_evaluation'] != '3'): ?><a href="<?php echo url('app=my_evaluation&act=edit_buyer&rec_id=' . $this->_var['goods']['rec_id']. ''); ?>" class="ncu-btn2 mt5">改为好评</a><?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="20" class="norecord"><i>&nbsp;</i><span>暂无符合条件的数据记录</span></td>
                        </tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php endif; ?>
                        
                        <?php if ($_GET['type'] == 'to_seller'): ?>
                        <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');$this->_foreach['fe_goods'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_goods']['total'] > 0):
    foreach ($_from AS $this->_var['goods']):
        $this->_foreach['fe_goods']['iteration']++;
?>
                        <tr class="bd-line ncgeval">
                            <td class="<?php if ($this->_var['goods']['evaluation'] == '3'): ?>ncgeval-good<?php elseif ($this->_var['goods']['evaluation'] == '2'): ?>ncgeval-normal<?php elseif ($this->_var['goods']['evaluation'] == '1'): ?>ncgeval-bad<?php endif; ?>"><span class="ico"></span></td>
                            <td class="tl">
                                <p><?php echo $this->_var['goods']['comment']; ?></p>
                                <p class="date">[<?php echo local_date("Y-m-d H:i:s",$this->_var['goods']['evaluation_time']); ?>]</p>
                            </td>
                            <td>
                                <p><?php echo htmlspecialchars($this->_var['goods']['seller_name']); ?></p>
                                <p><img src='<?php echo $this->_var['goods']['seller_credit_image']; ?>' title='<?php echo $this->_var['goods']['seller_credit_value']; ?>'/></p>
                            </td>
                            <td class="tl">
                                <p><a target="_blank" href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></a></p>
                                <p><?php echo price_format($this->_var['goods']['price']); ?>元</p>
                            </td>
                            <td>
                                <?php if ($this->_var['goods']['evaluation'] != '3'): ?><a href="<?php echo url('app=my_evaluation&act=edit_seller&rec_id=' . $this->_var['goods']['rec_id']. ''); ?>" class="ncu-btn2 mt5">改为好评</a><?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; else: ?>
                        <tr>
                            <td colspan="20" class="norecord"><i>&nbsp;</i><span>暂无符合条件的数据记录</span></td>
                        </tr>
                        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        <?php endif; ?>



                    </tbody>


                </table>
                <div style="border-top: solid 1px #C4D5E0;"></div>
                <?php echo $this->fetch('member.page.bottom.html'); ?>
                <div class="clear"></div>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<iframe id='iframe_post' name="iframe_post" frameborder="0" width="0" height="0">
</iframe>
<?php echo $this->fetch('footer.html'); ?>
