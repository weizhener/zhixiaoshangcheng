<div id="header" class="w">

    <div id="shop-nav" class="w auto mb10">

        <div class="banner">

            <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>">

                <?php if ($this->_var['store']['store_banner']): ?>

                <img src="<?php echo $this->_var['store']['store_banner']; ?>" width="950" height="150" />

                <?php else: ?>

                <img src="<?php echo $this->res_base . "/" . 'images/banner.gif'; ?>" width="950" height="150" />

                <?php endif; ?>

            </a>

        </div>



        <ul class="clearfix">

            <!--<li class="allcategory"></li>-->

            <li><a class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'index'): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><span>店铺首页</span></a></li>



            <?php $_from = $this->_var['store']['store_navs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store_nav');if (count($_from)):
    foreach ($_from AS $this->_var['store_nav']):
?>

            <li><a class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'article' && $_GET['id'] == $this->_var['store_nav']['article_id']): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&act=article&id=' . $this->_var['store_nav']['article_id']. ''); ?>"><span><?php echo htmlspecialchars($this->_var['store_nav']['title']); ?></span></a></li>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            <li><a class="<?php if ($_GET['app'] == 'store' && $_GET['act'] == 'credit'): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&act=credit&id=' . $this->_var['store']['store_id']. ''); ?>"><span>信用评价</span></a></li>



            <?php $_from = $this->_var['store']['store_gcates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'gcategory');if (count($_from)):
    foreach ($_from AS $this->_var['gcategory']):
?>

            <li><a class="<?php if ($_GET['cate_id'] == $this->_var['gcategory']['id']): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. '&act=search&cate_id=' . $this->_var['gcategory']['id']. '&from=nav'); ?>"><span><?php echo htmlspecialchars($this->_var['gcategory']['value']); ?></span></a></li>

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>





            <?php if ($this->_var['store']['functions']['groupbuy']): ?>

            <li><a class="<?php if ($_GET['app'] == 'groupbuy' || $_GET['act'] == 'groupbuy'): ?>active<?php else: ?>normal<?php endif; ?>" href="<?php echo url('app=store&act=groupbuy&id=' . $this->_var['store']['store_id']. ''); ?>"><span>团购活动</span></a></li>

            <?php endif; ?>

            <?php if ($_GET['app'] == 'store' && $_GET['act'] == 'search' && $_GET['from'] != 'nav'): ?>

            <li><a class="active"><span>分类商品</span></a></li>

            <?php endif; ?>

            <?php if ($_GET['app'] == 'goods' && $_GET['id']): ?>

            <li><a class="active"><span>商品详情</span></a></li>

            <?php endif; ?>
            
            




        </ul>

    </div>

    <div class="store-header-search w clearfix">

        <div class="form">

            <form action="index.php" method="get">

                <b></b>

                <input type="hidden" name="app" value="store" />

                <input type="hidden" name="act" value="search" />

                <input type="hidden" name="id" value="<?php echo $this->_var['store']['store_id']; ?>" />

                <input type="text" name="keyword"  class="keyword" maxlength="30" value="<?php echo $_GET['keyword']; ?>"/>

                <input type="submit" value="搜索" class="submit" />

            </form>

        </div>

        <div class="keys">

            <span>热门搜索：</span>

            <?php $_from = $this->_var['store']['hot_search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'keyword');if (count($_from)):
    foreach ($_from AS $this->_var['keyword']):
?>

            <a href="<?php echo url('app=store&act=search&id=' . $this->_var['store']['store_id']. '&keyword=' . urlencode($this->_var['keyword']). ''); ?>"><?php echo $this->_var['keyword']; ?></a> 

            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

        </div>

    </div>

</div>