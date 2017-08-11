<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});
    $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
 <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/utils.js'; ?>" charset="utf-8"></script>
<div id="rightTop">
  <h1><p><a href="index.php?act=welcome" style="text-decoration:none;"><?php echo $this->_var['setting']['site_name']; ?></a> &nbsp;>&nbsp;资金走势&nbsp;&nbsp;>&nbsp;&nbsp; 资金走势</p></h1>
</div>
<div class="mrightTop">
    <div class="fontl">
        <form method="get">
             <div class="left">
                <input type="hidden" name="app" value="flow_stats" />
                <input type="hidden" name="act" value="index" />
           	   
               开始时间:
                <input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_from']; ?>" id="add_time_from" name="add_time_from" class="pick_date" />
                结束时间:<input class="queryInput2" type="text" value="<?php echo $this->_var['query']['add_time_to']; ?>" id="add_time_to" name="add_time_to" class="pick_date" />
                
                <input type="submit" class="formbtn" value="查询" />
            </div>
            <?php if ($this->_var['filtered']): ?>
            <a class="left formbtn1" href="index.php?app=flow_stats">撤销检索</a>
            <?php endif; ?>
        </form>
    </div>
</div>
<div class="tab-div">
 <div id="tabbar-div">
    <p>
        <span class="tab-front" id="general-tab">综合访问量</span><span
      
    </p>
 </div>
<div id="tabbody-div">
        
        <table width="90%" id="general-table">
          <tr><td align="center">
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
              codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0"
              width="565" height="420" id="FCColumn2" align="middle">
              <PARAM NAME="FlashVars" value="&dataXML=<?php echo $this->_var['general_data']; ?>">
              <PARAM NAME=movie VALUE="templates/images/charts/line.swf?chartWidth=650&chartHeight=400">
              <param NAME="quality" VALUE="high">
              <param NAME="bgcolor" VALUE="#FFFFFF">
              <param NAME="wmode" VALUE="opaque">
              <embed src="templates/images/charts/line.swf?chartWidth=650&chartHeight=400" FlashVars="&dataXML=<?php echo $this->_var['general_data']; ?>" quality="high" bgcolor="#FFFFFF"  width="650" height="400" name="FCColumn2" wmode="opaque" align="middle" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">
            </object>

          </td></tr>
        </table>
        

       

       
 </div>
 </div>
 <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'js/tab.js'; ?>" charset="utf-8"></script>
<?php echo $this->fetch('footer.html'); ?>
