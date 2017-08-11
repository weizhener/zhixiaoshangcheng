<?php

/**
 *    手机短信
 *
 *    @author    andcpp
 *    @return    void
 */
class MsgApp extends StoreadminbaseApp {

    function __construct() {
        $this->MsgApp();
    }

    function MsgApp() {
        parent::__construct();
        $this->msg_mod = & m('msg');
        $this->msglog_mod = & m('msglog');
        $this->_user_id = $this->visitor->get('user_id');
        $this->_user_name = $this->visitor->get('user_name');
    }

    function index() {
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('msg'), 'index.php?app=msg', LANG::get('msg_index'));
        $this->_curitem('msg');
        $this->_curmenu('msg_index');

        $page = $this->_get_page(10);
        //TYPE=1  表示为 充值   TYPE=0表示发送记录
        $msglogs = $this->msglog_mod->find(array(
            'conditions' => "type=0 AND user_id=" . $this->_user_id,
            'order' => 'time desc',
            'limit' => $page['limit'],
            'count' => true,
        ));
        $this->assign('msglogs', $msglogs);
        
        $page['item_count'] = $this->msglog_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        $this->display('msg.index.html');
    }

    function set() {
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('msg'), 'index.php?app=msg', LANG::get('set'));
        $this->_curitem('msg');
        $this->_curmenu('msg_set');
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
        $row_msg = $this->msg_mod->get("user_id='$this->_user_id'");
        if (!IS_POST) {
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('msg'));

            $checked_functions = $functions = array();
            import('mobile_msg.lib');
            $mobile_msg = new Mobile_msg();
            $functions = $mobile_msg->get_functions();
            $tmp = explode(',', $row_msg['functions']);
            if ($functions) {
                foreach ($functions as $func) {
                    $checked_functions[$func] = in_array($func, $tmp);
                }
            }
            $this->assign('mobile', $row_msg[mobile]);
            $this->assign('state', $row_msg[state]);
            $this->assign('num', $row_msg[num]);
            $this->assign('functions', $functions);
            $this->assign('checked_functions', $checked_functions);
            $this->display('msg.set.html');
        } else {
            $functions = isset($_POST['functions']) ? implode(',', $_POST['functions']) : '';
            $data = array(
                'user_id' => $this->_user_id,
                'user_name' => $this->_user_name,
                'mobile' => $_POST['mobile'],
                'state' => $_POST['state'],
                'functions' => $functions,
            );
            if ($row_msg) {
                $this->msg_mod->edit('user_id=' . $this->_user_id, $data);
            } else {
                $this->msg_mod->add($data);
            }
            $this->show_message('set_ok', 'back_list', 'index.php?app=msg');
        }
    }

    /**
     *    发送短消息
     *
     *    @author    Hyber
     *    @return    void
     */
    function send() {
        if (!IS_POST) {
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('msg'), 'index.php?app=msg', LANG::get('sendmsg'));
            $this->_curitem('msg');
            $this->_curmenu('msg_send');
            

            header('Content-Type:text/html;charset=' . CHARSET);

            //引入jquery表单插件
            $this->import_resource(array(
                'script' => 'jquery.plugins/jquery.validate.js',
            ));
            $this->_config_seo('title', Lang::get('user_center') . ' - ' . Lang::get('sendmsg'));
            $this->display('msg.send.html');
        } else {
            $to_mobile = $_POST['to_mobile']; //号码
            $smsText = trim($_POST['msg_content']);  //内容

            if ($smsText == '') {
                $this->show_message('cuowu_neirongbunengweikong', 'go_back', 'index.php?app=msg&act=send');
                return;
            }
            if ($to_mobile == '') {
                $this->show_message('cuowu_shoujihaomabunengweikong', 'go_back', 'index.php?app=msg&act=send');
                return;
            }
            import('mobile_msg.lib');
            $mobile_msg = new Mobile_msg();
            $result = $mobile_msg->send_msg_seller($this->_user_id, $this->_user_name, $to_mobile, $smsText);

            if ($result) {
                $this->show_message('send_msg_successed', 'go_back', 'index.php?app=msg');
            } else {
                $this->show_message('cuowu_duanxinfasongshibai', 'go_back', 'index.php?app=msg');
            }
        }
    }

    function _get_member_submenu() {
        return array(
            array(
                'name' => 'msg_index',
                'url' => 'index.php?app=msg&act=index',
            ),
            array(
                'name' => 'msg_set',
                'url' => 'index.php?app=msg&act=set',
            ),
            array(
                'name' => 'msg_send',
                'url' => 'index.php?app=msg&act=send',
            ),
        );
    }

}

?>
