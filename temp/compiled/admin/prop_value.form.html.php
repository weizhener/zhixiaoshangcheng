<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>商品属性</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=props">属性列表</a></li>
        <?php if ($_GET['act'] == 'add_value'): ?>
        <li><span>新增属性值</span>
        <?php else: ?>
        <li><a class="btn1" href="index.php?app=props&amp;act=add_value">新增属性值</a></li>
        <li><span>编辑属性值</span></li>
        <?php endif; ?>        
    </ul>
</div>
<style>
.prop_input{border:1px #ddd solid; height:22px; line-height:22px;}
</style>
<div class="info">
    <form method="post">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    属性名:</th>
                <td class="paddingT15 wordSpacing5">
                    <select name="pid">
                       <?php $_from = $this->_var['props']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                       <option value="<?php echo $this->_var['item']['pid']; ?>" <?php if ($this->_var['item']['pid'] == $this->_var['prop_value']['pid']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['item']['name']; ?></option>
                       <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    属性值:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="prop_input infoTableInput2" type="text" name="prop_value" value="<?php echo htmlspecialchars($this->_var['prop_value']['prop_value']); ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order prop_input" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['prop_value']['sort_order']; ?>" />
                </td>
            </tr>
            <tr>
              <th class="paddingT15">启用:</th>
              <td class="paddingT15 wordSpacing5"><p>
                <label>
                  <input type="radio" name="status" value="1" <?php if ($this->_var['prop_value']['status']): ?>checked="checked"<?php endif; ?>/>
                  是</label>
                <label>
                  <input type="radio" name="status" value="0" <?php if (! $this->_var['prop_value']['status']): ?>checked="checked"<?php endif; ?>/>
                  否</label>
              </p></td>
            </tr>

          <tr>
            <th></th>
            <td class="ptb20">
                <input class="formbtn" type="submit" name="Submit" value="提交" />
                <input class="formbtn" type="reset" name="reset" value="重置" />            </td>
        </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
