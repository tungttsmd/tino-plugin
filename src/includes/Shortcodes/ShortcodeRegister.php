<?php

namespace Includes\Shortcodes;

use Controller\SyncController;

class ShortcodeRegister
{
    public function __construct()
    {
        add_shortcode('webo_bang_gia', [$this, 'webo_bang_gia']);
        add_shortcode('webo_dang_ky', [$this, 'webo_dang_ky']);
        add_shortcode('webo_hoa_don', [$this, 'webo_hoa_don']);
        add_shortcode('webo_dat_hang', [$this, 'webo_dat_hang']);
    }

    /**
     * Hiển thị bảng giá các tên miền
     * 
     * @return void
     */
    function webo_bang_gia()
    {
        echo SyncController::make()->pricing();
    }

    /**
     * Hiển thị form kiểm tra tên miền để mua
     * 
     * @return void
     */
    function webo_dang_ky()
    {
        echo SyncController::make()->domainInspect();
    }

    /**
     * Render shortcode
     * - Mặc định trang domain/hoa-don (tuỳ config) thì sẽ trả trang in hoá đơn tên miền
     * - Đang phát triển: Nếu có ?tab=panel thì sẽ in ra trang quản lý dữ liệu tên miền (panel)
     * - Đang phát triển: Nếu có thêm ...&detail=x thì sẽ lấy ra dữ liệu chi tiết của từng record trong panel
     * 
     * @return void
     */
    function webo_hoa_don()
    {
        $request = $_GET['tab'] ?? null;
        if ($request === "panel") {
            view("layout/layout_panel", []);
        } elseif ($request === "detail") {
            view("layout/layout_detail", []);
        } else {
            echo SyncController::make()->invoice();
        }
    }
    function webo_dat_hang()
    {
        echo SyncController::make()->confirm();
    }
}
