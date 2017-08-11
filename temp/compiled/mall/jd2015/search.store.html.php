<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'search_store.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
//<!CDATA[
$(function (){
	
    var order = '<?php echo $_GET['order']; ?>';
	var css = '';
	
	<?php if ($_GET['order']): ?>
	order_arr = order.split(' ');
	switch (order_arr[1]){
		case 'desc' : 
			css = 'order-down btn-order-cur';
		break;
		case 'asc' :
			css = 'order-up btn-order-cur';
		break;
		default : 
			css = 'order-down-gray';
	}
	$('.btn-order a[ectype='+order_arr[0]+']').attr('class','btn-order-click '+css);
	<?php endif; ?>
	
	$(".btn-order a").click(function(){
		if(this.id==''){
			dropParam('order');// default order
			return false;
		}
		else
		{
			dd = " desc";
			if(order != '') {
				order_arr = order.split(' ');
				if(order_arr[0]==this.id && order_arr[1]=="desc")
					dd = " asc";
				else dd = " desc";
			}
			replaceParam('order', this.id+dd);
			return false;
		}
	});
	
	$('.list-fields li .row_3 a').click(function(){
		var cl=$(this).attr('class');
		if(cl=='expand'){
			$(this).attr('class','fold');	
			$(this).html('收起相关宝贝');
		}else{
			$(this).attr('class','expand');	
			$(this).html('展开相关宝贝');
		}
		$(this).parent().parent().parent('.store-info').next('.store-goods').toggle();
	});
	
	$('.search-by .show-more').click(function(){
		$(this).parent().children().find('.toggle').toggle();
		if($(this).find('span').html()=='展开'){
			$(this).find('span').html('收起');
			$(this).children().children('i').css('background-position','0 -1488px');
		} else {
			$(this).find('span').html('展开');
			$(this).children().children('i').css('background-position','0 -1497px');
		}
	});
	
});

//]]>
</script>
<div id="main" class="w-full">
<div id="page-search-store" class="w mt10 mb10">  
	<?php echo $this->fetch('curlocal.html'); ?>
    <div class="w mb10 border">
        <div class="search-by by-category relative">
			<?php $_from = $this->_var['scategorys']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'scategory');$this->_foreach['fe_scategory'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_scategory']['total'] > 0):
    foreach ($_from AS $this->_var['scategory']):
        $this->_foreach['fe_scategory']['iteration']++;
?>
			<dl class="relative clearfix">
				<dt class="float-left"><a href="<?php echo url('app=search&act=store&cate_id=' . $this->_var['scategory']['id']. ''); ?>"><?php echo htmlspecialchars($this->_var['scategory']['value']); ?></a></dt>
				<dd class="float-left">
					<?php if ($this->_var['scategory']['children']): ?>
					<?php $_from = $this->_var['scategory']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
					<a href="<?php echo url('app=search&act=store&cate_id=' . $this->_var['child']['id']. ''); ?>" class="<?php if ($this->_foreach['fe_child']['iteration'] > 7): ?>toggle hidden<?php endif; ?>"><?php echo htmlspecialchars($this->_var['child']['value']); ?></a>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php else: ?>
                    &nbsp;
					<?php endif; ?>
				</dd>
                <dd class="float-left show-more"><h3 class="pointer clearfix"><i></i><span>展开</span>分类</span></h3></dd>
			</dl>
			<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</div>
		<div class="search-by by-region relative clearfix">
			<dl class="clearfix" style="border-bottom:0">
				<dt class="float-left"><a ectype="region" id="" href="javascript:;">所在地</a></dt>
				<dd class="float-left">
					<?php $_from = $this->_var['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'region');$this->_foreach['fe_region'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_region']['total'] > 0):
    foreach ($_from AS $this->_var['key'] => $this->_var['region']):
        $this->_foreach['fe_region']['iteration']++;
?>
					<a href="javascript:;" ectype="region" id="<?php echo $this->_var['key']; ?>" class="<?php if ($this->_foreach['fe_region']['iteration'] >= 9): ?>toggle hidden<?php endif; ?>"><?php echo htmlspecialchars($this->_var['region']); ?></a>
					<?php endforeach; else: ?>
                    &nbsp;
					<?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
				</dd>
                <dd class="float-left show-more"><h3 class="pointer clearfix"><i></i><span>展开</span>地区</h3></dd>
			</dl>
			
        </div>  
    </div>
    <div class="shops-list w clearfix">
			<div class="search-type clearfix">
				<div class="float-left btn-type">
					<a href="<?php echo url('app=search'); ?>">搜索商品</a>
					<a href="<?php echo url('app=search&act=store'); ?>" class="current" style="border-right:0px;">搜索店铺</a>
					<a href="<?php echo url('app=search&act=groupbuy'); ?>">搜索团购</a>
				</div>
				<?php echo $this->fetch('page.top.html'); ?>                              
			</div>
            <div  class="sort-type padding5 border border-t-0  mb10 clearfix">
               <div class="clearfix float-left btn-order">
                    <a class="btn-order-click default-sort" id="" href="javascript:;">默认排序</a>
                    <a class="btn-order-click order-down-gray" id="credit_value" href="javascript:;">信用度<i></i></a>
                    <a class="btn-order-click order-down-gray" id="add_time" href="javascript:;">添加时间<i></i></a>
                    <a class="btn-order-click order-down-gray" id="praise_rate" href="javascript:;">好评率<i></i></a>
                    <a class="btn-order-click order-down-gray" id="region_name" href="javascript:;">所在地<i></i></a>
                </div>
               <div class="clearfix float-right">
                    <a class="select-param"  href="javascript:;">
                    	信用度
                        <span><i></i></span>
                        <ul class="tan" ectype="credit_value">
                        	<li v="4">金冠店铺</li>
                        	<li v="3">皇冠店铺</li>
                            <li v="2">钻级店铺</li>
                            <li v="1">心级店铺</li>
                            <li v="">不限</li>
                        </ul>
                    </a>
                    <a class="select-param"  href="javascript:;">
                    	推荐
                        <span><i></i></span>
                        <ul class="tan" ectype="recommended">
                        	<li v="1">是</li>
                        	<li v="0">否</li>
                            <li v="">不限</li>
                        </ul>
                    </a>
                    <a class="select-param"  href="javascript:;">
                    	好评率
                        <span><i></i></span>
                        <ul class="tan" ectype="praise_rate">
                        	<li v="90">90%以上</li>
                        	<li v="80">80%以上</li>
                            <li v="70">70%以上</li>
                            <li v="60">60%以上</li>
                            <li v="50">50%以上</li>
                            <li v="">不限</li>
                        </ul>
                    </a>
                    <a class="select-param"  href="javascript:;">
                        店铺等级
                        <span><i></i></span>
                        <ul class="tan" ectype="sgrade">
                        	<?php $_from = $this->_var['sgrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'sgrade');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['sgrade']):
?>
                        	<li v="<?php echo $this->_var['key']; ?>"><?php echo $this->_var['sgrade']; ?></li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            <li v="">不限</li>
                        </ul>
                    </a>
                </div>
            </div>
            <div class="list-fields w mb10">
				<ul>
					<?php $_from = $this->_var['stores']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'store');if (count($_from)):
    foreach ($_from AS $this->_var['store']):
?>
            		<li class="pb5 pt5">
						<div class="store-info clearfix">
							<div class="row_1 float-left"><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><img src="<?php echo $this->_var['store']['store_logo']; ?>" width="80" height="80" /></a></div>
                            <div class="row_2 float-left">
                                <h2><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></a></h2>
                                <div class="mainbussiness">
                                    <span>主营业务：</span><a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo $this->_var['store']['business_scope']; ?></a>
                                </div>
                                <div class="owner_info">
                                    <span>掌柜：</span>
                                    <a href="<?php echo url('app=store&id=' . $this->_var['store']['store_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['store']['user_name']); ?></a>
                                    <?php if ($this->_var['store']['im_qq']): ?>
                                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=<?php echo $this->_var['store']['im_qq']; ?>&site=qq&menu=yes"><img width="65" border="0" src="http://wpa.qq.com/pa?p=2:<?php echo $this->_var['store']['im_qq']; ?>:1" align="absMiddle"></a>				
                                    <?php endif; ?>
                                    <?php if ($this->_var['store']['im_ww']): ?>
                                    <a target="_blank" href="http://www.taobao.com/webww/ww.php?ver=3&touid=<?php echo $this->_var['store']['im_ww']; ?>&siteid=cntaobao&status=1&charset=utf-8"><img border="0" src="http://amos.alicdn.com/realonline.aw?v=2&uid=<?php echo $this->_var['store']['im_ww']; ?>&site=cntaobao&s=1&charset=utf-8" align="absMiddle"/></a>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="row_3 float-left">
                                <p>共<b><?php echo $this->_var['store']['goods_count']; ?></b>件商品</p>
                                <p>店铺总共售出<b><?php echo $this->_var['store']['store_sold']; ?></b>件商品</p>
                                <p><a class="fold" href="javascript:;">收起相关宝贝</a></p>
                            </div>
                            <div class="row_4 float-left"><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></div>
                            <div class="row_5 float-right">
                                <p>
                                    <?php if ($this->_var['store']['credit_value'] >= 0): ?>
                                    <img src="<?php echo $this->_var['store']['credit_image']; ?>" />
                                    <?php else: ?>
                                    <?php echo $this->_var['store']['credit_value']; ?>
                                    <?php endif; ?>
                                </p>
                                <p><?php echo $this->_var['store']['sgrade_name']; ?></p>
                                <p>好评率:<?php echo $this->_var['store']['praise_rate']; ?>%</p>
                            </div>
                        </div>
                        <?php if ($this->_var['store']['goods_list']): ?>
						<div class="store-goods mt5 mb5 carousel-<?php echo $this->_var['store']['store_id']; ?>">
                            <b></b>
							<a class="prev" href="javascript:;"></a>
							<a class="next" href="javascript:;"></a> 
                            <div class="clr"></div>
							<div class="scroller">
								<div class="ks-switchable-content">
									<?php $_from = $this->_var['store']['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'list');if (count($_from)):
    foreach ($_from AS $this->_var['list']):
?>
                                    <div class="each clearfix">
                                    <?php $_from = $this->_var['list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
									<dl>
										<dt><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><img width="160" height="160" src="<?php echo $this->_var['goods']['default_image']; ?>" /></a></dt>
										<dd>
											<div class="desc"><a href="<?php echo url('app=goods&id=' . $this->_var['goods']['goods_id']. ''); ?>" target="_blank"><?php echo $this->_var['goods']['goods_name']; ?></a></div>
											<div class="price"><span><?php echo price_format($this->_var['goods']['price']); ?></span></div>
										</dd>
									</dl>
                                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </div>
									<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
								</div>
							</div>
						</div>
                        <script>
						KISSY.use("switchable", function(S) {
						var tiny_slide = new S.Carousel('.carousel-<?php echo $this->_var['store']['store_id']; ?>', {
							//steps:5,
							effect: 'scrollx',
							circular: true,
							prevBtnCls: 'prev',
							nextBtnCls: 'next',
							autoplay:true
							});
						});
					</script>
                        <?php endif; ?>
					</li>	
                    <?php endforeach; else: ?>
             		<div class="store-empty padding10 mb10">很抱歉！没有找到相关店铺</div>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
            	</ul>
            </div>
         
        <?php echo $this->fetch('page.bottom.html'); ?>
    </div>
</div>
</div>	
<?php echo $this->fetch('server.html'); ?>					
<?php echo $this->fetch('footer.html'); ?>