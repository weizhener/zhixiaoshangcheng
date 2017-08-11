<?php echo $this->fetch('header.html'); ?>
<style>

</style>
<script type="text/javascript">
//<!CDATA[
$(function()
{
    change_background();
});

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

function flex(obj)
{
    var status = obj.attr('status');
    var id = obj.attr('fieldid');
    var pid = obj.parent('td').parent('tr').attr("class");
    var src = $(obj).attr('src');
    if(status == 'open')
    {
        var pr = $(obj).parent('td').parent('tr');
        var selfurl = window.location.href;
        var sr  = pr.clone();
        var td2 = sr.find("td:eq(1)");
        td2.prepend("<img class='preimg' src='templates/style/images/treetable/vertline.gif'/>")
                        .find("img[ectype=flex]")
                        .remove()
                        .end()
                        .find('span')
                        .remove();
        var img_count = td2.children("img").length;
        var td2html = td2.html();
         $.get(selfurl + "&act=ajax_cate", {id: id}, function(data){
             if(data)
             {
                 var str = '';
                 var add_child = '';
                 var res = eval('(' + data + ')');
                 for(var i = 0; i < res.length; i++)
                 {
                     if(res[i].switchs)
                     {
                         src =  "<img src='templates/style/images/treetable/tv-expandable.gif' ectype='flex' status='open' fieldid="+res[i].region_id+
                           " onclick='flex($(this))'><span class='node_name'>" + res[i].region_name + "</span>";
                     }
                     else
                     {
                         src = "<img src='templates/style/images/treetable/tv-item.gif'><span class='node_name'>" + res[i].region_name + "</span>";
                     }
                     if(img_count < (<?php echo $this->_var['max_layer']; ?> -1))
                     {
                         add_child = "<a href='index.php?app=region&amp;act=add&amp;pid="+res[i].region_id+"'>新增下级</a>";
                     }
                     var itd2 = td2html + src;
                     str+="<tr class='"+pid+" row"+id+"'><td class='align_center w30'><input type='checkbox' class='checkitem' value='" + res[i].region_id + "'></td>"+
                        "<td class='node' width='50%'>" + itd2 + "</td>"+
                        "<td class='align_center'><span ectype='inline_edit' fieldname='sort_order' fieldid='" + res[i].region_id + "' datatype='pint' maxvalue='255' title='单击可以编辑' class='editable'>" + res[i].sort_order + "</span></td>"+
                        "<td class='handler'><span><a href='index.php?app=region&act=edit&id=" + res[i].region_id + "'>编辑</a> | <a href='javascript:if(confirm(\""+lang.confirm_delete+"\"))window.location=\"index.php?app=region&act=drop&id=" + res[i].region_id + "\";'>删除</a> | " + add_child + "</span></td>";
                 }
                pr.after(str);
                change_background();
                $('span[ectype="inline_edit"]').unbind('click');
                $.getScript(SITE_URL+"/includes/libraries/javascript/inline_edit.js");
             }
         });
         obj.attr('src',src.replace("tv-expandable","tv-collapsable"));
         obj.attr('status','close');
    }
    if(status == 'close')
    {
        $('.row' + id).hide();
        obj.attr('src',src.replace("tv-collapsable","tv-expandable"));
        obj.attr('status','open');
    }
}
var uri = "index.php?app=region&act=update_order";

function updateOrder(obj){
    var arr = new Array();
    $(".checkitem:checked").each(function(){
        arr.push($(this).parents("tr").find(":text").val());
    });
    $(obj).attr("uri", uri + "&sort_order=" + arr.join(','));
    return true;
}
//]]>
</script>

<div id="rightTop">
    <p>地区设置</p>
    <ul class="subnav">
        <li><span>管理</span></li>
        <li><a class="btn1" href="index.php?app=region&amp;act=add">新增</a></li>
        <li><a class="btn1" href="index.php?app=region&amp;act=export">导出</a></li>
        <li><a class="btn1" href="index.php?app=region&amp;act=import">导入</a></li>
    </ul>
</div>

<div class="info2">
    <table class="distinction">
        <?php if ($this->_var['regions']): ?>
        <thead>
        <tr>
            <th class="w30"><input id="checkall_1" type="checkbox" class="checkall"/></th>
            <th width="50%"><span class="all_checkbox"><label for="checkall_1">全选</label></span>地区名称</th>
            <th>排序</th>
            <th class="handler">操作</th>
        </tr>
        </thead>
        <tbody id="treet1"><?php endif; ?>
        <?php $_from = $this->_var['regions']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'region');if (count($_from)):
    foreach ($_from AS $this->_var['region']):
?>
        <tr class="">
            <td class="align_center w30"><input type="checkbox" class="checkitem" value="<?php echo $this->_var['region']['region_id']; ?>" /></td>
            <td class="node" width="50%">
            <?php if ($this->_var['region']['switchs']): ?>
            <img src="templates/style/images/treetable/tv-expandable.gif" ectype="flex" status="open" fieldid="<?php echo $this->_var['region']['region_id']; ?>" onclick="flex($(this))">
            <?php else: ?>
            <img src="templates/style/images/treetable/tv-item.gif">
            <?php endif; ?>
            <span class="node_name"><?php echo htmlspecialchars($this->_var['region']['region_name']); ?></span></td>
            <td class="align_center"><span ectype="inline_edit" fieldname="sort_order" fieldid="<?php echo $this->_var['region']['region_id']; ?>" datatype="pint" maxvalue="255" title="单击可以编辑" class="editable"><?php echo $this->_var['region']['sort_order']; ?></span></td>
            <td class="handler">
            <span>
            <a href="index.php?app=region&amp;act=edit&amp;id=<?php echo $this->_var['region']['region_id']; ?>">编辑</a>
                |
                <a href="javascript:if(confirm('删除该地区将会同时删除该地区的所有下级地区，您确定要删除吗'))window.location = 'index.php?app=region&amp;act=drop&amp;id=<?php echo $this->_var['region']['region_id']; ?>';">删除</a><?php if ($this->_var['region']['layer'] < $this->_var['max_layer']): ?> | <a href="index.php?app=region&amp;act=add&amp;pid=<?php echo $this->_var['region']['region_id']; ?>">新增下级</a><?php endif; ?>
                </span>
                </td>
        </tr>
        <?php endforeach; else: ?>
        <tr class="no_data">
            <td colspan="4">您还没添加地区</td>
        </tr>
        <?php endif; unset($_from); ?><?php $this->pop_vars();; ?>
        <?php if ($this->_var['regions']): ?></tbody><?php endif; ?>
        <tfoot>
            <tr class="tr_pt10">
            <?php if ($this->_var['regions']): ?>
                <td class="align_center"><label for="checkall1"><input id="checkall_2" type="checkbox" class="checkall"></label></td>
                <td colspan="3" id="batchAction">
                    <span class="all_checkbox"><label for="checkall_2">全选</label></span>&nbsp;&nbsp;
                    <input class="formbtn batchButton" type="button" value="删除" name="id" uri="index.php?app=region&act=drop" presubmit="confirm('删除该地区将会同时删除该地区的所有下级地区，您确定要删除吗');" />
                </td>
            <?php endif; ?>
            </tr>
        </tfoot>
    </table>


</div>

<?php echo $this->fetch('footer.html'); ?>