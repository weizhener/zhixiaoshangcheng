<?php



/**

 *    成长值设置

 *

 *    @author   cengnlaeng

 *    @usage    none

 */

class GrowthArrayfile extends BaseArrayfile

{

    function __construct()

    {

        $this->GrowthArrayfile();

    }



    function GrowthArrayfile()

    {

        $this->_filename = ROOT_PATH . '/data/growth.inc.php';

    }

    function get_default()

    {

        return array(

            'register_growth'=>5,

			'bought_growth'=>0.05,

			'comment_growth'=>5

        );

    }

}

?>