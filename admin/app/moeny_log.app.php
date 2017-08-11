<?php

class moeny_logApp extends BackendApp
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
		$this->_stats_mod =& m('moeny_log');
		
    }

    function index()
    {
        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'addtime',
                'name'  => 'addtime_from',
                'equal' => '>=',
                'handler'=> 'gmstr2time',
            ),array(
                'field' => 'addtime',
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

      
		 $page = $this->_get_page(10);
		 $moeny_list = $this->_stats_mod->find(array(
		   'conditions' => '1=1' . $conditions,
           'limit' => $page['limit'],
            'order' => "id desc",
            'count' => true,
        ));
		$key = 0;
		
	
	    foreach($moeny_list as $kk=>$val)
		{
		$val['access_date'] = gmdate('m-d',$val['addtime']);
            $general_xml .= "<set name='$val[access_date]' value='$val[moeny]' color='" .$this->chart_color($key). "' />";
            if ($val['moeny'] > $max)
            {
                $max = $val['access_count'];
            }
            $key++;
		
		}
	
     $general_xml .= '</graph>';
        $general_xml  = sprintf($general_xml, $max);
		$this->assign('general_data', $general_xml);
     
		$model_setting = &af('settings');
        	$setting = $model_setting->getAll(); //载入系统设置数据
			$this->assign('setting', $setting);
        $this->display('moeny_log.htm');
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
