<?php


class StatisticsApp extends MallbaseApp {

    var $_store_id;
    var $_user_id;
    var $_statistics_mod;

    function __construct() {
        parent::__construct();
        $this->_statistics_mod = & m('statistics');
    }

    function index() {

        $store_id = intval($_GET['store_id']);
        if($this->visitor->get('user_id')){
            $user_id = $this->visitor->get('user_id');
        }else{
            $user_id = 0;
        }
        
      if (empty($store_id)||empty($_SERVER['HTTP_REFERER'])) {
            return;
        }

        
        $data['store_id'] = $store_id;
        $data['user_id'] = $user_id;
        
//        $data['visit_url'] = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $data['visit_url'] = $_SERVER['HTTP_REFERER'];#此处通过JS 调用的 脚本  获取上级页面即为当前访问地址
        
        $data['reffrer_url'] = '';
        
        
        $data['ip'] = $this->_getIp();

        $data['user_os'] = $this->_get_userOS();
        $data['user_browser'] = $this->_get_userBrowser();

        /**
          屏蔽IP 都為空  用戶瀏覽器   來訪頁面
         */
        if ($data['user_browser'] == '其它' && $data['user_os'] == '其它') {
            return;
        }

        //東8時區， 獲取 需要加上 8*3600
        $data['start_time'] = time();
        $data['end_time'] = $data['start_time'] + 1;
        $data['visit_times'] = 1;
        $data['date'] = date('Y-m-d', $data['start_time'] + 3600 * 8);  #此處加了八個小時，  表示為 東八區


        $day = mktime(0, 0, 0, date('m'), date("d"), date('Y'));
        $yday = mktime(0, 0, 0, date('m'), date("d") + 1, date('Y'));



        //判斷用戶是否已經訪問過
        $conditions = 'user_id="' . $data['user_id'] . '" AND store_id="' . $data['store_id'] . '"  AND visit_url="' . $data['visit_url'] . '"  AND start_time>' . $day . ' AND end_time<' . $yday;
        $info = $this->_statistics_mod->get(
                array(
                    'conditions' => $conditions,
                )
        );
        if (empty($info)) {
            $this->_statistics_mod->add($data);
        } else {
            $this->_statistics_mod->edit($info['statistics_id'], array(
                'end_time' => time(),
                'visit_times' => $info['visit_times'] + 1,
                    )
            );
        }
		
		 $hot= $this->_statistics_mod->getOne("SELECT COUNT(*) FROM " . DB_PREFIX . "statistics WHERE store_id > '$store_id'");
		
		$store_mod =& m('store');
		
		$store_mod->edit($store_id,"hot='$hot'");
		
    }
    
    function _get_userBrowser() {
        $user_OSagent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_OSagent, "Maxthon") && strpos($user_OSagent, "MSIE")) {
            $visitor_browser = "Maxthon(Microsoft IE)";
        } elseif (strpos($user_OSagent, "Maxthon 2.0")) {
            $visitor_browser = "Maxthon 2.0";
        } elseif (strpos($user_OSagent, "Maxthon")) {
            $visitor_browser = "Maxthon";
        } elseif (strpos($user_OSagent, "MSIE 9.0")) {
            $visitor_browser = "MSIE 9.0";
        } elseif (strpos($user_OSagent, "MSIE 8.0")) {
            $visitor_browser = "MSIE 8.0";
        } elseif (strpos($user_OSagent, "MSIE 7.0")) {
            $visitor_browser = "MSIE 7.0";
        } elseif (strpos($user_OSagent, "MSIE 6.0")) {
            $visitor_browser = "MSIE 6.0";
        } elseif (strpos($user_OSagent, "MSIE 5.5")) {
            $visitor_browser = "MSIE 5.5";
        } elseif (strpos($user_OSagent, "MSIE 5.0")) {
            $visitor_browser = "MSIE 5.0";
        } elseif (strpos($user_OSagent, "MSIE 4.01")) {
            $visitor_browser = "MSIE 4.01";
        } elseif (strpos($user_OSagent, "MSIE")) {
            $visitor_browser = "MSIE 较高版本";
        } elseif (strpos($user_OSagent, "NetCaptor")) {
            $visitor_browser = "NetCaptor";
        } elseif (strpos($user_OSagent, "Netscape")) {
            $visitor_browser = "Netscape";
        } elseif (strpos($user_OSagent, "Chrome")) {
            $visitor_browser = "Chrome";
        } elseif (strpos($user_OSagent, "Lynx")) {
            $visitor_browser = "Lynx";
        } elseif (strpos($user_OSagent, "Opera")) {
            $visitor_browser = "Opera";
        } elseif (strpos($user_OSagent, "Konqueror")) {
            $visitor_browser = "Konqueror";
        } elseif (strpos($user_OSagent, "Mozilla/5.0")) {
            $visitor_browser = "Mozilla";
        } elseif (strpos($user_OSagent, "Firefox")) {
            $visitor_browser = "Firefox";
        } elseif (strpos($user_OSagent, "U")) {
            $visitor_browser = "Firefox";
        } else {
            $visitor_browser = "其它";
        }
        return $visitor_browser;
    }

    function _get_userOS() {
        $user_OSagent = $_SERVER['HTTP_USER_AGENT'];
        if (strpos($user_OSagent, "NT 5.1")) {
            $visitor_os = "Windows XP (SP2)";
        } elseif (strpos($user_OSagent, "NT 5.2") && strpos($user_OSagent, "WOW64")) {
            $visitor_os = "Windows XP 64-bit Edition";
        } elseif (strpos($user_OSagent, "NT 5.2")) {
            $visitor_os = "Windows 2003";
        } elseif (strpos($user_OSagent, "NT 6.0")) {
            $visitor_os = "Windows Vista";
        } elseif (strpos($user_OSagent, "NT 5.0")) {
            $visitor_os = "Windows 2000";
        } elseif (strpos($user_OSagent, "4.9")) {
            $visitor_os = "Windows ME";
        } elseif (strpos($user_OSagent, "NT 4")) {
            $visitor_os = "Windows NT 4.0";
        } elseif (strpos($user_OSagent, "98")) {
            $visitor_os = "Windows 98";
        } elseif (strpos($user_OSagent, "95")) {
            $visitor_os = "Windows 95";
        } elseif (strpos($user_OSagent, "Mac")) {
            $visitor_os = "Mac";
        } elseif (strpos($user_OSagent, "Linux")) {
            $visitor_os = "Linux";
        } elseif (strpos($user_OSagent, "Unix")) {
            $visitor_os = "Unix";
        } elseif (strpos($user_OSagent, "FreeBSD")) {
            $visitor_os = "FreeBSD";
        } elseif (strpos($user_OSagent, "SunOS")) {
            $visitor_os = "SunOS";
        } elseif (strpos($user_OSagent, "BeOS")) {
            $visitor_os = "BeOS";
        } elseif (strpos($user_OSagent, "OS/2")) {
            $visitor_os = "OS/2";
        } elseif (strpos($user_OSagent, "PC")) {
            $visitor_os = "Macintosh";
        } elseif (strpos($user_OSagent, "AIX")) {
            $visitor_os = "AIX";
        } elseif (strpos($user_OSagent, "IBM OS/2")) {
            $visitor_os = "IBM OS/2";
        } elseif (strpos($user_OSagent, "BSD")) {
            $visitor_os = "BSD";
        } elseif (strpos($user_OSagent, "NetBSD")) {
            $visitor_os = "NetBSD";
        } else {
            $visitor_os = "其它";
        }
        return $visitor_os;
    }

    /*
     * 获取用户IP的函数
     */

    function _getIp() {
        $onlineip = "";
        if (getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
            $onlineip = getenv('HTTP_CLIENT_IP');
        } elseif (getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
            $onlineip = getenv('HTTP_X_FORWARDED_FOR');
        } elseif (getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
            $onlineip = getenv('REMOTE_ADDR');
        } elseif (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
            $onlineip = $_SERVER['REMOTE_ADDR'];
        }
        return $onlineip;
    }
    
    

}

?>
