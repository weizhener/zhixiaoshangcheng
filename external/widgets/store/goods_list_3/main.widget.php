<?php

/**
 * 商品列表挂件
 */
class Goods_list_3Widget extends Store_baseWidget
{
    var $_name = 'goods_list_3';
	var $_ttl  = 86400;
	function _get_data()
    {
		$amount = !empty($this->options['amount']) ? intval($this->options['amount']) : 9;
		$recom_mod =& bm('recommend', array('_store_id' => $this->_store_id));
        $goods_list = $recom_mod->get_recommended_goods($this->options['img_recom_id'], $amount, true, $this->options['img_cate_id']);
		$data = array(
			'model_name' => $this->options['model_name'],
			'ad_image_url'  => $this->options['ad_image_url'],
			'ad_width'      => $this->options['ad_width'],
			'ad_height'     => $this->options['ad_height'],
			'link'  => $this->options['link'],
			'model_color'=>$this->options['model_color']?$this->options['model_color']:'#FFAA89',
			'goods_list' => $goods_list,
		);
        return $data;
    }
	
	function get_config_datasrc()
    {
		// 取得推荐类型
        $this->assign('recommends', $this->_get_recommends());
		
        // 取得一级商品分类
        $this->assign('gcategories', $this->_get_gcategory_options(1));
    }
	function parse_config($input)
    {
        $image = $this->_upload_image();
        if ($image)
        {
            $input['ad_image_url'] = $image;
        }

        return $input;
    }
	function _upload_image()
    {
        import('uploader.lib');
        $file = $_FILES['ad_image_file'];
        if ($file['error'] == UPLOAD_ERR_OK)
        {
            $uploader = new Uploader();
            $uploader->allowed_type(IMAGE_FILE_TYPE);
            $uploader->addFile($file);
            $uploader->root_dir(ROOT_PATH);
            return $uploader->save("data/files/store_{$this->_store_id}/template", $uploader->random_filename());
        }

        return '';
    } 
}

?>