<?php echo $this->fetch('header.html'); ?>
<style type="text/css">
.store_reply {padding:5px 0px; color:green;}
</style>
<div id="rightTop">
  <p>咨询管理</p>
    <ul class="subnav">
    <li><span>管理</span></li>
  </ul>
</div>


<div class="mrightTop">
  <div class="fontl">
    <form method="get">
      <div class="left">
          <input type="hidden" name="app" value="consulting" />
          咨询人:
          <input class="queryInput" type="text" name="asker" value="<?php echo htmlspecialchars($this->_var['query']['asker']); ?>" />
          咨询内容:
          <input class="queryInput" type="text" name="content" value="<?php echo htmlspecialchars($this->_var['query']['content']); ?>" />
          <input type="submit" class="formbtn" value="查询" />
      </div>
      <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=consulting">撤销检索</a>
     <?php endif; ?>
    </form>
    </div>
  <div class="fontr"><?php echo $this->fetch('page.top.html'); ?></div>
</div>
<div class="tdare">

  <form method=get>
  <table width="100%" cellspacing="0" class="dataTable">
    <?php if ($this->_var['list_data']): ?>
    <tr class="tatr1">
      <td width="20" class="firstCell"><input type="checkbox" class="checkall" /></td>
      <td width="80">咨询人</td>
      <td width="15%">咨询对象</td>
      <td>咨询内容</td>
      <td width="100">店铺名称</td>
      <td width="120" style="text-align:center;">咨询时间</td>
      <td style="width:80px;" class="handler">操作</td>
    </tr>

    <?php endif; ?>
    <?php $_from = $this->_var['list_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'data');if (count($_from)):
    foreach ($_from AS $this->_var['data']):
?>
    <tr class="tatr2">
        <td class="firstCell"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['data']['ques_id']; ?>" /></td>
        <td><?php if ($this->_var['data']['user_name'] == ''): ?> 游客<?php else: ?><?php echo htmlspecialchars($this->_var['data']['user_name']); ?><?php endif; ?></td>
        <td>[<?php echo $this->_var['lang'][$this->_var['data']['type']]; ?>]&nbsp;<a target="_blank" href="<?php echo $this->_var['site_url']; ?>/index.php?app=<?php echo $this->_var['data']['type']; ?>&amp;id=<?php echo $this->_var['data']['item_id']; ?>"><?php echo htmlspecialchars($this->_var['data']['item_name']); ?></a></td>
        <td><?php echo htmlspecialchars($this->_var['data']['question_content']); ?>
        <?php if ($this->_var['data']['reply_content']): ?><div class="store_reply">店主回复&nbsp;:&nbsp;<?php echo htmlspecialchars($this->_var['data']['reply_content']); ?></div><?php endif; ?></td>
        <td><a target="_blank" href="<?php echo $this->_var['site_url']; ?>/index.php?app=store&id=<?php echo $this->_var['data']['store_id']; ?>"><?php echo $this->_var['data']['store_name']; ?></a></td>
        <td><?php echo local_date("Y-m-d H:i:s",$this->_var['data']['time_post']); ?></td>
        <td style="width:80px;" class="handler"><a href="javascript:drop_confirm('您确定要删除这些商品咨询吗？','index.php?app=consulting&amp;act=delete&amp;id=<?php echo $this->_var['data']['ques_id']; ?>');" >删除</a></td>
    </tr>

    <?php endforeach; else: ?>
    <tr class="no_data">
      <td colspan="7">没有符合条件的记录</td>
    </tr>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
    </table>

    <div id="dataFuncs">
        <div class="pageLinks"><?php echo $this->fetch('page.bottom.html'); ?></div>
        <?php if ($this->_var['list_data']): ?><div id="dataFuncs">
            <div id="batchAction" class="left paddingT15"> &nbsp;&nbsp;
            <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=consulting&act=delete" presubmit="confirm('您确定要删除这些商品咨询吗？');" />
            </div>
        </div><?php endif; ?>
    </div>
    <div class="clear"></div>
  </div>
 </form>
</div>
<?php echo $this->fetch('footer.html'); ?>