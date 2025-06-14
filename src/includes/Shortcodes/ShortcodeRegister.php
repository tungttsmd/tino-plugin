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
        echo SyncController::make()->renderPricingControl();
    }
    function webo_dang_ky()
    {
        echo SyncController::make()->renderOrderControl();
    }
    function webo_hoa_don()
    {
        echo SyncController::make()->renderInvoiceControl();
    }
    function webo_dat_hang()
    {
        echo SyncController::make()->renderConfirmControl();
    }
}
