<?php

define('MAX_LAYER', 2);

class JuApp extends BackendApp
{
    var $_ju_mod;
	var $_store_mod;
	var $_jucate_mod;
	var $_jutemplate_mod;

    function __construct()
    {
        $this->JuApp();
    }

    function JuApp()
    {
        parent::BackendApp();
		$this->_ju_mod =& m('ju');
        $this->_jutemplate_mod =& m('jutemplate');
		$this->_jucate_mod =&m('jucate');
		$this->_goods_mod =&m('goods');
		$this->_store_mod = &m('store');
    }

    function index()
    {
		$channel = !empty($_GET['channel'])? intval($_GET['channel']) : 0;
		$state = !empty($_GET['state'])? intval($_GET['state']) : 0;
		$conditions='';
        !empty($channel)&& $conditions .= ' AND channel='.$channel;
		!empty($state) && $conditions .= ' AND state='.$state;
        $conditions .= $this->_get_query_conditions(array(
            array(
                'field' => 'template_name',         //可搜索字段title
                'equal' => 'LIKE',          //等价关系,可以是LIKE, =, <, >, <>
                'assoc' => 'AND',           //关系类型,可以是AND, OR
                'name'  => 'template_name',         //GET的值的访问键名
                'type'  => 'string',        //GET的值的类型
            ),
        ));
        $page = $this->_get_page(10);
        $tempaltes_list = $this->_jutemplate_mod->find(array(
            'conditions' => '1=1'.$conditions,
            'limit' => $page['limit'],
            'order' => 'template_id DESC',
            'count' => true
        ));
		$state_options = array(
				'1'	=> LANG::get('group_on'),
				'2' => LANG::get('group_end'),
				'3'	=> LANG::get('group_pending'),
		);
		$channel_options = array(
				'1'	=> LANG::get('ju_index'),
				'2'	=> LANG::get('ju_brand'),
				'3' => LANG::get('ju_mingpin'),
				'4'	=> LANG::get('ju_decoration'),
				'5'	=> LANG::get('ju_life'),
				'6' => LANG::get('ju_travel'),
		);
		foreach($tempaltes_list as $key => $tem)
		{
			$tempaltes_list[$key]['channel'] = $channel_options[$tem['channel']];
		}
        $page['item_count'] = $this->_jutemplate_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('tempaltes_list', $tempaltes_list);
		$this->assign('channel_options',$channel_options);
		$this->assign('state_options',$state_options);
		$this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
		$this->headtag('<link href="{res file=style/ju.css}" rel="stylesheet" type="text/css" />');
        $this->display('ju.index.html');
    }

	function goods_list()
    {
		$verify =  empty($_GET['wait_verify']) ? '' : ' AND status = 0';
        $conditions = $this->_get_query_conditions(array(
            array(
                'field' => 'gb.group_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'group_name',
                'type'  => 'string',
            ),
			array(
                'field' => 's.store_name',
                'equal' => 'LIKE',
                'assoc' => 'AND',
                'name'  => 'store_name',
                'type'  => 'string',
            ),
			array(
                'field' => 'template_id',
                'equal' => '=',
				'name'  => 'template_id',
                'type'  => 'numeric',
			),
			array(
				'field' => 'status',
				'equal' => '=',
				'name'  => 'status',
				'type'  => 'numeric'
			),
        ));
        $page = $this->_get_page(10);
        $groupbuy_list = $this->_ju_mod->find(array(
            'conditions' => "1 = 1" . $conditions . $verify,
            'join'  => 'belong_store',
            'fields'=> 'this.*,s.store_name',
            'limit' => $page['limit'],
            'order' => 'group_id DESC',
            'count' => true
        ));
		foreach($groupbuy_list as $key => $group)
		{
			$template = $this->_jutemplate_mod->get(array('conditions'=>'template_id='.$group['template_id'],'fields'=>'template_name'));
			$groupbuy_list[$key]['template_name'] = $template['template_name'];
		}

        $page['item_count'] = $this->_ju_mod->getCount();
        $this->_format_page($page);
        $this->import_resource(array(
            'script' => 'inline_edit.js',
			'style'  => 'res:style/ju.css'
        ));
		$template_list = $this->_jutemplate_mod->find(array('fields'=>'template_id,template_name'));
		$this->assign('status', array(' ' => Lang::get('group_all'),
			 '1' => Lang::get('verified'),
             '0' => Lang::get('verifying'),
			 '3' => Lang::get('wait_edit'),
			 '2' => Lang::get('verify_no_pass'),
        ));
		$this->assign('template_list',$template_list);
        $this->assign('type', $_GET['type']);
        $this->assign('filtered', $conditions ? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);   //将分页信息传递给视图，用于形成分页条
        $this->assign('groupbuy_list', $groupbuy_list);
        $this->display('ju.goods.html');
    }

    function recommend()
    {
        $id = trim($_GET['id']);
		if (!$id){
            $this->show_warning('no_such_goods');
            return;
        }
		
        $ids = explode(',', $id);
		
		// 已通过的才能设为推荐
        $this->_ju_mod->edit('group_id' . db_create_in($ids) . ' AND status=1', array('recommend' => 1));
        if ($this->_ju_mod->has_error())
        {
            $this->show_warning($this->_ju_mod->get_error());
            exit;
        }
        $this->show_warning('recommend_success', 'back_list' , 'index.php?app=ju&amp;act=goods_list');
    }
	
	function verify()
	{
		$id = trim($_GET['id']);
		if (!$id){
            $this->show_warning('no_such_goods');
            return;
        }
		
        $ids = explode(',', $id);
		
		if(!IS_POST)
		{
			$ju = array();
			if(count($ids)==1) // 如果不是批量审核
			{
				$ju = $this->_ju_mod->get(array('conditions'=>'group_id='.current($ids),'fields'=>'status_desc,status'));
			}
			
			$this->assign('status_options', array(
                '1' => Lang::get('yes'),
                '2' => Lang::get('no'),
            ));
			$this->assign('ju',$ju);
			$this->display('ju.verify.html');
		}
		else
		{
			$data = array();
			$data['status_desc'] = trim($_POST['status_desc']);
			$data['status'] = isset($_POST['status']) ? intval($_POST['status']) : 0;
			
			// 如果审核的动作是，把状态设置为不通过，则取消之前的推荐设置
			if($data['status']==2){
				$data['recommend'] = 0;
			}
			
			// 处于待修改过状态的，不允许审核通过
			$this->_ju_mod->edit('group_id' . db_create_in($ids).' AND status !=3',$data);
			if ($this->_ju_mod->has_error())    //有错误
            {
                $this->show_warning($this->_ju_mod->get_error());

                return;
            }
			$this->show_message('edit_successed',
				'back_list', 'index.php?app=ju&amp;act=goods_list',
				'edit_again', 'index.php?app=ju&amp;act=verify&id='.$id
			);
		}
	}
	
	function view()
	{
		$id = isset($_GET['id']) ? trim($_GET['id']) : '';
        if (!$id)
        {
            $this->show_warning('no_goods_to_view');
            return;
        }
		$ju = $this->_ju_mod->get(array('conditions'=>'group_id='.$id,'fields'=>'store_id,goods_id'));
		
		$store = $this->_store_mod->get($ju['store_id']);
		$goods = $this->_get_common_info($ju['goods_id']);
		$this->assign('store', $store);
        $this->assign('goods', $goods);
		$this->display('ju.view.html');
	}
	
	function drop_goods()
    {
        $id = trim($_GET['id']);
        $ids = explode(',', $id);
        if (empty($ids))
        {
            $this->show_warning("no_valid_data");
            exit;
        }
        $this->_ju_mod->drop(db_create_in($ids, 'group_id'));
        if ($this->_ju_mod->has_error())
        {
            $this->show_warning($this->_ju_mod->get_error());
            exit;
        }
        $this->show_warning('drop_success',
            'back_list' , 'index.php?app=ju&act=goods_list');
    }
	
   function _get_common_info($id)
   {
        /* 商品信息 */
        $goods = $this->_goods_mod->get_info($id);
        if (!$goods || $goods['if_show'] == 0 || $goods['closed'] == 1 || $goods['state'] != 1) // state => store opening
        {
           $this->show_warning('goods_not_exist');
           return false;
        }
		//取团购信息
		$groupbuy = $this->_ju_mod->get('goods_id='.$goods['goods_id']);
		if($groupbuy)
		{
			$groupbuy['spec_price'] = unserialize($groupbuy['spec_price']);
			foreach ($goods['_specs'] as $key => $spec)
			{
				if (!empty($groupbuy['spec_price'][$spec['spec_id']]))
				{
					$goods['_specs'][$key]['group_price'] = $groupbuy['spec_price'][$spec['spec_id']]['price'];
				}
			}
		}		
        return $goods;
    }
	
	//异步修改数据
    function ajax_col()
    {
       $id     = empty($_GET['id']) ? 0 : intval($_GET['id']);
       $column = empty($_GET['column']) ? '' : trim($_GET['column']);
       $value  = isset($_GET['value']) ? trim($_GET['value']) : '';
       $data   = array();
	   if (in_array($column ,array('recommend')))
       {
		   // 如果不是审核通过的，不能设置为推荐
		   if(!$this->_ju_mod->get(array('conditions'=>'group_id='.$id.' AND status=1','fields'=>'group_id'))){
			   return;
		   }
           $data[$column] = $value;
           $this->_ju_mod->edit("group_id = " . $id , $data);
           if(!$this->_ju_mod->has_error())
           {
               echo ecm_json_encode(true);
           }
       }
       else
       {
           return ;
       }
       return ;
    }

}

?>