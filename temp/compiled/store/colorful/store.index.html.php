<?php echo $this->fetch('header.html'); ?>
<div class="skin_box">
        <div class="ww">
            <a href="<?php echo $_GET['page']; ?>#im"></a>
        </div>
        <div class="backtop">
            <span onclick="window.scrollTo(0,0);"></span>
        </div>
</div>
<div id="page">
    <div class="w-full col-1" area="top_ad_area" widget_type="area">
    <?php $this->display_widgets(array('page'=>'index','area'=>'top_ad_area')); ?>
    </div>
    <div class="w col-2" area="col-2" widget_type="area">
    <?php $this->display_widgets(array('page'=>'index','area'=>'col-2')); ?>
    </div>
    <div class="col-3 w">
        <div id="left">
            <div class="" area="store_left" widget_type="area">
            <?php $this->display_widgets(array('page'=>'index','area'=>'store_left')); ?>
            </div>
        </div>
        <div id="right">
            <div class="" area="store_right" widget_type="area">
                <?php $this->display_widgets(array('page'=>'index','area'=>'store_right')); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
</div>
<?php echo $this->fetch('footer.html'); ?>
