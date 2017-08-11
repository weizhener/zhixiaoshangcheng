<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>导入数据</p>
  <ul class="subnav">
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data">
    <table class="infoTable">
      <tr>
        <th class="paddingT15">请选择文件:</th>
        <td class="paddingT15 wordSpacing5">
        <input type="file" name="csv" id="csv" />
        <span class="grey">如果导入速度较慢，建议您把文件拆分为几个小文件，然后分别导入</span></td>
      </tr>
      <tr>
        <th class="paddingT15">请选择文件编码:</th>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input type="radio" name="charset" value="utf-8" checked="checked" />
            utf-8</label>
            <label>
            <input type="radio" name="charset" value="gbk" />
            gbk</label>
            <label>
            <input type="radio" name="charset" value="big5" />
            big5</label>
            <span class="grey"><?php echo $this->_var['note_for_import']; ?></span>
          </p>
          </td>
      </tr>
      <tr>
        <th class="paddingT15" valign="top">文件格式:</th>
        <td class="paddingT15 wordSpacing5"><table border="1"><tr><td>一级分类</td></tr><tr><td></td><td>二级分类</td></tr><tr><td></td><td>二级分类</td></tr><tr><td></td><td></td><td>三级分类</td></tr><tr><td>一级分类</td></tr></table></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="导入" />
          <input class="formbtn" type="button" onclick="history.go(-1)" value="返回" />        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 