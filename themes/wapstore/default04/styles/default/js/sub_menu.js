// JavaScript Document
	
$(function(){
	//二级下拉菜单
	$(".menu").click(function(){
		$(".sub_menu").slideToggle();
		})
			//二级菜单
	$(".sub_menu li").click(function(){
		$(this).children(".sub_menu_list").slideToggle();
	}); 
	//显示（关闭）二维码等店铺信息
	$(".code").click(function(){
		$(".shop_info").show().animate({left:0});
		})
	$(".shop_info .back").click(function(){
		$(".shop_info").animate({left:"100%"});
		})
	})

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



	$(function(){
		public_search();
	});	
	
	$(window).resize(function(){
		public_search();
	});
	function public_search(){
		var zw = $('.logo').css('width');
		zw = zw.substring(0,zw.length-2);
		
		var w = document.documentElement.clientWidth-zw;
		
		$('.searchBar').css({'width':w+'px'});
		var h = document.body.clientHeight-40;
		$('.sub_menu').css({'height':h});
	}
//返回顶部	
$(function(){
	$('.top').click(function(){$('html,body').animate({scrollTop: '0px'}, 800);});
	})
	