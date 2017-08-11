<?php echo $this->fetch('header.html'); ?>

<script type="text/javascript">
//<!CDATA[
    $(function () {
        $(".show_image").mouseover(function () {
            $(this).next("div").show();
        });
        $(".show_image").mouseout(function () {
            $(this).next("div").hide();
        });
    });
//]]>
</script>

<div id="rightTop">
    <p>手机版设置</p>
    <ul class="subnav">
        <li><span>基本设置</span></li>
    </ul>
</div>
<div class="info">
    <form method="post" enctype="multipart/form-data">
        <table class="infoTable">
            <tr>
                <th class="paddingT15"> <label for="wap_site_name">手机网站名称:</label></th>
                <td class="paddingT15 wordSpacing5"><input id="wap_site_name" type="text" name="wap_site_name" value="<?php echo $this->_var['setting']['wap_site_name']; ?>" class="infoTableInput"/>        </td>
            </tr>
            <tr>
                <th class="paddingT15"> <label for="wap_site_title">手机网站标题:</label></th>
                <td class="paddingT15 wordSpacing5"><input id="wap_site_title" type="text" name="wap_site_title" value="<?php echo $this->_var['setting']['wap_site_title']; ?>" class="infoTableInput"/>        </td>
            </tr>
            <tr>
                <th class="paddingT15" valign="top"> <label for="wap_site_description">手机网站描述:</label></th>
                <td class="paddingT15 wordSpacing5"><textarea name="wap_site_description" id="wap_site_description"><?php echo $this->_var['setting']['wap_site_description']; ?></textarea>        </td>
            </tr>
            <tr>
                <th class="paddingT15">手机网站关键字:</th>
                <td class="paddingT15 wordSpacing5"><input id="wap_site_keywords" type="text" name="wap_site_keywords" value="<?php echo $this->_var['setting']['wap_site_keywords']; ?>" class="infoTableInput"/></td>
            </tr>
            <tr>
                <th class="paddingT15"><label for="wap_site_logo">手机网站Logo:</label></th>
                <td class="paddingT15 wordSpacing5"><input class="infoTableFile" id="wap_site_logo" type="file" name="wap_site_logo" />
                    <?php if ($this->_var['setting']['wap_site_logo']): ?>
                    <img class="show_image" src="<?php echo $this->res_base . "/" . 'style/images/right.gif'; ?>" />
                    <div style="position:absolute; display:none"><img src="<?php echo $this->_var['site_url']; ?>/<?php echo $this->_var['setting']['wap_site_logo']; ?>?<?php echo $this->_var['random_number']; ?>" /></div>
                    <?php endif; ?></td>
            </tr>
            <tr>
                <th></th>
                <td class="ptb20"><input class="formbtn" type="submit" name="Submit" value="提交" />
                    <input class="formbtn" type="reset" name="Submit2" value="重置" />        </td>
            </tr>
        </table>
    </form>
</div>
<?php echo $this->fetch('footer.html'); ?>