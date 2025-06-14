<?php

namespace Service;

use Helper\Maker;
use Model\Order;

class OrderService
{
    use Maker;
    private $orderModel;
    private $contactModel;
    public function __construct()
    {
        $this->orderModel = new Order();
    }

    public function fetchOrderList()
    {
        $response = $this->orderModel->fetchOrderList();
        return $response;
    }
}
