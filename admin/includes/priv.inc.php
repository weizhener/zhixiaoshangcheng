<?php



/**

 * 网站后台管理左侧菜单数据

 */



if (!defined('IN_ECM'))

{

    trigger_error('Hacking attempt', E_USER_ERROR);

}



$menu_data = array

(

    'mall_setting' => array

    (

        'default'     => 'default|all',//后台登录

        'setting'     => 'setting|all',//网站设置

        'region'       => 'region|all',//地区设置

        'payment'    => 'payment|all',//支付方式

        'theme'     => 'theme|all',//主题设置

        'mailtemplate'   => 'mailtemplate|all',//邮件模板

        'template'  => 'template|all',//模板编辑

    ),

    'goods_admin' => array

    (

        'gcategory'    => 'gcategory|all',//分类管理

        'brand' => 'brand|all',//品牌管理

        'goods'    => 'goods|all',//商品管理

        'recommend'    => 'recommend|all',//推荐类型

        'props'=>'props|all',//属性管理

        'mix'=>'mix|all',//自由搭配

    ),

    'ju' => array

    (

        'ju_template'    => 'jutemplate|all',//活动管理

        'ju_cate'    => 'jucate|all',//分类管理

        'ju_brand'    => 'jubrand|all',//品牌团

        'ju'    => 'ju|all',//商品审核

    ),

    'store_admin' => array

    (

        'sgrade'    => 'sgrade|all',//店铺等级

        'scategory'     => 'scategory|all',//店铺分类

        'store'   => 'store|all',//店铺管理

        'ultimate_store'   => 'ultimate_store|all',//旗舰店管理

    ),

    'member' => array

    (

        'user'  => 'user|all',//会员管理

        'admin' => 'admin|all',//管理员管理

        'notice' => 'notice|all',//会员通知

        'ugrade' => 'ugrade|all',//会员等级

        'tuijian' => 'tuijian|all',//推荐

    ),

    'order' => array

    (

        'order'   => 'order|all',//订单管理

        'epay'  => 'epay|all', //退款管理

        'refund'  => 'refund|all', //退款管理

        'evaluation_manage'=>'evaluation|all',//评价管理

    ),

    'website' => array

    (

        'acategory'    => 'acategory|all',//文章分类

        'article'      => array('article' => 'article|all', 'upload' => array('comupload' => 'comupload|all', 'swfupload' => 'swfupload|all')),//文章管理

        'partner'      => 'partner|all',//合作伙伴

        'navigation'   => 'navigation|all',//页面导航

        'db'           => 'db|all',//数据库

        'groupbuy'     => 'groupbuy|all',//团购

        'consulting'   => 'consulting|all',//咨询

        'share_link'   => 'share|all',//分享管理

        'supply_demand'=> 'supply_demand|all',

        'msg'=> 'msg|all',//短信管理

        'customer_message'=> 'customer_message|all',//投诉及建议

        'job'=> 'job|all',//招贤纳士

        'job_apply'=> 'job_apply|all',//在线应聘

    ),

    'wap_setting' => array

    (

        'wap_setting' => 'wap_setting|all',//手机版设置

        'ad'   => 'ad|all',//素材管理

        'waptheme'   => 'waptheme|all',//手机主题设置

    ),

    'integral_manage' => array

    (

        'integral_log' => 'integral_log|all',//积分记录

        'egg_setting'   => 'egg|all',//砸蛋设置

        'eggpresent_setting'   => 'eggpresent|all',//砸蛋礼品管理

        'eggpresentrec_setting'   => 'eggpresentrec|all',//砸蛋礼品兑换记录

        'integral_goods'   => 'integral_goods|all',//积分回购管理

        'integral_goods_log'   => 'integral_goods_log|all',//积分回购记录

    ),

    'external' => array

    (

        'plugin' => 'plugin|all',//插件管理

        'module'   => 'module|all',//模块管理

        'widget'   => 'widget|all',//挂件管理

    ),

    'clear_cache' =>array

    (

        'clear_cache' => 'clear_cache|all',//清空缓存

    )

);

?>