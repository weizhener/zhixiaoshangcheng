<?php

/*分类控制器*/
class companyApp extends MallbaseApp
{
    
   
	/* 商品分类 */
    function index()
    {   
        $this->display('company.html');
		
    }
	function show(){

	  $limit = $_GET['limit'];
	  $_limit = $_GET['_limit'];
        /* 其他检索条件 */

        $conditions = $this->_get_query_conditions(array(

            array(//店铺名称

                'field' => 'store_name',

                'equal' => 'LIKE',

                'assoc' => 'AND',

                'name' => 'keyword',

                'type' => 'string',

            ),

            array(//地区名称

                'field' => 'region_name',

                'equal' => 'LIKE',

                'assoc' => 'AND',

                'name' => 'region_name',

                'type' => 'string',

            ),

            array(//地区id

                'field' => 'region_id',

                'equal' => '=',

                'assoc' => 'AND',

                'name' => 'region_id',

                'type' => 'string',

            ),

            array(//店铺等级id

                'field' => 'sgrade',

                'equal' => '=',

                'assoc' => 'AND',

                'name' => 'sgrade',

                'type' => 'string',

            ),

            array(//是否推荐

                'field' => 'recommended',

                'equal' => '=',

                'assoc' => 'AND',

                'name' => 'recommended',

                'type' => 'string',

            ),

            array(//好评率

                'field' => 'praise_rate',

                'equal' => '>',

                'assoc' => 'AND',

                'name' => 'praise_rate',

                'type' => 'string',

            ),

            array(//商家用户名

                'field' => 'user_name',

                'equal' => 'LIKE',

                'assoc' => 'AND',

                'name' => 'user_name',

                'type' => 'string',

            ),

        ));



        //    safe care

        $orders = array(

            'sales desc',

            'sales asc',

            'price desc',

            'price asc',

            'add_time desc',

            'add_time asc',

            'comments desc',

            'comments asc',

            'credit_value desc',

            'credit_value asc',

            'views desc',

            'views asc',

        );
        $model_store = & m('store');
        $stores = $model_store->find(array(

            'conditions' => 'state = ' . STORE_OPEN . $credit_condition . $condition_id . $conditions,

            'limit' => "{$limit},{$_limit}",

            'fields' => 'store_name,user_name,sgrade,store_logo,praise_rate,credit_value,s.im_qq,im_ww,business_scope,region_name',

            'order' => empty($_GET['order']) || !in_array($_GET['order'], $orders) ? 'sort_order' : $_GET['order'], //   $orders

            'join' => 'belongs_to_user,has_scategory',

            'count' => true   //允许统计

        ));



        foreach ($stores as $key => $store) {
            empty($store['store_logo']) && $store['store_logo'] = Conf::get('default_store_logo');
            $store['credit_image'] = $this->_view->res_base . '/images/' . $model_store->compute_credit($store['credit_value'], $step);
			$store['a'] = "{$limit},{$_limit}";
			$arr[] = $store;
        }
	  echo ecm_json_encode($arr);
	  exit;
	
	}
 
		 
		
}

?>