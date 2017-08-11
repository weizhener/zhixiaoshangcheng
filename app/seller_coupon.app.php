<?php

class Seller_couponApp extends StoreadminbaseApp
{
    var $_coupon_mod;
    var $_store_id;
    var $_store_mod;
    var $_couponsn_mod;
    var $_uploadedfile_mod;
    function __construct()
    {
        $this->Seller_couponApp();
    }
    function Seller_couponApp()
    {
        parent::__construct();
        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_store_mod =& m('store');
        $this->_coupon_mod =& m('coupon');
        $this->_couponsn_mod =& m('couponsn');
        $this->_uploadedfile_mod = &m('uploadedfile');
    }
    function index()
    {
        $page = $this->_get_page(10);
        $coupons = $this->_coupon_mod->find(array(
            'conditions' => 'store_id = '.$this->_store_id,
            'limit' => $page['limit'],
            'count' => true,
        ));
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('coupon'), 'index.php?app=seller_coupon',
                         LANG::get('coupons_list'));
        $page['item_count'] = $this->_coupon_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);

        $this->_curitem('coupon');
        $this->_curmenu('coupons_list');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('coupon'));
        $this->assign('coupons', $coupons);
        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'dialog/dialog.js',
                    'attr' => 'id="dialog_js"',
                ),
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.ui/i18n/' . i18n_code() . '.js',
                    'attr' => '',
                ),
                array(
                    'path' => 'jquery.plugins/jquery.validate.js',
                    'attr' => '',
                ),
            ),
            'style' =>  'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));
        $this->assign('time', gmtime());
        $this->display('seller_coupon.index.html');
    }

    /**
     * 查看优惠券发放的优惠码
     */
    function couponsn_view()
    {
        $coupon_id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        
        if(!$coupon_id){
            $this->show_warning("error");
            exit;
        }
        
        $coupon = $this->_coupon_mod->get(array('conditions' => 'coupon_id = ' . $coupon_id.' AND store_id='.$this->_store_id));
        
        if(empty($coupon)){
            $this->show_warning("error");
            exit;
        }
        
        $page = $this->_get_page(50);
        $couponsn_list = $this->_couponsn_mod->find(
                array(
                    'conditions' => 'coupon_id = ' . $coupon_id,
                    'limit' => $page['limit'],
                    'count' => true,
                )
        );
        

        
        $page['item_count'] = $this->_couponsn_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        
        
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('coupon'), 'index.php?app=seller_coupon',
                         LANG::get('couponsn_view'));
        $this->_curitem('coupon');
        $this->_curmenu('couponsn_view');
        
        $this->assign('couponsn_list', $couponsn_list);
        $this->display('seller_coupon.couponsn_view.html');
    }
    /**
     * 删除特定的优惠码
     */
    function couponsn_drop()
    {
        if (!isset($_GET['id']) && empty($_GET['id'])) {
            $this->show_warning("involid_data");
            exit;
        }
        $ids = explode(',', trim($_GET['id']));

        foreach ($ids as $key => $id) {
            $this->_couponsn_mod->drop('coupon_sn=' . $id);
        }

        if ($this->_couponsn_mod->has_error()) {
            $this->show_warning($this->_couponsn_mod->get_error());
            exit;
        }
        $this->show_message('drop_ok', 'back_list', 'index.php?app=seller_coupon');
    }
    
    /**
     *  新增优惠券
     */
    function add()
    {
        if (!IS_POST)
        {
            
            /* 文章模型未分配的附件 */
            $files_belong_coupon = $this->_uploadedfile_mod->find(array(
                'conditions' => 'store_id = ' . $this->visitor->get('manage_store') . ' AND belong = ' . BELONG_COUPON . ' AND item_id = 0',
                'fields' => 'this.file_id, this.file_name, this.file_path',
            ));

            //上传图片是传给iframe的参数
            $this->assign("id", 0);
            $this->assign("belong", BELONG_COUPON);

            extract($this->_get_theme());
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'content',
                'ext_js' => false,
                'content_css' => SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}" . '/shop.css', // for preview
            )));
            
            $this->assign('files_belong_coupon', $files_belong_coupon);
            
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->assign('today', gmtime());
            $this->display('seller_coupon.form.html');
        }
        else
        {

            $coupon_value = floatval(trim($_POST['coupon_value']));
            $use_times = intval(trim($_POST['use_times']));
            $min_amount = floatval(trim($_POST['min_amount']));
            if (empty($coupon_value) || $coupon_value < 0 )
            {
                $this->pop_warning('coupon_value_not');
                exit;
            }
            if (empty($use_times))
            {
                $this->pop_warning('use_times_not_zero');
                exit;
            }
            if ($min_amount < 0)
            {
                $this->pop_warning("min_amount_gt_zero");
                exit;
            }
            $start_time = gmstr2time(trim($_POST['start_time']));
            $end_time = gmstr2time_end(trim($_POST['end_time'])) - 1 ;
            if ($end_time < $start_time)
            {
                $this->pop_warning('end_gt_start');
                exit;
            }
            $coupon = array(
                'coupon_name' => trim($_POST['coupon_name']),
                'coupon_value' => $coupon_value,
                'store_id' => $this->_store_id,
                'use_times' => $use_times,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'min_amount' => $min_amount,
                'if_issue'  => trim($_POST['if_issue']) == 1 ? 1 : 0,
                'content'       => $_POST['content'],
            );
            
            if(!$coupon_id = $this->_coupon_mod->add($coupon)){
                $this->pop_warning($this->_coupon_mod->get_error());
                return;
            }

            $logo = $this->_upload_logo($coupon_id);
            if ($logo === false) {
                return;
            }
            $this->_coupon_mod->edit($coupon_id, array('coupon_bg' => $logo));
            
            /* 附件入库 */
            if (isset($_POST['file_id']))
            {
                foreach ($_POST['file_id'] as $file_id)
                {
                    $this->_uploadedfile_mod->edit($file_id, array('item_id' => $coupon_id));
                }
            }
            
            $this->pop_warning('ok', 'coupon_add');
        }
    }

    function _upload_logo($coupon_id) {
        $file = $_FILES['coupon_bg'];
        if ($file['error'] == UPLOAD_ERR_NO_FILE || !isset($_FILES['coupon_bg'])) { // 没有文件被上传
            return '';
        }
        import('uploader.lib');             //导入上传类
        $uploader = new Uploader();
        $uploader->allowed_type(IMAGE_FILE_TYPE); //限制文件类型
        $uploader->addFile($_FILES['coupon_bg']); //上传logo
        if (!$uploader->file_info()) {
            $this->pop_warning($uploader->get_error());
            return false;
        }
        /* 指定保存位置的根目录 */
        $uploader->root_dir(ROOT_PATH);

        /* 上传 */
        if ($file_path = $uploader->save('data/files/mall/coupon', $coupon_id)) {  
            return $file_path;
        } else {
            return false;
        }
    }
    
    function edit()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($coupon_id))
        {
            echo Lang::get("no_coupon");
        }
        if (!IS_POST)
        {
            
            /* 当前的附件 */
            $files_belong_coupon = $this->_uploadedfile_mod->find(array(
                'fields' => 'this.file_id, this.file_name, this.file_path',
                'conditions' => 'store_id = ' . $this->visitor->get('manage_store') . ' AND belong = ' . BELONG_COUPON . ' AND item_id=' . $coupon_id,
            ));

            //上传图片是传给iframe的参数
            $this->assign("id", $coupon_id);
            $this->assign("belong", BELONG_COUPON);
            $this->assign('files_belong_coupon', $files_belong_coupon);
            
            extract($this->_get_theme());
            $this->assign('build_editor', $this->_build_editor(array(
                'name' => 'content',
                'ext_js' => false,
                'content_css' => SITE_URL . "/themes/store/{$template_name}/styles/{$style_name}" . '/shop.css', // for preview
            )));
            
            
            header("Content-Type:text/html;charset=" . CHARSET);
            $coupon = $this->_coupon_mod->get_info($coupon_id);
            $this->assign('coupon', $coupon);
            $this->display('seller_coupon.form.html');
        }
        else
        {
            $coupon_value = floatval(trim($_POST['coupon_value']));
            $use_times = intval(trim($_POST['use_times']));
            $min_amount = floatval(trim($_POST['min_amount']));
            if (empty($coupon_value) || $coupon_value < 0 )
            {
                $this->pop_warning('coupon_value_not');
                exit;
            }
            if (empty($use_times))
            {
                $this->pop_warning('use_times_not_zero');
                exit;
            }
            if ($min_amount < 0)
            {
                $this->pop_warning("min_amount_gt_zero");
                exit;
            }
            $start_time = gmstr2time(trim($_POST['start_time']));
            $end_time = gmstr2time_end(trim($_POST['end_time']))-1;
            if ($end_time < $start_time)
            {
                $this->pop_warning('end_gt_start');
                exit;
            }
            $coupon = array(
                'coupon_name' => trim($_POST['coupon_name']),
                'coupon_value' => $coupon_value,
                'store_id' => $this->_store_id,
                'use_times' => $use_times,
                'start_time' => $start_time,
                'end_time' => $end_time,
                'min_amount' => $min_amount,
                'if_issue'  => trim($_POST['if_issue']) == 1 ? 1 : 0,
                'content'       => $_POST['content'],
            );
            
            if (isset($_FILES['coupon_bg'])) {
                $logo = $this->_upload_logo($coupon_id);
                if ($logo === false) {
                    return;
                }
                $coupon['coupon_bg'] = $logo;
            }
            
            
            $this->_coupon_mod->edit($coupon_id, $coupon);
            if ($this->_coupon_mod->has_error())
            {
                $this->pop_warning($this->_coupon_mod->get_error());
                exit;
            }
            $this->pop_warning('ok','coupon_edit');
        }
    }

    function issue()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
        if (empty($coupon_id))
        {
            $this->show_warning("no_coupon");
            exit;
        }
        $this->_coupon_mod->edit($coupon_id, array('if_issue' => 1));
        if ($this->_coupon_mod->has_error())
        {
            $this->show_message($this->_coupon_mod->get_error());
            exit;
        }
        $this->show_message('issue_success',
            'back_list', 'index.php?app=seller_coupon');
    }

    function drop()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : '';
        if (empty($coupon_id))
        {
            $this->show_warning('no_coupon');
            return;
        }
        $coupon = $this->_coupon_mod->get($coupon_id);
        if(empty($coupon)){
            $this->show_warning('no_coupon');
            return;
        }
        if($coupon['store_id']!=$this->_store_id){
            $this->show_warning('no_coupon');
            return;
        }
        $this->_coupon_mod->drop($coupon_id);
        if ($this->_coupon_mod->has_error())
        {
            $this->show_warning($this->_coupon_mod->get_error());
            return;
        }
        $this->_couponsn_mod->drop('coupon_id ='.$coupon_id);
        $this->show_message('drop_ok',
            'back_list', 'index.php?app=seller_coupon');
    }

    function export()
    {
        $coupon_id = isset($_GET['id']) ? intval($_GET['id']) : '';
        if (empty($coupon_id))
        {
            echo Lang::get('no_coupon');
            exit;
        }
        if (!IS_POST)
        {
            header("Content-Type:text/html;charset=" . CHARSET);
            $this->assign('id', $coupon_id);
            $this->display('seller_coupon.export.html');
        }
        else
        {
            $amount = intval(trim($_POST['amount']));
            if (empty($amount))
            {
                $this->pop_warning('involid_data');
                exit;
            }
            $info = $this->_coupon_mod->get_info($coupon_id);
            $coupon_name = ecm_iconv(CHARSET, 'gbk', $info['coupon_name']);
//            header('Content-type: application/txt');
//            header('Content-Disposition: attachment; filename="coupon_' .date('Ymd'). '_' .$coupon_name.'.txt"');
            $sn_array = $this->generate($amount, $coupon_id);
            $this->pop_warning('ok', 'coupon_export');
        }
    }



    function generate($num, $id)
    {
        $use_times = $this->_coupon_mod->get(array('fields' => 'use_times', 'conditions' => 'store_id = ' . $this->_store_id . ' AND coupon_id = ' . $id));

        if ($num > 1000)
        {
            $num = 1000;
        }
        if ($num < 1)
        {
            $num = 1;
        }
        $times = $use_times['use_times'];
        $add_data = array();
        $str = '';
        $pix = 0;
        if (file_exists(ROOT_PATH . '/data/generate.txt'))
        {
            $s = file_get_contents(ROOT_PATH . '/data/generate.txt');
            $pix = intval($s);
        }
        $max = $pix + $num;
        file_put_contents(ROOT_PATH . '/data/generate.txt', $max);
        $couponsn = '';
        $tmp = '';
        $cpm = '';
        $str = '';
        for ($i = $pix + 1; $i <= $max; $i++ )
        {
            $cpm = gmtime();
            $tmp = mt_rand(10000, 99999);
            $couponsn = $cpm . $tmp;
            $str .= "('{$couponsn}', {$id}, {$times}),";
            $add_data[] = array(
                'coupon_sn' => $couponsn,
                'coupon_id' => $id,
                'remain_times' => $times,
                );
        }
        $string = substr($str,0, strrpos($str, ','));
        $this->_couponsn_mod->db->query("INSERT INTO {$this->_couponsn_mod->table} (coupon_sn, coupon_id, remain_times) VALUES {$string}", 'SILENT');
        return $add_data;
    }

    function _sql_insert($data)
    {
        $str = '';
        foreach ($data as $val)
        {
            $str .= "('{$val['coupon_sn']}', {$val['coupon_id']}, {$val['remain_times']}),";
        }
        $string = substr($str,0, strrpos($str, ','));
        $res = $this->_couponsn_mod->db->query("INSERT INTO {$this->_couponsn_mod->table} (coupon_sn, coupon_id, remain_times) VALUES {$string}", 'SILENT');
        $error = $this->_couponsn_mod->db->errno();
        return array('res' => $res, 'errno' => $error);
    }

    function _create_random($num, $id, $times)
    {
        $arr = array();
        for ($i = 1; $i <= $num; $i++)
        {
            $arr[$i]['coupon_sn'] =  mt_rand(10000, 99999);
            $arr[$i]['coupon_id'] = $id;
            $arr[$i]['remain_times'] = $times;
        }
        return $arr;
    }
    
    
    /* 检查优惠券相关信息 */
    function check()
    {
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get('coupon'), 'index.php?app=seller_coupon',
                         LANG::get('check'));
        $this->_curitem('coupon');
        $this->_curmenu('check');
        
        $this->display('seller_coupon.check.html');
    }
    function check_coupon_sn()
    {
        $coupon_sn = trim($_GET['coupon_sn']);
        if(strlen($coupon_sn)!=15){
            echo '<font color="red">请输入正确的优惠码！</font><br/>';exit;
        }
        $coupon_sn_info = $this->_couponsn_mod->find(array(
            'fields' => 'couponsn.remain_times,coupon.*', 
            'conditions' => 'coupon_sn = '.$coupon_sn,
            'join'=>'belongs_to_coupon',
        ));
        if(empty($coupon_sn_info)){
            echo '<font color="red">优惠码错误！</font>';exit;
        }
        if(count($coupon_sn_info)!=1){
            echo '<font color="red">系统错误！</font>';exit;
        }
        $coupon_sn_info = current($coupon_sn_info);
        if($coupon_sn_info['store_id']!=$this->_store_id){
            echo '<font color="red">不是此店优惠券！</font><br/>';exit;
        }
        if($coupon_sn_info['end_time'] <= gmtime()){
            echo '<font color="red">此优惠券已过期！</font><br/>';exit;
        }
        if($coupon_sn_info['remain_times'] <= 0){
            echo '<font color="red">此优惠券已使用！</font><br/>';exit;
        }
        if($coupon_sn_info['user_id'] == 0){
            echo '<font color="red">此优惠券未被领取！</font><br/>';exit;
        }
        echo '优惠券名称：<font color="blue">'.$coupon_sn_info['coupon_name'].'</font>'
                .'<br/>抵扣金额：<font color="blue">'.$coupon_sn_info['coupon_value'].'</font>'
                .'<br/>最低消费：<font color="blue">'.$coupon_sn_info['min_amount'].'</font>'
                .'<br/>可使用次数：<font color="blue">'.$coupon_sn_info['remain_times'].'</font>'
                .'<br/>使用期限：<font color="blue">'.  date('Y-m-d H:i', $coupon_sn_info['start_time']).'至'.date('Y-m-d H:i', $coupon_sn_info['end_time']).'</font>';
        
    }
    
    function use_coupon_sn()
    {
        $coupon_sn = trim($_GET['coupon_sn']);
        
        if(strlen($coupon_sn)!=15){
            echo '<font color="red">请输入正确的优惠码！</font><br/>';exit;
        }
        
        $coupon_sn_info = $this->_couponsn_mod->find(array(
            'fields' => 'couponsn.remain_times,coupon.*', 
            'conditions' => 'coupon_sn = '.$coupon_sn,
            'join'=>'belongs_to_coupon',
        ));
        if(empty($coupon_sn_info)){
            echo '<font color="red">优惠码错误！</font>';exit;
        }
        if(count($coupon_sn_info)!=1){
            echo '<font color="red">系统错误！</font>';exit;
        }
        
        $coupon_sn_info = current($coupon_sn_info);
        if($coupon_sn_info['store_id']!=$this->_store_id){
            echo '<font color="red">不是此店优惠券！</font><br/>';exit;
        }
        if($coupon_sn_info['end_time'] <= gmtime()){
            echo '<font color="red">此优惠券已过期！</font><br/>';exit;
        }
        if($coupon_sn_info['remain_times'] <= 0){
            echo '<font color="red">此优惠券已使用！</font><br/>';exit;
        }
        
        $this->_couponsn_mod->edit("coupon_sn = '{$coupon_sn}'", "remain_times= remain_times - 1");
        
        echo '<font color="red">使用成功！</font><br/>';exit;
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
    

    function _get_member_submenu()
    {
        $menus = array(
            array(
                'name'  => 'coupons_list',
                'url'   => 'index.php?app=seller_coupon',
            ),
            array(
                'name'  => 'check',
                'url'   => 'index.php?app=seller_coupon&act=check',
            ),
        );
        if (ACT == 'couponsn_view') {
            $menus[] = 
                array(
                    'name' => 'couponsn_view',
                    'url' => 'index.php?app=seller_coupon&act=couponsn_view',
                )
            ;
        }
        return $menus;
    }
}

?>