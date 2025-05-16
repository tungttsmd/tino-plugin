<?php
# Load file cấu hình
require(dirname(dirname(plugin_dir_path(__FILE__))) . '/system/autoload.php');

# Lấy dữ liệu
$configData = [
    $_POST['domain'] ?? '',
    $config_nameservers,
    $config_username,
    $config_password
];

# Khởi tạo, nén dữ liệu
$action = OrderAction::make()
    ->orderInit(...$configData);

# Giải nén dữ liệu
extract($action); # $color, $widget, $nameserver, $auth, $msg, $flag đều nằm đây

$programData = [
    $widget_data,
    $nameservers,
    $auth,
    $config_nameservers,
    $msg,
    $color
];
# Xử lý và thực thi chương trình
OrderController::make()->run(...$programData);
