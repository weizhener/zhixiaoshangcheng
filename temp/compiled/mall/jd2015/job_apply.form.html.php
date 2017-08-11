<?php echo $this->fetch('header.html'); ?>





<div id="main" class="w-full">
    <div id="page-job-apply" class="w mb20 pt10 clearfix">
        
        <div class="col-sub">
            <div class="mt">招贤纳士</div>
            <div class="mc">
                <dl>
                    <dt><a href="<?php echo url('app=job'); ?>" title="招贤纳士"><span>招贤纳士</span></a></dt>
                </dl>
                <dl>
                    <dt class="on"><a href="<?php echo url('app=job_apply&act=add'); ?>" title="招贤纳士"><span>在线应聘</span></a></dt>
                </dl>
            </div>
        </div>
        
        <div class="col-main">
            <div class="mt">
                <span>招贤纳士</span>
            </div>
            <div class="mc">
                <form method="post">
                <table>
                    <tr>
                        <th>应聘职位:</th>
                        <td>
                            <select name="job_id" id="job_id">
                                <?php $_from = $this->_var['jobs']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'job');if (count($_from)):
    foreach ($_from AS $this->_var['job']):
?>
                                <option value="<?php echo $this->_var['job']['job_id']; ?>" <?php if ($this->_var['job']['job_id'] == $this->_var['id']): ?> selected="selected"<?php endif; ?>><?php echo $this->_var['job']['position']; ?></option>
                                <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>姓名:</th>
                        <td><input type="text" name="name" id="name" value="" /></td>
                    </tr>
                    <tr>
                        <th>性别:</th>
                        <td>
                            <input name="sex" type="radio" id="sex" value="0" checked="checked">
                            <label>先生</label>
                            <input name="sex" type="radio" id="sex" value="1">
                            <label>女士</label>
                        </td>
                    </tr>
                    <tr>
                        <th>出生年月:</th>
                        <td><input type="text" name="birthday" id="birthday" value="" /></td>
                    </tr>
                    <tr>
                        <th>籍贯:</th>
                        <td><input type="text" name="native_place" id="native_place" value="" /></td>
                    </tr>
                    <tr>
                        <th>联系电话:</th>
                        <td><input type="text" name="telephone" id="telephone" value="" /></td>
                    </tr>
                    <tr>
                        <th>邮编:</th>
                        <td><input type="text" name="zip_code" id="zip_code" value="" /></td>
                    </tr>
                    <tr>
                        <th>E–mail:</th>
                        <td><input type="text" name="email" id="email" value="" /></td>
                    </tr>
                    <tr>
                        <th>学历:</th>
                        <td><input type="text" name="education" id="education" value="" /></td>
                    </tr>
                    <tr>
                        <th>专业:</th>
                        <td><input type="text" name="professional" id="professional" value="" /></td>
                    </tr>
                    <tr>
                        <th>学校:</th>
                        <td><input type="text" name="school" id="school" value="" /></td>
                    </tr>
                    <tr>
                        <th>通讯地址:</th>
                        <td><input type="text" name="address" id="address" value="" /></td>
                    </tr>
                    
                    <tr>
                        <th>所获奖项:</th>
                        <td><textarea name="awards" cols="60" rows="5"></textarea></td>
                    </tr>
                    <tr>
                        <th>工作经历:</th>
                        <td><textarea name="experience" cols="60" rows="5"></textarea></td>
                    </tr>
                    <tr>
                        <th>业余爱好:</th>
                        <td><textarea name="hobbies" cols="60" rows="5"></textarea></td>
                    </tr>
                    <tr>
                        <th></th>
                        <td><input type="submit" value="提交信息" /></td>
                    </tr>
                </table>
                </form>
            </div>
        </div>
        
        
    </div>
</div>








<?php echo $this->fetch('footer.html'); ?>