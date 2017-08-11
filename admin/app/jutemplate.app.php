<?php

class JutemplateApp extends BackendApp {

    var $_jutemplate_mod;

    function __construct() {
        $this->JutemplateApp();
    }

    function JutemplateApp() {
        parent::BackendApp();
        $this->_jutemplate_mod = & m('jutemplate');
    }

    function index() {
        $channel = !empty($_GET['channel']) ? intval($_GET['channel']) : 0;
        $state = !empty($_GET['state']) ? intval($_GET['state']) : 0;
        $conditions = '';
        !empty($channel) && $conditions .= ' AND channel=' . $channel;
        !empty($state) && $conditions .= ' AND state=' . $state;
        $conditions .= $this->_get_query_conditions(array(
            array(
                'field' => 'template_name', //可搜索字段title
                'equal' => 'LIKE', //等价关系,可以是LIKE, =, <, >, <>
                'assoc' => 'AND', //关系类型,可以是AND, OR
                'name' => 'template_name', //GET的值的访问键名
                'type' => 'string', //GET的值的类型
            ),
        ));
        $page = $this->_get_page(10);
        $tempaltes_list = $this->_jutemplate_mod->find(array(
            'conditions' => '1=1' . $conditions,
            'limit' => $page['limit'],
            'order' => 'template_id DESC',
            'count' => true
        ));
        $state_options = array(
            '1' => LANG::get('group_on'),
            '2' => LANG::get('group_end'),
            '3' => LANG::get('group_pending'),
        );
        $channel_options = array(
            '1' => LANG::get('ju_index'),
            '2' => LANG::get('ju_brand'),
            '3' => LANG::get('ju_mingpin'),
            '4' => LANG::get('ju_decoration'),
            '5' => LANG::get('ju_life'),
            '6' => LANG::get('ju_travel'),
        );
        foreach ($tempaltes_list as $key => $tem) {
            $tempaltes_list[$key]['channel'] = $channel_options[$tem['channel']];
        }
        $page['item_count'] = $this->_jutemplate_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('tempaltes_list', $tempaltes_list);
        $this->assign('channel_options', $channel_options);
        $this->assign('state_options', $state_options);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->headtag('<link href="{res file=style/ju.css}" rel="stylesheet" type="text/css" />');
        $this->display('jutemplate.index.html');
    }

    /**
     *    新增聚活动
     */
    function add() {
        if (!IS_POST) {
            $this->assign('channel', array(
                '1' => LANG::get('ju_index'),
                '2' => LANG::get('ju_brand'),
                '3' => LANG::get('ju_mingpin'),
                '4' => LANG::get('ju_decoration'),
                '5' => LANG::get('ju_life'),
                '6' => LANG::get('ju_travel'),
            ));
            $this->assign('template', '');
            $this->import_resource(array('script' => 'jquery.plugins/jquery.validate.js'));
            $this->display('jutemplate.form.html');
        } else {
            $channel = isset($_POST['channel']) ? intval($_POST['channel']) : 0;
            if (!$channel) {
                $this->show_warning('select_channel');
                return;
            }

            $data = array(
                'template_name' => trim($_POST['template_name']),
                'start_time' => gmstr2time(trim($_POST['start_time'])) - 28800,
                'end_time' => gmstr2time(trim($_POST['end_time'])) - 28800,
                'join_end_time' => gmstr2time(trim($_POST['join_end_time'])) - 28800,
                'channel' => $channel,
            );


            if ($data['start_time'] == $data['join_end_time'] && $data['join_end_time'] == $data['end_time']) {
                $this->show_warning('time_dont_eq');
                return;
            }

            if ($data['join_end_time'] > $data['end_time']) {
                $this->show_warning('join_end_time_ge_end_time');
                return;
            }
            if ($data['join_end_time'] < $data['start_time']) {
                $this->show_warning('join_end_time_le_start_time');
                return;
            }

            $tempaltes = $this->_jutemplate_mod->get("state=1 AND channel={$channel}");
            if ($tempaltes) {
                if ($tempaltes['end_time'] > $data['start_time']) {
                    $this->show_warning(Lang::get('start_time_error'));
                    return;
                }
            }
            $rows = $this->_jutemplate_mod->add($data);
            if ($this->_jutemplate_mod->has_error()) {
                $this->show_warning($this->_jutemplate_mod->get_error());

                return;
            }

            $this->show_message('add_tem_successed', 'back_list', 'index.php?app=jutemplate', 'continue_add', 'index.php?app=jutemplate&amp;act=add'
            );
        }
    }

    function edit() {
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$id) {
            $this->show_warning('no_such_template');
            return;
        }
        if (!IS_POST) {
            $find_data = $this->_jutemplate_mod->get('template_id=' . $id);
            if (empty($find_data)) {
                $this->show_warning('no_such_template');
                return;
            }
            if ($find_data['state'] == 2) {
                $this->show_warning(Lang::get('template_end_error'));
                return;
            }
            $this->assign('template', $find_data);
            $this->assign('channel', array(
                '1' => LANG::get('ju_index'),
                '2' => LANG::get('ju_brand'),
                '3' => LANG::get('ju_mingpin'),
                '4' => LANG::get('ju_decoration'),
                '5' => LANG::get('ju_life'),
                '6' => LANG::get('ju_travel'),
            ));
            $this->import_resource('jquery.plaugins/jquery.validate.js');
            $this->display('jutemplate.form.html');
        } else {
            $channel = isset($_POST['channel']) ? intval($_POST['channel']) : 0;
            if (!$channel) {
                $this->show_warning('select_channel');
                return;
            }
            $data = array(
                'template_name' => trim($_POST['template_name']),
                'start_time' => gmstr2time($_POST['start_time']) - 28800,
                'end_time' => gmstr2time($_POST['end_time']) - 28800,
                'join_end_time' => gmstr2time($_POST['join_end_time']) - 28800,
                'channel' => $channel,
            );
            if ($_POST['join_end_time'] > $_POST['end_time']) {
                $this->show_warning('join_end_time_ge_end_time');
                return;
            }
            if ($_POST['join_end_time'] < $_POST['start_time']) {
                $this->show_warning('join_end_time_le_start_time');
                return;
            }
            $rows = $this->_jutemplate_mod->edit($id, $data);
            if ($this->_jutemplate_mod->has_error()) {
                $this->show_warning($this->_jutemplate_mod->get_error());

                return;
            }
            $this->show_message('edit_tem_successed', 'back_list', 'index.php?app=jutemplate', 'edit_again', 'index.php?app=jutemplate&amp;act=edit'
            );
        }
    }

    function drop() {
        $id = trim($_GET['id']);
        $ids = explode(',', $id);
        if (empty($ids)) {
            $this->show_warning("no_valid_data");
            exit;
        }
        $this->_jutemplate_mod->drop($ids);
        if ($this->_jutemplate_mod->has_error()) {
            $this->show_warning($this->_jutemplate_mod->get_error());
            exit;
        }
        $this->show_warning('drop_success', 'back_list', 'index.php?app=jutemplate');
    }

}

?>