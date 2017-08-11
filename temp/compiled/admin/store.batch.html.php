<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript" src="index.php?act=jslang"></script>
<script type="text/javascript">
//<!CDATA[
$(function(){
    regionInit("region");

    $(":radio[name='certification']").click(function(){
        $(".certification:checkbox").attr('disabled', this.value == 0);
    });
});
//]]>
</script>
<div id="rightTop">
  <p>店铺</p>
  <ul class="subnav">
    <li><a class="btn1" href="index.php?app=store">管理</a></li>
    <li><a class="btn1" href="index.php?app=store&amp;act=test">新增</a></li>
    <li><a class="btn1" href="index.php?app=store&amp;wait_verify=1">待审核</a></li>
  </ul>
</div>
<div class="info">
  <form method="post" enctype="multipart/form-data">
    <table class="infoTable">
      <tr>
        <th class="paddingT15"> 所在地:</th>
        <td class="paddingT15 wordSpacing5" ><div id="region">
            <input type="hidden" name="region_id" value="0" class="mls_id" />
            <input type="hidden" name="region_name" value="" class="mls_names" />
            <select>
              <option value="0">请选择...</option>
              <?php echo $this->html_options(array('options'=>$this->_var['regions'])); ?>
            </select>
            <span class="grey">不修改请不要选择</span> </div></td>
      </tr>
      <tr>
        <th class="paddingT15"> <label for="sgrade"> 所属等级: </label>
        </th>
        <td class="paddingT15 wordSpacing5"><select name="sgrade" id="sgrade">
            <option value="0">请选择...</option>
          <?php echo $this->html_options(array('options'=>$this->_var['sgrades'])); ?>
          </select>
          <span class="grey">不修改请不要选择</span> </td>
      </tr>
      <tr>
        <th class="paddingT15">认证:</th>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input name="certification" type="radio" value="0" checked="checked" />
            保持不变</label>
            <label>
            <input type="radio" name="certification" value="1" />
            改为</label> (
            <label for="autonym">
            <input name="autonym" type="checkbox" id="autonym" value="1" class="certification" disabled="disabled" />
            实名认证</label>
            <label for="material">
            <input type="checkbox" name="material" value="1" id="material" class="certification" disabled="disabled" />
            实体店铺认证</label> )
          </p></td>
      </tr>
      <tr>
        <th class="paddingT15">推荐:</th>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input name="recommended" type="radio" value="-1" checked="checked" />
            保持不变</label>
            <label>
            <input type="radio" name="recommended" value="1" />
            是</label>
            <label>
            <input type="radio" name="recommended" value="0" />
            否</label>
          </p></td>
      </tr>
      <tr>
        <th class="paddingT15">是否开启刷销量:</th>
        <td class="paddingT15 wordSpacing5"><p>
            <label>
            <input name="is_open_shua" type="radio" value="-1" checked="checked" />
            保持不变</label>
            <label>
            <input type="radio" name="is_open_shua" value="1" />
            开启</label>
            <label>
            <input type="radio" name="is_open_shua" value="0" />
            关闭</label>
          </p></td>
      </tr>
      <tr>
        <th class="paddingT15">排序:</th>
        <td class="paddingT15 wordSpacing5"><input name="sort_order" type="text" id="sort_order" />
          <span class="grey">不修改请留空</span></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" />
          <input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Reset" value="重置" /></td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 