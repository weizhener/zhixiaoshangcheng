<?php



/* 申请开店 */



class renewApp extends MallbaseApp {



    function index() {

        $step = isset($_GET['step']) ? intval($_GET['step']) : 1;

        /* 判断是否开启了店铺申请 */

        if (!Conf::get('store_allow')) {

            $this->show_warning('apply_disabled');

            return;

        }



        /* 只有登录的用户才可申请 */

        if (!$this->visitor->has_login) {

            $this->login();

            return;

        }



        /* 已申请过或已有店铺不能再申请 */

        $store_mod = & m('store');

        $store = $store_mod->get($this->visitor->get('user_id'));
		
		$uid = $this->visitor->get('user_id');
		

					
		

        if ($store['end_time']>time()) {

                    $this->show_warning('店铺未到期');

        }

        $sgrade_mod = & m('sgrade');



        switch ($step) {

            case 1:

                $sgrades = $sgrade_mod->find(array(

                    'order' => 'sort_order',

                ));

                foreach ($sgrades as $key => $sgrade) {

                    if (!$sgrade['goods_limit']) {

                        $sgrades[$key]['goods_limit'] = LANG::get('no_limit');

                    }

                    if (!$sgrade['space_limit']) {

                        $sgrades[$key]['space_limit'] = LANG::get('no_limit');

                    }

                    $arr = explode(',', $sgrade['functions']);

                    $subdomain = array();

                    foreach ($arr as $val) {

                        if (!empty($val)) {

                            $subdomain[$val] = 1;

                        }

                    }

                    $sgrades[$key]['functions'] = $subdomain;

                    unset($arr);

                    unset($subdomain);

                }

                $this->assign('domain', ENABLED_SUBDOMAIN);

                $this->assign('sgrades', $sgrades);



                $this->_config_seo('title', Lang::get('title_step1') . ' - ' . Conf::get('site_title'));

                $this->display('renew.step1.html');

                break;

            case 2:

                $sgrade_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
				
				if($sgrade_id==6) $this->show_warning('非法操作');

                $sgrade = $sgrade_mod->get($sgrade_id);

                if (empty($sgrade)) {

                    $this->show_message('request_error', 'back_step1', 'index.php?app=renew');

                    exit;

                }
				





                    $store_mod = & m('store');



                    $store_id = $this->visitor->get('user_id');
					
		            $epay_mod = & m('epay');
		
                    $epay  = $epay_mod->get($store_id);

					
		            if($epay['money'] < $sgrade['charge']){		
					  $this->show_warning("余额不足续费店铺");
		            }
					
					$mod_epaylog = & m('epaylog');
					
					$end_time = strtotime(date("Y-m-d 00:00",time()))+(10*24*3600);

                    $data = array(
                        'sgrade' => $sgrade['grade_id'],						
						'end_time' => $end_time,
						'state'=>'1',
						'close_reason'=>'',
                    );
					$store_mod->edit($store_id,$data);


                    if ($store_mod->has_error()) {

                        $this->show_warning($store_mod->get_error());

                        return;

                    }


            $order_sn = date('YmdHis',gmtime()+8*3600).rand(1000,9999);

            //$log_text = $this->visitor->get('user_name') . Lang::get('tixianshenqingjine') . $tx_money . Lang::get('yuan').$bank_str;

            $add_epaylog = array(

                'user_id' => $store_id,

                'user_name' => $this->visitor->get('user_name'),

                'order_sn ' => '70' . $order_sn,

                'add_time' => gmtime(),

                'type' => EPAY_KAIDIAN, //提现

                'money_flow'=>'outlay',

                'money' => $sgrade['charge'],

                'log_text' => "店铺续费",

                'states' => 40, //待审核		
				
				'complete' => 1, //待审核

            );

            $mod_epaylog->add($add_epaylog);

            $edit_mymoney = array(

                'money' => $epay['money']-$sgrade['charge'],

            );
			

            $epay_mod->edit('user_id=' . $store_id, $edit_mymoney);


                        $this->show_message('店铺续费成功', 'index', 'index.php');



                break;

            default:

                header("Location:index.php?app=renew&step=1");

                break;

        }

    }



    function check_name() {

        $store_name = empty($_GET['store_name']) ? '' : trim($_GET['store_name']);

        $store_id = empty($_GET['store_id']) ? 0 : intval($_GET['store_id']);



        $store_mod = & m('store');

        if (!$store_mod->unique($store_name, $store_id)) {

            echo ecm_json_encode(false);

            return;

        }

        echo ecm_json_encode(true);

    }



    /* 上传图片 */



    function _upload_image($store_id) {

        import('uploader.lib');

        $uploader = new Uploader();

        $uploader->allowed_type(IMAGE_FILE_TYPE);

        $uploader->allowed_size(SIZE_STORE_CERT); // 400KB



        $data = array();

        for ($i = 1; $i <= 3; $i++) {

            $file = $_FILES['image_' . $i];

            if ($file['error'] == UPLOAD_ERR_OK) {

                if (empty($file)) {

                    continue;

                }

                $uploader->addFile($file);

                if (!$uploader->file_info()) {

                    $this->_error($uploader->get_error());

                    return false;

                }



                $uploader->root_dir(ROOT_PATH);

                $dirname = 'data/files/mall/application';

                $filename = 'store_' . $store_id . '_' . $i;

                $data['image_' . $i] = $uploader->save($dirname, $filename);

            }

        }

        return $data;

    }



    /* 取得店铺分类 */



    function _get_scategory_options() {

        $mod = & m('scategory');

        $scategories = $mod->get_list();

        import('tree.lib');

        $tree = new Tree();

        $tree->setTree($scategories, 'cate_id', 'parent_id', 'cate_name');

        return $tree->getOptions();

    }



}



?>

