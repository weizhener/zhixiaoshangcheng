<?php

class My_recommendApp extends StoreadminbaseApp
{
    var $_recommend_mod;

    function __construct()
    {
        $this->My_recommendApp();
    }

    function My_recommendApp()
    {
        parent::__construct();
		$this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_recommend_mod =& bm('recommend', array('_store_id' => $this->_store_id));
    }

    function index()
    {
		$filtered = '';
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'recom_name',
                'equal' => 'LIKE',
            ),
        ));
        $page = $this->_get_page(10);
		$recommends = $this->_recommend_mod->find(array(
            'conditions' => 'store_id =' . $this->_store_id . $conditions,
            'count' => true,
            'order' => 'recom_id desc',
            'limit' => $page['limit'],
        ));
		$count = $this->_recommend_mod->count_goods();
        foreach ($recommends as $key => $recommend)
        {
            $recommends[$key]['goods_count'] = $count[$recommend['recom_id']];
        }
        $page['item_count'] = $this->_recommend_mod->getCount();
        $this->_format_page($page);
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_goods'), 'index.php?app=my_goods',
                         LANG::get('recommend_list'));
        $this->_curitem('my_goods');
        $this->_curmenu('recommend_list');
        $this->import_resource(array(
                 'script' => array(
                     array(
                         'path' => 'jquery.plugins/jquery.validate.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'path' => 'jquery.ui/jquery.ui.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'attr' => 'id="dialog_js" charset="utf-8"',
                         'path' => 'dialog/dialog.js',
                     ),
                 ),
                 'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
             ));
		$this->assign('recommends', $recommends);
        $this->assign('page_info', $page);
        $this->assign('filtered', empty($filtered) ? 0 : 1);
        $this->display('my_recommend.index.html');
    }

    function add()
    {		
		if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->display('my_recommend.form.html');
        }
        else
        {
			$recommend_name = empty($_POST['recommend_name']) ? '' : trim($_POST['recommend_name']);
			if(!$recommend_name)
			{
				$this->pop_warning("recom_empty");
                return;
			}
             /* 检查名称是否已存在 */
			 $recommends = $this->_recommend_mod->find(array(
			 	'conditions' => "store_id=".$this->_store_id." AND recom_name='".$recommend_name."'"	
			 ));
            if ($recommends)
            {
                $this->pop_warning("name_exist");
                return;
            }

            if (!$recommend_id = $this->_recommend_mod->add(array('recom_name'   => $recommend_name, 'store_id' => $this->_store_id)))
            {
                $this->pop_warning($this->_recommend_mod->get_error());

                return;
            }
            $this->pop_warning('ok',
                'back_list',    'index.php?app=my_recommend');
        }
    }
	
    function edit()
    {
		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		if(!$id)
		{
			return;
		}
		/* 是否存在 */
        $recommend = $this->_recommend_mod->get_info($id);
        if (!$recommend)
        {
             $this->show_warning('recommend_empty');
             return;
        }
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
			$this->assign('recommend', $recommend);
            $this->display('my_recommend.form.html');
        }
        else
        {
			$recommend_name = empty($_POST['recommend_name']) ? '' : trim($_POST['recommend_name']);
			if(!$recommend_name)
			{
				$this->pop_warning("recom_empty");
                return;
			}
             /* 检查名称是否已存在 */
			 $recommends = $this->_recommend_mod->find(array(
			 	'conditions' => "store_id=".$this->_store_id." AND recom_name='".$recommend_name."'"	
			 ));
            if ($recommends)
            {
                $this->pop_warning("name_exist");
                return;
            }

            if (!$recommend_id = $this->_recommend_mod->edit($id,array('recom_name'   => $recommend_name, 'store_id' => $this->_store_id)))
            {
                $this->pop_warning($this->_recommend_mod->get_error());

                return;
            }
            $this->pop_warning('ok',
                'back_list',    'index.php?app=my_recommend');
        }
    }

    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_recommend_to_drop');
            return;
        }

        $ids = explode(',', $id);
        if (!$this->_recommend_mod->drop($ids))
        {
            $this->show_warning($this->_recommend_mod->get_error());
            return;
        }

        $this->show_message('drop_ok');
    }
    /* 查看推荐类型下的商品 */
    function view_goods()
    {
		$this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('my_goods'), 'index.php?app=my_goods',
                         LANG::get('view_recommended_goods'));
        $this->_curitem('my_goods');
        $this->_curmenu('view_recommended_goods');
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        /* 取得推荐类型 */
        $recommends = $this->_recommend_mod->get_options();
        if (!$recommends[$id])
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->assign('recommends', $recommends);

        /* 取得推荐商品 */
        $page = $this->_get_page(10);
        $goods_mod =& m('goods');
        $goods_list = $goods_mod->find(array(
            'join' => 'be_recommend, belongs_to_store, has_goodsstatistics',
            'fields' => 'g.goods_name, s.store_id, s.store_name, g.cate_name, g.brand, recommended_goods.sort_order, g.closed, g.if_show, views, g.default_image',
            'conditions' => "recommended_goods.recom_id = '$id'",
            'limit' => $page['limit'],
            'order' => 'recommended_goods.sort_order',
            'count' => true,
        ));
        foreach ($goods_list as $key => $goods)
        {
            $goods_list[$key]['cate_name'] = $goods_mod->format_cate_name($goods['cate_name']);
			empty($goods['default_image']) && $goods_list[$key]['default_image'] = Conf::get('default_goods_image');
        }
        $this->assign('goods_list', $goods_list);

        $page['item_count'] = $goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        $this->display('my_recommend.view.html');
    }

    /* 取消推荐 */
    function drop_goods_from()
    {
        if (empty($_GET['id']) || empty($_GET['goods_id']))
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $id = intval($_GET['id']);
        $goods_ids = explode(',', $_GET['goods_id']);
        $this->_recommend_mod->unlinkRelation('recommend_goods', $id, $goods_ids);

        $this->show_message('drop_goods_from_ok');
    }

    // 异步修改数据
    function ajax_col()
    {
        $id     = $_GET['id'];
        $column = empty($_GET['column']) ? '' : trim($_GET['column']);
        $value  = intval($_GET['value']);
        $data   = array();
        $arr    = explode('-', $id);
        $recom_id = intval($arr[0]);
        $goods_id = intval($arr[1]);

        if (in_array($column ,array('sort_order')))
        {
            $data[$column] = $value;
            $this->_recommend_mod->createRelation('recommend_goods', $recom_id, array($goods_id => array('sort_order' => $value)));
            if(!$this->_recommend_mod->has_error())
            {
                echo ecm_json_encode(true);
            }
        }
        else
        {
            return ;
        }
        return ;
    }
	function _get_member_submenu()
    {
            $menus = array(
                array(
                    'name' => 'goods_list',
                    'url'  => 'index.php?app=my_goods',
                ),
                array(
                    'name' => 'recommend_list',
                    'url' => 'index.php?app=my_recommend'
                ),
            );
			if(ACT == 'view_goods')
			{
				$menus[] = array(
					'name' => 'view_recommended_goods',
                    'url' => ''
				);
			}
        return $menus;
    }
}

?>