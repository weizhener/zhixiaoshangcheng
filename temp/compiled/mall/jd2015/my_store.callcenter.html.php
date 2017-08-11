<?php echo $this->fetch('member.header.html'); ?>
<link href="<?php echo $this->res_base . "/" . 'css/callcenter.css'; ?>" rel="stylesheet" type="text/css" />
<script>
    $(function() {
        $('#callcenter_form').find('a[nctype="del"]').live('click', function() {
            $(this).parents('div:first').remove();
        });
    });
    function add_service(param) {
        if (param == 'pre') {
            var text = '售前';
        } else if (param == 'after') {
            var text = '售后';
        }
        obj = $('dl[nctype="' + param + '"]').children('dd').find('p');
        len = $('dl[nctype="' + param + '"]').children('dd').find('div').length;
        key = 'k' + len + Math.floor(Math.random() * 100);
        $('<div class="ncs-message-list"></div>').append('<span class="name tip" title="使用默认值或修改您自己的客服名称"><input type="text" class="text w60" value="' + text + len + '" name="' + param + '[' + key + '][name]" /></span>')
                .append('<span class="tool tip" title="请选择即时通讯工具类型"><select name="' + param + '[' + key + '][type]"><option class="" value="0">-请选择-</option><option value="1">QQ</option><option value="2">旺旺</option></select></span>')
                .append('<span class="number tip" title="根据您所选择的即时通讯工具类型输入正确的用户账号"><input class="text w180" type="text" name="' + param + '[' + key + '][num]" /></span>')
                .append('<span class="del"><a nctype="del" href="javascript:void(0);" class="ncu-btn2">删除</a></span>')
                .insertBefore(obj);
    }
</script>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class='callcenter'>
                <div class="ncu-form-style">
                    <div class="ncm-notes">
                        <h3>说明：</h3>
                        <ul>
                            <li>客服信息需要填写完整，不完整信息将不会被保存。</li>
                        </ul>
                    </div>
                    <form method="post"  id="callcenter_form"  class="ncs-message">
                        <dl nctype="pre" class="pb20">
                            <dt>售前客服：</dt>
                            <dd>
                                <div class="ncs-message-title"><span class="name">客服名称</span><span class="tool">客服工具</span><span class="number">客服账号</span></div>
                                <?php $_from = $this->_var['store']['pre_connects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'pre_connect');$this->_foreach['fe_pre_connect'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_pre_connect']['total'] > 0):
    foreach ($_from AS $this->_var['pre_connect']):
        $this->_foreach['fe_pre_connect']['iteration']++;
?>
                                <div class="ncs-message-list">
                                    <span class="name tip" title="使用默认值或修改您自己的客服名称">
                                        <input type="text" class="text w60" value="<?php echo htmlspecialchars($this->_var['pre_connect']['name']); ?>" name="pre[<?php echo $this->_foreach['fe_pre_connect']['iteration']; ?>][name]" maxlength="10">
                                    </span><span class="tool tip" title="请选择即时通讯工具类型">
                                        <select name="pre[<?php echo $this->_foreach['fe_pre_connect']['iteration']; ?>][type]">
                                            <option value="0">-请选择-</option>
                                            <option value="1" <?php if ($this->_var['pre_connect']['type'] == '1'): ?>selected<?php endif; ?>>QQ</option>
                                            <option value="2" <?php if ($this->_var['pre_connect']['type'] == '2'): ?>selected<?php endif; ?>>旺旺</option>
                                        </select>
                                    </span><span class="number tip" title="根据您所选择的即时通讯工具类型输入正确的用户账号">
                                        <input name="pre[<?php echo $this->_foreach['fe_pre_connect']['iteration']; ?>][num]" type="text" class="text w180" maxlength="25" value="<?php echo htmlspecialchars($this->_var['pre_connect']['num']); ?>">
                                    </span><span class="del"><a nctype="del" href="javascript:void(0);" class="ncu-btn2">删除</a></span>
                                </div>
                                <?php endforeach; else: ?>
                                <div class="ncs-message-list">
                                    <span class="name tip" title="使用默认值或修改您自己的客服名称">
                                        <input type="text" class="text w60" value="售前1" name="pre[1][name]" maxlength="10">
                                    </span><span class="tool tip" title="请选择即时通讯工具类型">
                                        <select name="pre[1][type]">
                                            <option value="0">-请选择-</option>
                                            <option value="1">QQ</option>
                                            <option value="2">旺旺</option>
                                        </select>
                                    </span><span class="number tip" title="根据您所选择的即时通讯工具类型输入正确的用户账号">
                                        <input name="pre[1][num]" type="text" class="text w180" maxlength="25">
                                    </span><span class="del"><a nctype="del" href="javascript:void(0);" class="ncu-btn2">删除</a></span>
                                </div>
                                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                
                                
                                <p><span><a href="javascript:void(0);" onclick="add_service('pre');" class="ncu-btn6 mt10">添加客服</a></span></p>
                            </dd>
                        </dl>
                        <dl nctype="after" class="mt20 pb20">
                            <dt>售后客服：</dt>
                            <dd>
                                <div class="ncs-message-title"><span class="name">客服名称</span><span class="tool">客服工具</span><span class="number">客服账号</span></div>
                                
                                <?php $_from = $this->_var['store']['after_connects']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'after_connect');$this->_foreach['fe_after_connect'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_after_connect']['total'] > 0):
    foreach ($_from AS $this->_var['after_connect']):
        $this->_foreach['fe_after_connect']['iteration']++;
?>
                                <div class="ncs-message-list">
                                    <span class="name tip" title="使用默认值或修改您自己的客服名称">
                                        <input type="text" class="text w60" value="<?php echo htmlspecialchars($this->_var['after_connect']['name']); ?>" name="after[<?php echo $this->_foreach['fe_after_connect']['iteration']; ?>][name]" maxlength="10">
                                    </span><span class="tool tip" title="请选择即时通讯工具类型">
                                        <select name="after[<?php echo $this->_foreach['fe_after_connect']['iteration']; ?>][type]">
                                            <option value="0">-请选择-</option>
                                            <option value="1" <?php if ($this->_var['after_connect']['type'] == '1'): ?>selected<?php endif; ?>>QQ</option>
                                            <option value="2" <?php if ($this->_var['after_connect']['type'] == '2'): ?>selected<?php endif; ?>>旺旺</option>
                                        </select>
                                    </span><span class="number tip" title="根据您所选择的即时通讯工具类型输入正确的用户账号">
                                        <input type="text" class="text w180" name="after[<?php echo $this->_foreach['fe_after_connect']['iteration']; ?>][num]" maxlength="25" value='<?php echo htmlspecialchars($this->_var['after_connect']['num']); ?>'>
                                    </span><span><a nctype="del" href="javascript:void(0);" class="ncu-btn2">删除</a></span> 
                                </div>
                                <?php endforeach; else: ?>
                                <div class="ncs-message-list">
                                    <span class="name tip" title="使用默认值或修改您自己的客服名称">
                                        <input type="text" class="text w60" value="售后1" name="after[1][name]" maxlength="10">
                                    </span><span class="tool tip" title="请选择即时通讯工具类型">
                                        <select name="after[1][type]">
                                            <option value="0">-请选择-</option>
                                            <option value="1">QQ</option>
                                            <option value="2">旺旺</option>
                                        </select>
                                    </span><span class="number tip" title="根据您所选择的即时通讯工具类型输入正确的用户账号">
                                        <input type="text" class="text w180" name="after[1][num]" maxlength="25">
                                    </span><span><a nctype="del" href="javascript:void(0);" class="ncu-btn2">删除</a></span> 
                                </div>
                                <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                
                                <p><span><a href="javascript:void(0);" onclick="add_service('after');" class="ncu-btn6 mt10">添加客服</a></span></p>
                            </dd>
                        </dl>
                        <dl class="bottom">
                            <dt>&nbsp;</dt>
                            <dd>
                                <input type="submit" class="submit" value="提交">
                            </dd>
                        </dl>
                    </form>
                </div>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
