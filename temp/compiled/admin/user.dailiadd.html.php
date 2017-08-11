<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
//<!CDATA[
$(function(){
	 regionInit("region");
 $('#add_region_button').click(function(){
        var region_id = $('#region_id').val();
        var region_name = $('#region_name').val();
        if(!region_id || !region_name){
            return;
        }
        if($('#region_' + region_id).length == 0){
            $('#current_cod_regions').append($('<label id="region' + region_id + '"><input type="checkbox" checked="true" name="cod_regions[' + region_id + ']" id="region_' + region_id + '" value="' + region_name + '" />&nbsp;' + region_name + '<a href="javascript:void(0);" class="delete" onclick="del_region('+region_id+')">删除</a></label>'));
        }
   });	
});	

function del_region(region_id){
    $('#region'+region_id).remove();
}
	//]]>
</script>
<div id="rightTop">
  <p>会员管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=user&daili">管理</a></li>
    <li>
      
      <span>新增</span>
     
    </li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data" id="user_form">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> 区域名称:</th>
        <td class="paddingT15 wordSpacing5">
      
          <input class="infoTableInput2" id="title" type="text" name="title" value="<?php echo htmlspecialchars($this->_var['user']['title']); ?>" />
        
              </td>
      </tr>
      
      <tr>
        <th class="paddingT15"> 会员ID:</th>
        <td class="paddingT15 wordSpacing5">
      
          <input class="infoTableInput2" id="user_id" type="text" name="user_id" value="<?php echo htmlspecialchars($this->_var['user']['user_id']); ?>" />
        
              </td>
      </tr>
      
      
       <tr>
        <th class="paddingT15"> 代理区域:</th>
        <td class="paddingT15 wordSpacing5">
        <div class="ddd" style="width:300;float:left;">
        
                   <div id="region">
                    <input type="hidden" name="region_id" id="region_id" class="mls_id" />
                    <input type="hidden" name="region_name" id="region_name" class="mls_names" />
                    <select>
                      <option>请选择...</option>
                      <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
                    </select>
                    <input class="btn" type="button" id="add_region_button" value="新增" />
                    </div>
                    
                    
                    <div class="zone" id="current_cod_regions">
                    <?php $_from = $this->_var['cod_regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('cod_r_id', 'cod_r');if (count($_from)):
    foreach ($_from AS $this->_var['cod_r_id'] => $this->_var['cod_r']):
?>
                    <label id="region<?php echo $this->_var['cod_r_id']; ?>"><input type="checkbox" checked="true" name="cod_regions[<?php echo $this->_var['cod_r_id']; ?>]" id="region_<?php echo $this->_var['cod_r_id']; ?>" value="<?php echo $this->_var['cod_r']; ?>" />&nbsp;<?php echo $this->_var['cod_r']; ?><a href="javascript:;" class="delete" onclick="del_region(<?php echo $this->_var['cod_r_id']; ?>)">删除</a></label>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

                </div>
                
                </div>
              </td>
      </tr>
      
       <tr>
        <th class="paddingT15">推荐人比例:</th>
        <td class="paddingT15 wordSpacing5">
      
          <input class="infoTableInput2" id="tjbl" type="text" name="tjbl" value="<?php echo htmlspecialchars($this->_var['user']['tjbl']); ?>" />
         <p>如填0.2</p>
              </td>
      </tr>
      
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" />        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>