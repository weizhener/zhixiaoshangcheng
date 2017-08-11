<?php echo $this->fetch('member.header.html'); ?>

<div class="mb-head">

    <a href="javascript:history.back(-1)" class="l_b">返回</a>

    <div class="tit">我的推广</div>

    <a href="javascript" class="r_b"></a>

</div>

<?php echo $this->fetch('member.submenu.html'); ?>

<br/>



<div style="background:#fff;padding:10px;">
    <h1>我的推广二维码</h1>
    <img src="http://ykt.anduowang.com/index.php?app=qrcode&url=http://ykt.anduowang.com/index.php?app=reg%26u=<?php echo $this->_var['member_info']['user_name']; ?>"/>
	<br />
	<br />
	<a onClick="window.yutebi.share('http://ykt.anduowang.com/index.php?app=qrcode&url=http://ykt.anduowang.com/index.php?app=reg%26u=<?php echo $this->_var['member_info']['user_name']; ?>');">点击分享给你的好友</a>
	<br />
	<br />

    我的推荐人：<?php if ($this->_var['parent_refers']): ?><?php echo $this->_var['parent_refers']['user_name']; ?><?php else: ?>自行注册<?php endif; ?>

    <br/>

</div>





<?php echo $this->fetch('member.footer.html'); ?>