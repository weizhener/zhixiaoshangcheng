<?php

/* 多级选择：地区选择，分类选择 */

class MlselectionApp extends MallbaseApp {

    function index() {
        in_array($_GET['type'], array('region', 'gcategory', 'sdcategory','jucategory')) or $this->json_error('invalid type');
        $pid = empty($_GET['pid']) ? 0 : $_GET['pid'];

        switch ($_GET['type']) {
            case 'region':
                $mod_region = & m('region');
                $regions = $mod_region->get_list($pid);
                foreach ($regions as $key => $region) {
                    $regions[$key]['region_name'] = htmlspecialchars($region['region_name']);
                }
                $this->json_result(array_values($regions));
                break;
            case 'gcategory':
                $mod_gcategory = & m('gcategory');
                $cates = $mod_gcategory->get_list($pid, true);
                foreach ($cates as $key => $cate) {
                    $cates[$key]['cate_name'] = htmlspecialchars($cate['cate_name']);
                }
                $this->json_result(array_values($cates));
                break;
            case 'sdcategory':
                $mod_sdcategory = & m('sdcategory');
                $sdcates = $mod_sdcategory->get_list($pid, true);
                foreach ($sdcates as $key => $sdcate) {
                    $sdcates[$key]['cate_name'] = htmlspecialchars($sdcate['cate_name']);
                }
                $this->json_result(array_values($sdcates));
                break;
            case 'jucategory':
                $mod_jucategory = & m('jucate');
                $jucates = $mod_jucategory->get_list($pid, true);
                foreach ($jucates as $key => $jucate) {
                    $jucates[$key]['cate_name'] = htmlspecialchars($jucate['cate_name']);
                }
                $this->json_result(array_values($jucates));
                break;
        }
    }

}

?>