<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public">
                <div class="message message_line">
                    <?php if ($this->_var['box'] != 'announcepm'): ?>
                    <h2>
                        <span>&nbsp;</span>
                        <a class="delete" href="javascript:drop_confirm('您确定要删除它吗？', 'index.php?app=message&amp;act=drop_relate&amp;back=<?php echo $this->_var['box']; ?>&amp;msg_id=<?php echo $this->_var['message']['msg_id']; ?>');">删除</a>    
                    </h2>
                    <?php else: ?>
                    <h2 class="message_line"></h2>
                    <?php endif; ?>
                    <div class="message_con">
                        <div class="user">
                            <p><img src="<?php echo $this->_var['message']['portrait']; ?>" width="50" height="50" alt="" /></p>
                            <h3><span><?php echo htmlspecialchars($this->_var['message']['user_name']); ?></span><br /><?php echo local_date("Y-m-d H:i",$this->_var['message']['add_time']); ?></h3>
                        </div>
                        <div class="txt"><?php echo call_user_func("short_msg_filter",$this->_var['message']['content']); ?></div>
                    </div>
                    <?php if ($this->_var['box'] == 'privatepm'): ?>
                    <?php $_from = $this->_var['replies']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'reply');if (count($_from)):
    foreach ($_from AS $this->_var['reply']):
?>
                    <div class="message_con">
                        <div class="user">
                            <p><img src="<?php echo $this->_var['reply']['portrait']; ?>" width="50" height="50" alt="" /></p>
                            <h3><span><?php echo htmlspecialchars($this->_var['reply']['user_name']); ?></span><br /><?php echo local_date("Y-m-d H:i",$this->_var['reply']['add_time']); ?></h3>
                        </div>
                        <div class="txt"><?php echo call_user_func("short_msg_filter",$this->_var['reply']['content']); ?></div>
                    </div>
                    <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    <?php endif; ?>
                </div>
                <?php if ($this->_var['box'] == 'privatepm'): ?>
                <div class="message">
                    <h2><span><strong>回复</strong></span></h2>
                    <dl>
                        <form method="post" enctype="multipart/form-date">
                        <dt>内容: </dt>
                        <dd>
                            <p><textarea class="text" name="msg_content"></textarea></p>
                            <div id="short_msg_desc" style="margin-left:0px; margin-bottom:10px;"><a href="javascript:;" id="msg_instrunction">短消息使用格式?</a>
                                <div>图片标签：[img]http://www.baidu.com/img/bdlogo.png[/img]<br/>超链接标签：[url=http://www.baidu.com]官方网站[/url]</div>
                            </div>
                            <p><input type="submit" class="btn" value="提交" /></p>
                        </dd>
                        </form>
                    </dl>
               </div>
              <?php endif; ?>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
