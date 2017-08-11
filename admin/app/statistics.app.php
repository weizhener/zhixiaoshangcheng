<?php
define('ENABLE_STATISTICS_CACHE', FALSE); // 启用缓存
define('SEARCH_STATISTICS_TTL', 1000);  // 商品搜索缓存时间
class statisticsApp extends BackendApp {

    var $_statistics_mod;
    var $_store_id;
	 var $_store_mod;

    function __construct() {
        parent::__construct();

        //設置為  東八區  時間段（北京時間）
        date_default_timezone_set('PRC');
        $this->_statistics_mod = & m('statistics');
        $this->_store_id = intval($this->visitor->get('manage_store'));
		$this->_store_mod =& m('store');
    }

    function index() {
        /* 当前用户中心菜单 */
       
        $page = $this->_get_page();
        $stores = $this->_store_mod->find(array(
            'conditions' => $conditions,
            'limit' => $page['limit'],
            'count' => true,
            'order' => "hot desc"
        ));

     

        $this->assign('stores', $stores);
        $this->display('statistics.index.html');
    }
    //今日概況
    function solid_dot() {
        $statistics = $this->_get_data();

        //使用open-flash-chart  返回圖片數值
        include 'includes/open-flash-chart-2/php-ofc-library/open-flash-chart.php';
        $y_range = 0;
        $data_type = $statistics['param']['data_type'];

        foreach ($statistics['time'] as $key => $value) {
            //visit_times   pv   uv   ip   相關數據   此處數據用來 傳給open-flash-chart
            $temp_data = empty($value[$data_type]) ? 0 : $value[$data_type];
            $data[] = $temp_data;

            if ($temp_data > $y_range)
                $y_range = $temp_data;
            $x_date[] = $key;


            /*
              $visit_times = empty($value['visit_times']) ? 0 : $value['visit_times'];
              $data['visit_times'][] = $visit_times;
              $pv   = empty($value['pv']) ? 0 : $value['pv'];
              $data['pv'][]  = $pv;
              $uv   = empty($value['uv']) ? 0 : $value['uv'];
              $data['uv'][] = $uv;
              $ip = empty($value['ip']) ? 0 : $value['ip'];
              $data['ip'][] = $ip;

              if ($ip > $y_range)
              $y_range = $ip;
              $x_date[] = $key ;
             */
        }
//        print_r($data);exit;
        $x_range = ceil(count($x_date) / 10);

        #得到10的倍數 ， 用來使用與 豎坐標
        $y_range = ceil($y_range / 10);
        $y_range = ($y_range < 1 ? 1 : $y_range) * 10;

        $title = date("Y年m月d日", mktime(0, 0, 0, $statistics['param']['st']['m'], $statistics['param']['st']['d'], $statistics['param']['st']['Y']));
        $title .= $data_type . "統計";
        $title = new title($title);
        // ------- LINE 2 -----
        $d = new solid_dot();
        $d->size(4)->halo_size(0)->colour('#E95B7D'); #設置點的顏色，  點的範圍 ，點的大小

        $line = new line();
        $line->set_default_dot_style($d);
        $line->set_values($data);
        $line->set_width(2);
        $line->set_colour('#E95B7D');   #設置線條顏色

        $x = new x_axis();
        $x->set_steps($x_range);
//        $x->set_colours('#E95B7D', '#FFB5C5'); # 設置線條顏色
        $x->set_labels_from_array($x_date);


        $y = new y_axis();
        $y->set_range(0, $y_range, $y_range / 10);
//        $y->set_colours('#E95B7D', '#FFB5C5');


        $chart = new open_flash_chart();
//        $g->title( 'Server load', '{font-size: 25px; color: #9933CC; text-align: left}' );
        $chart->set_bg_colour('#ffffff'); # 設置背景色
        $chart->set_title($title);
        $chart->add_element($line);
//        $g->set_y_legend( 'Money', 12, '#000000' ); #側邊的注釋說明
//        $g->set_x_legend( '2007', 12, '#000000' );
        $chart->set_y_axis($y);
        $chart->set_x_axis($x);

        echo $chart->toPrettyString();
    }
    
    
    function _get_data() {
        $param = $this->_get_query_param();

        $statistics = FALSE;

        if (ENABLE_STATISTICS_CACHE) {
            $cache_server = & cache_server();
            $statistics_key = 'statistics_index_' . $this->_store_id . var_export($param, true);
            $statistics = $cache_server->get($statistics_key);
        }

        if ($statistics === FALSE) {

            //判斷是一天統計還是多天統計  一天的詳細信息通過小時   多天通過天數
            //$start_time = date("M-d-Y", mktime(0, 0, 0, $param['st']['m'], $param['st']['d'], $param['st']['Y']));echo $start_time;exit;
            $start_time = mktime(0, 0, 0, $param['st']['m'], $param['st']['d'], $param['st']['Y']);
            $end_time = mktime(0, 0, 0, $param['et']['m'], $param['et']['d'], $param['et']['Y']);

            //判斷時間週期 一天為計算單位(小時為區分點)  多天為計算單位(天數為區分點)
            if ($start_time == $end_time) {
                //如果為今日    $start_time ==$end_time
                $end_time = $start_time + 24 * 3600;

//            $conditions = 'start_time>' . $start_time . ' AND end_time<' . $end_time;
                $conditions = 'store_id="' . $this->_store_id . '"  AND start_time>' . $start_time . ' AND start_time<' . $end_time;
                $statis_info = $this->_statistics_mod->find(
                        array(
                            'conditions' => $conditions,
                        )
                );
//            print_r($statis_info);
                //根據數據對時段進行統計
                for ($hour_i = 0; $hour_i < 24; $hour_i++) {
                    $statistics['time'][$hour_i . ":00"] = NULL;
                }
                $visit_times = 0;
                $visit_url = array();
                $visit_url_count = 0;
                $user_id = array();
                $user_id_count = 0;
                $address = array();
                $address_count = 0;

                foreach ($statis_info as $key => $info) {
                    $Hour = date('G', $info['start_time']) . ':00';

                    #店鋪時間段訪問次數  
                    $statistics['time'][$Hour]['visit_times'] += $info['visit_times'];
                    $visit_times += $info['visit_times']; #統計一共訪問次數
                    #店鋪PV  檢查店鋪PV  如果存在不相加
                    if (empty($statistics['time'][$Hour]['pv']) || !in_array($info['visit_url'], $visit_url)) {
                        $statistics['time'][$Hour]['pv'] +=1;
                        $visit_url[] = $info['visit_url'];
                        $visit_url_count++;
                    }


                    #店鋪UV  檢查店鋪UV  如果存在不相加
                    //默認情況下   如果 UV 應該 大於IP  如果   以下如果任意一個滿足 都應該 增長 1  通過 temp_uv 判斷
                    $temp_uv = TRUE;
                    if (empty($statistics['time'][$Hour]['uv']) || !in_array($info['user_id'], $user_id)) {
                        $statistics['time'][$Hour]['uv'] +=1;
                        $user_id[] = $info['user_id'];
                        $user_id_count++;
                        $temp_uv = FALSE;
                    }

                    #店鋪IP  檢查店鋪IP  如果存在不相加
                    if (empty($statistics['time'][$Hour]['ip']) || !in_array($info['ip'], $address)) {
                        $statistics['time'][$Hour]['ip'] +=1;
                        $address[] = $info['ip'];
                        $address_count++;
                        if($temp_uv){
                            $user_id_count++;
                            $statistics['time'][$Hour]['uv'] +=1;
                        }
                    }
                }
                $statistics['total']['visit_times'] = $visit_times;
                $statistics['total']['pv'] = $visit_url_count;
                $statistics['total']['uv'] = $user_id_count;
                $statistics['total']['ip'] = $address_count;
                $statistics['param'] = $param;
            } elseif (($end_time - $start_time) <= 3600 * 24 * 31) {
                //以日期為計算單位
                $end_time = $end_time + 24 * 3600;

                
                                
                
                //方法一  
                $sql = 'select count(distinct(visit_url)) as pv ,  count(distinct(user_id)) as uv, sum(visit_times) as visit_times ,count(distinct(ip)) as ip ,date
                    from '.$this->_statistics_mod->table .' where start_time >'.$start_time.' AND start_time<'.$end_time.' AND store_id = '.$this->_store_id .' group by store_id , date';
                $statis_info = $this->_statistics_mod->getAll($sql);
                //初始化數組
                $days = ($end_time - $start_time) / (3600 * 24);
                if ($days < 1) {
                    exit;
                }
                for ($day_i = 0; $day_i < $days; $day_i++) {
                    $date = date('Y-m-d', $start_time + $day_i * 3600 * 24);
                    $statistics['time'][$date] = NULL;
                }
                $visit_times = 0;
                $visit_url_count = 0;
                $user_id_count = 0;
                $address_count = 0;
                foreach ($statis_info as $key => $info) {
                    $date = $info['date']; #由於錄入時 ， 沒有確定時區，此處的時區是 main.plugin.php  錄入的時候加了8小時
                    $statistics['time'][$date]['visit_times'] = (int)$info['visit_times'];  #當天的訪問
                    $visit_times += (int)$info['visit_times'];
                    $statistics['time'][$date]['pv'] = (int)$info['pv'];
                    $visit_url_count += (int)$info['pv'];
                    $statistics['time'][$date]['uv'] = (int)$info['uv']+(int)$info['pv'];
                    $user_id_count += (int)$info['uv']+(int)$info['pv'];;
                    $statistics['time'][$date]['ip'] = (int)$info['ip'];
                    $address_count += (int)$info['ip'];
                }
                
                $statistics['total']['visit_times'] = $visit_times;
                $statistics['total']['pv'] = $visit_url_count;
                $statistics['total']['uv'] = $user_id_count;
                $statistics['total']['ip'] = $address_count;
                $statistics['param'] = $param;
                
                
                /*
                //方法二
                $conditions = 'store_id="' . $this->_store_id . '"  AND start_time>' . $start_time . ' AND start_time<' . $end_time;
                $statis_info = $this->_statistics_mod->find(
                        array(
                            'conditions' => $conditions,
                        )
                );

                //初始化數組
                $days = ($end_time - $start_time) / (3600 * 24);
                if ($days < 1) {
                    exit;
                }
                for ($day_i = 0; $day_i < $days; $day_i++) {
                    $date = date('Y-m-d', $start_time + $day_i * 3600 * 24);
                    $statistics['time'][$date] = NULL;
                }

                $visit_times = 0;
                $visit_url = array();
                $visit_url_count = 0;
                $user_id = array();
                $user_id_count = 0;
                $address = array();
                $address_count = 0;
                foreach ($statis_info as $key => $info) {
                    $date = $info['date']; #由於錄入時 ， 沒有確定時區，此處的時區是 main.plugin.php  錄入的時候加了8小時
//                echo date('Y-m-d',$info['start_time'])."<br/>";
                    $statistics['time'][$date]['visit_times'] += $info['visit_times']; #當天的訪問
                    $visit_times += $info['visit_times']; #統計一共訪問次數
                    #店鋪PV  檢查店鋪PV  如果存在不相加
                    if (empty($statistics['time'][$date]['pv']) || !in_array($info['visit_url'], $visit_url)) {
                        $visit_url[] = $info['visit_url'];
                        $statistics['time'][$date]['pv'] +=1;
                        $visit_url_count ++;
                    }

                    #店鋪UV  檢查店鋪UV  如果存在不相加
                    //默認情況下   如果 UV 應該 大於IP  如果   以下如果任意一個滿足 都應該 增長 1  通過 temp_uv 判斷
                    $temp_uv = TRUE;
                    if (empty($statistics['time'][$date]['uv']) || !in_array($info['user_id'], $user_id)) {
                        $user_id[] = $info['user_id'];
                        $statistics['time'][$date]['uv'] +=1;
                        $user_id_count++;
                        $temp_uv = FALSE;
                    }

                    #店鋪IP  檢查店鋪IP  如果存在不相加
                    if (empty($statistics['time'][$date]['ip']) || !in_array($info['ip'], $address)) {
                        $address[] = $info['ip'];
                        $statistics['time'][$date]['ip'] +=1;
                        $address_count++;
                        if($temp_uv){
                            $user_id_count++;
                            $statistics['time'][$date]['uv'] += 1;
                        }
                    }
                }
                $statistics['total']['visit_times'] = $visit_times;
                $statistics['total']['pv'] = $visit_url_count;
                $statistics['total']['uv'] = $user_id_count;
                $statistics['total']['ip'] = $address_count;
                $statistics['param'] = $param;
                 * 
                 */
            } else {
                exit('error_code:#268');
            }

            if (ENABLE_STATISTICS_CACHE) {
                $cache_server->set($statistics_key, $statistics, SEARCH_STATISTICS_TTL);
            }
        }
        return $statistics;
    }
    
    
    function page_ranking() {
        /* 当前用户中心菜单 */
        $this->_curitem('my_statistics');
        /* 当前所处子菜单 */
        if (empty($_GET['type'])) {
            $this->_curmenu('today');
        } else {
            $this->_curmenu($_GET['type']);
        }
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_statistics'));
        $statistics_page_ranking = $this->_get_page_ranking();
        $this->assign('statistics_page_ranking', $statistics_page_ranking);
        $this->display('my_statistics_page_ranking.index.html');
    }
    
    //页面访问获取排行数据
    function _get_page_ranking() {
        $param = $this->_get_query_param();

        $statistics_page_ranking = FALSE;
        if (ENABLE_STATISTICS_CACHE) {
            $cache_server = & cache_server();
            $statistics_key = 'statistics_page_ranking_' . $this->_store_id . var_export($param, true);
            $statistics_page_ranking = $cache_server->get($statistics_key);
        }

        if ($statistics_page_ranking === FALSE) {
            $start_time = mktime(0, 0, 0, $param['st']['m'], $param['st']['d'], $param['st']['Y']);
            $end_time = mktime(0, 0, 0, $param['et']['m'], $param['et']['d'], $param['et']['Y']);

            //判斷時間週期 一天為計算單位(小時為區分點)  多天為計算單位(天數為區分點)
            if (($end_time - $start_time) <= 3600 * 24 * 31) {
                //如果為今日    $start_time ==$end_time
                $end_time = $end_time + 24 * 3600;

                $conditions = 'store_id="' . $this->_store_id . '"  AND start_time>' . $start_time . ' AND start_time<' . $end_time;
//            $conditions = 'start_time>' . $start_time . ' AND end_time<' . $end_time;
                $statis_info = $this->_statistics_mod->find(
                        array(
                            'conditions' => $conditions,
                        )
                );

                if (empty($statis_info))
                    return;
                //统计获取的页面信息
                $statistics_url = array();
                $visit_url = array();
                $visit_url_count = 0;
                $user_id = array();
                $user_id_count = 0;
                $address = array();
                $address_count = 0;
                foreach ($statis_info as $key => $info) {
                    if (empty($info['visit_url'])) {
                        continue;
                    }
                    if (!is_array($user_id[$info['visit_url']])) {
                        $user_id[$info['visit_url']] = array();
                    }
                    if (!is_array($address[$info['visit_url']])) {
                        $address[$info['visit_url']] = array();
                    }
                    //如果不存在
                    if (!in_array($info['visit_url'], $visit_url)) {
                        $visit_url[] = $info['visit_url'];
                        $statistics_url[$info['visit_url']]['vv'] += $info['visit_times'];
                        $visit_url_count += $info['visit_times'];
                    } else {
                        $statistics_url[$info['visit_url']]['vv'] += $info['visit_times'];
                        $visit_url_count += $info['visit_times'];
                    }

                    //默認情況下   如果 UV 應該 大於IP  如果   以下如果任意一個滿足 都應該 增長 1  通過 temp_uv 判斷
                    $temp_uv = TRUE;
                    if (!in_array($info['user_id'], $user_id[$info['visit_url']])) {
                        $user_id[$info['visit_url']][] = $info['user_id'];
                        $statistics_url[$info['visit_url']]['uv'] += 1;
                        $user_id_count++;
                        $temp_uv = FALSE;
                    }

                    if (!in_array($info['address'], $address[$info['visit_url']])) {
                        $address[$info['visit_url']][] = $info['address'];
                        $statistics_url[$info['visit_url']]['ip'] += 1;
                        $address_count++;
                        if($temp_uv){
                            $user_id_count++;
                            $statistics_url[$info['visit_url']]['uv'] += 1;
                        }
                    }
                }
                //排序  按照  访问数量排序
                foreach ($statistics_url as $key => $order_info) {
                    $order_visit_times[$key] = $order_info['vv'];
                }
                array_multisort($order_visit_times, SORT_DESC, $statistics_url);

                $statistics_page_ranking['url'] = $statistics_url;
                $statistics_page_ranking['total']['vv'] = $visit_url_count;
                $statistics_page_ranking['total']['uv'] = $user_id_count;
                $statistics_page_ranking['total']['ip'] = $address_count;
            } else {
                exit('error:#code666');
            }
            if (ENABLE_STATISTICS_CACHE) {
                $cache_server->set($statistics_key, $statistics_page_ranking, SEARCH_STATISTICS_TTL);
            }
        }
        return $statistics_page_ranking;
    }
    
    /**
     *  来访页面排行
     */
    function reffrer_page_ranking() {
        /* 当前用户中心菜单 */
        $this->_curitem('my_statistics');
        /* 当前所处子菜单 */
        if (empty($_GET['type'])) {
            $this->_curmenu('today');
        } else {
            $this->_curmenu($_GET['type']);
        }
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_statistics'));
        $statistics_reffrer_page_ranking = $this->_get_reffrer_page_ranking();
        $this->assign('statistics_reffrer_page_ranking', $statistics_reffrer_page_ranking);
        $this->display('my_statistics_reffrer_page_ranking.index.html');
    }

    function _get_reffrer_page_ranking() {
        $param = $this->_get_query_param();
        $statistics_reffrer_page_ranking = FALSE;
        if (ENABLE_STATISTICS_CACHE) {
            $cache_server = & cache_server();
            $statistics_key = 'statistics_reffrer_page_ranking_' . $this->_store_id . var_export($param, true);
            $statistics_reffrer_page_ranking = $cache_server->get($statistics_key);
        }
        if ($statistics_reffrer_page_ranking === FALSE) {
            $start_time = mktime(0, 0, 0, $param['st']['m'], $param['st']['d'], $param['st']['Y']);
            $end_time = mktime(0, 0, 0, $param['et']['m'], $param['et']['d'], $param['et']['Y']);
            if (($end_time - $start_time) <= 3600 * 24 * 31) {
                $end_time = $end_time + 24 * 3600;
                $conditions = 'store_id="' . $this->_store_id . '"  AND start_time>' . $start_time . ' AND start_time<' . $end_time;
//                $conditions = 'start_time>' . $start_time . ' AND end_time<' . $end_time;
                $statis_info = $this->_statistics_mod->find(
                        array(
                            'conditions' => $conditions,
                        )
                );
                if (empty($statis_info))
                    return;
                //统计获取的页面信息
                $statistics_url = array();
                $reffrer_url = array();
                $user_id = array();
                $address = array();
                foreach ($statis_info as $key => $info) {
                    
                    if (empty($info['reffrer_url'])) {
                        continue;
                    }
                    if (!is_array($user_id[$info['reffrer_url']])) {
                        $user_id[$info['reffrer_url']] = array();
                    }
                    if (!is_array($address[$info['reffrer_url']])) {
                        $address[$info['reffrer_url']] = array();
                    }
                    //如果不存在
                    if (!in_array($info['reffrer_url'], $reffrer_url)) {
                        
                        $reffrer_url[] = $info['reffrer_url'];
                        $statistics_url[$info['reffrer_url']]['vv'] += 1;
                    } else {
                        $statistics_url[$info['reffrer_url']]['vv'] += 1;
                    }
                    
                    //默認情況下   如果 UV 應該 大於IP  如果   以下如果任意一個滿足 都應該 增長 1  通過 temp_uv 判斷
                    $temp_uv = TRUE;
                    if (!in_array($info['user_id'], $user_id[$info['reffrer_url']])) {
                        $user_id[$info['reffrer_url']][] = $info['user_id'];
                        $statistics_url[$info['reffrer_url']]['uv'] += 1;
                        $temp_uv = FALSE;
                    }

                    if (!in_array($info['address'], $address[$info['reffrer_url']])) {
                        $address[$info['reffrer_url']][] = $info['address'];
                        $statistics_url[$info['reffrer_url']]['ip'] += 1;
                        if($temp_uv){
                            $statistics_url[$info['reffrer_url']]['uv'] += 1;
                        }
                    }
                }
                if(empty($statistics_url))
                    return;
                //排序  按照  访问数量排序
                foreach ($statistics_url as $key => $order_info) {
                    $order_visit_times[$key] = $order_info['vv'];
                }
                array_multisort($order_visit_times, SORT_DESC, $statistics_url);
                $statistics_reffrer_page_ranking['url'] = $statistics_url;
            } else {
                exit('error:#code666');
            }
            if (ENABLE_STATISTICS_CACHE) {
                $cache_server->set($statistics_key, $statistics_reffrer_page_ranking, SEARCH_STATISTICS_TTL);
            }
        }
        return $statistics_reffrer_page_ranking;
    }
    
    
    
    function _get_query_param() {
        $res = array();
        //開始日期   同時判斷日期是否合法 ， 不合法 返回當前日期    
        if (isset($_GET['st'])) {
            $st_array = explode('-', trim($_GET['st']));
            if (count($st_array) == 3 && checkdate($st_array[1], $st_array[2], $st_array[0])) {
                
            } else {
                $st_array = explode('-', date('Y-m-d'));
            }
        } else {
            $st_array = explode('-', date('Y-m-d'));
        }
        $res['st']['Y'] = $st_array[0];
        $res['st']['m'] = $st_array[1];
        $res['st']['d'] = $st_array[2];


        //結束日期   同時判斷日期是否合法 ， 不合法 返回當前日期
        if (isset($_GET['et'])) {
            $et_array = explode('-', trim($_GET['et']));
            if (count($et_array) == 3 && checkdate($et_array[1], $et_array[2], $et_array[0])) {
                
            } else {
                $et_array = explode('-', date('Y-m-d'));
            }
        } else {
            $et_array = explode('-', date('Y-m-d'));
        }
        $res['et']['Y'] = $et_array[0];
        $res['et']['m'] = $et_array[1];
        $res['et']['d'] = $et_array[2];

        //獲得數據類型
        switch ($_GET['data_type']) {
            case 'visit_times':
                $res['data_type'] = 'visit_times';
                break;
            case 'pv':
                $res['data_type'] = 'pv';
                break;
            case 'uv':
                $res['data_type'] = 'uv';
                break;
            case 'ip':
                $res['data_type'] = 'ip';
                break;

            default:
                $res['data_type'] = 'pv';
                break;
        }

        return $res;
    }
    
    //三级菜单:
    function _get_member_submenu() {
        //獲取今天、昨天 、 近7天 、 本月 的日期
        $time_data['today']['st'] = $time_data['today']['et'] = $time_data['week']['et'] = $time_data['month']['et'] = date("Y-m-d");
        $time_data['yestoday']['st'] = $time_data['yestoday']['et'] = date("Y-m-d", strtotime("-1 day"));
        $time_data['week']['st'] = date("Y-m-d", strtotime("-1 week"));
        $time_data['month']['st'] = date("Y-m-d", strtotime("-1 month"));
        $this->assign('time_data', $time_data);


        $act = $_GET['act'];
        switch ($act) {
            case 'index':
                $act_url = '&amp;act=index';
                break;
            case 'page_ranking':
                $act_url = '&amp;act=page_ranking';
                break;
            case 'reffrer_page_ranking':
                $act_url = '&amp;act=reffrer_page_ranking';
                break;
            default:
                break;
        }

        $array = array(
            array(
                'name' => 'today',
                'url' => 'index.php?app=my_statistics' . $act_url . '&amp;type=today&amp;st=' . $time_data['today']['st'] . '&amp;et=' . $time_data['today']['et'],
            ),
            array(
                'name' => 'yestoday',
                'url' => 'index.php?app=my_statistics' . $act_url . '&amp;type=yestoday&amp;st=' . $time_data['yestoday']['st'] . '&amp;et=' . $time_data['yestoday']['et'],
            ),
            array(
                'name' => 'week',
                'url' => 'index.php?app=my_statistics' . $act_url . '&amp;type=week&amp;st=' . $time_data['week']['st'] . '&amp;et=' . $time_data['week']['et'],
            ),
            array(
                'name' => 'month',
                'url' => 'index.php?app=my_statistics' . $act_url . '&amp;type=month&amp;st=' . $time_data['month']['st'] . '&amp;et=' . $time_data['month']['et'],
            ),
        );
        return $array;
    }

}

?>