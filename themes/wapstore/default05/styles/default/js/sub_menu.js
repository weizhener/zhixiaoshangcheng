// JavaScript Document


//底部导航
$(function(){
	$(".bottom_nav_btn").click(function(){
		if($(".footer_nav .nav").height()==40){
			$(".footer_nav .nav").animate({"height":"0"},500);
		}else{
			$(".footer_nav .nav").animate({"height":"40"},500);
		}
	}); 
})




//返回顶部	
$(function(){
	$('.top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);});
	})
	