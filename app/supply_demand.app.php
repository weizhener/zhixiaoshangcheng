<?php

/**
 *    供求信息控制器
 *
 *    @author    Andcpp
 *    @usage    none
 */
class Supply_demandApp extends MemberbaseApp
{
    function index()
    {
		$type = (isset($_GET['type']) && $_GET['type'] != '') ? trim($_GET['type']) : 'supply';
        $conditions = 'user_id = ' . $this->visitor->get('user_id');
        switch ($type)
        {
            case 'supply':
                $conditions .= ' AND type = 1';
                break;
            case 'demand' :
                $conditions .= ' AND type = 2';
                break;
			case 'verify' :
                $conditions .= ' AND verify <> 1';
                break;
        };
        /* 取得列表数据 */
        $model_sdinfo =& m('sdinfo');
        $sdinfo     = $model_sdinfo->find(array(
            'conditions'    => $conditions,
        ));
        $this->assign('sdinfo', $sdinfo);

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                         LANG::get('supply_demand'), 'index.php?app=supply_demand',
                         LANG::get('supply_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('supply_demand');

        /* 当前所处子菜单 */
		$this->_curmenu('supply_list');
        $this->assign('_curmenu',$type.'_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('supply_list'));
        $this->display('suplly_demand.index.html');
    }

    /**
     *    添加地址
     *
     *    @author    Garbin
     *    @return    void
     */
    function add()
    {
        if (!IS_POST)
        {
            /* 当前位置 */
			$this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
							 LANG::get('supply_demand'), 'index.php?app=supply_demand',
							 LANG::get('add_info_free'));
	
			/* 当前用户中心菜单 */
			$this->_curitem('supply_demand');
	
			/* 当前所处子菜单 */
			$this->_curmenu('add_info');
            $this->assign('act', 'add');
            $this->_get_regions();
			
			$this->assign('editor_upload', $this->_build_upload(array(
                'obj' => 'EDITOR_SWFU',
                'belong' => BELONG_ARTICLE,
                'item_id' => $this->visitor->get('user_id'),
                'button_text' => Lang::get('bat_upload'),
                'button_id' => 'editor_upload_button',
                'progress_id' => 'editor_upload_progress',
                'upload_url' => 'index.php?app=swfupload',
                'if_multirow' => 1,
            )));
			$this->assign('build_editor', $this->_build_editor(array(
                 'name' => 'description',
                 'content_css' => SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}" . '/shop.css', // for preview
             )));
			 $this->assign('is_store',$this->visitor->get('manage_store'));
			 
			$this->assign('sdcategories', $this->_get_sdcategory_options(0)); // 商城分类第一级
			$type = array(
				'1' => Lang::get('supply'),
				'2' => Lang::get('demand'),
			);
			$this->assign('type',$type);
			$this->import_resource(array(
                 'script' => array(
                     array(
                         'path' => 'mlselection.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'path' => 'jquery.plugins/jquery.validate.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'path' => 'jquery.ui/jquery.ui.js',
                         'attr' => 'charset="utf-8"',
                     )
                 ),
                 'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
             ));
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('suplly_demand.form.html');
        }
        else
        {
            $data = array(
                'user_id'  		=> $this->visitor->get('user_id'),
				'type'			=> intval($_POST['type']),
                'cate_id'   	=> intval($_POST['cate_id']),
				'cate_name'		=> $_POST['cate_name'],
				'title'			=> $_POST['title'],
                'price_from'    => $_POST['price_from'],
				'price_to'   	=> $_POST['price_to'],
                'price'   		=> $_POST['price'],
				'region_id'     => $_POST['region_id'],
				'region_name'   => $_POST['region_name'],
                'name'     		=> $_POST['name'],
                'phone'     	=> $_POST['phone'],
				'content' 		=> $_POST['content'],
				'add_time' 		=> gmtime()
            );
            $model_sdinfo =& m('sdinfo');
            $model_sdinfo->add($data);
            $this->show_message('add_ok',
                'back_list', 'index.php?app=supply_demand',
                'continue_add', 'index.php?app=supply_demand&amp;act=add'
            );
        }
    }
    function edit()
    {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id)
        {
            echo Lang::get("no_such_info");
            return;
        }
        if (!IS_POST)
        {
			$model_sdinfo =& m('sdinfo');
            $info     = $model_sdinfo->get("id = {$id} AND user_id=" . $this->visitor->get('user_id'));
            if (empty($info))
            {
                echo Lang::get('no_such_info');

                return;
            }
			$this->assign('info',$info);
             /* 当前位置 */
			$this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
							 LANG::get('supply_demand'), 'index.php?app=supply_demand',
							 LANG::get('edit_info'));
	
			/* 当前用户中心菜单 */
			$this->_curitem('supply_demand');
	
			/* 当前所处子菜单 */
			$this->_curmenu('edit_info');
            $this->assign('act', 'edit');
            $this->_get_regions();
			
			$this->assign('editor_upload', $this->_build_upload(array(
                'obj' => 'EDITOR_SWFU',
                'belong' => BELONG_ARTICLE,
                'item_id' => $this->visitor->get('user_id'),
                'button_text' => Lang::get('bat_upload'),
                'button_id' => 'editor_upload_button',
                'progress_id' => 'editor_upload_progress',
                'upload_url' => 'index.php?app=swfupload',
                'if_multirow' => 1,
            )));
			$this->assign('build_editor', $this->_build_editor(array(
                 'name' => 'description',
                 'content_css' => SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}" . '/shop.css', // for preview
             )));
			 $this->assign('is_store',$this->visitor->get('manage_store'));
			 
			$this->assign('sdcategories', $this->_get_sdcategory_options(0)); // 商城分类第一级
			$type = array(
				'1' => Lang::get('supply'),
				'2' => Lang::get('demand'),
			);
			$this->assign('type',$type);
			$this->import_resource(array(
                 'script' => array(
                     array(
                         'path' => 'mlselection.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'path' => 'jquery.plugins/jquery.validate.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'path' => 'jquery.ui/jquery.ui.js',
                         'attr' => 'charset="utf-8"',
                     )
                 ),
                 'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
             ));
            header('Content-Type:text/html;charset=' . CHARSET);
            $this->display('suplly_demand.form.html');
        }
        else
        {
           $data = array(
				'type'			=> intval($_POST['type']),
                'cate_id'   	=> intval($_POST['cate_id']),
				'cate_name'		=> $_POST['cate_name'],
				'title'			=> $_POST['title'],
                'price_from'    => $_POST['price_from'],
				'price_to'   	=> $_POST['price_to'],
                'price'   		=> $_POST['price'],
                'images'        => $_POST['gimage'],
				'region_id'     => $_POST['region_id'],
				'region_name'   => $_POST['region_name'],
                'name'     		=> $_POST['name'],
                'phone'     	=> $_POST['phone'],
				'verify'		=> 0,
				'content' 		=> $_POST['content']
            );
            $model_sdinfo =& m('sdinfo');
            $model_sdinfo->edit($id,$data);
            $this->show_message('edit_ok',
                'back_list', 'index.php?app=supply_demand',
                'continue_edit', 'index.php?app=supply_demand&amp;act=eidt&amp;&id='.$id
            );
        }
    }
    function drop()
    {
        $id = isset($_GET['id']) ? trim($_GET['id']) : 0;
        if (!$id)
        {
            $this->show_warning('no_such_info');

            return;
        }
        $ids = explode(',', $id);//获取一个类似array(1, 2, 3)的数组
        $model_sdinfo  =& m('sdinfo');
        $drop_count = $model_sdinfo->drop("user_id = " . $this->visitor->get('user_id') . " AND id " . db_create_in($ids));
        if (!$drop_count)
        {
            /* 没有可删除的项 */
            $this->show_warning('no_such_info');

            return;
        }

        if ($model_sdinfo->has_error())    //出错了
        {
            $this->show_warning($model_sdinfo->get_error());

            return;
        }

        $this->show_message('drop_successed');
    }
    function _get_regions()
    {
        $model_region =& m('region');
        $regions = $model_region->get_list(0);
        if ($regions)
        {
            $tmp  = array();
            foreach ($regions as $key => $value)
            {
                $tmp[$key] = $value['region_name'];
            }
            $regions = $tmp;
        }
        $this->assign('regions', $regions);
    }
    /**
     *    三级菜单
     *
     *    @author    Garbin
     *    @return    void
     */
    function _get_member_submenu()
    {
        $menus = array(
            array(
                'name'  => 'supply_list',
                'url'   => 'index.php?app=supply_demand',
            ),
			array(
                'name'  => 'demand_list',
                'url'   => 'index.php?app=supply_demand&type=demand',
            ),
			array(
                'name'  => 'verify_list',
                'url'   => 'index.php?app=supply_demand&type=verify',
            ),

        );
        if (ACT == 'add')
        {
            $menus[] = array(
                'name' => 'add_info',
                'url'  => '',
            );
        }else if(ACT == 'edit'){
			$menus[] = array(
                'name' => 'edit_info',
                'url'  => '',
            );
		}
        return $menus;
    }
	
	/* 取得分类，指定parent_id */
    function _get_sdcategory_options($parent_id = 0)
    {
        $res = array();
        $mod =&m('sdcategory');
        $sdcategories = $mod->get_list($parent_id, true);
        foreach ($sdcategories as $category)
        {
                  $res[$category['cate_id']] = $category['cate_name'];
        }
        return $res;
    }
}

?>