<?php

/* 砸蛋礼品兑换 eggpresentrec */

class EggpresentrecModel extends BaseModel {

    var $table = 'eggpresentrec';
    var $prikey = 'id';
    var $_name = 'eggpresentrec';

    /**
     *    删除
     */
    function drop($conditions, $fields = '') {
        $droped_rows = parent::drop($conditions, $fields);
        if ($droped_rows) {
            restore_error_handler();
            $droped_data = $this->getDroppedData();
            reset_error_handler();
        }

        return $droped_rows;
    }

}

?>