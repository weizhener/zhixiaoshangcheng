<?php
class SdemandApp extends MallbaseApp
{

    var $_sdinfo_mod;
    var $_sdcategory_mod;
    var $_cate_ids; //当前分类及子孙分类cate_id
    function __construct()
    {
        $this->Sdemand();
    }
    function Sdemand()
    {
        parent::__construct();
        $this->_sdinfo_mod = &m('sdinfo');
        $this->_sdcategory_mod = &m('sdcategory');
    }
    function index()
    {
       /* 处理cate_id */
        $cate_id = !empty($_GET['cate_id'])? intval($_GET['cate_id']) : 0;
		$title = !empty($_GET['title'])? trim($_GET['title']) : '';
		$search_type = !empty($_GET['type'])? intval($_GET['type']) : '';
        if ($cate_id > 0) //取得该分类及子分类cate_id
        {
            $cate_ids = $this->_sdcategory_mod->get_descendant($cate_id);
            if (!$cate_ids)
            {
                $this->show_warning('no_data');
                return;
            }
        }
        $conditions='';
        !empty($cate_ids)&& $conditions .= ' AND cate_id ' . db_create_in($cate_ids);
		!empty($title)&& $conditions .= " AND title LIKE '%".$title."%'";
		!empty($search_type)&& $conditions .= ' AND type= '.$search_type;

        $page   =   $this->_get_page(10);   //获取分页信息
        $infos = $this->_sdinfo_mod->find(array(
			'conditions'  => "verify = 1".$conditions,
			'limit'   => $page['limit'],
			'order'   => 'sort_order ASC,add_time DESC', //必须加别名
			'count'   => true   //允许统计
        ));
        $page['item_count']=$this->_sdinfo_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('infos', $infos);
		$type = array(
            1 => Lang::get('supply'),
            2 => Lang::get('demand'),
        );
		$this->assign('type', $type);
		/* 文章分类 */
        $acategories = $this->_get_acategory($cate_id);
		$this->assign('acategories', $acategories);
		/* 新文章 */
        $new = $this->_get_article('new');
        $new_articles = $new['articles'];
        $this->assign('new_articles', $new_articles);
		/* 当前位置 */
        $curlocal = $this->_get_curlocal($cate_id);
        unset($curlocal[count($curlocal)-1]['url']);
        print_r($this->_curlocal($curlocal));
		$this->_config_seo('title', Lang::get('supply_demand') . ' - ' . Conf::get('site_title'));
        $this->display('sdemand.index.html');
    }

    function view()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $cate_ids = array();
        if ($id>0)
        {
            $article = $this->_sdinfo_mod->get('id=' . $id . ' AND verify=1');
            if (!$article)
            {
                $this->show_warning('no_such_article');
                return;
            }
            /* 上一篇下一篇 */
            $pre_article = $this->_sdinfo_mod->get('id<' . $id . ' AND verify=1 ORDER BY id DESC limit 1');
            $next_article = $this->_sdinfo_mod->get('id>' . $id . ' AND verify=1 ORDER BY id ASC limit 1');
            if ($article)
            {
                $cate_id = $article['cate_id'];
                /* 取得当前分类及子孙分类cate_id */
                $cate_ids = $this->_sdcategory_mod->get_descendant($cate_id);
            }
            else
            {
                $this->show_warning('no_such_article');
                return;
            }
        }
        else
        {
            $this->show_warning('no_such_article');
            return;
        }
		
        $this->_sdinfo_mod->edit($id, "views = views + 1");//更新浏览数

        $this->_cate_ids = $cate_ids;
        /* 当前位置 */
        $curlocal = $this->_get_curlocal($cate_id);
        $curlocal[] =array('text' => Lang::get('content'));
        $this->_curlocal($curlocal);
        /*文章分类*/
        $acategories = $this->_get_acategory($cate_id);
        /* 新文章 */
        $new = $this->_get_article('new');
        $new_articles = $new['articles'];
        $this->assign('article', $article);
        $this->assign('pre_article', $pre_article);
        $this->assign('next_article', $next_article);
        $this->assign('new_articles', $new_articles);
        $this->assign('acategories', $acategories);
        $this->_config_seo('title', $article['title'] . ' - ' . Conf::get('site_title'));
        $this->display('sdemand.view.html');
    }

    function _get_curlocal($cate_id)
    {
		$curlocal[] = array('text' => Lang::get('all_cate'), 'url' => 'index.php?app=sdemand');
        $parents = array();
        if ($cate_id)
        {
            $this->_sdcategory_mod->get_parents($parents, $cate_id);
        }
        foreach ($parents as $category)
        {
            $curlocal[] = array('text' => $category['cate_name'], 'url' => 'index.php?app=sdemand&amp;cate_id=' . $category['cate_id']);
        }
        return $curlocal;
    }
    function _get_article($type='')
    {
        $conditions = '';
        $per = '';
        switch ($type)
        {
            case 'new' : $sort_order = 'add_time DESC,sort_order ASC';
            $per=5;
            break;
            case 'all' : $sort_order = 'sort_order ASC,add_time DESC';
            $per=10;
            break;
        }
        $page = $this->_get_page($per);   //获取分页信息
        !empty($this->_cate_ids)&& $conditions = ' AND cate_id ' . db_create_in($this->_cate_ids);
        $articles = $this->_sdinfo_mod->find(array(
            'conditions'  => 'verify=1' . $conditions,
            'limit'   => $page['limit'],
            'order'   => $sort_order,
            'count'   => true   //允许统计
        ));
        $page['item_count'] = $this->_sdinfo_mod->getCount();
        return array('page'=>$page, 'articles'=>$articles);
    }
	
	function _get_acategory($cate_id)
    {
        $acategories = $this->_sdcategory_mod->get_list($cate_id);
        if ($acategories){
            return $acategories;
        }
        else
        {
            $parent = $this->_sdcategory_mod->get($cate_id);
            if (isset($parent['parent_id']))
            {
                return $this->_get_acategory($parent['parent_id']);
            }
        }
    }
}

?>
