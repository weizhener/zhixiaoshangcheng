<?php

class MixApp extends BackendApp
{
    var $_mix_mod;

    function __construct()
    {
        $this->MixApp();
    }
    function MixApp()
    {
        parent::BackendApp();

        $this->_mix_mod =& m('mix');
    }

    /* 套餐列表 */
    function index()
    {
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'mix_name',
				'name'  => 'mix_name',
                'equal' => 'like',
            ),
            array(
                'field' => 's.store_name',
				'name'  => 'store_name',
                'equal' => 'like',
            ),
        ));

        $page = $this->_get_page(10);
        $mix_list = $this->_mix_mod->find(array(
            'conditions' => "1 = 1" . $conditions,
			'fields' => "mix.*,s.store_name",
			'join' => 'belongs_to_store',
            'count' => true,
            'order' => "mix_id desc",
            'limit' => $page['limit'],
        ));
	    $page['item_count'] = $this->_mix_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);	
		
        foreach ($mix_list as $key => $mix)
        {
			$mix_mod =& bm('mix', array('_store_id' => $mix['store_id']));
			$count = $mix_mod->count_goods();
            $mix_list[$key]['goods_count'] = $count[$mix['mix_id']];
        }
        $this->assign('mix_list', $mix_list);

        $this->import_resource('inline_edit.js');
        $this->display('mix.index.html');
    }
	
    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_mix_to_drop');
            return false;
        }
		$ids = explode(',', $id);
        $this->_mix_mod->drop($ids);
        if ($this->_mix_mod->has_error())
        {
            $this->show_warning($this->_mix_mod->get_error());
            return;
        }

        $this->show_message('drop_mix_successed');
    }
	
	/* 查看自由搭配下的商品 */
    function view_goods()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            $this->show_warning('no_such_mix');
            return;
        }

        /* 取得自由搭配 */
        $mixs = $this->_get_options();
        if (!$mixs[$id])
        {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->assign('mixs', $mixs);

        /* 取得推荐商品 */
        $page = $this->_get_page();
        $goods_mod =& m('goods');
        $goods_list = $goods_mod->find(array(
            'join' => 'be_mix, belongs_to_store, has_goodsstatistics',
            'fields' => 'g.goods_name, s.store_id, s.store_name, g.cate_name, g.brand, mix_goods.sort_order, g.closed, g.if_show, views',
            'conditions' => "mix_goods.mix_id = '$id'",
            'limit' => $page['limit'],
            'order' => 'mix_goods.sort_order',
            'count' => true,
        ));
        foreach ($goods_list as $key => $goods)
        {
            $goods_list[$key]['cate_name'] = $goods_mod->format_cate_name($goods['cate_name']);
        }
        $this->assign('goods_list', $goods_list);

        $page['item_count'] = $goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
		$this->assign('page_title', Lang::get('member_center') . ' - ' . Lang::get('view_goods_mix'));
        $this->display('mix.goods.html');
    }
		
	/* 移出自由搭配 */
    function drop_goods_from()
    {
        if (empty($_GET['id']) || empty($_GET['goods_id']))
        {
            $this->show_warning('no_such_mix');
            return;
        }

        $id = intval($_GET['id']);
        $goods_ids = explode(',', $_GET['goods_id']);
        $this->_mix_mod->unlinkRelation('mix_goods', $id, $goods_ids);

        $this->show_message('drop_goods_from_ok');
    }
	
	function _get_options()
    {
        $options = array();
        $mixs = $this->_mix_mod->find('1=1');
        foreach ($mixs as $mix)
        {
            $options[$mix['mix_id']] = $mix['mix_name'];
        }

        return $options;
    }
}

?>
