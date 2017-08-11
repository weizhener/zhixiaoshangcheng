<?php

/**
 *    我的数据包控制器
 *
 *    @author    tyioocom
 *    @usage    none
 */
class My_dataecshopApp extends MemberbaseApp
{
	var $_goods_mod;
	var $_dataecshop_mod;
	var $_store_mod;
	var $_goodsimage_mod;
	var $_goodsspec_mod;
	var $_region_mod;
	
    function __construct()
    {
        $this->My_dataecshopApp();
    }
    function My_dataecshopApp()
    {
        parent::__construct();
		$this->_goods_mod = &m('goods');
		$this->_dataecshop_mod = &m('dataecshop');
		$this->_store_mod = &m('store');
		$this->_goodsimage_mod = &m('goodsimage');
		$this->_goodsspec_mod = &m('goodsspec');
		$this->_region_mod = &m('region');
	}
    function index()
    {
        $page   =   $this->_get_page(10);
		$dataecshop_goods = $this->_dataecshop_mod->find(array(
            'fields'=> '',
            'conditions' => 'user_id = ' . $this->visitor->get('user_id'),
            'count' => true,
            'order' => 'add_time DESC',
            'limit' => $page['limit'],
        ));
		
		if($dataecshop_goods)
		{
			foreach($dataecshop_goods as $key=>$goods){
				$goods = $this->_goods_mod->get(array(
					'conditions'=>'g.goods_id='.$goods['goods_id'],
					'join'=>'belongs_to_store,has_default_spec',
					'fields'=>'g.goods_name,g.price,g.default_image,store.store_name,store.store_id,goodsspec.price,goodsspec.spec_id',
				));
				empty($goods['default_image']) && $goods['default_image'] = Conf::get('default_goods_image');
				$dataecshop_goods[$key] +=$goods;
			}
		}

        $page['item_count'] = $this->_dataecshop_mod->getCount();
        $this->_format_page($page);
        $this->assign('dataecshop_goods', $dataecshop_goods);
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                            LANG::get('my_dataecshop'), 'index.php?app=my_dataecshop',
                            LANG::get('dataecshop_goods'));

        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));

        //当前用户中心菜单项
        $this->_curitem('my_dataecshop');

        $this->_curmenu('dataecshop_goods');
        $this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('dataecshop_goods'));
        $this->display('my_dataecshop.index.html');
    }
	function store()
	{
		/* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                            LANG::get('my_dataecshop'), 'index.php?app=my_dataecshop',
                            LANG::get('create_store_all'));
							
		//当前用户中心菜单项
        $this->_curitem('my_dataecshop');

        $this->_curmenu('create_store_all');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('create_store_all'));
        $this->display('my_dataecshop.form.html');
	}
	function create()
	{
		import('phpzip.lib');
		$zip = new PHPZip;
		
		$lang_taobao = array(
			'title' => '宝贝名称',
    		'cid' => '宝贝类目',
    		'seller_cids' => '店铺类目',
    		'stuff_status' => '新旧程度',
    		'location_state' => '省',
    		'location_city' => '城市',
    		'item_type' => '出售方式',
    		'price' => '宝贝价格',
    		'auction_increment' => '加价幅度',
    		'num' => '宝贝数量',
    		'valid_thru' => '有效期',
    		'freight_payer' => '运费承担',
    		'post_fee' => '平邮',
    		'ems_fee' => 'EMS',
    		'express_fee' => '快递',
			'has_invoice' => '发票',
			'has_warranty' => '保修',
			'approve_status' => '放入仓库',
			'has_showcase' => '橱窗推荐',
			'list_time'=>'开始时间',
			'description' => '宝贝描述',
			'cateProps' => '宝贝属性',
			'postage_id' => '邮费模版ID',
			'has_discount' => '会员打折',
			'modified' => '修改时间',
			'upload_fail_msg' => '上传状态',
			'picture_status' => '图片状态',
			'auction_point' => '返点比例',
			'picture' => '新图片',
			'video' => '视频',
			'skuProps' => '销售属性组合',
			'inputPids' => '用户输入ID串',
			'inputValues' => '用户输入名-值对',
			'outer_id' => '商家编码',
			'propAlias' => '销售属性别名',
			'auto_fill' => '代充类型',
			'num_id' => '数字ID',
			'local_cid'=>'本地ID',// add
			'navigation_type'=>'宝贝分类',//add
			'user_name'=>'账户名称', // add
			'syncStatus'=>'宝贝状态',// add
			'is_lighting_consigment'=>'闪电发货',// add
			'is_xinpin'=>'新品',// add
			'foodparame'=>'食品专项',// add
			'features'=>'尺码库', // add
			
			// tyioocom
			'brand'=>'品牌',
			'tags'=>'商品标签',
			'market_price'=>'市场价',
			
		);
		
		/* csv文件数组 */
		$goods_value = array();
		foreach($lang_taobao as $key=>$val)
		{
			$goods_value[$key] = '';
		}
		
		/* 赋初始值 */
		$goods_value['cid'] = 50008901; // 对应淘宝分类： 女装/女士精品/风衣
		$goods_value['seller_cids'] = 0;
		$goods_value['stuff_status'] = 0;
		$goods_value['item_type'] = 1;
		$goods_value['valid_thru'] = 7;
		$goods_value['auction_increment'] = 0;
		$goods_value['freight_payer'] = 1;
		$goods_value['post_fee'] = 10;
		$goods_value['ems_fee']  = 20;
		$goods_value['express_fee'] = 15;
		$goods_value['has_invoice'] = 0;
		$goods_value['has_warranty'] = 0;
		$goods_value['approve_status'] = 0;
		$goods_value['postage_id'] = 0;
		$goods_value['has_discount'] = 0;
		$goods_value['upload_fail_msg'] = 100;
		
    	$content = implode("\t", $lang_taobao) . "\n";
		$folder = 'goods_'.date('Ymdhis', time());
		
		if($_GET['goods_id'])
		{
			$goods_ids = trim($_GET['goods_id']);
			$goods_ids = explode(',', $goods_ids);
		
			$conditions = ' AND goods_id IN('.implode(',',$goods_ids).')';
		
			$goods_list = $this->_goods_mod->find(array(
				'conditions'=>'if_show=1 and closed=0 '. $conditions,
			));
		}
		elseif($_GET['goods']=='dp_all') 
		{
			$goods_list = $this->_dataecshop_mod->find(array('conditions'=>'user_id = ' . $this->visitor->get('user_id')));
			if($goods_list)
			{
				foreach($goods_list as $key=>$val)
				{
					$goods_list[$key] = $this->_goods_mod->get($val['goods_id']);
				}
			}
		}
		else
		{
			$goods_list = $this->_goods_mod->find(array('conditions'=>'store_id = ' . $this->visitor->get('user_id')));		
		}
		
		foreach($goods_list as $key=>$goods)
    	{
			$goods_value['title'] = '"' . $goods['goods_name'] . '"';
        	$goods_value['price'] = $goods['price'];
        	$goods_value['num'] = $this->_get_goods_num($goods['goods_id']);
			
			$location = $this->_get_location($goods['store_id']);
			$goods_value['location_state'] = $location[1];
			$goods_value['location_city']  = $location[2];
       	 	$goods_value['description'] = $this->replace_special_char($goods['description']);
			$goods_value['picture'] = $this->_compress_picture($zip, $goods['goods_id'], $folder);
			$goods_value['has_showcase'] = $goods['recommended'];
			$goods_value['modified'] = date('Y:m:d h:i:s', $goods['last_update']);
			$goods_value['outer_id'] = $this->_get_goods_outer_id($goods['default_spec']);
			
			// tyioocom
			$goods_value['brand'] = $goods['brand'];
			$goods_value['tags']  = $goods['tags'];			
			$goods_value['skuProps'] = $this->_get_goods_spec_for_csv($goods['goods_id']);
			$goods_value['market_price'] = $goods['mkprice'];
        	
        	$content .= implode("\t", $goods_value) . "\n";
    	}

   	 	if (CHARSET != 'utf-8')
    	{
        	$content = ecm_iconv(CHARSET, 'utf-8', $content);
   		}
		$zip->add_file("\xFF\xFE" . $this->utf82u2($content), $folder.'.csv');

    	header("Content-Disposition: attachment; filename=".$folder.".zip");
    	header("Content-Type: application/unknown");
    	die($zip->file());
	}
	function _get_goods_spec_for_csv($goods_id)
	{
		if(!$goods_id){
			return '';
		}
		
		$data = array('prop_type'=>'ecmall','spec_qty'=>0,'spec_name_1'=>'', 'spec_name_2'=>'', 'item'=>array());
		
		$goods = $this->_goods_mod->get(array('conditions'=>'goods_id='.$goods_id,'fields'=>'spec_qty,spec_name_1,spec_name_2'));
		$data = array_merge($data, $goods);
		
		$goods_spec = $this->_goodsspec_mod->find(array('conditions'=>'goods_id='.$goods_id,'fields'=>''));
		
		if($goods_spec)
		{
			if(count($goods_spec)==1)
			{
				$goods_spec_first = current($goods_spec);
				if(empty($goods_spec_first['spec_1']) && empty($goods_spec_first['spec_2'])){
					return '';
				}
			}
			
			$data['item'] = $goods_spec;
			foreach($goods_spec as $key=>$val)
			{
				unset($data['item'][$key]['spec_id']);
			}
		}
		return json_encode($data);
	}
	
	
	function _get_location($store_id)
	{
		if(!$store_id){
			return '';
		}
		$store = $this->_store_mod->get(array(
			'conditions'=>'store_id='.$store_id,
			'fields'=>'region_id',
		));
		$region = $this->_region_mod->get($store['region_id']);
		
		$str = '';
		while($region['parent_id']!=0)
		{
			$parent_id = $region['parent_id'];
			$str = ','.$region['region_name'] . $str;
			$region = $this->_region_mod->get(array('conditions'=>'region_id='.$parent_id,'fields'=>'region_name,region_id,parent_id'));
		}
		$str = $region['region_name'] . $str;
		$location_arr = explode(',', $str);
		
		/* 格式化地区名称，处理直辖市等情况，使之与淘宝的地区一致 */
		$location_arr[1] = str_replace('省','', $location_arr[1]);
		$location_arr[1] = str_replace('市','', $location_arr[1]);
		$location_arr[2] = str_replace('市','', $location_arr[2]);
		
		if($location_arr[1] == '北京'){
			$location_arr[1] =  $location_arr[2] = '北京';
		} else if($location_arr[1] == '上海'){
			if($location_arr[2] == '崇明' || $location_arr[2] == '朱家角'){
				$location_arr[1] = '上海';
			} else {
				$location_arr[1] =  $location_arr[2] = '上海';
			}
		}elseif($location_arr[1] == '重庆'){
			$location_arr[1] =  $location_arr[2] = '重庆';
		}
		elseif($location_arr[1] == '天津'){
			$location_arr[1] =  $location_arr[2] = '天津';
		}
		elseif($location_arr[1] == '内蒙古自治区'){
			$location_arr[1] = '内蒙古';
		}
		elseif($location_arr[1] == '广西壮族自治区'){
			$location_arr[1] = '广西';
		}
		elseif($location_arr[1] == '西藏自治区'){
			$location_arr[1] =  '西藏';
		}
		
		elseif($location_arr[1] == '宁夏回族自治区'){
			$location_arr[1] = '宁夏';
		}
		
		elseif($location_arr[1] == '新疆维吾尔自治区'){
			$location_arr[1] = '新疆';
		}
		elseif($location_arr[1] == '香港特别行政区'){
			if($location_arr[2] == '九龙' ||  $location_arr[2] == '新界'){
				$location_arr[1] = '香港';
			} else {
				$location_arr[1] =  $location_arr[2] = '香港';
			}
		}
		elseif($location_arr[1] == '澳门特别行政区'){
			$location_arr[1] =  $location_arr[2] = '澳门';
		}

		unset($location_arr[0]);// 去掉中国
		return $location_arr;	
	}
	function _get_goods_outer_id($spec_id)
	{
		if(!$spec_id){
			return '';
		}
		$goodsspec = $this->_goodsspec_mod->get(array(
			'conditions'=>'spec_id='.$spec_id,
			'fields'=>'sku'
		));
		return $goodsspec['sku'];
	}
	function _get_goods_num($goods_id)
	{
		$stocks = 0;
		if(!$goods_id){
			return $stocks;
		}
		$goodsspec = $this->_goodsspec_mod->find(array(
			'conditions'=>'goods_id='.$goods_id,
			'fields'=>'stock'
		));
		foreach($goodsspec as $spec)
		{
			$stocks += $spec['stock'];
		}
		return $stocks;
	}
	
	/* 压缩图片 */
	function _compress_picture($zip,$goods_id=0,$folder='')
	{
		if(!$goods_id){
			return '';
		}
		
		$goodsimage = $this->_goodsimage_mod->find(array(
			'conditions'=>'goods_id='.$goods_id,
			'fields'=>'thumbnail,image_url',
			'order'=>'image_id',
			'limit'=> 5 //  淘宝宝贝图片和主图只读取5张
		));
		
		$picture_string = '"';
		$i = 0;
		foreach($goodsimage as $image)
		{
			//$image_url = $image['image_url']; big
			$image_url = $image['thumbnail']; // small
			
			$picture_name = '';
			if (!empty($image_url) && is_file(ROOT_PATH . "/" . $image_url))
        	{
				$image_arr = explode('/', $image_url);
            	$picture = preg_replace("/(.gif|.jpg|.jpeg|.png)$/", "\${2}.tbi", end($image_arr));
            	
				@copy(ROOT_PATH . "/" . $image_url, ROOT_PATH ."/temp/" . $picture);
				
            	if(is_file(ROOT_PATH . "/temp/". $picture))
            	{
					$picture_name = md5($picture);
                 	$zip->add_file(file_get_contents(ROOT_PATH . "/temp/". $picture), $folder . '/' . $picture_name . '.tbi');
                 	unlink(ROOT_PATH . "/temp/".$picture);
            	}
        	}
       	 	
        	if(!empty($picture_name))
        	{
            	$picture = str_ireplace('/','\\',$picture,$picture);
            	$picture = str_ireplace('.tbi','',$picture,$picture);
           		//$goods_value['picture'] = '"' . $goods['picture'] . ':0:0:|;'.'"';
				$picture_string .= $picture_name . ':0:'.($i++).':|;';
        	}
		}
		$picture_string .='"';
		
		return $picture_string;
	}
	
    function add()
    {
        $goods_id = empty($_GET['goods_id'])  ? 0 : intval($_GET['goods_id']);
        if (!$goods_id)
        {
            $this->show_warning('no_such_goods');

            return;
        }
        $this->_add_dataecshop($goods_id);
    }
    /**
     *    删除项目
     */
    function drop()
    {
        $goods_ids = empty($_GET['goods_id'])  ? 0 : trim($_GET['goods_id']);
        if (!$goods_ids)
        {
            $this->show_warning('no_such_goods');

            return;
        }
		$goods_ids = explode(',', $goods_ids);
        $this->_dataecshop_mod->drop($goods_ids);
		$this->show_message('drop_dataecshop_goods_successed');
    }

   
    /**
     *    加入数据包
     */
    function _add_dataecshop($goods_id)
    {
        /* 验证商品是否存在 */
        $goods_info  = $this->_goods_mod->get($goods_id);

        if (empty($goods_info))
        {
            /* 商品不存在 */
            $this->json_error('no_such_goods');
            return;
        }
		
		/* 加入到数据包 */
		$dataecshop = $this->_dataecshop_mod->get(array(
			'conditions'=>'goods_id='.$goods_id.' and user_id='.$this->visitor->get('user_id'),
			'fields'=>'user_id'
		));
		if(empty($dataecshop))
		{
			$data = array(
				'user_id'=> $this->visitor->get('user_id'),
				'goods_id'=> $goods_id,
				'add_time'=> time()
			);
			$this->_dataecshop_mod->add($data);
		}

        $goods_image = $goods_info['default_image'] ? $goods_info['default_image'] : Conf::get('default_goods_image');
        $goods_url  = SITE_URL . '/' . url('app=goods&id=' . $goods_id);
        $this->send_feed('add_dataecshop_goods', array(
            'user_id'   => $this->visitor->get('user_id'),
            'user_name'   => $this->visitor->get('user_name'),
            'goods_url'   => $goods_url,
            'goods_name'   => $goods_info['goods_name'],
            'images'    => array(array(
                'url' => SITE_URL . '/' . $goods_image,
                'link' => $goods_url,
            )),
        ));

        /* 加入成功 */
        $this->json_result('', 'add_dataecshop_goods_ok');
    }
	
    function _get_member_submenu()
    {
        $menus = array(
            array(
                'name'  => 'dataecshop_goods',
                'url'   => 'index.php?app=my_dataecshop',
            ),
			array(
				'name' => 'create_store_all',
				'url'  => 'index.php?app=my_dataecshop&act=store',
			),
        );
        return $menus;
    }
	
	function replace_special_char($str, $replace = true)
	{
    	$str = str_replace("\r\n", "", $this->image_path_format($str));
    	$str = str_replace("\t", "    ", $str);
    	$str = str_replace("\n", "", $str);
    	if ($replace == true)
    	{
        	$str = '"' . str_replace('"', '""', $str) . '"';
    	}
    	return $str;
	}

	function image_path_format($content)
	{
    	$prefix = 'http://' . $_SERVER['SERVER_NAME'];
    	$pattern = '/(background|src)=[\'|\"]((?!http:\/\/).*?)[\'|\"]/i';
    	$replace = "$1='" . $prefix . "$2'";
    	return preg_replace($pattern, $replace, $content);
	}


	function utf82u2($str)
	{
    	$len = strlen($str);
    	$start = 0;
    	$result = '';

   		if ($len == 0)
    	{
        	return $result;
    	}

    	while ($start < $len)
    	{
        	$num = ord($str{$start});
        	if ($num < 127)
        	{
            	$result .= chr($num) . chr($num >> 8);
            	$start += 1;
       	 	}
        	else
        	{
            	if ($num < 192)
            	{
                	/* 无效字节 */
                	$start ++;
            	}
            	elseif ($num < 224)
            	{
                	if ($start + 1 <  $len)
                	{
                    	$num = (ord($str{$start}) & 0x3f) << 6;
                    	$num += ord($str{$start+1}) & 0x3f;
                    	$result .=   chr($num & 0xff) . chr($num >> 8) ;
                	}
                	$start += 2;
            	}
            	elseif ($num < 240)
            	{
                	if ($start + 2 <  $len)
                	{
                   	 	$num = (ord($str{$start}) & 0x1f) << 12;
                    	$num += (ord($str{$start+1}) & 0x3f) << 6;
                    	$num += ord($str{$start+2}) & 0x3f;

                    	$result .=   chr($num & 0xff) . chr($num >> 8) ;
               	 	}
                	$start += 3;
            	}
            	elseif ($num < 248)
            	{

                	if ($start + 3 <  $len)
                	{
                    	$num = (ord($str{$start}) & 0x0f) << 18;
                    	$num += (ord($str{$start+1}) & 0x3f) << 12;
                    	$num += (ord($str{$start+2}) & 0x3f) << 6;
                    	$num += ord($str{$start+3}) & 0x3f;
                    	$result .= chr($num & 0xff) . chr($num >> 8) . chr($num >>16);
                	}
                	$start += 4;
            	}
            	elseif ($num < 252)
            	{
                	if ($start + 4 <  $len)
                	{
                    	/* 不做处理 */
                	}
                	$start += 5;
            	}
            	else
            	{
                	if ($start + 5 <  $len)
                	{
                    	/* 不做处理 */
                	}
                	$start += 6;
            	}
        	}

    	}
    	return $result;
	}
}

?>
