<?php 
require (dirname(plugin_dir_path(__FILE__)) . '/config.php');
$height = 48 + 42 * $config_rowTable;
echo '<iframe src="' . dirname(plugin_dir_url(__FILE__)) . '/views/widget_pricing.php' . '" width="100%" height="' . $height . 'px" style="border:none;"></iframe>';
