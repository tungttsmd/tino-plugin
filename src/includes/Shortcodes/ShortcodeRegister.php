<?php

namespace Includes\Shortcodes;

use Includes\Shortcodes\Invoice as ShortcodesInvoice;
use Includes\Shortcodes\Pricing as ShortcodesPricing;
use Includes\Shortcodes\Order as ShortcodesOrder;
use Includes\Shortcodes\Confirm as ShortcodesConfirm;

class ShortcodeRegister
{
    public function __construct()
    {
        add_shortcode('webo_bang_gia', [$this, 'shortcodePricing']);
        add_shortcode('webo_dang_ky', [$this, 'shortcodeOrder']);
        add_shortcode('webo_hoa_don', [$this, 'shortcodeInvoice']);
        add_shortcode('webo_dat_hang', [$this, 'shortcodeConfirm']);
    }
    function shortcodePricing()
    {
        $pricing = new ShortcodesPricing();
        return $pricing->render();
    }
    function shortcodeOrder()
    {
        ob_start();
        $order = new ShortcodesOrder();
        return ob_get_clean();
    }
    function shortcodeInvoice()
    {
        ob_start();
        $invoice = new ShortcodesInvoice();
        return ob_get_clean();
    }
    function shortcodeConfirm()
    {
        ob_start();
        $confỉrm = new ShortcodesConfirm();
        return ob_get_clean();
    }
}
