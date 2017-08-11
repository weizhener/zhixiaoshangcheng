<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />

<meta name="apple-mobile-web-app-capable" content="yes" />

<meta name="apple-mobile-web-app-status-bar-style" content="black" />

<?php echo $this->_var['page_seo']; ?>

<link href="<?php echo $this->res_base . "/" . 'css/global.css'; ?>" type="text/css" rel="stylesheet" />

<link href="<?php echo $this->res_base . "/" . 'css/user.css'; ?>?v=1.2" type="text/css" rel="stylesheet" />

<script type="text/javascript" src="index.php?act=jslang"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'jquery.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'ecmall.js'; ?>" charset="utf-8"></script>

<script type="text/javascript" src="<?php echo $this->lib_base . "/" . 'member.js'; ?>" charset="utf-8"></script>

<script type="text/javascript">

//<!CDATA[

var SITE_URL = "<?php echo $this->_var['site_url']; ?>";

var REAL_SITE_URL = "<?php echo $this->_var['real_site_url']; ?>";

var PRICE_FORMAT = '<?php echo $this->_var['price_format']; ?>';

//]]>



</script>

<?php echo $this->_var['_head_tags']; ?>

</head>