// JavaScript Document
$(function(){
	//下拉菜单
	$(".menu").click(function(){
		$(".sub_menu").fadeToggle();
		})
	//二级菜单
	$(".sub_menu li").click(function(){
		$(this).children(".sub_menu_list").slideToggle();
		$(this).children("h2").toggleClass("cur");
	}); 
	//显示（关闭）二维码等店铺信息
	$(".code").click(function(){
		$(".shop_info").show().animate({left:0});
		})
	$(".shop_info .back").click(function(){
		$(".shop_info").animate({left:"100%"});
		})
	//加入收藏
	$(".fav").click(function(){
//		$(".fav_msg").fadeIn(1000).delay(3000).fadeOut(1000);
		})
	})
	