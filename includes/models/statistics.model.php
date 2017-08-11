<?php

class statisticsModel extends BaseModel
{
    var $table  = 'statistics';
    var $prikey = 'statistics_id';
	var $alias  = 'stat';
    var $_name  = 'stat';
	 
	  var $_relation  =   array(
        // 一个配送方式只能属于一个店铺
        'belongs_to_store' => array(
            'model'         => 'store',
            'type'          => BELONGS_TO,
            'foreign_key'   => 'store_id',
            'reverse'       => 'has_statistics',
        ),
    );
	 
	/**
     * 获取店铺诊断店铺近30天体检报告
     *
     */
    function  _list()
    {
        $data = array();
        $sql = "SELECT count(*) as count , *  FROM {$this->table} WHERE statistics_id > 0 GROUP BY statistics_id ORDER BY count DESC LIMIT 50";
        $res = $this->db->query($sql);
        while ($row = $this->db->fetchRow($res))
        {
            $data[$row['statistics_id']] = $row;
        }
        return $data;
    }
	
    /**
     * 获取店铺诊断店铺近30天体检报告
     */
    function  _add($url)
    {
	$sql="INSERT INTO  ecm_statistics  (`statistics_id`, `store_id`, `Position`, `Starttime`, `url`, `endtime`, `other`, `statistics`, `session_id`, `visitor_id`, `se`, `se_name`, `keyword`, `referer_domain`, `referer_url`, `page_url`, `page_domain`, `page_title`, `entrance_url`, `entrance_title`, `exit_url`, `exit_title`, `ip`) VALUES (NULL, '1', '11', '11', '1', '11', '11', '11', '11', '11', '111', '111', '11', '111', '11', '11', '11', '1', '111', '1', '111', '11', '11');";
    }

  
}

?>
