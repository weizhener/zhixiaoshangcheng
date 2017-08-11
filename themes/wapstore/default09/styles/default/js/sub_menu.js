// JavaScript Document
	
$(function(){
	//下拉菜单
	$(".menu").click(function(){
		$(".sub_menu_bg").animate({'left':0});
		})
	$(".shrink").click(function(){
		$(".sub_menu_bg").animate({'left':-275});
		})
	//二级菜单
	$(".sub_menu li").click(function(){
		$(this).children(".sub_menu_list").slideToggle();
	}); 
	//搜索框
	$(".search").click(function(){
		$(".searchBar").slideToggle();
	}); 
	//加入收藏
	$(".fav").click(function(){
		$(".fav_msg").fadeIn(1000).delay(3000).fadeOut(1000);
		})
	//返回顶部	
	$(function(){
		$('.top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);});
		})
	})

