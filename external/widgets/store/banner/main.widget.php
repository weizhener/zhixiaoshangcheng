<?php

class BannerWidget extends Store_baseWidget
{
    var $_name = 'banner';

    function _get_data()
    {
        return array(
            'ad_image_url'  => $this->options['ad_image_url'],
			'ad_height'     => $this->options['ad_link'],
			'ad_height'     => $this->options['ad_height'],
        );
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