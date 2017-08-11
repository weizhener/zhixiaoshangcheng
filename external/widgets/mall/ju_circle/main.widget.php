<?php

/**
 *
 * @return  array
 */
class Ju_circleWidget extends BaseWidget
{
    var $_name = 'ju_circle';
    var $_ttl  = 1800;
	var $_num = 15;
	
	function _get_data()
    {
		$data = array(
		   'model_id'=>mt_rand(),
		   'model_name'	 	=> $this->options['model_name'],
		   'keywords'  	 	=> $this->get_keywords(),
		   'ads'=> $this->options['ads'],
		);
        return $data;
    }
	
	function get_keywords()
	{
		$keywords = explode(',',$this->options['keyword']);
		$link 	  = explode(',',$this->options['link']);
		foreach($keywords as $key => $word)
		{
			$data[] = array(
				'keyword' => $word,
				'link' => $link[$key],
			);
		}
		return $data;
	}

    function parse_config($input)
    {
        $result = array();
        $num    = isset($input['ad_link_url']) ? count($input['ad_link_url']) : 0;
        if ($num > 0)
        {
            $images = $this->_upload_image($num);
            for ($i = 0; $i < $num ; $i++)
            {
                if (!empty($images[$i]))
                {
                    $input['ad_image_url'][$i] = $images[$i];
                }
    
                if (!empty($input['ad_image_url'][$i]))
                {
                    $result[] = array(
                        'ad_image_url' => $input['ad_image_url'][$i],
                        'ad_link_url'  => $input['ad_link_url'][$i],
                        'ad_title' => $input['ad_title'][$i]
                    );
                }
            }
        }
		$input['ads'] = $result;

        return $input;
    }

    function _upload_image($num)
    {
        import('uploader.lib');

        $images = array();
        for ($i = 0; $i < $num; $i++)
        {
            $file = array();
            foreach ($_FILES['ad_image_file'] as $key => $value)
            {
                $file[$key] = $value[$i];
            }

            if ($file['error'] == UPLOAD_ERR_OK)
            {
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