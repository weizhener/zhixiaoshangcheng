<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>导出数据</p>
  <ul class="subnav">
  </ul>
</div>
<div class="info">
  <form method="post">
    <table class="infoTable">
      <tr>
        <td class="paddingT15 wordSpacing5" width="40"></td>
        <td class="paddingT15 wordSpacing5"><?php echo $this->_var['note_for_export']; ?></td>
      </tr>
      <tr>
        <td class="paddingT15 wordSpacing5" width="40"></td>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input type="radio" name="if_convert" value="1" checked="checked" />
            是</label>
            <label>
            <input type="radio" name="if_convert" value="0" />
            否</label>
          </p><br />
          <span class="grey">如果您导出的文件需要用 excel 打开，请选择“是”，否则打开时可能显示乱码；如果您导出的文件只是为导入使用，建议不要转换，这样可以节省转换编码的时间。</span></td>
      </tr>
      <tr>
        <td class="ptb20" width="40"></td>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="导出" />
          <input class="formbtn" type="button" onclick="history.go(-1)" value="返回" />
        </td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 