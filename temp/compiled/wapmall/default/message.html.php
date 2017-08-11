<?php echo $this->fetch('member.header.html'); ?>
<div class="mb-head">
    <a href="javascript:history.back(-1)" class="l_b">返回</a>
    <div class="tit"><?php echo $this->_var['head_msg']; ?></div>
    <a href="javascript" class="r_b"></a>
</div>

    <body class="gray">
        <div class="w320">
            <div class="mark"> 
                <div class="bm_con">
                    <div class="marklist">
                        <ul>
                            <br>
                                <li style="text-align:center;"><?php echo $this->_var['message']; ?>
                                    <?php if ($this->_var['err_file']): ?>
                                    <b style="clear: both; float: left; font-size: 15px;">Error File: <strong><?php echo $this->_var['err_file']; ?></strong> at <strong><?php echo $this->_var['err_line']; ?></strong> line.</b>
                                    <?php endif; ?>
                                    <?php if ($this->_var['icon'] != "notice"): ?>
                                    <font style="clear: both; display:block; margin:0 0 0 50px;">
                                        <?php $_from = $this->_var['links']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }; $this->push_vars('', 'item');if (count($_from)):
    foreach ($_from AS $this->_var['item']):
?>
                                        <a style="color:#aaa;" href="<?php echo $this->_var['item']['href']; ?>">>> <?php echo $this->_var['item']['text']; ?></a><br />
                                        <?php endforeach; endif; unset($_from); ?><?php $this->pop_vars();; ?>
                                    </font>
                                    <?php endif; ?>
                                </li>
                        </ul>
                    </div>
                </div>

            </div>
        </div>
        <script type="text/javascript">
            //<!CDATA[
<?php if ($this->_var['redirect']): ?>
            window.setTimeout("<?php echo $this->_var['redirect']; ?>", 1000);
<?php endif; ?>
            //]]>
        </script>
        
<?php echo $this->fetch('member.footer.html'); ?>