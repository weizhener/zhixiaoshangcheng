<?php echo $this->fetch('header.html'); ?>
<link type="text/css" href="<?php echo $this->res_base . "/" . 'css/mapstore.css'; ?>" rel="stylesheet" />
<script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $this->_var['baidu_ak']; ?>"></script>
<div id="mapaddr" class="w-full">
    <div class="mapaddr_content w">
        <div class="mapaddr_header">
            <h1>地图点选</h1>
        </div>
        <div id="g_index_map"></div>
    </div>
</div>






<script>
    var pinLng = <?php echo $this->_var['lng']; ?>;
    var pinLat = <?php echo $this->_var['lat']; ?>;

    map = new BMap.Map("g_index_map", {enableMapClick: false});//去掉默认 百度地图的标示
//            map = new BMap.Map("g_index_map");
    map.enableScrollWheelZoom();
    map.enableContinuousZoom();

    var point = new BMap.Point(pinLng, pinLat);
    var myIcon = new BMap.Icon("<?php echo $this->res_base . "/" . 'images/mapstore_3.png'; ?>", new BMap.Size(60, 60));
    marker = new BMap.Marker(point, {icon: myIcon});
    map.addOverlay(marker);
    map.centerAndZoom(point, 16);
    map.addControl(new BMap.NavigationControl());
    marker.setAnimation(BMAP_ANIMATION_BOUNCE);
    marker.enableDragging();//允许拖拽
    marker.addEventListener("mouseup", doMouseUp);

    //绑定地图单击事件
    map.addEventListener("click", clickMap);




    $.ajax({
        url: 'index.php?app=mapstore&act=ajax_get_stores_by_position',
        data: 'lng=' + pinLng + '&lat=' + pinLat,
        dataType: "json",
        success: function(data) {
            complexOverLay(data);
        }
    });



    //添加覆盖物
    function complexOverLay(data) {

        function ComplexCustomOverlay(point) {
            this._point = point;
        }
        ComplexCustomOverlay.prototype = new BMap.Overlay();
        ComplexCustomOverlay.prototype.initialize = function(map) {
            this._map = map;
            var div = this._div = document.createElement("div");

            div.style.position = "absolute";
            div.style.zIndex = BMap.Overlay.getZIndex(this._point.lat);
            div.style.backgroundColor = "white";
            div.style.border = "1px solid #dddddd";
            div.style.color = "#666666";
            div.style.width = "200px";
            div.style.borderRadius = "6px";
            div.style.padding = "25px 20px 0px 20px";
            div.style.boxShadow = "0 1px 6px rgba(0,0,0,0.35)";
            div.style.lineHeight = "18px";
            var aLink = this._aLink = document.createElement("a");


            if (data.done) {
                if (data.retval.store_num > 0) {
                    div.innerHTML = "<span style='font-size:10pt;color:#FF6000;margin:5px 0;display:inline-block'>" + data.retval.region_addr + "</span><br /><span style='font-size:13pt;color:#999;margin:10px 0;display:inline-block'>周边10千米共有 <b style='color:#FF6000' >" + data.retval.store_num + " </b>家店铺</span>";
                    aLink.addEventListener("mousedown", confirm_address);

                } else {
                    div.innerHTML = "<span style='font-size:13pt;color:#999;margin:10px 0;display:inline-block'>周边10千米没有店铺</span>";
                    aLink.addEventListener("mousedown", confirm_address);
                }
            } else {
                alert('系统错误');
            }

            aLink.style.display = "block";
            aLink.style.width = '100%';
            aLink.style.lineHeight = '35px';
            aLink.style.height = '35px';
            aLink.style.borderRadius = '5px';
            aLink.style.textAlign = 'center';
            aLink.style.fontSize = '11pt';
            aLink.style.background = '#92C424';
            aLink.style.margin = '20px 0';
            aLink.style.color = '#ffffff';

            aLink.innerHTML = "点击查看";

            aLink.style.textDecoration = "none";
            aLink.href = "javascript:void(0)";

            div.appendChild(aLink);
            // div.style.whiteSpace = "nowrap";
            div.style.MozUserSelect = "none";
            div.style.fontSize = "12px"

            var arrow = this._arrow = document.createElement("div");
            arrow.style.background = "url(<?php echo $this->res_base . "/" . 'images/mapstore_toolsub.png'; ?>)";
            arrow.style.position = "absolute";
            arrow.style.width = "30px";
            arrow.style.height = "18px";
            arrow.style.bottom = "-18px";
            arrow.style.left = "100px";

            div.appendChild(arrow);

            map.getPanes().labelPane.appendChild(div);
            return div;
        }
        ComplexCustomOverlay.prototype.draw = function() {
            var map = this._map;
            var pixel = map.pointToOverlayPixel(this._point);
            this._div.style.left = pixel.x - parseInt(this._arrow.style.left) - 12 + "px";
            this._div.style.top = pixel.y - 200 + "px";
        }
        myCompOverlay = new ComplexCustomOverlay(new BMap.Point(pinLng, pinLat));
        map.addOverlay(myCompOverlay);
    }
    //点击地图移动PIN

    function confirm_address() {
        map.removeEventListener("click", clickMap);
        window.location.href = "index.php?app=mapstore";
    }

    var _chk = true;//为了避免重复点击事件图层覆盖
    function clickMap(event) {
        if (!_chk) {
            return false;
        }
        _chk = false;


        map.removeOverlay(myCompOverlay);
        map.removeOverlay(marker);

        pinLng = event.point.lng;
        pinLat = event.point.lat;


        var myIcon = new BMap.Icon("<?php echo $this->res_base . "/" . 'images/mapstore_3.png'; ?>", new BMap.Size(60, 60));
        marker = new BMap.Marker(event.point, {icon: myIcon});
        map.addOverlay(marker);
        marker.setAnimation(BMAP_ANIMATION_BOUNCE);
        marker.enableDragging();//允许拖拽
        marker.addEventListener("mouseup", doMouseUp);

        $.ajax({
            url: 'index.php?app=mapstore&act=ajax_get_stores_by_position',
            data: 'lng=' + pinLng + '&lat=' + pinLat,
            dataType: "json",
            success: function(data) {
                complexOverLay(data);
                _chk = true;
            }
        });
    }

    function doMouseUp(event) {
        if (!_chk) {
            return false;
        }
        _chk = false;
        if (myCompOverlay) {
            map.removeOverlay(myCompOverlay);
        }

        pinLng = event.point.lng;
        pinLat = event.point.lat;
        $.ajax({
            url: 'index.php?app=mapstore&act=ajax_get_stores_by_position',
            data: 'lng=' + pinLng + '&lat=' + pinLat,
            dataType: "json",
            success: function(data) {
                complexOverLay(data);
                _chk = true;
            }
        });
    }

</script>
<?php echo $this->fetch('footer.html'); ?>