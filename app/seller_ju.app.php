<?php
/* 聚品牌申请状态 */
define('BRAND_PASSED', 1);
define('BRAND_REFUSE', 0);
/**
 *    卖家团购管理控制器
 *
 *    @author    Hyber
 *    @usage    none
 */
class Seller_juApp extends StoreadminbaseApp
{
    var $_store_id;
    var $_goods_mod;
    var $_ju_mod;
	var $_jucate_mod;
	var $_jutemplate_mod;
	var $_uploadedfile_mod;
    var $_last_update_id;
	var $_brand_mod;

    /* 构造函数 */
    function __construct()
    {
         $this->Seller_juApp();
    }

    function Seller_juApp()
    {
        parent::__construct();
        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_goods_mod =& m('goods');
        $this->_ju_mod =& bm('ju', array('_store_id'=> $this->_store_id));
		$this->_jucate_mod =&m('jucate');
		$this->_jutemplate_mod =&m('jutemplate');
		$this->_uploadedfile_mod =& m('uploadedfile');
		$this->_brand_mod = &m('jubrand');
    }

    function index()
    {
        /* 取得列表数据 */
        $conditions = $this->_get_query_conditions(array(
            array(      //按团购状态搜索
                'field' => 'status',
                'name'  => 'status',
                'equal' => '=',
            ),
            array(      //按团购名称搜索
                'field' => 'group_name',
                'name'  => 'group_name',
                'equal' => 'LIKE',
            ),
        ));
        // 标识有没有过滤条件
        if ($conditions)
        {
            $this->assign('filtered', 1);
        }

        $page   =   $this->_get_page(10);    //获取分页信息
        $groupbuy_list = $this->_ju_mod->find(array(
			'join' 	=> 'belong_goods',
			'conditions' => 'ju.store_id=' . $this->_store_id . $conditions,
			'order' => 'ju.group_id DESC',
			'limit' => $page['limit'],  //获取当前页的数据
			'fields'=>'this.*,g.goods_id,g.goods_name,g.store_id,g.default_spec,g.price,g.default_image',
			'count' => true
		));
		$page['item_count'] = $this->_ju_mod->getCount();   //获取统计的数据
		
		import('init.lib');
		$init = new Init_Seller_juApp();
		$groupbuy_list = $init->format_groupbuy_list($groupbuy_list, $this->_ju_mod, $this->_jutemplate_mod);

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                         LANG::get('ju'), 'index.php?app=seller_ju',
                         LANG::get('groupbuy_list'));

        /* 当前用户中心菜单 */
        $this->_curitem('ju');

        /* 当前所处子菜单 */
        $this->_curmenu('groupbuy_list');
        $this->_format_page($page);
        $this->_import_resource();
        $this->assign('page_info', $page);          //将分页信息传递给视图，用于形成分页条
        $this->assign('groupbuy_list', $groupbuy_list);
        $this->assign('status', array(' ' => Lang::get('group_all'),
			 '1' => Lang::get('verified'),
             '0' => Lang::get('verifying'),
			 '3' => Lang::get('wait_edit'),
			 '2' => Lang::get('verify_no_pass'),
        ));
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('groupbuy_manage'));
        $this->display('seller_ju.index.html');
    }

    function add()
    {
        if (!IS_POST)
        {
			$brands = $this->_brand_mod->find(array(
				'conditions' => 'if_show=1',
				'fields' => 'brand_name'
			));
			foreach($brands as $key => $brand)
			{
				$ju_brands[$key] = $brand['brand_name']; 
			}
			$this->assign('ju_brands', $ju_brands);
			$channel_options = array(
				'1'	=> LANG::get('ju_index'),
				'2'	=> LANG::get('ju_brand'),
				'3' => LANG::get('ju_mingpin'),
				'4'	=> LANG::get('ju_decoration'),
				'5'	=> LANG::get('ju_life'),
				'6' => LANG::get('ju_travel'),
			);
			$this->assign('channel_options', $channel_options);
			
			$groupbuy_cate = $this->_jucate_mod->find(array(
				'condition' => '',
			)); //查找全部团购分类，下来选择
			$groupbuy_template = $this->_jutemplate_mod->find(array(
				'conditions' => 'state <> 2 and join_end_time>'.gmtime(),
			));//查询可以报名的团购活动
            $goods_mod = &bm('goods', array('_store_id' => $this->_store_id));
            $goods_count = $goods_mod->get_count();
            if ($goods_count == 0)
            {
                $this->show_warning('has_no_goods', 'add_goods', 'index.php?app=my_goods&act=add');
                return;
            }
			
			//传给iframe参数belong, item_id
			$this->assign('belong', BELONG_GROUPBUY);
            $this->assign('id', $this->_store_id);
			
			$this->assign('editor_upload', $this->_build_upload(array(
                'obj' => 'EDITOR_SWFU',
                'belong' => BELONG_GROUPBUY,
                'item_id' => $this->_store_id,
                'button_text' => Lang::get('bat_upload'),
                'button_id' => 'editor_upload_button',
                'progress_id' => 'editor_upload_progress',
                'upload_url' => 'index.php?app=swfupload',
                'if_multirow' => 1,
            )));
            
            extract($this->_get_theme());
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'description',
                'content_css' => SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}" . '/shop.css', // for preview
            )));
			
			/* 当前位置 */
			$this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
							 LANG::get('ju'), 'index.php?app=seller_ju',
							 LANG::get('add_groupbuy'));
	
			/* 当前用户中心菜单 */
			$this->_curitem('ju');
            /* 当前所处子菜单 */
            $this->_curmenu('add_groupbuy');
			$this->assign('categories', $this->_get_category_options(0)); // 商城分类第一级
			$this->assign('groupbuy_cate',$groupbuy_cate);
			$this->assign('groupbuy_template',$groupbuy_template);
            $this->assign('group', array('max_per_user' => 0, 'end_time' => gmtime() + 7 * 24 * 3600));
            $this->assign('store_id', $this->_store_id);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('add_groupbuy'));
            $this->_import_resource();
            $this->display('seller_ju.form.html');
        }
        else
        {
            /* 检查数据 */
            if (!$this->_handle_post_data($_POST, 0))
            {
                $this->show_warning($this->get_error());
                return;
            }
			//  立即更新
			$cache_server =& cache_server();
        	$cache_server->clear();
			
            $this->show_message('add_groupbuy_ok',
                'back_list', 'index.php?app=seller_ju',
                'continue_add', 'index.php?app=seller_ju&amp;act=add'
            );
        }
    }

    function edit()
    {
		$groupbuy_cate = $this->_jucate_mod->find(array(
				'conditions' => '',
		));
		$groupbuy_template = $this->_jutemplate_mod->find(array(
				'conditions' => 'state <> 2',
		));
        $id = empty($_GET['id']) ? 0 : $_GET['id'];
        if (!$id)
        {
            $this->show_warning('no_such_groupbuy');
            return false;
        }
        if (!IS_POST)
        {
			$brands = $this->_brand_mod->find(array(
				'conditions' => 'if_show=1',
				'fields' => 'brand_name'
			));
			foreach($brands as $key => $brand)
			{
				$ju_brands[$key] = $brand['brand_name']; 
			}
			$this->assign('ju_brands', $ju_brands);
			$channel_options = array(
				'1'	=> LANG::get('ju_index'),
				'2'	=> LANG::get('ju_brand'),
				'3' => LANG::get('ju_mingpin'),
				'4'	=> LANG::get('ju_decoration'),
				'5'	=> LANG::get('ju_life'),
				'6' => LANG::get('ju_travel'),
			);
			$this->assign('channel_options', $channel_options);
            /* 当前位置 */
            $this->_curlocal(LANG::get('member_center'),    'index.php?app=member',
                             LANG::get('groupbuy_manage'), 'index.php?app=seller_ju',
                             LANG::get('edit_groupbuy'));

            /* 当前用户中心菜单 */
            $this->_curitem('ju');

            /* 当前所处子菜单 */
            $this->_curmenu('edit_groupbuy');

            /* 团购信息 */
            $group = $this->_ju_mod->get($id);
            $group['spec_price'] = unserialize($group['spec_price']);
            $goods = $this->_query_goods_info($group['goods_id']);
			$goods['channel_name'] = $channel_options[$group['channel']];//获得聚划算所属频道
			$goods['channel'] = $group['channel'];
			$template = $this->_jutemplate_mod->get($group['template_id']);
			$goods['template_id'] = $group['template_id'];
			$goods['template_name'] = $template['template_name'];//获得聚划算活动
			$cate = $this->_jucate_mod->get($group['cate_id']);
			$goods['ju_cate_id'] = $group['cate_id'];
			$goods['ju_cate'] = $cate['cate_name']; //获得聚划算分类
		    $goods['brand_id'] = $group['brand_id'];
            foreach ($goods['_specs'] as $key => $spec)
            {
                if (!empty($group['spec_price'][$spec['spec_id']]))
                {
                    $goods['_specs'][$key]['group_price'] = $group['spec_price'][$spec['spec_id']]['price'];
                }
            }
			$this->assign('groupbuy_cate',$groupbuy_cate);
			$this->assign('groupbuy_template',$groupbuy_template);
			$this->assign('group', $group);
            $this->assign('goods', $goods);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('edit_groupbuy'));
            $this->_import_resource();
			
			//传给iframe参数belong, item_id
			$this->assign('belong', BELONG_GROUPBUY);
            $this->assign('id', $this->_store_id);
			
			$this->assign('editor_upload', $this->_build_upload(array(
                'obj' => 'EDITOR_SWFU',
                'belong' => BELONG_GROUPBUY,
                'item_id' => $this->_store_id,
                'button_text' => Lang::get('bat_upload'),
                'button_id' => 'editor_upload_button',
                'progress_id' => 'editor_upload_progress',
                'upload_url' => 'index.php?app=swfupload',
                'if_multirow' => 1,
            )));
            
            extract($this->_get_theme());
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'description',
                'content_css' => SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}" . '/shop.css', // for preview
            )));
			$this->assign('categories', $this->_get_category_options(0)); // 商城分类第一级
            $this->display('seller_ju.form.html');
        }
        else
        {
            /* 检查数据 */
            if (!$this->_handle_post_data($_POST, $id))
            {
                $this->show_warning($this->get_error());
                return;
            }
			//  立即更新
			$cache_server =& cache_server();
        	$cache_server->clear();
			
            $this->show_message('edit_groupbuy_ok',
                'back_list', 'index.php?app=seller_ju',
                'continue_edit', 'index.php?app=seller_ju&act=edit&id=' . $id
            );
        }
    }

    function drop()
    {
        $id = empty($_GET['id']) ? 0 : $_GET['id'];
        if (!$id)
        {
            $this->show_warning('no_such_groupbuy');
            return false;
        }
        if (!$this->_ju_mod->drop($id))
        {
            $this->show_warning($this->_ju_mod->get_error());

            return;
        }

        $this->show_message('drop_groupbuy_successed');
    }
	
	 //聚品牌申请列表
    function brand_list()
    {
        $_GET['store_id'] = $this->_store_id;
        $_GET['if_show'] = BRAND_PASSED;
        $con = array(
            array(
                'field' => 'store_id',
                'name'  => 'store_id',
                'equal' => '=',
            ),
            array(
                'field' => 'if_show',
                'name'  => 'if_show',
                'equal' => '=',
                'assoc' => 'or',
            ),);
        $filtered = '';
        if (!empty($_GET['brand_name']) || !empty($_GET['store']))
        {
            $_GET['brand_name'] && $filtered = " AND brand_name LIKE '%{$_GET['brand_name']}%'";
            $_GET['store'] && $filtered = $filtered . " AND store_id = " . $this->_store_id;
        }
        if (isset($_GET['sort']) && isset($_GET['order']))
        {
            $sort  = strtolower(trim($_GET['sort']));
            $order = strtolower(trim($_GET['order']));
            if (!in_array($order,array('asc','desc')))
            {
                $sort  = 'store_id';
                $order = 'desc';
            }
        }
        else
        {
            $sort  = 'store_id';
            $order = 'desc';
        }
        $page = $this->_get_page(10);
        $conditions = $this->_get_query_conditions($con);
        $brand = $this->_brand_mod->find(array(
            'conditions' => "(1=1 $conditions)" . $filtered,
            'limit' => $page['limit'],
            'order' => "$sort $order",
            'count' => true,
        ));
        $page['item_count'] = $this->_brand_mod->getCount();
        $this->_format_page($page);
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('ju'), 'index.php?app=seller_ju',
                         LANG::get('ju_brand'));
        $this->_curitem('ju');
        $this->_curmenu('ju_brand');
        $this->import_resource(array(
                 'script' => array(
                     array(
                         'path' => 'jquery.plugins/jquery.validate.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'path' => 'jquery.ui/jquery.ui.js',
                         'attr' => 'charset="utf-8"',
                     ),
                     array(
                         'attr' => 'id="dialog_js" charset="utf-8"',
                         'path' => 'dialog/dialog.js',
                     ),
                 ),
                 'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
             ));
        $this->assign('page_info', $page);
        $this->assign('filtered', empty($filtered) ? 0 : 1);
        $this->assign('brands', $brand);
        $this->display('seller_ju.brandlist.html');
    }

    //聚品牌申请

    function brand_apply()
    {
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->display('seller_ju.brandapply.html');
        }
        else
        {
            $brand_name = trim($_POST['brand_name']);
            if (empty($brand_name))
            {
                $this->pop_warning("brand_name_required");
                exit;
            }

            if (!$this->_brand_mod->unique($brand_name))
            {
                $this->pop_warning('brand_name_exist');
                return;
            }
            if (!$brand_id = $this->_brand_mod->add(array('brand_name' => $brand_name, 'store_id' => $this->_store_id, 'if_show' => 0, 'tag' => trim($_POST['tag']))))  //获取brand_id
            {
                $this->pop_warning($this->_brand_mod->get_error());

                return;
            }

            $logo = $this->_upload_logo($brand_id);
            if ($logo === false)
            {
                return;
            }
            $this->_brand_mod->edit($brand_id, array('brand_logo' => $logo));
            $this->pop_warning('ok',
                'seller_ju_brand_apply', 'index.php?app=seller_ju&act=brand_list');
        }
    }

    function brand_edit()
    {
        $id = intval($_GET['id']);
        $brand = $this->_brand_mod->find('store_id = ' . $this->_store_id . ' AND if_show = ' . BRAND_REFUSE . ' AND brand_id = ' . $id);
        $brand = current($brand);
        if (empty($brand))
        {
            $this->show_warning("not_rights");
            exit;
        }
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->assign('brand', $brand);
            $this->display('seller_ju.brandapply.html');
        }
        else
        {
            $brand_name = trim($_POST['brand_name']);
            if (!$this->_brand_mod->unique($brand_name, $id))
            {
                $this->pop_warning('brand_name_exist');
                return;
            }
            $data = array();
            if (isset($_FILES['brand_logo']) && !empty($_FILES['brand_logo']['name']))
            {
                $logo = $this->_upload_logo($id);
                if ($logo === false)
                {
                    return;
                }
                $data['brand_logo'] = $logo;
            }
            $data['brand_name'] = $brand_name;
            $data['tag'] = trim($_POST['tag']);
            $this->_brand_mod->edit($id, $data);
            if ($this->_brand_mod->has_error())
            {
                $this->pop_warning($this->_brand_mod->get_error());
                exit;
            }
            $this->pop_warning('ok',
                'seller_ju_brand_edit', 'index.php?app=seller_ju&act=brand_list');
        }

    }

    function brand_drop()
    {
        $id = intval($_GET['id']);
        if (empty($id))
        {
            $this->show_warning('request_error');
            exit;
        }
        $brand = $this->_brand_mod->find("store_id = " . $this->_store_id . " AND if_show = " . BRAND_REFUSE . " AND brand_id = " . $id);
        $brand = current($brand);
        if (empty($brand))
        {
            $this->show_warning('request_error');
            exit;
        }
        if (!$this->_brand_mod->drop($id))
        {
            $this->show_warning($this->_brand_mod->get_error());
            exit;
        }
        if (!empty($brand['brand_logo']) && file_exists(ROOT_PATH . '/' . $brand['brand_logo']))
        {
            @unlink(ROOT_PATH . '/' . $brand['brand_logo']);
        }
        $this->show_message('drop_brand_ok',
            'back_list', 'index.php?app=seller_ju&act=brand_list');

    }

    function check_brand()
    {
        $brand_name = $_GET['brand_name'];
        if (!$brand_name)
        {
            echo ecm_json_encode(true);
            return ;
        }
        if ($this->_brand_mod->unique($brand_name))
        {
            echo ecm_json_encode(true);
        }
        else
        {
            echo ecm_json_encode(false);
        }
        return ;
    }
	
    function _upload_logo($brand_id)
    {
        $file = $_FILES['brand_logo'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE || !isset($_FILES['brand_logo'])) // 没有文件被上传
        {
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['brand_logo']);//上传logo
        if (!$uploader->file_info())
        {
            $this->pop_warning($uploader->get_error());        
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/mall/ju_brand', $brand_id))   //保存到指定目录，并以指定文件名$brand_id存储
        {
            return $file_path;
        }
        else
        {
            return false;
        }
    }
	
    /**
     * 检查提交的数据
     */
    function _handle_post_data($post, $id = 0)
    {
		$template_id = isset($_POST['template_id']) ? intval($_POST['template_id']) : 0;
		if (!$template_id)
        {
            $this->_error('select_template');
            return false;
        }
		$cate_id = isset($_POST['cate_id']) ? intval($_POST['cate_id']) : 0;
        if (($post['goods_id'] = intval($post['goods_id'])) == 0)
        {
            $this->_error('fill_goods');
            return false;
        }
		if(!$id)
		{
			$ju = $this->_ju_mod->get(array('conditions'=>'goods_id='.$post['goods_id'].' AND store_id='.$this->_store_id,'fields'=>'group_id'));
			if($ju){
				$this->_error('has_joined');
				return false;
			}
		}
        foreach($post['price'] as $key => $val)
        {
            if (empty($post['group_price'][$key]) || $post['group_price'][$key]<0 || $post['group_price'][$key] >= $val)
            {
                $this->_error('invalid_group_price');
                return false;
            }
            $spec_price[$key] = array('price' => $this->_filter_price($post['group_price'][$key]));
        }
        $data = array(
            'group_name' => $post['group_name'],
            'group_desc' => $post['group_desc'],
            'goods_id'   => $post['goods_id'],
            'spec_price' => serialize($spec_price),
            'max_per_user' => $post['max_per_user'],
			'status' => 0,
            'store_id'     => $this->_store_id,
			'template_id'  => $template_id,
			'cate_id' => $cate_id,
			'recommend' => 0,
			'channel' => $post['channel'],
			'brand_id' => $_POST['brand_id']
        );
        if ($id > 0)
        {
			$image = $this->_upload_image($this->_store_id);
			$image && $data['image'] = $image;
            if ($image === false)
            {
                return;
            }
            $this->_ju_mod->edit($id, $data);
            if ($this->_ju_mod->has_error())
            {
                $this->_error($this->_ju_mod->get_error());
                return false;
            }
        }
        else
        {
            if (!($id = $this->_ju_mod->add($data)))
            {
                $this->_error($this->_ju_mod->get_error());
                return false;
            }
			else
			{
				 /* 处理上传的图片 */
				$image       =   $this->_upload_image($this->_store_id);
				if ($image === false)
				{
					return false;
				}
				$this->_ju_mod->edit($id, array('image' => $image)); //将image地址记下
			}
        }
		$this->_last_update_id = $id;

        return true;
    }
	
	/**
     *    处理上传标志
     *
     *    @author    Garbin
     *    @param     int $store_id
     *    @return    string
     */
    function _upload_image($store_id)
    {
        $file = $_FILES['gimage'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE) // 没有文件被上传
        {
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['gimage']);//上传
        if (!$uploader->file_info())
        {
            $this->show_warning($uploader->get_error());
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/store_'.$store_id.'/groupbuy', $uploader->random_filename()))//保存到指定目录
        {
            return $file_path;
        }
        else
        {
            return false;
        }
    }

    function query_goods_info()
    {
        $goods_id = empty($_GET['goods_id']) ? 0 : intval($_GET['goods_id']);
        if ($goods_id)
        {
            $goods = $this->_query_goods_info($goods_id);
            $this->json_result($goods);
        }
    }

    function _query_goods_info($goods_id)
    {
        $goods = $this->_goods_mod->get_info($goods_id);
        if ($goods['spec_qty'] ==1 || $goods['spec_qty'] ==2)
        {
            $goods['spec_name'] = htmlspecialchars($goods['spec_name_1'] . ($goods['spec_name_2'] ? ' ' . $goods['spec_name_2'] : ''));
        }
        else
        {
            $goods['spec_name'] = Lang::get('spec');
        }
        foreach ($goods['_specs'] as $key => $spec)
        {
            if ($goods['spec_qty'] ==1 || $goods['spec_qty'] ==2)
            {
                $goods['_specs'][$key]['spec'] = htmlspecialchars($spec['spec_1'] . ($spec['spec_2'] ? ' ' . $spec['spec_2'] : ''));
            }
            else
            {
                $goods['_specs'][$key]['spec'] = Lang::get('default_spec');
            }
        }
        $goods['default_image'] || $goods['default_image'] = Conf::get('default_goods_image');
        return $goods;
    }
    function query_goods()
    {
        $goods_mod = &bm('goods', array('_store_id' => $this->_store_id));

        /* 搜索条件 */
        $conditions = "1 = 1";
        if (trim($_GET['goods_name']))
        {
            $str = "LIKE '%" . trim($_GET['goods_name']) . "%'";
            $conditions .= " AND (goods_name {$str})";
        }

        if (intval($_GET['sgcate_id']) > 0)
        {
            $cate_mod =& bm('gcategory', array('_store_id' => $this->visitor->get('manage_store')));
            $cate_ids = $cate_mod->get_descendant(intval($_GET['sgcate_id']));
        }
        else
        {
            $cate_ids = 0;
        }

        /* 取得商品列表 */
        $goods_list = $goods_mod->get_list(array(
            'conditions' => $conditions . ' AND g.if_show=1 AND g.closed=0',
            'order' => 'g.add_time DESC',
            'limit' => 100,
        ), $cate_ids);

        foreach ($goods_list as $key => $val)
        {
            $goods_list[$key]['goods_name'] = htmlspecialchars($val['goods_name']);
        }
        $this->json_result($goods_list);
    }

    function _import_resource()
    {
        if(in_array(ACT, array('index' , 'add', 'edit')))
        {
            $resource['script'][] = array( // JQUERY UI
                'path' => 'jquery.ui/jquery.ui.js'
            );
        }
        if(in_array(ACT, array('index', 'add', 'edit')))
        {
            $resource['script'][] = array( // 对话框
                'attr' => 'id="dialog_js"',
                'path' => 'dialog/dialog.js'
            );
        }
        if(in_array(ACT, array('add', 'edit')))
        {
            $resource['script'][] = array( // 验证
                'path' => 'jquery.plugins/jquery.validate.js'
            );
			$resource['script'][] = array( // 选择分类
                'path' => 'mlselection.js',
                'attr' => 'charset="utf-8"',
            );
        }
        if(in_array(ACT, array('add', 'edit'))) //日历相关
        {
            $resource['script'][] = array(
                'path' => 'jquery.ui/i18n/' . i18n_code() . '.js'
            );
            $resource['style'] .= 'jquery.ui/themes/ui-lightness/jquery.ui.css';
        }
        $this->import_resource($resource);
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
                'name'  => 'groupbuy_list',
                'url'   => 'index.php?app=seller_ju',
            ),
			array(
                'name'  => 'ju_brand',
                'url'   => 'index.php?app=seller_ju&act=brand_list',
            ),
        );
        if (ACT == 'add' || ACT == 'edit' || ACT == 'desc' || ACT == 'cancel')
        {
            $menus[] = array(
                'name' => ACT . '_groupbuy',
                'url'  => '',
            );
        }
        return $menus;
    }
	
	/* 异步删除附件 */
    function drop_uploadedfile()
    {
        $file_id = isset($_GET['file_id']) ? intval($_GET['file_id']) : 0;
        $file = $this->_uploadedfile_mod->get($file_id);
        if ($file_id && $file['store_id'] == $this->visitor->get('manage_store') && $this->_uploadedfile_mod->drop($file_id))
        {
            $this->json_result('drop_ok');
            return;
        }
        else
        {
            $this->json_error('drop_error');
            return;
        }
    }
	/* 价格过滤，返回非负浮点数 */
    function _filter_price($price)
    {
        return abs(floatval($price));
    }
	
	/* 取得聚分类，指定parent_id */
    function _get_category_options($parent_id = 0)
    {
        $res = array();
        $mod_jucate =&m('jucate');
        $categories = $mod_jucate->get_list($parent_id, true);
        foreach ($categories as $category)
        {
                  $res[$category['cate_id']] = $category['cate_name'];
        }
        return $res;
    }
	
	function channel_json()
	{
		$pid = empty($_GET['pid']) ? 0 : $_GET['pid'];
		$templates = $this->_jutemplate_mod->find(array(
			'conditions' => 'state <> 2 and join_end_time>'.gmtime().' AND channel='.$pid
		));
		foreach($templates as $key => $template)
		{
			$data[$key] = array( 
				'template_id' => $template['template_id'],
				'template_name' => $template['template_name'].'('. date("Y/m/d", $template['start_time']).'-'.date("Y/m/d", $template['end_time']).')'.LANG::get('join_endtime'). date("Y/m/d", $template['join_end_time'])
			);
		}
		if($data)
		{
			$this->json_result(array_values($data));
			return;
		}
		else
		{
			$this->json_error('no_template_error');
			return;
		}
	}

}

?>
