<?php

/**
 * 这里可以放一些安装模块时需要执行的代码，比如新建表，新建目录、文件之类的
 */

/* 下面的代码不是必需的，只是作为示例 */
$filename = ROOT_PATH . '/data/datacall.inc.php';
file_put_contents($filename, "<?php return array(); ?>");

$db=&db();
$db->query("CREATE TABLE `ecm_dazhuanpan` (
  `id` int(10) NOT NULL auto_increment,
  `title` varchar(100) NOT NULL,
  `zhizhen` int(10) NOT NULL,
  `gailv` int(10) NOT NULL,
  `num` int(10) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");


$db->query("CREATE TABLE `ecm_dazhuanpan_log` (
  `id` int(10) NOT NULL auto_increment,
  `userid` int(10) NOT NULL,
  `is_zhong` int(10) NOT NULL,
  `jiangpin_id` int(10) NOT NULL,
  `is_fangfa` int(12) NOT NULL,
  `time` int(10) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1;");


?>