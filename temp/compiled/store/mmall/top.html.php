<div class="banner">

    <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>">

        <?php if ($this->_var['store']['store_banner']): ?>

        <img src="<?php echo $this->_var['store']['store_banner']; ?>" width="1000" height="120" />

        <?php else: ?>

        <img src="<?php echo $this->res_base . "/" . 'images/banner.jpg'; ?>"  />

        <?php endif; ?>

    </a>

</div>

<div id="nav">

    <ul>

        <li><a class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'index'): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><span>店铺首页</span></a></li>

        <?php if ($this->_var['store']['functions']['groupbuy'] && $this->_var['store']['enable_groupbuy']): ?>

        <li><a class="<?php if ($_GET['app'] == 'groupbuy' || $_GET['act'] == 'groupbuy'): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&act=groupbuy&id=' . $this->_var['store']['store_id']. ''); ?>"><span>团购活动</span></a></li>

        <?php endif; ?>

        <?php $_from = $this->_var['store']['store_navs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store_nav');if (count($_from)):
    foreach ($_from AS $this->_var['store_nav']):
?>

        <li><a class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'article' && $_GET['id'] == $this->_var['store_nav']['article_id']): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&act=article&id=' . $this->_var['store_nav']['article_id']. ''); ?>"><span><?php echo htmlspecialchars($this->_var['store_nav']['title']); ?></span></a></li>

        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        <li><a class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'credit'): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&act=credit&id=' . $this->_var['store']['store_id']. ''); ?>"><span>信用评价</span></a></li>

        <li><a class="normal" href="javascript:collect_store(<?php echo $this->_var['store']['store_id']; ?>)"><span>收藏该店铺</span></a></li>

    </ul>

</div>