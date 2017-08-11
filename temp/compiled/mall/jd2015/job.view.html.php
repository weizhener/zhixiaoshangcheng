<?php echo $this->fetch('header.html'); ?>


<div id="main" class="w-full">
    <div id="page-job" class="w mb20 pt10 clearfix">
        
        <div class="col-sub">
            <div class="mt">招贤纳士</div>
            <div class="mc">
                <dl>
                    <dt class="on"><a href="<?php echo url('app=job'); ?>" title="招贤纳士"><span>招贤纳士</span></a></dt>
                </dl>
                <dl>
                    <dt><a href="<?php echo url('app=job_apply&act=add'); ?>" title="招贤纳士"><span>在线应聘</span></a></dt>
                </dl>
            </div>
        </div>
        
        <div class="col-main">
            <div class="mt">
                <span>招贤纳士</span>
            </div>
            
            <div class="mc">
                <h2 class="title"><?php echo htmlspecialchars($this->_var['job']['position']); ?></h2>
                <ul class="paralist  clearfix">
                    <li><span>招聘人数</span><?php echo ($this->_var['job']['count'] == '') ? '不限' : $this->_var['job']['count']; ?></li>
                    <li><span>工作地点</span><?php echo ($this->_var['job']['place'] == '') ? '待定' : $this->_var['job']['place']; ?></li>
                    <li><span>工作待遇</span><?php echo ($this->_var['job']['deal'] == '') ? '待定' : $this->_var['job']['deal']; ?></li>
                    <li><span>发布时间</span><?php echo local_date("Y-m-d",$this->_var['job']['update_time']); ?></li>
                </ul>
                
                <h3 class="ctitle"><span>职位描述</span></h3>
                
                <div class="editor">
                    <?php echo html_filter($this->_var['job']['content']); ?>
                </div>
                
                <div class="met_hits">
                    <div class="metjiathis">
                        
                        <div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>

                    </div>
                    &nbsp;&nbsp;更新时间：2012-07-16&nbsp;&nbsp;【<a href="javascript:window.print()">打印此页</a>】
                </div>
                
            </div>
        </div>
        
        
    </div>
</div>







<?php echo $this->fetch('footer.html'); ?>