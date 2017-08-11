<?php

class AdApp extends BackendApp {

    var $_ad_mod;

    function __construct() {
        $this->AdApp();
    }

    function AdApp() {
        parent::BackendApp();
        $_POST = stripslashes_deep($_POST);
        $this->_ad_mod = & m('ad');
    }

    //图标类型  手机轮播图  手机分类  手机广告图
    function index() {
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'ad_type',
                'equal' => '=',
                'name' => 'ad_type',
                'type' => 'numeric',
            ),
            array(
                'field' => 'ad_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'ad_name',
                'type'  => 'string',
            ),
        ));

        //更新排序
        if (isset($_GET['sort']) && isset($_GET['order'])) {
            $sort = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order, array('asc', 'desc'))) {
                $sort = 'ad_id';
                $order = 'desc';
            }
        } else {
            $sort = 'ad_id';
            $order = 'desc';
        }

        $ad_type_list = $this->get_ad_type_list();
        $this->assign('ad_type_list', $ad_type_list);

        $page = $this->_get_page(10);   //获取分页信息
        $ads = $this->_ad_mod->find(array(
            'conditions' => 'user_id=0' . $conditions,
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true
        ));
        $page['item_count'] = $this->_ad_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条

        foreach ($ads as $key => $ad) {
            $ad['ad_logo'] && $ads[$key]['ad_logo'] = dirname(site_url()) . '/' . $ad['ad_logo'];
            $ads[$key]['ad_type'] = $ad_type_list[$ad['ad_type']];
        }


        $this->assign('ads', $ads);
        $this->import_resource(array('script' => 'inline_edit.js,jquery.ui/jquery.ui.js,jquery.ui/i18n/' . i18n_code() . '.js',
            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css'));
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->display('ad.index.html');
    }

    function add() {
        if (!IS_POST) {
            /* 显示新增表单 */
            $ad = array(
                'sort_order' => 0,
                'if_show' => 1,
                'ad_link'=>'index.php',
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
            $this->display('ad.form.html');
        } else {
            $data = array(
                'ad_name' => $_POST['ad_name'],
                'ad_description' => $_POST['ad_description'],
                'ad_link' => $_POST['ad_link'],
                'ad_type' => $_POST['ad_type'],
                'if_show' => $_POST['if_show'],
                'sort_order' => $_POST['sort_order'],
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

            $this->show_message('add_ad_successed', 'back_list', 'index.php?app=ad', 'continue_add', 'index.php?app=ad&amp;act=add'
            );
        }
    }
    
     /**
     *    编辑商品品牌
     *
     *    @author    Hyber
     *    @return    void
     */
    function edit()
    {
        $ad_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$ad_id)
        {
            $this->show_warning('no_such_ad');
            return;
        }
         if (!IS_POST)
        {
            $find_data     = $this->_ad_mod->find($ad_id);
            if (empty($find_data))
            {
                $this->show_warning('no_such_ad');

                return;
            }
            $ad    =   current($find_data);
            if ($ad['ad_logo'])
            {
                $ad['ad_logo']  =   dirname(site_url()) . "/" . $ad['ad_logo'];
            }
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
            $this->display('ad.form.html');
        }
        else
        {
            $data = array(
                'ad_name' => $_POST['ad_name'],
                'ad_description' => $_POST['ad_description'],
                'ad_link' => $_POST['ad_link'],
                'ad_type' => $_POST['ad_type'],
                'if_show' => $_POST['if_show'],
                'sort_order' => $_POST['sort_order'],
            );
            
            $logo               =   $this->_upload_logo($ad_id);
            $logo && $data['ad_logo'] = $logo;
            if ($logo === false)
            {
                return;
            }
            $rows=$this->_ad_mod->edit($ad_id, $data);
            if ($this->_ad_mod->has_error())
            {
                $this->show_warning($this->_ad_mod->get_error());
                return;
            }
            $ret_page = isset($_GET['ret_page']) ? intval($_GET['ret_page']) : 1;
            $ad_type = isset($_GET['ad_type']) ? intval($_GET['ad_type']) : '';
            $this->show_message('edit_ad_successed',
                'back_list',        'index.php?app=ad&page=' . $ret_page.'&ad_type=' . $ad_type,
                'edit_again',    'index.php?app=ad&amp;act=edit&amp;id=' . $ad_id.'&page=' . $ret_page.'&ad_type=' . $ad_type);
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
    
    
    
    //异步修改数据
    function ajax_col() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $column = empty($_GET['column']) ? '' : trim($_GET['column']);
        $value = isset($_GET['value']) ? trim($_GET['value']) : '';
        $data = array();

        if (in_array($column, array('ad_name', 'ad_link', 'sort_order', 'if_show'))) {
            $data[$column] = $value;
            $this->_ad_mod->edit($id, $data);
            if (!$this->_ad_mod->has_error()) {
                echo ecm_json_encode(true);
            }
        } else {
            return;
        }
        return;
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
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=ad&amp;act=edit&amp;id=' . $ad_id);
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

    /* 返回所有的图片类型 */

    function get_ad_type_list() {
        return array(
            1 => '手机首页轮播图(图片不限)', 
            2 => '手机首页按钮(图片不限)', 
            3 => '抢好货(图片1张)', 
            4 => '服装箱包(图片3张)', 
            5 => '美容化妆(图片3张)', 
            6 => '家用电器(图片3张)', 
            7 => '居家生活(图片3张)',
            8 => '母婴玩具(图片3张)',
            9 => '保健食品(图片3张)',
            10 => '主题馆(图片不限)',
        );
    }

}
