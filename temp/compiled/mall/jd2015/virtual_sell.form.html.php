<script type="text/javascript">
	$('#add_form').validate({ 
        errorPlacement: function(error, element){
            $(element).next('.field_notice').hide();
            $(element).after(error);
        },
        success       : function(label){
            label.addClass('right').text('OK!');
            
        },
        submitHandler:function(form){
        	ajax_submit();
        },
        rules : {    
            username : {
            	 required : true,
                 byteRange: [3,25,'<?php echo $this->_var['charset']; ?>'],
                 remote   : {
                     url :'index.php?app=member&act=check_user&ajax=1',
                     type:'get',
                     data:{
                         user_name : function(){
                             return $('#username').val();
                         }
                     },
                     beforeSend:function(){
                         var _checking = $('#checking_user');
                         _checking.prev('.field_notice').hide();
                         _checking.next('label').hide();
                         $(_checking).show();
                     },
                     complete :function(){
                         $('#checking_user').hide();
                     }
                 }
            },
            order_time:{
               required   : true
            },
            comment_time:{
               required   : true
            },
            comment:{
               required   : true
            } 
        },
        messages : {
        	username : {
        		required : '用户名不能为空!',
                byteRange: '用户名长度必须是3到25!',
                remote   : '该用户名已经使用!'
            },
            order_time  : {
                required   : '不能为空'
            },
            comment_time  : {
                required   : '不能为空'
            },
            comment  : {
                required   : '不能为空'
            } 
        }
    });

	function ajax_submit(){  
		
		$.get('index.php?app=goods_virtual_sell&act=add_virtual_sell&goods_id='+$('#goods_id').val(),
				{
					'username':$('#username').val(),
					'order_time':$('#order_time').val(),
					'comment_time':$('#comment_time').val(),
					'comment':$('#comment').val()
				},
				function(data){
					$('#add_form')[0].reset(); 
					$("lable .error right").each(function(key,object){  
			            $(object).html('');
			        });  
					 
					var json = eval('('+data+')');
					   if(!confirm('新增'+json.msg+' ,继续添加?')){ 
							 DialogManager.close('add_virtual_sell');
						 } 
				}
			);
		
		return false;
	};
	
	
	$('#order_time').datetimepicker({
		showSecond: true, //显示秒
		hour: 13,
		minute: 15,
		second: 27, 
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm:ss' 
	});
	
	$('#comment_time').datetimepicker({
		showSecond: true, //显示秒
		hour: 18,
		minute: 34,
		second: 19,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'hh:mm:ss' 
	});

</script>

<style>

.ui-timepicker-div .ui-widget-header{margin-bottom: 8px;}
.ui-timepicker-div dl{text-align: left;}
.ui-timepicker-div dl dt{height: 25px;}
.ui-timepicker-div dl dd{margin: -25px 0 10px 65px;}
.ui-timepicker-div td {font-size: 90%;}

</style>


<ul class="tab">
    <li class="active">添加销售记录</li>
</ul>
<div class="content1">
<div id="warning"></div>
    <input type="hidden" id="goods_id" name="id" value="<?php echo $this->_var['goods_id']; ?>" >
    
    <form target="iframe_post" id="add_form" onsubmit="return false">
        
	    <h1> <?php echo $this->_var['goods_name']; ?></h1>
	    
	    <table  class="infoTable" align="center">
	    	<tr>
	    		 <td class="paddingT15" > <span>用户名:</span>  </td>
	    		 <td class="paddingT15 wordSpacing5"> <input name="username"  id="username"  type="text"  />   </td>
	    		 <td> <label class="field_notice"></label> </td>
	    	</tr>
	    
	        <tr>
	    		 <td class="paddingT15" > <span>下单时间:</span>  </td>
	    		 <td class="paddingT15 wordSpacing5">
	    		     <input name="order_time"  id="order_time"  type="text"  /> &nbsp; 
	    		 </td>
	    		 <td> <label class="field_notice"></label> </td>
	    	</tr>
	    	  
	    	  
	    	<tr>
	    		 <td class="paddingT15" > <span>评论时间:</span>  </td>
	    		 <td class="paddingT15 wordSpacing5"> 
	    		    <input name="comment_time"  id="comment_time"  type="text"  /> &nbsp;   
	    		 </td>
	    		 <td> <label class="field_notice"></label> </td>
	    	</tr>
	    
	        <tr>
	    		 <td class="paddingT15" >  <span>评论:</span>  </td>
	    		 <td class="paddingT15 wordSpacing5"> 
	    		    <textarea rows="3" cols="18" name="comment"  id="comment" ></textarea> 
	    		 </td>
	    		 <td> <label class="field_notice"></label> </td>
	    	</tr> 
	    	
	    </table>
	    
	     
	    <p></p>
	    
	    <div class="btn">
	        <input type="submit" id="confirm_button" class="btn1" value="确认" /> 
	    </div>
	    
    </form>
</div>

