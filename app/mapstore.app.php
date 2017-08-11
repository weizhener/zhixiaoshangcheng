<?php

class MapstoreApp extends MallbaseApp {

    var $lng;
    var $lat;
    var $baidu_ak;

    function __construct() {
        $this->MapstoreApp();
    }

    function MapstoreApp() {
        parent::__construct();


        $this->baidu_ak = Conf::get('baidu_ak');
        if (empty($this->baidu_ak)) {
            $this->show_warning('商城未设置百度地图密钥');
            exit;
        }

        if ($_GET['lat'] && $_GET['lng']) {
            $_SESSION['lat'] = $_GET['lat'];
            $_SESSION['lng'] = $_GET['lng'];
        }

        $this->lng = $_SESSION['lng'];
        $this->lat = $_SESSION['lat'];
        if (empty($this->lng) || empty($this->lat)) {
            //根据用户当前的IP 获取 经纬度
            $location = $this->get_ip_location();
            $this->lng = $location['lng'];
            $this->lat = $location['lat'];
        }
    }

    function index() {

        //获取店铺店铺分类
        $scategory_mod = & m('scategory');
        $scate_id = empty($_GET['scate_id']) ? 0 : intval($_GET['scate_id']);
        $this->assign('scate_id', $scate_id);


        $cache_server = & cache_server();
        $key = 'page_mapstore_'.$scate_id;
        $data = $cache_server->get($key);
        if ($data === false) {
            //获取当前分类下的子分类用于显示 
            //方式1
//        $scategorys = $scategory_mod->find('parent_id=0'); #此处标示当前分类的下级
            //方式2 BEGIN
            $scategorys = $scategory_mod->get_list(-1); #此处获得的为所有店铺分类
            import('tree.lib');
            $tree = new Tree();
            $tree->setTree($scategorys, 'cate_id', 'parent_id', 'cate_name');
            $data['scategorys'] = $tree->getArrayList(0);
            
            if ($scate_id > 0) {
                $scategory_info = $scategory_mod->get($scate_id);
                $top_id = $scategory_info['parent_id'];
                if ($top_id == 0) {
                    $top_id = $scate_id;
                }
                $data['top_id'] = $top_id;
                
            }
            //END
            /* 取得该分类及子分类cate_id */
            $scate_ids = array();
            $condition_id = '';
            if ($scate_id > 0) {
                $scate_ids = $scategory_mod->get_descendant($scate_id);
                /* 店铺分类检索条件 */
                $condition_id = implode(',', $scate_ids);
                $condition_id && $condition_id = ' AND cate_id IN(' . $condition_id . ')';
            }
            $data['condition_id'] = $condition_id;
            $cache_server->set($key, $data, 3600);
        }

        $this->assign('scategorys', $data['scategorys']);
        $this->assign('top_id', $data['top_id']);
        $condition_id = $data['condition_id'];



        if (in_array($_GET['order'], array('add_time', 'sgrade', 'credit_value', 'juli'))) {
            if ($_GET['order'] == 'juli') {
                $order = $_GET['order'] . " asc";
            } else {
                $order = $_GET['order'] . " desc";
            }
        } else {
            $order = "juli asc";
        }

        //条件是 10KM 之内的
        $conditions = ' AND (2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $this->lat . '-lat)/360),2)+COS(PI()*' . $this->lat . '/180)* COS(lat * PI()/180)*POW(SIN(PI()*(' . $this->lng . '-lng)/360),2)))) < 10000';


        $store_mod = & m('store');
        $stores = $store_mod->find(
                array(
                    'conditions' => 'state = ' . STORE_OPEN . $condition_id . $conditions,
                    'fields' => 'this.* ,(2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $this->lat . '-lat)/360),2)+COS(PI()*' . $this->lat . '/180)* COS(lat * PI()/180)*POW(SIN(PI()*(' . $this->lng . '-lng)/360),2)))) as juli ',
                    'limit' => 30,
                    'order' => $order,
                    'join' => 'has_scategory',
                )
        );
        $model_goods = &m('goods');
        foreach ($stores as $key => $store) {
            //店铺logo
            empty($store['store_logo']) && $stores[$key]['store_logo'] = Conf::get('default_store_logo');
            //商品数量
            $stores[$key]['goods_count'] = $model_goods->get_count_of_store($store['store_id']);
            $stores[$key]['juli'] = round($store['juli'], 2);
        }
        
        
        
        $this->assign('stores', $stores);
        $this->assign('baidu_ak', $this->baidu_ak);
        $this->display('mapstore.index.html');
    }

    function address() {

        $this->assign('lng', $this->lng);
        $this->assign('lat', $this->lat);
        $this->assign('baidu_ak', $this->baidu_ak);
        $this->display('mapstore.address.html');
    }

    function ajax_get_stores_by_position() {
        //根据经纬度获取当前的街道
        $url = "http://api.map.baidu.com/geocoder/v2/?ak=" . $this->baidu_ak . "&callback=renderReverse&location=" . $this->lat . "," . $this->lng . "&output=xml&pois=1";

//        $content = file_get_contents($url);
        $content = $this->curl_get_contents($url);
		$content = preg_replace('/&/','&amp;',  $content);
        $result = simplexml_load_string($content);
        $data['region_addr'] = (string) $result->result->formatted_address;

        //查询出附近10 KM 有多少店铺
        $store_mod = & m('store');
        $conditions = ' AND (2 * 6378.137* ASIN(SQRT(POW(SIN(PI()*(' . $this->lat . '-lat)/360),2)+COS(PI()*' . $this->lat . '/180)* COS(lat * PI()/180)*POW(SIN(PI()*(' . $this->lng . '-lng)/360),2)))) < 10000';
        $sql = "SELECT COUNT(*) FROM {$store_mod->table} WHERE state = '" . STORE_OPEN . "' {$conditions}";
        $data['store_num'] = $store_mod->getOne($sql);
        $this->json_result($data);
    }

    function curl_get_contents($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);            //设置访问的url地址   
        //curl_setopt($ch,CURLOPT_HEADER,1);            //是否显示头部信息   
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);           //设置超时   
        curl_setopt($ch, CURLOPT_USERAGENT, _USERAGENT_);   //用户访问代理 User-Agent   
        curl_setopt($ch, CURLOPT_REFERER, _REFERER_);        //设置 referer   
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);      //跟踪301   
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);        //返回结果   
        $content = curl_exec($ch);
        curl_close($ch);
        return $content;
    }
    
    function view()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $store_mod = & m('store');
        $this->assign('store', $store_mod->get($id));
        $this->assign('baidu_ak', $this->baidu_ak);
        $this->display('mapstore.view.html');
    }
	
    function store() {
        $this->assign('lng', $this->lng);
        $this->assign('lat', $this->lat);
        $this->assign('baidu_ak', $this->baidu_ak);
        $this->display('mapstore.store.html');
    }

    function ajax_get_stores_list_by_position() {
        $store_mod = & m('store');
        $stores = $store_mod->find();
        $this->json_result(array_values($stores));
    }
    

}

?>