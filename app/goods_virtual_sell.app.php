<?php

/* 商品虚拟销售控制器 */
class Goods_virtual_sellApp extends StoreadminbaseApp
{ 
    var $_goods_mod;
    var $_order_gooods_mod;
    var $_order_mod;
    var $_store_id;

    /**
     * 构造函数
     */
    function __construct()
    {
        $this->Goods_virtual_sell();
    }
    
    
    function Goods_virtual_sell()
    {
        parent::__construct();
        $this->_store_id  = intval($this->visitor->get('manage_store'));
        $this->_goods_mod =& m('goods');
        $this->_order_gooods_mod =& m('ordergoods');
        $this->_order_mod =& m('order');
    }

    /* 管理 */
    function index()
    { 
    	$goods_id = $_GET['goods_id']; 
    	$goods_info = $this->_goods_mod->get_info($goods_id);
    	$this->assign('goods_id',$goods_id );
    	$this->assign('goods_name',$goods_info['goods_name'] );
     
        $this->display('virtual_sell.form.html');
    } 	  

    function add_virtual_sell(){
    	
    	    $goods_id = $_GET['goods_id'];  
    	    $goods_info = $this->_goods_mod->get_info($goods_id);
    	  
    		$username = $_GET['username']; 
    		$order_time = $_GET['order_time'];
    		$comment_time = $_GET['comment_time'];
    		$comment = $_GET['comment'];
    		 
    		if(empty($username)  ||empty($order_time) ||empty($comment_time) ||empty($comment)     ) {
    			$json = ecm_json_encode(array('done' => false , 'msg' => '失败'));
            	echo $json;
            	return;
    		}

    		/* 1 注册 ucenter  tp_memeber  */
    		$ms =& ms(); //连接用户中心
    		$mail = $username.'@163.com';
            $user_id = $ms->user->register($username, '111111', $mail);
            
    		/* 2 添加订单记录  order   */
    	    /* 根据商品类型获取对应订单类型 */
             $order_model =& m('order');   
	         $order_data =  array(
	            'order_sn'      =>  $this->_gen_order_sn(),
	            'type'          =>  $goods_info['type'],
	            'extension'     =>  'normal',
	            'seller_id'     =>  $goods_info['store_id'],
	            'seller_name'   =>  addslashes($goods_info['store_name']),
	            'buyer_id'      =>  $user_id,
	            'buyer_name'    =>  addslashes($username),
	            'pay_time'      =>  $mail,
	            'status'        =>  ORDER_FINISHED,//交易成功
	            'add_time'      =>  gmstr2time($order_time),
	            'pay_time'      =>  gmstr2time($order_time),  
	            'ship_time'     =>  gmstr2time($order_time),
	            'finished_time' =>  gmstr2time($comment_time),
	            'evaluation_time' =>gmstr2time($comment_time),
	            'goods_amount'  =>  $goods_info['amount'],
	            'discount'      =>  isset($goods_info['discount']) ? $goods_info['discount'] : 0,
	            'evaluation_status' =>1,
	            'anonymous'     =>  0,
	            'postscript'          =>  trim(''),  //买家留言  
	        );
	         $order_id = $order_model->add($order_data);

    		/* 3 商品表  order 数量加1  */ 
    		$new_goods=array(
				'virtual_seles'=> intval($goods_info["virtual_seles"])+1 ,
			);
			$this->_goods_mod->edit($goods_info["goods_id"],$new_goods);
			  
    		 $model_goodsstatistics =& m('goodsstatistics');
			 $model_goodsstatistics->edit($goods_info["goods_id"], 'comments=comments+1');
    		
    		/* 4 商品订单表  评论   order_goods  */
    		$order_gooods = array( 
                'order_id'      =>  $order_id,
                'goods_id'      =>  $goods_info['goods_id'],
                'goods_name'    =>  $goods_info['goods_name'],
                'spec_id'       =>  $goods_info['default_spec'],
                //'specification' =>  $value['specification'],
                'price'         =>  $goods_info['price'],//$value['price'],
                'quantity'      =>  1, //数量
                'comment'       =>  strip_tags($comment), 
                'evaluation'    =>  3,
                'goods_image'   =>  $goods_info['default_image'],
            );
			
            $id = $this->_order_gooods_mod->add($order_gooods); 
    		
		    $json = ecm_json_encode(array('done' => true , 'msg' => '成功'));
		    
    		echo $json; 
    	
    }
 
    
    
 /**
     *    生成订单号
     *
     *    @author    Garbin
     *    @return    string
     */
    function _gen_order_sn()
    {
        /* 选择一个随机的方案 */
        mt_srand((double) microtime() * 1000000);
        $timestamp = gmtime();
        $y = date('y', $timestamp);
        $z = date('z', $timestamp);
        $order_sn = $y . str_pad($z, 3, '0', STR_PAD_LEFT) . str_pad(mt_rand(1, 99999), 5, '0', STR_PAD_LEFT);

        $model_order =& m('order');
        $orders = $model_order->find('order_sn=' . $order_sn);
        if (empty($orders))
        {
            /* 否则就使用这个订单号 */
            return $order_sn;
        }

        /* 如果有重复的，则重新生成 */
        return $this->_gen_order_sn();
    }
    
}

?>