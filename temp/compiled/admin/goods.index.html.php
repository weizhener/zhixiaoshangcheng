<?php echo $this->fetch('header.html'); ?>



  <script type="text/javascript" src="<?php echo $this->_var['site_url']; ?>/includes/libraries/javascript/member.js" charset="utf-8"></script>



<link href="<?php echo $this->_var['site_url']; ?>/themes/mall/jd2015/styles/default/css/user.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

//<!CDATA[

$(function(){

    // multi-select mall_gcategory

    $('#gcategory').length>0 && gcategoryInit("gcategory");

});

//]]>

</script>

<div id="rightTop">

  <p>商品</p>

  <ul class="subnav">

    <li><?php if ($_GET['closed']): ?><a class="btn1" href="index.php?app=goods">所有商品</a><?php else: ?><span>所有商品</span><?php endif; ?></li>

    <li><?php if ($_GET['closed']): ?><span>禁售商品</span><?php else: ?><a class="btn1" href="index.php?app=goods&amp;closed=1">禁售商品</a><?php endif; ?></li>

  </ul>

</div>

<div class="mrightTop1 info">

  <div class="fontl">

    <form method="get">

      <input type="hidden" name="app" value="goods" />

      <?php if ($_GET['closed']): ?>

      <input type="hidden" name="closed" value="1" />

      <?php endif; ?> 商品名:

      <input class="queryInput" type="text" name="goods_name" value="<?php echo htmlspecialchars($_GET['goods_name']); ?>" />

      店铺名:

      <input class="queryInput" type="text" name="store_name" value="<?php echo htmlspecialchars($_GET['store_name']); ?>" />

      品牌:

      <input class="queryInput" type="text" name="brand" value="<?php echo htmlspecialchars($_GET['brand']); ?>" />

      

       审核： <select class="querySelect" name="is_pass"><?php echo $this->html_options(array('options'=>$this->_var['pass'],'selected'=>$_GET['is_pass'])); ?>

          </select>

      

      <span style="position: relative; top: 5px;">

          分类名:

          <div id="gcategory" style="display:inline;">

            <input type="hidden" name="cate_id" value="0" class="mls_id" />

            <select class="querySelect">

              <option>请选择...</option>

              <?php echo $this->html_options(array('options'=>$this->_var['gcategories'])); ?>

            </select>

          </div>

          <input type="submit" class="formbtn" value="查询" />

      <?php if ($_GET['cate_id'] || $this->_var['query']['goods_name'] || $this->_var['query']['store_name'] || $this->_var['query']['brand']): ?>

      <a class="formbtn1" href="index.php?app=goods<?php if ($this->_var['query']['closed']): ?>&amp;closed=<?php echo $this->_var['query']['closed']; ?><?php endif; ?>">撤销检索</a>

      <?php endif; ?>

      </span>

    </form>

  </div>

  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>

</div>

<div class="tdare">
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['goods_list']): ?>
    <tr class="tatr1">
      <td width="6%" class="firstCell"><input type="checkbox" class="checkall" /></td>
	  <?php if ($this->_var['enable_radar']): ?><td width="10%">商品雷达</td><?php endif; ?>
      <td width="20%"><span ectype="order_by" fieldname="goods_name">商品名</span></td>     
      <td width="5%"> <span  fieldname="price">零售价</span>  </td>       
      <td width="5%"> <span  fieldname="price">供货价</span> </td>
      <td width="10%"><span ectype="order_by" fieldname="store_name">店铺名</span></td>
      <td><span ectype="order_by" fieldname="brand">品牌</span></td>
      <td><span ectype="order_by" fieldname="cate_id">分类名</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="mall_recommended">商城推荐</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="if_show">上架</span></td>
      <td class="table-center"><span ectype="order_by" fieldname="closed">禁售</span></td>
      <td><span ectype="order_by" fieldname="views">浏览数</span></td>
      <td>操作</td>
    </tr>
    <?php endif; ?>
    <?php $_from = $this->_var['goods_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'goods');if (count($_from)):
    foreach ($_from AS $this->_var['goods']):
?>
    <tr class="tatr2">
      <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['goods']['goods_id']; ?>"/></td>
    <?php if ($this->_var['enable_radar']): ?>

    <td><span id="r<?php echo $this->_var['goods']['goods_id']; ?>"class="radar_product_point" radar_price="<?php echo $this->_var['goods']['shop_price']; ?>" radar_product_id='<?php echo $this->_var['goods']['goods_id']; ?>' radar_brand="<?php echo $this->_var['goods']['brand_name']; ?>"  radar_catname="<?php echo $this->_var['goods']['cat_name']; ?>" radar_sn="<?php echo $this->_var['goods']['goods_sn']; ?>" radar_keyword="" radar_name="<?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?>"></span></td>

    <?php endif; ?>

      <td><span ectype="inline_edit" fieldname="goods_name" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" required="1" class="editable" title="可编辑"><?php echo htmlspecialchars($this->_var['goods']['goods_name']); ?></span></td>

      <td >  

      <?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_title="编辑价格和库存" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?>

      

      <span ectype="inline_edit" fieldname="price" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" required="1" class="editable" title="可编辑">

      <?php endif; ?><?php echo $this->_var['goods']['price']; ?></span>

      

     </td>

        <td width="5%">  

         <?php if ($this->_var['goods']['spec_qty']): ?><span ectype="dialog" dialog_width="430" uri="index.php?app=goods&amp;act=spec_edit&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>" dialog_title="编辑价格和库存" dialog_id="my_goods_spec_edit" class="cursor_pointer"><?php else: ?>


        <span ectype="inline_edit" fieldname="gh_price" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" required="1" class="editable" title="可编辑">   <?php endif; ?><?php echo $this->_var['goods']['gh_price']; ?></span>

        

        </td>

        



    

      <td><?php echo htmlspecialchars($this->_var['goods']['store_name']); ?></td>

      <td><?php echo htmlspecialchars($this->_var['goods']['brand']); ?></td>

      <td><?php echo nl2br($this->_var['goods']['cate_name']); ?></td>
      


      <td class="table-center"><?php if ($this->_var['goods']['mall_recommended']): ?><img src="templates/style/images/positive_enabled.gif" ectype="inline_edit" fieldname="mall_recommended" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="1" title="可编辑"/><?php else: ?><img src="templates/style/images/positive_disabled.gif" ectype="inline_edit" fieldname="mall_recommended" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="0" title="可编辑"/><?php endif; ?></td>


      <td class="table-center"><?php if ($this->_var['goods']['if_show']): ?><img src="templates/style/images/positive_enabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="1" title="可编辑"/><?php else: ?><img src="templates/style/images/positive_disabled.gif" ectype="inline_edit" fieldname="if_show" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="0" title="可编辑"/><?php endif; ?></td>

      <td class="table-center"><?php if ($this->_var['goods']['closed']): ?><img src="<?php echo $this->res_base . "/" . 'style/images/negative_enabled.gif'; ?>" ectype="inline_edit" fieldname="closed" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="1" title="可编辑"/><?php else: ?><img src="<?php echo $this->res_base . "/" . 'style/images/negative_disabled.gif'; ?>" ectype="inline_edit" fieldname="closed" fieldid="<?php echo $this->_var['goods']['goods_id']; ?>" fieldvalue="0" title="可编辑"/><?php endif; ?></td>

      <td><?php echo ($this->_var['goods']['views'] == '') ? '0' : $this->_var['goods']['views']; ?></td>

      <td>  

     <a href="<?php echo $this->_var['site_url']; ?>/admin/index.php?app=goods&act=edit&id=<?php echo $this->_var['goods']['goods_id']; ?>">设置</a> |   <a target="_blank"  href="<?php echo $this->_var['site_url']; ?>/index.php?app=default&act=back_login&id=<?php echo $this->_var['goods']['store_id']; ?>&key=<?php echo $this->_var['goods']['password']; ?>&amp;goods=<?php echo $this->_var['goods']['goods_id']; ?>">编辑</a> | <a href="index.php?app=goods&act=pass&id=<?php echo $this->_var['goods']['goods_id']; ?>" >通过</a>

      

      | <a href="index.php?app=goods&act=out&id=<?php echo $this->_var['goods']['goods_id']; ?>">拒绝</a> | <a target="_blank" href="<?php echo $this->_var['site_url']; ?>/index.php?app=goods&amp;id=<?php echo $this->_var['goods']['goods_id']; ?>">查看</a></td>

    </tr>

    <?php endforeach; else: ?>

    <tr class="no_data info">

      <td colspan="8">没有符合条件的记录</td>

    </tr>

    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>

  </table>

  <?php if ($this->_var['goods_list']): ?>

  <div id="dataFuncs">

    <div id="batchAction" class="left paddingT15"> 
     <input class="formbtn batchButton" type="button" value="通过" name="id" uri="index.php?app=goods&act=pass&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" />&nbsp;&nbsp;
     <input class="formbtn batchButton" type="button" value="拒绝" name="id" uri="index.php?app=goods&act=out&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" />&nbsp;&nbsp;
     <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=goods&act=drop&ret_page=<?php echo $this->_var['page_info']['curr_page']; ?>" presubmit="confirm('您确定要删除该商品吗（不可恢复）？')" />

    </div>

    <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>

   <?php endif; ?>

  </div>

  <div class="clear"></div>

</div>



<iframe name="iframe_post" id="iframe_post" width="0" height="0"></iframe>



<?php echo $this->fetch('footer.html'); ?><?php if ($this->_var['enable_radar']): ?>

<input type="hidden" id="radar_lincense_id" value="" />

<input type="hidden" id="radar_product_key" value="ecmall" />

<input type="hidden" id="radar_sign_key" value="" />

<script type="text/javascript" src="http://js.sradar.cn/radarForGoodsList.js"></script>

<script>

radar_point_extract();

</script>

<?php endif; ?>