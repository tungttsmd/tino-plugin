<?php

namespace App\Controllers;

use App\Actions\OrderAction;
use App\Helper\BaseService;
use App\Services\InvoiceService;
use App\Services\OrderService;
use model\Invoice;
use models\Domain;
use models\Login;

class OrderController
{
    use BaseService;

    public function run($widget_data, $nameservers, $auth, $config_nameservers, $msg, $color)
    {

        if (!isset($_POST['button']) || empty($_POST['button'])) {
            $_POST['button'] = "orderOther";
        };

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
                ->orderPayment($_POST['domain'] ?? '', CONFIG_NAMESERVERS, $auth, $widget_data);
        }
    }
}
