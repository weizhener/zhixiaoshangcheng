<?php

/* 砸蛋礼品 eggpresent */

class EggpresentModel extends BaseModel {

    var $table = 'eggpresent';
    var $prikey = 'id';
    var $_name = 'eggpresent';
    var $_relation = array(
        // 一个礼品属于一个金蛋
        'belongs_to_egg' => array(
            'model' => 'egg',
            'type' => BELONGS_TO,
            'foreign_key' => 'id',
            'reverse' => 'has_eggpresent',
        ),
    );

    /**
     *    删除
     *
     *    @author    Hyber
     *    @param     string $conditions
     *    @param     string $fields
     *    @return    void
     */
    function drop($conditions, $fields = 'eggpresent_logo') {
        $droped_rows = parent::drop($conditions, $fields);
        if ($droped_rows) {
            restore_error_handler();
            $droped_data = $this->getDroppedData();
            foreach ($droped_data as $key => $value) {
                if ($value['eggpresent_logo']) {
                    @unlink(ROOT_PATH . '/' . $value['eggpresent_logo']);  //删除Logo文件
                }
            }
            reset_error_handler();
        }

        return $droped_rows;
    }

}

?>