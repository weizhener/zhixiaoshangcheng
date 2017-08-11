<?php

class SdinfoModel extends BaseModel
{
    var $table  = 'sdinfo';
    var $prikey = 'id';
    var $_name  = 'sdinfo';

    var $_relation = array(
        // 一条信息属于一个分类
        'belongs_to_sdcategory' => array(
            'model'             => 'sdcategory',
            'type'              => BELONGS_TO,
            'foreign_key'       => 'cate_id',
            'reverse'           => 'has_sdinfo',
        ),
		// 一条信息只能属于一个用户
        'belongs_to_member' => array(
            'model'             => 'member',
            'type'              => BELONGS_TO,
            'foreign_key'       => 'user_id',
            'reverse'           => 'has_sdinfo',
        ),
         //一个文章对应多个上传文件
        'has_uploadedfile' => array(
            'model'             => 'uploadedfile',
            'type'              => HAS_MANY,
            'foreign_key' => 'item_id',
            'ext_limit' => array('belong' => BELONG_ARTICLE),
            'dependent' => true
        ),
    );

}

?>