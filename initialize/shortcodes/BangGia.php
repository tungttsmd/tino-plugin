<?php
# Load file cấu hình
require(dirname(dirname(plugin_dir_path(__FILE__))) . '/system/autoload.php');
$height = 50 + 42 * $config_rowTable;
echo '<iframe src="' . dirname(dirname(plugin_dir_url(__FILE__))) . '/views/widget_pricing.php' . '" width="100%" height="' . $height . 'px" style="border:none;"></iframe>';
