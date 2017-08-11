<?php echo $this->fetch('member.header.html'); ?>
<style>
.sub_btn {margin-right:10px; background:transparent url(<?php echo $this->res_base . "/" . 'images/member/btn.gif'; ?>) no-repeat scroll 0 -253px; border:0 none; color:#3F3D3E; cursor:pointer; font-weight:bold; height:32px; width:120px; }
.add_wrap .assort .txt {width: 60px;}
</style>

<div class="content">
  <div class="totline"></div>
  <div class="botline"></div>
  <?php echo $this->fetch('member.menu.html'); ?>
  <div id="right"> <?php echo $this->fetch('member.curlocal.html'); ?>
<?php echo $this->fetch('member.submenu.html'); ?>
    <div class="wrap">
      <div class="public">
        <form id="batch_form" method="POST" enctype="multipart/form-data">
          <div class="information_index">
            <div class="add_wrap">
           
              <div class="assort">
                <p class="txt">拒绝原因: </p>
                <p class="select">
                 <?php echo $this->_var['goods']['godds_log']; ?>
                </p>
               
              </div>
              
            </div>
          </div>
          
        </form>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>