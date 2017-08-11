<?php

class HistoryApp extends MallbaseApp {
    
    function index()
    {
        
        $goods_mod = &m('goods');
        $goods_list = array();
        $goods_ids = ecm_getcookie('goodsBrowseHistory');
        $goods_ids = $goods_ids ? explode(',', $goods_ids) : array();
        if ($goods_ids) {
            $rows = $goods_mod->find(array(
                'conditions' => $goods_ids,
                'fields' => 'goods_name,default_image',
            ));
            foreach ($goods_ids as $goods_id) {
                if (isset($rows[$goods_id])) {
                    empty($rows[$goods_id]['default_image']) && $rows[$goods_id]['default_image'] = Conf::get('default_goods_image');
                    $goods_list[] = $rows[$goods_id];
                }
            }
        }
    
        /* 配置seo信息 */
        $this->_config_seo('title', Lang::get('goods_history') . ' - ' . Conf::get('site_title'));
        $this->_curlocal(array(array('text' => Lang::get('goods_history'), 'url' => '')));
        $this->assign('goods_list', $goods_list);
        
        
        $this->display('history.index.html');
    }
    
    
}
?>
