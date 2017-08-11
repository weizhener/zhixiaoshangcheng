<?php

define('MAX_LAYER', 2);

class JucateApp extends BackendApp {

    var $_jucate_mod;
    var $_jutemplate_mod;

    function __construct() {
        $this->JucateApp();
    }

    function JucateApp() {
        parent::BackendApp();
        $this->_jucate_mod = &m('jucate');
    }

    function index() {
        /* 取得聚划算分类 */
        $cate_list = $this->_jucate_mod->get_list(0);
        $tree = & $this->_tree($cate_list);

        /* 先根排序 */
        foreach ($cate_list as $key => $val) {
            $cate_list[$key]['switchs'] = 0;
            if ($this->_jucate_mod->get_list($val['cate_id'])) {
                $cate_list[$key]['switchs'] = 1;
            }
        }
        $this->assign('cate_list', $cate_list);
        /* 构造映射表（每个结点的父结点对应的行，从1开始） */

        $this->assign('max_layer', MAX_LAYER);

        /* 导入jQuery的表单验证插件 */
        $this->import_resource(array(
            'script' => 'jqtable.js,inline_edit.js',
            'style' => 'res:style/jqtreetable.css,res:style/ju.css'
        ));
        $this->display('jucate.index.html');
    }

    /**
     *    新增团购活动
     */
    function add() {
        if (!IS_POST) {
            /* 参数 */
            $pid = empty($_GET['pid']) ? 0 : intval($_GET['pid']);
            $category = array('parent_id' => $pid, 'sort_order' => 255, 'if_show' => 1);
            $this->assign('category', $category);
            $channel_options = array(
                '1' => LANG::get('ju_index'),
                '2' => LANG::get('ju_brand'),
                '3' => LANG::get('ju_mingpin'),
                '4' => LANG::get('ju_decoration'),
                '5' => LANG::get('ju_life'),
                '6' => LANG::get('ju_travel'),
            );
            $this->assign('channel_options', $channel_options);
            $this->assign('parents', $this->_get_options());
            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->display('jucate.form.html');
        } else {
            $channel = isset($_POST['channel']) ? intval($_POST['channel']) : 0;
            $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
            if (!$parent_id && !$channel) {
                $this->show_warning('channel_desc');
                return;
            }
            $data = array(
                'cate_name' => $_POST['cate_name'],
                'parent_id' => $parent_id,
                'sort_order' => $_POST['sort_order'],
                'if_show' => $_POST['if_show'],
                'channel' => $channel,
            );

            /* 检查名称是否已存在 */
            if (!$this->_jucate_mod->unique(trim($data['cate_name']), $data['parent_id'])) {
                $this->show_warning('name_exist');
                return;
            }

            /* 检查级数 */
            $ancestor = $this->_jucate_mod->get_ancestor($data['parent_id']);
            if (count($ancestor) >= MAX_LAYER) {
                $this->show_warning('max_layer_error');
                return;
            }

            /* 保存 */
            $cate_id = $this->_jucate_mod->add($data);
            if (!$cate_id) {
                $this->show_warning($this->_jucate_mod->get_error());
                return;
            }

            $this->show_message('add_ok', 'back_list', 'index.php?app=jucate', 'continue_add', 'index.php?app=jucate&amp;act=add&amp;pid=' . $data['parent_id']
            );
        }
    }

    /* 检查分类名的唯一 */

    function check_catename() {
        $cate_name = empty($_GET['cate_name']) ? '' : trim($_GET['cate_name']);
        $parent_id = empty($_GET['parent_id']) ? 0 : intval($_GET['parent_id']);
        $cate_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$cate_name) {
            echo ecm_json_encode(true);
            return;
        }
        if ($this->_jucate_mod->unique($cate_name, $parent_id, $cate_id)) {
            echo ecm_json_encode(true);
        } else {
            echo ecm_json_encode(false);
        }
        return;
    }

    function edit() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!IS_POST) {
            /* 是否存在 */
            $category = $this->_jucate_mod->get_info($id);
            if (!$category) {
                $this->show_warning('category_empty');
                return;
            }
            $this->assign('category', $category);
            $channel_options = array(
                '1' => LANG::get('ju_index'),
                '2' => LANG::get('ju_brand'),
                '3' => LANG::get('ju_mingpin'),
                '4' => LANG::get('ju_decoration'),
                '5' => LANG::get('ju_life'),
                '6' => LANG::get('ju_travel'),
            );
            $this->assign('channel_options', $channel_options);
            /* 导入jQuery的表单验证插件 */
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->assign('parents', $this->_get_options($id));
            $this->display('jucate.form.html');
        } else {
            $channel = isset($_POST['channel']) ? intval($_POST['channel']) : 0;
            $parent_id = isset($_POST['parent_id']) ? intval($_POST['parent_id']) : 0;
            if (!$parent_id && !$channel) {
                $this->show_warning('channel_desc');
                return;
            }
            $data = array(
                'cate_name' => $_POST['cate_name'],
                'parent_id' => $parent_id,
                'sort_order' => $_POST['sort_order'],
                'if_show' => $_POST['if_show'],
                'channel' => $channel,
            );

            /* 检查名称是否已存在 */
            if (!$this->_jucate_mod->unique(trim($data['cate_name']), $data['parent_id'], $id)) {
                $this->show_warning('name_exist');
                return;
            }

            /* 检查级数 */
            $depth = $this->_jucate_mod->get_depth($id);
            $ancestor = $this->_jucate_mod->get_ancestor($data['parent_id']);
            if ($depth + count($ancestor) > MAX_LAYER) {
                $this->show_warning('max_layer_error');
                return;
            }

            /* 保存 */
            $rows = $this->_jucate_mod->edit($id, $data);
            if ($this->_jucate_mod->has_error()) {
                $this->show_warning($this->_jucate_mod->get_error());
                return;
            }

            $this->show_message('edit_ok', 'back_list', 'index.php?app=jucate', 'edit_again', 'index.php?app=jucate&amp;act=edit&amp;id=' . $id
            );
        }
    }

    /* 删除分类 */

    function drop() {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id) {
            $this->show_warning('no_gcategory_to_drop');
            return;
        }

        $ids = explode(',', $id);
        if (!$this->_jucate_mod->drop($ids)) {
            $this->show_warning($this->_jucate_mod->get_error());
            return;
        }
        $this->show_message('drop_ok');
    }

    //异步修改数据
    function ajax_col() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $column = empty($_GET['column']) ? '' : trim($_GET['column']);
        $value = isset($_GET['value']) ? trim($_GET['value']) : '';
        $data = array();
        if (in_array($column, array('cate_name', 'if_show', 'sort_order'))) {
            $data[$column] = $value;
            if ($column == 'cate_name') {
                $gcategory = $this->_jucate_mod->get_info($id);
                if (!$this->_jucate_mod->unique($value, $gcategory['parent_id'], $id)) {
                    echo ecm_json_encode(false);
                    return;
                }
            }
            $this->_jucate_mod->edit($id, $data);
            if (!$this->_jucate_mod->has_error()) {
                echo ecm_json_encode(true);
            }
        } else {
            return;
        }
        return;
    }

    /* 异步去商品分类子元素 */

    function ajax_cate() {
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            echo ecm_json_encode(false);
            return;
        }
        $cate = $this->_jucate_mod->get_list($_GET['id']);
        foreach ($cate as $key => $val) {
            $child = $this->_jucate_mod->get_list($val['cate_id']);
            $lay = $this->_jucate_mod->get_layer($val['cate_id']);
            if ($lay >= MAX_LAYER) {
                $cate[$key]['add_child'] = 0;
            } else {
                $cate[$key]['add_child'] = 1;
            }
            if (!$child || empty($child)) {

                $cate[$key]['switchs'] = 0;
            } else {
                $cate[$key]['switchs'] = 1;
            }
        }
        header("Content-Type:text/html;charset=" . CHARSET);
        echo ecm_json_encode(array_values($cate));
        return;
    }

    /* 构造并返回树 */

    function &_tree($gcategories) {
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($gcategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree;
    }

    /* 取得可以作为上级的商品分类数据 */

    function _get_options($except = NULL) {
        $categories = $this->_jucate_mod->get_list();
        $tree = & $this->_tree($categories);
        return $tree->getOptions(MAX_LAYER - 1, 0, $except);
    }

}

?>