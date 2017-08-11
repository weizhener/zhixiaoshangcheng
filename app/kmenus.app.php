<?php

class KmenusApp extends StoreadminbaseApp {

    var $_store_id;
    var $_kmenus_mod;
    var $_kmenusinfo_mod;

    /* 构造函数 */

    function __construct() {
        $this->KmenusApp();
    }

    function KmenusApp() {
        parent::__construct();
        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->_kmenus_mod = & m('kmenus');
        $this->_kmenusinfo_mod = & m('kmenusinfo');
    }

    function index() {
        //kmenus_id  为  store_id 
        
        if (!IS_POST) {
            $kmenus = $this->_kmenus_mod->get($this->_store_id);
            
            //如果不存在  就新增
            if (empty($kmenus)) {
                $data = array(
                    'kmenus_id' => $this->_store_id,
                    'stypeinfo' => '1',
                    'status' => '0',
                    'stype' => '1',
                );
                $this->_kmenus_mod->add($data);
                $kmenus = $this->_kmenus_mod->get($this->_store_id);
            }
            $this->assign('kmenus', $kmenus);
            $this->assign('kmenusinfo', $this->_get_store_kmenusinfo());
          
            $this->_curitem('kmenus');
            $this->display('kmenus.index.html');
        }else{
            
            $data = array(
                'stypeinfo' => $_POST['stypeinfo'],
                'status' => $_POST['status'],
                'stype' => $_POST['stype'],
            );
            $this->_kmenus_mod->edit($this->_store_id, $data);
            
            $this->show_message('edit_ok');
        }
    }
    
    
    function _get_store_kmenusinfo()
    {
        $kmenusinfo = $this->_kmenusinfo_mod->find(
                array(
                    'conditions' => 'kmenus_id=' . $this->_store_id
                )
        );
        return $kmenusinfo;
    }
    
    

}

?>
