<?php

class channel_appliances_floor1Widget extends BaseWidget {

    var $_name = 'channel_appliances_floor1';
    var $_ttl = 86400;
    var $_num = 4;

    function _get_data() {
        $recom_mod = & m('recommend');
        $data = array(
            'keywords' => explode(' ', $this->options['keyword']),
            'model_id' => mt_rand(),
            'model_name' => $this->options['model_name'],
            'subtitle_name' => $this->options['subtitle_name'],
            'left_title_name' => $this->options['left_title_name'],
            
            
            //
            'ad1_image_url' => $this->options['ad1_image_url'],
            'ad1_link_url' => $this->options['ad1_link_url'],
            'ad1_title' => $this->options['ad1_title'],
            'ad1_price' => $this->options['ad1_price'],
            'ad1_market' => $this->options['ad1_market'],
            //
            'ad2_image_url' => $this->options['ad2_image_url'],
            'ad2_link_url' => $this->options['ad2_link_url'],
            
            'goods_list_1' => $recom_mod->get_recommended_goods($this->options['img_recom_id_1'], 6, true, $this->options['img_cate_id_1']),
            
            'model_name2' => $this->options['model_name2'],
            'goods_list_2' => $recom_mod->get_recommended_goods($this->options['img_recom_id_2'], 3, true, $this->options['img_cate_id_2']),
            
            'model_name3' => $this->options['model_name3'],
            'goods_list_3' => $recom_mod->get_recommended_goods($this->options['img_recom_id_3'], 3, true, $this->options['img_cate_id_3']),
            
            'model_name4' => $this->options['model_name4'],
            'goods_list_4' => $recom_mod->get_recommended_goods($this->options['img_recom_id_4'], 3, true, $this->options['img_cate_id_4']),
        );
        
        return $data;
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
        for ($i = 1; $i <= 20; $i++) {
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