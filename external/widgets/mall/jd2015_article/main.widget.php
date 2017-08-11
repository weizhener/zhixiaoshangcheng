<?php

/**
 * 文章挂件
 *
 * @return  array
 */
class jd2015_articleWidget extends BaseWidget {
    var $_name = 'jd2015_article';
    var $_ttl = 86400;
    function _get_data() {
        $cache_server = & cache_server();
        $key = $this->_get_cache_id();
        $data = $cache_server->get($key);
        if ($data === false) {

            $data = array(
                'model_id' => mt_rand(),
                'model_name' => $this->options['model_name'],
                'articles' => $this->_get_article($this->options['cate_id1']),
            );
            $cache_server->set($key, $data, $this->_ttl);
        }
        return $data;
    }
    function get_config_datasrc() {
        // 取得多级文章分类，去除系统文章
        $this->assign('acategories', $this->_get_acategory_options(2));
    }
    
    function _get_article($cate_id) {
        $acategory_mod = &m('acategory');
        $cate_ids = $acategory_mod->get_descendant($cate_id);
        if ($cate_ids) {
            $conditions = ' AND cate_id ' . db_create_in($cate_ids);
        } else {
            $conditions = '';
        }
        
        $article_mod = & m('article');
        $articles = $article_mod->find(array(
            'conditions' => 'code = "" AND if_show=1 AND store_id=0 ' . $conditions,
            'fields' => 'article_id, title',
            'limit' => 5,
            'order' => 'sort_order ASC, article_id DESC'
        ));
        return $articles;
    }

    function parse_config($input) {
        return $input;
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

}

?>