<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

        <meta name="apple-mobile-web-app-capable" content="yes"/>

        <meta name="apple-touch-fullscreen" content="yes"/>

        <meta name="apple-mobile-web-app-status-bar-style" content="black"/>

        <title>附近商家</title>

        <meta name="copyright" content="<?php echo $this->_var['ecmall_version']; ?>" />

        <link href="<?php echo $this->res_base . "/" . 'css/global.css'; ?>" type="text/css" rel="stylesheet" />

        <link href="<?php echo $this->res_base . "/" . 'css/main.css'; ?>" type="text/css" rel="stylesheet" /><br />

<link href="<?php echo $this->res_base . "/" . 'css/company.css'; ?>" type="text/css" rel="stylesheet" />

        <script type="text/javascript" src="index.php?act=jslang"></script>

        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>

        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>
		
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.4"></script>
<script type="text/javascript" src="http://developer.baidu.com/map/jsdemo/demo/convertor.js"></script>
		

        <?php echo $this->_var['_head_tags']; ?>

        <script type="text/javascript">

            //<!CDATA[

            var SITE_URL = "<?php echo $this->_var['site_url']; ?>";

            var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";

            var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';

            //]]>
var latlonx=getCookie('latlonx'),latlony=getCookie('latlony');
var lat,lng;
var _limit = 0;
var __limit = 0;
	$(function(){
	
	  getLocation(); 
  $(window).scroll(function(){ 
	var limit = parseInt($("#limit").val());
    var srollPos = $(window).scrollTop();    //滚动条距顶部距离(页面超出窗口的高度)
    var windowHeight = $(window).height(); //窗口的高度
    var dbHiht = $("body").height(); //整个页面文件的高度
    if((windowHeight + srollPos) >= (dbHiht)&&__limit<=limit){
	  __limit += _limit;
      reloading();	
    }
  }); 					   
  var allheight = $(window).height();
  var oneheight = parseInt($(".newList").height());
  _limit = parseInt(allheight/oneheight);
  __limit += _limit;
  $("#limit").val("0");					   
  if(latlonx==''||latlony==''){
     //Toast('定位出错');
  }else{
     reloading();
  }
	  
      $("#dingwei").click(function(){
	     $("#listdz").html('');
   	     $(".reloading").hide();
	     getLocation(); 	 
      });
	
	})
	  function getLocation(){
       $("#dwload").html('正在获取您的位置.....');
        var location = window.yutebi.getloc().split(",");
        latlonx = location[0];
        latlony = location[1];
        setCookie('latlonx',latlonx);
        setCookie('latlony',latlony);
        reloading();
      }
	  
function reloading(){
  address();
}
	  
	  
function address(){
    var latlonx=getCookie('latlonx');
	var latlony=getCookie('latlony');

	
	
    BMap.Convertor.translate(new BMap.Point(latlony,latlonx),0,function(point){		
      var myGeo = new BMap.Geocoder(); 
      myGeo.getLocation(new BMap.Point(point.lng,point.lat), function(result){  
        if (result){      
	      $("#dwload").html(result.address);   
        }  
      })
      limit = parseInt($("#limit").val());
      if(limit>=0){
        $(".reloading").addClass('showloading').html('').show();
        $.getJSON('index.php?app=company&act=show&limit='+limit+'&_limit='+_limit,function(res){		
          if(res.length==0){
	        if(limit==0){
	          $(".newList_view").html('<div class="tips_view mitu_01"><div class="tips_msg"><h3>附近没有商家</h3><p>请选择其他查看</p></div></div>');
	        }
	      }else{																												  
	        for(var i=0;i<res.length;i++){
	          var html = '<div class="newList">';
	          html += '<div class="imgurl"><a href="index.php?app=store&id='+res[i]['store_id']+'"><img src="'+res[i]['store_logo']+'"></a></div>';
	          html += '<div class="content">';
	          html += '<div class="name"><a href="index.php?app=store&id='+res[i]['store_id']+'">'+res[i]['store_name']+'</a></div>';
	          html += '<div class="price"><img src="'+res[i]['credit_image']+'"></div><div class="juli">营业地址：'+res[i]['region_name']+'</div></div></div>';
              $('#companylist').append(html);
  	        }
	        if(res.length<_limit){   
	           $("#limit").val(-1); 
	           $(".reloading").removeClass('showloading').html("数据已经加载完毕");
	        }else{
               $(".reloading").hide();
	           $("#limit").val(limit+_limit); 
	        }
	      }																																		  
        }); 
      }	  										   
    });  
}

function setCookie(name, value) {
var argv = setCookie.arguments;
var argc = setCookie.arguments.length;
var expires = (argc > 2) ? argv[2] : null;
if (expires != null) {
   var LargeExpDate = new Date ();
   LargeExpDate.setTime(LargeExpDate.getTime() + (expires*1000*3600*24));
}
document.cookie = name + "=" + escape (value)+((expires == null) ? "" : ("; expires=" +LargeExpDate.toGMTString()));
}
function getCookie(Name) {
var search = Name + "="
if (document.cookie.length > 0) {
   offset = document.cookie.indexOf(search);
   if(offset != -1) {
    offset += search.length;
    end = document.cookie.indexOf(";", offset);
    if(end == -1) end = document.cookie.length;
    return unescape(document.cookie.substring(offset, end));
   }else {
    return '';
   }
}
}
	  

        </script>

    </head>

<body>
    <header class="index-header" style="width:100%; height:43px; margin:0; padding:0; background:none;">

<div class="mb-head" style="width:100%; height:43px;"><div class="tit">附近商家</div></div>
    </header>

<div class="viewport" style="padding-top:3em;">
  <div id="companylist">
    <div class="newList" style="display:none;">
      <div class="imgurl"><a href="#"><img  src="#"></a></div>
      <div class="content">
        <div class="name"><a href="?mod=mobile&act=companyshow&id='+res[i]['id']+'">#</a></div>
        <div class="price">主营业务：#</div>
        <div class="juli">营业地址：{self company['address']}</div>
      </div>
    </div>
  </div>
  <div class="newList_view" style="margin-bottom:3em;">
    <div class="reloading"></div>
    <input id="limit" name="limit" type="hidden" value="0">
  </div>
</div>
<div class="dwload"><span id="dingwei">定</span>
  <div id="dwload"></div>
</div>
</body>
</html>