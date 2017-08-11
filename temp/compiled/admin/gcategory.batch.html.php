<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>商品分类</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=gcategory">管理</a></li>
    <li><a class="btn1" href="index.php?app=gcategory&amp;act=add">新增</a></li>
    <li><span>批量编辑</span></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data">
    <table class="infoTable">
      <tr>
        <th class="paddingT15">显示:</th>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input type="radio" name="if_show" value="-1" checked="checked" />
            保持不变</label>
            <label>
            <input type="radio" name="if_show" value="1" />
            是</label>
            <label>
            <input type="radio" name="if_show" value="0" />
            否</label>
          </p></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
          <input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="reset" value="重置" />
        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 