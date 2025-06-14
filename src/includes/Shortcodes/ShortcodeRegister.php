<?php

namespace Includes\Shortcodes;

use Includes\Shortcodes\Invoice as ShortcodesInvoice;
use Includes\Shortcodes\Pricing as ShortcodesPricing;
use Includes\Shortcodes\Order as ShortcodesOrder;
use Includes\Shortcodes\Confirm as ShortcodesConfirm;
use Includes\Shortcodes\Panel as ShortcodesPanel;

class ShortcodeRegister
{
    public function __construct()
    {
        add_shortcode('webo_bang_gia', [$this, 'shortcodePricing']);
        add_shortcode('webo_dang_ky', [$this, 'shortcodeOrder']);
        add_shortcode('webo_hoa_don', [$this, 'shortcodeInvoice']);
        add_shortcode('webo_dat_hang', [$this, 'shortcodeConfirm']);
        add_shortcode('webo_domain_panel', [$this, 'shortcodePanel']);
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
        $confirm = new ShortcodesConfirm();
        return ob_get_clean();
    }
    function shortcodePanel()
    {
        ob_start();
        $dashboard = new ShortcodesPanel();
        return ob_get_clean();
    }
}
