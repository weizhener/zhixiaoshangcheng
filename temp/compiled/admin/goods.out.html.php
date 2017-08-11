<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
  <p>商品批量操作</p>
  <ul class="subnav">
  </ul>
</div>
<div class="info">
  <form method="post">
    <table class="infoTable">
      
      <tr>
        <th class="paddingT15">拒绝:</th>
        <td class="paddingT15 wordSpacing5">
            <textarea name="godds_log">
            
            </textarea>
            
        </td>
      </tr>
     
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