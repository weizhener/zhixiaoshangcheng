$(function(){
	
	// 表单验证
	$('#delivery_template').submit(function(){
		if($(this).find('input[name="name"]').val()==''){
			alert('请输入模板名称');
			return false;
		}
		
		i=0;
		$(this).find('input[group="dests"]').each(function(index, element) {
			if($(this).attr('value')==''){ i++;	}
		});
		if(i > 0) {
			alert('您还有“未添加地区”项，请设置地区');
			return false;
		}
		

	});
	
	$('.J_Province input[fileds="province"]').live("click",function(){
		if($(this).attr('checked')==true){
			$(this).parent().find('.citylist').find('input[fileds="city"]').attr('checked',true);
			checkCount = $(this).parent().find('.citylist').find('input[fileds="city"]:checked').length;
			if(checkCount > 0) {
				$(this).parent().find('label[fileds="provinceName"]').find('i').html('('+checkCount+')');
			}
		} else {
			$(this).parent().find('.citylist').find('input[fileds="city"]').attr('checked',false);
			$(this).parent().find('label[fileds="provinceName"]').find('i').html('');
		}
	});
	
	$('.J_CloseCity').live("click",function(){
		$(this).parent().parent().parent().parent().toggleClass('gareas-cur');
		$(this).parent().parent().parent().toggleClass('hidden');
	});
	
	$('.J_ExpandCity').live("click",function(){
		$(this).next('.citylist').toggleClass('hidden');
		$(this).parent().toggleClass('gareas-cur');
		
	});
	
	$('.J_Province input[fileds="city"]').live("click",function(){
		checkCount = 0;
		checkAll = true;
		$(this).parent().parent().find('input[fileds="city"]').each(function(index, element) {
			if($(this).attr('checked')==true){
				checkCount++;
			}
			else{
				checkAll = false;
			}
		});
		$(this).parent().parent().parent().parent().find('input[fileds="province"]').attr('checked', checkAll);
		if(checkCount==0) {
			$(this).parent().parent().parent().parent().find('label[fileds="provinceName"]').find('i').html('');
		} else {
			$(this).parent().parent().parent().parent().find('label[fileds="provinceName"]').find('i').html('('+checkCount+')');
		}
	});
	
	$('.del_area').live("click",function(){
		type = $(this).attr('type');
		
		if($('#'+type+' tbody').find('tr').length > 1){
			$(this).parent().parent().remove();
		} else { // 如果删除的是最后一个 tr,则删除整个 table
			$('#'+type+' table').remove();
		}
	});
	
	$('.add_area').live("click",function(){
		type = $(this).attr('type');
		area_id = new Date().getTime();
		
		tr = '<tr>' + 
				 	'<td class="cell-area">' +
					'	<div class="selected_area J_SelectedAreaName">未添加地区</div>' +
					'	<input type="hidden" group="dests" name="'+type+'_dests[]" value="" />'+
					'	<a href="javascript:;" gs_id="gselector-delivery-'+type+area_id+'" gs_name="delivery_name" gs_callback="gs_callback" gs_title="编辑运费模板" gs_width="660" gs_type="delivery" gs_store_id="" ectype="gselector" gs_opacity="0.05" gs_class="simple-blue" name="gselector-delivery" id="gselector-delivery" class="btn-add-product">编辑</a>' +
					'</td>'+
					'<td><input type="text" class="input" value="1" name="'+type+'_start[]" /></td>'+
					'<td><input type="text" class="input" value="10" name="'+type+'_postage[]" /></td>'+
					'<td><input type="text" class="input" value="1" name="'+type+'_plus[]" /></td>'+
					'<td><input type="text" class="input" value="0" name="'+type+'_postageplus[]" /></td>'+
					'<td><a href="javascript:;" class="del_area" type="'+type+'">删除</a></td>'+
				 '</tr>';

		// 如果有 thead
		if($('#'+type+' tbody').find('tr').length>0){
			$('#'+type+' tbody').append(tr);
		}
		else
		{
			html = '<table border="0" cellpadding="0" cellspacing="0">'+
				 	'<thead>'+
						'<tr>'+
							'<th class="cell-area">运送到</th>'+
							'<th>首件(个)</th>'+
							'<th>首费(元)</th>'+
							'<th>续件(个)</th>'+
							'<th>续费(元)</th>'+
							'<th>操作</th>'+
						'</tr>'+
					'</thead>'+
					'<tbody>';
				 
			html += tr + '</tbody></table>';
			
			$('#'+type+' .fee_list').append(html);
		}
	});
		
});

function bind(id)
{
	// 获取指定地区运费的地区ID
	$('*[gs_id="'+id+'"]').parent().find('input[group="dests"]').each(function(index, element) {
		dests = $(this).val().split('|');
    });
	
	// 设置选择的地区为选中状态
	$.each(dests, function(i,item){
		$('.J_Province').children().find('input[value="'+item+'"]').attr('checked', true);
	});
	
	// 如果省选中的话，设置该省下面的所有城市为选中状态
	$('.J_Province input[fileds="province"]').each(function(index, element) {
        if($(this).attr('checked')==true) {
			$(this).parent().find('.citylist').find('input[fileds="city"]').attr('checked',true);
		}
    });
	
	// 计算城市选中的数量，赋值到省后面
	$('.J_Province').find('.citylist').each(function(index, element) {
        checkCount = $(this).find('input[type="checkbox"]:checked').length;
		if(checkCount > 0) {
			$(this).parent().find('label[fileds="provinceName"]').find('i').html('('+checkCount+')');
		}
    });
}

function gs_callback(id)
{
	dests = AreaName = '';
	$('.J_Province').find('input[fileds="province"]').each(function(index, element) {
		if(0){
			dests += '|'+$(this).val();
			AreaName += ','+$(this).attr('title');
		}
		else
		{
			// 城市
			$(this).parent().find('.citylist').find('input[fileds="city"]').each(function(index, element) {
				if($(this).attr('checked')==true){
					dests += '|'+$(this).val();
					AreaName += ','+$(this).attr('title');
				}
			});
		}
	});
	if(dests.length==0){
		msg('您没有选择任何地区');return false;
	}
	$('*[gs_id="'+id+'"]').parent().find('input[group="dests"]').val(dests.substr(1));
	
	if(AreaName.length==0) {
		AreaName = '未添加地区';
	} else AreaName = AreaName.substr(1);
	
	$('*[gs_id="'+id+'"]').parent().find('.J_SelectedAreaName').html(AreaName);
	
	DialogManager.close(id);

}

function msg(msg){
    $('.J_Warning').show();
    $('.J_Warning').text(msg);
    window.setTimeout(function(){
        $('.J_Warning').hide();
    },6000)
}