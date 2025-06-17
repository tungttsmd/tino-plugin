<?php

namespace Service;

use Helper\Maker;
use Model\Domain;
use Model\DummyAPI;
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
            $modelOrder = Order::make();
            $modelDomain = Domain::make();
            $getData = std($modelOrder->fetchOrderDetail($request));
            $order_id = $getData->details->id;
            $getContact = std($modelOrder->getOrderContactById($getData->details->name));
            $ekycUrl = $modelOrder->getEkycUrl($order_id);
            $getTotal = std($modelDomain->lookup($order_id));
            $documents = $modelOrder->getDocuments($order_id);
            $data = std([
                "order_id" => $order_id,
                "payment" => $getData->details->status,
                "order_date" => $getData->details->date_created,
                "domain_name" => $getData->details->name,
                "domain_price" => $getTotal->tld === ".vn" ? "450000" : $getTotal->periods->{'0'}->register,
                "nameservers" => $getData->details->nameservers,
                "contact" => $getContact->contact_info,
                "ekyc_url" => $ekycUrl,
                "ekyc_verify" => std($modelOrder->getDocumentUploaded($order_id))->{15}->isUpload,
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
