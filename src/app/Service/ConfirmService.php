<?php

namespace Service;

use Helper\Maker;

class ConfirmService
{
    use Maker;
    public function confirm()
    {
        // Xoá khi có thể (chỉ test) DASHBOARD
        $session_domain_name = session_get("tino_inspect_save._100_status_anti_csrf.domain_name") ?? null;
        $session_domain_total = session_get("tino_inspect_save._100_status_anti_csrf.domain_total") ?? null;
        if ($session_domain_name && $session_domain_total) {
            $data = [
                'domain_name' => $session_domain_name,
                'domain_total' => $session_domain_total,
            ];
            return  $data;
        } else {
            return null;
        }
    }
}
