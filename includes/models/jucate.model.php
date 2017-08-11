<?php
/* 团购活动 groupbuy */
class JucateModel extends BaseModel
{
    var $table  = 'ju_cate';
    var $prikey = 'cate_id';
    var $_name  = 'jucate';
	
	/**
     * 取得分类列表
     *
     * @param int $parent_id 大于等于0表示取某分类的下级分类，小于0表示取所有分类
     * @param bool $shown 只取要显示的分类
     * @return array
     */
    function get_list($parent_id = -1, $shown = false)
    {
        $conditions = "1 = 1";
        $parent_id >= 0 && $conditions .= " AND parent_id = '$parent_id'";
        $shown && $conditions .= " AND if_show = 1";

        return $this->find(array(
            'conditions' => $conditions,
            'order' => 'sort_order, cate_id',
        ));
    }

    function get_options($parent_id = -1, $shown = false)
    {
        $options = array();
        $rows = $this->get_list($parent_id, $shown);
        foreach ($rows as $row)
        {
            $options[$row['cate_id']] = $row['cate_name'];
        }

        return $options;
    }
	
	/*
     * 判断名称是否唯一
     */
    function unique($cate_name, $parent_id, $cate_id = 0)
    {
        $conditions = "parent_id = '$parent_id' AND cate_name = '$cate_name'";
        $cate_id && $conditions .= " AND cate_id <> '" . $cate_id . "'";
        return count($this->find(array('conditions' => $conditions))) == 0;
    }
	
	/**
     * 取得某分类的所有子孙分类id（不推荐使用，但是因为调用模块和专题模块中用到了，所以暂时保留，推荐使用业务模型中的相关函数）
     */
    function get_descendant($id)
    {
        $ids = array($id);
        $ids_total = array();
        $this->_get_descendant($ids, $ids_total);
        return array_unique($ids_total);
    }
	
	function _get_descendant($ids, &$ids_total)
    {
        $childs = $this->find(array(
            'fields' => 'cate_id',
            'conditions' => "parent_id " . db_create_in($ids)
        ));
        $ids_total = array_merge($ids_total, $ids);
        $ids = array();
        foreach ($childs as $child)
        {
            $ids[] = $child['cate_id'];
        }
        if (empty($ids))
        {
            return ;
        }
        $this->_get_descendant($ids, $ids_total);
    }
	
	/**
     * 取得某分类的深度（没有子节点深度为1）
     * 
     * @param   int     $id     分类id（需保证是存在的）
     * @return  int     深度
     */
    function get_depth($id)
    {
        $depth = 0;

        $pids = array($id);
        while ($pids)
        {
            $depth++;
            $sql  = "SELECT cate_id FROM {$this->table} " . $this->_getConditions("parent_id " . db_create_in($pids));
            $pids = $this->getCol($sql);
        }

        return $depth;
    }
	
	/**
     * 取得某分类的子分类
     *
     * @param   int     $id     分类id
     * @param   bool    $cached 是否缓存（缓存数据不包括不显示的分类，一般用于前台；非缓存数据包括不显示的分类，一般用于后台）
     * @return  array(
     *              array('cate_id' => 1, 'cate_name' => '数码产品'),
     *              array('cate_id' => 2, 'cate_name' => '手机'),
     *              ...
     *          )
     */
    function get_children($id, $cached = false)
    {
        $res = array();

        if ($cached)
        {
            $data = $this->_get_structured_data();
            if (isset($data[$id]))
            {
                $cids = $data[$id]['cids'];
                foreach ($cids as $id)
                {
                    $res[$id] = array(
                        'cate_id'   => $id, 
                        'cate_name' => $data[$id]['name'],
                    );
                }
            }
        }
        else
        {
            $sql = "SELECT cate_id, cate_name FROM {$this->table} WHERE parent_id = '$id'";
            $res = $this->getAll($sql);
        }

        return $res;
    }
	
	/**
     * 取得某分类的祖先分类（包括自身，按层级排序）
     *
     * @param   int     $id     分类id
     * @param   bool    $cached 是否缓存（缓存数据不包括不显示的分类，一般用于前台；非缓存数据包括不显示的分类，一般用于后台）
     * @return  array(
     *              array('cate_id' => 1, 'cate_name' => '数码产品'),
     *              array('cate_id' => 2, 'cate_name' => '手机'),
     *              ...
     *          )
     */
    function get_ancestor($id, $cached = false)
    {
        $res = array();

        if ($cached)
        {
            $data = $this->_get_structured_data();
            if ($id > 0 && isset($data[$id]))
            {
                while ($id > 0)
                {
                    $res[] = array('cate_id' => $id, 'cate_name' => $data[$id]['name']);
                    $id    = $data[$id]['pid'];
                }
            }
        }
        else
        {
            while ($id > 0)
            {
                $sql = "SELECT cate_id, cate_name, parent_id FROM {$this->table} WHERE cate_id = '$id'";
                $row = $this->getRow($sql);
                if ($row)
                {
                    $res[] = array('cate_id' => $row['cate_id'], 'cate_name' => $row['cate_name']);
                    $id    = $row['parent_id'];
                }
            }
        }

        return array_reverse($res);
    }
	
	/**
     * 取得某分类的层级（从1开始算起）
     * 
     * @param   int     $id     分类id
     * @param   bool    $cached 是否缓存（缓存数据不包括不显示的分类，一般用于前台；非缓存数据包括不显示的分类，一般用于后台）
     * @return  int     层级     当分类不存在或不显示时返回false
     */
    function get_layer($id, $cached = false)
    {
        $ancestor = $this->get_ancestor($id, $cached);
        if (empty($ancestor))
        {
            return false; //分类不存在或不显示
        }
        else
        {
            return count($ancestor);
        }        
    }
}
?>
