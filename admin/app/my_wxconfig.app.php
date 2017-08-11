<?php

/* 微公众平台接口管理控制器 */

class My_wxconfigApp extends BackendApp {

    var $_store_id=0;
    var $my_wxconfig_mod;

    function __construct() {
        $this->My_wxconfig();
    }

    function My_wxconfig() {
        parent::__construct();
        $this->_store_id ='0';
        $this->my_wxconfig_mod = & m('wxconfig');
    }

    function index() {
        if (!IS_POST) {
            $wx_config = $this->my_wxconfig_mod->get_info_user($this->_store_id);
            
            if (empty($wx_config)) {
                $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
                for ($i = 0; $i < 8; $i++) {
                    $wx_config['token'] .= $chars[mt_rand(0, strlen($chars) - 1)];
                }
            }
            
            $wx_config['url'] = SITE_URL . '/index.php?app=weixin&id=' . $this->_store_id;
            $this->assign('wx_config', $wx_config);
       
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_wxconfig'));
            $this->display('my_wxconfig.index.html');
        } else {
            $data = array(
                'user_id' => $this->_store_id,
                'url' => $_POST['url'],
                'token' => $_POST['token'],
            );
            $w_id = $this->my_wxconfig_mod->unique($this->_store_id);
            if ($w_id) {
                $this->my_wxconfig_mod->edit($w_id, $data);
                if ($this->my_wxconfig_mod->has_error()) {
                    $this->show_warning($this->my_wxconfig_mod->get_error());

                    return;
                }

                $this->show_message('edit_wxconfig_successed');
            } else {
                $this->my_wxconfig_mod->add($data);
                if ($this->my_wxconfig_mod->has_error()) {
                    $this->show_warning($this->my_wxconfig_mod->get_error());
                    return;
                }

                $this->show_message('edit_wxconfig_successed');
            }
        }
    }

    /**
     *    三级菜单
     *
     *    @author    Hyber
     *    @return    void
     */
    function _get_member_submenu() {
        $submenus = array(
            array(
                'name' => 'my_wxconfig',
                'url' => 'index.php?app=my_wxconfig',
            ),
        );
        return $submenus;
    }

}

?>