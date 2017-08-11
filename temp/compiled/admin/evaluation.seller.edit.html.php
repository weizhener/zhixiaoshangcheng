<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>买家评价修改</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=evaluation&act=get_evaluation_seller">卖家评价</a></li>
  </ul>
</div>
<div class="info">
  <form method="post">
    <table class="infoTable">
      <tr id="tr_close_reason">
          <th class="paddingT15" valign="top">卖家评价:</th>
          <td class="paddingT15 wordSpacing5">
              <label><input type="radio" name="seller_evaluation" value="3" <?php if ($this->_var['order_goods']['seller_evaluation'] == '3'): ?>checked="checked"<?php endif; ?> />好评</label>
              <label><input type="radio" name="seller_evaluation" value="2" <?php if ($this->_var['order_goods']['seller_evaluation'] == '2'): ?>checked="checked"<?php endif; ?> />中评</label>
              <label><input type="radio" name="seller_evaluation" value="1" <?php if ($this->_var['order_goods']['seller_evaluation'] == '1'): ?>checked="checked"<?php endif; ?> />差评</label>
              <textarea name="seller_comment" ><?php echo $this->_var['order_goods']['seller_comment']; ?></textarea>
          </td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" />
        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?>