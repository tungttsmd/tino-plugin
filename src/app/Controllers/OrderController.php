<?php

namespace App\Controllers;

use Action\RenderAction;
use App\Actions\OrderAction;
use Helper\Maker;

class OrderController
{
    use Maker;

    public function run($widget_data, $nameservers, $auth, $config_nameservers, $msg, $color)
    {
        OrderAction::make()->orderFormDraw($widget_data, $msg, $color);
    }
    public function panel()
    {
        if (isset($_GET['tab']) && $_GET['tab'] === "contact") {
        }
    }
}
