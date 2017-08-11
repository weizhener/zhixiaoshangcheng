<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="index.php?act=jslang"></script>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $('#ultimate_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        onkeyup    : false,
        rules : {
			<?php if ($_GET['act'] == 'add'): ?>
			user_name: {
				required : true,
                remote : {
                    url  : 'index.php?app=ultimate_store&act=check_user_name',
                    type : 'get',
                    data : {
                        brand_id : function(){
                            return $('#user_name').val();
                        },
                    }
                }
            },
			<?php endif; ?>
            brand_id: {
                remote : {
                    url  : 'index.php?app=ultimate_store&act=check_brand&ultimate_id=<?php echo $this->_var['ultimate']['ultimate_id']; ?>',
                    type : 'get',
                    data : {
                        brand_id : function(){
                            return $('#brand_id').val();
                        },
                    }
                }
            },
			cate_id: {
                remote : {
                    url  : 'index.php?app=ultimate_store&act=check_gcategory&ultimate_id=<?php echo $this->_var['ultimate']['ultimate_id']; ?>',
                    type : 'get',
                    data : {
                        cate_id : function(){
                            return $('#cate_id').val();
                        },
                    }
                }
            },
			keyword: {
                remote : {
                    url  : 'index.php?app=ultimate_store&act=check_kw&ultimate_id=<?php echo $this->_var['ultimate']['ultimate_id']; ?>',
                    type : 'get',
                    data : {
                        keyword: function(){
                            return $('#keyword').val();
                        },
                    }
                }
            }
        },
        messages : {
		   <?php if ($_GET['act'] == 'add'): ?>
		   user_name : {
			   required : '店家用户名不能为空',
               remote: '该用户没有申请开店或者店铺没有通过审核' 	
		   },
		   <?php endif; ?>
           brand_id: {
                remote: '相关的品牌已存在，你需要保持每个品牌分配给店铺的唯一性'
           },
		   cate_id: {
                remote: '相关的分类已存在，你需要保持每个分类分配给店铺的唯一性'
           },
		   keyword: {
                remote: '关键字已存在'
           }   
        }
    });
});
//]]>
</script>
<div id="rightTop">
  <p>旗舰店</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=ultimate_store">管理</a></li>
    <?php if ($_GET['act'] == 'add'): ?>
    <li><span>新增</span></li>
    <?php else: ?>
    <li><a class="btn1" href="index.php?app=ultimate_store&act=add">新增</a></li>
    <li><span>编辑</span></li>
    <?php endif; ?>
  </ul>
</div>
<div class="info">
  <form method="post" id="ultimate_form">
    <table class="infoTable">
      <?php if ($_GET['act'] == 'add'): ?>
      <tr>
        <th class="paddingT15">请输入店家用户名:</th>
        <td class="paddingT15 wordSpacing5">
        	<input type="text" name="user_name" id="user_name" value="" />
       </td>
      </tr>
      <?php else: ?>
      <tr>
        <th class="paddingT15">店铺名称:</th>
        <td class="paddingT15 wordSpacing5">
        	<?php echo $this->_var['ultimate']['store_name']; ?>
       </td>
      </tr>
      <?php endif; ?>
      <tr>
      <th class="paddingT15"> 选择相关联的品牌:</th>
         <td class="paddingT15 wordSpacing5" >
            <select id="brand_id" name="brand_id">
              <option  value="">选择相关联的品牌</option>
              <?php echo $this->html_options(array('options'=>$this->_var['brands'],'selected'=>$this->_var['ultimate']['brand_id'])); ?>
            </select>
            <span class="gray">优先级最高，如果搜索条件中同时有品牌，关键词，分类的，则优先显示品牌对应的旗舰店。</span>
         </td>
      </tr>
      <tr>
        <th class="paddingT15"> <label>店铺相关关键字:</label></th>
        <td class="paddingT15 wordSpacing5">
        	<input id="keyword" name="keyword" value="<?php echo $this->_var['ultimate']['keyword']; ?>" />
            <span class="gray">优先级次之，如果搜索条件中同时有关键词，分类的，则优先显示关键词对应的旗舰店。</span>
        </td>
      </tr>
      <tr>
      <th class="paddingT15"> 选择相关联的商品分类:</th>
         <td class="paddingT15 wordSpacing5" >
            <select id="cate_id" name="cate_id">
              <option value="">选择相关联的商品分类</option>
              <?php echo $this->html_options(array('options'=>$this->_var['gcategories'],'selected'=>$this->_var['ultimate']['cate_id'])); ?>
            </select>
            <span class="gray">优先级最低，如果搜索条件中没有品牌和关键词，则显示该分类对应的旗舰店（不显示该分类下的子分类对应的旗舰店）。</span>
         </td>
      </tr>
      
      <tr>
        <th class="paddingT15"> <label>旗舰店介绍:</label></th>
        <td class="paddingT15 wordSpacing5"><textarea id="description" style="width:300px;height:100px;" name="description"><?php echo $this->_var['ultimate']['description']; ?></textarea></td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="status">开启状态:</label></th>
        <td class="paddingT15 wordSpacing5"><?php echo $this->html_radios(array('name'=>'status','options'=>$this->_var['status'],'checked'=>$this->_var['ultimate']['status'])); ?></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" /></td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>