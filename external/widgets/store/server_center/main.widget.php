<?php

/**
 * 4个图片广告挂件
 *
 * @param   string  $ad_image_url   广告图片地址1-4
 * @param   string  $ad_link_url    广告链接地址1-4
 * @return  array
 */
class Server_centerWidget extends Store_baseWidget
{
    var $_name = 'server_center';

    function _get_data()
    {
		$result=array();
		$acounts=explode(' ',$this->options['acount']);
		for($i=0;$i<9;$i++){
			$result[$i]['ad_image_url']  = $this->options['ad'.$i.'_image_url'];
			$type=explode(',',$acounts[$i]);
			$result[$i]['type']=$type[0];
			$result[$i]['acount']=$type[1];
			$result[$i]['acount_name']=$type[2];
		}
		$result=array_chunk($result,3);
		if($result){
			$data=array();
			$title=explode(' ',$this->options['title']);
			$i=0;
			foreach($result  as $key=>$val){
				$data[$key]['im']=$val;
				$data[$key]['title']=$title[$i];
				$i++;
				unset($result[$key]);
			}
		}
		return $data;
    }

    function parse_config($input)
    {
        $images = $this->_upload_image();
        if ($images)
        {
            foreach ($images as $key => $image)
            {
                $input['ad' . $key . '_image_url'] = $image;
            }
        }

        return $input;
    }

    function _upload_image()
    {
        import('uploader.lib');
        $images = array();
        for ($i = 0; $i < 9; $i++)
        {
            $file = $_FILES['ad' . $i . '_image_file'];
            if ($file['error'] == UPLOAD_ERR_OK)
            {
                $uploader = new Uploader();
                $uploader->allowed_type(IMAGE_FILE_TYPE);
                $uploader->addFile($file);
                $uploader->root_dir(ROOT_PATH);
                $images[$i] = $uploader->save('data/files/store_'.$this->_store_id.'/template', $uploader->random_filename());
            }
        }

        return $images;
    }
}

?>