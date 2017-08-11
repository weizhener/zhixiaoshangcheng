<?php

/**
 *    合作伙伴控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
class My_oauthApp extends StoreadminbaseApp
{
    var $_partner_mod;
    var $_store_id;
    function __construct()
    {
        $this->PartnerApp();
    }

    function PartnerApp()
    {
        parent::__construct();
        $this->_store_id = intval($this->visitor->get('manage_store'));
        $this->_partner_mod =& m('myoauth');
    }

    /**
     *    管理
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function index()
    {
		
	
     $conditions = $this->_get_query_conditions(array(
            array(
                'field' => $_GET['field_name'],
                'name'  => 'field_value',
                'equal' => 'like',
            ),
        ));
        $page   =   $this->_get_page(100);    //获取分页信息
        $partners = $this->_partner_mod->find(array(
            'conditions'    =>'1=1 and store_id='.$this->_store_id. $conditions,
            'limit'         => $page['limit'],  //获取当前页的数据
            'order'         => 'id desc',
            'count'         => true             //允许统计
        )); //找出所有商城的合作伙伴
      
        $page['item_count'] = $this->_partner_mod->getCount();   //获取统计的数据
        $this->_format_page($page);
        $this->import_resource(array('script' => 'inline_edit.js'));
        $this->assign('filtered', $conditions? 1 : 0); //是否有查询条件
        $this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条
        $this->assign('partners', $partners);
		
		    /* 当前用户中心菜单 */
            $this->_curitem('my_oauth');

            /* 当前所处子菜单 */
            $this->_curmenu('my_oauth');
		
        $this->display('myoauth.index.html');
    }
    /**
     *    新增
     *
     *    @author    Garbin
     *    @return    void
     */
    function add()
    {
		
		 $partner_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!IS_POST)
        {
         
		   if($partner_id)
		   {
		$partner=  $this->_partner_mod->get($partner_id);
		   }
		 	
		    /* 当前用户中心菜单 */
            $this->_curitem('my_oauth');

            /* 当前所处子菜单 */
            $this->_curmenu('my_oauth');
		 
            $this->assign('partner' , $partner);
            $this->import_resource('jquery.plugins/jquery.validate.js');
            $this->display('myoauth.form.html');
        }
        else
        {
            $data = array();
          
            $data['name']      =   $_POST['name'];
            $data['url']       =   $_POST['url'];
            $data['store_id'] =   $this->_store_id;
			
            
			if( $partner_id)
			{
			
			 if (!$partner_id = $this->_partner_mod->edit($partner_id,$data))  //获取partner_id
            {
                $this->show_warning($this->_partner_mod->get_error());

                return;
            }
			
			}else
			{
			
			 if (!$partner_id = $this->_partner_mod->add($data))  //获取partner_id
            {
                $this->show_warning($this->_partner_mod->get_error());

                return;
            }
			
			}
			
           

          

           
            $this->show_message('提交成功',
                'back_list',    'index.php?app=my_oauth',
                'continue_add', 'index.php?app=my_oauth&amp;act=add'
            );
        }
    }

    /**
     *    编辑
     *
     *    @author    Garbin
     *    @return    void
     */
    function edit()
    {
        $partner_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (!$partner_id)
        {
            $this->show_warning('no_such_partner');

            return;
        }
        if (!IS_POST)
        {
            $find_data     = $this->_partner_mod->find($partner_id);
            if (empty($find_data))
            {
                $this->show_warning('no_such_partner');

                return;
            }
            $partner    =   current($find_data);
            if ($partner['logo'])
            {
                $partner['logo']  =   dirname(site_url()) . "/" . $partner['logo'];
            }
            $this->assign('partner', $partner);
            $this->import_resource('jquery.plugins/jquery.validate.js');
            $this->display('partner.form.html');
        }
        else
        {
            $data = array();
            $data['title']      =   $_POST['title'];
            $data['link']       =   $_POST['link'];
            $data['sort_order'] =   $_POST['sort_order'];
            $logo               =   $this->_upload_logo($partner_id);
            $logo && $data['logo'] = $logo;
            if ($logo === false)
            {
                return;
            }
            $rows = $this->_partner_mod->edit($partner_id, $data);
            if ($this->_partner_mod->has_error())    //有错误
            {
                $this->show_warning($this->_partner_mod->get_error());

                return;
            }
			//写入日志                                                                           
            $user_name= $this->visitor->get('user_name');
            $user_id = $this->visitor->get('user_id');
            setadminlog($user_id,$user_name,site_url(),'微信oauth',$user_name.'编辑了微信oauth：'.$data['title'],$user_id,6);
            $this->show_message('edit_partner_successed',
                'back_list',     'index.php?app=my_oauth',
                'edit_again', 'index.php?app=my_oauth&amp;act=edit&amp;id=' . $partner_id);
        }
    }

    //异步修改数据
   function ajax_col()
   {
       $id     = empty($_GET['id']) ? 0 : intval($_GET['id']);
       $column = empty($_GET['column']) ? '' : trim($_GET['column']);
       $value  = isset($_GET['value']) ? trim($_GET['value']) : '';
       $data   = array();

       if (in_array($column ,array('title', 'sort_order')))
       {
           $data[$column] = $value;
           $this->_partner_mod->edit($id, $data);
           if(!$this->_partner_mod->has_error())
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

    function drop()
    {
        $partner_ids = isset($_GET['id']) ? trim($_GET['id']) : 0;
        if (!$partner_ids)
        {
            $this->show_warning('no_such_partner');

            return;
        }
        $partner_ids = explode(',', $partner_ids);//获取一个类似array(1, 2, 3)的数组
        if (!$this->_partner_mod->drop($partner_ids))    //删除
        {
            $this->show_warning($this->_partner_mod->get_error());

            return;
        }
			//写入日志                                                                           
            $user_name= $this->visitor->get('user_name');
            $user_id = $this->visitor->get('user_id');
            setadminlog($user_id,$user_name,site_url(),'微信oauth',$user_name.'删除了微信oauth：',$user_id,6);
        $this->show_message('drop_partner_successed');
    }

    /* 更新排序 */
    function update_order()
    {
        if (empty($_GET['id']))
        {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $ids = explode(',', $_GET['id']);
        $sort_orders = explode(',', $_GET['sort_order']);
        foreach ($ids as $key => $id)
        {
            $this->_partner_mod->edit($id, array('sort_order' => $sort_orders[$key]));
        }

        $this->show_message('update_order_ok');
    }

    /**
     *    处理上传标志
     *
     *    @author    Garbin
     *    @param     int $partner_id
     *    @return    string
     */
    function _upload_logo($partner_id)
    {
        $file = $_FILES['logo'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE) // 没有文件被上传
        {
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['logo']);//上传logo
        if (!$uploader->file_info())
        {
            $this->show_warning($uploader->get_error() , 'go_back', 'index.php?app=my_oauth&amp;act=edit&amp;id=' . $partner_id);
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/mall/partner', $partner_id))   //保存到指定目录，并以指定文件名$partner_id存储
        {
            return $file_path;
        }
        else
        {
            return false;
        }
    }
}

?>
