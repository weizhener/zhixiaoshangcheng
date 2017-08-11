<?php echo $this->fetch('header.html'); ?>
<div  id="main" class="w-full">
    <div id="page-home" class="w-full mb20">
        <div class="col-1 relative w">
            <div class="left" area="col-1-left" widget_type="area">
                <?php $this->display_widgets(array('page'=>'index','area'=>'col-1-left')); ?>
            </div>
            <div class="right" area="col-1-right" widget_type="area">
                <?php $this->display_widgets(array('page'=>'index','area'=>'col-1-right')); ?>
                <div class="jd2015_register_login">
                    <dl>
                        <dt><img src="<?php echo $this->res_base . "/" . 'images/index_member_logo.png'; ?>" width="60" height="60"/></dt>
                        <dd>
                            <p>Hi! 你好</p>
                            <p>去<em>会员中心</em>看看</p>
                        </dd>
                    </dl>
                    <?php if (! $this->_var['visitor']['user_id']): ?>
                    <a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>">登录</a>
                    <a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>" class="register">注册</a>
                    <a href="<?php echo url('app=apply'); ?>">用户开店</a>
                    <?php else: ?>
                    <a href="<?php echo url('app=member'); ?>"><?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?></a>
                    <a href="<?php echo url('app=member&act=logout'); ?>"  class="register">退出</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-2" area="col-2" widget_type="area">
            <?php $this->display_widgets(array('page'=>'index','area'=>'col-2')); ?>
        </div>
        <div class="col-3 w" area="col-3" widget_type="area">
            <?php $this->display_widgets(array('page'=>'index','area'=>'col-3')); ?>
        </div>
        <div class="col-4 w" area="col-4" widget_type="area">
            <?php $this->display_widgets(array('page'=>'index','area'=>'col-4')); ?>
        </div>
    </div>
</div>

<?php echo $this->fetch('footer.html'); ?>