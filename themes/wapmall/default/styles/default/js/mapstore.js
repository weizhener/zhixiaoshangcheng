/*    插件相关      */
$(function () {
    $("[ectype='ul_scategory'] a").click(function () {
        replaceParam('scate_id', this.id);
        return false;
    });
    $("[ectype='order_by'] a").click(function () {
        replaceParam('order', this.id);
        return false;
    });

    $(".newitem h3").click(function () {
        if ($(this).parent().hasClass("hover")) {
            $(this).parent().removeClass("hover");
        } else {
            $(this).parent().addClass("hover");
        }
    });

});

/* 替换参数 */
function replaceParam(key, value)
{
    var params = location.search.substr(1).split('&');
    var found = false;
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr = param.split('=');
        pKey = arr[0];
        if (pKey == 'page')
        {
            params[i] = 'page=1';
        }
        if (pKey == key)
        {
            params[i] = key + '=' + value;
            found = true;
        }
    }
    if (!found)
    {
        value = transform_char(value);
        params.push(key + '=' + value);
    }
    location.assign(SITE_URL + '/index.php?' + params.join('&'));
}

/* 删除参数 */
function dropParam(key)
{
    var params = location.search.substr(1).split('&');
    for (var i = 0; i < params.length; i++)
    {
        param = params[i];
        arr = param.split('=');
        pKey = arr[0];
        if (pKey == 'page')
        {
            params[i] = 'page=1';
        }
        if (pKey == key)
        {
            params.splice(i, 1);
        }
    }
    location.assign(SITE_URL + '/index.php?' + params.join('&'));
}