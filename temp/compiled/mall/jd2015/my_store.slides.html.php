<?php echo $this->fetch('member.header.html'); ?>
<style>
.information .info table{width :auto;}
</style>
<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.submenu.html'); ?>
    <div class="wrap">
        <div class="public">
            <div class="information">
               <form method="post" enctype="multipart/form-data" id="pic_slides_form">
                    <div class="setup info shop">

                        <table style="width: 100%;">
                            <tr>
                                <th style="width:150px;">幻灯片1：(750px * 300px)</th>
                                <td style="width:250px;">
                                    <p class="td_block"><input type="file" class="text width_normal" name="pic_slides_url_1" /></p>
                                </td>
                                <td><?php if ($this->_var['slides']['pic_slides_url_1']): ?><img src="<?php echo $this->_var['slides']['pic_slides_url_1']; ?>"  height="25"/><?php endif; ?></td>
                            </tr>
                            <tr>
                                <th class="width2">幻灯片链接1：</th>
                                <td>
                                    <p class="td_block"><input type="text" class="text width_normal" name="pic_slides_link_1" value="<?php echo $this->_var['slides']['pic_slides_link_1']; ?>" /></p>
                                </td>
                            </tr>
                            
                            <tr>
                                <th style="width:150px;">幻灯片2：(750px * 300px)</th>
                                <td>
                                    <p class="td_block"><input type="file" class="text width_normal" name="pic_slides_url_2" /></p>
                                </td>
                                <td><?php if ($this->_var['slides']['pic_slides_url_2']): ?><img src="<?php echo $this->_var['slides']['pic_slides_url_2']; ?>"  height="25"/> <?php endif; ?></td>
                            </tr>
                            <tr>
                                <th class="width2">幻灯片链接2：</th>
                                <td>
                                    <p class="td_block"><input type="text" class="text width_normal" name="pic_slides_link_2" value="<?php echo $this->_var['slides']['pic_slides_link_2']; ?>"/></p>
                                </td>
                            </tr>

                             <tr>
                                <th style="width:150px;">幻灯片3：(750px * 300px)</th>
                                <td>
                                    <p class="td_block"><input type="file" class="text width_normal" name="pic_slides_url_3" /></p>
                                </td>
                                <td><?php if ($this->_var['slides']['pic_slides_url_3']): ?><img src="<?php echo $this->_var['slides']['pic_slides_url_3']; ?>"  height="25"/> <?php endif; ?></td>
                            </tr>
                            <tr>
                                <th class="width2">幻灯片链接3：</th>
                                <td>
                                    <p class="td_block"><input type="text" class="text width_normal" name="pic_slides_link_3" value="<?php echo $this->_var['slides']['pic_slides_link_3']; ?>"/></p>
                                </td>
                            </tr>
                            <tr>
                            	<th></th>
                                <td><input type="submit" class="btn" value="提交" /></td>
                                <td></td>
                           </tr>
                         </table>
                     </div>
                </form>
            </div>
         </div>
         <div class="wrap_bottom"></div>
        </div>

        <div class="clear"></div>
        <div class="adorn_right1"></div>
        <div class="adorn_right2"></div>
        <div class="adorn_right3"></div>
        <div class="adorn_right4"></div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>