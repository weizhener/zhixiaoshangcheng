<?php

class jd2015_floor2Widget extends BaseWidget {

    var $_name = 'jd2015_floor2';
    var $_ttl = 86400;
    var $_num = 6;

    function _get_data() {
        $recom_mod = & m('recommend');
        $cate_id_1 = empty($this->options['cate_id_1']) ? 0 : $this->options['cate_id_1'];
        $data = array(
            'model_id' => mt_rand(),
            'cates_1' => $this->get_cate($cate_id_1),
            'num_name' => $this->options['num_name'],
            'model_name' => $this->options['model_name'],
            'sub_title_name1' => $this->options['sub_title_name1'],
            'sub_title_name1_link_url' => $this->options['sub_title_name1_link_url'],
            'sub_title_name2' => $this->options['sub_title_name2'],
            'sub_title_name2_link_url' => $this->options['sub_title_name2_link_url'],
            'sub_title_name3' => $this->options['sub_title_name3'],
            'sub_title_name3_link_url' => $this->options['sub_title_name3_link_url'],
            'sub_title_name4' => $this->options['sub_title_name4'],
            'sub_title_name4_link_url' => $this->options['sub_title_name4_link_url'],
            'ad1_image_url' => $this->options['ad1_image_url'],
            'ad1_link_url' => $this->options['ad1_link_url'],
            'ad2_image_url' => $this->options['ad2_image_url'],
            'ad2_link_url' => $this->options['ad2_link_url'],
            'ad3_image_url' => $this->options['ad3_image_url'],
            'ad3_link_url' => $this->options['ad3_link_url'],
            'ad4_image_url' => $this->options['ad4_image_url'],
            'ad4_link_url' => $this->options['ad4_link_url'],
            'ad5_image_url' => $this->options['ad5_image_url'],
            'ad5_link_url' => $this->options['ad5_link_url'],
            'ad6_image_url' => $this->options['ad6_image_url'],
            'ad6_link_url' => $this->options['ad6_link_url'],
            'ad7_image_url' => $this->options['ad7_image_url'],
            'ad7_link_url' => $this->options['ad7_link_url'],
            'ad8_image_url' => $this->options['ad8_image_url'],
            'ad8_link_url' => $this->options['ad8_link_url'],
            'ad9_image_url' => $this->options['ad9_image_url'],
            'ad9_link_url' => $this->options['ad9_link_url'],
            'ad10_image_url' => $this->options['ad10_image_url'],
            'ad10_link_url' => $this->options['ad10_link_url'],
            'ad11_image_url' => $this->options['ad11_image_url'],
            'ad11_link_url' => $this->options['ad11_link_url'],
            'ad12_image_url' => $this->options['ad12_image_url'],
            'ad12_link_url' => $this->options['ad12_link_url'],
            'ad13_image_url' => $this->options['ad13_image_url'],
            'ad13_link_url' => $this->options['ad13_link_url'],
            'ad14_image_url' => $this->options['ad14_image_url'],
            'ad14_link_url' => $this->options['ad14_link_url'],
            'model_name1' => $this->options['model_name1'],
            'goods_list_1' => $recom_mod->get_recommended_goods($this->options['img_recom_id_1'], 10, true, $this->options['img_cate_id_1']),
            'model_name2' => $this->options['model_name2'],
            'goods_list_2' => $recom_mod->get_recommended_goods($this->options['img_recom_id_2'], 10, true, $this->options['img_cate_id_2']),
            'model_name3' => $this->options['model_name3'],
            'goods_list_3' => $recom_mod->get_recommended_goods($this->options['img_recom_id_3'], 10, true, $this->options['img_cate_id_3']),
            'model_name4' => $this->options['model_name4'],
            'goods_list_4' => $recom_mod->get_recommended_goods($this->options['img_recom_id_4'], 10, true, $this->options['img_cate_id_4']),
            'model_name5' => $this->options['model_name5'],
            'goods_list_5' => $recom_mod->get_recommended_goods($this->options['img_recom_id_5'], 10, true, $this->options['img_cate_id_5']),
            'model_name6' => $this->options['model_name6'],
            'goods_list_6' => $recom_mod->get_recommended_goods($this->options['img_recom_id_6'], 10, true, $this->options['img_cate_id_6']),
            'model_name7' => $this->options['model_name7'],
            'goods_list_7' => $recom_mod->get_recommended_goods($this->options['img_recom_id_7'], 10, true, $this->options['img_cate_id_7']),
        );
        return $data;
    }

//获取设定分类下的子分类
    function get_cate($cate_id) {
        $mod_gcage = &bm('gcategory');
        $cates = $mod_gcage->get_children($cate_id, true);
        return $cates;
    }

    function get_config_datasrc() {
        // 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options());
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

    function _upload_image() {
        import('uploader.lib');
        $images = array();
        for ($i = 1; $i <= 14; $i++) {
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