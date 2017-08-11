var selfurl = window.location.href;
function change_background()
{
    $("tbody tr").hover(
    function()
    {
        $(this).css({background:"#EAF8DB"});
    },
    function()
    {
        $(this).css({background:"#fff"});
    });
}
$(function()
{
    change_background();
    var selfurl = window.location.href;
    //给图标的加减号添加展开收缩行为
    $('img[ectype="flex"]').click(function(){
        var status = $(this).attr("status");
        var pid = $(this).attr("fieldid");
        //状态是加号的事件
        if(status == 'open')
        {
            var src = $(this).attr('src');
            var pr = $(this).parent('td').parent('tr');
            
            $.get(selfurl + "&act=ajax_prop_value", {pid: pid}, function(data){
                if(data)
                {
                    var str = "";
                    var res = eval('('+data+')');
                    for(var i = 0; i < res.length; i++)
                    {
                        var src = "";
                        var status = "";
                        src =  "<img src='templates/style/images/treetable/tv-item.gif' fieldid='"+res[i].vid+"'>";
                        
                        //给每一个取出的数据添加是否显示标志
                        if(res[i].status == '1')
                        {
                            status = "<img src='templates/style/images/positive_enabled.gif'/>";
                        }
                        else
                        {
                            status = "<img src='templates/style/images/positive_disabled.gif'/>";
                        }
                        //构造每一个tr组成的字符串，标语添加
                        str+="<tr class='row"+pid+"'><td class='align_center w30'><input name='vid[]' type='checkbox' class='checkitem' value='"+res[i].vid+"' /></td>"+
                        "<td class='node' width='50%'><img class='preimg' src='templates/style/images/treetable/vertline.gif'/>"+src+"<span>"+res[i].prop_value+"</span></td>"+
            "<td class='align_center'><span>"+res[i].sort_order+"</span></td>"+
            "<td class='align_center'>"+status+"</td>"+
            "<td><span><a href='index.php?app=props&amp;act=edit_value&amp;pid="+res[i].pid+"&amp;vid="+res[i].vid+"'>"+lang.edit+"</a>  | <a href='javascript:if(confirm(\"你确定要删除该属性值么？\"))window.location=\"index.php?app=props&act=drop_value&vid="+res[i].vid+"\";'>"+lang.drop+"</a></span></td></tr>";
                    }
                    //将组成的字符串添加到点击对象后面
                    pr.after(str);
                    change_background();
                    //解除行间编辑的绑定事件
                    $('span[ectype="inline_edit"]').unbind('click');
                    //重现初始化页面
                    $.getScript(SITE_URL+"/includes/libraries/javascript/inline_edit.js");
                }
            });
            $(this).attr('src',src.replace("tv-expandable","tv-collapsable"));
            $(this).attr('status','close');
        }
        //状态是减号的事件
        if(status == "close")
        {
            var src = $(this).attr('src');
            $('.row'+pid).hide();
            $(this).attr('src',src.replace("tv-collapsable","tv-expandable"));
            $(this).attr('status','open');
        }
    });
});