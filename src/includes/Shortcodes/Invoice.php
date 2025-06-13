<?php

namespace Includes\Shortcodes;

use Action\RenderAction;

class Invoice
{
    public function __construct()
    {
        if (isset($_GET['invoice']) && !empty($_GET['invoice'])) {
            $invoice_html = RenderAction::make()->invoiceRender($_GET['invoice']);
            if (empty($invoice_html)) {
                echo "Không tìm thấy ID hoá đơn này";
            } else {
                echo $invoice_html;
            }
        } else {
            echo "URL trang hoá đơn không đúng";
        }
    }
}
