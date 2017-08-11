<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <base href="<?php echo $this->_var['site_url']; ?>/" />
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $this->_var['charset']; ?>" />
        <?php echo $this->_var['page_seo']; ?>
        <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

        <link type="text/css" href="<?php echo $this->res_base . "/" . 'css/global.css'; ?>" rel="stylesheet" />
        <!--
        <link type="text/css" href="<?php echo $this->res_base . "/" . 'css/mapstore.css'; ?>" rel="stylesheet" />
        -->
        <script type="text/javascript" src="index.php?act=jslang"></script>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>
        <script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>


        <script type="text/javascript">
            //<!CDATA[
            var SITE_URL = "<?php echo $this->_var['site_url']; ?>";
            var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";
            var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';
            //]]>
        </script>
        <?php echo $this->_var['_head_tags']; ?>
    </head>
    <body>

        <style>
            body, html,#allmap {width: 100%;height: 100%;overflow: hidden;margin:0;font-family:"微软雅黑";}
            /*mapstore_address.html*/
            .mapaddr_header{height: 40px;width: 100%;background: #92c424;border-radius: 2px 2px 0 0;}
            .mapaddr_header a{margin: 0;text-align: center;font-size: 1.05rem;font-weight: normal;width:50%;display: block;float: left;color: #fff;line-height: 40px;text-decoration:none;}
            .mapaddr_footer{position:fixed;bottom:0px;left: 0px;width: 100%;height:30px;background: #92c424;text-align: center;}
            .mapaddr_footer a{color:#fff;line-height: 30px;text-decoration: none;}
        </style>
        <!--
        <script type="text/javascript" src="http://api.map.baidu.com/api?type=quick&ak=<?php echo $this->_var['baidu_ak']; ?>&v=1.0"></script>
        -->
        <script type="text/javascript" src="http://api.map.baidu.com/api?v=2.0&ak=<?php echo $this->_var['baidu_ak']; ?>"></script>
        <div class="mapaddr_header">
            <a href="<?php echo url('app=mapstore&act=address'); ?>">地图</a>
            <a href="<?php echo url('app=mapstore'); ?>"  style="background:#FF6000;">周边</a>
        </div>
        <div id="allmap"></div>
        <div class="mapaddr_footer"></div>
        <script type="text/javascript">
            var pinLng = <?php echo $this->_var['lng']; ?>;
                    var pinLat = <?php echo $this->_var['lat']; ?>;

            var map = new BMap.Map("allmap");
            
            


var geolocation = new BMap.Geolocation();
geolocation.getCurrentPosition(function(r){
    if(this.getStatus() == BMAP_STATUS_SUCCESS){
        var pinLng = r.point.lng;
        var pinLat = r.point.lat;

            
            var point = new BMap.Point(pinLng, pinLat);
            map.centerAndZoom(point, 16);

            marker = new BMap.Marker(point);
            map.addOverlay(marker);

            map.addEventListener("click", clickMap);


            $.ajax({
                url: 'index.php?app=mapstore&act=ajax_get_stores_by_position',
                data: 'lng=' + pinLng + '&lat=' + pinLat,
                dataType: "json",
                success: function (data) {
                    complexOverLay(data);
                }
            });
        
    }
    else {
        alert('failed'+this.getStatus());
    }        
},{enableHighAccuracy: true})
            


            var _chk = true;//为了避免重复点击事件图层覆盖
            function clickMap(event)
            {
                if (!_chk) {
                    return false;
                }
                _chk = false;
                map.removeOverlay(marker);

                pinLng = event.point.lng;
                pinLat = event.point.lat;

                marker = new BMap.Marker(event.point);
                map.addOverlay(marker);

                $.ajax({
                    url: 'index.php?app=mapstore&act=ajax_get_stores_by_position',
                    data: 'lng=' + pinLng + '&lat=' + pinLat,
                    dataType: "json",
                    success: function (data) {
//                        complexOverLay(data);
                        _chk = true;
                    }
                });
            }




            function complexOverLay(data) {
                if (data.done) {
                    if (data.retval.store_num > 0) {
                        str = "<a href='<?php echo url('app=mapstore'); ?>'>附近10千米有" + data.retval.store_num + "店铺（点击查看）</a>";
                    } else {
                        str = "<a href='<?php echo url('app=mapstore'); ?>'>附近10千米没有店铺（点击查看）</a>";
                    }
                } else {
                    str = "系统错误";
                }
                $('.mapaddr_footer').html(str);
            }


        </script>
    </body>
</html>

