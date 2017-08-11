<?php

/* 快递查询控制器
 * 
 *
 */
 
class Order_expressApp extends MemberbaseApp
{
	var $_order_mod;

    /* 构造函数 */
    function __construct()
    {
         $this->Order_expressApp();
    }

    function Order_expressApp()
    {
        parent::__construct();
		$this->_order_mod = &m('order');
    }

    function index()
    {
		if(!$this->_check_express_plugin())
		{
			$this->show_warning('no_such_express_plugin');
			return;
		}
		$order_id = isset($_GET['order_id']) ? intval($_GET['order_id']) : 0;
		if(!$order_id)
		{
			$this->show_warning('no_such_order');
			return;
		}
		
		// 查询的订单必须是已发货（不是货到付款）或者是已完成的交易
        $order_info  = $this->_order_mod->get(array(
            'conditions' => "(status=40 OR (status=30 AND payment_code !='cod')) AND order_id={$order_id} AND (seller_id=" . $this->visitor->get('user_id')." OR buyer_id=".$this->visitor->get('user_id').")",
			'fields'=>'invoice_no,express_company,buyer_id,seller_id',
        ));
        if (!$order_info)
        {
			$this->show_warning('no_such_order');
            return;
        }
		
		// 如果快递公司或者快递单号为空，则返回空
		if(empty($order_info['invoice_no']) || empty($order_info['express_company'])){
			$this->show_warning('invoice_or_ecompany_empty');
			return;
		}
		
		// 从订单ID查询快递公司和快递单号
		$data =  $this->_hook('on_query_express',array('com'=>$order_info['express_company'],'nu'=>$order_info['invoice_no']));
		
		$this->assign('kuaidi_info', $data);
		
		// 判断来访者是当前订单的买家还是卖家，以便设置不同的当前地址和左栏菜单
		if($order_info['seller_id'] == $this->visitor->get('user_id')) // 是当前订单的卖家
		{
			$curlocal_item = 'index.php?app=seller_order';
			$curmenu_item  = 'order_manage';
		}
		else
		{
			$curlocal_item = 'index.php?app=buyer_order';
			$curmenu_item  = 'my_order';
		}
		
		/* 当前位置 */
		$this->_curlocal(LANG::get('member_center'), 'index.php?app=member',
                         LANG::get($curmenu_item), $curlocal_item,
                         LANG::get('view_delivery_track'));

        /* 当前用户中心菜单 */
       	$this->_curitem($curmenu_item);
		$this->_curmenu('view_delivery_track');
        $this->_config_seo('title', Lang::get('member_center') . ' - ' . Lang::get($curmenu_item));
       
		$this->display('order.express.html');
		
	}
	/*三级菜单*/
    function _get_member_submenu()
    {
        $array = array(
			array(
                'name' => 'view_delivery_track',
                'url' => '',
            ),
        );
        return $array;
    }
}

?>
