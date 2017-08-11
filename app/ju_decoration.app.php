<?php

class Ju_decorationApp extends MallbaseApp
{	
	var $_jucate_mod;
	var $_jutemplate_mod;
	
    function __construct()
    {
        $this->Ju_decorationApp();
    }

    function Ju_decorationApp()
    {
        parent::__construct();
		$this->_jucate_mod =&m('jucate');	
		$this->_jutemplate_mod =&m('jutemplate');	
    }

    function index()
    {
		
		$cate_list = $this->_list_category();
		$this->assign('cate_list',$cate_list);
		$template = $this->_jutemplate_mod->get("channel=4 and state=1");
		import('init.lib');
		$init = new Init_Ju_decorationApp();
		$this->assign('lefttime',$init->lefttime($template['end_time']));
        $this->_config_seo('title', Lang::get('ju_decoration') . ' - ' . Conf::get('site_title'));
		$this->import_resource(array('style' =>array(array('path'=>'res:css/ju.css'))));
        $this->display("ju.decoration.html");
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
