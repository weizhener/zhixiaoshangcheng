<?php

/**
 *  积分产品
 */
class Integral_goodsApp extends BackendApp {

    var $_integral_goods_mod;

    function __construct() {
        $this->Integral_goodsApp();
    }

    function Integral_goodsApp() {
        parent::BackendApp();
        $this->_integral_goods_mod = & m('integral_goods');
    }

    function index() {
        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'goods_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name' => 'goods_name',
                'type' => 'string',
            ),
        ));

        $page = $this->_get_page(10);   //获取分页信息
        //获取统计数据
        $integral_goods_list = $this->_integral_goods_mod->find(array(
            'conditions' => '1=1 ' . $conditions,
            'limit' => $page['limit'],
            'order' => "add_time desc",
            'count' => true   //允许统计
        ));


        foreach ($integral_goods_list as $key => $integral_goods) {
            $integral_goods['goods_logo'] && $integral_goods_list[$key]['goods_logo'] = dirname(site_url()) . '/' . $integral_goods['goods_logo'];
        }



        $page['item_count'] = $this->_integral_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        $this->assign('integral_goods_list', $integral_goods_list);
        $this->display('integral_goods.index.html');
    }

    function add() {
        if (!IS_POST) {
            /* 显示新增表单 */
            $integral_goods = array(
                'sort_order' => 255,
            );
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->assign('integral_goods', $integral_goods);
            $this->display('integral_goods.form.html');
        } else {
            $data['goods_name'] = $_POST['goods_name'];
            $data['goods_stock'] = intval($_POST['goods_stock']);
            $data['goods_stock_exchange'] = intval($_POST['goods_stock_exchange']);

            $data['goods_price'] = intval($_POST['goods_price']);
            $data['goods_point'] = intval($_POST['goods_point']);
            $data['add_time'] = gmtime();
            $data['sort_order'] = intval($_POST['sort_order']);

            /* 检查名称是否已存在 */
            if (!$this->_integral_goods_mod->unique(trim($data['goods_name']))) {
                $this->show_warning('name_exist');
                return;
            }
            if (!$goods_id = $this->_integral_goods_mod->add($data)) {
                $this->show_warning($this->_integral_goods_mod->get_error());

                return;
            }

            /* 处理上传的图片 */
            $logo = $this->_upload_logo($goods_id);
            if ($logo === false) {
                return;
            }
            $logo && $this->_integral_goods_mod->edit($goods_id, array('goods_logo' => $logo)); //将logo地址记下

            $this->show_message('add_goods_successed', 'back_list', 'index.php?app=integral_goods', 'continue_add', 'index.php?app=integral_goods&amp;act=add'
            );
        }
    }

    function edit()
    {
        $goods_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$goods_id)
        {
            $this->show_warning('no_such_goods');
            return;
        }
         if (!IS_POST)
        {
            $integral_goods     = $this->_integral_goods_mod->get($goods_id);
            if (empty($integral_goods))
            {
                $this->show_warning('no_such_goods');

                return;
            }
            if ($integral_goods['goods_logo'])
            {
                $integral_goods['goods_logo']  =   dirname(site_url()) . "/" . $integral_goods['goods_logo'];
            }
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js'
            ));
            $this->assign('integral_goods', $integral_goods);
            $this->display('integral_goods.form.html');
        }
        else
        {
            $data['goods_name'] = $_POST['goods_name'];
            $data['goods_stock'] = intval($_POST['goods_stock']);
            $data['goods_stock_exchange'] = intval($_POST['goods_stock_exchange']);

            $data['goods_price'] = intval($_POST['goods_price']);
            $data['goods_point'] = intval($_POST['goods_point']);
            $data['add_time'] = gmtime();
            $data['sort_order'] = intval($_POST['sort_order']);
            
            
            $logo               =   $this->_upload_logo($goods_id);
            $logo && $data['goods_logo'] = $logo;
            if ($logo === false)
            {
                return;
            }
             /* 检查名称是否已存在 */
            if (!$this->_integral_goods_mod->unique(trim($data['goods_name']), $goods_id))
            {
                $this->show_warning('name_exist');
                return;
            }
            $rows=$this->_integral_goods_mod->edit($goods_id, $data);
            if ($this->_integral_goods_mod->has_error())
            {
                $this->show_warning($this->_integral_goods_mod->get_error());

                return;
            }

            $this->show_message('edit_goods_successed',
                'back_list',        'index.php?app=integral_goods',
                'edit_again',    'index.php?app=integral_goods&amp;act=edit&amp;id=' . $goods_id);
        }
    }

    function drop() {
        $goods_ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$goods_ids)
        {
            $this->show_warning('no_such_goods');

            return;
        }
        $goods_ids=explode(',',$goods_ids);
        $this->_integral_goods_mod->drop($goods_ids);
        if ($this->_integral_goods_mod->has_error())    //删除
        {
            $this->show_warning($this->_integral_goods_mod->get_error());

            return;
        }

        $this->show_message('drop_goods_successed');
    }

    function check_integral_goods() {
        $goods_name = empty($_GET['goods_name']) ? '' : trim($_GET['goods_name']);
        $goods_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$goods_name) {
            echo ecm_json_encode(false);
        }
        if ($this->_integral_goods_mod->unique($goods_name, $goods_id)) {
            echo ecm_json_encode(true);
        } else {
            echo ecm_json_encode(false);
        }
        return;
    }

    function _upload_logo($goods_id) {
        $file = $_FILES['goods_logo'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE) { // 没有文件被上传
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['goods_logo']); //上传logo
        if (!$uploader->file_info()) {
            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=integral_goods&amp;act=edit&amp;id=' . $goods_id);
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/mall/integral_goods', $goods_id)) {   //保存到指定目录，并以指定文件名$goods_id存储
            return $file_path;
        } else {
            return false;
        }
    }

}
