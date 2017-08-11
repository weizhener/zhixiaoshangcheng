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
                
                <?php $_from = $this->_var['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'job');if (count($_from)):
    foreach ($_from AS $this->_var['job']):
?>
                <dl class="clearfix">
                    <dt>
                        <a href="<?php echo url('app=job&act=view&id=' . $this->_var['job']['job_id']. ''); ?>" title="PHP技术支持" target="_self"><?php echo htmlspecialchars($this->_var['job']['position']); ?></a>
                    </dt>
                    <dd>
                        <div class="detail"><span>发布日期：<?php echo local_date("Y-m-d",$this->_var['job']['update_time']); ?></span><span>工作地点：<?php echo ($this->_var['job']['place'] == '') ? '待定' : $this->_var['job']['place']; ?></span><span>招聘人数：<?php echo ($this->_var['job']['count'] == '') ? '不限' : $this->_var['job']['count']; ?></span></div>
                        <div class="dtail">
                            <span><a href="<?php echo url('app=job_apply&act=add&id=' . $this->_var['job']['job_id']. ''); ?>" title="在线应聘" target="_self">在线应聘</a></span>
                            <span><a href="<?php echo url('app=job&act=view&id=' . $this->_var['job']['job_id']. ''); ?>" title="查看详细" target="_self">查看详细</a></span>
                        </div>
                    </dd>
                </dl>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                
            </div>
        </div>
        
        
    </div>
</div>







<?php echo $this->fetch('footer.html'); ?>