<?php
# Load file cấu hình
require(dirname(plugin_dir_path(__FILE__)) . '/system/autoload.php');

if (isset($_GET['invoice']) && !empty($_GET['invoice'])) {
    $dangnhap = new Login($config_username, $config_password);
    $hoadon = new Invoice($dangnhap->getToken());
    # Xử lý và thực thi chương trình
    $invoice_html = InvoiceService::make()->draw_invoice($hoadon, $_GET['invoice']);
    if (empty($invoice_html)) {
        echo "Không tìm thấy ID hoá đơn này";
    } else {
        echo $invoice_html;
    }
} else {
    echo "URL trang hoá đơn không đúng";
}
