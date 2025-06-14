<?php

namespace Model;

use Helper\Session;
use Repository\ApiClient;

class Invoice extends ApiClient
{

    // Constructor
    public function __construct()
    {
        $auth = new Auth(CONFIG_USERNAME, CONFIG_PASSWORD);
        parent::__construct($auth->token());
        Session::make();
    }

    // Get
    public function fetchInvoices()
    {
        // Lấy toàn bộ thông tin của toàn bộ invoice
        $endpoint = "invoice";
        $response = $this->call($endpoint, 'get');
        return $response->invoices;
    }
    public function fetchInvoiceById(string|int|float $invoiceId)
    {
        $endpoint = "invoice/" . (int) $invoiceId;
        $response = $this->call($endpoint, "get");
        return $response;
    }

    public function invoiceIdListing()
    {
        // Lấy danh sách toàn bộ id invoice trong giỏ hàng
        $list = [];
        $invoiceIdList = $this->fetchInvoices();
        foreach ($invoiceIdList as $number => $invoiceId) {
            $list[] = $invoiceId->id;
        }
        return $list;
    }
    public function fetchInvoiceByOrderId(string|int|float $orderId)
    {
        $orderId = (string) $orderId;
        $invoiceID = $this->getInvoiceIdByOrderId($orderId);
        $invoiceDetail = $this->getInvoiceById($invoiceID);
        return $invoiceDetail;
    }
    public function getPaymentStatus(string|int|float $invoiceId)
    {
        return $this->fetchInvoiceById($invoiceId)->invoice;
    }
    public function getInvoiceIdByOrderId(string|int|float $orderId)
    {
        $orderID = (string) $orderId;
        foreach ($this->invoiceIdListing() as $invoiceId) {
            $orderIdByInvoiceId = $this->getOrderIdByInvoiceId($invoiceId);
            if (!is_null($orderIdByInvoiceId)) {
                if ($orderIdByInvoiceId === $orderID) {
                    return $invoiceId;
                }
            }
        }
        return null;
    }
    public function getInvoiceById(string|int|float $invoiceId)
    {
        $endpoint = "invoice/" . (int) $invoiceId;
        $response = $this->call($endpoint, "get");
        return $response->invoice;
    }
    public function getOrderIdByInvoiceId(string|int|float $invoiceId)
    {
        $detail = $this->getInvoiceById($invoiceId);
        if ($detail) {
            return $detail->items[0]->item_id;
        }
        return null;
    }
}
