<?php
class QrcodeApp extends MallbaseApp {//业务
    function index() {
        import('phpqrcode');
        $value = $_GET['url'];
        $errorCorrectionLevel = "L";
        $matrixPointSize = "4";
		QRcode::png($value,false,'L',"10",1,true);  
        exit;
    }

}
?>