<?php

return array (
  'widgets' => 
  array (
  '_widget_944' => 
    array (
      'name' => 'banner',
      'options' => 
      array (
        'ad_image_url' => 'data/files/store_1/template/201310230247132921.jpg',
		'ad_link' => '#',
        'ad_height' => '118',
      ),
    ),
    '_widget_628' => 
    array (
      'name' => 'nav',
      'options' => 
      array (
        'color' => '#8e94a4',
        'title' => 
        array (
          0 => '所有宝贝',
          1 => '女装',
          2 => '时尚女鞋',
        ),
        'link' => 
        array (
          0 => 'index.php?app=store&id=2&act=search',
          1 => 'index.php?app=store&id=2&act=search&cate_id=1200',
          2 => 'index.php?app=store&id=2&act=search&cate_id=1207',
        ),
        'navs' => 
        array (
          0 => 
          array (
            'title' => '所有宝贝',
            'link' => 'index.php?app=store&id=2&act=search',
          ),
          1 => 
          array (
            'title' => '女装',
            'link' => 'index.php?app=store&id=2&act=search&cate_id=1200',
          ),
          2 => 
          array (
            'title' => '时尚女鞋',
            'link' => 'index.php?app=store&id=2&act=search&cate_id=1207',
          ),
        ),
      ),
    ),
    '_widget_229' => 
    array (
      'name' => 'gcategory',
      'options' => NULL,
    ),
    '_widget_352' => 
    array (
      'name' => 'hot_sales_more_collect',
      'options' => NULL,
    ),
  ),
  'config' => 
  array (
  'top_ad_area' => 
    array (
      0 => '_widget_944',
      1 => '_widget_628',
   ),
    'store_left' => 
    array (
      0 => '_widget_229',
      1 => '_widget_352',
    ),
  ),
);

?>