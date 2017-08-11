<?php echo $this->fetch('footer_order_notice.html'); ?>
<div id="footer">
    <div class="w">
        <div class="copyright">
            <span><?php echo $this->_var['copyright']; ?><br> <?php if ($this->_var['icp_number']): ?><?php echo $this->_var['icp_number']; ?><?php endif; ?> <?php echo $this->_var['statistics_code']; ?></span>
        </div>

    </div>
</div>

<?php echo $this->_var['store']['statistics_url']; ?>
<?php echo $this->_var['async_sendmail']; ?>
</body>
</html>