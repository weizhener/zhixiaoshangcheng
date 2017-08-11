<?php echo $this->fetch('header.html'); ?>
<script language="javascript" src="/img/rotate.js"></script>
<!--[if lte IE 6]>
<style type="text/css">
.ie6_width{width:800px; margin:0 auto; position:relative; z-index:99999; font-size:14px; font-family:"宋体"，arial}  
#ie6-warning{width:1200px; margin:0 auto; text-indent:14px; background:#FFf; position:absolute;top:0; left:0;line-height:35px; color:#333;padding:0 10px; border:2px solid #0066FF;text-align:center}  
#ie6-warning img{float:right; cursor:pointer; margin-top:10px;} 
#ie6-warning a{text-decoration:none; color:#ff0000;}  
</style>
<div class="ie6_width">
<div id="ie6-warning"> 
<img src="/themes/mall/default/styles/new/images/icox.gif"  width="15" height="13" onclick="closeme();" alt="关闭提示" />您使用的IE浏览器版本过低,安全性低,有可能出现无法登陆或重新登陆的问题,影响网页性能,为更好的浏览本页,建议您将浏览器升级到 <a href="http://www.microsoft.com/china/windows/internet-explorer/ie8howto.aspx" target="_blank">IE8</a> 或使用以下浏览器：<a href="http://www.firefox.com.cn/download/">Firefox</a> / <a href="http://www.google.cn/chrome">Chrome</a> 
</div>  
</div>
<script type="text/javascript">  
function closeme() 
{ 
   var div = document.getElementById("ie6-warning"); 
   div.style.display ="none"; 
} 
function position_fixed(el, eltop, elleft){  

// check if this is IE6  

if(!window.XMLHttpRequest)  

window.onscroll = function(){  

el.style.top = (document.documentElement.scrollTop + eltop)+"px";  

el.style.left = (document.documentElement.scrollLeft + elleft)+"px";  

}  

else el.style.position = "fixed";  

}  

position_fixed(document.getElementById("ie6-warning"),0, 0);  

</script>  

<![endif]-->


 
<link href="<?php echo $this->res_base . "/" . 'css/zp_index.css'; ?>" rel="stylesheet" type="text/css" />
<div class="yl_fgx_main">
  <div class="marg clearfix">
    <div class="yl_cj_left fl">
      <div class="yl_cj_cyrs">使用积分<em>2</em>即可参与大转盘抽奖，积分多多金币多多<br />你好，<?php echo $this->_var['member']['user_name']; ?>。当前账户积分余额：<em id="userintegral"><?php echo $this->_var['member']['integral']; ?></em></div>
      <div class="yl_cj_main">
<div class="waike">
  <div class="zp" id="zp">
    <div class="zhizhen" id="zhizhen">
	 <div class="kaishi"></div>
	</div>
  </div>
  <div class="ts" id="ts"></div>
</div>

	  </div>
    </div>
    <div class="yl_cj_right fl">
      <div class="yl_zjmd">
        <div class="yl_zjmd_m"> <strong>最新中奖动态</strong> <span><em>奖品</em><i>中奖用户</i><b>中奖时间</b></span>
          <div id="yl_demo" style="overflow:hidden;height:240px;width:286px;">
			
				<ul id="yl_demo1">
                 <?php $_from = $this->_var['zhongjiang_list']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('key', 'val');if (count($_from)):
    foreach ($_from AS $this->_var['key'] => $this->_var['val']):
?>
				 				  <li class="clearfix"><em><?php echo htmlspecialchars($this->_var['val']['title']); ?></em><i><?php echo htmlspecialchars($this->_var['val']['user_name']); ?></i><b><?php echo local_date("Y-m-d",$this->_var['val']['time']); ?></b></li>
                                   <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
				   
				  				 
				  				</ul>			
				 <ul id="yl_demo2"></ul>
          </div>
        </div>
      </div>
      <div class="yl_cj_hdgz"> <strong>活动规则说明</strong>
        <p>1. 每次抽奖需要消耗<em>2</em>积分，每天不限抽奖次数。</p>
        <p>2. 您可通过"抽奖记录"查询您的中奖信息。</p>
        <p>3.  以上抽奖规则最终解释权归智芸商城所有！</p>
      </div>
    </div>
  </div>
</div>
<script> 
var dian = 0;
$(function(){
	var rotateFunc = function(angle,text,money,zhuan){
		$('#zhizhen').stopRotate();
		$("#zhizhen").rotate({
			angle:0, 
			duration: 5000, 
			animateTo: parseInt(angle)+1440, //angle是图片上各奖项对应的角度，1440是我要让指针旋转4圈。所以最后的结束的角度就是这样子^^
			callback:function(){
				$("#ts").show().html(text);
				flashPriceValue("userintegral",money);
                setTimeout(function(){
				  $("#ts").hide();
				  dian = 0;
				},2000);
			}
		}); 
		$("#zp").rotate({
			angle:0, 
			duration:2000, 
			animateTo:zhuan, //angle是图片上各奖项对应的角度，1440是我要让指针旋转4圈。所以最后的结束的角度就是这样子^^
			callback:function(){}
		});
	};
	
	$("#zhizhen").rotate({ 
	   bind: 
		 { 
			click: function(){
			if(dian==1) return false;
			 if($("#ts").is(':visible')) return false;
			  dian = 1;
              $.getJSON("index.php?app=dazhuanpan&act=json",function(res){			  
			    if(res.error=='0'){
			      rotateFunc(res.jiaodu,res.tishi,res.money,res.yizhuan);		
				}else{
				  $("#ts").show().html(res.error);
                  setTimeout(function(){
				    $("#ts").hide();
					dian = 0;
				  },2000);
				}													 					  
              });
			}
		 } 
	   
	});
  //time_over();
  //window.setInterval('time_over()',6000);
});
function time_over(){
  $.getJSON("index.php?app=getuserinfo",function(res){																 
	flashPriceValue("userintegral",res.integral);							  
  });
}
function flashPriceValue(id, val)
{
	if($('#' + id).html()!=val){
	$('#' + id).animate({
		opacity:'0.2'
	  }, 'slow');
	  $('#' + id).html(val);
	$('#' + id).animate({
		opacity:'1'
	  }, 'slow');
	}
}

function flashValue(id, val)
{
	val = val > 0 ? val : '';
	$('#' + id).animate({
		opacity:'0.2'
	  }, 'slow');
	  $('#' + id).html(val);
	$('#' + id).animate({
		opacity:'1'
	  }, 'slow');
}
var speed=40 
var demo=document.getElementById("yl_demo"); 
var demo2=document.getElementById("yl_demo2"); 
var demo1=document.getElementById("yl_demo1"); 
demo2.innerHTML=demo1.innerHTML 
function Marquee(){ 
if(demo2.offsetHeight-demo.scrollTop<=0) 
  demo.scrollTop-=demo1.offsetHeight 
else{ 
  demo.scrollTop++ 
} 
} 
var MyMar=setInterval(Marquee,speed) 
demo.onmouseover=function() {clearInterval(MyMar)} 
demo.onmouseout=function() {MyMar=setInterval(Marquee,speed)} 
</script>
<?php echo $this->fetch('footer.html'); ?>