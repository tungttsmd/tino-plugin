<?php

namespace Includes\Shortcodes;

use Action\RenderAction;

class Confirm
{
    public function __construct()
    {
        // Xoá khi có thể (chỉ test) DASHBOARD
        $session_domain_name = $_SESSION['tino_inspect_save']['_100_status_anti_csrf']['domain_name'] ?? null;
        $session_domain_total = $_SESSION['tino_inspect_save']['_100_status_anti_csrf']['domain_total'] ?? null;
        if ($session_domain_name && $session_domain_total) {
            $data = [
                'domain_name' => $session_domain_name,
                'domain_total' => $session_domain_total,
            ];
            echo RenderAction::make()->confirmForm($data);
        } else {
            echo "Thông tin domain đặt hàng không hợp lệ";
        }
    }
}
