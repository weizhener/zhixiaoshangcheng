<?php echo $this->fetch('header.html'); ?>
<div id="rightTop">
    <p><strong>启用</strong></p>
</div>

<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15">
                    <label for="module_name">名称:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->_var['module']['name']; ?><input type="hidden" name="name" value="<?php echo $this->_var['module']['name']; ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="module_desc">描述:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->_var['module']['desc']; ?><input type="hidden" name="desc" value="<?php echo $this->_var['module']['desc']; ?>" />
                </td>
            </tr>
            <tr>
                <th class="paddingT15">
                    <label for="module_desc">版本:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->_var['module']['version']; ?><input type="hidden" name="version" value="<?php echo $this->_var['module']['version']; ?>" />
                </td>
            </tr>
            <?php $_from = $this->_var['module']['config']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('conf', 'info');if (count($_from)):
    foreach ($_from AS $this->_var['conf'] => $this->_var['info']):
?>
            <tr>
                <th class="paddingT15">
                    <label for="module_<?php echo $this->_var['conf']; ?>"><?php echo $this->_var['info']['text']; ?>:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php if ($this->_var['info']['type'] == 'text'): ?>
                        <input type="text" name="config[<?php echo $this->_var['conf']; ?>]" value="<?php echo $this->_var['config'][$this->_var['conf']]; ?>" size="<?php echo $this->_var['info']['size']; ?>" />
                    <?php elseif ($this->_var['info']['type'] == 'select'): ?>
                        <select name="config[<?php echo $this->_var['conf']; ?>]">
                        <?php echo $this->html_options(array('options'=>$this->_var['info']['items'],'selected'=>$this->_var['config'][$this->_var['conf']])); ?>
                        </select>
                    <?php elseif ($this->_var['info']['type'] == 'textarea'): ?>
                        <textarea cols="<?php echo $this->_var['info']['cols']; ?>" rows="<?php echo $this->_var['info']['rows']; ?>" name="config[<?php echo $this->_var['conf']; ?>]"><?php echo $this->_var['config'][$this->_var['conf']]; ?></textarea>
                    <?php elseif ($this->_var['info']['type'] == 'radio'): ?>
                        <?php echo $this->html_radios(array('options'=>$this->_var['info']['items'],'checked'=>$this->_var['config'][$this->_var['conf']],'name'=>$this->_var['info']['name'])); ?>
                    <?php elseif ($this->_var['info']['type'] == 'checkbox'): ?>
                        <?php echo $this->html_checkbox(array('options'=>$this->_var['info']['items'],'checked'=>$this->_var['config'][$this->_var['conf']],'name'=>$this->_var['info']['name'])); ?>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
            <tr>
                <th class="paddingT15">
                    <label for="module_desc">启用:</label></th>
                <td class="paddingT15 wordSpacing5">
                    <?php echo $this->html_radios(array('options'=>$this->_var['enable_options'],'checked'=>$this->_var['config']['enabled'],'name'=>'enabled')); ?>
                </td>
            </tr>
            <tr>
                <th></th>
                <td class="ptb20">
                    <input class="formbtn" type="submit" name="Submit" value="提交" />
                    <input class="formbtn" type="button" onclick="window.history.go(-1)" value="返回" />
                </td>
            </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>
