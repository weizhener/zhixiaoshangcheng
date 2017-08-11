<?php echo $this->fetch('header.html'); ?>
<script type="text/javascript">
$(function(){
    $('#notice_form').validate({
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error); 
        },
        success       : function(label){
            label.addClass('right').text('OK!');
        },
        rules : { 
            user_name : {
                required : check_user_name  
            },   
            amount    :{
                number     : true
            }
        },
        messages : {
            user_name :{
                required     : '指定会员发送，会员名不能为空且一行一个会员名'
            },
            amount    :{
                number     : '批量发送数量仅能为数字'
            }
        }
    });
    function check_user_name()
    {
        var rs = $(":input[name='send_type']:checked").val();
        
        return rs == 1 ? true : false; 
    }
    $("input[name='send_type']").click(function(){
        var rs = $(this).val();
        switch(rs)
        {
            case '1':
                $('#user_list').show();
                $('#sgrade_list').hide();
                break;
            case '2':
                $('#user_list').hide();
                $('#sgrade_list').hide();
                break;
            case '3':
                $('#sgrade_list').show();
                $('#user_list').hide();
                break;
            case '4':
                $('#user_list').hide();
                $('#sgrade_list').hide();
                break;
        }
    });
    $("input[name='send_mode']").click(function(){
        var rs = $(this).val();
        switch(rs)
        {
            case '1':
                $('#msg').show();
                $('#email').hide();
                $('#title').hide();
                break;
            case '2':
                $('#msg').hide();
                $('#email').show();
                $('#title').show();
                break;
        }
    });
    
    $('#msg_instrunction').toggle(function(){
        $(this).next('div').fadeIn("slow")
    },function(){
        $(this).next('div').fadeOut("slow");
    });
});

</script>
<style type="text/css">
#short_msg_desc {margin-top:10px;}
#short_msg_desc a {color:#0099CC;}
#short_msg_desc div {display:none;color:#646665;border:1px solid #CCCCCC;padding:5px;width:340px;background-color:#F5F5F5;line-height:25px;}
</style>
<?php echo $this->_var['build_editor']; ?>
<div id="rightTop">
  <p>会员通知</p>
  <ul class="subnav">
    <li><span>发送通知</span></li>
  </ul>
</div>
<div class="info">
<form method="POST" id="notice_form">
<input type="hidden" name="type" value="<?php echo $_GET['type']; ?>">
<table class="infoTable">

    <tr>
        <th class="paddingT15">发送类型:</td>
        <td class="paddingT15 wordSpacing5">
            <?php echo $this->html_radios(array('options'=>$this->_var['send_type'],'name'=>'send_type','checked'=>'1')); ?>
        </td>
    </tr>
    <tr id="user_list">
        <th class="paddingT15"> 会员列表:</th>
        <td class="paddingT15 wordSpacing5"><textarea name="user_name" style="height:100px;" id="user_name"></textarea><span class="field_notice">每行填写一个会员名<span></td>
    </tr>
    <tr id="sgrade_list" style="display:none;">
        <th class="paddingT15"> 会员列表:</th>
        <td class="paddingT15 wordSpacing5">
        <select name="sgrade[]" multiple="multiple">
            <?php echo $this->html_options(array('options'=>$this->_var['sgrades'])); ?>
        </select>
        </td>
    </tr>
    <tr>
        <th class="paddingT15">分批发送数量:</td>
        <td class="paddingT15 wordSpacing5"><input type="text" name="amount" value="20"><span class="field_notice">一次发送过多，程序可能会因为超时而终止执行。此处建议不要超过100。</span></td>
    </tr>
    <tr>
        <th class="paddingT15">发送方式:</td>
        <td class="paddingT15 wordSpacing5"><?php echo $this->html_radios(array('options'=>$this->_var['send_mode'],'name'=>'send_mode','checked'=>'1')); ?></td>
    </tr>
    <tr id="title" style="display:none;">
        <th class="paddingT15">通知标题:</td>
        <td class="paddingT15 wordSpacing5"><input type="text" name="title"></td>
    </tr>
    <tr id="email"  style="display:none;">
        <th class="paddingT15">通知内容:</td>
        <td class="paddingT15 wordSpacing5"><textarea name="content" style="width:400px; height:300px;"></textarea></td>
    </tr>
    <tr id="msg">
        <th class="paddingT15">通知内容:</td>
        <td class="paddingT15 wordSpacing5"><textarea name="content1" style="width:400px; height:300px;"></textarea>
            <div id="short_msg_desc"><a href="javascript:;" id="msg_instrunction">短消息使用格式?</a>
                <div>图片标签：[img]http://www.baidu.com/img/bdlogo.png[/img]<br/>超链接标签：[url=http://www.baidu.com]官方网站[/url]</div>
            <div>
        </td>
    </tr>
    <tr>
        <th class="paddingT15"> </th>
        <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
          <input class="formbtn" type="reset" name="Submit2" value="重置" /></td>
    </tr>
</table>
</form>
</div>
<?php echo $this->fetch('footer.html'); ?>