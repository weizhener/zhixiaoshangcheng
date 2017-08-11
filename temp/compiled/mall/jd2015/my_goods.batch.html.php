<?php echo $this->fetch('member.header.html'); ?>
<style>
.sub_btn {margin-right:10px; background:transparent url(<?php echo $this->res_base . "/" . 'images/member/btn.gif'; ?>) no-repeat scroll 0 -253px; border:0 none; color:#3F3D3E; cursor:pointer; font-weight:bold; height:32px; width:120px; }
.add_wrap .assort .txt {width: 60px;}
</style>
<script type="text/javascript">
//<!CDATA[
$(function(){
    // add store_gcategory
    gcategoryInit("gcategory");
    // validate
    $('#batch_form').validate({
        errorPlacement: function(error, element){
            $(element).parent().next('.new_add').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        onkeyup : false,
        rules : {
            price      : {
                number     : true,
                min : 0
            },
            stock      : {
                digits    : true
            }
        },
        messages : {
            price       : {
                number     : '此项仅能为数字',
                min : '价格必须大于或等于零'
            },
            stock       : {
                digits  : '此项仅能为数字'
            }
        }
    });
});
//]]>
</script>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
    <div class="wrap">
      <div class="public">
        <form id="batch_form" method="POST" enctype="multipart/form-data">
          <div class="information_index">
            <div class="add_wrap">
              <div class="assort">
                <p class="txt">商品分类: </p>
                <p id="gcategory" class="select">
                  <input type="hidden" name="cate_id" value="0" class="mls_id" />
                  <input type="hidden" name="cate_name" value="" class="mls_names" />
                  <select>
                    <option>请选择...</option>
                    <?php echo $this->html_options(array('options'=>$this->_var['mgcategories'])); ?>
                  </select>
                </p>
              </div>
              <div class="assort">
                <p class="txt">本店分类: </p>
                <p class="select">
                  <select name="sgcate_id[]" class="sgcategory">
                    <option value="0">请选择...</option>
                    <?php echo $this->html_options(array('options'=>$this->_var['sgcategories'])); ?>
                  </select>
                </p>
                <p class="new_add">
                  <a id="add_sgcategory" class="btn" href="javascript:;">新增</a>
                  <span>不修改请不要选择</span>
                </p>
              </div>
              <div class="assort">
                <p class="txt">品牌: </p>
                <p>
                  <input type="text" name="brand" class="text" />
                </p>
                <p class="new_add"><span>不修改请留空</span></p>
              </div>
              <div class="assort">
                <p class="txt">是否上架: </p>
                <p>
                  <label>
                  <input type="radio" name="if_show" value="-1" checked="checked" />
                  保持不变</label>
                  <label>
                  <input type="radio" name="if_show" value="1" />
                  上架</label>
                  <label>
                  <input type="radio" name="if_show" value="0" />
                  下架</label>
                </p>
              </div>
              <div class="assort">
                <p class="txt">是否推荐: </p>
                <p>
                  <label>
                  <input type="radio" name="recommended" value="-1" checked="checked" />
                  保持不变</label>
                  <label>
                  <input type="radio" name="recommended" value="1" />
                  推荐</label>
                  <label>
                  <input type="radio" name="recommended" value="0" />
                  取消推荐</label>
                </p>
              </div>
                
                
                
                <div class="assort">
                    <p class="txt">会员价： </p>
                    <p>
                        <label><input name="if_open" value="1" type="radio"  checked="checked"  /> 是</label>
                        <label><input name="if_open" value="0" type="radio" /> 否</label>
                    </p>
                </div>
                <?php $_from = $this->_var['ugrades']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'ugrade');$this->_foreach['fe_ugrade'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_ugrade']['total'] > 0):
    foreach ($_from AS $this->_var['ugrade']):
        $this->_foreach['fe_ugrade']['iteration']++;
?>
                <div class="assort">
                    <p class="txt"><?php echo $this->_var['ugrade']['grade_name']; ?>: </p>
                    <p class="select">
                        <input name="grade[]" value="<?php echo $this->_var['ugrade']['grade']; ?>" type="hidden" />
                        <input name="grade_id[]" value="<?php echo $this->_var['ugrade']['grade_id']; ?>" type="hidden" /><input name="grade_discount[]" value="<?php echo ($this->_var['ugrade']['grade_discount'] == '') ? '' : $this->_var['ugrade']['grade_discount']; ?>" type="text" class="text width_short" />
                    </p>
                    <p class="new_add"><span>不修改请留空</span></p>
                </div>
                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>		
                
                
                
                
                
              <div class="assort">
                <p class="txt">价格: </p>
                <p class="select">
                  <select name="price_change"><?php echo $this->html_options(array('options'=>$this->_var['lang']['change_array'])); ?></select>
                  <input name="price" type="text" class="text" />
                </p>
                <p class="new_add"><span>不修改请留空</span></p>
              </div>
              <div class="assort">
                <p class="txt">库存: </p>
                <p class="select">
                  <select name="stock_change"><?php echo $this->html_options(array('options'=>$this->_var['lang']['change_array'])); ?></select>
                  <input name="stock" type="text" class="text" />
                </p>
                <p class="new_add"><span>不修改请留空</span></p>
              </div>
            </div>
          </div>
          <div class="send_out">
            <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
            <input class="sub_btn" type="submit" name="Submit" value="提交" />
            <input class="sub_btn" type="reset" name="Reset" value="重置" />
          </div>
        </form>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>