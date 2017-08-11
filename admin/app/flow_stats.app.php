<?php

class Flow_statsApp extends BackendApp
{
    var $_user_mod;
	var $_stats_mod;

    function __construct()
    {
        $this->Flow_statsApp();
    }

    function Flow_statsApp()
    {
        parent::__construct();
        $this->_user_mod =& m('member');
		$this->_stats_mod =& m('stats');
		
    }

    function index()
    {
        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'add_time',
                'name'  => 'add_time_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'add_time',
                'name'  => 'add_time_to',
                'equal' => '<=',
                'handler'   => 'gmstr2time_end',
            ),
        ));


    /* 时间参数 */
    	if (isset($_GET['add_time_from']) && !empty($_GET['add_time_to']))
    	{
        	$start_date = strtotime($_GET['add_time_from']);
       	 	$end_date = strtotime($_GET['add_time_to']);
        	if ($start_date == $end_date)
        	{
				$end_date   =   $start_date + 86400;
        	}
    	}
    	else
    	{
        	$today      = strtotime(date('Y-m-d'));   //本地时间
        	$start_date = $today - 86400 * 30*12;
        	$end_date   = $today + 86400;               //至明天零时
    	}
		
	/* ------------------------------------- */
    /* --综合流量
    /* ------------------------------------- */
    	 $max = 0;
         $general_xml = "<graph caption='" . Lang::get('general_stats') . "' shownames='1' showvalues='1' decimalPrecision='0' yaxisminvalue='0' yaxismaxvalue='%d' animation='1' outCnvBaseFontSize='12' baseFontSize='12' xaxisname='$_LANG[date]' yaxisname='" . Lang::get('access_count')."' >";

        $sql = "SELECT FLOOR((access_time - $start_date) / (24 * 3600)) AS sn, access_time, COUNT(*) AS access_count".
                " FROM " .DB_PREFIX."stats ".
                " WHERE access_time >= '$start_date' AND access_time <= " .($end_date + 86400).
                " GROUP BY sn";

		$res = $this->_stats_mod->db->query($sql);
        $key = 0;
 		while ($val =$this->_stats_mod->db->FetchRow($res))
        {
            $val['access_date'] = gmdate('m-d',$val['access_time']);
            $general_xml .= "<set name='$val[access_date]' value='$val[access_count]' color='" .$this->chart_color($key). "' />";
            if ($val['access_count'] > $max)
            {
                $max = $val['access_count'];
            }
            $key++;
        }

        $general_xml .= '</graph>';
        $general_xml  = sprintf($general_xml, $max);
	/* ------------------------------------- */
    /* --地域分布
    /* ------------------------------------- */
		$area_xml .= "<graph caption='". Lang::get('area_stats')."' shownames='1' showvalues='1' decimalPrecision='2' outCnvBaseFontSize='13' baseFontSize='13' pieYScale='45'  pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='100' bgAngle='460'>";

        $sql = "SELECT COUNT(*) AS access_count, area FROM "  .DB_PREFIX."stats ".
                " WHERE access_time >= '$start_date' AND access_time < " .($end_date + 86400).
                " GROUP BY area ORDER BY access_count DESC LIMIT 20";
		$res = $this->_stats_mod->db->query($sql);
        $key = 0;
        while ($val =$this->_stats_mod->db->FetchRow($res))
        {
            $area = empty($val['area']) ? 'unknow' : $val['area'];

            $area_xml .= "<set name='$area' value='$val[access_count]' color='" .$this->chart_color($key). "' />";
            $key++;
        }
        $area_xml .= '</graph>';
	/* ------------------------------------- */
    /* --来源网站
    /* ------------------------------------- */
		$from_xml = "<graph caption='".Lang::get('from_stats')."' shownames='1' showvalues='1' decimalPrecision='2' outCnvBaseFontSize='12' baseFontSize='12' pieYScale='45' pieBorderAlpha='40' pieFillAlpha='70' pieSliceDepth='15' pieRadius='100' bgAngle='460'>";

        $sql = "SELECT COUNT(*) AS access_count, referer_domain FROM " .DB_PREFIX."stats ".
                " WHERE access_time >= '$start_date' AND access_time <= " .($end_date + 86400).
                " GROUP BY referer_domain ORDER BY access_count DESC LIMIT 20";
				
		$res = $this->_stats_mod->db->query($sql);
        $key = 0;
        while ($val =$this->_stats_mod->db->FetchRow($res))
        {
            $from = empty($val['referer_domain']) ? lang::get('input_url') : $val['referer_domain'];

            $from_xml .= "<set name='".str_replace(array('http://', 'https://'), array('', ''), $from) . "' value='$val[access_count]' color='" . $this->chart_color($key). "' />";

            $key++;
        }

        $from_xml .= '</graph>';
		$this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
                                  'style'=> 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
		$this->assign('general_data', $general_xml);
    	$this->assign('area_data',    $area_xml);
    	$this->assign('from_data',    $from_xml); 
		$model_setting = &af('settings');
        	$setting = $model_setting->getAll(); //载入系统设置数据
			$this->assign('setting', $setting);
        $this->display('flow_stats.htm');
    }
	function chart_color($n)
	{
    /* 随机显示颜色代码 */
    $arr = array('33FF66', 'FF6600', '3399FF', '009966', 'CC3399', 'FFCC33', '6699CC', 'CC3366', '33FF66', 'FF6600', '3399FF');

    if ($n > 8)
    {
        $n = $n % 8;
    }

    return $arr[$n];
	}
}


?>
