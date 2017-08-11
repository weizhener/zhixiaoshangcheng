<?php

class KmenusinfoApp extends StoreadminbaseApp {

    var $_store_id;
    var $_kmenus_mod;
    var $_kmenusinfo_mod;

    /* 构造函数 */

    function __construct() {
        $this->KmenusinfoApp();
    }

    function KmenusinfoApp() {
        parent::__construct();
        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->_kmenus_mod = & m('kmenus');
        $this->_kmenusinfo_mod = & m('kmenusinfo');
    }

    function index() {

        if (!IS_POST) {
            $this->_curitem('kmenus');
            $this->display('kmenusinfo.index.html');
        } else {
            $data = array(
                'kmenus_id' => $this->_store_id,
                'title' => $_POST['title'],
                'color' => $_POST['color'],
                'loadurl' => $_POST['loadurl'],
                'imgurl' => $_POST['imgurl'],
                'nums' => $_POST['nums'],
            );
            $this->_kmenusinfo_mod->add($data);
            $this->show_message('add_ok');
        }
    }

    function edit() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $kmenusinfo = $this->_kmenusinfo_mod->get($id);
        if (empty($kmenusinfo) || $kmenusinfo['kmenus_id'] != $this->_store_id) {
            $this->show_warning('Hacking Attempt');
            return;
        }

        if (!IS_POST) {
            $this->assign('kmenusinfo', $kmenusinfo);
            $this->_curitem('kmenus');
            $this->display('kmenusinfo.index.html');
        } else {
            $data = array(
                'title' => $_POST['title'],
                'color' => $_POST['color'],
                'loadurl' => $_POST['loadurl'],
                'imgurl' => $_POST['imgurl'],
                'nums' => $_POST['nums'],
            );
            $this->_kmenusinfo_mod->edit($id,$data);
            $this->show_message('edit_ok');
        }
    }
    
    function del()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        $kmenusinfo = $this->_kmenusinfo_mod->get($id);
        if (empty($kmenusinfo) || $kmenusinfo['kmenus_id'] != $this->_store_id) {
            $this->show_warning('Hacking Attempt');
            return;
        }
        $this->_kmenusinfo_mod->drop($id);
        $this->show_message('drop_ok');
        
    }

}

?>
