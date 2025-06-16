<?php

namespace Service;

use Helper\Maker;
use Model\Domain;
use Model\Order;

class OrderService
{
    use Maker;
    /**
     * Kéo dữ liệu order panel
     * 
     * @return mixed HTML Order Panel
     */
    public function orderPanel($request = null)
    {
        if ($request) {
            $getData = std(Order::make()->fetchOrderDetail($request));
            $getContact = std(Order::make()->getOrderContactById($request));
            $getTotal = std(Domain::make()->lookup($getData->details->name));
            $data = std([
                "order_id" => $getData->details->id,
                "payment" => $getData->details->status,
                "order_date" => $getData->details->date_created,
                "domain_name" => $getData->details->name,
                "domain_price" => $getTotal->tld === ".vn" ? "450000" : $getTotal->periods->{'0'}->register,
                "nameservers" => $getData->details->nameservers,
                "contact" => $getContact->contact_info,
                "ekyc_info" => $getData->details->ddocs,
            ]);
            return $data;
        }
        $data = new \stdClass;
        $getData = std(Order::make()->fetchOrderList());
        foreach ($getData->domains as $key => $item) {
            $data->{$key} = $item;
            $data->{$key}->tld = substr($item->name, strpos($item->name, "."));
        };
        return $data;
    }
}
