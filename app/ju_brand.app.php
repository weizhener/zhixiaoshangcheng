<?php

class Ju_brandApp extends MallbaseApp
{	
	var $_jutemplate_mod;
	var $_jucate_mod;
	var $_ju_mod;
	var $_jubrand_mod;
	
    function __construct()
    {
        $this->Ju_brandApp();
    }

    function Ju_brandApp()
    {
        parent::__construct();
		$this->_jutemplate_mod =&m('jutemplate');
		$this->_jucate_mod =&m('jucate');
		$this->_ju_mod =&m('ju');
		$this->_jubrand_mod = &m('jubrand');
		
    }

    function index()
    {
		$conditions = '';
		$brand_id = isset($_GET['brand_id']) ? trim($_GET['brand_id']) : '';
		if($brand_id)
		{
			$conditions = " AND ju.brand_id = ".$brand_id;
		}
		$tempalte = $this->_jutemplate_mod->get('channel=2 AND state=1');
		
		if($tempalte)
		{
			$ju_list = $this->_ju_mod->find(array(
				'join' => 'belong_goods',
				'conditions' => 'template_id='.$tempalte['template_id'].' AND ju.status=1' . $conditions,
				'order' => 'ju.group_id DESC',
				'fields'=>'this.*,g.goods_id,g.goods_name,g.store_id,g.default_spec,g.price,g.default_image',
			));
		
			import('init.lib');
			$init = new Init_Ju_brandApp();
			$ju_list = $init->format_ju_list($ju_list, $this->_ju_mod);
		}
		$brands = $this->_jubrand_mod->find(array(
			'conditions' => 'if_show=1'
		));
		$brand_tags = array();
		foreach($brands as $key => $brand)
		{
			$brand_tags[$key] = $brand['tag'];
		}
		$brand_tags_unique = array_unique($brand_tags);
		$brand_tags_count = array_count_values($brand_tags);
		foreach($brand_tags_unique as $key1 => $val)
		{
			$brands_arr[$key1]['count'] = $brand_tags_count[$val];
			$brands_arr[$key1]['tag'] = $val;
			$brands_arr[$key1]['brands'] = $this->_jubrand_mod->find(array(
				'conditions' => "if_show=1 and tag='".$val."'"
			));
		}
		$this->assign('brands_arr',$brands_arr);//获得品牌分类、品牌个数、品牌
		$this->assign('brands_allcount',count($brands));//所有品牌个数
		$this->assign('brands_all',$brands);
		$cate_list = $this->_list_category();
		$this->assign('cate_list',$cate_list);
        $this->_config_seo('title', Lang::get('ju_brand') . ' - ' . Conf::get('site_title'));
		$this->import_resource(array('style' =>array(array('path'=>'res:css/ju.css'))));
		$this->assign('ju_list',$ju_list);
		//$this->assign('page_info', $page);
        $this->display("ju.brand.html");
    }

	function _list_category()
    {
        $cache_server =& cache_server();
        $key = 'page_ju_category';
        $data = $cache_server->get($key);
        if ($data === false)
        {
            $categories = $this->_jucate_mod->find(array(
				'conditions' => "if_show = 1 and parent_id = '0' and channel in (1,5)",
			));
			$categories1 = array();
			foreach($categories as $categorie)
			{
				$categories1 += $this->_jucate_mod->find(array(
					'conditions' => "if_show = 1 and parent_id = ".$categorie['cate_id'],
				));
			}
            import('tree.lib');
            $tree = new Tree();
            $tree->setTree(array_merge($categories,$categories1), 'cate_id', 'parent_id', 'cate_name');
            $data = $tree->getArrayList(0);

            $cache_server->set($key, $data, 3600);
        }

        return $data;
    }
}

?>
