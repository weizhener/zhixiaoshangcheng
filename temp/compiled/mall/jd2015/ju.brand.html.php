<?php echo $this->fetch('top.html'); ?>
<script language="JavaScript">
$(function(){
	$(".brand-conts li").click(function(){
		replaceParam('brand_id', this.id);
		return false;
	});
	$(window).scroll(function(){
		if($(window).scrollTop()>210){
			$(".brands-list").css("position","fixed");
			$(".brands-list").addClass("cssfix");
		}else{
			$(".brands-list").css("position","static");
			$(".brands-list").removeClass("cssfix");
		}
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
<div class="wrapper channel">
    
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
             <h2 ectype="cate">
                <a href="javascript:;"><?php echo $this->_var['cate']['value']; ?></a>
            </h2>
            <ul class="jcategory" ectype="cate">
            	<?php $_from = $this->_var['cate']['children']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'child');$this->_foreach['fe_child'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_child']['total'] > 0):
    foreach ($_from AS $this->_var['child']):
        $this->_foreach['fe_child']['iteration']++;
?>
                <li><a href="<?php echo url('app=ju&cate_id=' . $this->_var['child']['id']. ''); ?>#module"><span><?php echo $this->_var['child']['value']; ?></span></a>
                </li>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            </ul>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
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
                    <li class="menu-home"><a class="menu-link" href="<?php echo url('app=ju'); ?>"><span>首页</span></a>
                    </li>
                    <li class="current menu-brands">
                        <a class="menu-link"  href="<?php echo url('app=ju_brand'); ?>"> <span>品牌团</span>
     <em class="btn-dropdown"></em>
                        </a>
                    </li>
                    <li class=" menu-jump"><a class="menu-link"  href="<?php echo url('app=ju_mingpin'); ?>"><span>聚名品</span></a>
                    </li>
                    <li class=" menu-jiazhuang"><a class="menu-link"  href="<?php echo url('app=ju_decoration'); ?>"><span>聚家装</span></a>
                    </li>
                    <li class=" menu-local">
                        <a class="menu-link"  href="<?php echo url('app=ju_life'); ?>"> <span>生活汇</span>
     
                        </a>
                    </li>
                    <li class=" menu-travel">
                        <a class="menu-link"  href="<?php echo url('app=ju_travel'); ?>"> <span>旅游团</span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="top-b">
            <div class="top-b-ct">
                <span class="left"></span>
                <span class="right"></span>
            </div>
        </div>
        <div class="content">
            
            <div class="" area="brand_top" widget_type="area">
            <?php $this->display_widgets(array('page'=>'ju_brand','area'=>'brand_top')); ?>
            </div>
            <a name="module"></a>
            <div class="logos-ct mt10">
            	<div class="brands-list">
                	<ul class="brand-tabs clearfix ks-switchable-nav">
                        <li class="ks-active"><span class="brands-tab tab-all">所有品牌 (<?php echo $this->_var['brands_allcount']; ?>)</span></li>
                        <?php $_from = $this->_var['brands_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>
                        <li><span class="brands-tab"><?php echo $this->_var['brand']['tag']; ?> (<?php echo $this->_var['brand']['count']; ?>)</span></li>
                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
            		<div class="brand-conts ks-switchable-content">
                        <div class="first all-content tab-content expandble" style="display: block; overflow: hidden; height:168px;"> 
                        	<ul class="clearfix">
                            	<?php $_from = $this->_var['brands_all']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>
                            	<li id="<?php echo $this->_var['brand']['brand_id']; ?>">
                                	<div class="flipper">
                                    	<div class="front">
                                        	<a href="javascript:;" title="<?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?>" >
                                            	<img width="90" height="37" src="<?php echo $this->_var['brand']['brand_logo']; ?>">
                                            </a>
                                        </div>
                                        <div class="back"><span><?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?></span></div>
                                     </div>
                                </li>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                             </ul>
                             <span class="collapse"></span>
                         </div>
                         <?php $_from = $this->_var['brands_arr']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'arr');if (count($_from)):
    foreach ($_from AS $this->_var['arr']):
?>
                        <div class="all-content tab-content" style=" display:none;"> 
                        	<ul class="clearfix">
                            	<?php $_from = $this->_var['arr']['brands']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'brand');if (count($_from)):
    foreach ($_from AS $this->_var['brand']):
?>
                            	<li id="<?php echo $this->_var['brand']['brand_id']; ?>">
                                    	<div class="front">
                                        	<a href="javascript:;" title="<?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?>">
                                            	<img width="90" height="37" src="<?php echo $this->_var['brand']['brand_logo']; ?>">
                                            </a>
                                        </div>
                                        <div class="back"><span><?php echo htmlspecialchars($this->_var['brand']['brand_name']); ?></span></div>
                                </li>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                             </ul>
                         </div>
                         <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                     </div>
                 </div>
            </div>
            <div class="" area="brand_middle" widget_type="area">
            <?php $this->display_widgets(array('page'=>'ju_brand','area'=>'brand_middle')); ?>
            </div>
            <div class="ju-list" style=" min-height:100px;">
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
        </div>
    </div>
</div>
<script>
    KISSY.ready(function(S) {
        var tabs = new S.Tabs('.brands-list',{
             aria:false
        });
    });
	$(function(){
		$(".brands-list .first").hover(function(){
			$(this).css({"height":"auto","min-height":"168px"});
			$(".collapse").css("background-position","0 -57px");
		},function(){
			$(this).css("height","168px");
			$(".collapse").css("background-position","0 5px");
		})
	})
</script>
<?php echo $this->fetch('footer.html'); ?>
