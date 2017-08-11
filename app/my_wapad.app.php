<?php

class My_wapadApp extends StoreadminbaseApp {

    var $_store_id;
    var $_ad_mod;

    function __construct() {
        $this->My_wapadApp();
    }

    function My_wapadApp() {
        parent::__construct();
        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->_ad_mod = & m('ad');
    }

    //图标类型  手机轮播图  手机分类  手机广告图
    function index() {
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_wapad_index'));
        $this->_curitem('my_wapad');
        $this->_curmenu('my_wapad_index');

        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'ad_type',
                'equal' => '=',
                'name' => 'ad_type',
                'type' => 'numeric',
            ),
        ));


        $ad_type_list = $this->get_ad_type_list();
        $this->assign('ad_type_list', $ad_type_list);

        $page = $this->_get_page(10);   //获取分页信息
        $ads = $this->_ad_mod->find(array(
            'conditions' => 'user_id=' . $this->_store_id . $conditions,
            'limit' => $page['limit'],
            'order' => "ad_id desc",
            'count' => true
        ));
        $page['item_count'] = $this->_ad_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条

        foreach ($ads as $key => $ad) {
            $ads[$key]['ad_type'] = $ad_type_list[$ad['ad_type']];
        }

        $this->assign('ads', $ads);
        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->display('my_wapad.index.html');
    }

    function add() {
        if (!IS_POST) {
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_wapad_add'));
            $this->_curitem('my_wapad');
            $this->_curmenu('my_wapad_add');


            /* 显示新增表单 */
            $ad = array(
                'sort_order' => 0,
                'if_show' => 1,
                'ad_link' => 'index.php',
            );
            $yes_or_no = array(
                1 => Lang::get('yes'),
                0 => Lang::get('no'),
            );
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->assign('yes_or_no', $yes_or_no);
            $this->assign('ad', $ad);
            $this->assign('ad_type_list', $this->get_ad_type_list());
            $this->display('my_wapad.form.html');
        } else {
            $data = array(
                'ad_name' => $_POST['ad_name'],
                'ad_description' => $_POST['ad_description'],
                'ad_link' => $_POST['ad_link'],
                'ad_type' => $_POST['ad_type'],
                'if_show' => $_POST['if_show'],
                'sort_order' => $_POST['sort_order'],
                'user_id' => $this->_store_id,
            );
            if (!$ad_id = $this->_ad_mod->add($data)) {  //获取ad_id
                $this->show_warning($this->_ad_mod->get_error());
                return;
            }
            /* 处理上传的图片 */
            $logo = $this->_upload_logo($ad_id);
            if ($logo === false) {
                return;
            }
            $logo && $this->_ad_mod->edit($ad_id, array('ad_logo' => $logo)); //将logo地址记下

            $this->show_message('add_ad_successed', 'back_list', 'index.php?app=my_wapad', 'continue_add', 'index.php?app=my_wapad&amp;act=add'
            );
        }
    }

    /**
     *    编辑商品品牌
     *
     *    @author    Hyber
     *    @return    void
     */
    function edit() {
        $ad_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$ad_id) {
            $this->show_warning('no_such_ad');
            return;
        }
        $ad = $this->_ad_mod->get('ad_id=' . $ad_id . ' AND user_id=' . $this->_store_id);
        if (empty($ad)) {
            $this->show_warning('no_such_ad');

            return;
        }
        if (!IS_POST) {
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_wapad_edit'));
            $this->_curitem('my_wapad');
            $this->_curmenu('my_wapad_edit');
            
            $this->assign('ad_type_list', $this->get_ad_type_list());
            /* 显示新增表单 */
            $yes_or_no = array(
                1 => Lang::get('yes'),
                0 => Lang::get('no'),
            );
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->assign('yes_or_no', $yes_or_no);
            $this->assign('ad', $ad);
            $this->display('my_wapad.form.html');
        } else {
            $data = array(
                'ad_name' => $_POST['ad_name'],
                'ad_description' => $_POST['ad_description'],
                'ad_link' => $_POST['ad_link'],
                'ad_type' => $_POST['ad_type'],
                'if_show' => $_POST['if_show'],
                'sort_order' => $_POST['sort_order'],
            );

            $logo = $this->_upload_logo($ad_id);
            $logo && $data['ad_logo'] = $logo;
            if ($logo === false) {
                return;
            }
            $rows = $this->_ad_mod->edit($ad_id, $data);
            if ($this->_ad_mod->has_error()) {
                $this->show_warning($this->_ad_mod->get_error());
                return;
            }

            $this->show_message('edit_ad_successed', 'back_list', 'index.php?app=my_wapad', 'edit_again', 'index.php?app=my_wapad&amp;act=edit&amp;id=' . $ad_id);
        }
    }

    function drop() {
        $ad_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$ad_ids) {
            $this->show_warning('no_such_ad');

            return;
        }
        $ad_ids = explode(',', $ad_ids);
        $this->_ad_mod->drop($ad_ids);
        if ($this->_ad_mod->has_error()) {    //删除
            $this->show_warning($this->_ad_mod->get_error());

            return;
        }
        $this->show_message('drop_ad_successed');
    }

    function _upload_logo($ad_id) {
        $file = $_FILES['ad_logo'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE) { // 没有文件被上传
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['ad_logo']); //上传logo
        if (!$uploader->file_info()) {
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=my_wapad&amp;act=edit&amp;id=' . $ad_id);
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/mall/ad', $ad_id)) {   //保存到指定目录，并以指定文件名$ad_id存储
            return $file_path;
        } else {
            return false;
        }
    }

    function _get_member_submenu() {
        return array(
            array(
                'name' => 'my_wapad_index',
                'url' => 'index.php?app=my_wapad',
            ),
            array(
                'name' => 'my_wapad_add',
                'url' => 'index.php?app=my_wapad&act=add',
            ),
        );
    }

    /* 返回所有的图片类型 */

    function get_ad_type_list() {
        return array(
            11 => '店铺轮播图1', 
            12 => '店铺轮播图2', 
            13 => '横排两广告', 
            14 => '单张广告1',
            15 => '单张广告2',
        );
    }

}
