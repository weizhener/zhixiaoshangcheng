/* 多级选择相关函数，如地区选择，分类选择
 * multi-level selection
 */

/* 地区选择函数 */
function regionInit(divId)
{
    $("#" + divId + " > select").change(regionChange); // select的onchange事件
    $("#" + divId + " > input:button[class='edit_region']").click(regionEdit); // 编辑按钮的onclick事件
}

function regionChange()
{
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++)
    {
        sel = selects[i];
        if (sel.value > 0)
        {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));

    // ajax请求下级地区
    if (this.value > 0)
    {
        var _self = this;
        var url = REAL_SITE_URL + '/index.php?app=mlselection&type=region';
        $.getJSON(url, {'pid': this.value}, function(data) {
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(regionChange).insertAfter(_self);
                    var data = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].region_id + "'>" + data[i].region_name + "</option>");
                    }
                }
            }
            else
            {
                alert(data.msg);
            }
        });
    }
}

function regionEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().hide();
}

/* 商品分类选择函数 */
function gcategoryInit(divId)
{
    $("#" + divId + " > select").get(0).onchange = gcategoryChange; // select的onchange事件
    window.onerror = function() {
        return true;
    }; //屏蔽jquery报错
    $("#" + divId + " .edit_gcategory").click(gcategoryEdit); // 编辑按钮的onclick事件
}

function gcategoryChange()
{
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++)
    {
        sel = selects[i];
        if (sel.value > 0)
        {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));

    // ajax请求下级分类
    if (this.value > 0)
    {
        var _self = this;
        var url = REAL_SITE_URL + '/index.php?app=mlselection&type=gcategory';
        $.getJSON(url, {'pid': this.value}, function(data) {
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(gcategoryChange).insertAfter(_self);
                    var data = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].cate_id + "'>" + data[i].cate_name + "</option>");
                    }
                }
            }
            else
            {
                alert(data.msg);
            }
        });
    }
    // ajax 请求该商品分类的属性设置 sku  
    if (id > 0)
    {
        $("#props").children().remove(); // 先除掉原先加载的 属性列表 html
        var url = REAL_SITE_URL + '/index.php?app=my_goods&act=ajax_props';
        $.getJSON(url, {'cate_id': id}, function(data) {
            if (data.done)
            {
                //alert(data.retval.length);
                if (data.retval.length > 0)
                {
                    $("#prop_list").show();
                    var data = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        //alert(data[i].pid);
                        $("#props").append("<span>" + data[i].name + "</span>");
                        $("#props").append("<select name=props[] id='prop" + data[i].pid + "'>");
                        values = data[i].value;
                        option = "<option value=''></option>";
                        for (j = 0; j < values.length; j++)
                        {
                            //alert(values[j].prop_value);
                            if (values[j].prop_value != undefined) {
                                option += "<option value='" + values[j].pid + ":" + values[j].vid + "'>" + values[j].prop_value + "</option>"
                            }
                        }
                        $("#prop" + data[i].pid).append(option);
                        $("#props").append("</select>");
                    }
                }
                else
                {
                    $("#prop_list").hide();
                }
            }
        });
    }
    else {

        $("#prop_list").hide();
    }
    // end sku


}

function gcategoryEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().remove();
}

/* 供求分类选择函数 */
function sdcategoryInit(divId)
{
    $("#" + divId + " > select").get(0).onchange = sdcategoryChange; // select的onchange事件
    window.onerror = function() {
        return true;
    }; //屏蔽jquery报错
    $("#" + divId + " .edit_gcategory").click(sdcategoryEdit); // 编辑按钮的onclick事件
}

function sdcategoryChange()
{
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++)
    {
        sel = selects[i];
        if (sel.value > 0)
        {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }
    $(".mls_sdid").val(id);
    $(".mls_sdname").val(name);
    $(".mls_sdnames").val(names.join("\t"));

    // ajax请求下级分类
    if (this.value > 0)
    {
        var _self = this;
        var url = REAL_SITE_URL + '/index.php?app=mlselection&type=sdcategory';
        $.getJSON(url, {'pid': this.value}, function(data) {
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(sdcategoryChange).insertAfter(_self);
                    var data = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].cate_id + "'>" + data[i].cate_name + "</option>");
                    }
                }
            }
            else
            {
                alert(data.msg);
            }
        });
    }
}

function sdcategoryEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().remove();
}
function gcategoryEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().remove();
}

/* 聚分类选择函数 */
function jucategoryInit(divId)
{
    $("#" + divId + " > select").get(0).onchange = jucategoryChange; // select的onchange事件
    window.onerror = function() {
        return true;
    }; //屏蔽jquery报错
    $("#" + divId + " .edit_gcategory").click(jucategoryEdit); // 编辑按钮的onclick事件
}

function jucategoryChange()
{
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++)
    {
        sel = selects[i];
        if (sel.value > 0)
        {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }
    $(".mls_id").val(id);
    $(".mls_name").val(name);
    $(".mls_names").val(names.join("\t"));

    // ajax请求下级分类
    if (this.value > 0)
    {
        var _self = this;
        var url = REAL_SITE_URL + '/index.php?app=mlselection&type=jucategory';
        $.getJSON(url, {'pid': this.value}, function(data) {
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(jucategoryChange).insertAfter(_self);
                    var data = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].cate_id + "'>" + data[i].cate_name + "</option>");
                    }
                }
            }
            else
            {
                alert(data.msg);
            }
        });
    }
}

function jucategoryEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().remove();
}

/* 供求分类选择函数 */
function sdcategoryInit(divId)
{
    $("#" + divId + " > select").get(0).onchange = sdcategoryChange; // select的onchange事件
    window.onerror = function(){return true;}; //屏蔽jquery报错
    $("#" + divId + " .edit_gcategory").click(sdcategoryEdit); // 编辑按钮的onclick事件
}

function sdcategoryChange()
{
    // 删除后面的select
    $(this).nextAll("select").remove();

    // 计算当前选中到id和拼起来的name
    var selects = $(this).siblings("select").andSelf();
    var id = 0;
    var names = new Array();
    for (i = 0; i < selects.length; i++)
    {
        sel = selects[i];
        if (sel.value > 0)
        {
            id = sel.value;
            name = sel.options[sel.selectedIndex].text;
            names.push(name);
        }
    }
    $(".mls_sdid").val(id);
    $(".mls_sdname").val(name);
    $(".mls_sdnames").val(names.join("\t"));

    // ajax请求下级分类
    if (this.value > 0)
    {
        var _self = this;
        var url = REAL_SITE_URL + '/index.php?app=mlselection&type=sdcategory';
        $.getJSON(url, {'pid':this.value}, function(data){
            if (data.done)
            {
                if (data.retval.length > 0)
                {
                    $("<select><option>" + lang.select_pls + "</option></select>").change(sdcategoryChange).insertAfter(_self);
                    var data  = data.retval;
                    for (i = 0; i < data.length; i++)
                    {
                        $(_self).next("select").append("<option value='" + data[i].cate_id + "'>" + data[i].cate_name + "</option>");
                    }
                }
            }
            else
            {
                alert(data.msg);
            }
        });
    }
}

function sdcategoryEdit()
{
    $(this).siblings("select").show();
    $(this).siblings("span").andSelf().remove();
}
