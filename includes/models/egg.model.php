<?php

/* 砸蛋蛋库 egg */

class EggModel extends BaseModel {

    var $table = 'egg';
    var $prikey = 'id';
    var $_name = 'egg';
    var $_relation = array(
        // 一个金蛋有多个礼品
        'has_eggpresent' => array(
            'model' => 'eggpresent',
            'type' => HAS_MANY,
            'foreign_key' => 'byeggid',
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
    function drop($conditions, $fields = '') {
        $droped_rows = parent::drop($conditions, $fields);
        if ($droped_rows) {
            restore_error_handler();
            $droped_data = $this->getDroppedData();
            reset_error_handler();
        }
        return $droped_rows;
    }

    /**
     *    为封装成select
     *
     *    @author    Hyber
     *    @param     string $conditions
     *    @param     string $fields
     *    @return    void
     */
    function get_options() {
        $cache_server = & cache_server();
        $key = 'egg_options';
        $options = $cache_server->get($key);
        if ($options === false) {
            $options = array();
            $eggs = $this->find();
            foreach ($eggs as $egg) {
                $options[$egg['id']] = $egg['name'];
            }
            $cache_server->set($key, $options);
        }

        return $options;
    }

}

?>