<?php



class DefaultApp extends MallbaseApp {



    function index() {



      

       



        $this->assign('index', 1); // 标识当前页面是首页，用于设置导航状态



        $this->_config_seo(array(

            'title' => Conf::get('site_title'),

        ));

        $this->assign('page_description', Conf::get('site_description'));

        $this->assign('page_keywords', Conf::get('site_keywords'));

        $this->display('index.html');

    }



	function userwx()

{

	

	 $id = isset($_GET['id']) ? trim($_GET['id']) : 0;

$wxchqr_mod=&m('wxchqr');

 $user_id= $id;

$wxchqr_info=$wxchqr_mod->get("scene_id=".$user_id);



$this->assign('wxchqr_info', $wxchqr_info);





        

$this->display('member.userwx.html');



}



    function ajaxorder() {

        $user_id = $this->visitor->get('user_id');

        //获取订单记录没有查看的IDS

        $order_log_mod = & m('orderlog');



        //用户作为买家的提示 

        $buyer_order_log = $order_log_mod->find(

                array(

                    'conditions' => "buyer_id = '$user_id' AND order_log_status = 0 AND operator_type='seller'",

                    'join' => 'belongs_to_order',

                )

        );

        //用户作为卖家的提示 

        $seller_order_log = $order_log_mod->find(

                array(

                    'conditions' => "seller_id = '$user_id' AND order_log_status = 0 AND operator_type='buyer'",

                    'join' => 'belongs_to_order',

                )

        );



        $order_log_array = array();



        $k = 0;

        if (!empty($buyer_order_log)) {

            foreach ($buyer_order_log as $key => $order_log) {

                $order_log_array['list'][$k]['title'] = '尊敬的买家，您有一份新订单' . $order_log['changed_status'] . "，订单编号为" . $order_log['order_sn'];

                $order_log_array['list'][$k]['url'] = 'index.php?app=buyer_order&act=view&order_id=' . $order_log['order_id'];

                $order_log_array['list'][$k]['notice'] = '买家系统提示';

                $order_log_array['list'][$k]['log_id'] = $order_log['log_id'];

                $k++;

            }

        }



        if (!empty($seller_order_log)) {

            $order_log_array['list'][$k]['title'] = '尊敬的卖家，您有<strong style="color:red">' . count($seller_order_log) . '</strong>份新订单未处理';

            $order_log_array['list'][$k]['url'] = 'index.php?app=seller_order';

            $order_log_array['list'][$k]['notice'] = '卖家系统提示';

            $order_log_array['list'][$k]['log_id'] = 'all';

        }



        $order_log_array['order_log_num'] = count($order_log_array['list']);



        $json_data = json_encode($order_log_array);

        echo $json_data;

        die;

    }



    function ajaxorderdrop() {

        $log_id = trim($_GET['log_id']);

        if (empty($log_id)) {

            return;

        }

        if ($log_id == 'all') {

            $order_log_mod = & m('orderlog');

            $user_id = $this->visitor->get('user_id');

            $seller_order_log = $order_log_mod->find(

                    array(

                        'conditions' => "seller_id = '$user_id' AND order_log_status = 0 AND operator_type='buyer'",

                        'join' => 'belongs_to_order',

                    )

            );

            if (!empty($seller_order_log)) {

                foreach ($seller_order_log as $key => $order) {

                    $data['order_log_status'] = 1;

                    $order_log_mod->edit($key, $data);

                }

            }

            $json_data = json_encode(array('done' => 'true'));

            echo $json_data;

            die;

        }



        $order_log_mod = & m('orderlog');

        $data['order_log_status'] = 1;

        $edit_rows = $order_log_mod->edit($log_id, $data);

        if ($edit_rows) {

            $json_data = json_encode(array('done' => 'true'));

        } else {

            $json_data = json_encode(array('done' => 'false'));

        }

        echo $json_data;

        die;

    }

    

    //微信检查订单是否支付成功

    function check_payment()

    {

        $result = 0;

        $dingdan = $_GET['dingdan'];

        if(empty($dingdan)){

            echo $result;

            return ;

        }

        $mod_epaylog = & m('epaylog');

        $row_epay_log = $mod_epaylog->get("order_sn='$dingdan'");

        //如果充值成功

        if($row_epay_log['complete'] == '1'){

            $result = '1';//表示为充值 到充值界面

            //如果是商品订单

            $mod_order = & m('order');

            $order_info = $mod_order->get('order_sn=' . $dingdan);

            if ($order_info) {

                $result = '2'; //表示为订单购买 到订单页面

            }

        }

        echo $result;

    }

    

    function version(){

        echo 'etmall版本:'.'150620'.'<br/>订单号:1554546';

    }

	function back_login()
	{
		$id = empty($_GET['id']) ? 0 : intval($_GET['id']);
		$key = trim($_GET['key']);
		if(!$id || empty($key))
		{
			header('Location: index.php');
			return;
		}
		$user_mod = &m('member');
		$user = $user_mod->get($id);
		$check_key = md5($user['user_id'].$user['user_name'].$user['password'].$user['last_login'].$user['last_ip']);
		if($key == $check_key)
		{
			/* 同步登陆外部系统 */
			$ms =& ms();
			 /* 通过验证，执行登陆操作 */
			$this->_do_login($id);
			
			$ms->user->synlogout();
	
			/* 同步登陆外部系统 */
			$synlogin = $ms->user->synlogin($id);
	
			$this->show_message(Lang::get('login_successed'),
			  'back_before_login', 'index.php?app=my_goods&act=edit&id='.$_GET['goods']
		    );
		}
		else
		{
			header('Location: index.php');
			return;
		}
	}
}



?>