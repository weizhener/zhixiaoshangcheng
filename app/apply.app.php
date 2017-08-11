<?php



/* 申请开店 */



class ApplyApp extends MallbaseApp {



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
		

					
		

        if ($store) {

            if ($store['state']) {

                $this->show_warning('user_has_store');

                return;

            } else {

                if ($step != 2) {

                    $this->show_warning('user_has_application');

                    return;

                }

            }

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

                $this->display('apply.step1.html');

                break;

            case 2:

                $sgrade_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
				
				if($sgrade_id==6) $this->show_warning('非法操作');

                $sgrade = $sgrade_mod->get($sgrade_id);

                if (empty($sgrade)) {

                    $this->show_message('request_error', 'back_step1', 'index.php?app=apply');

                    exit;

                }
				




                if (!IS_POST) {

                    $region_mod = & m('region');

                    $this->assign('site_url', site_url());

                    $this->assign('regions', $region_mod->get_options(0));

                    $this->assign('scategories', $this->_get_scategory_options());



                    /* 导入jQuery的表单验证插件 */

                    $this->import_resource(array('script' => 'mlselection.js,jquery.plugins/jquery.validate.js'));



                    $this->_config_seo('title', Lang::get('title_step2') . ' - ' . Conf::get('site_title'));

                    $this->assign('store', $store);

                    $scategory = $store_mod->getRelatedData('has_scategory', $this->visitor->get('user_id'));

                    if ($scategory) {

                        $scategory = current($scategory);

                    }

                    $this->assign('scategory', $scategory);

                    $this->display('apply.step2.html');

                } else {

                    $store_mod = & m('store');



                    $store_id = $this->visitor->get('user_id');
					
		            $epay_mod = & m('epay');
		
                    $epay  = $epay_mod->get($store_id);

					
		            if($epay['money'] < $sgrade['charge']){		
					  $this->show_warning("余额不足开通店铺");
		            }
					
					$mod_epaylog = & m('epaylog');
					
					$end_time = strtotime(date("Y-m-d 00:00",time()))+(10*24*3600);

                    $data = array(

                        'store_id' => $store_id,

                        'store_name' => $_POST['store_name'],

                        'owner_name' => $_POST['owner_name'],

                        'owner_card' => $_POST['owner_card'],

                        'region_id' => $_POST['region_id'],

                        'region_name' => $_POST['region_name'],

                        'address' => $_POST['address'],

                        'zipcode' => $_POST['zipcode'],

                        'tel' => $_POST['tel'],

                        'sgrade' => $sgrade['grade_id'],

                        //'apply_remark' => $_POST['apply_remark'],

                        'state' => $sgrade['need_confirm'] ? 0 : 1,

                        'add_time' => gmtime(),
						
						'end_time' => $end_time,

                    );

                    $image = $this->_upload_image($store_id);

                    if ($this->has_error()) {

                        $this->show_warning($this->get_error());



                        return;

                    }



                    /* 判断是否已经申请过 */

                    $state = $this->visitor->get('state');

                    if ($state != '' && $state == STORE_APPLYING) {

                        $store_mod->edit($store_id, array_merge($data, $image));

                    } else {

                        $store_mod->add(array_merge($data, $image));

                    }



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

                'log_text' => "开通店铺",

                'states' => 40, //待审核		
				
				'complete' => 1, //待审核

            );

            $mod_epaylog->add($add_epaylog);

            $edit_mymoney = array(

                'money' => $epay['money']-$sgrade['charge'],

            );
			

            $epay_mod->edit('user_id=' . $store_id, $edit_mymoney);

                    $cate_id = intval($_POST['cate_id']);

                    $store_mod->unlinkRelation('has_scategory', $store_id);

                    if ($cate_id > 0) {

                        $store_mod->createRelation('has_scategory', $store_id, $cate_id);

                    }
					
					
/*	          $member_mod = &m('member');
          $member = $member_mod->get($store_id);
					
					
      //1级推荐人 不存在买家的推荐人则返回

        if ($member['referid']) {
		   $referid_1 = $member['referid'];
		   $referinfo_1 = $member_mod->get($referid_1);		
		}

        //2级推荐人 不存在买家的推荐人则返回

        if ($referinfo_1['referid']) {
          $referid_2 = $referinfo_1['referid'];
          $referinfo_2 = $member_mod->get($referid_2);
		  if($referinfo_2){
		    $m_2 = $sgrade['charge']*0.02;	
		    $m_2_1 = $m_2*0.7;		
		    $m_2_2 = $m_2*0.2;		  
            $member_mod->edit($referid_2, array('integral' => $referinfo_2['integral'] + $m_2_1,'shopmoney' => $member['shopmoney'] + $m_2_2));
            //操作记录入积分记录
            $integral_log_mod = &m('integral_log');
            $integral_log = array(
                'user_id' => $referid_2,
                'user_name' => $referinfo_2['user_name'],
                'point' => $m_2_1,
                'add_time' => gmtime(),
                'remark' => '二级返利',
                'integral_type' => INTEGRAL_DATE,
            );
            $integral_log_mod->add($integral_log);
			
			
		  }
		  
		}
		
        if ($referinfo_2['referid']) {
          $referid_3 = $referinfo_2['referid'];
          $referinfo_3 = $member_mod->get($referid_3);	
		  if($referinfo_3){
		    $m_3 = $sgrade['charge']*0.01;
		    $m_3_1 = $m_3*0.7;		
		    $m_3_2 = $m_3*0.2;		  
            $member_mod->edit($referid_3, array('integral' => $referinfo_3['integral'] + $m_3_1,'shopmoney' => $member['shopmoney'] + $m_3_2));
            //操作记录入积分记录
            $integral_log_mod = &m('integral_log');
            $integral_log = array(
                'user_id' => $referid_3,
                'user_name' => $referinfo_3['user_name'],
                'point' => $m_3_1,
                'add_time' => gmtime(),
                'remark' => '三级返利',
                'integral_type' => INTEGRAL_DATE,
            );
            $integral_log_mod->add($integral_log);
		  }
		}*/
			
					



                    if ($sgrade['need_confirm']) {

                        $this->show_message('apply_ok', 'index', 'index.php');

                    } else {

                        $this->send_feed('store_created', array(

                            'user_id' => $this->visitor->get('user_id'),

                            'user_name' => $this->visitor->get('user_name'),

                            'store_url' => SITE_URL . '/' . url('app=store&id=' . $store_id),

                            'seller_name' => $data['store_name'],

                        ));

                        $this->_hook('after_opening', array('user_id' => $store_id));



                        $this->show_message('store_opened', 'index', 'index.php');

                    }

                }

                break;

            default:

                header("Location:index.php?app=apply&step=1");

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

