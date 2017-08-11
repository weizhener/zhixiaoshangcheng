<?php



return array(

    'id' => 'kuaidi100',

    'hook' => 'on_query_express',

    'name' => '快递跟踪',

    'desc' => '显示物流快递的配送进程',

    'author' => '智芸商城',

    'version' => '1.0',

    'config' => array(

        'AppKey' => array(

            'type' => 'text',

            'text' => 'AppKey'

        ),

    )

);



?>