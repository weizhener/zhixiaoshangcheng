<?php

/**
 *    Desc
 *
 *    @author    Garbin
 *    @usage    none
 */
class ReferApp extends MemberbaseApp {

    var $user_id;
    var $_member_mod;

    function __construct() {
        $this->ReferApp();
    }

    function ReferApp() {

        parent::__construct();
        $this->user_id = $this->visitor->get('user_id');
        $this->_member_mod = & m('member');
    }

    function index() {

        //获取当前用户的信息
        $member_info = $this->_member_mod->get($this->user_id);
        $this->assign('member_info', $member_info);

        if (!empty($member_info['referid'])) {
            //获取当前用户的推荐人
            $parent_refers = $this->_member_mod->get($member_info['referid']);
            $this->assign('parent_refers', $parent_refers);
        }


        $this->import_resource(array(
            'script' => array(
                array(
                    'path' => 'jquery.ui/jquery.ui.js',
                    'attr' => '',
                ),
            ),
            'style' => 'jquery.ui/themes/ui-lightness/jquery.ui.css',
        ));

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('refer'));
        /* 当前用户中心菜单 */
        $this->_curitem('refer');
        $this->_curmenu('refer');

        $url = SITE_URL . '/index.php?app=member%26act=register%26referid=' . $this->user_id;
        $scan_code = '<img src=' . SITE_URL . '/index.php?app=qrcode&url=' . $url . ' />';
        $this->assign('scan_code', $scan_code);

        $this->display('refer.index.html');
    }

    function all_refer() {
        //获取相关子孙推荐人
        $all_refers = $this->_get_all_refers($this->user_id);
        $this->assign('all_refers', $all_refers);

        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('refer'));
        /* 当前用户中心菜单 */
        $this->_curitem('refer');
        $this->_curmenu('all_refer');

        $this->display('refer.all_refer.html');
    }

    function _get_all_refers($user_id) {

        //获取所有用户 包含子孙
        $members = $this->_member_mod->find();

        import('tree.lib');
        $tree = new Tree();
        $tree->setTree($members, 'user_id', 'referid', 'user_name');


        return $tree->getOptions(0, $user_id, NULL, '<img src="' . site_url() . '/themes/mall/jd2015/styles/default/images/treetable/tv-item-last.gif" class="ttimage">');
//        return $tree->getArrayList(0);
    }

    function _get_member_submenu() {
        $array = array(
            array(
                'name' => 'refer',
                'url' => 'index.php?app=refer',
            ),
            array(
                'name' => 'all_refer',
                'url' => 'index.php?app=refer&act=all_refer',
            ),
            array(
                'name' => 'refer_user1',
                'url' => 'index.php?app=refer&act=refer_user1',
            ),
            array(
                'name' => 'refer_user2',
                'url' => 'index.php?app=refer&act=refer_user2',
            ),
            array(
                'name' => 'refer_user3',
                'url' => 'index.php?app=refer&act=refer_user3',
            ),
        );
        return $array;
    }

    /**
     * 一级推荐人
     */
    function refer_user1() {
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('refer_user1'));
        /* 当前用户中心菜单 */
        $this->_curitem('refer');
        $this->_curmenu('refer_user1');


        $page = $this->_get_page();
        $refers1 = $this->_member_mod->findAll(
                array(
                    'conditions' => 'referid=' . $this->user_id,
                    'count' => true,
                    'limit' => $page['limit'],
                )
        );
        $page['item_count'] = $this->_member_mod->getCount();
        $this->_format_page($page);
        $this->assign('page_info', $page);
        $this->assign('refers', $refers1);
        $this->display('refer.refer.html');
    }

    function refer_user2() {
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('refer_user2'));
        /* 当前用户中心菜单 */
        $this->_curitem('refer');
        $this->_curmenu('refer_user2');

        //首先获得一级的推荐人列表
        $refers1 = $this->_member_mod->findAll(
                array(
                    'fields' => 'referid',
                    'conditions' => 'referid=' . $this->user_id,
                )
        );

        //如果有推荐人
        if (!empty($refers1)) {
            $ids = array();
            foreach ($refers1 as $key => $refer) {
                $ids[] = $refer['user_id'];
            }
            $page = $this->_get_page();
            $refers2 = $this->_member_mod->findAll(
                    array(
                        'conditions' => 'referid ' . db_create_in($ids),
                        'count' => true,
                        'limit' => $page['limit'],
                    )
            );
            $page['item_count'] = $this->_member_mod->getCount();
            $this->_format_page($page);
            $this->assign('page_info', $page);
            $this->assign('refers', $refers2);
        }
        $this->display('refer.refer.html');
    }

    function refer_user3() {
        /* 当前位置 */
        $this->_curlocal(LANG::get('member_center'), 'index.php?app=member', LANG::get('refer_user2'));
        /* 当前用户中心菜单 */
        $this->_curitem('refer');
        $this->_curmenu('refer_user3');

        //首先获得一级的推荐人列表
        $refers1 = $this->_member_mod->findAll(
                array(
                    'fields' => 'referid',
                    'conditions' => 'referid=' . $this->user_id,
                )
        );

        //如果有推荐人
        if (!empty($refers1)) {
            $ids = array();
            foreach ($refers1 as $key => $refer) {
                $ids[] = $refer['user_id'];
            }

            $refers2 = $this->_member_mod->findAll(
                    array(
                        'conditions' => 'referid ' . db_create_in($ids),
                    )
            );

            if (!empty($refers2)) {
                $ids = array();
                foreach ($refers2 as $key => $refer) {
                    $ids[] = $refer['user_id'];
                }

                $page = $this->_get_page();
                $refers3 = $this->_member_mod->findAll(
                        array(
                            'conditions' => 'referid ' . db_create_in($ids),
                            'count' => true,
                            'limit' => $page['limit'],
                        )
                );
                $page['item_count'] = $this->_member_mod->getCount();
                $this->_format_page($page);
                $this->assign('page_info', $page);
                $this->assign('refers', $refers3);
            }
        }
        $this->display('refer.refer.html');
    }

}

?>
