<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>管理员管理</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=admin">管理</a></li>
    <li><span>添加</span></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data" id="test_form">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> 用户名:</th>
        <td class="paddingT15 wordSpacing5"><input class="infoTableInput2" name="user_name" type="text" id="user_name" /><label class="field_notice">首先输入您要添加的管理员会员名</label></td>
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