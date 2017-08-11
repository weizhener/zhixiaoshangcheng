<?php

/**
 *    买家的订单管理控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
define('NUM_PER_PAGE', 5);        // 每页显示数量

class My_evaluationApp extends MemberbaseApp {

    var $_user_id;
    var $_store_mod;
    var $_order_goods_mod;
    var $_member_mod;

    function __construct() {
        $this->My_evaluationApp();
    }

    function My_evaluationApp() {
        parent::__construct();
        $this->_user_id = $this->visitor->get('user_id');
        $this->_store_mod = & m('store');
        $this->_order_goods_mod = & m('ordergoods');
        $this->_member_mod = & m('member');
    }

    function index() {
        $type = $_GET['type'];
        if (!in_array($type, array('from_buyer', 'from_seller', 'to_buyer', 'to_seller'))) {
            $this->show_warning('error');
            return;
        }

        //获取店铺信息
        $store = $this->_store_mod->get_info($this->_user_id);
        if (!empty($store)) {
            import('evaluation.lib');
            $evaluation = new Evaluation();
            $this->assign('evaluation', $evaluation->get_store_evaluation($this->_user_id)); /* 新增店铺动态评分 获取评分 */
            $this->assign('seller_stats', $this->_get_seller_stats()); /* 卖家按时间统计信誉 */
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            $store['credit_image'] = $this->_view->res_base . '/images/' . $this->_store_mod->compute_credit($store['credit_value'], $step);
            $this->assign('store', $store);
        }
        $member = $this->_member_mod->get_info($this->_user_id);
        import('evaluation.lib');
        $evaluation = new Evaluation();
        $member['credit_image'] = site_url() . '/data/system/buyer_evaluation/' . $evaluation->compute_member_credit($member['buyer_credit_value'], $step);
        $this->assign('member', $member);
        $this->assign('buyer_stats', $this->_get_buyer_stats()); /* 买家按时间统计信誉 */


        if ($type == 'from_buyer') {
            //来自买家的评价
            $goods_list = $this->_get_from_buyer();
        } elseif ($type == 'from_seller') {
            //来自卖家的评价
            $goods_list = $this->_get_from_seller();
        } elseif ($type == 'to_buyer') {
            //给买家的评价
            $goods_list = $this->_get_to_buyer();
        } elseif ($type == 'to_seller') {
            //给卖家的评价
            $goods_list = $this->_get_to_seller();
        }

        $this->assign('goods_list', $goods_list);


        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_order'), 'index.php?app=buyer_order', LANG::get('my_evaluation'));

        /* 当前用户中心菜单 */
        $this->_curitem('my_evaluation');
        $this->_curmenu($_GET['type']);
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('my_evaluation'));

        /* 显示订单列表 */
        $this->display('my_evaluation.index.html');
    }

    /**
     * 来自卖家的评论
     */
    function _get_from_seller() {
        $conditions = 'seller_evaluation_status = 1 AND buyer_id = ' . $this->_user_id;
        if (in_array($_GET['evalscore'], array('1', '2', '3'))) {
            //评价 好中差
            $conditions .= ' AND seller_evaluation = ' . $_GET['evalscore'];
        }
        if ($_GET['havecontent'] == '1') {
            //无评论
            $conditions .= ' AND seller_comment =""';
        } elseif ($_GET['havecontent'] == '2') {
            //有评论
            $conditions .= ' AND seller_comment !=""';
        }

        $page = $this->_get_page(NUM_PER_PAGE);
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => $conditions,
            'join' => 'belongs_to_order',
//            'fields' => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment,seller_evaluation,seller_evaluation_time,seller_comment,seller_name,seller_id',
            'order' => 'seller_evaluation_time desc',
            'limit' => $page['limit'],
            'count' => true,
        ));

        $page['item_count'] = $this->_order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        //获取买家的信誉
        if (!empty($goods_list)) {
            import('evaluation.lib');
            $evaluation = new Evaluation();
            foreach ($goods_list as $key => $value) {
                $data = $evaluation->get_seller_evaluation($value['seller_id']);
                $goods_list[$key]['seller_credit_value'] = $data['seller_credit_value'];
                $goods_list[$key]['seller_credit_image'] = $data['seller_credit_image'];
                $goods_list[$key]['seller_praise_rate'] = $data['seller_praise_rate'];
            }
        }
        return $goods_list;
    }

    /**
     * 来自买家的评论
     * 买家评论状态   与  卖家的ID 判断
     */
    function _get_from_buyer() {
        $conditions = 'evaluation_status = 1 AND seller_id = ' . $this->_user_id;
        if (in_array($_GET['evalscore'], array('1', '2', '3'))) {
            //评价 好中差
            $conditions .= ' AND evaluation = ' . $_GET['evalscore'];
        }
        if ($_GET['havecontent'] == '1') {
            //无评论
            $conditions .= ' AND comment = ""';
        } elseif ($_GET['havecontent'] == '2') {
            //有评论
            $conditions .= ' AND comment !=""';
        }

        $page = $this->_get_page(NUM_PER_PAGE);
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => $conditions,
            'join' => 'belongs_to_order',
//            'fields' => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment,seller_evaluation,seller_evaluation_time,seller_comment,seller_name,seller_id',
            'order' => 'evaluation_time desc',
            'limit' => $page['limit'],
            'count' => true,
        ));
        $page['item_count'] = $this->_order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        //获取买家的信誉
        if (!empty($goods_list)) {
            import('evaluation.lib');
            $evaluation = new Evaluation();
            foreach ($goods_list as $key => $value) {
                $data = $evaluation->get_buyer_evaluation($value['buyer_id']);
                $goods_list[$key]['buyer_credit_value'] = $data['buyer_credit_value'];
                $goods_list[$key]['buyer_credit_image'] = $data['buyer_credit_image'];
                $goods_list[$key]['buyer_praise_rate'] = $data['buyer_praise_rate'];
            }
        }
        return $goods_list;
    }

    /**
     * 给买家的评价
     */
    function _get_to_buyer() {
        $conditions = 'seller_evaluation_status = 1 AND seller_id = ' . $this->_user_id;
        if (in_array($_GET['evalscore'], array('1', '2', '3'))) {
            //评价 好中差
            $conditions .= ' AND seller_evaluation = ' . $_GET['evalscore'];
        }
        if ($_GET['havecontent'] == '1') {
            //无评论
            $conditions .= ' AND seller_comment =""';
        } elseif ($_GET['havecontent'] == '2') {
            //有评论
            $conditions .= ' AND seller_comment != ""';
        }
        $page = $this->_get_page(NUM_PER_PAGE);
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => $conditions,
            'join' => 'belongs_to_order',
//            'fields' => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment,seller_evaluation,seller_evaluation_time,seller_comment,seller_name,seller_id',
            'order' => 'evaluation_time desc',
            'limit' => $page['limit'],
            'count' => true,
        ));
        $page['item_count'] = $this->_order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        //获取买家的信誉
        if (!empty($goods_list)) {
            import('evaluation.lib');
            $evaluation = new Evaluation();
            foreach ($goods_list as $key => $value) {
                $data = $evaluation->get_buyer_evaluation($value['buyer_id']);
                $goods_list[$key]['buyer_credit_value'] = $data['buyer_credit_value'];
                $goods_list[$key]['buyer_credit_image'] = $data['buyer_credit_image'];
                $goods_list[$key]['buyer_praise_rate'] = $data['buyer_praise_rate'];
            }
        }
        return $goods_list;
    }

    function _get_to_seller() {
        $conditions = 'evaluation_status = 1 AND buyer_id = ' . $this->_user_id;
        if (in_array($_GET['evalscore'], array('1', '2', '3'))) {
            //评价 好中差
            $conditions .= ' AND evaluation = ' . $_GET['evalscore'];
        }
        if ($_GET['havecontent'] == '1') {
            //无评论
            $conditions .= ' AND comment = ""';
        } elseif ($_GET['havecontent'] == '2') {
            //有评论
            $conditions .= ' AND comment !=""';
        }
        $page = $this->_get_page(NUM_PER_PAGE);
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => $conditions,
            'join' => 'belongs_to_order',
//            'fields' => 'buyer_id, buyer_name, anonymous, evaluation_time, goods_id, goods_name, specification, price, quantity, goods_image, evaluation, comment,seller_evaluation,seller_evaluation_time,seller_comment,seller_name,seller_id',
            'order' => 'seller_evaluation_time desc',
            'limit' => $page['limit'],
            'count' => true,
        ));
        $page['item_count'] = $this->_order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        //获取买家的信誉
        if (!empty($goods_list)) {
            import('evaluation.lib');
            $evaluation = new Evaluation();
            foreach ($goods_list as $key => $value) {
                $data = $evaluation->get_seller_evaluation($value['seller_id']);
                $goods_list[$key]['seller_credit_value'] = $data['seller_credit_value'];
                $goods_list[$key]['seller_credit_image'] = $data['seller_credit_image'];
                $goods_list[$key]['seller_praise_rate'] = $data['seller_praise_rate'];
            }
        }
        return $goods_list;
    }

    /**
     * 给买家的评价 
     */
    function edit_buyer() {
        $this->_curitem('my_evaluation');
        $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        if (!$rec_id)
        {
            $this->show_warning('error');
            return;
        }
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => 'rec_id='.$rec_id,
            'join' => 'belongs_to_order',
        ));
        $goods_list = current($goods_list);
        if(empty($goods_list)||$goods_list['seller_id']!=$this->_user_id){
            $this->show_warning('error');
            return;
        }
        if(!IS_POST){
            $this->assign('goods_list', $goods_list);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('to_buyer'));
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_order'), 'index.php?app=buyer_order', LANG::get('to_buyer'));
            $this->display('my_evaluation.buyer.edit.html');
        }else{
            $data['seller_comment'] = $_POST['seller_comment'];
            $data['seller_evaluation'] = 3;
            $this->_order_goods_mod->edit($rec_id,$data);
            $this->show_message('edit_ok',
                'back_list', 'index.php?app=my_evaluation&type=to_buyer#list_pj'
            );
        }
    }
    
    /**
     * 给卖家的评价 
     */
    function edit_seller() {
        $this->_curitem('my_evaluation');
        $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        if (!$rec_id)
        {
            $this->show_warning('error');
            return;
        }
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => 'rec_id='.$rec_id,
            'join' => 'belongs_to_order',
        ));
        $goods_list = current($goods_list);
        if(empty($goods_list)||$goods_list['buyer_id']!=$this->_user_id){
            $this->show_warning('error');
            return;
        }
        if(!IS_POST){
            $this->assign('goods_list', $goods_list);
            $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get('to_seller'));
            $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('my_order'), 'index.php?app=buyer_order', LANG::get('to_seller'));
            $this->display('my_evaluation.seller.edit.html');
        }else{
            $data['comment'] = $_POST['comment'];
            $data['evaluation'] = 3;
            $this->_order_goods_mod->edit($rec_id,$data);
            $this->show_message('edit_ok',
                'back_list', 'index.php?app=my_evaluation&type=to_seller#list_pj'
            );
        }
    }

    function _get_member_submenu() {
        if (ACT == 'index') {
            if ($this->visitor->get('store_id')) {
                $menus = array(
                    array(
                        'name' => 'from_buyer',
                        'url' => 'index.php?app=my_evaluation&type=from_buyer#list_pj',
                    ),
                    array(
                        'name' => 'from_seller',
                        'url' => 'index.php?app=my_evaluation&type=from_seller#list_pj',
                    ),
                    array(
                        'name' => 'to_buyer',
                        'url' => 'index.php?app=my_evaluation&type=to_buyer#list_pj',
                    ),
                    array(
                        'name' => 'to_seller',
                        'url' => 'index.php?app=my_evaluation&type=to_seller#list_pj',
                    ),
                );
            } else {
                $menus = array(
                    array(
                        'name' => 'from_seller',
                        'url' => 'index.php?app=my_evaluation&type=from_seller#list_pj',
                    ),
                    array(
                        'name' => 'to_seller',
                        'url' => 'index.php?app=my_evaluation&type=to_seller#list_pj',
                    ),
                );
            }
        }
        return $menus;
    }

    /**
     * 卖家信誉按时间统计
     */
    function _get_seller_stats() {
        /* 按时间统计 */
        $stats = array();
        for ($i = 0; $i <= 3; $i++) {
            $stats[$i]['in_a_week'] = 0;
            $stats[$i]['in_a_month'] = 0;
            $stats[$i]['in_six_month'] = 0;
            $stats[$i]['six_month_before'] = 0;
            $stats[$i]['total'] = 0;
        }

        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => "seller_id = '$this->_user_id' AND evaluation_status = 1 AND is_valid = 1 ",
            'join' => 'belongs_to_order',
            'fields' => 'evaluation_time, evaluation',
        ));
        foreach ($goods_list as $goods) {
            $eval = $goods['evaluation'];
            $stats[$eval]['total']++;
            $stats[0]['total']++;

            $days = (gmtime() - $goods['evaluation_time']) / (24 * 3600);
            if ($days <= 7) {
                $stats[$eval]['in_a_week']++;
                $stats[0]['in_a_week']++;
            }
            if ($days <= 30) {
                $stats[$eval]['in_a_month']++;
                $stats[0]['in_a_month']++;
            }
            if ($days <= 180) {
                $stats[$eval]['in_six_month']++;
                $stats[0]['in_six_month']++;
            }
            if ($days > 180) {
                $stats[$eval]['six_month_before']++;
                $stats[0]['six_month_before']++;
            }
        }
        return $stats;
    }

    /**
     * 买家信誉按时间统计
     */
    function _get_buyer_stats() {
        /* 按时间统计 */
        $stats = array();
        for ($i = 0; $i <= 3; $i++) {
            $stats[$i]['in_a_week'] = 0;
            $stats[$i]['in_a_month'] = 0;
            $stats[$i]['in_six_month'] = 0;
            $stats[$i]['six_month_before'] = 0;
            $stats[$i]['total'] = 0;
        }

        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => "buyer_id = '$this->_user_id' AND seller_evaluation_status = 1 AND is_valid = 1 ",
            'join' => 'belongs_to_order',
            'fields' => 'seller_evaluation_time, seller_evaluation',
        ));
        foreach ($goods_list as $goods) {
            $eval = $goods['seller_evaluation'];
            $stats[$eval]['total']++;
            $stats[0]['total']++;

            $days = (gmtime() - $goods['seller_evaluation_time']) / (24 * 3600);
            if ($days <= 7) {
                $stats[$eval]['in_a_week']++;
                $stats[0]['in_a_week']++;
            }
            if ($days <= 30) {
                $stats[$eval]['in_a_month']++;
                $stats[0]['in_a_month']++;
            }
            if ($days <= 180) {
                $stats[$eval]['in_six_month']++;
                $stats[0]['in_six_month']++;
            }
            if ($days > 180) {
                $stats[$eval]['six_month_before']++;
                $stats[0]['six_month_before']++;
            }
        }
        return $stats;
    }

}

?>
