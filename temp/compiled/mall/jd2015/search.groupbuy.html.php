<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_groupbuy.js'; ?>" charset="utf-8"></script>

<div id="main" class="w-full">
	<div id="page-search-groupbuy" class="w mt10 mb20">
		<?php echo $this->fetch('curlocal.html'); ?>
		<div class="w ads mt10" area="ads_top" widget_type="area">
			<?php $this->display_widgets(array('page'=>'groupbuy','area'=>'ads_top')); ?>
		</div>
		<div class="w mt10">
			<div class="search-by mb10">
				<ul>
					<li class="state clearfix">
						<h3>团购状态</h3>
                        <a href="javascript:;" ectype="state" <?php if ($_GET['state'] == ''): ?>class="act"<?php endif; ?> id="">不限</a>
						<a href="javascript:;" ectype="state" <?php if ($_GET['state'] == 'on'): ?>class="act"<?php endif; ?> id="on"><?php echo $this->_var['state']['on']; ?></a>
						<a href="javascript:;" ectype="state" <?php if ($_GET['state'] == 'end'): ?>class="act"<?php endif; ?> id="end"><?php echo $this->_var['state']['end']; ?></a>
						<a href="javascript:;" ectype="state" <?php if ($_GET['state'] == 'finished'): ?>class="act"<?php endif; ?> id="finished"><?php echo $this->_var['state']['finished']; ?></a>
						<a href="javascript:;" ectype="state" <?php if ($_GET['state'] == 'canceled'): ?>class="act"<?php endif; ?> id="canceled"><?php echo $this->_var['state']['canceled']; ?></a>
                	</li>
					<li class="admin_recomand clearfix" style="border:0px;">
						<h3>商城推荐</h3>
                        <a href="javascript:;" ectype="recommend" <?php if ($_GET['recommend'] == ''): ?>class="act"<?php endif; ?> id="">不限</a>
						<a href="javascript:;" ectype="recommend" <?php if ($_GET['recommend'] == '1'): ?>class="act"<?php endif; ?> id="1">是</a>
						<a href="javascript:;" ectype="recommend" <?php if ($_GET['recommend'] == '0'): ?>class="act"<?php endif; ?> id="0">否</a>
                	</li>
				</ul>
			</div>
			<div class="search-type clearfix">
				<div class="float-left btn-type">
					<a href="<?php echo url('app=search'); ?>">搜索商品</a>
					<a href="<?php echo url('app=search&act=store'); ?>" style="border-left:0px;">搜索店铺</a>
					<a href="<?php echo url('app=search&act=groupbuy'); ?>" class="current">搜索团购</a>
				</div>
				<?php echo $this->fetch('page.top.html'); ?>                              
			</div>
			<div class="group-list mt10 mb10 clearfix">
          		<ul class="clearfix">
                 	<?php $_from = $this->_var['groupbuy_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'group');$this->_foreach['fe_group'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_group']['total'] > 0):
    foreach ($_from AS $this->_var['group']):
        $this->_foreach['fe_group']['iteration']++;
?>
                 	<li class="item mb20" <?php if ($this->_foreach['fe_group']['iteration'] % 4 == 0): ?> style="margin-right:0"<?php endif; ?>>
                 		<?php if ($this->_var['group']['recommended'] == 1): ?><div class="rec_ico"></div><?php endif; ?>
                 		<div class="desc"><a target="_blank" href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>"><?php echo sub_str(htmlspecialchars($this->_var['group']['group_name']),60); ?></a></div>
                 		<div class="pic"><a target="_blank" href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>"><img src="<?php if ($this->_var['group']['group_image']): ?><?php echo $this->_var['group']['group_image']; ?><?php else: ?><?php echo $this->_var['group']['default_image']; ?><?php endif; ?>" alt="<?php echo htmlspecialchars($this->_var['group']['group_name']); ?>" /></a></div>
                    	<div class="buy"><span class="price"><?php echo price_format($this->_var['group']['group_price']); ?></span><del><?php echo $this->_var['group']['price']; ?></del><a href="<?php echo url('app=groupbuy&id=' . $this->_var['group']['group_id']. ''); ?>"></a></div>
                    	<div class="extra">
                   			<span><strong><?php echo $this->_var['group']['discount']; ?></strong>折</span><span>剩余时间：<?php echo $this->_var['group']['lefttime']; ?></span><span><b><?php echo $this->_var['group']['quantity']; ?></b>人参与</span>
                        	<div class="gray-bg"></div>
                    	</div>
                 	</li>
                 	<?php endforeach; else: ?>
                 	<div>没有找到相关团购活动</div>
                 	<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
              	</ul>
				<?php echo $this->fetch('page.bottom.html'); ?>
       		</div>    
  		</div>
   		<div class="ads mt10 clearboth" area="ads_bottom" widget_type="area">
			<?php $this->display_widgets(array('page'=>'groupbuy','area'=>'ads_bottom')); ?>
    	</div>
	</div>
</div>
<?php echo $this->fetch('server.html'); ?>
<?php echo $this->fetch('footer.html'); ?>