<?php



/**

 * 金蛋礼品设置

 */

class EggpresentApp extends BackendApp {



    var $_eggpresent_mod;



    function __construct() {

        $this->EggpresentApp();

    }



    function EggpresentApp() {

        parent::BackendApp();

        $this->_eggpresent_mod = & m('eggpresent');

    }



    /**

     *    礼品管理索引

     */

    function index() {

        $conditions = $this->_get_query_conditions(array(array(

                'field' => 'name',

                'equal' => 'LIKE',

                'assoc' => 'AND',

                'name' => 'name',

                'type' => 'string',

            ),

        ));

        $page = $this->_get_page(10);   //获取分页信息

        //更新排序

        if (isset($_GET['sort']) && isset($_GET['order'])) {

            $sort = strtolower(trim($_GET['sort']));

            $order = strtolower(trim($_GET['order']));

            if (!in_array($order, array('asc', 'desc'))) {

                $sort = 'id';

                $order = 'desc';

            }

        } else {

            $sort = 'id';

            $order = 'desc';

        }

        $eggpresents = $this->_eggpresent_mod->findAll(array(

            'conditions' => '1=1' . $conditions,

            'join' => 'belongs_to_egg',

            'fields' => 'this.*,egg.name as eggname',

            'limit' => $page['limit'],

            'order' => "$sort $order",

            'count' => true

        ));



        foreach ($eggpresents as $key => $eggpresent) {

            $eggpresent['eggpresent_logo'] && $eggpresents[$key]['eggpresent_logo'] = dirname(site_url()) . '/' . $eggpresent['eggpresent_logo'];

        }



        $page['item_count'] = $this->_eggpresent_mod->getCount();   //获取统计数据

        /* 导入jQuery的表单验证插件 */

        $this->import_resource(array(

            'script' => 'jqtreetable.js,inline_edit.js',

            'style' => 'res:style/jqtreetable.css'

        ));

        $this->_format_page($page);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件

        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条

        $this->assign('eggpresents', $eggpresents);

        $this->display('eggpresent.index.html');

    }



    function drop() {

        $ids = isset($_GET['id']) ? trim($_GET['id']) : '';

        if (!$ids) {

            $this->show_warning('no_such');



            return;

        }

        $ids = explode(',', $ids);

        $this->_eggpresent_mod->drop($ids);

        if ($this->_eggpresent_mod->has_error()) {    //删除

            $this->show_warning($this->_eggpresent_mod->get_error());



            return;

        }



        $this->show_message('drop_successed');

    }



    /**

     *    处理上传标志

     */

    function _upload_logo($id) {

        $file = $_FILES['eggpresent_logo'];

        if ($file['error'] == UPLOAD_ERR_NO_FILE) { // 没有文件被上传

            return '';

        }

        import('uploader.lib');             //导入上传类

        $uploader = new Uploader();

        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型

        $uploader->addFile($_FILES['eggpresent_logo']); //上传logo

        if (!$uploader->file_info()) {

            $this->show_warning($uploader->get_error(), 'go_back', 'index.php?app=eggpresent&amp;act=edit&amp;id=' . $id);

            return false;

        }

        /* 指定保存位置的根目录 */

        $uploader->root_dir(ROOT_PATH);



        /* 上传 */

        if ($file_path = $uploader->save('data/files/mall/eggpresent', $id)) {   //保存到指定目录，并以指定文件名$id存储

            return $file_path;

        }

    }



    /**

     *    编辑

     */

    function edit() {

        $eggpresent_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$eggpresent_id) {

            $this->show_warning('no_such');

            return;

        }

        if (!IS_POST) {

            $find_data = $this->_eggpresent_mod->find($eggpresent_id);

            if (empty($find_data)) {

                $this->show_warning('no_such');



                return;

            }

            $eggpresent = current($find_data);

            if ($eggpresent['eggpresent_logo']) {

                $eggpresent['eggpresent_logo'] = dirname(site_url()) . "/" . $eggpresent['eggpresent_logo'];

            }



            $egg_mod = & m('egg');

            $this->assign('eggs', $egg_mod->get_options());

            /* 显示新增表单 */

            $yes_or_no = array(

                1 => Lang::get('yes'),

                0 => Lang::get('no'),

            );

            $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js'

            ));

            $this->assign('yes_or_no', $yes_or_no);

            $this->assign('eggpresent', $eggpresent);

            $this->display('eggpresent.form.html');

        } else {

            $data = array();

            $data['name'] = $_POST['name'];

            $data['byeggid'] = intval($_POST['egg']);
			
			

            $data['money'] = $_POST['money'];



            $rows = $this->_eggpresent_mod->edit($eggpresent_id, $data);

            if ($this->_eggpresent_mod->has_error()) {

                $this->show_warning($this->_eggpresent_mod->get_error());



                return;

            }



            $this->show_message('edit_successed', 'back_list', 'index.php?app=eggpresent', 'edit_again', 'index.php?app=eggpresent&amp;act=edit&amp;id=' . $eggpresentrec_id);

        }

    }



    /**

     *    新增

     */

    function add() {

        if (!IS_POST) {

            /* 显示新增表单 */

            $eggpresent = array(

                'isexpired' => 0,

            );

            $yes_or_no = array(

                1 => Lang::get('yes'),

                0 => Lang::get('no'),

            );

            $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js'

            ));

            $egg_mod = & m('egg');

            $this->assign('eggs', $egg_mod->get_options());

            $this->assign('yes_or_no', $yes_or_no);

            $this->assign('eggpresent', $eggpresent);

            $this->display('eggpresent.form.html');

        } else {

            $data = array();

            $data['name'] = $_POST['name'];

            $data['byeggid'] = intval($_POST['egg']);
$data['money'] = $_POST['money'];




            /* 检查名称是否已存在 */

            //if (!$this->_eggpresent_mod->unique(trim($data['sn'])))

            //{

            //$this->show_warning('name_exist');

            //return;

            //}

            if (!$eggpresent_id = $this->_eggpresent_mod->add($data)) {  //获取brand_id

                $this->show_warning($this->_eggpresent_mod->get_error());

                return;

            }







            $this->show_message('add_successed', 'back_list', 'index.php?app=eggpresent', 'continue_add', 'index.php?app=eggpresent&amp;act=add'

            );

        }

    }



}



?>