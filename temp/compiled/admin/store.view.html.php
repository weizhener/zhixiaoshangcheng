<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
//<!CDATA[
$(function(){
    $("#reject").click(function(){
        var reason = $.trim($("#reject_reason").val());
        if (reason == '')
        {
            alert('请输入拒绝原因');
            return false;
        }
        return true;
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
        <th class="paddingT15">店主姓名:</th>
        <td class="paddingT15 wordSpacing5"><?php echo htmlspecialchars($this->_var['store']['owner_name']); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">店主身份证号:</th>
        <td class="paddingT15 wordSpacing5"><?php echo htmlspecialchars($this->_var['store']['owner_card']); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">店铺名称:</th>
        <td class="paddingT15 wordSpacing5"><?php echo htmlspecialchars($this->_var['store']['store_name']); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">所属分类:</th>
        <td class="paddingT15 wordSpacing5" ><?php $_from = $this->_var['scates']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'cate');if (count($_from)):
    foreach ($_from AS $this->_var['cate']):
?><?php echo htmlspecialchars($this->_var['cate']['cate_name']); ?>&nbsp;<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?></td>
      </tr>
      <tr>
        <th class="paddingT15">所在地:</th>
        <td class="paddingT15 wordSpacing5" ><?php echo htmlspecialchars($this->_var['store']['region_name']); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">详细地址:</th>
        <td class="paddingT15 wordSpacing5"><?php echo htmlspecialchars($this->_var['store']['address']); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">邮政编码:</th>
        <td class="paddingT15 wordSpacing5"><?php echo htmlspecialchars($this->_var['store']['zipcode']); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">联系电话:</th>
        <td class="paddingT15 wordSpacing5"><?php echo htmlspecialchars($this->_var['store']['tel']); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">所属等级:</th>
        <td class="paddingT15 wordSpacing5"><?php echo $this->_var['store']['sgrade']; ?></td>
      </tr>
      <tr>
          <th class="paddingT15">申请说明:</th>
          <td class="paddingT15 wordSpacing5"><?php echo nl2br(htmlspecialchars($this->_var['store']['apply_remark'])); ?></td>
      </tr>
      <tr>
        <th class="paddingT15">上传的图片:</th>
        <td class="paddingT15 wordSpacing5">
          <?php if ($this->_var['store']['image_1']): ?><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_1']; ?>" target="_blank">查看</a><?php endif; ?>
          <?php if ($this->_var['store']['image_2']): ?><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_2']; ?>" target="_blank">查看</a><?php endif; ?>
          <?php if ($this->_var['store']['image_3']): ?><a href="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['store']['image_3']; ?>" target="_blank">查看</a><?php endif; ?>        </td>
      </tr>
      <tr>
        <th class="paddingT15" valign="top">拒绝原因:</th>
        <td class="paddingT15 wordSpacing5">
        <textarea name="reject_reason" cols="60" rows="4" id="reject_reason"></textarea></td>
      </tr>
      <tr>
        <th></th>
        <td class="ptb20"><input class="formbtn" type="submit" name="agree" id="agree" value="同意" />
          <input class="formbtn" type="submit" name="reject" id="reject" value="拒绝" /></td>
      </tr>
    </table>
  </form>
</div>
<?php echo $this->fetch('footer.html'); ?> 