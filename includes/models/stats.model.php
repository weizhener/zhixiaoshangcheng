<?php

/* 流量统计 stats */
class StatsModel extends BaseModel
{
    var $table  = 'stats';
    var $prikey = 'access_time';
    var $alias  = 's';
    var $_name  = 'stats';


    /**
     *    重新计算好评率
     *
     *    @author    Garbin
     *    @param     int $store_id
     *    @return    float
     */
    function recount_praise_rate($store_id)
    {
        $praise_rate = 0.00;
        $model_ordergoods =& m('ordergoods');

        /* 找出所有is_valid为1的商品中的商品评价记录总数 */
        $info  = $model_ordergoods->get(array(
            'join'          => 'belongs_to_order',
            'conditions'    => "seller_id={$store_id} AND evaluation_status=1 AND is_valid=1",
            'fields'        => 'COUNT(*) as evaluation_count',
            'index_key'     => false,   /* 不需要索引 */
        ));
        $evaluation_count = $info['evaluation_count'];
        if (!$evaluation_count)
        {
            return $praise_count;
        }

        /* 找出所有的evaluation为3的记录总数 */
        $info = $model_ordergoods->get(array(
            'join'          => 'belongs_to_order',
            'conditions'    => "seller_id={$store_id} AND evaluation_status=1 AND is_valid=1 AND evaluation=3",
            'fields'        => 'COUNT(*) as praise_count',
            'index_key'     => false,   /* 不需要索引 */
        ));
        $praise_count = $info['praise_count'];
        /* 计算好评数占总数的百分比 */
        $praise_rate = round(($praise_count / $evaluation_count), 4) * 100;

        return $praise_rate;
    }

}

?>
