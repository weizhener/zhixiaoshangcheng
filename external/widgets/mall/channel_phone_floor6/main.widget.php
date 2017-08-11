<?php

class channel_phone_floor6Widget extends BaseWidget {

    var $_name = 'channel_phone_floor6';
    var $_ttl = 86400;
    var $_num = 10;

    function _get_data() {
        $data = array(
            'model_id' => mt_rand(),
            'model_name1' => $this->options['model_name1'],
            'model_name2' => $this->options['model_name2'],
            'articles_3' => $this->_get_article($this->options['cate_id_3']),
            'model_name3' => $this->options['model_name3'],
            'model_name4' => $this->options['model_name4'],
            'articles_1' => $this->_get_article($this->options['cate_id_1']),
            'model_name5' => $this->options['model_name5'],
            'articles_2' => $this->_get_article($this->options['cate_id_2']),
            //
            'ad1_image_url' => $this->options['ad1_image_url'],
            'ad1_link_url' => $this->options['ad1_link_url'],
            'ad1_title' => $this->options['ad1_title'],
            'ad1_name' => $this->options['ad1_name'],
            //
            'ad2_image_url' => $this->options['ad2_image_url'],
            'ad2_link_url' => $this->options['ad2_link_url'],
            'ad2_title' => $this->options['ad2_title'],
            'ad2_name' => $this->options['ad2_name'],
            //
            'ad3_image_url' => $this->options['ad3_image_url'],
            'ad3_link_url' => $this->options['ad3_link_url'],
            //
            'ad4_image_url' => $this->options['ad4_image_url'],
            'ad4_link_url' => $this->options['ad4_link_url'],
            //
            'ad5_image_url' => $this->options['ad5_image_url'],
            'ad5_link_url' => $this->options['ad5_link_url'],
            'ad_flash_url' => $this->options['ad_flash_url'],
            'ad1_flash_url' => $this->options['ad1_flash_url'],
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

    function get_config_datasrc() {
        // 取得多级文章分类，去除系统文章
        $this->assign('acategories', $this->_get_acategory_options(2));
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