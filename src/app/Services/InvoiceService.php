<?php
namespace App\Services;

use Helper\Maker;

class InvoiceService extends DrawService
{
    use Maker;

    public function draw_invoice(object $invoiceObject, $order_invoice_id)
    {

        # Vẽ tổng quan đơn hàng
        $original_invoice_html = $invoiceObject->fetchHtml($order_invoice_id);

        if (!empty($original_invoice_html)) {
            $cut_pos = strpos($original_invoice_html, 'Thông tin chuyển khoản ngân hàng');
            $invoice_html = substr($original_invoice_html, 0, $cut_pos);

            $widgetInvoice = [];
            # Truyền thủ công thêm dữ liệu cho widget để tạo nút bấm Thanh toán
            $widgetInvoice['button']['VNPayHref'] = $invoiceObject->paymentVNPayHref($order_invoice_id);
            $widgetInvoice['button']['MomoHref'] = $invoiceObject->paymentMomoHref($order_invoice_id);

            # Nhúng nút Thanh toan
            $widget = betterStd($widgetInvoice);

            ob_start();
            # Xoá dòng style body ngu ngốc bằng cách ghi đè <style>
            echo $invoice_html . "<style>body {width:auto;}</style>";
            include(betterPath(__FILE__, 2) . 'views/widget_paymentButton.php');
            return ob_get_clean();
        } else {
            return null;
        }

        # Kết thúc luồng (Đặt hàng -> Thanh toán)
    }
}
