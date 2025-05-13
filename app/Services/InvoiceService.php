<?php
class InvoiceService extends DrawService
{
    use BaseService;

    public function draw_invoice(object $invoiceObject, $order_invoice_id)
    {
        # Vẽ tổng quan đơn hàng
        $original_invoice_html = $invoiceObject->fetchHtml($order_invoice_id);
        $cut_pos = strpos($original_invoice_html, 'Thông tin chuyển khoản ngân hàng');
        $invoice_html = substr($original_invoice_html, 0, $cut_pos);

        # Xoá dòng style body ngu ngốc bằng cách ghi đè <style>
        echo $invoice_html . "<style>body {width:auto;}</style>";

        $widgetInvoice = [];
        # Truyền thủ công thêm dữ liệu cho widget để tạo nút bấm Thanh toán
        $widgetInvoice['button']['VNPayHref'] = $invoiceObject->paymentVNPayHref($order_invoice_id);
        $widgetInvoice['button']['MomoHref'] = $invoiceObject->paymentMomoHref($order_invoice_id);

        # Nhúng nút Thanh toan
        $widget = betterStd($widgetInvoice);
        include(betterPath(__FILE__, 2) . 'views/widget_paymentButton.php');

        # Kết thúc luồng (Đặt hàng -> Thanh toán)
    }
}
