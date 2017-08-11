// JavaScript Document
$(function(){
	//二级下拉菜单
	$(".menu").click(function(){
		$(".sub_menu").slideToggle();
		})
	//显示（关闭）二维码等店铺信息
	$(".code").click(function(){
		$(".shop_info").show().animate({left:0});
		})
	$(".shop_info .back").click(function(){
		$(".shop_info").animate({left:"100%"});
		})
	//加入收藏
	/*$(".fav").click(function(){
		$(".fav_msg").fadeIn(1000).delay(3000).fadeOut(1000);
		})*/
	})