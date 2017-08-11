<?php
/**
 *    买家 卖家评价控制器
 *
 *    @author    Garbin
 *    @usage    none
 */
define('NUM_PER_PAGE', 20);        // 每页显示数量
class EvaluationApp extends BackendApp{
    var $_order_goods_mod;
    function __construct() {
        parent::__construct();
        $this->_order_goods_mod = & m('ordergoods');
    }
    
    /*
     * 获取买家评价
     */
    function get_evaluation_buyer()
    {
        $conditions = 'evaluation_status = 1 and is_drop = "" ';
        if(in_array($_GET['evalscore'], array('1','2','3'))){
            //评价 好中差
            $conditions .= ' AND evaluation = '.$_GET['evalscore'];
        }
        if($_GET['havecontent']=='1'){
            //无评论
            $conditions .= ' AND comment = ""';
        }elseif($_GET['havecontent']=='2'){
            //有评论
            $conditions .= ' AND comment !=""';
        }
        
        $page = $this->_get_page(NUM_PER_PAGE);
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => $conditions,
            'join' => 'belongs_to_order',
            'order' => 'evaluation_time desc',
            'limit' => $page['limit'],
            'count' => true,
        ));
        $page['item_count'] = $this->_order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        $this->assign('goods_list', $goods_list);
        $this->display('evaluation.buyer.html');
    }
    /**
     * 修改买家评价
     */
    function edit_buyer()
    {
        $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        if (!$rec_id)
        {
            $this->show_warning('error');
            return;
        }
        $order_goods = $this->_order_goods_mod->get($rec_id);
        if(empty($order_goods)){
            $this->show_warning('error');
            return;
        }
        
        if(!IS_POST){
            $this->assign('order_goods', $order_goods);
            $this->display('evaluation.buyer.edit.html');
        }else{
            $data['comment'] = $_POST['comment'];
            $data['evaluation'] = $_POST['evaluation'];
            $this->_order_goods_mod->edit($rec_id,$data);
            $this->show_message('edit_ok',
                'back_list', 'index.php?app=evaluation&act=get_evaluation_buyer'
            );
        }
    }
    
    /**
     * 修改卖家评价
     */
    function get_evaluation_seller(){
        $conditions = 'seller_evaluation_status = 1 ';
        if(in_array($_GET['evalscore'], array('1','2','3'))){
            //评价 好中差
            $conditions .= ' AND seller_evaluation = '.$_GET['evalscore'];
        }
        if($_GET['havecontent']=='1'){
            //无评论
            $conditions .= ' AND seller_comment = ""';
        }elseif($_GET['havecontent']=='2'){
            //有评论
            $conditions .= ' AND seller_comment !=""';
        }
        
        $page = $this->_get_page(NUM_PER_PAGE);
        $goods_list = $this->_order_goods_mod->find(array(
            'conditions' => $conditions,
            'join' => 'belongs_to_order',
            'order' => 'seller_evaluation_time desc',
            'limit' => $page['limit'],
            'count' => true,
        ));
        $page['item_count'] = $this->_order_goods_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        $this->assign('goods_list', $goods_list);
        $this->display('evaluation.seller.html');
    }
    
    /**
     * 修改买家评价
     */
    function edit_seller()
    {
        $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        if (!$rec_id)
        {
            $this->show_warning('error');
            return;
        }
        $order_goods = $this->_order_goods_mod->get($rec_id);
        if(empty($order_goods)){
            $this->show_warning('error');
            return;
        }
        
        if(!IS_POST){
            $this->assign('order_goods', $order_goods);
            $this->display('evaluation.seller.edit.html');
        }else{
            $data['seller_comment'] = $_POST['seller_comment'];
            $data['seller_evaluation'] = $_POST['seller_evaluation'];
            $this->_order_goods_mod->edit($rec_id,$data);
            $this->show_message('edit_ok',
                'back_list', 'index.php?app=evaluation&act=get_evaluation_seller'
            );
        }
    }
    
     
    function drop()
    {
        $rec_id = isset($_GET['rec_id']) ? intval($_GET['rec_id']) : 0;
        if (!$rec_id)
        {
            $this->show_warning('error');
            return;
        }
        $order_goods = $this->_order_goods_mod->get($rec_id);
        if(empty($order_goods)){
            $this->show_warning('error');
            return;
        }
        
            $data['is_drop'] = '1';
            $this->_order_goods_mod->edit($rec_id,$data);
            $this->show_message('删除成功');
    }   
    
    
}
?>
