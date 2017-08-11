<?php

/**
 *    短信
 *
 */
class MsgApp extends BackendApp {

    function __construct() {
        $this->MsgModule();
    }

    function MsgModule() {
        parent::__construct();
        $this->msg_mod = & m('msg');
        $this->msglog_mod = & m('msglog');
    }

    function index() {
        $condition = $this->_get_query_conditions(array(array(
                'field' => 'to_mobile', //可搜索字段title
                'equal' => 'LIKE', //等价关系,可以是LIKE, =, <, >, <>
            ),
        ));
        $page = $this->_get_page(10);
        $index = $this->msglog_mod->find(array(
            'conditions' => 'type=0' . $condition,
            'limit' => $page['limit'],
            'order' => "id desc",
            'count' => true));
        $page['item_count'] = $this->msglog_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        $this->assign('index', $index); //传递到风格里
        $this->display('msg.index.html');
    }

    function user() {
        $condition = $this->_get_query_conditions(array(array(
                'user_name' => 'user_name', //可搜索字段user_name
                'equal' => 'LIKE', //等价关系,可以是LIKE, =, <, >, <>
            ),
        ));
        $page = $this->_get_page(10);
        $user = $this->msg_mod->find(array(
            'conditions' => '1=1' . $condition,
            'limit' => $page['limit'],
            'order' => "id desc",
            'count' => true));
        $page['item_count'] = $this->msg_mod->getCount();
        $this->_format_page($page);

        $checked_functions = $functions = array();
        import('mobile_msg.lib');
        $mobile_msg = new Mobile_msg();
        $functions = $mobile_msg->get_functions();
        $tmp = explode(',', $user[1]['functions']);
        if ($functions) {
            foreach ($functions as $func) {
                $checked_functions[$func] = in_array($func, $tmp);
            }
        }
        $this->assign('functions', $functions);
        $this->assign('checked_functions', $checked_functions);
        $this->assign('page_info', $page);
        $this->assign('user', $user); //传递到风格里
        $this->display('msg.user.html');
    }

    function add() {
        if (!IS_POST) {
            $user_id = isset($_GET['user_id']) ? trim($_GET['user_id']) : '';
            $user_name = isset($_GET['user_name']) ? trim($_GET['user_name']) : '';
            if (!empty($user_id)) {
                $data = $this->msg_mod->find('user_id=' . $user_id);
            }
            $this->assign('data', $data);
            $this->display('msg.add.html');
        } else {
            $user_name = trim($_POST['user_name']);
            $num_edit = trim($_POST['num']);
            $jia_or_jian = trim($_POST['jia_or_jian']);
            $log_text = trim($_POST['log_text']);
            $time = time();
            if (empty($user_name) or empty($num_edit) or empty($jia_or_jian)) {
                $this->show_warning('cuowu_bunengweikong');
                return;
            }
            if (preg_match("/[^0.-9]/", $num_edit)) {
                $this->show_warning('cuowu_not_num');
                return;
            }
            $row_msg = $this->msg_mod->getrow("select * from " . DB_PREFIX . "msg where user_name='$user_name'");
            if ($row_msg) {
                $num_old = $row_msg['num'];
                $id = $row_msg['user_id'];
                if ($jia_or_jian == "jia") {
                    $num_new = $num_old + $num_edit;
                } else {
                    if ($num_old >= $num_edit) {
                        $num_new = $num_old - $num_edit;
                    } else {
                        $this->show_warning('cuowu_num_smaller');
                        return;
                    }
                }
                $edit_msg = array(
                    'num' => $num_new,
                );
                $edit_msglog = array(
                    'user_id' => $id,
                    'user_name' => $user_name,
                    'content' => $log_text,
                    'type' => 1,
                    'time' => $time,
                );
                $this->msg_mod->edit("user_name='$user_name'", $edit_msg);
                $this->msglog_mod->add($edit_msglog);
                $this->show_message('add_msgnum_successed', 'back_list', 'index.php?app=msg&amp;act=user', 'continue_add', 'index.php?app=msg&amp;act=add'
                );
            } else {
                $this->show_warning('cuowu_no_user');
                return;
            }
        }
    }

    function send() {
        if (!IS_POST) {
            $this->display('msg.send.html');
        } else {
            $to_mobile = $_POST['to_mobile']; //号码
            $smsText = trim($_POST['msg_content']);  //内容

            $time = time();
            if ($to_mobile == '') {
                $this->show_message('cuowu_shoujihaomabunengweikong', 'go_back', 'index.php?app=msg');
                return;
            }
            if ($smsText == '') {
                $this->show_message('cuowu_neirongbunengweikong', 'go_back', 'index.php?app=msg');
                return;
            }


            import('mobile_msg.lib');
            $mobile_msg = new Mobile_msg();
            $state = $mobile_msg->send_msg('0', 'admin', $to_mobile, $smsText);
            if ($state == TRUE) {
                $this->show_message('send_msg_successed', 'go_back', 'index.php?app=msg');
            } else {
                $this->show_message('cuowu_duanxinfasongshibai', 'go_back', 'index.php?app=msg');
            }
        }
    }

    function setting() {
        $model_setting = &af('settings');
        $setting = $model_setting->getAll(); //载入系统设置数据
        if (!IS_POST) {
            $this->assign('setting', $setting);
            $this->display('msg.setting.html');
        } else {
            $data['msg_enabled'] = $_POST['msg_enabled'];
            $data['msg_pid'] = $_POST['msg_pid'];
            $data['msg_key'] = $_POST['msg_key'];
            $model_setting->setAll($data);
            $this->show_message('setting_successed');
        }
    }

}

?>
