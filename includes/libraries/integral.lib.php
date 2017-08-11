<?php



class Integral {



    var $_member_mod;

    var $_integral_log_mod;



    function __construct() {

        $this->_member_mod = &m('member');

        $this->_integral_log_mod = & m('integral_log');



        //判断积分操作是否开启 未开启直接返回

        if (!Conf::get('integral_enabled')) {

            return;

        }

    }



    //用户注册 积分操作

    function change_integral_reg($user_id) {

        if(!intval($user_id)){

            return;

        }

        // 获取后台设置的  注册赠送积分

        $integral_reg = Conf::get('integral_reg');

        //未设置 或者小于 0 不进行操作

        if ($integral_reg <= 0) {

            return;

        }

        //获取当前用户的信息

        $member = $this->_member_mod->get(intval($user_id));

        //用户未存在 则返回

        if (empty($member)) {

            return;

        }

        $data['integral'] = $integral_reg + $member['integral']; #当前可用积分

        $data['total_integral'] = $integral_reg + $member['total_integral']; #当前总共积分

        $this->_member_mod->edit($user_id, $data);



        //操作记录入积分记录

        $integral_log = array(

            'user_id' => $user_id,

            'user_name' => $member['user_name'],

            'point' => $integral_reg,

            'add_time' => gmtime(),

            'remark' => '注册赠送积分' . $integral_reg,

            'integral_type' => INTEGRAL_REG,

        );

        $this->_integral_log_mod->add($integral_log);

    }



    //用户登录 积分操作

    function change_integral_login($user_id) {

        if(!intval($user_id)){

            return;

        }

        

        // 获取后台设置的  注册赠送积分

        $integral_login = Conf::get('integral_login');

        //未设置 或者小于 0 不进行操作

        if ($integral_login <= 0) {

            return;

        }

        //获取当前用户的信息

        $member = $this->_member_mod->get(intval($user_id));

        //用户未存在 则返回

        if (empty($member)) {

            return;

        }





        //判断今日是否登录过赠送积分

        $begin_time = mktime(0, 0, 0, date('m'), date("d"), date('Y'));

        $end_time = mktime(0, 0, 0, date('m'), date("d") + 1, date('Y'));

        $info = $this->_integral_log_mod->get("integral_type=" . INTEGRAL_LOGIN . " AND user_id=" . $user_id . " AND add_time >" . $begin_time . " AND add_time <" . $end_time);

        if ($info) {

            return;

        }





        $data['integral'] = $integral_login + $member['integral']; #当前可用积分

        $data['total_integral'] = $integral_login + $member['total_integral']; #当前总共积分

        $this->_member_mod->edit($user_id, $data);



        //操作记录入积分记录

        $integral_log = array(

            'user_id' => $user_id,

            'user_name' => $member['user_name'],

            'point' => $integral_login,

            'add_time' => gmtime(),

            'remark' => '登录赠送积分' . $integral_login,

            'integral_type' => INTEGRAL_LOGIN,

        );

        $this->_integral_log_mod->add($integral_log);

    }



    //  推荐用户 获得积分计算  $user_id 为推荐者的用户ID

    function change_integral_recom($user_id) {

        if(!intval($user_id)){

            return;

        }

        // 获取后台设置的  推荐赠送积分

        $integral_recom = Conf::get('integral_recom');

        //未设置 或者小于 0 不进行操作

        if ($integral_recom <= 0) {

            return;

        }

        //获取当前用户的信息

        $member = $this->_member_mod->get(intval($user_id));

        //用户未存在 则返回

        if (empty($member)) {

            return;

        }

        $data['integral'] = $integral_recom + $member['integral']; #当前可用积分

        $data['total_integral'] = $integral_recom + $member['total_integral']; #当前总共积分

        $this->_member_mod->edit($user_id, $data);



        //操作记录入积分记录

        $integral_log = array(

            'user_id' => $user_id,

            'user_name' => $member['user_name'],

            'point' => $integral_recom,

            'add_time' => gmtime(),

            'remark' => '推荐赠送积分' . $integral_recom,

            'integral_type' => INTEGRAL_RECOM,

        );

        $this->_integral_log_mod->add($integral_log);

    }



    // 用户确认收货  获得积分计算

    function change_integral_buy($user_id, $amount) {

        if(!intval($user_id)||!$amount){

            return;

        }

        // 获取后台设置的  购买获得积分计算

        $integral_buy = Conf::get('integral_buy');

        //未设置 或者小于 0 不进行操作

        if ($integral_buy <= 0) {

            return;

        }

        //确认收货 获得的积分为  比例×额度

        $integral_buy = intval($integral_buy * $amount);



        //获取当前用户的信息

        $member = $this->_member_mod->get(intval($user_id));

        //用户未存在 则返回

        if (empty($member)) {

            return;

        }

        $data['integral'] = $integral_buy + $member['integral']; #当前可用积分

        $data['total_integral'] = $integral_buy + $member['total_integral']; #当前总共积分

        $this->_member_mod->edit($user_id, $data);



        //操作记录入积分记录

        $integral_log = array(

            'user_id' => $user_id,

            'user_name' => $member['user_name'],

            'point' => $integral_buy,

            'add_time' => gmtime(),

            'remark' => '购买赠送积分' . $integral_buy,

            'integral_type' => INTEGRAL_BUY,

        );

        $this->_integral_log_mod->add($integral_log);

    }



    /**

     * 用户购买产品  可以抵扣的积分

     * @param type $user_id

     * @param type $point

     * 

     * 注意 此处预留    新增 首先需 新增   抵扣 比例   同时判断当前积分是否大于抵扣的数额

     * 

     */

    function change_integral_seller($user_id, $point) {

        

        if(!intval($user_id)||!$point){

            return;

        }

        // 获取后台设置的  购买抵扣积分计算

        $integral_seller = Conf::get('integral_seller');

        //未设置 或者小于 0 不进行操作

        if ($integral_seller <= 0) {

            return;

        }

        

        //获取当前用户的信息

        $member = $this->_member_mod->get(intval($user_id));

        //用户未存在 则返回

        if (empty($member)) {

            return;

        }

        $data['integral'] = $member['integral'] - $point ; #当前可用积分

        if($data['integral']<0){

            return;

        }

        $this->_member_mod->edit($user_id, $data);

        

        //操作记录入积分记录

        $integral_log = array(

            'user_id' => $user_id,

            'user_name' => $member['user_name'],

            'point' => $point,

            'add_time' => gmtime(),

            'remark' => '购买抵扣积分'.$point.',减免金额为:'.$integral_seller* $point,

            'integral_type' => INTEGRAL_SELLER,

        );

        $this->_integral_log_mod->add($integral_log);

    }



    /**

     *  此处相关逻辑代码  直接 在app/egg.app.php 写入了  

     * @param type $user_id

     * @param type $point

     */

    function change_integral_egg($user_id, $point) {

        

    }



    /**

     * 用户积分回购扣除积分

     */

    function change_integral_goods($user_id, $point, $goods_id) {

        

    }



}



?>