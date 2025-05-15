<?php
class OrderController
{
    use BaseService;

    public function run($widget_data, $nameservers, $auth, $config_nameservers, $msg, $color)
    {

        if (!isset($_POST['button']) || empty($_POST['button'])) {
            $_POST['button'] = "orderOther";
        };
        // Ajax send $_POST ajaxConfirm and domainInput together

        if (!isset($_POST['ajaxConfirm']) && !isset($_GET['invoice'])) {

            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                OrderAction::make()
                    ->orderFormDraw($widget_data, $msg, $color);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderOther')) {
                OrderAction::make()
                    ->orderFormDraw($widget_data, $msg, $color);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderNew')) {
                OrderAction::make()
                    ->orderNew($_POST['domain'] ?? '', $nameservers, $auth, $widget_data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderConfirm') {
                OrderAction::make()
                    ->orderConfirm($nameservers, $auth, $widget_data);
            } elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderPayment') {
                OrderAction::make()
                    ->orderPayment($_POST['domain'] ?? '', $config_nameservers, $auth, $widget_data);
            }
        } elseif (isset($_POST['ajaxConfirm']) && !isset($_GET['invoice'])) {
            $dangnhap = new Login($auth->username, $auth->password);
            $dangkytenmien = new Domain($dangnhap->getToken());
            $hoadon = new Invoice($dangnhap->getToken());
            $orderID = OrderService::make()
                ->get_orderID_by_domainName($dangkytenmien, $_POST['domainInput']);
            $invoiceID = OrderService::make()
                ->get_order_invoice_id_by_comparing_scan($hoadon, $orderID);
            return $invoiceID;
        } else {
            $dangnhap = new Login($auth->username, $auth->password);
            $hoadon = new Invoice($dangnhap->getToken());
            echo InvoiceService::make()->draw_invoice($hoadon, $_GET['invoice']);
        }
    }
}
