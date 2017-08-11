<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>

<div id="rightTop">
  <h1><p><a href="index.php?act=welcome" style="text-decoration:none;"><?php echo $this->_var['setting']['site_name']; ?></a> &nbsp;>&nbsp;报表统计&nbsp;&nbsp;>&nbsp;&nbsp; 订单统计</p></h1>
</div>
<div class="main-div">
  <p style="margin: 10px">
    <strong>有效订单总金额</strong>:&nbsp;&nbsp;<?php echo $this->_var['total_turnover']; ?>&nbsp;&nbsp;&nbsp;
    <strong>总点击数</strong>:&nbsp;&nbsp;<?php echo $this->_var['click_count']; ?>&nbsp;&nbsp;&nbsp;
    <strong>每千点击订单数</strong>:&nbsp;&nbsp;<?php echo $this->_var['click_ordernum']; ?>&nbsp;&nbsp;&nbsp;
    <strong> 每千点击购物额</strong>:&nbsp;&nbsp;<?php echo $this->_var['click_turnover']; ?>
  </p>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get" name="search_form">
             <div class="left">
                <input type="hidden" name="app" value="order_stats" />
                <input type="hidden" name="act" value="index" />
           	   
               开始时间:
                <input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
                结束时间:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />

				 <a href="JavaScript:void(0);" class="btn-search" onclick="document.search_form.submit()">查询</a>
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=order_stats">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
</div>
<div class="tab-div">
 <div id="tabbar-div">
    <p>
      <span class="tab-front" id="order_circs-tab">订单概况</span><span
      class="tab-back" id="shipping-tab">配送方式</span><span
      class="tab-back" id="pay-tab">支付方式</span>
    </p>
 </div>
<div id="tabbody-div">
    <table width="90%" cellspacing="0" cellpadding="3" id="order_circs-table">
      <tr>
        <td align="center">
        <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="650" HEIGHT="400" id="OrderGeneral" ALIGN="middle">
          <PARAM NAME="FlashVars" value="&dataXML=<?php echo $this->_var['order_general_xml']; ?>">
          <PARAM NAME="movie" VALUE="templates/images/charts/pie3d.swf?chartWidth=650&chartHeight=400">
          <PARAM NAME="quality" VALUE="high">
          <PARAM NAME=bgcolor VALUE="#FFFFFF">
          <param name="wmode" value="opaque" />
          <EMBED src="templates/images/charts/pie3d.swf?chartWidth=650&chartHeight=400" FlashVars="&dataXML=<?php echo $this->_var['order_general_xml']; ?>" quality="high" bgcolor="#FFFFFF" WIDTH="650" HEIGHT="400" wmode="opaque" NAME="OrderGeneral" ALIGN="middle" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
          </OBJECT>
        </td>
      </tr>
    </table>
	    <table width="90%" cellspacing="0" cellpadding="3" id="shipping-table" style="display:none">
      <tr>
        <td align="center">
          <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="650" HEIGHT="400" id="ShipType" ALIGN="middle">
          <PARAM NAME="FlashVars" value="&dataXML=<?php echo $this->_var['ship_xml']; ?>">
          <PARAM NAME="movie" VALUE="templates/images/charts/pie3d.swf?chartWidth=650&chartHeight=400">
          <PARAM NAME="quality" VALUE="high">
          <param name="wmode" value="opaque" />
          <PARAM NAME="bgcolor" VALUE="#FFFFFF">
          <EMBED src="templates/images/charts/pie3d.swf?chartWidth=650&chartHeight=400" FlashVars="&dataXML=<?php echo $this->_var['ship_xml']; ?>" quality="high" bgcolor="#FFFFFF" WIDTH="650" HEIGHT="400" NAME="ShipType" ALIGN="middle" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer" wmode="opaque"></EMBED>
          </OBJECT>
        </td>
      </tr>
    </table>
    <table width="90%" cellspacing="0" cellpadding="3" id="pay-table" style="display:none">
      <tr>
        <td align="center">
          <OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"  codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" WIDTH="650" HEIGHT="400" id="PayMethod" ALIGN="middle">
          <PARAM NAME="FlashVars" value="&dataXML=<?php echo $this->_var['pay_xml']; ?>">
          <PARAM NAME="movie" VALUE="templates/images/charts/pie3d.swf?chartWidth=650&chartHeight=400">
          <PARAM NAME="quality" VALUE="high">
          <PARAM NAME="bgcolor" VALUE="#FFFFFF">
          <param name="wmode" value="opaque" />
          <EMBED src="templates/images/charts/pie3d.swf?chartWidth=650&chartHeight=400" FlashVars="&dataXML=<?php echo $this->_var['pay_xml']; ?>" quality="high" bgcolor="#FFFFFF" WIDTH="650" HEIGHT="400" NAME="PayMethod" wmode="opaque" ALIGN="middle" TYPE="application/x-shockwave-flash" PLUGINSPAGE="http://www.macromedia.com/go/getflashplayer"></EMBED>
        </OBJECT>
        </td>
      </tr>
    </table>
 </div>
 </div>
 <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/tab.js'; ?>" charset="utf-8"></script>
<?php echo $this->fetch('footer.html'); ?>
