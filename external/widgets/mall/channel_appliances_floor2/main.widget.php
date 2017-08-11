<?php

class channel_appliances_floor2Widget extends BaseWidget {

    var $_name = 'channel_appliances_floor2';
    var $_ttl = 86400;
    var $_num = 4;

    function _get_data() {
        $data = array(
            'model_name1' => $this->options['model_name1'],
            'model_name2' => $this->options['model_name2'],
            'model_name3' => $this->options['model_name3'],
            'model_name4' => $this->options['model_name4'],
            'articles' => $this->_get_article($this->options['cate_id']),
            'articles1' => $this->_get_article($this->options['cate_id_1']),


            //
            'ad1_image_url' => $this->options['ad1_image_url'],
            'ad1_link_url' => $this->options['ad1_link_url'],
            'ad1_title' => $this->options['ad1_title'],
            //
            'ad2_image_url' => $this->options['ad2_image_url'],
            'ad2_link_url' => $this->options['ad2_link_url'],
            'ad2_title' => $this->options['ad2_title'],
            //
            'ad3_image_url' => $this->options['ad3_image_url'],
            'ad3_link_url' => $this->options['ad3_link_url'],
            'ad3_title' => $this->options['ad3_title'],
            //
            'ad4_image_url' => $this->options['ad4_image_url'],
            'ad4_link_url' => $this->options['ad4_link_url'],
            'ad4_title' => $this->options['ad4_title'],
            //
            'ad5_image_url' => $this->options['ad5_image_url'],
            'ad5_link_url' => $this->options['ad5_link_url'],
            'ad5_title' => $this->options['ad5_title'],
            //
            'ad6_image_url' => $this->options['ad6_image_url'],
            'ad6_link_url' => $this->options['ad6_link_url'],
            'ad6_title' => $this->options['ad6_title'],
            //
            'ad7_image_url' => $this->options['ad7_image_url'],
            'ad7_link_url' => $this->options['ad7_link_url'],
            'ad7_title' => $this->options['ad7_title'],
            //
             'ad8_image_url' => $this->options['ad8_image_url'],
            'ad8_link_url' => $this->options['ad8_link_url'],
            'ad8_title' => $this->options['ad8_title'],
            //
             'ad9_image_url' => $this->options['ad9_image_url'],
            'ad9_link_url' => $this->options['ad9_link_url'],
            'ad9_title' => $this->options['ad9_title'],
            //
             'ad10_image_url' => $this->options['ad10_image_url'],
            'ad10_link_url' => $this->options['ad10_link_url'],
            'ad10_title' => $this->options['ad10_title'],
            //
             'ad11_image_url' => $this->options['ad11_image_url'],
            'ad11_link_url' => $this->options['ad11_link_url'],
            'ad11_title' => $this->options['ad11_title'],
            //
             'ad12_image_url' => $this->options['ad12_image_url'],
            'ad12_link_url' => $this->options['ad12_link_url'],
            'ad12_title' => $this->options['ad12_title'],
            //
             'ad13_image_url' => $this->options['ad13_image_url'],
            'ad13_link_url' => $this->options['ad13_link_url'],
            //
             'ad14_image_url' => $this->options['ad14_image_url'],
            'ad14_link_url' => $this->options['ad14_link_url'],
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
            'limit' => 4,
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
    
    function get_config_datasrc() {
        // 取得多级文章分类，去除系统文章
        $this->assign('acategories', $this->_get_acategory_options(2));
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