<?php

class My_third_loginApp extends MemberbaseApp {

    var $_user_id;
    var $_third_login_mod;

    function __construct() {
        $this->My_third_loginApp();
    }

    function My_third_loginApp() {
        parent::__construct();
        $this->_user_id = $this->visitor->get('user_id');
        $this->_third_login_mod = & m('third_login');
    }

    function index() {
        $third_logins = $this->_third_login_mod->find(
                array(
                    'conditions'    => 'user_id='.$this->_user_id,
                )
        );
        
        /* 当前用户中心菜单 */
        $this->_curitem('my_third_login');
        $this->_curmenu('my_third_login');
        $this->assign('third_logins', $third_logins);
        
        $this->display('my_third_login.index.html');
    }
    
    
    
    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_goods_to_drop');
            return;
        }
        $this->_third_login_mod->drop($id);
        if ($this->_third_login_mod->has_error())
        {
            $this->show_warning($this->_third_login_mod->get_error());
            return;
        }
        $this->show_message('drop_ok');
    }
    
/*三级菜单*/
    function _get_member_submenu()
    {
        $menus = array(
            array(
                'name' => 'my_third_login',
                'url'  => 'index.php?app=my_third_login',
            ),
            );
        return $menus;
    }
    

}
