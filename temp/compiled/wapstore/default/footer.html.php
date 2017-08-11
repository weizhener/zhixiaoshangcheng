<div class="footer" id="copyright1111">

    <p>

        <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>">商铺首页</a>|

        <a href="<?php if ($this->_var['visitor']['user_id']): ?><?php echo url('app=buyer_order'); ?><?php else: ?><?php echo url('app=member&act=login&ret_url=' . $this->_var['ret_url']. ''); ?><?php endif; ?>">会员中心</a>|

    </p>

    <p>版权所有 <?php echo $this->_var['icp_number']; ?></p>

</div> 

<?php if ($this->_var['kmenus']['status'] == 0 || $this->_var['kmenus']['status'] == ''): ?>

<link type="text/css" rel="stylesheet" href="<?php echo $this->res_base . "/" . 'css/kmenus.css'; ?>">

<div class="flo_btn_<?php if ($this->_var['kmenus']['stypeinfo'] == ''): ?>1<?php else: ?><?php echo $this->_var['kmenus']['stypeinfo']; ?><?php endif; ?>" id="footer_nav1111">

    <ul>

        <?php $_from = $this->_var['kmenusinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'info');if (count($_from)):
    foreach ($_from AS $this->_var['info']):
?>

        <li>

            <a style="background-color:#<?php echo $this->_var['info']['color']; ?>;" href="<?php if ($this->_var['info']['title'] == '导航'): ?>http://map.baidu.com/?newmap=1&ie=utf-8&s=s%26wd%3D<?php echo $this->_var['info']['loadurl']; ?><?php else: ?><?php echo $this->_var['info']['loadurl']; ?><?php endif; ?>"><span style="background:url('<?php echo $this->_var['info']['imgurl']; ?>') scroll no-repeat center center transparent;background-size:60%; bottom:0; left:0;"></span></a>

        </li>

        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

    </ul>

</div>

<?php endif; ?>

<script language="javascript">
$(document).ready(function() {//
  window.yutebi.showSource('yutebi');	 
});
function setyincang(){
  $("#footer_nav1111").hide();
  $("#copyright1111").html("");
}
</script>

<?php echo $this->_var['store']['statistics_url']; ?>

<?php echo $this->_var['async_sendmail']; ?>