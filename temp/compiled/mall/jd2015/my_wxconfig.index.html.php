<?php echo $this->fetch('member.header.html'); ?>
<script type="text/javascript">
//<!CDATA[
    $(function() {
        $('#my_wxconfig_form').validate({
            errorPlacement: function(error, element) {
                $(element).next('.field_notice').hide();
                if ($(element).parent().parent().is('b'))
                {
                    $(element).parent().parent('b').next('.explain').hide();
                    $(element).parent().parent('b').after(error);
                }
                else
                {
                    $(element).after(error);
                }
            },
            rules: {
                url: {
                    required: true,
                },
                token: {
                    required: true,
                }
            },
            messages: {
                url: {
                    required: '不能为空',
                },
                token: {
                    required: '不能为空',
                }
            }
        });
    });

//]]>

</script>
<?php echo $this->_var['build_editor']; ?>
<div class="content">
    <div class="totline"></div>
    <div class="botline"></div>
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right"> <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">
            <div class="public">
                <div class="information">
                    <div class="setup info shop">
                        <form  enctype="multipart/form-data" method="post"  id="my_wxconfig_form" m>
                            <table style="width: 100%">
                                
                                <tr>
                                    <th class="width2">接口配置URL:</th>
                                    <td>
                                        <p class="td_block"><input id="url" type="text" class="text width_normal" name="url" value="<?php echo htmlspecialchars($this->_var['wx_config']['url']); ?>" style="width:480px;" readonly/></p>
                                        
                                    </td>
                                </tr>
                                <tr>
                                    <th>接口配置Token:</th>
                                    <td>
                                        <p class="td_block"><input type="text" name="token" class="text width_normal" id="token" value="<?php echo htmlspecialchars($this->_var['wx_config']['token']); ?>" readonly/></p>
                                        <a href="static/weixin/help/index.html" target="_blank" class="btn1">说明文档</a>
                                    </td>
                                </tr>
                                
                                 <tr>
                                    <th class="width2">公众号名称</th>
                                    <td>
                                        <p class="td_block">    
                                     <input type="text" name="name" class="form-control rect" id="name" value="<?php echo htmlspecialchars($this->_var['wx_config']['name']); ?>"/></p>
                                    </td>
                                </tr>
                                
                                  <tr>
                                    <th class="width2">公众号类型</th>
                                    <td>
                                        <p class="td_block">    
                                      <select class="querySelect" name="type"><?php echo $this->html_options(array('options'=>$this->_var['type'],'selected'=>$this->_var['wx_config']['type'])); ?></select></p>
                                    </td>
                                </tr>
                                
                                 <tr>
                                    <th class="width2">二维码场景图片</th>
                                    <td>
                                     <p class="td_block"><input type="file"  name="pic" /></p>
                                     <?php if ($this->_var['wx_config']['pic']): ?><p class="td_block"><a target="_blank" href="<?php echo $this->_var['wx_config']['pic']; ?>" ><img width="50" height="50" src="<?php echo $this->_var['wx_config']['pic']; ?>"  /></a></p><?php endif; ?>
                                 	<p class="td_block">建议尺寸530*800 <a target="_blank" href="qrcode/qrcode.jpg">点击查看参考示图</a></p>      
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td>
                                        <div class="issuance"><input type="submit" class="btn" value="提交" /></div>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
            </div>
            <div class="wrap_bottom"></div>
        </div>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>