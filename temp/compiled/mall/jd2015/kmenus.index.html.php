<?php echo $this->fetch('member.header.html'); ?>
<style>
select{height: auto}
.kg{overflow:hidden;padding:20px 85px;border-bottom:#eee solid 1px;}
.zscul{margin-left:35px;}
.zscul li{padding:8px;}
.zscul li select{padding:5px;}
.btn{background: none repeat scroll 0 0 #3F89EC;border: 0 none;color: #FFFFFF;cursor: pointer;font-weight: bold;height: 32px;width: 120px;margin-left:111px;}
table{padding-bottom:50px;}
table th{border-top:1px solid #EEEEEE; border-bottom:1px solid #EEEEEE;}
table td{border-bottom:1px solid #EEEEEE;}
table th,table td{padding:8px 10px; text-align:center;}
.plug-menu{border-radius: 36px;box-shadow: 0 0 0 4px #FFFFFF, 0 2px 5px 4px rgba(0, 0, 0, 0.25);height: 36px;position: relative;width: 36px;margin:0 auto;}
.plug-menu span {display: block;height: 28px;left: 4px;overflow: hidden;position: absolute;text-indent: -999px;top: 4px;width: 28px;}
.remind .btn1{float: left;}
</style>

<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">    
        <div class="wrap">
            <div class="kg">
                <h3 style="color:#666;" class="h_left remind">
                    <a href="<?php echo url('app=kmenus'); ?>" style="margin:0 30px 0 -40px;" class="btn1"><span class="pic2">快捷菜单管理</span></a>
                    <a href="<?php echo url('app=kmenusinfo'); ?>" style="margin:0;" class="btn1"> <span class="pic1">添加快捷菜单</span></a>
                </h3>
            </div>
            <div class="content-right" style="padding-top:20px;">
                <ul class="zscul">
                    <form  method="post">
                        <li>
                            <strong>是否启用快捷菜单：</strong>
                            <input type="radio" <?php if ($this->_var['kmenus']['status'] == 0): ?>checked="checked"<?php endif; ?> value="0" name="status" /> 启用
                                   <input type="radio" <?php if ($this->_var['kmenus']['status'] == 1): ?>checked="checked"<?php endif; ?> value="1" style="margin-left:20px;" name="status"/> 不启用
                        </li>
                        <li>
                            <strong style="margin-left:72px;">样式：</strong>
                            <select name="stype">
                                <option <?php if ($this->_var['kmenus']['stype'] == 1): ?>selected="selected"<?php endif; ?> value="1">样式一</option>
                            </select>
                        </li>
                        <li>
                            <strong style="margin-left:72px;">示例：</strong>
                            <img src="<?php echo $this->_var['site_url']; ?>/mall/kmenus/shili.png" />
                        </li>
                        <li>
                            <strong style="margin-left:48px;">显示方式：</strong>
                            <select name="stypeinfo">
                                <option <?php if ($this->_var['kmenus']['stypeinfo'] == 1): ?>selected="selected"<?php endif; ?> value="1">左下角横向显示</option>
                                <option <?php if ($this->_var['kmenus']['stypeinfo'] == 2): ?>selected="selected"<?php endif; ?> value="2">左下角纵向显示</option>
                                <option <?php if ($this->_var['kmenus']['stypeinfo'] == 3): ?>selected="selected"<?php endif; ?> value="3">右下角横向显示</option>
                                <option <?php if ($this->_var['kmenus']['stypeinfo'] == 4): ?>selected="selected"<?php endif; ?> value="4">右下角纵向显示</option>
                            </select>
                        </li>
                        <li>
                            <input type="submit" value="保存" class="btn" />
                        </li>
                    </form>
                </ul>
            </div> 
            <div class="content-right" style="padding-top:20px;">
                <table>
                    <tr>
                        <th width="120">效果图</th>
                        <th>链接</th>
                        <th width="80">名称</th>
                        <th width="120">操作</th>
                    </tr>
                    <?php $_from = $this->_var['kmenusinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'info');if (count($_from)):
    foreach ($_from AS $this->_var['info']):
?>
                    <tr>
                        <td>
                            <div class="plug-menu" style="background-color: #<?php echo $this->_var['info']['color']; ?>;">
                                <span class="close" style="background:url('<?php echo $this->_var['info']['imgurl']; ?>') no-repeat scroll 0 0 / 28px 28px rgba(0, 0, 0, 0);">
                                </span>
                            </div>
                        </td>
                        <td><?php echo $this->_var['info']['loadurl']; ?></td>
                        <td><?php echo $this->_var['info']['title']; ?></td>
                        <td>
                            <a href="<?php echo url('app=kmenusinfo&act=edit&id='); ?><?php echo $this->_var['info']['kmenusinfo_id']; ?>">编辑</a>
                            <a style="margin-left:10px;" href="javascript:drop_confirm('您确定要删除吗？','<?php echo url('app=kmenusinfo&act=del&id='); ?><?php echo $this->_var['info']['kmenusinfo_id']; ?>');">删除</a>
                        </td>
                    </tr>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                </table>
            </div>         
        </div>
    </div>

</div>
<div class="clear"></div>
<?php echo $this->fetch('footer.html'); ?>

