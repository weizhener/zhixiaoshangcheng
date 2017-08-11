<?php echo $this->fetch('member.header.html'); ?>
<div class="content">
    <?php echo $this->fetch('member.menu.html'); ?>
    <div id="right">
        <?php echo $this->fetch('member.submenu.html'); ?>
        <div class="wrap">

            <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $this->_var['baidu_ak']; ?>"></script>
            <div id="allmap" style="margin-top:20px;width:800px;height:600px;"></div>
            <div class="public">
                <form method="post">
                    <div class="user_search">
                        <span>经度: </span>
                        <input id="lng" name="lng" class="text1 width13" type="text" value="<?php echo $this->_var['store_info']['lng']; ?>">
                        <span>纬度: </span>
                        <input id="lat" name="lat" class="text1 width13" type="text"  value="<?php echo $this->_var['store_info']['lat']; ?>">
                        <span>层级: </span>
                        <input id="zoom" name="zoom" class="text1 width13" type="text"  value="<?php echo $this->_var['store_info']['zoom']; ?>">
                        <input type="submit" class="btn" value="保存">
                    </div>
                </form>
            </div>
            <script type="text/javascript">
// 百度地图API功能
                var map = new BMap.Map("allmap");

                var point = new BMap.Point(<?php echo $this->_var['store_info']['lng']; ?>, <?php echo $this->_var['store_info']['lat']; ?>);
                map.centerAndZoom(point, <?php echo $this->_var['store_info']['zoom']; ?>);

                map.addControl(new BMap.NavigationControl());
                map.enableScrollWheelZoom();                            //启用滚轮放大缩小


                var marker = new BMap.Marker(point);  // 创建标注
                map.addOverlay(marker);              // 将标注添加到地图中
                marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                

                map.addEventListener("click", function(e){
//                    alert(e.point.lng + ", " + e.point.lat);
                    map.clearOverlays();  //清除标注  或者可以把market 放入数组
                    var point = new BMap.Point(e.point.lng , e.point.lat);
                    var marker = new BMap.Marker(point);
                    map.addOverlay(marker);
                    marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                    
                    document.getElementById("lng").value = e.point.lng;
                    document.getElementById("lat").value = e.point.lat;
                    document.getElementById("zoom").value = map.getZoom(10);
                });
                


            </script>







        </div>
    </div>
    <div class="clear"></div>
</div>
<?php echo $this->fetch('footer.html'); ?>
