<?php

class Evaluation {

    /**
     *  新增店铺动态评分 获取评分
     *  在原有ECMALL的基礎上新增的方法，用來獲取發貨速度，商品描述，服務態度等信息
     */
    function get_store_evaluation($id) {
            $order_goods_mod = & m('ordergoods');
            $goods_list = $order_goods_mod->find(array(
                'conditions' => "seller_id = '$id' AND evaluation_status = 1 AND is_valid = 1 ",
                'join' => 'belongs_to_order',
                'fields' => 'evaluation_time, evaluation, evaluation_desc, evaluation_service, evaluation_speed', /* 新增店铺动态评分 获取评分 */
            ));
            if (count($goods_list) == 0) {
                $data['count'] = 0;
                $data['evaluation_desc']['average_score'] = 0;
                $data['evaluation_desc'][1] = 0;
                $data['evaluation_desc'][2] = 0;
                $data['evaluation_desc'][3] = 0;
                $data['evaluation_desc'][4] = 0;
                $data['evaluation_desc'][5] = 0;
                $data['evaluation_desc']['ico'] = 0;

                //獲取服務態度的百分比
                $data['evaluation_service']['average_score'] = 0;  #獲取服務態度的平均分
                $data['evaluation_service'][1] = 0;
                $data['evaluation_service'][2] = 0;
                $data['evaluation_service'][3] = 0;
                $data['evaluation_service'][4] = 0;
                $data['evaluation_service'][5] = 0;
                $data['evaluation_service']['ico'] = 0;

                //獲取發貨速度的百分比
                $data['evaluation_speed']['average_score'] = 0;  #獲取發貨速度的平均分
                $data['evaluation_speed'][1] = 0;
                $data['evaluation_speed'][2] = 0;
                $data['evaluation_speed'][3] = 0;
                $data['evaluation_speed'][4] = 0;
                $data['evaluation_speed'][5] = 0;
                $data['evaluation_speed']['ico'] = 0;
                return $data;
            }

            $evaluation = array();
            foreach ($goods_list as $key => $goods) {
                $evaluation['evaluation_desc']['total_count'] += $goods['evaluation_desc']; #獲取描述相符總積分
                //記錄描述相符(evaluation_desc) 1、2、3、4、5、 分值 出現的次數
                if (1 == $goods['evaluation_desc']) {
                    $evaluation['evaluation_desc'][1]++;
                } elseif (2 == $goods['evaluation_desc']) {
                    $evaluation['evaluation_desc'][2]++;
                } elseif (3 == $goods['evaluation_desc']) {
                    $evaluation['evaluation_desc'][3]++;
                } elseif (4 == $goods['evaluation_desc']) {
                    $evaluation['evaluation_desc'][4]++;
                } elseif (5 == $goods['evaluation_desc']) {
                    $evaluation['evaluation_desc'][5]++;
                } else {
                    exit('獲取積分系統錯誤');
                }

                $evaluation['evaluation_service']['total_count'] += $goods['evaluation_service']; #獲取服務態度總積分
                //記錄服務態度(evaluation_service) 1、2、3、4、5、 分值 出現的次數
                if (1 == $goods['evaluation_service']) {
                    $evaluation['evaluation_service'][1]++;
                } elseif (2 == $goods['evaluation_service']) {
                    $evaluation['evaluation_service'][2]++;
                } elseif (3 == $goods['evaluation_service']) {
                    $evaluation['evaluation_service'][3]++;
                } elseif (4 == $goods['evaluation_service']) {
                    $evaluation['evaluation_service'][4]++;
                } elseif (5 == $goods['evaluation_service']) {
                    $evaluation['evaluation_service'][5]++;
                } else {
                    exit('獲取積分系統錯誤');
                }

                $evaluation['evaluation_speed']['total_count'] += $goods['evaluation_speed']; #獲取服務態度總積分
                //記錄服務態度(evaluation_speed) 1、2、3、4、5、 分值 出現的次數
                if (1 == $goods['evaluation_speed']) {
                    $evaluation['evaluation_speed'][1]++;
                } elseif (2 == $goods['evaluation_speed']) {
                    $evaluation['evaluation_speed'][2]++;
                } elseif (3 == $goods['evaluation_speed']) {
                    $evaluation['evaluation_speed'][3]++;
                } elseif (4 == $goods['evaluation_speed']) {
                    $evaluation['evaluation_speed'][4]++;
                } elseif (5 == $goods['evaluation_speed']) {
                    $evaluation['evaluation_speed'][5]++;
                } else {
                    exit('獲取積分系統錯誤');
                }
            }
//                print_r($evaluation);exit;
            //根據獲取到的信息  進行統計 獲得每項服務所得分值所占的百分比
            $data['count'] = count($goods_list);  #總評價人數
            //獲取描述評分的百分比
            $data['evaluation_desc']['average_score'] = round($evaluation['evaluation_desc']['total_count'] / $data['count'], 1);  #獲取描述評分的平均分
            $data['evaluation_desc'][1] = round($evaluation['evaluation_desc'][1] / $data['count'], 4) * 100;
            $data['evaluation_desc'][2] = round($evaluation['evaluation_desc'][2] / $data['count'], 4) * 100;
            $data['evaluation_desc'][3] = round($evaluation['evaluation_desc'][3] / $data['count'], 4) * 100;
            $data['evaluation_desc'][4] = round($evaluation['evaluation_desc'][4] / $data['count'], 4) * 100;
            $data['evaluation_desc'][5] = round($evaluation['evaluation_desc'][5] / $data['count'], 4) * 100;
            $data['evaluation_desc']['ico'] = $data['evaluation_desc']['average_score'] * 10;  #顯示分值的圖片， 由於不能為小數點，  所以陳 10
            //獲取服務態度的百分比
            $data['evaluation_service']['average_score'] = round($evaluation['evaluation_service']['total_count'] / $data['count'], 1);  #獲取服務態度的平均分
            $data['evaluation_service'][1] = round($evaluation['evaluation_service'][1] / $data['count'], 4) * 100;
            $data['evaluation_service'][2] = round($evaluation['evaluation_service'][2] / $data['count'], 4) * 100;
            $data['evaluation_service'][3] = round($evaluation['evaluation_service'][3] / $data['count'], 4) * 100;
            $data['evaluation_service'][4] = round($evaluation['evaluation_service'][4] / $data['count'], 4) * 100;
            $data['evaluation_service'][5] = round($evaluation['evaluation_service'][5] / $data['count'], 4) * 100;
            $data['evaluation_service']['ico'] = $data['evaluation_service']['average_score'] * 10; #顯示分值的圖片， 由於不能為小數點，  所以陳 10
            //獲取發貨速度的百分比
            $data['evaluation_speed']['average_score'] = round($evaluation['evaluation_speed']['total_count'] / $data['count'], 1);  #獲取發貨速度的平均分
            $data['evaluation_speed'][1] = round($evaluation['evaluation_speed'][1] / $data['count'], 4) * 100;
            $data['evaluation_speed'][2] = round($evaluation['evaluation_speed'][2] / $data['count'], 4) * 100;
            $data['evaluation_speed'][3] = round($evaluation['evaluation_speed'][3] / $data['count'], 4) * 100;
            $data['evaluation_speed'][4] = round($evaluation['evaluation_speed'][4] / $data['count'], 4) * 100;
            $data['evaluation_speed'][5] = round($evaluation['evaluation_speed'][5] / $data['count'], 4) * 100;
            $data['evaluation_speed']['ico'] = $data['evaluation_speed']['average_score'] * 10; #顯示分值的圖片， 由於不能為小數點，  所以陳 10
            //获取所有店铺的平均分
            $store_mod = & m('store');
            $stores_avg = $store_mod->find(
                    array(
                        'conditions' => 'state=1 group by state',
                        'fields' => 'AVG(evaluation_desc) as avg_evaluation_desc,AVG(evaluation_service) as avg_evaluation_service,AVG(evaluation_speed) as avg_evaluation_speed',
                    )
            );
            $stores_avg = current($stores_avg);
            //店铺当前的分数和总平均分对比
            //描述相符
            if ($data['evaluation_desc']['average_score'] > $stores_avg['avg_evaluation_desc']) {
                $data['evaluation_desc']['total']['state'] = 'over';
                $value = $data['evaluation_desc']['average_score'] - $stores_avg['avg_evaluation_desc'];
            } else if ($data['evaluation_desc']['average_score'] < $stores_avg['avg_evaluation_desc']) {
                $data['evaluation_desc']['total']['state'] = 'lower';
                $value = $stores_avg['avg_evaluation_desc'] - $data['evaluation_desc']['average_score'];
            } else {
                $data['evaluation_desc']['total']['state'] = 'normal';
                $value = 0;
            }
            $data['evaluation_desc']['total']['count'] = round($value / $stores_avg['avg_evaluation_desc'], 4) * 100;
            //服务态度
            if ($data['evaluation_service']['average_score'] > $stores_avg['avg_evaluation_service']) {
                $data['evaluation_service']['total']['state'] = 'over';
                $value = $data['evaluation_service']['average_score'] - $stores_avg['avg_evaluation_service'];
            } else if ($data['evaluation_service']['average_score'] < $stores_avg['avg_evaluation_service']) {
                $data['evaluation_service']['total']['state'] = 'lower';
                $value = $stores_avg['avg_evaluation_service'] - $data['evaluation_service']['average_score'];
            } else {
                $data['evaluation_service']['total']['state'] = 'normal';
                $value = 0;
            }
            $data['evaluation_service']['total']['count'] = round($value / $stores_avg['avg_evaluation_service'], 4) * 100;
            //发货速度
            if ($data['evaluation_speed']['average_score'] > $stores_avg['avg_evaluation_speed']) {
                $data['evaluation_speed']['total']['state'] = 'over';
                $value = $data['evaluation_speed']['average_score'] - $stores_avg['avg_evaluation_speed'];
            } else if ($data['evaluation_speed']['average_score'] < $stores_avg['avg_evaluation_speed']) {
                $data['evaluation_speed']['total']['state'] = 'lower';
                $value = $stores_avg['avg_evaluation_speed'] - $data['evaluation_speed']['average_score'];
            } else {
                $data['evaluation_speed']['total']['state'] = 'normal';
                $value = 0;
            }
            $data['evaluation_speed']['total']['count'] = round($value / $stores_avg['avg_evaluation_speed'], 4) * 100;

        return $data;
    }
    
    /**
     * 通过卖家的ID  获取卖家的信用值
     * @param type $seller_id
     */
    function get_seller_evaluation($seller_id){
        if(empty($seller_id))
            return;
        $cache_server = & cache_server();
        $evaluation_key = 'function_get_seller_evaluation_' . $seller_id;
        $data = $cache_server->get($evaluation_key);
        if ($data === false) {
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            
            $store_mod =& m('store');
            $store = $store_mod->get_info($seller_id);
            if(empty($store)){
                return;
            }
            $data['seller_credit_value'] = $store['credit_value'];
            $data['seller_credit_image'] = 'data/system/seller_evaluation/' . $store_mod->compute_credit($store['credit_value'], $step);
            $data['seller_praise_rate']  = $store['praise_rate'];
            
            $cache_server->set($evaluation_key, $data, 1800);
        }
        return $data;
    }
    
    
    /**
     *  通过买家的 ID 获取买家的信用值
     * @param type $buyer_id
     * @return type
     */
    function get_buyer_evaluation($buyer_id){
        if(empty($buyer_id))
            return;
        $cache_server = & cache_server();
        $evaluation_key = 'function_get_buyer_evaluation_' . $buyer_id;
        $data = $cache_server->get($evaluation_key);
        if ($data === false) {
            $step = intval(Conf::get('upgrade_required'));
            $step < 1 && $step = 5;
            
            $model_member =& m('member');
            $member_info  = $model_member->get($buyer_id);
            $data['buyer_credit_value'] = $member_info['buyer_credit_value'];
            $data['buyer_credit_image'] = site_url().'/data/system/buyer_evaluation/' .$this->compute_member_credit($member_info['buyer_credit_value'],$step);
            $data['buyer_praise_rate']  = $member_info['buyer_praise_rate'];
            $cache_server->set($evaluation_key, $data, 1800);
        }
        return $data;
    }
    
    /**
     * 根据买家信用值计算图标
     *
     * @param   int     $credit_value   信用值
     * @param   int     $step           最低等级升级所需信用值
     * @return  string  图片文件名
     */
    function compute_member_credit($credit_value, $step = 5) {
        $step < 1 && $step = 5;
        
        if (Conf::get('b_level') != 'true') {
            $level_1 = $step * 5;
            $level_2 = $level_1 * 6;
            $level_3 = $level_2 * 6;
            $level_4 = $level_3 * 6;
            $level_5 = $level_4 * 6;
            if ($credit_value < $level_1) {
                return 'b_red_' . (floor($credit_value / $step) + 1) . '.gif';
            } elseif ($credit_value < $level_2) {
                return 'b_blue_' . (floor(($credit_value - $level_1) / $level_1) + 1) . '.gif';
            } elseif ($credit_value < $level_3) {
                return 'b_blue_' . (floor(($credit_value - $level_2) / $level_2) + 1) . '.gif';
            } else {
                return 'b_red_1.gif';
            }
        }else{
            $member_credit = 'b_red_1.gif';
            switch ($credit_value) {
                case $credit_value>=intval(Conf::get('b_level_1_from'))&&$credit_value<intval(Conf::get('b_level_1_to')):
                    $member_credit = 'b_red_1.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_2_from'))&&$credit_value<intval(Conf::get('b_level_2_to')):
                    $member_credit = 'b_red_2.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_3_from'))&&$credit_value<intval(Conf::get('b_level_3_to')):
                    $member_credit = 'b_red_3.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_4_from'))&&$credit_value<intval(Conf::get('b_level_4_to')):
                    $member_credit = 'b_red_4.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_5_from'))&&$credit_value<intval(Conf::get('b_level_5_to')):
                    $member_credit = 'b_red_5.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_6_from'))&&$credit_value<intval(Conf::get('b_level_6_to')):
                    $member_credit = 'b_blue_1.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_7_from'))&&$credit_value<intval(Conf::get('b_level_7_to')):
                    $member_credit = 'b_blue_2.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_8_from'))&&$credit_value<intval(Conf::get('b_level_8_to')):
                    $member_credit = 'b_blue_3.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_9_from'))&&$credit_value<intval(Conf::get('b_level_9_to')):
                    $member_credit = 'b_blue_4.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_10_from'))&&$credit_value<intval(Conf::get('b_level_10_to')):
                    $member_credit = 'b_blue_5.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_11_from'))&&$credit_value<intval(Conf::get('b_level_11_to')):
                    $member_credit = 'b_cap_1.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_12_from'))&&$credit_value<intval(Conf::get('b_level_12_to')):
                    $member_credit = 'b_cap_2.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_13_from'))&&$credit_value<intval(Conf::get('b_level_13_to')):
                    $member_credit = 'b_cap_3.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_14_from'))&&$credit_value<intval(Conf::get('b_level_14_to')):
                    $member_credit = 'b_cap_4.gif';
                    break;
                case $credit_value>=intval(Conf::get('b_level_15_from'))&&$credit_value<intval(Conf::get('b_level_15_to')):
                    $member_credit = 'b_cap_5.gif';
                    break;
                default:
                    break;
            }
            return $member_credit;
        }
    }
    
    /**
     *   新增 店铺动态评分 
     * 
     *   重新计算 ， 发货速度 、商品描述 、 服务态度的总值
     *   
     */
    function recount_evaluation_dss($store_id)
    {
        $average_score = array();
        $model_ordergoods =& m('ordergoods');
        /* 找出所有is_valid为1的商品评价记录，计算他们的credit_value的和 */
        $info = $model_ordergoods->get(array(
            'join'          => 'belongs_to_order',
            'conditions'    => "seller_id={$store_id} AND evaluation_status=1 AND is_valid = 1",
            'fields'        => 'SUM(evaluation_desc) AS evaluation_desc ,SUM(evaluation_service) AS evaluation_service , SUM(evaluation_speed) AS evaluation_speed ,  COUNT(*) as evaluation_count',
            'index_key'     => false,   /* 不需要索引 */
        ));
        $average_score['evaluation_desc']    = round(($info['evaluation_desc']/$info['evaluation_count']),1);
        $average_score['evaluation_service'] = round(($info['evaluation_service']/$info['evaluation_count']),1);
        $average_score['evaluation_speed']   = round(($info['evaluation_speed']/$info['evaluation_count']),1);
            
        return $average_score;
        
    }
    
    
    
    

}
