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
    function webo_bang_gia()
    {
        echo SyncController::make()->pricing();
    }
    function webo_dang_ky()
    {
        echo SyncController::make()->domainInspect();
    }
    function webo_hoa_don()
    {
        //Panel Render For Testing
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
