<script type="text/javascript">
//<!CDATA[
$(function(){
	bind('<?php echo $_GET['id']; ?>');
	$('#gs_submit').click(function(){
		gs_callback('<?php echo $_GET['id']; ?>');
	});
	
	$('#cancel_button').click(function(){
        DialogManager.close('<?php echo $_GET['id']; ?>');
    });
	
});
//]]>
</script>

<style>
body,div,p,dl,dt,li,h3{margin:0;padding:0;}
input{vertical-align:middle}
ul{list-style:none}
.hidden{display:none}
.input{border:1px #7F9DB9 solid;}
.clearfix:after{content:'20'; display:block; height:0; overflow:hidden; clear:both;}
.select_area_form{width:660px;color:#3e3e3e;font-size:12px;}

.select_area_form ul{width:640px;line-height:22px; background:#ECF4FF;padding:5px 8px 5px 8px;}
.select_area_form .province{float:left;width:160px;}
.select_area_form .province strong{font-weight:normal;font-size:12px}
.select_area_form .gareas{border:1px #ECF4FF solid; background:none; display:inline-block;padding-right:5px; position:relative}

.select_area_form .gareas ins{display:none;height:1px; width:100%; position:absolute;left:0;bottom:-1px; z-index:99}
.select_area_form .gareas-cur{border:1px #F7E4A5 solid; background:#FFFEC6;}
.select_area_form .gareas-cur ins{display:block; background:#FFFEC6;}
.select_area_form .province input[type="checkbox"]{width:20px;}
.select_area_form .province i{text-decoration:none; color:#f60; font-style:normal}
.select_area_form .province .expand-city{background:url('<?php echo $this->res_base . "/" . 'images/T1XZCWXd8iXXXXXXXX-8-8.gif'; ?>') no-repeat;width:8px; height:8px; display:inline-block; cursor:pointer}
.select_area_form .citylist{position:relative;}
.select_area_form .city{border:1px #F7E4A5 solid;background:#FFFEC6;width:320px; position:absolute;left:-1px;top:0px; z-index:9}
.select_area_form .city span{display:inline-block}
.select_area_form .city p{text-align:right}
.select_area_form .bottom{border-top:1px #C4D5DF solid; background:#fff;padding:8px 0 8px 20px;margin-top:10px;}
.select_area_form ul.white{background:#fff}

</style>
<form>
	<div class="select_area_form clearfix">
    	<div class="notice-word selectedNoArea J_Warning hidden"></div>
    	<ul class="white clearfix">
			<?php $_from = $this->_var['area']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'province');$this->_foreach['fe_province'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['fe_province']['total'] > 0):
    foreach ($_from AS $this->_var['province']):
        $this->_foreach['fe_province']['iteration']++;
?>
			<li class="province J_Province">
				<span class="gareas clearfix">
					<ins></ins>
					<input type="checkbox" name="province[<?php echo $this->_var['province']['region_id']; ?>]" id="province[<?php echo $this->_var['province']['region_id']; ?>]" fileds="province" value="<?php echo $this->_var['province']['region_id']; ?>" title="<?php echo $this->_var['province']['region_name']; ?>">
					<label fileds="provinceName" for="province[<?php echo $this->_var['province']['region_id']; ?>]"><?php echo $this->_var['province']['region_name']; ?><i></i></label>
					<?php if ($this->_var['province']['cities']): ?>
					<span class="expand-city J_ExpandCity"></span>
					<div class="hidden clearfix citylist">
						<div class="city">
							<?php $_from = $this->_var['province']['cities']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'city');if (count($_from)):
    foreach ($_from AS $this->_var['city']):
?>
							<span>
                        		<input type="checkbox" name="city[<?php echo $this->_var['province']['region_id']; ?>][]" fileds="city" id="city<?php echo $this->_var['city']['region_id']; ?>" value="<?php echo $this->_var['city']['region_id']; ?>" title="<?php echo $this->_var['city']['region_name']; ?>">
								<label fields="cityName" for="city<?php echo $this->_var['city']['region_id']; ?>"><?php echo $this->_var['city']['region_name']; ?></label>
    						</span>
							<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
							<p><input type="button" class="J_CloseCity" value="关闭" /></p>
						</div>
					</div>
					<?php endif; ?>
				</span>
			</li> 
			<?php if ($this->_foreach['fe_province']['iteration'] % 8 == 0 && ! ($this->_foreach['fe_province']['iteration'] == $this->_foreach['fe_province']['total'])): ?>   
		</ul>
		<ul class="<?php if ($this->_foreach['fe_province']['iteration'] % 16 == 0): ?>white<?php endif; ?> clearfix">
		<?php endif; ?>                
		<?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
		</ul>
		<div class="bottom submit">
			<input type="button" id="gs_submit" class="btn" value="提交" />
			<input type="button" id="cancel_button" class="btn2" value="取消" />
		</div>
	</div>
</form>
