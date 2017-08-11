<?php

/**
 * 积分产品
 */
class Integral_goodsModel extends BaseModel {

    var $table = 'integral_goods';
    var $prikey = 'goods_id';
    var $_name = 'integral_goods';
    var $_relation = array(
        // 一个积分产品 有 多个兑换记录
        'has_integral_goods_log' => array(
            'model' => 'integral_goods_log',
            'type' => HAS_MANY,
            'foreign_key' => 'goods_id',
            'dependent' => true
        ),
    );

    function drop($conditions, $fields = 'goods_logo') {
        $droped_rows = parent::drop($conditions, $fields);
        if ($droped_rows) {
            restore_error_handler();
            $droped_data = $this->getDroppedData();
            foreach ($droped_data as $key => $value) {
                if ($value['goods_logo']) {
                    @unlink(ROOT_PATH . '/' . $value['goods_logo']);  //删除Logo文件
                }
            }
            reset_error_handler();
        }
        return $droped_rows;
    }

    /*
     * 判断名称是否唯一
     */
    function unique($goods_name, $goods_id = 0) {
        $conditions = "goods_name = '" . $goods_name . "' AND goods_id != " . $goods_id . "";
        //dump($conditions);
        return count($this->find(array('conditions' => $conditions))) == 0;
    }

}
