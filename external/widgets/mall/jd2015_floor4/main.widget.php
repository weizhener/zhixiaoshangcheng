<?php

class jd2015_floor4Widget extends BaseWidget {

    var $_name = 'jd2015_floor4';
    var $_ttl = 86400;
    var $_num = 4;

    function _get_data() {
        $recom_mod = & m('recommend');
        $data = array(
            'model_id' => mt_rand(),
            'num_name' => $this->options['num_name'],
            'model_name' => $this->options['model_name'],
            //产品调用
            'goods_list_1' => $recom_mod->get_recommended_goods($this->options['img_recom_id_1'], 10, true, $this->options['img_cate_id_1']),
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

    function _upload_image() {
        import('uploader.lib');
        $images = array();
        for ($i = 1; $i <= 8; $i++) {
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

    function get_config_datasrc() {
        // 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options());
    }

}

?>