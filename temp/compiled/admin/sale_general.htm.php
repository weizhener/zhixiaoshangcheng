<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>

<div id="rightTop">
  <h1><p><a href="index.php?act=welcome" style="text-decoration:none;"><?php echo $this->_var['setting']['site_name']; ?></a> &nbsp;>&nbsp;报表统计&nbsp;&nbsp;>&nbsp;&nbsp; 销售概况</p></h1>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
          <div class="left">
                <input type="hidden" name="app" value="sale_general" />
                <input type="hidden" name="act" value="index" />
               开始日期:
                <input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
                结束日期:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />
                
             <input name="submit" type="submit" class="formbtn" value="查询" />
          </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=sale_general">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
</div>
<div class="tab-div">
   <div id="tabbar-div">
      <p>
        <span class="tab-front" id="order-tab">订单走势</span><span
        class="tab-back" id="turnover-tab">销售额走势</span>
      </p>
   </div>
   <div id="tabbody-div">
      
      <table width="90%" id="order-table">
        <tr><td align="center">
          <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
            width="565" height="420" id="FCColumn2" align="middle">
            <param NAME="movie" VALUE="templates/images/charts/column3d.swf?dataXML=<?php echo $this->_var['data_count']; ?>">
            <param NAME="quality" VALUE="high">
            <param NAME="bgcolor" VALUE="#FFFFFF">
            <embed src="templates/images/charts/column3d.swf?dataXML=<?php echo $this->_var['data_count']; ?>" quality="high" bgcolor="#FFFFFF"  width="565" height="420" name="FCColumn2" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
          </object>
          <div><?php echo $this->_var['data_count_name']; ?></div>
        </td></tr>
      </table>

      
      <table width="90%" id="turnover-table" style="display:none">
        <tr><td align="center">
          <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
            codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
            width="565" height="420" id="FCColumn2" align="middle">
            <param NAME="movie" VALUE="templates/images/charts/column3d.swf?dataXML=<?php echo $this->_var['data_amount']; ?>">
            <param NAME="quality" VALUE="high">
            <param NAME="bgcolor" VALUE="#FFFFFF">
            <embed src="templates/images/charts/column3d.swf?dataXML=<?php echo $this->_var['data_amount']; ?>" quality="high" bgcolor="#FFFFFF"  width="565" height="420" name="FCColumn2" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
          </object>
          <div><?php echo $this->_var['data_amount_name']; ?></div>
        </td></tr>
      </table>
    </div>
</div>
<script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/tab.js'; ?>" charset="utf-8"></script>
<?php echo $this->fetch('footer.html'); ?>
