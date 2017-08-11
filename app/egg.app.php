<?php



class EggApp extends MallbaseApp {

    /* 进入砸蛋界面 */



    

    function __construct() {

        $this->EggApp();

    }



    function EggApp() {

        parent::__construct();

        

        //判断积分操作是否开启 未开启直接返回

        if (!Conf::get('integral_enabled')) {

            $this->show_warning('未开启积分');exit;

            return;

        }

    }

    

    function index() {

        /* 得到礼品列表 */

        $model_eggpresent = & m('eggpresent');

        $eggpresent_list = $model_eggpresent->findAll(array(

            'conditions' => "",

            'fields' => 'this.*',

            'count' => true,

            'limit' => 5,

            'order' => 'id DESC',

        ));



        /* 得到兑换列表 */

        $model_eggpresentrec = & m('eggpresentrec');

        $eggpresentrec_list = $model_eggpresentrec->findAll(array(

            'conditions' => "",

            'fields' => 'this.*',

            'count' => true,

            'limit' => '6',

            'order' => 'add_time DESC',

        ));

        $this->assign('eggpresent_list', $eggpresent_list);

        $this->assign('eggpresentrec_list', $eggpresentrec_list);

        $this->display('egg.index.html');

    }



    /* 砸蛋过程 */



    function eggact_ajax() {

        $user_id = $this->visitor->get('user_id');

        $eggid = $_GET['egg_type'];

        $msg = "";

        $db = &db();

        if (!empty($user_id)) {//是否登录

            $member_mod = &m('member');

            $member = $member_mod->get($user_id); #获取用户相关信息

            if (empty($member)) {

                header('Content-Type:text/html;charset=' . CHARSET);

                echo "系统错误,用户不存在";

                return;

            }





            $egg_mod = &m('egg');

            $egg = $egg_mod->get($eggid); #当前金蛋相关信息

            if (empty($egg)) {

                header('Content-Type:text/html;charset=' . CHARSET);

                echo "系统错误,金蛋不存在";

                return;

            }



            

            //查看是否存在奖品

            $eggpresent_m = $db->getrow("select * from " . DB_PREFIX . "eggpresent where byeggid=" . $eggid . " order by rand() limit 1"); //用户信息

            if (empty($eggpresent_m)) {//是否存在奖品

                header('Content-Type:text/html;charset=' . CHARSET);

                echo "奖品被领完了吗？居然没有奖品了，你太倒霉了 !";

                return;

            }



            if ($member['integral'] >= $egg['noun']) {//活动积分是否够砸此蛋

                #扣除积分  由当前的积分 - 减去使用砸金蛋扣除的积分 

                $data['integral'] = $member['integral'] - $egg['noun'];

                $member_mod->edit($user_id, $data);



                $integral_log_mod = & m('integral_log');

                //操作记录入积分记录

                $integral_log = array(

                    'user_id' => $user_id,

                    'user_name' => $member['user_name'],

                    'point' => $egg['noun'],

                    'add_time' => gmtime(),

                    'remark' => '砸金蛋扣除积分' . $egg['noun'],

                    'integral_type' => INTEGRAL_EGG,

                );

                $integral_log_mod->add($integral_log);




                $data['integral'] = $member['integral'] - $egg['noun'] +$eggpresent_m['money'];

                $member_mod->edit($user_id, $data);



                $integral_log_mod = & m('integral_log');

                //操作记录入积分记录

                $integral_log = array(

                    'user_id' => $user_id,

                    'user_name' => $member['user_name'],

                    'point' => $eggpresent_m['money'],

                    'add_time' => gmtime(),

                    'remark' => '砸金蛋获奖积分' . $eggpresent_m['money'],

                    'integral_type' => INTEGRAL_EGG,

                );

                $integral_log_mod->add($integral_log);





                if (intval($egg['rate']) >= rand(1, 1000)) {//是否中奖 

                        $msg = "太棒了 ！你居然砸中了 " . $eggpresent_m['name'] . " ！";

                        $sql_str = "insert into ".DB_PREFIX."eggpresentrec  (username,presentname,eggname,add_time) values ('" . $member['user_name'] . "','" . $eggpresent_m['name'] . "','" . $egg['name'] . "'," . intval(ecm_microtime()) . ") ";

                        $db->query($sql_str); //插入中奖记录

                } else {

                    $msg = "很遗憾 ！什么也没有砸中，再接再厉吧 ！";

                }

            } else {

                $msg = "很遗憾 ！你剩余的活动积分不够砸此蛋 ！";

            }

        } else {

            $msg = "请先登录";

        }

        header('Content-Type:text/html;charset=' . CHARSET);

        echo $msg;

        return;

    }



}

