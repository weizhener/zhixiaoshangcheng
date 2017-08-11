<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p>商品属性</p>
    <ul class="subnav">
        <li><a class="btn1" href="index.php?app=props">属性列表</a></li>
        <?php if ($_GET['act'] == 'add'): ?>
        <li><span>添加属性</span>
        <?php else: ?>
        <li><a class="btn1" href="index.php?app=props&amp;act=add">添加属性</a></li>
        <li><span>编辑属性</span></li>
        <?php endif; ?>
        <li><a class="btn1" href="index.php?app=gcategory">分配属性</a></li>     
    </ul>
</div>
<style>
.prop_input{border:1px #ddd solid; height:22px; line-height:22px;color:#3e3e3e;}
</style>
<div class="info">
    <form method="post">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    属性名:</th>
                <td class="paddingT15 wordSpacing5">
                    <input name="name" value="<?php echo $this->_var['props']['name']; ?>" class="prop_input" />
                </td>
            </tr>
            <?php if ($_GET['act'] == 'add'): ?>
            <tr>
                <th class="paddingT15">
                    属性值:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="prop_input" style="width:300px;" type="text" name="prop_value" value="<?php echo htmlspecialchars($this->_var['props']['prop_value']); ?>" />
                    <label class="gray">多个属性值请用半角逗号（,）隔开</label>
                </td>
            </tr>
            <?php endif; ?>
            <tr>
                <th class="paddingT15">
                    排序:</th>
                <td class="paddingT15 wordSpacing5">
                    <input class="sort_order prop_input" id="sort_order" type="text" name="sort_order" value="<?php echo $this->_var['props']['sort_order']; ?>" />
                </td>
            </tr>
            <tr>
              <th class="paddingT15">启用:</th>
              <td class="paddingT15 wordSpacing5"><p>
                <label>
                  <input type="radio" name="status" value="1" <?php if ($this->_var['props']['status']): ?>  checked="checked" <?php endif; ?>/>
                  是</label>
                <label>
                  <input type="radio" name="status" value="0" <?php if (! $this->_var['props']['status']): ?> checked="checked"<?php endif; ?>/>
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
