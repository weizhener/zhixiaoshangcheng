<?php echo $this->fetch('footer_order_notice.html'); ?>
<div class="m_footer">
    <div class="web_icp">
        <p class="copyright">
            <?php echo $this->_var['copyright']; ?>
        </p>
    </div>
    <div class="ext">
        <ul class="ext_list">
            <li><a  href="#" target="_blank"><img src="<?php echo $this->res_base . "/" . 'images/footer1.jpg'; ?>" style="visibility: visible; display: inline;"></a></li>
            <li><a  href="#" target="_blank"><img src="<?php echo $this->res_base . "/" . 'images/footer2.jpg'; ?>" style="visibility: visible; display: inline;"></a></li>
            <li><a  href="#" target="_blank"><img src="<?php echo $this->res_base . "/" . 'images/footer3.gif'; ?>" style="visibility: visible; display: inline;"></a></li>
            <li><a  href="#" target="_blank"><img src="<?php echo $this->res_base . "/" . 'images/footer4.jpg'; ?>" style="visibility: visible; display: inline;"></a></li>
        </ul>
    </div>
</div>

<div  class="right_toTop" style="display: block;">
    <a title="返回顶部" href="javascript:window.scrollTo(0, 0);"></a>
</div>

<?php echo $this->_var['store']['statistics_url']; ?>
<?php echo $this->_var['async_sendmail']; ?>
</body>
</html>