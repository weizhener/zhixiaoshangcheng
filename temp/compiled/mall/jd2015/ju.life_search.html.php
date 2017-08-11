<?php echo $this->fetch('top.html'); ?>
<script language="JavaScript">
$(function(){
	var cate_id = '<?php echo $_GET['cate_id']; ?>';
	if(cate_id)
	{
		$("ul[ectype='cate'] li a").removeClass('on');
		$("ul[ectype='cate'] li a#"+cate_id).addClass('on');
	}
	$("[ectype='cate'] li a").click(function(){
		replaceParam('cate_id', this.id);
		return false;
	});
	$("ul[ectype='cate'] li a.all").click(function(){
			dropParam('cate_id');
			return false;
	});
	var region_id = '<?php echo $_GET['region_id']; ?>';
	if(region_id)
	{
		$("ul[ectype='region'] li a").removeClass('on');
		$("ul[ectype='region'] li a[title='"+region_id+"']").addClass('on');
	}
	$("[ectype='region'] li a").click(function(){
		replaceParam('region_id', this.title);
		return false;
	});
	$("ul[ectype='region'] li a.all").click(function(){
			dropParam('region_id');
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
	$(".list-sort a.all").click(function(){
			dropParam('order');
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
    location.assign(SITE_URL + '/index.php?' + params.join('&'));
}
/* 删除参数 */
function dropParam(key)
{
    var params = location.search.substr(1).split('&');
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
            params.splice(i, 1);
        }
    }
    location.assign(SITE_URL + '/index.php?' + params.join('&'));
}
</script>
<div class="wrapper channel nbg">
    
    <div class="ju-ele-nav">
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
             <h2>
                <a href="javascript:;" id="<?php echo $this->_var['cate']['id']; ?>"><?php echo $this->_var['cate']['value']; ?></a>
            </h2>
            <ul class="jcategory">
            	<?php $_from = $this->_var['cate']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
                <li><a href="<?php echo url('app=ju&cate_id=' . $this->_var['child']['id']. ''); ?>"><span><?php echo $this->_var['child']['value']; ?></span></a>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
        </div>
        <div class="bt"></div>
    </div>
    
    <div id="page" class="life search">
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
                    <li class="menu-home"><a class="menu-link" href="<?php echo url('app=ju'); ?>"><span>首页</span></a>
                    </li>
                    <li class=" menu-brands">
                        <a class="menu-link"  href="<?php echo url('app=ju_brand'); ?>"> <span>品牌团</span>
     <em class="btn-dropdown"></em>
                        </a>
                    </li>
                    <li class="menu-jump"><a class="menu-link"  href="<?php echo url('app=ju_mingpin'); ?>"><span>聚名品</span></a>
                    </li>
                    <li class="menu-jiazhuang"><a class="menu-link"  href="<?php echo url('app=ju_decoration'); ?>"><span>聚家装</span></a>
                    </li>
                    <li class="current menu-local">
                        <a class="menu-link"  href="<?php echo url('app=ju_life'); ?>"> <span>生活汇</span>
     
                        </a>
                    </li>
                    <li class="menu-travel">
                        <a class="menu-link"  href="<?php echo url('app=ju_travel'); ?>"> <span>旅游团</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="homebg">
            <div class="w990 clearfix">
                <div class="ju-category">
                     <div class="filter-cat clearfix">
                        <h2><a href="javascript:void(0);">分类<i></i></a></h2>
                        <ul ectype="cate">
                             <li><a href="javascript:;" class="all on" id="">全部&nbsp;<?php echo $this->_var['ju_count']; ?></a></li>
                             <?php $_from = $this->_var['cate_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?>
                             <li><a href="javascript:;" id="<?php echo $this->_var['cate']['cate_id']; ?>"><?php echo $this->_var['cate']['cate_name']; ?>&nbsp;<span><?php echo $this->_var['cate']['count']; ?></span></a></li>
                             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                     </div>
                                           
                    <div class="filter-cat clearfix">
                    	<h2><a href="javascript:void(0);">区域<i></i></a></h2>
                        <ul ectype="region">
                        	<li><a class="all on" href="javascript:;">全部&nbsp;</a></li>
                            <?php $_from = $this->_var['region']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'reg');if (count($_from)):
    foreach ($_from AS $this->_var['reg']):
?>
                            <li><a href="javascript:;" title="<?php echo $this->_var['reg']['region_id']; ?>"><?php echo htmlspecialchars($this->_var['reg']['region_name']); ?></a></li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                    <div class="ju-list-nav clearfix">
                            <div class="list-sort">
                                <ul>
                                    <li>
                                        <a href="javascript:;" class="all on" id=""> <span>默认</span></a>
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
                
			</div>
        
            <div class="content">
                <div class="ju-list">
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
                                    <div class="dock"> <span class="discount"><em><?php echo $this->_var['ju']['discount']; ?></em>折</span>  <del class="orig-price"><?php echo price_format($this->_var['ju']['price']); ?></del> 
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
            </div>
        </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
