/* spec对象 */
function spec(id, spec1, spec2, price, pro_price, stock, is_pro,discount)
{
    this.id = id;
    this.spec1 = spec1;
    this.spec2 = spec2;
    this.price = price;
    this.pro_price = pro_price; // add by psmb 
    this.stock = stock;
    this.is_pro = is_pro;
    this.discount=discount;
}

/* goodsspec对象 */
function goodsspec(specs, specQty, defSpec)
{
    this.specs = specs;
    this.specQty = specQty;
    this.defSpec = defSpec;
    this.spec1 = null;
    this.spec2 = null;
    if (this.specQty >= 1)
    {
        for (var i = 0; i < this.specs.length; i++)
        {
            if (this.specs[i].id == this.defSpec)
            {
                this.spec1 = this.specs[i].spec1;
                if (this.specQty >= 2)
                {
                    this.spec2 = this.specs[i].spec2;
                }
                break;
            }
        }
    }

    // 取得某字段的不重复值，如果有spec1，以此为条件
    this.getDistinctValues = function (field, spec1)
    {
        var values = new Array();
        for (var i = 0; i < this.specs.length; i++)
        {
            var value = this.specs[i][field];
            if (spec1 != '' && spec1 != this.specs[i].spec1)
                continue;
            if ($.inArray(value, values) < 0)
            {
                values.push(value);
            }
        }
        return (values);
    }

    // 取得选中的spec
    this.getSpec = function ()
    {
        for (var i = 0; i < this.specs.length; i++)
        {
            if (this.specQty >= 1 && this.specs[i].spec1 != this.spec1)
                continue;
            if (this.specQty >= 2 && this.specs[i].spec2 != this.spec2)
                continue;

            return this.specs[i];
        }
        return null;
    }

    // 初始化
    this.init = function ()
    {
        if (this.specQty >= 1)
        {
            var spec1Values = this.getDistinctValues('spec1', '');
            for (var i = 0; i < spec1Values.length; i++)
            {
                if (spec1Values[i] == this.spec1)
                {
                    $(".handle ul:eq(0)").append("<li class='solid' onclick='selectSpec(1, this)'><a href='javascript:;'><span>" + spec1Values[i] + "</span></a></li>");
                }
                else
                {
                    $(".handle ul:eq(0)").append("<li class='dotted' onclick='selectSpec(1, this)'><a href='javascript:;'><span>" + spec1Values[i] + "</span></a></li>");
                }
            }
        }
        if (this.specQty >= 2)
        {
            var spec2Values = this.getDistinctValues('spec2', this.spec1);
            for (var i = 0; i < spec2Values.length; i++)
            {
                if (spec2Values[i] == this.spec2)
                {
                    $(".handle ul:eq(1)").append("<li class='solid' onclick='selectSpec(2, this)'><a href='javascript:;'><span>" + spec2Values[i] + "</span></a></li>");
                }
                else
                {
                    $(".handle ul:eq(1)").append("<li class='dotted' onclick='selectSpec(2, this)'><a href='javascript:;'><span>" + spec2Values[i] + "</span></a></li>");
                }
            }
        }
        var spec = this.getSpec();
        $("[ectype='current_spec']").html(spec.spec1 + ' ' + spec.spec2);
    }
}

/* 选中某规格 num=1,2 */
function selectSpec(num, liObj)
{
    goodsspec['spec' + num] = $(liObj).find('a span').html();

    $(liObj).attr("class", "solid");
    $(liObj).siblings(".solid").attr("class", "dotted");

    // 当有2种规格并且选中了第一个规格时，刷新第二个规格
    if (num == 1 && goodsspec.specQty == 2)
    {
        goodsspec.spec2 = null;
        $(".aggregate").html("");
        $(".handle ul:eq(1) li[class='handle_title']").siblings().remove();

        var spec2Values = goodsspec.getDistinctValues('spec2', goodsspec.spec1);
        for (var i = 0; i < spec2Values.length; i++)
        {
            $(".handle ul:eq(1)").append("<li class='dotted' onclick='selectSpec(2, this)'><a href='javascript:;'><span>" + spec2Values[i] + "</span></a></li>");
        }
    }
    else
    {
        var spec = goodsspec.getSpec();
        if (spec != null)
        {
            $("[ectype='current_spec']").html(spec.spec1 + ' ' + spec.spec2);
            $("[ectype='goods_price']").html(price_format(spec.price));
            if (spec.discount < 1 && spec.discount > 0) {
                $("[ectype='member_price']").html(price_format(spec.price * spec.discount));
            }
            if(spec.is_pro){
                $("[ectype='goods_pro_price']").html(price_format(spec.pro_price));
            }
            $("[ectype='goods_stock']").html(spec.stock);
        }
    }
}
function slideUp_fn()
{
    $('.ware_cen').slideUp('slow');
}
$(function () {
    goodsspec.init();

    //放大镜效果/
    if ($(".jqzoom img").attr('jqimg'))
    {
        $(".jqzoom").jqueryzoom({xzoom: 450, yzoom: 450});
    }

    // 图片替换效果
    $('.ware_box li').mouseover(function () {
        $('.ware_box li').removeClass();
        $(this).addClass('ware_pic_hover');
        $('.big_pic img').attr('src', $(this).children('img:first').attr('src'));
        $('.big_pic img').attr('jqimg', $(this).attr('bigimg'));
    });

    //点击后移动的距离
    var left_num = -61;

    //整个ul超出显示区域的尺寸
    var li_length = ($('.ware_box li').width() + 6) * $('.ware_box li').length - 305;

    $('.right_btn').click(function () {
        var posleft_num = $('.ware_box ul').position().left;
        if ($('.ware_box ul').position().left > -li_length) {
            $('.ware_box ul').css({'left': posleft_num + left_num});
        }
    });

    $('.left_btn').click(function () {
        var posleft_num = $('.ware_box ul').position().left;
        if ($('.ware_box ul').position().left < 0) {
            $('.ware_box ul').css({'left': posleft_num - left_num});
        }
    });

    // 加入购物车弹出层
    $('.close_btn').click(function () {
        $('.ware_cen').slideUp('slow');
    });
    
	// tyioocom delivery 
	$('.postage-cont').hover(function(){
		$(this).find('.postage-area').show();
	},function(){
		$(this).find('.postage-area').hide();
	});
	$('.province a').click(function(){
		$('.cities').find('div').hide();
		$('.cities .city_'+this.id).show();		
		$('.province').find('a').attr('class','');
		$(this).attr('class','selected');
	});
	$('.cities a').click(function(){
		$('.cities').find('a').attr('class','');
		$(this).attr('class','selected');
						
		delivery_template_id = $(this).attr('delivery_template_id');
		city_id 	= $(this).attr('city_id');
		store_id    = $(this).attr('store_id');
			
		//  加载指定城市的运费
		load_city_logist(delivery_template_id,store_id,city_id); //传递 store_id,是为了在delivery_templaet_id 为0 的情况下，获取店铺的默认运费模板
	});
    /* 促销商品倒计时 */
    var theDaysBox = $('.J_Countdown_GoodsPromotion').find('.J_NumDays');
    var theHoursBox = $('.J_Countdown_GoodsPromotion').find('.J_NumHours');
    var theMinsBox = $('.J_Countdown_GoodsPromotion').find('.J_NumMins');
    var theSecsBox = $('.J_Countdown_GoodsPromotion').find('.J_NumSeconds');

    countdown(theDaysBox, theHoursBox, theMinsBox, theSecsBox);

});


function load_city_logist(delivery_template_id,store_id,city_id)
{
	html = '';
	if(city_id==undefined) {
		city_id = '';
	}
	var url = SITE_URL + '/index.php?app=logist&delivery_template_id='+delivery_template_id+'&store_id='+store_id+'&city_id='+city_id;
		$.getJSON(url,function(data){
			if (data.done){
				data = data.retval;
					$.each(data.logist_fee,function(n,v){
					html += v.name+':'+v.start_fees+'元 ';
			});
			$('#selected_city').html('至&nbsp;'+data.city_name);
			$('.postage-info').html(html);
			$('.postage-area').hide();
		}
	});
}


