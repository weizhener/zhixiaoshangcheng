<?php echo $this->fetch('member.header.html'); ?>

<script type="text/javascript">

    $(function() {

        $('#add_time_from').datepicker({dateFormat: 'yy-mm-dd'});

        $('#add_time_to').datepicker({dateFormat: 'yy-mm-dd'});

    });

</script>

<div class="content">

    <?php echo $this->fetch('member.menu.html'); ?>

    <div id="right">

        <?php echo $this->fetch('member.submenu.html'); ?>

        <div class="wrap">

            <div class="public">

                <div class="information">

                    <div class="info">

                        <table>

                            <tr>

                                <th style="width: 100px">推荐注册网址:</th>

                                <td style="width: 740px" colspan="6"><input type="text" class="text" name="real_name" value="<?php echo $this->_var['site_url']; ?>/index.php?app=member&act=register&referid=<?php echo $this->_var['member_info']['user_id']; ?>" style="width:600px;float:left" />

                                    <!--<a  class="detlink" href="javascript:copyToClipBoard();">复制网址</a>-->

                                    <span style='margin-left:15px;'>

                                    <embed wmode="transparent" src="<?php echo $this->res_base . "/" . 'clipboard_new.swf'; ?>" width="14" height="15" flashvars="clipboard=<?php echo $this->_var['site_url']; ?>/index.php?app=member%26act=register%26referid=<?php echo $this->_var['member_info']['user_id']; ?>" quality="high" allowscriptaccess="always" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer">

                                    一键复制

                                    </span>

                                </td>

                            </tr>

                            <tr>

                                <th colspan="7"><span style="color:#666">您可以通过 QQ、MSN 等 IM 工具，或者发送邮件，把下面的链接告诉您的好友，邀请他们加入进来</span></th>

                            </tr>

                            <tr>

                                <th>我的推荐人:</th>

                                <td colspan="6"><?php if ($this->_var['parent_refers']): ?><?php echo $this->_var['parent_refers']['user_name']; ?><?php else: ?>自行注册<?php endif; ?></td>

                            </tr>
							
							
                            <tr>

                                <th>您的推广二维码:</th>

                                <td colspan="6">
								
								<img src="http://ykt.anduowang.com/index.php?app=qrcode&url=http://ykt.anduowang.com/index.php?app=reg%26u=<?php echo $this->_var['member_info']['user_name']; ?>"/>
								
								
								
								</td>

                            </tr>
							

                        </table>

                    </div>

                </div>

            </div>

            <div class="wrap_bottom"></div>

        </div>

    </div>

    <div class="clear"></div>

</div>

<?php echo $this->fetch('footer.html'); ?>

