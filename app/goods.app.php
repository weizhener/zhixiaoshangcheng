<?php

/* 商品 */

class GoodsApp extends StorebaseApp {

    var $_goods_mod;
    var $_ju_mod;
    var $_gradegoods_mod;//by qufood

    function __construct() {
        $this->GoodsApp();
    }

    function GoodsApp() {
        parent::__construct();
        $this->_goods_mod = & m('goods');
        $this->_ju_mod = &m('ju');
        $this->_gradegoods_mod=&m('gradegoods');//by qufood
    }

    function index() {
        /* 参数 id */
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id) {
            $this->show_warning('Hacking Attempt');
            return;
        }

        /* 可缓存数据 */
        $data = $this->_get_common_info($id);
        if ($data === false) {
            return;
        } else {
            $this->_assign_common_info($data);
        }
        
        if(ECMALL_WAP == 1){
            $data = $this->_get_goods_comment($id, 10);
            $this->_assign_goods_comment($data);
        }
		
		// psmb 
		$region_mod = &m('region');
		$area = $region_mod->get_province_city();
		$this->assign('area', $area);

        /* 更新浏览次数 */
        $this->_update_views($id);

        $ju = $this->_ju_mod->get(array(
            'join' => 'belong_template',
            'conditions' => 'goods_id=' . $id,
            'fields' => 'this.group_id,this.status,jt.state',
        ));
        $this->assign('ju', $ju);
        
        //是否开启验证码
        if (Conf::get('captcha_status.goodsqa')) {
            $this->assign('captcha', 1);
        }

        // sku 
        $goods_pvs_mod = &m('goods_pvs');
        $props_mod = &m('props');
        $prop_value_mod = &m('prop_value');
        $goods_pvs = $goods_pvs_mod->get($id); // 取出该商品的属性字符串
        $goods_pvs_str = $goods_pvs['pvs'];
        $props = array();
        if (!empty($goods_pvs_str)) {
            $goods_pvs_arr = explode(';', $goods_pvs_str); //  分割成数组
            foreach ($goods_pvs_arr as $pv) {
                if ($pv) {
                    $pv_arr = explode(':', $pv);
                    $prop = $props_mod->get(array('conditions' => 'pid=' . $pv_arr[0] . ' AND status=1'));
                    if ($prop) {
                        $prop_value = $prop_value_mod->get(array('conditions' => 'pid=' . $pv_arr[0] . ' AND vid=' . $pv_arr[1] . ' AND status=1'));
                        if ($prop_value) {
                            $props[] = array('name' => $prop['name'], 'value' => $prop_value['prop_value']);
                        }
                    }
                }
            }
        }
        $this->assign('props', $props);
        // end sku


        $this->assign('guest_comment_enable', Conf::get('guest_comment'));
        $this->display('goods.index.html');
    }

    /* 商品评论 */

    function comments() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id) {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $data = $this->_get_common_info($id);
        if ($data === false) {
            return;
        } else {
            $this->_assign_common_info($data);
        }

        /* 赋值商品评论 */
        $data = $this->_get_goods_comment($id, 10);
        $this->_assign_goods_comment($data);

        
        /*获取当前商品的评价详情*/
        $order_goods_mod = & m('ordergoods');
        $evaluation = $order_goods_mod->find(
                array(
                    'conditions' =>  ' evaluation_status=1 AND goods_id='.$id,
					'join' => 'belongs_to_order',
        ));
        if(!empty($evaluation)){
            $times = 0;
            $total_evaluation_desc = 0;
            $total_evaluation_desc_5 = 0;
            foreach ($evaluation as $key => $value) {
                $total_evaluation_desc += $value['evaluation_desc'];
                if($value['evaluation_desc']==5){
                    $total_evaluation_desc_5++;
                }
                $times++;
            } 
            $evaluation_data['percent'] = round($total_evaluation_desc/($times*5)*100 ,2);
            $evaluation_data['evaluation_desc'] = round($total_evaluation_desc/$times ,2);
            $this->assign('evaluation_data', $evaluation_data);
        }
        $good_comments_sql = "SELECT COUNT(*) FROM {$order_goods_mod->table} WHERE goods_id={$id}  AND evaluation = '3'";
        $comments_count['good'] =  $order_goods_mod->getOne($good_comments_sql);
        $good_comments_sql = "SELECT COUNT(*) FROM {$order_goods_mod->table} WHERE goods_id={$id}  AND evaluation = '2'";
        $comments_count['middle'] =  $order_goods_mod->getOne($good_comments_sql);
        $good_comments_sql = "SELECT COUNT(*) FROM {$order_goods_mod->table} WHERE goods_id={$id}  AND evaluation = '1'";
        $comments_count['bad'] =  $order_goods_mod->getOne($good_comments_sql);
        $this->assign('comments_count', $comments_count);
        
        
        $this->display('goods.comments.html');
    }

    /* 销售记录 */

    function saleslog() {
        $id = empty($_GET['id']) ? 0 : intval($_GET['id']);
        if (!$id) {
            $this->show_warning('Hacking Attempt');
            return;
        }

        $data = $this->_get_common_info($id);
        if ($data === false) {
            return;
        } else {
            $this->_assign_common_info($data);
        }

        /* 赋值销售记录 */
        $data = $this->_get_sales_log($id, 10);
        $this->_assign_sales_log($data);

        $this->display('goods.saleslog.html');
    }

    function qa() {
        $goods_qa = & m('goodsqa');
        $id = intval($_GET['id']);
        if (!$id) {
            $this->show_warning('Hacking Attempt');
            return;
        }
        if (!IS_POST) {
            $data = $this->_get_common_info($id);
            if ($data === false) {
                return;
            } else {
                $this->_assign_common_info($data);
            }
            $data = $this->_get_goods_qa($id, 10);
            $this->_assign_goods_qa($data);

            //是否开启验证码
            if (Conf::get('captcha_status.goodsqa')) {
                $this->assign('captcha', 1);
            }
            $this->assign('guest_comment_enable', Conf::get('guest_comment'));
            /* 赋值产品咨询 */
            $this->display('goods.qa.html');
        } else {
            /* 不允许游客评论 */
            if (!Conf::get('guest_comment') && !$this->visitor->has_login) {
                $this->show_warning('guest_comment_disabled');

                return;
            }
            $content = (isset($_POST['content'])) ? trim($_POST['content']) : '';
            //$type = (isset($_POST['type'])) ? trim($_POST['type']) : '';
            $email = (isset($_POST['email'])) ? trim($_POST['email']) : '';
            $hide_name = (isset($_POST['hide_name'])) ? trim($_POST['hide_name']) : '';
            if (empty($content)) {
                $this->show_warning('content_not_null');
                return;
            }
            //对验证码和邮件进行判断

            if (Conf::get('captcha_status.goodsqa')) {
                if (base64_decode($_SESSION['captcha']) != strtolower($_POST['captcha'])) {
                    $this->show_warning('captcha_failed');
                    return;
                }
            }
            if (!empty($email) && !is_email($email)) {
                $this->show_warning('email_not_correct');
                return;
            }
            $user_id = empty($hide_name) ? $_SESSION['user_info']['user_id'] : 0;
            $conditions = 'g.goods_id =' . $id;
            $goods_mod = & m('goods');
            $ids = $goods_mod->get(array(
                'fields' => 'store_id,goods_name',
                'conditions' => $conditions
            ));
            extract($ids);
            $data = array(
                'question_content' => $content,
                'type' => 'goods',
                'item_id' => $id,
                'item_name' => addslashes($goods_name),
                'store_id' => $store_id,
                'email' => $email,
                'user_id' => $user_id,
                'time_post' => gmtime(),
            );
            if ($goods_qa->add($data)) {
                header("Location: index.php?app=goods&act=qa&id={$id}#module\n");
                exit;
            } else {
                $this->show_warning('post_fail');
                exit;
            }
        }
    }

    /**
     * 取得公共信息
     *
     * @param   int     $id
     * @return  false   失败
     *          array   成功
     */
    function _get_common_info($id) {
        $cache_server = & cache_server();
        $key = 'page_of_goods_' . $id;
        $data = $cache_server->get($key);
        $cached = true;
        if ($data === false) {
            $cached = false;
            $data = array('id' => $id);

            /* 商品信息 */
            $goods = $this->_goods_mod->get_info($id);
            if (!$goods || $goods['if_show'] == 0 || $goods['closed'] == 1 || $goods['state'] != 1) {
                $this->show_warning('goods_not_exist');
                return false;
            }
            $goods['tags'] = $goods['tags'] ? explode(',', trim($goods['tags'], ',')) : array();


            /* 减价打折促销 价格设置 add  */
            $_promotion_mod = & m('promotion');
            $promotion = $_promotion_mod->get(array('conditions' => "start_time<=" . gmtime() . " AND end_time>=" . gmtime() . " AND goods_id=" . $goods['goods_id']));
            if ($promotion) {
                $i = $is_pro = 0;
                foreach ($goods['_specs'] as $spec) {
                    $spec_price = unserialize($promotion['spec_price']);
                    if (isset($spec_price[$spec['spec_id']]['pro_type'])) {
                        if ($spec_price[$spec['spec_id']]['pro_type'] == 'price') {
                            if ($spec['price'] > $spec_price[$spec['spec_id']]['price']) {
                                $pro_price = round($spec['price'] - $spec_price[$spec['spec_id']]['price'], 2);
                                $is_pro = 1;
                            } else {
                                $pro_price = NULL; // 考虑设置了促销后，再给该商品添加规格的情况，那么一律给新增的规格设置促销价为NULL
                                $is_pro = 0;
                            }
                        } else {
                            $pro_price = round($spec['price'] * $spec_price[$spec['spec_id']]['price'] / 10, 2);
                            $is_pro = 1;
                        }
                    } else {
                        $pro_price = NULL; // 考虑设置了促销后，再给该商品添加规格的情况，那么一律给新增的规格设置促销价为NULL
                        $is_pro = 0;
                    }
                    $goods['_specs'][$i++] += array('pro_price' => $pro_price, 'is_pro' => $is_pro);
                }

                $goods['lefttime'] = $this->lefttime($promotion['end_time']);

                $goods += $promotion;
            }
            /* 减价打折促销结束 end   */


            $data['goods'] = $goods;

            /* 店铺信息 */
            if (!$goods['store_id']) {
                $this->show_warning('store of goods is empty');
                return false;
            }
            $this->set_store($goods['store_id']);
            $data['store_data'] = $this->get_store_data();

            /* 当前位置 */
            $data['cur_local'] = $this->_get_curlocal($goods['cate_id']);
            $data['goods']['related_info'] = $this->_get_related_objects($data['goods']['tags']);
            /* 分享链接 */
            $data['share'] = $this->_get_share($goods);

            $cache_server->set($key, $data, 1);
        }
        if ($cached) {
            $this->set_store($data['goods']['store_id']);
        }
        
        //开启会员价格并且用户登陆，则显示会员价格 by qufood
        if ($data['goods']['if_open']) {
            $member_mod = &m('member');
            $member = $member_mod->get_grade_info($this->visitor->get('user_id'));
            $data['goods']['grade_name'] = $member['grade_name'];
            $discount = $this->_gradegoods_mod->get_user_discount($this->visitor->get('user_id'), $id);
            foreach ($data['goods']['_specs'] as $key => $val) {
                $data['goods']['_specs'][$key]['member_price'] = $val['price'] * $discount;
                $data['goods']['_specs'][$key]['discount'] = $discount;
            }
        }

        /* 商品的自由搭配 */
        $mix_mod = & m('mix');
        $mix_list = $mix_mod->get(array(
            'conditions' => '1=1 AND nav_goods_id =' . $data['goods']['goods_id'],
            'join' => 'be_mix, belongs_to_store',
            'order' => 'mix_id asc',
        ));
        if ($mix_list) {
            $mix_info = $mix_mod->get_info($mix_list['mix_id']);
            $goods_mod = & m('goods');
            $mix_items = $goods_mod->find(array(
                'join' => 'be_mix, belongs_to_store',
                'conditions' => "mix_goods.mix_id = " . $mix_info['mix_id'],
                'order' => 'mix_goods.sort_order',
                'fields' => 'goods.*, store.store_name, mix_goods.mix_id'
            ));
            $spec_model = & m('goodsspec');
            //自由搭配分类
            $mix_cates = array();
            foreach ($mix_items as $key => $val) {
                //获取最优价格
                $spec_info = $spec_model->get(array(
                    'fields' => 'g.store_id, g.if_open, g.goods_id, g.goods_name, g.spec_name_1, g.spec_name_2, g.default_image, gs.spec_1, gs.spec_2, gs.stock, gs.price',
                    'conditions' => $val['default_spec'],
                    'join' => 'belongs_to_goods',
                ));
                $mix_items[$key]['price'] = $this->get_spec_price($spec_info);
                if(!array_key_exists($val['cate_id'], $mix_cates)){
                    $cate_name_array = explode("\t", $val['cate_name']);
                    if($cate_name_array){
                        $cate_name = end($cate_name_array);
                        $mix_cates[$val['cate_id']] = $cate_name;
                    }
                }
            }
            $data['mix_cates'] = $mix_cates;
            $data['mix_list'] = $mix_items;
            $data['mix_info'] = $mix_info;
        }
        
        return $data;
    }

    public function lefttime($time) {
        $lefttime = $time - gmtime();
        if (empty($time) || $lefttime <= 0) {
            return array();
        }
        $d = intval($lefttime / 86400);
        $lefttime -= $d * 86400;
        $h = intval($lefttime / 3600);
        $lefttime -= $h * 3600;
        $m = intval($lefttime / 60);
        $lefttime -= $m * 60;
        $s = $lefttime;
        return array(
            "d" => $d,
            "h" => $h,
            "m" => $m,
            "s" => $s
        );
    }

    function _get_related_objects($tags) {
        if (empty($tags)) {
            return array();
        }
        $tag = $tags[array_rand($tags)];
        $ms = & ms();

        return $ms->tag_get($tag);
    }

    /* 赋值公共信息 */

    function _assign_common_info($data) {
        /* 商品信息 */
        $goods = $data['goods'];
        $goods['sales'] = $goods['sales'] + $goods['virtual_seles'];
        $url = SITE_URL . '/index.php?app=goods%26id=' . $goods['goods_id'];
        $goods['scan_code'] = '<img src=' . SITE_URL . '/index.php?app=qrcode&url=' . $url . '/>';

        $this->assign('goods', $goods);
        $this->assign('sales_info', sprintf(LANG::get('sales'), $goods['sales'] ? $goods['sales'] : 0));
        $this->assign('comments', sprintf(LANG::get('comments'), $goods['comments'] ? $goods['comments'] : 0));

        /* 店铺信息 */
        $this->assign('store', $data['store_data']);

        /* 浏览历史 */
        $this->assign('goods_history', $this->_get_goods_history($data['id']));

        /* 默认图片 */
        $this->assign('default_image', Conf::get('default_goods_image'));

        /* 当前位置 */
        $this->_curlocal($data['cur_local']);

        /* 配置seo信息 */
        $this->_config_seo($this->_get_seo_info($data['goods']));

        //会员折扣
        $this->assign('discount', $this->_gradegoods_mod->get_user_discount($this->visitor->get('user_id'), $data['goods']['goods_id']));
        // 会员等级名称
        $member_mod = &m('member');
        $user_grade_info = $member_mod->get_grade_info($this->visitor->get('user_id'));
        $this->assign('ugrade_name', !empty($user_grade_info) ? $user_grade_info['grade_name'] . '价' : '会员价');
        
        /* 商品的自由搭配 */
        $this->assign('mix_cates', $data['mix_cates']);
        $this->assign('mix_list', $data['mix_list']);
        $this->assign('mix_info', $data['mix_info']);
        
        /* 商品分享 */
        $this->assign('share', $data['share']);

        $this->import_resource(array(
            'script' => 'jquery.jqzoom.js',
            'style' => 'res:jqzoom.css'
        ));
    }

    /* 取得浏览历史 */

    function _get_goods_history($id, $num = 9) {
        $goods_list = array();
        $goods_ids = ecm_getcookie('goodsBrowseHistory');
        $goods_ids = $goods_ids ? explode(',', $goods_ids) : array();
        if ($goods_ids) {
            $rows = $this->_goods_mod->find(array(
                'conditions' => $goods_ids,
                'fields' => 'goods_name,default_image',
            ));
            foreach ($goods_ids as $goods_id) {
                if (isset($rows[$goods_id])) {
                    empty($rows[$goods_id]['default_image']) && $rows[$goods_id]['default_image'] = Conf::get('default_goods_image');
                    $goods_list[] = $rows[$goods_id];
                }
            }
        }
        $goods_ids[] = $id;
        if (count($goods_ids) > $num) {
            unset($goods_ids[0]);
        }
        ecm_setcookie('goodsBrowseHistory', join(',', array_unique($goods_ids)));

        return $goods_list;
    }

    /* 取得销售记录 */

    function _get_sales_log($goods_id, $num_per_page) {
        $data = array();

        $page = $this->_get_page($num_per_page);
        $order_goods_mod = & m('ordergoods');
        $sales_list = $order_goods_mod->find(array(
            'conditions' => "goods_id = '$goods_id' AND status = '" . ORDER_FINISHED . "'",
            'join' => 'belongs_to_order',
            'fields' => 'buyer_id, buyer_name, add_time, anonymous, goods_id, specification, price, quantity, evaluation',
            'count' => true,
            'order' => 'add_time desc',
            'limit' => $page['limit'],
        ));
        
        //获取买家的信誉
        if(!empty($sales_list)){
            import('evaluation.lib');
            $evaluation = new Evaluation();
            foreach ($sales_list as $key => $value) {
                $data = $evaluation->get_buyer_evaluation($value['buyer_id']);
                $sales_list[$key]['buyer_credit_value'] = $data['buyer_credit_value'];
                $sales_list[$key]['buyer_credit_image'] = $data['buyer_credit_image'];
                $sales_list[$key]['buyer_praise_rate'] = $data['buyer_praise_rate'];
            }
        }
        
        $data['sales_list'] = $sales_list;

        $page['item_count'] = $order_goods_mod->getCount();
        $this->_format_page($page);
        $data['page_info'] = $page;
        $data['more_sales'] = $page['item_count'] > $num_per_page;

        return $data;
    }

    /* 赋值销售记录 */

    function _assign_sales_log($data) {
        $this->assign('sales_list', $data['sales_list']);
        $this->assign('page_info', $data['page_info']);
        $this->assign('more_sales', $data['more_sales']);
    }

    /* 取得商品评论 */

    function _get_goods_comment($goods_id, $num_per_page) {
        $data = array();
        
        $conditions = "goods_id = '$goods_id' AND evaluation_status = '1'";
        if(in_array($_GET['evalscore'], array('1','2','3'))){
            $conditions.=' AND evaluation='.$_GET['evalscore'];
        }
        if($_GET['havecomment']=='1'){
            $conditions .= ' AND comment !=""';
        }
        
        $page = $this->_get_page($num_per_page);
        $order_goods_mod = & m('ordergoods');
        $comments = $order_goods_mod->find(array(
            'conditions' => $conditions,
            'join' => 'belongs_to_order',
            'fields' => 'buyer_id, buyer_name, anonymous, evaluation_time, comment, evaluation',
            'count' => true,
            'order' => 'evaluation_time desc',
            'limit' => $page['limit'],
        ));
        
        //获取买家的信誉
        if(!empty($comments)){
            import('evaluation.lib');
            $evaluation = new Evaluation();
            foreach ($comments as $key => $value) {
                $data = $evaluation->get_buyer_evaluation($value['buyer_id']);
                $comments[$key]['buyer_credit_value'] = $data['buyer_credit_value'];
                $comments[$key]['buyer_credit_image'] = $data['buyer_credit_image'];
                $comments[$key]['buyer_praise_rate'] = $data['buyer_praise_rate'];
            }
        }
        $data['comments'] = $comments;

        $page['item_count'] = $order_goods_mod->getCount();
        $this->_format_page($page);
        $data['page_info'] = $page;
        $data['more_comments'] = $page['item_count'] > $num_per_page;

        return $data;
    }

    /* 赋值商品评论 */

    function _assign_goods_comment($data) {
        $this->assign('goods_comments', $data['comments']);
        $this->assign('page_info', $data['page_info']);
        $this->assign('more_comments', $data['more_comments']);
    }

    /* 取得商品咨询 */

    function _get_goods_qa($goods_id, $num_per_page) {
        $page = $this->_get_page($num_per_page);
        $goods_qa = & m('goodsqa');
        $qa_info = $goods_qa->find(array(
            'join' => 'belongs_to_user',
            'fields' => 'member.user_name,question_content,reply_content,time_post,time_reply',
            'conditions' => '1 = 1 AND item_id = ' . $goods_id . " AND type = 'goods'",
            'limit' => $page['limit'],
            'order' => 'time_post desc',
            'count' => true
        ));
        $page['item_count'] = $goods_qa->getCount();
        $this->_format_page($page);

        //如果登陆，则查出email
        if (!empty($_SESSION['user_info'])) {
            $user_mod = & m('member');
            $user_info = $user_mod->get(array(
                'fields' => 'email',
                'conditions' => '1=1 AND user_id = ' . $_SESSION['user_info']['user_id']
            ));
            extract($user_info);
        }

        return array(
            'email' => $email,
            'page_info' => $page,
            'qa_info' => $qa_info,
        );
    }

    /* 赋值商品咨询 */

    function _assign_goods_qa($data) {
        $this->assign('email', $data['email']);
        $this->assign('page_info', $data['page_info']);
        $this->assign('qa_info', $data['qa_info']);
    }

    /* 更新浏览次数 */

    function _update_views($id) {
        $goodsstat_mod = & m('goodsstatistics');
        $goodsstat_mod->edit($id, "views = views + 1");
    }

    /**
     * 取得当前位置
     *
     * @param int $cate_id 分类id
     */
    function _get_curlocal($cate_id) {
        $parents = array();
        if ($cate_id) {
            $gcategory_mod = & bm('gcategory');
            $parents = $gcategory_mod->get_ancestor($cate_id, true);
        }

        $curlocal = array(
            array('text' => LANG::get('all_categories'), 'url' => url('app=category')),
        );
        foreach ($parents as $category) {
            $curlocal[] = array('text' => $category['cate_name'], 'url' => url('app=search&cate_id=' . $category['cate_id']));
        }
        $curlocal[] = array('text' => LANG::get('goods_detail'));

        return $curlocal;
    }

    function _get_share($goods) {
        $m_share = &af('share');
        $shares = $m_share->getAll();
        $shares = array_msort($shares, array('sort_order' => SORT_ASC));
        $goods_name = ecm_iconv(CHARSET, 'utf-8', $goods['goods_name']);
        $goods_url = urlencode(SITE_URL . '/' . str_replace('&amp;', '&', url('app=goods&id=' . $goods['goods_id'])));
        $site_title = ecm_iconv(CHARSET, 'utf-8', Conf::get('site_title'));
        $share_title = urlencode($goods_name . '-' . $site_title);
        foreach ($shares as $share_id => $share) {
            $shares[$share_id]['link'] = str_replace(
                    array('{$link}', '{$title}'), array($goods_url, $share_title), $share['link']);
        }
        return $shares;
    }

    function _get_seo_info($data) {
        $seo_info = $keywords = array();
        $seo_info['title'] = $data['goods_name'] . ' - ' . Conf::get('site_title');
        $keywords = array(
            $data['brand'],
            $data['goods_name'],
            $data['cate_name']
        );
        $seo_info['keywords'] = implode(',', array_merge($keywords, $data['tags']));
        $seo_info['description'] = sub_str(strip_tags($data['description']), 10, true);
        return $seo_info;
    }

}

?>
