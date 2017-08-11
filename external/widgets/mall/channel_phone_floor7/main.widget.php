<?php

class channel_phone_floor7Widget extends BaseWidget {

    var $_name = 'channel_phone_floor7';
    var $_ttl = 86400;
    var $_num = 10;
   function _get_data() {
            $recom_mod = & m('recommend');
            $data = array(
                'model_id' => mt_rand(),
                'model_name' => $this->options['model_name'],
                
                'subtitle_name' => $this->options['subtitle_name'],
                 'articles' => $this->_get_article($this->options['cate_id']),
                //
                'ad1_image_url' => $this->options['ad1_image_url'],
                'ad1_link_url' => $this->options['ad1_link_url'],
                //
                'ad2_image_url' => $this->options['ad2_image_url'],
                'ad2_link_url' => $this->options['ad2_link_url'],
                //
                'ad3_image_url' => $this->options['ad3_image_url'],
                'ad3_link_url' => $this->options['ad3_link_url'],
                //
                'ad4_image_url' => $this->options['ad4_image_url'],
                'ad4_link_url' => $this->options['ad4_link_url'],
                //
                'ad5_image_url' => $this->options['ad5_image_url'],
                'ad5_link_url' => $this->options['ad5_link_url'],
                //
                'ad6_image_url' => $this->options['ad6_image_url'],
                'ad6_link_url' => $this->options['ad6_link_url'],
                //
                'ad7_image_url' => $this->options['ad7_image_url'],
                'ad7_link_url' => $this->options['ad7_link_url'],
                //
                'ad8_image_url' => $this->options['ad8_image_url'],
                'ad8_link_url' => $this->options['ad8_link_url'],
                //
                'ad9_image_url' => $this->options['ad9_image_url'],
                'ad9_link_url' => $this->options['ad9_link_url'],
                
                'model_name1' => $this->options['model_name1'],
                'goods_list_1' => $recom_mod->get_recommended_goods($this->options['img_recom_id_1'], 4, true, $this->options['img_cate_id_1']),
                
                'model_name2' => $this->options['model_name2'],
                'goods_list_2' => $recom_mod->get_recommended_goods($this->options['img_recom_id_2'], 4, true, $this->options['img_cate_id_2']),
                
                'model_name3' => $this->options['model_name3'],
                'goods_list_3' => $recom_mod->get_recommended_goods($this->options['img_recom_id_3'], 4, true, $this->options['img_cate_id_3']),
                
                'model_name4' => $this->options['model_name4'],
                'goods_list_4' => $recom_mod->get_recommended_goods($this->options['img_recom_id_4'], 4, true, $this->options['img_cate_id_4']),
                
                'model_name5' => $this->options['model_name5'],
                'goods_list_5' => $recom_mod->get_recommended_goods($this->options['img_recom_id_5'], 4, true, $this->options['img_cate_id_5']),
            );
             return $data;
        }
       
        
        function _get_article($cate_id) {
        if ($cate_id > 0) {
            $acategory_mod = & m('acategory');
            $cate_ids = $acategory_mod->get_descendant($cate_id);
            /* 店铺分类检索条件 */
            $condition_id = implode(',', $cate_ids);
            $condition_id && $condition_id = ' AND cate_id IN(' . $condition_id . ')';
        }
        $article_mod = & m('article');
        $article_list = $article_mod->find(array(
            'conditions' => '1=1 ' . $condition_id,
            'order' => 'sort_order desc',
            'limit' => 3,
        ));
        return $article_list;
    }
    
    function _get_acategory_options($layer = 0) {
        $acategory_mod = & m('acategory');
        $acategories = $acategory_mod->get_list();
        foreach ($acategories as $key => $val) {
            if ($val['code'] == ACC_SYSTEM) {
                unset($acategories[$key]);
            }
        }
        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($acategories, 'cate_id', 'parent_id', 'cate_name');
        return $tree->getOptions($layer);
    }
    
    function parse_config($input) {
        $images = $this->_upload_image();
        if ($images) {
            foreach ($images as $key => $image) {
                $input['ad' . $key . '_image_url'] = $image;
            }
        }
        return $input;
    }
    function get_config_datasrc() {
        // 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options());
        // 取得多级文章分类，去除系统文章
        $this->assign('acategories', $this->_get_acategory_options(2));
    }
    function _upload_image() {
        import('uploader.lib');
        $images = array();
        for ($i = 1; $i <= 10; $i++) {
            $file = $_FILES['ad' . $i . '_image_file'];
            if ($file['error'] == UPLOAD_ERR_OK) {
                $uploader = new Uploader();
                $uploader->allowed_type(IMAGE_FILE_TYPE);
                $uploader->addFile($file);
                $uploader->root_dir(ROOT_PATH);
                $images[$i] = $uploader->save('data/files/mall/template', $uploader->random_filename());
            }
        }
        return $images;
    }
    }
?>