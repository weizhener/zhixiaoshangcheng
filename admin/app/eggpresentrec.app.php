<?php

/**
 *    商品品牌管理控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class EggpresentrecApp extends BackendApp
{

    var $_eggpresentrec_mod;

    function __construct()
    {
        $this->EggpresentrecApp();
    }

    function EggpresentrecApp()
    {
        parent::BackendApp();

        $this->_eggpresentrec_mod =& m('eggpresentrec');
    }
    /**
     *    索引
     *
     *    @author    Hyber
     *    @return    void
     */
    function index()
    {
        $conditions = $this->_get_query_conditions(array(array(
                'field' => 'username',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'username',
                'type'  => 'string',
            ),
			array(
                'field' => 'eggname',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name' => 'eggname',
                'type' => 'string',
            ),
        ));
        $page   =   $this->_get_page(10);   //获取分页信息
        //更新排序
        if (isset($_GET['sort']) && isset($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
             $sort  = 'id';
             $order = 'desc';
            }
        }
        else
        {
            $sort  = 'id';
            $order = 'desc';
        }
        $eggpresentrecs=$this->_eggpresentrec_mod->find(array(
        'conditions'    => '1=1' . $conditions,
		'fields'        => '*,(select real_name from ecm_member where user_name=username) as real_name',
        'limit'         => $page['limit'],
        'order'         => "$sort $order",
        'count'         => true
        ));

        $page['item_count']=$this->_eggpresentrec_mod->getCount();   //获取统计数据
        /* 导入jQuery的表单验证插件 */
        $this->import_resource(array(
            'script' => 'inline_edit.js',
        ));
        $this->_format_page($page);
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('eggpresentrecs', $eggpresentrecs);
        $this->display('eggpresentrec.index.html');
    }
	


    function drop()
    {
        $ids = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$ids)
        {
            $this->show_warning('no_such');
            return;
        }
        $ids=explode(',',$ids);
		if (!$this->_eggpresentrec_mod->drop($ids))    //删除
        {
            $this->show_warning($this->_eggpresentrec_mod->get_error());
            return;
        }
		$this->_clear_cache();
        $this->show_message('drop_successed');
    }
	

}

?>