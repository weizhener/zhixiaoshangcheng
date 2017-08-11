<?php

/* 团购活动 groupbuy */
class JuModel extends BaseModel
{
    var $table  = 'ju';
    var $alias  = 'ju';
    var $prikey = 'group_id';
    var $_name  = 'ju';
    var $_relation  = array(
        // 一个团购活动属于一个商品
        'belong_goods' => array(
            'model'         => 'goods',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'goods_id',
            'reverse'       => 'has_groupbuy',
        ),
        // 一个团购活动属于一个店铺
        'belong_store' => array(
            'model'         => 'store',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'store_id',
            'reverse'       => 'has_groupbuy',
        ),
		// 一个团购活动属于一个活动
        'belong_template' => array(
            'model'         => 'jutemplate',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'template_id',
            'reverse'       => 'has_ju',
        ),
        // 团购活动和会员是多对多的关系（会员参加团购活动）
        'be_join' => array(
            'model'         => 'member',
            'type'          => HAS_AND_BELONGS_TO_MANY,
            'middle_table'  => 'groupbuy_log',
            'foreign_key'   => 'group_id',
            'reverse'       => 'join_groupbuy',
        ),
        // 一个团购被一个会员发起
        'be_start' => array(
            'model'         => 'member',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'user_id',
            'reverse'       => 'start_groupbuy',
        ),
        //一个团购有多个咨询
        'has_consulting' => array(
            'model' => 'goodsqa',
            'type' => HAS_MANY,
            'foreign_key' => 'item_id',
            'ext_limit' => array('type' => 'groupbuy'),
            'dependent' => true,
        ),
    );
	
	function _get_group_join($id=0)
	{
		if(!$id) return 0;
		
		$ordergoods_model =& m('ordergoods');
		$ordergoods = $ordergoods_model->find(array(
			'conditions' => 'order_goods.group_id='.$id, //如果要订单完成统计加，.' AND finished_time > 0'
			'join'       =>'belongs_to_order',
			'fields'=>'quantity',
		));
		if(empty($ordergoods)) return 0;
		
		$count = 0;
		foreach($ordergoods as $order)
		{
			$count += $order['quantity'];
		}
		return $count;
	}

}

/* 聚划算业务模型 business model */
class JuBModel extends JuModel
{
    var $_store_id = 0;
	
	function drop($conditions, $fields = '')
	{
		return parent::drop($conditions, $fields);
	}

}
?>
