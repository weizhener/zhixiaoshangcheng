
<?php echo $this->fetch('top.html'); ?>
<script language="JavaScript">
$(function(){
	var cate_id = '<?php echo $_GET['cate_id']; ?>';
	if(cate_id)
	{
		$("ul[ectype='cate'] a").removeClass('on');
		$("ul[ectype='cate'] a#"+cate_id).addClass('on');
	}
	$("[ectype='cate'] a").click(function(){
		replaceParam('cate_id', this.id);
		return false;
	});
	var order = '<?php echo $_GET['order']; ?>';
	if(order)
	{
		$(".list-sort a").removeClass("on");
		$("a#"+order).addClass("on");
	}
	$(".list-sort a").click(function(){
		replaceParam('order', this.id);
		return false;
	});
})
/* 替换参数 */
function replaceParam(key, value)
{
    var params = location.search.substr(1).split('&');
    var found  = false;
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr   = param.split('=');
        pKey  = arr[0];
        if (pKey == 'page')
        {
            params[i] = 'page=1';
        }
        if (pKey == key)
        {
            params[i] = key + '=' + value;
            found = true;
        }
    }
    if (!found)
    {
        value = transform_char(value);
        params.push(key + '=' + value);
    }
    location.assign(SITE_URL + '/index.php?' + params.join('&') + '#module');
}
</script>
<div class="wrapper">
    
    <div class="ju-ele-nav" id="ju-nav">
        <div class="top">
             <h2>
                <a class="logo" href="<?php echo url('app=ju'); ?>"></a>
            </h2>
        </div>
        <div class="ct">
            <?php $_from = $this->_var['cate_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');$this->_foreach['fe_cate'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_cate']['total'] > 0):
    foreach ($_from AS $this->_var['cate']):
        $this->_foreach['fe_cate']['iteration']++;
?>
             <h2 ectype="cate">
                <a href="javascript:;" id="<?php echo $this->_var['cate']['id']; ?>"><?php echo $this->_var['cate']['value']; ?></a>
            </h2>
            <ul class="jcategory clearfix" ectype="cate">
            	<?php $_from = $this->_var['cate']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
                <li><a href="javascript:;" id="<?php echo $this->_var['child']['id']; ?>"><span><?php echo $this->_var['child']['value']; ?></span></a>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <ul class="menu-cate">
                <li class="jbrand"><a target="_blank" href="<?php echo url('app=ju_brand'); ?>"><i></i>品牌团</a>
                </li>
                <li class="jmp"><a target="_blank" href="<?php echo url('app=ju_mingpin'); ?>"><i></i>聚名品</a>
                </li>
                <li class="jzz"><a target="_blank" href="<?php echo url('app=ju_decoration'); ?>"><i></i>聚家装</a>
                </li>
                <li class="life"><a target="_blank" href="<?php echo url('app=ju_life'); ?>"><i></i>生活汇</a>
                </li>
                <li class="tour"><a target="_blank" href="<?php echo url('app=ju_travel'); ?>"><i></i>旅游团</a>
            </ul>
        </div>
        <div class="bt"></div>
    </div>
    
    <div id="page">
        <div class="ju-naver">
            <div class="inner w">
                <div class="top-search">
                 <div class="top-search-box clearfix">
                    <div class="form-fields float-right">
                        <form method="GET" action="<?php echo url('app=ju'); ?>">
                            <input type="hidden" name="app" value="ju" />
                            <input type="hidden" name="act" value="index" />
                            <input type="text"   name="keyword" value="<?php if ($_GET['keyword']): ?><?php echo $_GET['keyword']; ?><?php else: ?>搜索其实很容易<?php endif; ?>" onfocus="if (this.value=='搜索其实很容易') this.value = '';"  class="keyword"  style="color:#999;"/>
                            <input type="submit" value="搜索" class="submit" hidefocus="true" />
                        </form>
                    </div>
                 </div>
              </div>
                
                <ul class="nav-menu">
                    <li class="current menu-home"><a class="menu-link" href="<?php echo url('app=ju'); ?>"><span>首页</span></a>
                    </li>
                    <li class=" menu-brands">
                        <a class="menu-link" target="_blank" href="<?php echo url('app=ju_brand'); ?>"> <span>品牌团</span>
     <em class="btn-dropdown"></em>
                        </a>
                    </li>
                    <li class=" menu-jump"><a class="menu-link" target="_blank" href="<?php echo url('app=ju_mingpin'); ?>"><span>聚名品</span></a>
                    </li>
                    <li class=" menu-jiazhuang"><a class="menu-link" target="_blank" href="<?php echo url('app=ju_decoration'); ?>"><span>聚家装</span></a>
                    </li>
                    <li class=" menu-local">
                        <a class="menu-link" target="_blank" href="<?php echo url('app=ju_life'); ?>"> <span>生活汇</span>
     
                        </a>
                    </li>
                    <li class=" menu-travel">
                        <a class="menu-link" target="_blank" href="<?php echo url('app=ju_travel'); ?>"> <span>旅游团</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="ju-content">
            <div class="clearfix mt10">
            	<div class="index_left" area="index_left" widget_type="area">
                <?php $this->display_widgets(array('page'=>'ju','area'=>'index_left')); ?>
                </div>
                <div class="index_right" area="index_right" widget_type="area">
                <?php $this->display_widgets(array('page'=>'ju','area'=>'index_right')); ?>
                </div>
            </div>
            <div class="" area="index_middle" widget_type="area">
            <?php $this->display_widgets(array('page'=>'ju','area'=>'index_middle')); ?>
            </div>
            <a name="module"></a>
            <div class="ju-filter">
                <div class="ju-list-nav clearfix">
                    <div class="filter-tit">
                        <h2 style="">今日团购</h2>
                    </div>
                    <div class="list-sort">
                        <ul>
                            <li>
                                <a href="javascript:;" class="on" id=""> <span>默认</span></a>
                            </li>
                            <li>
                                <a href="javascript:;" id="sale"> <span>销量</span><i class="sort-sign"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" id="discount"> <span>折扣</span><i class="sort-sign"></i></a>
                            </li>
                            <li>
                                <a href="javascript:;" id="addtime"> <span>最新</span><i class="sort-sign"></i></a>
                            </li>
                        </ul>
                    </div>
                    <?php echo $this->fetch('pageju.top.html'); ?>
                </div>
            </div>
            <div class="ju-list clearfix">
                <ul class="clearfix">
                	<?php $_from = $this->_var['ju_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ju');$this->_foreach['fe_ju'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_ju']['total'] > 0):
    foreach ($_from AS $this->_var['ju']):
        $this->_foreach['fe_ju']['iteration']++;
?>
                    <li <?php if ($this->_foreach['fe_ju']['iteration'] % 3 == 0): ?> style=" margin-right:0px;"<?php endif; ?>>
                        <div class="grts"></div>
                        <a target="_blank" href="<?php echo url('app=ju&act=show&id=' . $this->_var['ju']['group_id']. ''); ?>" class="link-box">
                            <img class="pic" <?php if ($this->_var['ju']['image']): ?> src="<?php echo $this->_var['ju']['image']; ?>"<?php else: ?> src="<?php echo $this->_var['ju']['default_image']; ?>"<?php endif; ?> alt="<?php echo $this->_var['ju']['goods_name']; ?>"> <i class="soldout-mask"></i> 
                             <h3 title="<?php echo $this->_var['ju']['group_name']; ?>"><?php echo htmlspecialchars($this->_var['ju']['group_name']); ?></h3> 
                            <div class="prices"> <span class="price"><i>￥</i><em><?php echo $this->_var['ju']['group_price']; ?></em></span> 
                                <div class="dock"> <span class="discount"><em>优惠<?php echo $this->_var['ju']['discount']; ?></em>%</span>  <del class="orig-price"><?php echo price_format($this->_var['ju']['price']); ?></del> 
                                </div> <span class="sold-num"><em><?php if ($this->_var['ju']['all_count']): ?> <?php echo $this->_var['ju']['all_count']; ?> <?php else: ?> 0 <?php endif; ?></em>人已买</span> 
                            </div>
                        </a>
                    </li>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </ul>
            </div>
            <div class="ju-filter filter-bottom">
                <div class="ju-list-nav clearfix">
                    <?php echo $this->fetch('pageju.bottom.html'); ?>
                </div>
            </div>   
            <div class="" area="index_bottom" widget_type="area">
            <?php $this->display_widgets(array('page'=>'ju','area'=>'index_bottom')); ?>
            </div> 
        </div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
