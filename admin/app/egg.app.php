<?php



/**

 *    egg 砸蛋 活动区

 */

class EggApp extends BackendApp {



    var $_egg_mod;



    function __construct() {

        $this->EggApp();

    }



    function EggApp() {

        parent::BackendApp();

        $this->_egg_mod = & m('egg');

    }



    /**

     *    管理索引

     */

    function index() {

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

        $eggs = $this->_egg_mod->findAll(array(

            'conditions' => '1=1' . $conditions,

            'fields' => 'this.*',

            'limit' => $page['limit'],

            'order' => "$sort $order",

            'count' => true

        ));





        $page['item_count'] = $this->_egg_mod->getCount();   //获取统计数据

        /* 导入jQuery的表单验证插件 */

        $this->import_resource(array(

            'script' => 'jqtreetable.js,inline_edit.js',

            'style' => 'res:style/jqtreetable.css'

        ));

        $this->_format_page($page);

        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件

        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条

        $this->assign('eggs', $eggs);

        $this->display('egg.index.html');

    }



    function drop() {

        $ids = isset($_GET['id']) ? trim($_GET['id']) : '';

        if (!$ids) {

            $this->show_warning('no_such');



            return;

        }

        $ids = explode(',', $ids);

        $this->_egg_mod->drop($ids);

        if ($this->_egg_mod->has_error()) {    //删除

            $this->show_warning($this->_egg_mod->get_error());



            return;

        }



        $this->show_message('drop_successed');

    }



    /**

     *    编辑

     */

    function edit() {

        $egg_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if (!$egg_id) {

            $this->show_warning('no_such');

            return;

        }

        if (!IS_POST) {

            $find_data = $this->_egg_mod->find($egg_id);

            if (empty($find_data)) {

                $this->show_warning('no_such');



                return;

            }

            $egg = current($find_data);

            /* 显示新增表单 */

            $yes_or_no = array(

                1 => Lang::get('yes'),

                0 => Lang::get('no'),

            );

            $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js'

            ));

            $this->assign('yes_or_no', $yes_or_no);

            $this->assign('egg', $egg);

            $this->display('egg.form.html');

        } else {

            $data = array();

            $data['name'] = $_POST['name'];

            $data['noun'] = intval($_POST['noun']);

            $data['rate'] = intval($_POST['rate']);



            $rows = $this->_egg_mod->edit($egg_id, $data);

            if ($this->_egg_mod->has_error()) {

                $this->show_warning($this->_egg_mod->get_error());

                return;

            }

            $this->show_message('edit_successed', 'back_list', 'index.php?app=egg', 'edit_again', 'index.php?app=egg&amp;act=edit&amp;id=' . $egg_id);

        }

    }



    /**

     *    新增

     */

    function add() {

        if (!IS_POST) {

            /* 显示新增表单 */

            $egg = array(

                'isexpired' => 0,

            );

            $yes_or_no = array(

                1 => Lang::get('yes'),

                0 => Lang::get('no'),

            );

            $this->import_resource(array(

                'script' => 'jquery.plugins/jquery.validate.js'

            ));

            $this->assign('yes_or_no', $yes_or_no);

            $this->assign('egg', $egg);

            $this->display('egg.form.html');

        } else {

            $data = array();

            $data['name'] = $_POST['name'];

            $data['noun'] = intval($_POST['noun']);

            $data['rate'] = intval($_POST['info']);



            if (!$egg_id = $this->_egg_mod->add($data)) {  //获取id

                $this->show_warning($this->_egg_mod->get_error());

                return;

            }

            $this->show_message('add_successed', 'back_list', 'index.php?app=egg', 'continue_add', 'index.php?app=egg&amp;act=add'

            );

        }

    }



}



?>