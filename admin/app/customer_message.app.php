<?php

/**
 * 客户留言投诉
 */
class Customer_messageApp extends BackendApp {

    var $_customer_message_mod;

    function __construct() {
        $this->Customer_messageApp();
    }

    function Customer_messageApp() {
        parent::BackendApp();
        $this->_customer_message_mod = & m('customer_message');
    }

    function index() {

        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'status',
                'equal' => '=',
                'type' => 'numeric',
            )
        ));

        $this->assign('status_list', array(
            0 => '未处理',
            1 => '已处理',
        ));

        $page = $this->_get_page(10);   //获取分页信息
        $customer_message_list = $this->_customer_message_mod->find(array(
            'conditions' => 'customer_message.type=' . CUSTOMER_MESSAGE_SUGGESTION . $conditions,
            'limit' => $page['limit'],
            'order' => "customer_message.add_time desc",
            'count' => true,
        ));
        $page['item_count'] = $this->_customer_message_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('customer_message_list', $customer_message_list);
        $this->display('customer_message.index.html');
    }

    function store() {

        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'status',
                'equal' => '=',
                'type' => 'numeric',
            )
        ));

        $this->assign('status_list', array(
            0 => '未处理',
            1 => '已处理',
        ));

        $page = $this->_get_page(10);   //获取分页信息
        $customer_message_list = $this->_customer_message_mod->find(array(
            'conditions' => 'customer_message.type=' . CUSTOMER_MESSAGE_STORE . $conditions,
            'limit' => $page['limit'],
            'order' => "customer_message.add_time desc",
            'join'    => 'belongs_to_store',
            'count' => true,
        ));
        $page['item_count'] = $this->_customer_message_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('customer_message_list', $customer_message_list);
        $this->display('customer_message.store.html');
    }

    function goods() {
        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'status',
                'equal' => '=',
                'type' => 'numeric',
            )
        ));

        $this->assign('status_list', array(
            0 => '未处理',
            1 => '已处理',
        ));

        $page = $this->_get_page(10);   //获取分页信息
        $customer_message_list = $this->_customer_message_mod->find(array(
            'conditions' => 'customer_message.type=' . CUSTOMER_MESSAGE_GOODS . $conditions,
            'limit' => $page['limit'],
            'order' => "customer_message.add_time desc",
            'join'    => 'belongs_to_goods',
            'count' => true,
        ));
        $page['item_count'] = $this->_customer_message_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('customer_message_list', $customer_message_list);
        $this->display('customer_message.goods.html');
    }
    
    
    function epay() {
        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'status',
                'equal' => '=',
                'type' => 'numeric',
            )
        ));

        $this->assign('status_list', array(
            0 => '未处理',
            1 => '已处理',
        ));

        $page = $this->_get_page(10);   //获取分页信息
        $customer_message_list = $this->_customer_message_mod->find(array(
            'conditions' => 'customer_message.type=' . CUSTOMER_EPAYOFFLINE . $conditions,
            'limit' => $page['limit'],
            'order' => "customer_message.add_time desc",
            'join'    => 'belongs_to_goods',
            'count' => true,
        ));
        $page['item_count'] = $this->_customer_message_mod->getCount();   //获取统计数据
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('customer_message_list', $customer_message_list);
        $this->display('customer_message.epay.html');
    }
    
    
    
    function status()
    {
        $id = isset($_GET['id']) ? intval($_GET['id']) : '';
        $this->_customer_message_mod->edit($id,array('status'=>'1'));
        $this->show_message('edit_successed');
    }
    
    
    
    function drop()
    {
        $ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$ids)
        {
            $this->show_warning('error');
            return;
        }
        $ids=explode(',',$ids);
        $this->_customer_message_mod->drop($ids);
        if ($this->_customer_message_mod->has_error())    //删除
        {
            $this->show_warning($this->_customer_message_mod->get_error());
            return;
        }
        $this->show_message('drop_successed');
    }
    
    

}

?>
