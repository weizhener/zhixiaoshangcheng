<?php echo $this->fetch('top.html'); ?>
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
    
    <div id="page" class="mingpin">
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
                    <li class="current menu-jump"><a class="menu-link"  href="<?php echo url('app=ju_mingpin'); ?>"><span>聚名品</span></a>
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
        <div class="c-bwrap">
            <div area="mingpin_top" widget_type="area">
            <?php $this->display_widgets(array('page'=>'ju_mingpin','area'=>'mingpin_top')); ?>
            </div>
        </div>
        <div class="content">
        	 <div area="mingpin_floor" widget_type="area">
            	<?php $this->display_widgets(array('page'=>'ju_mingpin','area'=>'mingpin_floor')); ?>
             </div>
    	</div>
</div>
<?php echo $this->fetch('footer.html'); ?>
