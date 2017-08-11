<script>
    $(document).ready(function(){
        $(".J_RateInfoTrigger").mouseenter(function(){
            $(".J_RateInfoTrigger").each(function(){
                $(this).removeClass("selected");
            });
            $(this).addClass("selected");
        });
    });
</script>

<link href="<?php echo $this->res_base . "/" . 'evaluation/evaluation.css'; ?>" rel="stylesheet" type="text/css" />
<div class="evaluation-shadow evaluation">
    <div class="bd">
        <div class="con">
            
            <h4 >店铺动态评分</h4>
            <div class="seller-rate-info">
                <ul>
                    <li class="J_RateInfoTrigger  selected">
                        <div class="item-scrib">
                            <span class="title">宝贝与描述相符：</span>
                            <em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['average_score']; ?>分" class="count"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['average_score']; ?></em>分 
                            <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['total']['state']): ?><em><strong class="percent <?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['total']['state']; ?>"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['total']['count']; ?>%</strong></em><?php endif; ?>
                        </div>

                        <div class="box rate-info-box">
                            <span class="rc-tp"><span></span></span>
                            <div class="bd">
                                <div class="total">
                                    <span class="star-value-no  star-value-<?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['ico']; ?>"></span>
                                    <em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['average_score']; ?>分" class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['average_score']; ?></em>分
                                    共<span><?php echo $this->_var['store']['store_evaluation']['count']; ?></span>人
                                </div>
                                <div class="count count5">
                                    <span class="small-star-no5"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_desc']['5'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['5']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['5']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count4">
                                    <span class="small-star-no4"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_desc']['4'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['4']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['4']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count3">
                                    <span class="small-star-no3"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_desc']['3'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['3']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['3']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count2">
                                    <span class="small-star-no2"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_desc']['2'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['2']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['2']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count1">
                                    <span class="small-star-no1"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_desc']['1'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['1']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_desc']['1']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="rc-bt"><span></span></span>
                        </div>
                    </li>
                    <li class="J_RateInfoTrigger">
                        <div class="item-scrib">
                            <span class="title">卖家的服务态度：</span>
                            <em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_service']['average_score']; ?>分" class="count"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['average_score']; ?></em>分 
                            <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['total']['state']): ?><em><strong class="percent <?php echo $this->_var['store']['store_evaluation']['evaluation_service']['total']['state']; ?>"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['total']['count']; ?>%</strong></em><?php endif; ?>
                        </div>
                        <div class="box rate-info-box">
                            <span class="rc-tp"><span></span></span>
                            <div class="bd">
                                <div class="total">
                                    <span class="star-value-no  star-value-<?php echo $this->_var['store']['store_evaluation']['evaluation_service']['ico']; ?>"></span>
                                    <em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_service']['average_score']; ?>分" class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['average_score']; ?></em>分
                                    共<span><?php echo $this->_var['store']['store_evaluation']['count']; ?></span>人
                                </div>
                                <div class="count count5">
                                    <span class="small-star-no5"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_service']['5'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_service']['5']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['5']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count4">
                                    <span class="small-star-no4"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_service']['4'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_service']['4']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['4']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count3">
                                    <span class="small-star-no3"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_service']['3'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_service']['3']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['3']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count2">
                                    <span class="small-star-no2"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_service']['2'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_service']['2']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['2']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count1">
                                    <span class="small-star-no1"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_service']['1'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_service']['1']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_service']['1']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="rc-bt"><span></span></span>
                        </div>
                    </li>
                    <li class="J_RateInfoTrigger">
                        <div class="item-scrib">
                            <span class="title">卖家的发货速度：</span>
                            <em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['average_score']; ?>分" class="count"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['average_score']; ?></em>分 
                            <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['total']['state']): ?><em><strong class="percent <?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['total']['state']; ?>"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['total']['count']; ?>%</strong></em><?php endif; ?>
                        </div>
                        <div class="box rate-info-box">
                            <span class="rc-tp"><span></span></span>
                            <div class="bd">
                                <div class="total">
                                    <span class="star-value-no  star-value-<?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['ico']; ?>"></span>
                                    <em title="<?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['average_score']; ?>分" class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['average_score']; ?></em>分
                                    共<span><?php echo $this->_var['store']['store_evaluation']['count']; ?></span>人
                                </div>
                                <div class="count count5">
                                    <span class="small-star-no5"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['5'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['5']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['5']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count4">
                                    <span class="small-star-no4"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['4'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['4']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['4']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count3">
                                    <span class="small-star-no3"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['3'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['3']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['3']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count2">
                                    <span class="small-star-no2"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['2'] != 0): ?>
                                    <span style="width:<?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['2']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['2']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                                <div class="count count1">
                                    <span class="small-star-no1"></span>
                                    <?php if ($this->_var['store']['store_evaluation']['evaluation_speed']['1'] != 0): ?>
                                    <span style="width: <?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['1']; ?>px;" class="rate-stat"></span>
                                    <em class="h"><?php echo $this->_var['store']['store_evaluation']['evaluation_speed']['1']; ?>%</em>
                                    <?php else: ?>
                                    暂无人打分
                                    <?php endif; ?>
                                </div>
                            </div>
                            <span class="rc-bt"><span></span></span>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>