<footer id="copyright">

    <section class="footer-t">

        <div class="fl" id="is_login">

            <?php if (! $this->_var['visitor']['user_id']): ?>

            <a href="<?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?>">请登录</a><a href="<?php echo url('app=member&act=register&ret_url=' . $this->_var['ret_url']. ''); ?>">注册</a>

            <?php else: ?>

            <span class="mr10"><?php echo htmlspecialchars($this->_var['visitor']['user_name']); ?></span><a href="<?php echo url('app=member&act=logout'); ?>">退出</a>

            <?php endif; ?> 

        </div>

        <a href="#" class="retum">回到顶部<b></b></a>

    </section>

    <?php echo $this->_var['async_sendmail']; ?>

</footer>



<div id="footer_nav">

    <ul>

        <li>

            <a href="<?php echo url('app=default'); ?>"><span class="iconfont">&#xf00a0;</span><br/>首页</a>

        </li>

        <li>

            <a href="<?php echo url('app=category'); ?>"><span class="iconfont">&#xf00a6;</span><br/>分类</a>

        </li>

        <li>
            <a href="<?php echo url('app=member'); ?>"><span class="iconfont">&#xf00a2;</span><br/>我的商城</a>
            

        </li>

        <li>

            <a href="<?php echo url('app=cart'); ?>"><span class="iconfont">&#xf009f;</span><br/>购物车</a>

        </li>

    </ul>

</div>

<script language="javascript">
$(document).ready(function() {//
  window.yutebi.showSource('yutebi'); 
});
function setyincang(){
  $("#footer_nav").hide();
  $("#copyright").html("");
}
</script>

</html>