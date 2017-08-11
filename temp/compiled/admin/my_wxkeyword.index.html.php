<?php echo $this->fetch('header.html'); ?>

<div id="rightTop">
    <p>名称</p>
    <ul class="subnav">
        <li><a class="btn1"  href="index.php?app=my_wxconfig">微信接口配置</a></li>
        <li><a class="btn1"  href="index.php?app=my_wxfollow">关注自动回复</a></li>
        <li><span>关键词自动回复</span></li>
        <li><a class="btn1"  href="index.php?app=my_wxmess">消息自动回复</a></li>
        <li><a class="btn1"  href="index.php?app=my_wxmenu">自定义菜单</a></li>
    </ul>
</div>

<div class="tdare">
    <link href="<?php echo $this->res_base . "/" . 'weixin/css/dingcan/css2.css'; ?>" rel="stylesheet" type="text/css" />
    <div class="public_index table1">
        <div class="main_right">
            <a href="javascript:" class="addreply"><img src="<?php echo $this->res_base . "/" . 'weixin/images/dingcan/keywords_03.jpg'; ?>" /></a>
            <div class="list" id="add_zsc" style="display:none;"></div>
            
            <?php $_from = $this->_var['keyinfo']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
            <div class="list" style="position:relative">
                <h3>规则：<?php echo $this->_var['item']['kename']; ?><a href="javascript:" id="zsc_btninfo<?php echo $this->_var['item']['kid']; ?>" class="add" onclick="zsc_show('<?php echo $this->_var['item']['kid']; ?>')"></a><a href="javascript:" class="del" id="zsc_del_<?php echo $this->_var['item']['kid']; ?>" onclick="zscdel('<?php echo $this->_var['item']['kid']; ?>')"></a></h3>
                <div id="zsc_content_<?php echo $this->_var['item']['kid']; ?>">
                    <p>关键字：<?php echo $this->_var['item']['kyword']; ?></p>
                    <?php if ($this->_var['item']['type'] == 1): ?><p>回复：文本消息 </p><?php else: ?><p>回复：图文消息 </p><?php endif; ?>
                </div>
            </div>
            <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?> 
            <div id="localImag"><img id="preview" width=-1 height=-1 style="diplay:none" /></div>
        </div>
        <div class="showimg" style="display:none">
            <div class="stit">
                <span>上传图片</span>
                <a href="javascript:zsc_close();"><img src="<?php echo $this->res_base . "/" . 'weixin/images/dingcan/addpageup_06.jpg'; ?>" /></a>
            </div>
            <div class="sup">
                <input type="button" value="上传图片" class="uploadbtn"/>
                <form action="<?php echo url('app=my_wxkeyword&act=ajaxupload'); ?>" method="post" id="zsc_myform" enctype="multipart/form-data" target="yframe">
                    <input type="file" value="上传图片" class="uploadbtn" style="position:absolute; top:75px; left:20px; filter:alpha(pacity=0);opacity:0; z-index:999;" onchange="zsc_upload()" name="image" />大小不超过1M ，仅限png,jpeg,jpg
                    <input type="hidden" name="sub" value="submit" /> 
                </form>
                <iframe name="yframe" src="<?php echo url('app=my_wxkeyword&act=ajaxupload'); ?>" style="border:none; display:none;"></iframe>
            </div>
            <div class="imgbox">

            </div>
            <div class="sbottom"><input type="button" class="submit" id="zsc_surebtn" /></div>
            
            <span class="loadsubmit">正在上传...</span>
        </div>
        <div class="zhe" style="display:none"></div>
    </div>
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'weixin/js/dingcan/jquery-1.8.3.min.js'; ?>"></script>
    <script type="text/javascript" src="<?php echo $this->res_base . "/" . 'weixin/js/dingcan/addkeyword2.js'; ?>"  charset="utf-8"></script>
    <iframe name="pop_warning" style="display:none;"></iframe>
</div>

<?php echo $this->fetch('footer.html'); ?>