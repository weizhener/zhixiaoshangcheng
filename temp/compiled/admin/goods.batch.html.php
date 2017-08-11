<?php echo $this->fetch('header.html'); ?>

<div id="rightTop">

  <p>商品操作</p>

  <ul class="subnav">

  </ul>

</div>

<div class="info">

  <form method="post">

    <table class="infoTable">

      <?php if ($_GET['act'] == "recommend"): ?>

      <tr>

        <th class="paddingT15">推荐到:</th>

        <td class="paddingT15 wordSpacing5">

            <ul class="recommend_to">

                <?php $_from = $this->_var['recommends']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('recom_id', 'recom_name');$this->_foreach['fe_recom'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_recom']['total'] > 0):
    foreach ($_from AS $this->_var['recom_id'] => $this->_var['recom_name']):
        $this->_foreach['fe_recom']['iteration']++;
?>

                <li><label><input type="radio" name="recom_id" value="<?php echo $this->_var['recom_id']; ?>" /> <?php echo $this->_var['recom_name']; ?></label></li>

                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>

            </ul>

        </td>

      </tr>

      <?php elseif ($_GET['act'] == "edit"): ?>

      <script type="text/javascript" src="index.php?act=jslang"></script>

      <script type="text/javascript">

//<!CDATA[

$(function(){

    // multi-select mall_gcategory

    gcategoryInit("gcategory");



    $(":radio[name='closed']").click(function(){

        if (this.value == 1)

        {

            $("#close_reason").show();

        }

        else

        {

            $("#close_reason").hide();

        }

    });

});

//]]>

</script>
      <tr>

        <th class="paddingT15">设置产品:</th>

        <td class="paddingT15 wordSpacing5"><?php echo $this->_var['goods']['goods_name']; ?></td>

      </tr>
      
      
      <tr>

        <th class="paddingT15">供货价格:</th>

        <td class="paddingT15 wordSpacing5"><input value="<?php echo $this->_var['goods']['gh_price']; ?>" class="infoTableInput2" type="text" name="gh_price" id="gh_price" />

          </td>

      </tr>
      
      <tr>

        <th class="paddingT15">市场价格:</th>

        <td class="paddingT15 wordSpacing5"><input value="<?php echo $this->_var['goods']['market_price']; ?>" class="infoTableInput2" type="text" name="market_price" id="market_price" />

          </td>

      </tr>
      
      <tr>

        <th class="paddingT15">销售价格:</th>

        <td class="paddingT15 wordSpacing5"><input value="<?php echo $this->_var['goods']['price']; ?>" class="infoTableInput2" type="text" name="price" id="price" />

          </td>

      </tr>
      
      
      <tr>

        <th class="paddingT15">可用积分:</th>

        <td class="paddingT15 wordSpacing5"><input value="<?php echo $this->_var['goods']['integral_max_exchange']; ?>" class="infoTableInput2" type="text" name="integral_max_exchange" id="integral_max_exchange" />

          </td>

      </tr>
      
      

      <tr>

        <th class="paddingT15">分类名:</th>

        <td class="paddingT15 wordSpacing5"><div id="gcategory">

            <input type="hidden" name="cate_id" value="0" class="mls_id" />

            <input type="hidden" name="cate_name" value="" class="mls_names" />

            <select>

              <option>请选择...</option>





          <?php echo $this->html_options(array('options'=>$this->_var['gcategories'])); ?>





            </select>

            <span class="grey">不修改请不要选择</span> </div></td>

      </tr>

      <tr>

        <th class="paddingT15">品牌:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" type="text" name="brand" id="brand" />

          <span class="grey">不修改请留空</span></td>

      </tr>


      <tr>

        <th class="paddingT15">禁售状态:</th>

        <td class="paddingT15 wordSpacing5"><p>

            <label>

            <input type="radio" name="closed" value="-1" checked="checked" />

            保持不变</label>

            <label>

            <input type="radio" name="closed" value="1" />

            禁售</label>

            <label>

            <input type="radio" name="closed" value="0" />

            可售</label>

          </p></td>

      </tr>
      
      <tr id="close_reason" style="display:none">

        <th class="paddingT15"><label for="close_reason">禁售原因:</label></th>

        <td class="paddingT15 wordSpacing5"><textarea id="close_reason" name="close_reason" cols="60" rows="3"></textarea></td>

      </tr>
      
     <tr>

        <th class="paddingT15">金花金额1:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" value="<?php echo $this->_var['goods']['jinhua1']; ?>" type="text" name="jinhua1" id="jinhua1" />

          </td>

      </tr>
      
      
      <tr>

        <th class="paddingT15">金花金额2:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" value="<?php echo $this->_var['goods']['jinhua2']; ?>"  type="text" name="jinhua2" id="jinhua2" />

          </td>

      </tr>
      
      <tr>

        <th class="paddingT15">金花金额3:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" value="<?php echo $this->_var['goods']['jinhua3']; ?>"  type="text" name="jinhua3" id="jinhua3" />

         </td>

      </tr>
      
      
      <tr>

        <th class="paddingT15">金花金额4:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" value="<?php echo $this->_var['goods']['jinhua4']; ?>"  type="text" name="jinhua4" id="jinhua4" />

          </td>

      </tr>
      
      
      <tr>

        <th class="paddingT15">金花金额5:</th>

        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" value="<?php echo $this->_var['goods']['jinhua5']; ?>"  type="text" name="jinhua5" id="jinhua5" />

          </td>

      </tr>
      



      <?php elseif ($_GET['act'] == "drop"): ?>

      <tr>

        <th class="paddingT15"> <label for="drop_reason">删除原因:</label></th>

        <td class="paddingT15 wordSpacing5"><textarea id="drop_reason" name="drop_reason" cols="60" rows="3" /></textarea></td>

      </tr>

      <?php endif; ?>
      
      
      
      
 
      
      

      <tr>

        <th></th>

        <td class="ptb20"><input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />

          <input class="formbtn" type="submit" name="Submit" value="提交" />

          <input class="formbtn" type="button" value="返回" onclick="history.go(-1)" />

        </td>

      </tr>

    </table>

  </form>

</div>

<?php echo $this->fetch('footer.html'); ?>