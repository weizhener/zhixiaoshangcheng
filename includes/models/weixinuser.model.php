<?php

/**
 *    微信公众平台信息模型
 *
 *    @author    hzj1216000
 *    @usage    none
 */
class WeixinuserModel extends BaseModel
{
    var $table      =   'weixin_user';
    var $prikey     =   'uid';
    var $_name      =   'weixin_user';
	    var $alias  = 'w';
	/* 与其它模型之间的关系 */
    var $_relation = array(
        
		
		       // 一个微信号一个会员
        'belongs_to_user' => array(
            'model'         => 'member',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'user_id',
            'reverse'       => 'has_wx',
        ),
		
	);
	

	
	
	

}

?>