<script type="text/javascript">
var __widgets = <?php echo $this->_var['widgets']; ?>;
$(function(){
    for (k in __widgets)
    {
        //<div class="add_widget_note">点击添加该挂件到页面</div>
        var _widget = $('<li widget_name="'+__widgets[k]['name']+'" title="点击添加该挂件到页面"><div>' + __widgets[k]['display_name'] + '</div></li>').css('cursor', 'pointer').click(add_widget);
        $('#widget_list_ul').append(_widget);
    }
    $('#widget_save_button').click(save_page);
    $('#handle_hide').click(toggle_panel);
});
</script>
<div class="handle" id="template_panel">
    <div class="handle_top">
        <ul>
            <li><a href="javascript:;" class="handle_hover"><span>挂件列表</span></a></li>
        </ul>
        <a href="javascript:;" id="handle_hide" status="open" class="handle_hide">隐藏</a>
    </div>

    <div class="handle_bot">
        <div class="handle_con">
            <div class="handle_con_box">
                <div class="widget_list">
                    <ul id="widget_list_ul"></ul>
                    <div class="clear"></div>
                </div>
                <div class="handle_btn">
                    <a href="javascript:;" id="widget_save_button" class="handle_btn1">保存修改</a>
                    <a href="javascript:window.close();" class="handle_btn2">退出编辑</a>
                    <a href="<?php echo $this->_var['site_url']; ?>" target="_blank" class="handle_btn2">商城首页</a>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <div class="handle_line"></div>
</div>
<form id="_edit_page_form_" style="display:none"></form>