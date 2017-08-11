<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.plugins/jquery.validate.js'; ?>" charset="utf-8"></script>
<script type="text/javascript">
$(function(){
    $('#message').validate({
        errorPlacement: function(error, element){
            var _message_box = $(element).parent().find('.field_message');
            _message_box.find('.field_notice').hide();
            _message_box.parent().append(error);
        },
        rules : {
            content : {
                required : true,
                byteRange : [0,255,'<?php echo $this->_var['charset']; ?>']
            }
        },
        messages : {
            content : {
                required : '内容不能为空',
                byteRange: '您最多可输入255个字符'
            }
        }
    });
})
</script>

<div class="message">
    <?php $_from = $this->_var['qa_info']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'qainfo');if (count($_from)):
    foreach ($_from AS $this->_var['qainfo']):
?>
    <div class="<?php echo $this->cycle(array('values'=>'message_text2,message_text2 bg1')); ?>">
        <dl class="leave_word">
            <dt>咨询内容: </dt>
            <dd><?php echo nl2br(htmlspecialchars($this->_var['qainfo']['question_content'])); ?></dd>
            <p>
                <span class="name"><?php if ($this->_var['qainfo']['user_name']): ?><?php echo $this->_var['qainfo']['user_name']; ?><?php else: ?>游客<?php endif; ?>
                </span>
            </p>
            <dd>
                <p><?php echo local_date("Y-m-d H:i:s",$this->_var['qainfo']['time_post']); ?></p>
            </dd>
        </dl>
        <?php if ($this->_var['qainfo']['reply_content']): ?>
        <dl class="revert_to">
            <dt>店主回复: </dt>
            <dd><?php echo nl2br(htmlspecialchars($this->_var['qainfo']['reply_content'])); ?></dd>
            <p>
                <span class="date"><?php echo local_date("Y-m-d H:i:s",$this->_var['qainfo']['time_reply']); ?></span>
            </p>
        </dl>
        <?php endif; ?>
    </div>
    <?php endforeach; else: ?>
    <div class="<?php echo $this->cycle(array('values'=>'message_text2,message_text2 bg1')); ?>">
        <span class="light">没有符合条件的记录</span>
    </div>
    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
</div>
<?php if ($this->_var['qa_info']): ?><?php echo $this->fetch('page.bottom.html'); ?><?php endif; ?>
<div class="clear"></div>
<?php if ($_GET['app'] == 'groupbuy' && $this->_var['group']['ican']['ask'] || $_GET['app'] == 'goods'): ?>
<div class="fill_in">
    <form method="post" id="message" action="index.php?app=<?php echo $_GET['app']; ?><?php if ($_GET['act']): ?>&amp;act=<?php echo $_GET['act']; ?><?php elseif ($_GET['app'] == 'goods'): ?>&amp;act=qa<?php endif; ?>&amp;id=<?php echo $_GET['id']; ?>">
    <p> <span class="desc">我要咨询: </span><textarea name="content"></textarea><span class="field_message"><span class="field_notice"></span></span></p>
    <p>
        <?php if (! $this->_var['guest_comment_enable'] && ! $this->_var['visitor']['user_id']): ?>
            您需要先&nbsp;[<a href="index.php?app=member&act=login">登录</a>]&nbsp;后才可以发布咨询
        <?php else: ?>
        <span>电子信箱: </span>
        <span><input type="text" class="text" name="email" value="<?php echo $this->_var['email']; ?>" /></span>
        <?php if ($this->_var['captcha']): ?>
        <span>验证码: </span>
        <span><input type="text" class="text" name="captcha" /></span>
        <span><a href="javascript:change_captcha($('#captcha'));"><img id="captcha" class="captcha" src="index.php?app=captcha&amp;<?php echo $this->_var['random_number']; ?>" /></a></span>
        <?php endif; ?>
        <?php if ($_SESSION['user_info']): ?>
        <span><label><input type="checkbox" name="hide_name" value="hide" /> 匿名发表</label></span>
        <?php endif; ?>
        <input type="submit" value="发布咨询" name="qa" />
        <!--<input type="hidden" value="<?php echo $_GET['id']; ?>" name="goods_id" />
        <input type="hidden" value="ask" name="type" />-->
        <?php endif; ?>
    </p>
    </form>
</div>
<?php endif; ?>
