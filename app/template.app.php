<?php

/* 挂件基础类 */
include(ROOT_PATH . '/includes/widget.base.php');

/**
 *    店铺模板编辑控制器
 *
 *    @author    Andcpp
 *    @usage    none
 */
class TemplateApp extends StoreadminbaseApp
{
	var $_store_id;
    var $_store_mod;

    function __construct()
    {
        $this->TemplateApp();
    }
    function TemplateApp()
    {
        parent::__construct();
        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_store_mod =& m('store');
    }
    /* 可编辑的页面列表 */
    function index()
    {
		/* 当前页面信息 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('template'));
        $this->_curitem('template');
        $this->_curmenu('template');
        $this->assign('pages', $this->_get_editable_pages());
        $this->display('template.index.html');
    }
	
	function _get_member_submenu()
    {
        return array(
            array(
                'name' => 'template',
                'url'  => 'index.php?app=template',
            ),
        );
    }


    /**
     *    编辑页面
     *
     *    @author    Garbin
     *    @return    void
     */
    function edit()
    {
        /* 当前所编辑的页面 */
        $page    = !empty($_GET['page']) ? trim($_GET['page']) : null;
        if (!$page)
        {
            $this->show_warning('no_such_page');

            return;
        }

        /* 注意，通过这种方式获取的页面中跟用户相关的数据都是游客，这样就保证了统一性，所见即所得编辑不会因为您是否已登录而出现不同 */
        $html = $this->_get_page_html($page);
        if (!$html)
        {
            $this->show_warning('no_such_page');

            return;
        }
        /* 让页面可编辑 */
        $html = $this->_make_editable($page, $html);

        echo $html;
    }

    /**
     *    保存编辑的页面
     *
     *    @author    Garbin
     *    @return    void
     */
    function save()
    {
        /* 初始化变量 */
        /* 页面中所有的挂件id=>name */
        $widgets = !empty($_POST['widgets']) ? $_POST['widgets'] : array();

        /* 页面中所有挂件的位置配置数据 */
        $config  = !empty($_POST['config']) ? $_POST['config'] : array();

        /* 当前所编辑的页面 */
		$page = $this->_get_page();
        if (!$page)
        {
            $this->json_error('no_such_page');

            return;
        }

        $page_config = get_widget_config($this->get_template_name(), $page['rule'],'store',$this->get_style_name());
		

        /* 写入位置配置信息 */
        $page_config['config'] = $config;

        /* 原始挂件信息 */
        $old_widgets = $page_config['widgets'];

        /* 清空原始挂件信息 */
        $page_config['widgets']  = array();

        /* 写入挂件信息,指明挂件ID是哪个挂件以及相关配置 */
        foreach ($widgets as $widget_id => $widget_name)
        {
            /* 写入新的挂件信息 */
            $page_config['widgets'][$widget_id]['name']     = $widget_name;
            $page_config['widgets'][$widget_id]['options']  = array();

            /* 如果进行了新的配置，则写入 */
            if (isset($page_config['tmp'][$widget_id]))
            {
                $page_config['widgets'][$widget_id]['options'] = $page_config['tmp'][$widget_id]['options'];

                continue;
            }

            /* 写入旧的配置信息 */
            $page_config['widgets'][$widget_id]['options'] = $old_widgets[$widget_id]['options'];
        }

        /* 清除临时的配置信息 */
        unset($page_config['tmp']);

        /* 保存配置 */
		
        $this->_save_page_config($this->get_template_name(), $page['rule'], $page_config,$this->get_style_name());
        $this->json_result('', 'save_successed');
    }

    /**
     *    获取编辑器面板
     *
     *    @author    Garbin
     *    @return    void
     */
    function get_editor_panel()
    {
        /* 获取挂件列表 */
        $widgets = list_widget('store');
		foreach($widgets as $key => $widget)
		{
			if(!empty($widget['theme']) && $widget['theme'] != $this->get_template_name())
			{
				unset($widgets[$key]);
			}
		}
        header('Content-Type:text/html;charset=' . CHARSET);
        $this->assign('widgets', ecm_json_encode($widgets));
        $this->assign('site_url', SITE_URL);
		$page = $this->_get_page();
		$this->assign('page', $page);
		$this->assign('store_id',$this->_store_id);
        $this->display('template.panel.html');
    }
	
    /**
     *    添加挂件到页面中
     *
     *    @author    Garbin
     *    @return    void
     */
    function add_widget()
    {
        $name = !empty($_GET['name']) ? trim($_GET['name']) : null;
        /* 当前所编辑的页面 */
		$page = $this->_get_page();
        if (!$name || !$page)
        {
            $this->json_error('no_such_widget');

            return;
        }
        $page_config = get_widget_config($this->get_template_name(), $page['rule'],'store',$this->get_style_name());
        $id = $this->_get_unique_id($page_config);
        $widget =& widget($id, $name, array(),'store');
        $contents = $widget->get_contents();
        $this->json_result(array('contents' => $contents, 'widget_id' => $id));
    }

    function _get_unique_id($page_config)
    {
        $id = '_widget_' . rand(100, 999);
        if (array_key_exists($id, $page_config['widgets']))
        {
            return $this->_get_unique_id($page_config);
        }

        return $id;
    }

    /**
     *    获取挂件的配置表单
     *
     *    @author    Garbin
     *    @return    void
     */
    function get_widget_config_form()
    {
        $name = !empty($_GET['name']) ? trim($_GET['name']) : null;
        $id   = !empty($_GET['id']) ? trim($_GET['id']) : null;
        /* 当前所编辑的页面 */
        $page = $this->_get_page();
        if (!$name || !$id || !$page)
        {
            $this->json_error('no_such_widget');

            return;
        }
        $page_config = get_widget_config($this->get_template_name(), $page['rule'], 'store',$this->get_style_name());
		
        $options = empty($page_config['tmp'][$id]['options']) ? $page_config['widgets'][$id]['options'] : $page_config['tmp'][$id]['options'];
        $widget =& widget($id, $name, $options,'store');
        header('Content-Type:text/html;charset=' . CHARSET);
        $widget->display_config();
    }

    /**
     *    配置挂件
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function config_widget()
    {
        if (!IS_POST)
        {
            return;
        }
        $name = !empty($_GET['name']) ? trim($_GET['name']) : null;
        $id   = !empty($_GET['id']) ? trim($_GET['id']) : null;
        /* 当前所编辑的页面 */
		$page = $this->_get_page();
        if (!$name || !$id || !$page)
        {
            $this->_config_respond('_d.setTitle("' . Lang::get('no_such_widget') . '");_d.setContents("message", {text:"' . Lang::get('no_such_widget') . '"});');

            return;
        }
        $page_config = get_widget_config($this->get_template_name(), $page['rule'], 'store',$this->get_style_name());
        $widget =& widget($id, $name, $page_config['widgets'][$id]['options'],'store');
        $options = $widget->parse_config($_POST);
        if ($options === false)
        {
            $this->json_error($widget->get_error());

            return;
        }
        $page_config['tmp'][$id]['options'] = $options;

        /* 保存配置信息 */
        $this->_save_page_config($this->get_template_name(), $page['rule'], $page_config,$this->get_style_name());

        /* 返回即时更新的数据 */
        $widget->set_options($options);
        $contents = $widget->get_contents();
        $this->_config_respond('DialogManager.close("config_dialog");parent.disableLink(parent.$(document.body));parent.$("#' . $id . '").replaceWith(document.getElementById("' . $id . '").parentNode.innerHTML);parent.init_widget("#' . $id . '");', $contents);
    }

    /**
     *    响应配置请求
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function _config_respond($js, $widget = '')
    {
        header('Content-Type:text/html;charset=' . CHARSET);
        echo  '<div>' . $widget . '</div>' . '<script type="text/javascript">var DialogManager = parent.DialogManager;var _d = DialogManager.get("config_widget");' . $js . '</script>';
    }

    /**
     *    保存页面配置文件
     *
     *    @author    Garbin
     *    @param     string $template_name
     *    @param     string $page
     *    @param     array  $page_config
     *    @return    void
     */
    function _save_page_config($template_name, $page, $page_config,$style_name)
    {
        $page_config_file = ROOT_PATH . '/data/page_config/store/' . $template_name . '.' . $style_name . '.' .$page . '.config.php';
        $php_data = "<?php\n\nreturn " . var_export($page_config, true) . ";\n\n?>";

        return file_put_contents($page_config_file, $php_data, LOCK_EX);
    }

    /**
     *    获取欲编辑的页面的HTML
     *
     *    @author    Garbin
     *    @param     string $page
     *    @return    string
     */
    function _get_page_html($page)
    {
        $pages = $this->_get_editable_pages();
        if (empty($pages[$page]))
        {
            return false;
        }

        return file_get_contents($pages[$page]['url']);
    }

    /**
     *    让页面具有编辑功能
     *
     *    @author    Garbin
     *    @param     string $html
     *    @return    string
     */
    function _make_editable($page, $html)
    {
        $real_backend_url = site_url();
        $editmode = '<script type="text/javascript" src="' . $real_backend_url . '/index.php?act=jslang"></script><script type="text/javascript">__PAGE__ = "' . $page . '"; REAL_BACKEND_URL = "' . $real_backend_url . '";</script><script type="text/javascript" src="' . SITE_URL . '/includes/libraries/javascript/jquery.ui/jquery.ui.js"></script><script type="text/javascript" charset="utf-8" src="' . SITE_URL . '/includes/libraries/javascript/jquery.ui/i18n/' . i18n_code() . '.js"></script><script id="dialog_js" type="text/javascript" src="' . SITE_URL . '/includes/libraries/javascript/dialog/dialog.js"></script><script id="template_editor_js" type="text/javascript" src="' . $real_backend_url . '/includes/libraries/javascript/template_panel.js"></script><link id="template_editor_css" href="' . $real_backend_url . '/includes/libraries/javascript/template_panel.css" rel="stylesheet" type="text/css" /><link rel="stylesheet" href="' . SITE_URL . '/includes/libraries/javascript/jquery.ui/themes/ui-lightness/jquery.ui.css" type="text/css" media="screen" /><link rel="stylesheet" href="' . SITE_URL . '/includes/libraries/javascript/hack.css" type="text/css" media="screen" />';

        return str_replace('<!--<editmode></editmode>-->', $editmode, $html);
    }

    /**
     *    获取可以编辑的页面列表
     *
     *    @author    Garbin
     *    @param    none
     *    @return    void
     */
    function _get_editable_pages()
    {
        $real_site_url = site_url();
        $data = array(
			'index' => array(
					'url' =>  $real_site_url . '/index.php?app=store&id=' . $this->_store_id,
					'rule'	=>	"store_{$this->_store_id}_index",
			),
			'search' => array(
					'url' =>  $real_site_url . '/index.php?app=store&act=search&id=' . $this->_store_id,
					'rule'	=>	"store_{$this->_store_id}_search",
			),
			'credit' => array(
					'url' =>  $real_site_url . '/index.php?app=store&act=credit&id=' . $this->_store_id,
					'rule'	=>	"store_{$this->_store_id}_credit",
			),
			'groupbuy' => array(
					'url' =>  $real_site_url . '/index.php?app=store&act=groupbuy&id=' . $this->_store_id,
					'rule'	=>	"store_{$this->_store_id}_groupbuy",
			),
		);
		if($this->get_default_article())
		{
			$data['article'] =array(
					'url' =>  $real_site_url . '/index.php?app=store&act=article&id=' . $this->get_default_article(),
					'rule'	=>	"store_{$this->_store_id}_article",
			);
		}
		if($this->get_default_groupbuy())
		{
			$data['groupbuyinfo'] =array(
					'url' =>  $real_site_url . '/index.php?app=groupbuy&id=' . $this->get_default_groupbuy(),
					'rule'	=>	"store_{$this->_store_id}_groupbuyinfo",
			);
		}
		if($this->get_default_goods())
		{
			$data['goodsinfo'] =array(
					'url' =>  $real_site_url . '/index.php?app=goods&id=' . $this->get_default_goods(),
					'rule'	=>	"store_{$this->_store_id}_goodsinfo",
			);
		}
		return $data;
        
    }
	function get_default_goods()
	{
		$goods_mod = &m('goods');
		$goods = $goods_mod->get("if_show = 1 AND closed = 0 AND store_id=".$this->_store_id);
		if(!$goods)
		{
			return false;
		}
		return $goods['goods_id'];
	}
	function get_default_groupbuy()
	{
		$groupbuy_mod = &m('groupbuy');
		$groupbuy = $groupbuy_mod->get("state<>" . GROUP_PENDING . " AND store_id=".$this->_store_id);
		if(!$groupbuy)
		{
			return false;
		}
		return $groupbuy['group_id'];
	}
	function get_default_article()
	{
		$article_mod = &m('article');
		$article = $article_mod->get("if_show = 1 AND store_id=".$this->_store_id);
		if(!$article)
		{
			return false;
		}
		return $article['article_id'];
	}
	/**
     *    获取可以店铺主题
     *
     *    @author    andcpp
     *    @param    none
     *    @return    string
     */
	function get_template_name()
    {
        $store_info = $this->_store_mod->get_info($this->_store_id);
        $theme = !empty($store_info['theme']) ? $store_info['theme'] : 'default|default';
        list($template_name, $style_name) = explode('|', $theme);

        return $template_name;
    }
	 /**
     *    获取当前店铺所设定的风格名称
     *    @author    andcpp
     *    @param    none
     *    @return    string
     */
    function get_style_name()
    {
        $store_info = $this->_store_mod->get_info($this->_store_id);
        $theme = !empty($store_info['theme']) ? $store_info['theme'] : 'default|default';
        list($template_name, $style_name) = explode('|', $theme);

        return $style_name;
    }
	
    function _get_page()
    {
        $page = !empty($_GET['page']) ? trim($_GET['page']) : null;
        $editable_pages = $this->_get_editable_pages();
        if(empty($editable_pages[$page]))
        {
        	return false;
        }
        else
        {
        	return $editable_pages[$page];
        }
    }
	
	
    /**
     *    清理垃圾文件
     *
     *    @author    Garbin
     *    @return    void
     */
    function clean_file()
    {
        $continue = isset($_GET['continue']);
        $isolcated_file = $this->_get_isolated_file();
        if (empty($isolcated_file))
        {
            $this->json_error('no_isocated_file');

            return;
        }
        $file_count = count($isolcated_file);
        if (!$continue)
        {
            $this->json_result('', sprintf(Lang::get('isolcated_file_count'), $file_count));

            return;
        }
        else
        {
            foreach ($isolcated_file as $f)
            {
                _at('unlink', ROOT_PATH . '/' . $f);
            }

            $this->json_result('', sprintf('clean_file_successed', $file_count));
        }
    }

    /**
     *    获取孤立的文件
     *
     *    @author    Garbin
     *    @return    array
     */
    function _get_isolated_file()
    {
        /* 获取存在的文件列表 */
        $exist_files    = $this->_get_exist_file();
        if (empty($exist_files))
        {
            return array();
        }
        /* 获取所有的选项值 */
        $option_values  = $this->_get_option_value();
        /* 无任何选项，则表示，所有文件都是孤立的，可以删除 */
        if (empty($option_values))
        {
            return $exist_files;
        }
        /* 逐个判断是否被使用 */
        foreach ($exist_files as $k => $f)
        {
            /* 若$f存在于选项中，则表示该文件正被使用，不能删除 */
            /* $options_values可以是二维数组，三维四维可能会有问题，因此，需要注意，所有的存储上传文件的option必须放在第一级数组中 */
            if($this->_check_use($f, $option_values))
            {
                unset($exist_files[$k]);
            }
        }
        return $exist_files;
    }

    /**
     *   检查挂件文件是否在使用
     *
     * @param  $f
     * @param array $option_values
     * @return true | 正在使用中，不能删除
     *         false | 没有使用，可以删除
     */
    function _check_use($f, $option_values)
    {
        if (in_array($f, $option_values, true))
        {
            return true;
        }
        foreach ($option_values as $key => $val)
        {
            if (is_array($val))
            {
                if (in_array($f, $val))
                {
                    return true;
                }
            }
        }
       return false;
    }

    function _get_exist_file()
    {
        $files = array();
        $file_dir = ROOT_PATH . '/data/files/mall/template';
        if (!is_dir($file_dir))
        {

            return $files;
        }
        $dir  = dir($file_dir);
        while (false !== ($item = $dir->read()))
        {
            if (in_array($item, array('.', '..', 'index.htm')) || $item{0} == '.')
            {
                continue;
            }
            $files[] = 'data/files/mall/template/' . $item;
        }

        return $files;
    }

    function _get_option_value()
    {
        $config_dir = ROOT_PATH . '/data/page_config/store';
        $dir  = dir($config_dir);
        $config_values = array();
        while (false !== ($item = $dir->read()))
        {
            if (in_array($item, array('.', '..', 'index.htm')) || $item{0} == '.')
            {
                continue;
            }
            $tmp = include($config_dir . '/' . $item);
            $config_values = array_merge($config_values, $this->_get_all_value($tmp));
        }

        return $config_values;
    }
    function _get_all_value($widgets)
    {
        $values = array();
        if (isset($widgets['widgets']))
        {
            foreach ($widgets['widgets'] as $widget)
            {
                if (is_array($widget['options']))
                {
                    $values = array_merge($values, array_values($widget['options']));
                }
            }
        }
        if (isset($widgets['tmp']))
        {
            foreach ($widgets['tmp'] as $widget)
            {
                if (is_array($widget['options']))
                {
                    $values = array_merge($values, array_values($widget['options']));
                }
            }
        }

        return $values;
    }
}

?>
