<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>买家评价修改</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=evaluation&act=get_evaluation_buyer">买家评价</a></li>
  </ul>
</div>
<div class="info">
  <form method="post">
    <table class="infoTable">
      <tr id="tr_close_reason">
          <th class="paddingT15" valign="top">买家评价:</th>
          <td class="paddingT15 wordSpacing5">
              <label><input type="radio" name="evaluation" value="3" <?php if ($this->_var['order_goods']['evaluation'] == '3'): ?>checked="checked"<?php endif; ?> />好评</label>
              <label><input type="radio" name="evaluation" value="2" <?php if ($this->_var['order_goods']['evaluation'] == '2'): ?>checked="checked"<?php endif; ?> />中评</label>
              <label><input type="radio" name="evaluation" value="1" <?php if ($this->_var['order_goods']['evaluation'] == '1'): ?>checked="checked"<?php endif; ?> />差评</label>
              <textarea name="comment" ><?php echo $this->_var['order_goods']['comment']; ?></textarea>
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