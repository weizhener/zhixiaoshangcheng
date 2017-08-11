<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
$(function(){
    $('a[ectype="to_user_name"]').click(function (){
        var str = $('input[name="to_user_name"]').val();
        var id = $(this).attr('id');
        if(str.indexOf(id) < 0){
            doFriend(id, 'add');
        }else{
            doFriend(id, 'delete');
        }
    });
}
);
$(function(){
  $('#send_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
            $(element).attr('name')=='msg_content' && $(element).after().css({display:'block'});
        },
        success       : function(label){
            label.addClass('validate_right').text('OK!');
        },
        rules : {
            to_user_name : {
                required   : true
            },
            msg_content : {
                required   : true
            }
        },
        messages : {
            to_user_name : {
                required : '收件人不能为空。'
            },
            msg_content : {
                required   : '短消息的内容不能为空。'
            }
        }
    });
});
function doFriend(user_name, action){
    var input_name = $("input[name='to_user_name']").val();
    var key, i = 0;
    var exist = false;
    var arrOld = new Array();
    var arrNew = new Array();
    input_name = input_name.replace(/\uff0c/g,',');
    arrOld     = input_name.split(',');
    for(key in arrOld){
        arrOld[key] = $.trim(arrOld[key]);
        if(arrOld[key].length > 0){
            arrOld[key] == user_name &&  action == 'delete' ? null : arrNew[i++] = arrOld[key];
            arrOld[key] == user_name ? exist = true : null;
        }
    }
    if(!exist && action == 'add'){
        arrNew[i] = user_name;
    }
    $("input[name='to_user_name']").val(arrNew);
}
</script>
<div class="content">
    <div class="totline"></div><div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
          <div class="wrap">
            <div class="eject_wrap_msg">
                <div class="fill_in">
                    <div class="eject_con">
                        <div class="msg">
                            <form method="post" enctype="multipart/form-data" id="send_form" action="index.php?app=message&act=send">
                            <ul>
                                <li>
                                    <h3>收件人: </h3>
                                    <p><input type="text" class="text width_normal" name="to_user_name" value="<?php echo htmlspecialchars($_GET['to_user_name']); ?>"/><span class="field_notice">多个收件人请用逗号分隔开</span></p>
                                </li>
                                <li>
                                    <h3>内容: </h3>
                                    <p><textarea class="text width_long" name="msg_content" /></textarea></p>
                                    <div class="clear"></div>
                                    <div id="short_msg_desc"><a href="javascript:;" id="msg_instrunction">短消息使用格式?</a>
                                        <div>图片标签：[img]http://www.baidu.com/img/bdlogo.png[/img]<br/>超链接标签：[url=http://www.baidu.com]官方网站[/url]</div>
                                    <div>
                                </li>
                            </ul>
                            <div class="submit"><input type="submit" class="btn" value="确认发送" /></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="friend">
                    <h2>好友(<?php echo $this->_var['friend_num']; ?>)</h2>
                    <ul>
                    <?php $_from = $this->_var['friends']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'friend');if (count($_from)):
    foreach ($_from AS $this->_var['friend']):
?>
                        <li><a href="javascript:void(0);" id="<?php echo htmlspecialchars($this->_var['friend']['user_name']); ?>" ectype="to_user_name"><?php echo htmlspecialchars($this->_var['friend']['user_name']); ?></a></li>
                    <?php endforeach; else: ?>
                        <li class="member_no_record">您没有好友</li>
                    <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
                    </ul>
                </div>
            </div>
          </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
