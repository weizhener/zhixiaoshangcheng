<?php

/**
 *    微信公众平台信息模型
 *
 *    @author    hzj1216000
 *    @usage    none
 */
class WxchqrModel extends BaseModel
{
    var $table      =   'wxch_qr';
    var $prikey     =   'qid';
    var $_name      =   'qr';
	   
	/* 与其它模型之间的关系 */
    var $_relation = array(
        
		
		       // 一个微信号一个会员
      /*  'belongs_to_user' => array(
            'model'         => 'member',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'user_id',
            'reverse'       => 'has_wx',
        ),*/
		
	);
	

	
	
	

}

?>