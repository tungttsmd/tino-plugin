<?php
# CHỨC NĂNG ĐĂNG KY -> THANH TOÁN DOMAIN
function core_autoload()
{
    include_once(betterPath(__FILE__, 1) . 'system/ApiClient.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Login.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Domain.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Invoice.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Tld.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Pricing.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Ticket.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Config.php');
}
function debug_0()
{
    # Tắt mở debug bằng cách thêm ?debug ở url
    if (isset($_GET['debug'])) {
        if (!betterEmpty_list($_POST)) {
            echo 'DEBUG: DỮ LIỆU $_POST<br>';
            var_dump($_POST);
        }
    }
}
function debug_1($data)
{
    # Tắt mở debug bằng cách thêm ?debug ở url
    if (isset($_GET['debug'])) {
        echo 'DEBUG: PHẢN HỒI API CỦA ORDER NEW';
        var_dump($data);
    }
}
function alert($content, $type = 'warning')
{
    $msg = $content;
    $color = '';
    switch ($type) {
        case 'warning':
            $color = '#fff3cd';
            $text = '#664d03';
            break;
        case 'success':
            $color = '#d4edda';
            $text = '#198754';
            break;
        case 'danger':
            $color = '#f8d7da';
            $text = 'dc3545';
            break;
        case 'info':
            $color = '#d1ecf1';
            $text = '664d03';
            break;
        default:
            $color = '#ffc107';
            $text = '664d03';
    }
    include(betterPath(__FILE__, 1) . 'views/widget_alert.php');
}
function import_core_data(string $nameservers)
{
    return betterStd([
        'domain' => trim($_POST['domain'] ?? ''),
        'nameservers' => $nameservers,
    ]);
}
function get_order_invoice_id_by_comparing_scan(object $invoiceObject, $order_domain_id)
{
    foreach ($invoiceObject->listId() as $value) {
        if ($order_domain_id === $invoiceObject->fetch($value)->invoice->items->{0}->item_id) {
            return $value;
        };
    };
    return null;
}
function orderNew_form()
{
    include(betterPath(__FILE__, 1) . 'views/widget_orderNew.php');
}
function orderConfirm_form()
{
    include(betterPath(__FILE__, 1) . 'views/widget_orderConfirm.php');
}

function orderPayment_form()
{
    include(betterPath(__FILE__, 1) . 'views/widget_orderPayment.php');
}
function get_orderID_by_domainName(object $domainObject, $domainName)
{
    return $domainObject->fetchByName($domainName)->domains->{0}->id;
}
function get_orderID_by_invoice(object $invoiceObject, int $id) {
    return $invoiceObject->fetch($id)->invoice->items->{0}->item_id;
}
function draw_invoice(object $invoiceObject, $order_invoice_id)
{

    # Vẽ tổng quan đơn hàng
    $original_invoice_html = $invoiceObject->fetchHtml($order_invoice_id);
    $cut_pos = strpos($original_invoice_html, 'Thông tin chuyển khoản ngân hàng');
    $invoice_html = substr($original_invoice_html, 0, $cut_pos);

    # Xoá dòng style body ngu ngốc bằng cách ghi đè <style>
    echo $invoice_html. "<style>body {width:auto;}</style>";

    # Truyền thủ công thêm dữ liệu cho widget để tạo nút bấm Thanh toán
    $_POST['widget']->button = new stdClass();
    $_POST['widget']->button->VNPayHref = $invoiceObject->paymentVNPayHref($order_invoice_id);
    $_POST['widget']->button->MomoHref = $invoiceObject->paymentMomoHref($order_invoice_id);

    # Nhúng nút Thanh toan
    include(betterPath(__FILE__, 1) . 'views/widget_paymentButton.php');

    # Kết thúc luồng (Đặt hàng -> Thanh toán)
}

# CHỨC NĂNG IN BẢNG GIÁ
function pricing()
{
    $pricing = new Pricing();
    return $pricing->draw();
}
