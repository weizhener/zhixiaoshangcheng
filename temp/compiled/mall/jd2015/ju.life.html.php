<?php echo $this->fetch('top.html'); ?>
<script language="JavaScript">
$(function(){
	$(window).scroll(function(){
		if($(window).scrollTop()>390){
			$(".ju-category").css({"position":"fixed","top":"-20px","z-index":"1000"});
		}else{
			$(".ju-category").css("position","static");
		}
	});
})
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
             <h2 ectype="cate">
                <a href="javascript:;" id="<?php echo $this->_var['cate']['id']; ?>"><?php echo $this->_var['cate']['value']; ?></a>
            </h2>
            <ul class="jcategory" ectype="cate">
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
    
    <div id="page" class="life">
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
            	<div area="life_top" widget_type="area" class="top">
                    <?php $this->display_widgets(array('page'=>'ju_life','area'=>'life_top')); ?>
                </div>
                <div class="clearfix">
                    <div area="life_left" widget_type="area" class="left">
                        <?php $this->display_widgets(array('page'=>'ju_life','area'=>'life_left')); ?>
                    </div>
                    <div area="life_right" widget_type="area" class="right">
                        <?php $this->display_widgets(array('page'=>'ju_life','area'=>'life_right')); ?>
                    </div>
                </div>
            </div>
            <div class="w990 clearfix">
                <div class="ju-category">
                     <div class="filter-cat clearfix">
                        <h2><a href="javascript:void(0);">分类<i></i></a></h2>
                        <ul ectype="cate">
                             <li><a href="<?php echo url('app=ju_life&act=search'); ?>" class="all on">全部&nbsp;<?php echo $this->_var['ju_count']; ?></a></li>
                             <?php $_from = $this->_var['cate_child']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?>
                             <li><a href="<?php echo url('app=ju_life&act=search&cate_id=' . $this->_var['cate']['cate_id']. ''); ?>"><?php echo $this->_var['cate']['cate_name']; ?>&nbsp;<span><?php echo $this->_var['cate']['count']; ?></span></a></li>
                             <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                     </div>
                                           
                    <div class="filter-cat clearfix" style="border:none;">
                    	<h2><a href="javascript:void(0);">区域<i></i></a></h2>
                        <ul>
                        	<li><a class="all on" href="<?php echo url('app=ju_life&act=search'); ?>">全部&nbsp;</a></li>
                            <?php $_from = $this->_var['region']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'reg');if (count($_from)):
    foreach ($_from AS $this->_var['reg']):
?>
                            <li><a href="<?php echo url('app=ju_life&act=search&region_id=' . $this->_var['reg']['region_id']. ''); ?>"><?php echo htmlspecialchars($this->_var['reg']['region_name']); ?></a></li>
                            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                        </ul>
                    </div>
                </div>
			</div>
        
            <div class="content">
                 <div area="life_floor" widget_type="area">
                    <?php $this->display_widgets(array('page'=>'ju_life','area'=>'life_floor')); ?>
                 </div>
            </div>
        </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
