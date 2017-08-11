<?php

class JutemplateModel extends BaseModel
{
    var $table  = 'ju_template';
    var $prikey = 'template_id';
	var $alias  = 'jt';
    var $_name  = 'jutemplate';
	
	
	var $_relation = array(
        'has_ju' => array(
            'model' => 'ju',
            'type' => HAS_MANY,
            'foreign_key' => 'template_id',
            'dependent'   => true, // 依赖
        ),
    );
}
?>
