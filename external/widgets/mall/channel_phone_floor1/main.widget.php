<?php

class channel_phone_floor1Widget extends BaseWidget {

    var $_name = 'channel_phone_floor1';
    var $_ttl = 86400;
    var $_num = 10;

   function _get_data() {

        $cache_server = & cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);

        if ($data === false) {
            $cate_id = empty($this->options['cate_id'])? 0 : $this->options['cate_id'];
            
            
            $recom_mod = & m('recommend');
            $data = array(
                'model_id' => mt_rand(),
                'model_name' => $this->options['model_name'],
                'sub_title_name1' => $this->options['sub_title_name1'],
                'describe_name1' => $this->options['describe_name1'],
                'sub_title_name2' => $this->options['sub_title_name2'],
                'describe_name2' => $this->options['describe_name2'],
                'sub_title_name3' => $this->options['sub_title_name3'],
                'describe_name3' => $this->options['describe_name3'],
                'sub_title_name4' => $this->options['sub_title_name4'],
                'describe_name4' => $this->options['describe_name4'],
                'sub_title_name5' => $this->options['sub_title_name5'],
                'describe_name5' => $this->options['describe_name5'],
                'cates' => $this->get_cate($cate_id),
                
                'model_name1' => $this->options['model_name1'],
                'goods_list_1' => $recom_mod->get_recommended_goods($this->options['img_recom_id_1'], 5, true, $this->options['img_cate_id_1']),
                
                'model_name2' => $this->options['model_name2'],
                'goods_list_2' => $recom_mod->get_recommended_goods($this->options['img_recom_id_2'], 5, true, $this->options['img_cate_id_2']),
                
                'model_name3' => $this->options['model_name3'],
                'goods_list_3' => $recom_mod->get_recommended_goods($this->options['img_recom_id_3'], 5, true, $this->options['img_cate_id_3']),
                
                'model_name4' => $this->options['model_name4'],
                'goods_list_4' => $recom_mod->get_recommended_goods($this->options['img_recom_id_4'], 5, true, $this->options['img_cate_id_4']),
                
                'model_name5' => $this->options['model_name5'],
                'goods_list_5' => $recom_mod->get_recommended_goods($this->options['img_recom_id_5'], 5, true, $this->options['img_cate_id_5']),
                
                
                
            );



            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
    
   //获取设定分类下的子分类
    function get_cate($cate_id) {
        $mod_gcage = &bm('gcategory');
        $cates = $mod_gcage->get_children($cate_id, true);
        return $cates;
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