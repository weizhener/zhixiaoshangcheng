<?php



return array(

    'dashboard' => array(

        'text' => Lang::get('dashboard'),

        'subtext' => Lang::get('offen_used'),

        'default' => 'welcome',

        'children' => array(

            'welcome' => array(

                'text' => Lang::get('welcome_page'),

                'url' => 'index.php?act=welcome',

            ),

            /*'aboutus' => array(

                'text' => Lang::get('aboutus_page'),

                'url' => 'index.php?act=aboutus',

            ),*/

            'base_setting' => array(

                'parent' => 'setting',

                'text' => Lang::get('base_setting'),

                'url' => 'index.php?app=setting&act=base_setting',

            ),

            'user_manage' => array(

                'text' => Lang::get('user_manage'),

                'parent' => 'user',

                'url' => 'index.php?app=user',

            ),

            'store_manage' => array(

                'text' => Lang::get('store_manage'),

                'parent' => 'store',

                'url' => 'index.php?app=store',

            ),

            'goods_manage' => array(

                'text' => Lang::get('goods_manage'),

                'parent' => 'goods',

                'url' => 'index.php?app=goods',

            ),

            'order_manage' => array(

                'text' => Lang::get('order_manage'),

                'parent' => 'trade',

                'url' => 'index.php?app=order'

            ),

        ),

    ),

    // 设置

    'setting' => array(

        'text' => Lang::get('setting'),

        'default' => 'base_setting',

        'children' => array(

            'base_setting' => array(

                'text' => Lang::get('base_setting'),

                'url' => 'index.php?app=setting&act=base_setting',

            ),

            'region' => array(

                'text' => Lang::get('region'),

                'url' => 'index.php?app=region',

            ),

            'payment' => array(

                'text' => Lang::get('payment'),

                'url' => 'index.php?app=payment',

            ),

            'theme' => array(

                'text' => Lang::get('theme'),

                'url' => 'index.php?app=theme',

            ),

            'template' => array(

                'text' => Lang::get('template'),

                'url' => 'index.php?app=template',

            ),

            'mailtemplate' => array(

                'text' => Lang::get('noticetemplate'),

                'url' => 'index.php?app=mailtemplate',

            ),

            'my_weixin' => array(

                'text' => '微信接口配置',

                'url' => 'index.php?app=my_wxconfig',

            ),

        ),

    ),

    // 商品

    'goods' => array(

        'text' => Lang::get('goods'),

        'default' => 'goods_manage',

        'children' => array(

            'gcategory' => array(

                'text' => Lang::get('gcategory'),

                'url' => 'index.php?app=gcategory',

            ),

            'brand' => array(

                'text' => Lang::get('brand'),

                'url' => 'index.php?app=brand',

            ),

            'goods_manage' => array(

                'text' => Lang::get('goods_manage'),

                'url' => 'index.php?app=goods',

            ),

            'props_manage' => array(

                'text' => Lang::get('props_manage'),

                'url' => 'index.php?app=props',

            ),

            // end			

            'recommend_type' => array(

                'text' => LANG::get('recommend_type'),

                'url' => 'index.php?app=recommend'

            ),

            /*'mix' => array(

                'text' => LANG::get('mix'),

                'url' => 'index.php?app=mix'

            ),*/

        ),

    ),

	// 聚划算

    /*'ju' => array(

        'text' => Lang::get('ju'),

        'default' => 'jutemplate',

        'children' => array(

            'jutemplate' => array(

                'text' => Lang::get('ju_template'),

                'url' => 'index.php?app=jutemplate',

            ),

            'jucate' => array(

                'text' => Lang::get('ju_cate'),

                'url' => 'index.php?app=jucate',

            ),

            'jubrand' => array(

                'text' => Lang::get('ju_brand'),

                'url' => 'index.php?app=jubrand',

            ),

            'goods_verify' => array(

                'text' => Lang::get('goods_verify'),

                'url' => 'index.php?app=ju&amp;act=goods_list',

            ),

        ),

    ),*/

    // 店铺

    'store' => array(

        'text' => Lang::get('store'),

        'default' => 'store_manage',

        'children' => array(

            'sgrade' => array(

                'text' => Lang::get('sgrade'),

                'url' => 'index.php?app=sgrade',

            ),

            'scategory' => array(

                'text' => Lang::get('scategory'),

                'url' => 'index.php?app=scategory',

            ),

            //by cengnlaeng

            /*'ultimate_store' => array(

                'text' => Lang::get('ultimate_store'),

                'url' => 'index.php?app=ultimate_store',

            ),*/

            //end

            'store_manage' => array(

                'text' => Lang::get('store_manage'),

                'url' => 'index.php?app=store',

            ),

        ),

    ),

    // 会员

    'user' => array(

        'text' => Lang::get('user'),

        'default' => 'user_manage',

        'children' => array(

            'user_manage' => array(

                'text' => Lang::get('user_manage'),

                'url' => 'index.php?app=user',

            ),

			

			'daili' => array(

                'text' => '区域代理',

                'url' => 'index.php?app=user&act=daili',

            ),

			

			

            'admin_manage' => array(

                'text' => Lang::get('admin_manage'),

                'url' => 'index.php?app=admin',

            ),

         /*   'vip_manage' => array(

                'text' => Lang::get('vip_manage'),

                'url' => 'index.php?app=ugrade',

            ),*/

            'user_notice' => array(

                'text' => Lang::get('user_notice'),

                'url' => 'index.php?app=notice',

            ),

            'tuijian' => array(

                'text' => Lang::get('tuijian'),

                'url' => 'index.php?app=tuijian&act=setting',

            ),

        ),

    ),

    // 交易

    'trade' => array(

        'text' => Lang::get('trade'),

        'default' => 'order_manage',

        'children' => array(

            'order_manage' => array(

                'text' => Lang::get('order_manage'),

                'url' => 'index.php?app=order'

            ),

            'evaluation_manage' => array(

                'text'  => Lang::get('evaluation_manage'),

                'url'   => 'index.php?app=evaluation&act=get_evaluation_buyer'

            ),

            'epay' => array(

                'text' => Lang::get('epay'),

                'url' => 'index.php?app=epay',

            ),	    

	    'refund_manage' => array(

                'text' => Lang::get('refund_manage'),

                'url' => 'index.php?app=refund',

            ),

        ),

    ),

    // 网站

    'website' => array(

        'text' => Lang::get('website'),

        'default' => 'acategory',

        'children' => array(

            'acategory' => array(

                'text' => Lang::get('acategory'),

                'url' => 'index.php?app=acategory',

            ),

            'article' => array(

                'text' => Lang::get('article'),

                'url' => 'index.php?app=article',

            ),

         /*   'partner' => array(

                'text' => Lang::get('partner'),

                'url' => 'index.php?app=partner',

            ),*/

            'navigation' => array(

                'text' => Lang::get('navigation'),

                'url' => 'index.php?app=navigation',

            ),

            'db' => array(

                'text' => Lang::get('db'),

                'url' => 'index.php?app=db&amp;act=backup',

            ),

        /*    'groupbuy' => array(

                'text' => Lang::get('groupbuy'),

                'url' => 'index.php?app=groupbuy',

            ),*/

            'consulting' => array(

                'text' => LANG::get('consulting'),

                'url' => 'index.php?app=consulting',

            ),

           /* 'share_link' => array(

                'text' => LANG::get('share_link'),

                'url' => 'index.php?app=share',

            ),

            'supply_demand' => array(

                'text' => Lang::get('supply_demand'),

                'url' => 'index.php?app=supply_demand',

            ),*/

           /* 'msg' => array(

                'text' => Lang::get('msg'),

                'url' => 'index.php?app=msg',

            ),*/

            'customer_message' => array(

                'text' => LANG::get('customer_message'),

                'url' => 'index.php?app=customer_message',

            ),

         /*   'job' => array(

                'text' => Lang::get('job'),

                'url' => 'index.php?app=job',

            ),*/

          /*  'job_apply' => array(

                'text' => Lang::get('job_apply'),

                'url' => 'index.php?app=job_apply',

            ),*/

        ),

    ),

    // 手机版设置

	

	 'report_compile' => array(

        'text'      => Lang::get('统计'),

        'default'   => 'order_stats',

        'children'  => array(

		

		      'order_stats' => array(

                'text' => Lang::get('流量分析'),

                'url'  => 'index.php?app=flow_stats',

            ),

			

			  'statistics' => array(

                'text' => Lang::get('店铺排行榜'),

                'url'  => 'index.php?app=statistics',

            ),

		

		

		    '订单统计' => array(

                'text' => Lang::get('订单统计'),

                'url'  => 'index.php?app=order_stats',

            ),

	    	    '销售概况' => array(

                'text' => Lang::get('销售概况'),

                'url'  => 'index.php?app=sale_general&act=index',

            ),



	    '客户统计' => array(

                'text' => Lang::get('客户统计'),

                'url'  => 'index.php?app=user&act=user_list',

            ),

	    '会员排行' => array(

                'text' => Lang::get('会员排行'),

                'url'  => 'index.php?app=user_order&act=index',

            ),

			

		 '资金走势' => array(

                'text' => Lang::get('资金走势'),

                'url'  => 'index.php?app=moeny_log&act=index',

            ),	

	   /* '销售明细' => array(

                'text' => Lang::get('销售明细'),

                'url'  => 'index.php?app=sale_list',

            ),

	    '销售排行' => array(

                'text' => Lang::get('销售排行'),

                'url'  => 'index.php?app=sale_order',

            ),*/



	            ),

        ),

	

	

	    'wap_setting' => array(

        'text' => Lang::get('wap_setting'),

        'default' => 'wap_setting',

        'children' => array(

            'wap_setting' => array(

                'text' => Lang::get('wap_setting'),

                'url' => 'index.php?app=wap_setting',

            ),

            'ad' => array(

                'text' => Lang::get('ad'),

                'url' => 'index.php?app=ad',

            ),

            'waptheme' => array(

                'text' => Lang::get('waptheme'),

                'url' => 'index.php?app=waptheme',

            ),

        ),

    ),

	

    'wap_setting' => array(

        'text' => Lang::get('wap_setting'),

        'default' => 'wap_setting',

        'children' => array(

            'wap_setting' => array(

                'text' => Lang::get('wap_setting'),

                'url' => 'index.php?app=wap_setting',

            ),

            'ad' => array(

                'text' => Lang::get('ad'),

                'url' => 'index.php?app=ad',

            ),

            'waptheme' => array(

                'text' => Lang::get('waptheme'),

                'url' => 'index.php?app=waptheme',

            ),

        ),

    ),

    // 后台积分相关

    'integral_manage' => array(

        'text'      => Lang::get('integral_manage'),

        'default'   => 'integral_log',

        'children'  => array(

            'integral_log' => array(

                'text'  => Lang::get('integral_log'),

                'url'   => 'index.php?app=integral_log',

            ),

            'egg_setting' => array(

                'text'  => Lang::get('egg_setting'),

                'url'   => 'index.php?app=egg',

            ),

            'eggpresent_setting' => array(

                'text'  => Lang::get('eggpresent_setting'),

                'url'   => 'index.php?app=eggpresent',

            ),

            'eggpresentrec_setting' => array(

                'text'  => Lang::get('eggpresentrec_setting'),

                'url'   => 'index.php?app=eggpresentrec',

            ),

            'integral_goods' => array(

                'text'  => Lang::get('integral_goods'),

                'url'   => 'index.php?app=integral_goods',

            ),

            'integral_goods_log' => array(

                'text'  => Lang::get('integral_goods_log'),

                'url'   => 'index.php?app=integral_goods_log',

            ),

        ),

    ),

    // 扩展

    'extend' => array(

        'text' => Lang::get('extend'),

        'default' => 'plugin',

        'children' => array(

            'plugin' => array(

                'text' => Lang::get('plugin'),

                'url' => 'index.php?app=plugin',

            ),

            'module' => array(

                'text' => Lang::get('module'),

                'url' => 'index.php?app=module&act=manage',

            ),

            'widget' => array(

                'text' => Lang::get('widget'),

                'url' => 'index.php?app=widget',

            ),

        ),

    ),

);

?>

