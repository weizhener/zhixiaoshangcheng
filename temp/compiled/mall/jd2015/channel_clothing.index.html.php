<?php echo $this->fetch('header.html'); ?>
<div  id="main" class="w-full">
    <div id="page-home" class="w-full mb20">
        <div class="col-1 relative w">
            <div class="left" area="col-1-left" widget_type="area">
                <?php $this->display_widgets(array('page'=>'channel_clothing','area'=>'col-1-left')); ?>
            </div>
        </div>
        <div class="col-2" area="col-2" widget_type="area">
            <?php $this->display_widgets(array('page'=>'channel_clothing','area'=>'col-2')); ?>
        </div>
        
        <div class="col-3 w" area="col-3" widget_type="area">
            <?php $this->display_widgets(array('page'=>'channel_clothing','area'=>'col-3')); ?>
        </div>
        <div class="col-4 w" area="col-4" widget_type="area">
            <?php $this->display_widgets(array('page'=>'channel_clothing','area'=>'col-4')); ?>
        </div>
    </div>
</div>

<?php echo $this->fetch('footer.html'); ?>