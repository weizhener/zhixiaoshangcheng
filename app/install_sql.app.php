<?php

class Install_sqlApp extends MallbaseApp {

    function index() {
        $mod = & m('privilege');

        $sql = "ALTER TABLE  `" . DB_PREFIX . "order_goods` ADD  `evaluation_desc` TINYINT NOT NULL DEFAULT  '5' AFTER  `credit_value` ,
ADD  `evaluation_service` TINYINT NOT NULL DEFAULT  '5' AFTER  `evaluation_desc` ,
ADD  `evaluation_speed` TINYINT NOT NULL DEFAULT  '5' AFTER  `evaluation_service`;";
        $mod->db->query($sql);

        $sql = "ALTER TABLE  `" . DB_PREFIX . "store` ADD  `evaluation_desc` DECIMAL( 3, 1 ) NOT NULL DEFAULT  '5' AFTER  `credit_value` ,
ADD  `evaluation_service` DECIMAL( 3, 1 ) NOT NULL DEFAULT  '5' AFTER  `evaluation_desc` ,
ADD  `evaluation_speed` DECIMAL( 3, 1 ) NOT NULL DEFAULT  '5' AFTER  `evaluation_service`";
        $mod->db->query($sql);
        
        
        $sql = "ALTER TABLE  `" . DB_PREFIX . "order` ADD  `seller_evaluation_status` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `evaluation_time` ,
ADD  `seller_evaluation_time` INT( 10 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `seller_evaluation_status`";
        $mod->db->query($sql);
        
        $sql = "ALTER TABLE  `" . DB_PREFIX . "order_goods` ADD  `seller_evaluation` TINYINT( 1 ) UNSIGNED NOT NULL DEFAULT  '0' AFTER  `credit_value` ,
ADD  `seller_comment` VARCHAR( 255 ) NOT NULL DEFAULT  '' AFTER  `seller_evaluation` ,
ADD  `seller_credit_value` TINYINT( 1 ) NOT NULL DEFAULT  '0' AFTER  `seller_comment`";
        $mod->db->query($sql);
        
        $sql = "ALTER TABLE  `ecm_member` ADD  `buyer_credit_value` INT( 10 ) NOT NULL DEFAULT  '0' AFTER  `real_name` ,
ADD  `buyer_praise_rate` DECIMAL( 5, 2 ) UNSIGNED NOT NULL DEFAULT  '0.00' AFTER  `buyer_credit_value`";
        $mod->db->query($sql);
        
        
        
    }

}

?>