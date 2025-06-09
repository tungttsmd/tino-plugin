<?php

namespace Includes\Shortcodes;

use App\Actions\OrderAction;
use App\Controllers\OrderController;


class Order
{
    public function __construct()
    {
        # Load file cấu hình
        require PLUGIN_PATH . 'src/system/autoload.php';

        # Lấy dữ liệu
        $configData = [
            $_POST['domain'] ?? '',
            CONFIG_NAMESERVERS,
            CONFIG_USERNAME,
            CONFIG_PASSWORD
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
            CONFIG_NAMESERVERS,
            $msg,
            $color
        ];
        # Xử lý và thực thi chương trình
        OrderController::make()->run(...$programData);
    }
}
