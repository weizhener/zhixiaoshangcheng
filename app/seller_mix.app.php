<?php

class Seller_mixApp extends StoreadminbaseApp {

    var $_store_id;
    var $_goods_mod;
    var $_mix_mod;

    /* 构造函数 */

    function __construct() {
        $this->Seller_mixApp();
    }

    function Seller_mixApp() {
        parent::__construct();

        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->_goods_mod = & m('goods');
        $this->_mix_mod = & bm('mix', array('_store_id' => $this->_store_id));
    }

    function index() {
        /* 取得列表数据 */
        $conditions = $this->_get_query_conditions(array(
            array(//按组合套餐名称搜索
                'field' => 'mix_name',
                'name' => 'mix_name',
                'equal' => 'LIKE',
            ),
        ));
        // 标识有没有过滤条件
        if ($conditions) {
            $this->assign('filtered', 1);
        }
        $page = $this->_get_page(10);    //获取分页信息
        $mix_list = $this->_mix_mod->find(array(
            'join' => 'belong_goods',
            'conditions' => '1=1' . $conditions,
            'order' => 'mix_id DESC',
            'limit' => $page['limit'], //获取当前页的数据
            'count' => true
        ));
        $page['item_count'] = $this->_mix_mod->getCount();   //获取统计的数据
        $count = $this->_mix_mod->count_goods();
        foreach ($mix_list as $key => $mix) {
            $mix_list[$key]['goods_count'] = $count[$mix['mix_id']];
        }
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('mix_manage'), 'index.php?app=seller_mix', LANG::get('mix_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('mix_manage');

        /* 当前所处子菜单 */
        $this->_curmenu('mix_list');
        $this->_format_page($page);
        $this->_import_resource();
        $this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条
        $this->assign('mix_list', $mix_list);

        $this->assign('title', Lang::get('member_center') . ' - ' . Lang::get('mix_manage'));
        $this->display('seller_mix.index.html');
    }

    function add() {
        if (!IS_POST) {

            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('mix_manage'), 'index.php?app=seller_mix', LANG::get('add_mix'));

            /* 当前用户中心菜单 */
            $this->_curitem('mix_manage');

            /* 当前所处子菜单 */
            $this->_curmenu('add_mix');
            $this->assign('group', array('max_per_user' => 0, 'end_time' => gmtime() + 7 * 24 * 3600));
            $this->assign('store_id', $this->_store_id);
            $this->assign('page_title', Lang::get('member_center') . ' - ' . Lang::get('add_mix'));
            $this->_import_resource();
            $this->assign('gcategories', $this->_get_mgcategory_options(0)); // 商城分类第一级
            $this->assign('sgcategories', $this->_get_sgcategory_options());

            $this->display('seller_mix.form.html');
        } else {
            /* 检查数据 */
            if (!$this->_handle_post_data($_POST, 0)) {
                $this->show_warning($this->get_error());
                return;
            }
            $this->show_message('add_mix_ok', 'back_list', 'index.php?app=seller_mix', 'continue_add', 'index.php?app=seller_mix&amp;act=add'
            );
        }
    }

    function _get_sgcategory_options() {
        $mod = & bm('gcategory', array('_store_id' => $this->_store_id));
        $gcategories = $mod->get_list();
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree->getOptions();
    }

    function edit() {
        $id = empty($_GET['id']) ? 0 : $_GET['id'];
        if (!$id) {
            $this->show_warning('no_such_mix');
            return false;
        }
        if (!IS_POST) {
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('mix_manage'), 'index.php?app=seller_mix', LANG::get('edit_mix'));

            /* 当前用户中心菜单 */
            $this->_curitem('mix_manage');

            /* 当前所处子菜单 */
            $this->_curmenu('edit_mix');

            /* 自由搭配信息 */
            $mix = $this->_mix_mod->get($id);
            $goods_mod = & m('goods');
            $goods_list = $goods_mod->find(array(
                'join' => 'be_mix',
                'fields' => 'g.goods_name, g.goods_id',
                'conditions' => "mix_goods.mix_id = '$id'",
                'order' => 'mix_goods.sort_order',
            ));
            $tmp_items = array();
            $mix_items = '';
            foreach ($goods_list as $key => $goods) {
                $tmp_items[] = $goods['goods_id'];
            }
            $mix_items = implode(',', $tmp_items);
            unset($tmp_items);
            $this->assign('mix', $mix);
            $this->assign('store_id', $this->_store_id);
            $this->assign('goods_list', $goods_list);
            $this->assign('mix_items', $mix_items);
            $this->assign('page_title', Lang::get('member_center') . ' - ' . Lang::get('edit_mix'));
            $this->_import_resource();
            $this->assign('gcategories', $this->_get_mgcategory_options(0)); // 商城分类第一级
            $this->assign('sgcategories', $this->_get_sgcategory_options());

            $this->display('seller_mix.form.html');
        } else {
            /* 检查数据 */
            if (!$this->_handle_post_data($_POST, $id)) {
                $this->show_warning($this->get_error());
                return;
            }
            $this->show_message('edit_mix_ok', 'back_list', 'index.php?app=seller_mix', 'continue_edit', 'index.php?app=seller_mix&act=edit&id=' . $id
            );
        }
    }

    /* 取得商城商品分类，指定parent_id */

    function _get_mgcategory_options($parent_id = 0) {
        $res = array();
        $mod = & bm('gcategory', array('_store_id' => 0));
        $gcategories = $mod->get_list($parent_id, true);
        foreach ($gcategories as $gcategory) {
            $res[$gcategory['cate_id']] = $gcategory['cate_name'];
        }
        return $res;
    }

    function drop() {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id) {
            $this->show_warning('no_mix_to_drop');
            return false;
        }
        $ids = explode(',', $id);
        if (!$this->_mix_mod->drop($ids)) {
            $this->show_warning($this->_mix_mod->get_error());

            return;
        }

        $this->show_message('drop_mix_successed');
    }

    /* 查看自由搭配下的商品 */

    function view_goods() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id) {
            $this->show_warning('no_such_mix');
            return;
        }

        /* 取得自由搭配 */
        $mixs = $this->_mix_mod->get_options();
        if (!$mixs[$id]) {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->assign('mixs', $mixs);

        /* 取得推荐商品 */
        $page = $this->_get_page();
        $goods_mod = & m('goods');
        $goods_list = $goods_mod->find(array(
            'join' => 'be_mix, belongs_to_store, has_goodsstatistics',
            'fields' => 'g.goods_name, s.store_id, s.store_name, g.cate_name, g.brand, mix_goods.sort_order, g.closed, g.if_show, views',
            'conditions' => "mix_goods.mix_id = '$id'",
            'limit' => $page['limit'],
            'order' => 'mix_goods.sort_order',
            'count' => true,
        ));
        foreach ($goods_list as $key => $goods) {
            $goods_list[$key]['cate_name'] = $goods_mod->format_cate_name($goods['cate_name']);
        }
        $this->assign('goods_list', $goods_list);

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('mix_manage'), 'index.php?app=seller_mix', LANG::get('view_goods_mix'));

        /* 当前用户中心菜单 */
        $this->_curitem('mix_manage');

        /* 当前所处子菜单 */
        $this->_curmenu('view_goods_mix');
        $page['item_count'] = $goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        $this->assign('page_title', Lang::get('member_center') . ' - ' . Lang::get('view_goods_mix'));
        $this->display('seller_mix.goods.html');
    }

    /**
     * 检查提交的数据
     */
    function _handle_post_data($post, $id = 0) {


        if (($post['goods_id'] = intval($post['goods_id'])) == 0) {
            $this->_error('fill_goods');
            return false;
        }
        $sql = "SELECT COUNT(*) FROM {$this->_mix_mod->table} WHERE nav_goods_id=" . $post['goods_id'] . " AND store_id =" . $this->_store_id;
        $mix_num = $this->_mix_mod->getOne($sql);
        if (MIX_MAX_NUM <= $mix_num) {
            $this->show_warning('mix_max_num_error');
            return;
        }
        if (empty($post['mix_name'])) {
            $this->_error('fill_mix_name');
            return false;
        }
        $goods = $this->_goods_mod->get_info($post['goods_id']);
        if (!$goods) {
            $this->_error('fill_goods');
            return false;
        }
        $goods['default_image'] || $goods['default_image'] = Conf::get('default_goods_image');

        $data = array(
            'mix_name' => $post['mix_name'],
            'mix_desc' => $post['mix_desc'],
            'nav_goods_id' => $post['goods_id'],
            'nav_goods_name' => $post['goods_name'],
            'nav_goods_image' => $goods['default_image'],
            'nav_goods_price' => $goods['price'],
            'store_id' => $this->_store_id
        );
        $mix_items = array();
        if ($post['selectright']) {
            foreach ($post['selectright'] as $mix_item) {
                $mix_items[] = $mix_item;
            }
        }
        if ($id > 0) {
            $this->_mix_mod->edit($id, $data);
            if ($this->_mix_mod->has_error()) {
                $this->_error($this->_mix_mod->get_error());
                return false;
            }
            $this->_mix_mod->unlinkRelation('mix_goods', $id);
        } else {
            if (!$id = $this->_mix_mod->add($data)) {
                $this->_error($this->_mix_mod->get_error());
                return false;
            }
        }
        $this->_mix_mod->createRelation('mix_goods', $id, $mix_items);
        return true;
    }

    function query_goods_info() {
        $res = array();
        $cate_id = empty($_GET['cate_id']) ? 0 : intval($_GET['cate_id']);
        $store_id = empty($_GET['store_id']) ? 0 : intval($_GET['store_id']);
        $mix_items = empty($_GET['mix_items']) ? 0 : trim($_GET['mix_items']);

        $conditions = "1=1 AND store_id='{$store_id}' AND type='material'";
        if ($cate_id) {
            /* $cate_mod =& m('gcategory');
              $cate_ids = $cate_mod->get_descendant($cate_id); */
            $cate_mod = & bm('gcategory', array('_store_id' => $this->_store_id));
            $cate_ids = $cate_mod->get_descendant_ids(intval($cate_id));


            $cg_table = DB_PREFIX . 'category_goods';

            $sql = "SELECT DISTINCT goods_id FROM {$cg_table} WHERE cate_id " . db_create_in($cate_ids);
            $gs_mod = & m('goodsspec');
            $goods_ids = $gs_mod->getCol($sql);



            $cate_ids && $conditions .= " AND g.goods_id " . db_create_in($goods_ids);
        }
        if ($mix_items) {
            $mix_items = explode(',', $mix_items);
            $mix_items && $conditions .= " AND g.goods_id not " . db_create_in($mix_items);
        }
        /* 取得商品列表 */
        $goods_mod = & m('goods');
        $goods_list = $goods_mod->find(array(
            'conditions' => $conditions,
            'order' => 'add_time DESC',
        ));
        foreach ($goods_list as $key => $val) {
            $res[$key]['goods_name'] = htmlspecialchars($val['goods_name']);
            $res[$key]['goods_id'] = $val['goods_id'];
        }
        $this->json_result($res);
    }

    function _import_resource() {
        if (in_array(ACT, array('index', 'add', 'edit'))) {
            $resource['script'][] = array(// JQUERY UI
                'path' => 'jquery.ui/jquery.ui.js'
            );
        }
        if (in_array(ACT, array('index', 'add', 'edit'))) {
            $resource['script'][] = array(// 对话框
                'attr' => 'id="dialog_js"',
                'path' => 'dialog/dialog.js'
            );
        }
        if (in_array(ACT, array('add', 'edit'))) {
            $resource['script'][] = array(
                'path' => 'mlselection.js'
            );
        }
        if (in_array(ACT, array('add', 'edit'))) {
            $resource['script'][] = array(// 验证
                'path' => 'jquery.plugins/jquery.validate.js'
            );
        }
        if (in_array(ACT, array('view_goods'))) {
            $resource['script'][] = array(
                'path' => 'inline_edit.js'
            );
        }
        $this->import_resource($resource);
    }

    /**
     *    三级菜单
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_member_submenu() {
        $menus = array(
            array(
                'name' => 'mix_list',
                'url' => 'index.php?app=seller_mix',
            ),
			 array(
                'name'  => 'add_mix',
                'url'   => 'index.php?app=seller_mix&act=add',
            ),
        );
        if (ACT == 'edit') {
            $menus[] = array(
                'name' => ACT . '_mix',
                'url' => '',
            );
        }
        if (ACT == 'view_goods') {
            $menus[] = array(
                'name' => ACT . '_mix',
                'url' => '',
            );
        }
        return $menus;
    }

    /* 移出自由搭配 */

    function drop_goods_from() {
        if (empty($_GET['id']) || empty($_GET['goods_id'])) {
            $this->show_warning('no_such_mix');
            return;
        }

        $id = intval($_GET['id']);
        $goods_ids = explode(',', $_GET['goods_id']);
        $this->_mix_mod->unlinkRelation('mix_goods', $id, $goods_ids);

        $this->show_message('drop_goods_from_ok');
    }

}

?>