<?php

namespace Model;

class Invoice extends ApiClient
{
    private $invoiceDetailStdClass;

    // Constructor
    public function __construct($accessToken)
    {
        parent::__construct($accessToken);
        Session::make();
        $this->invoiceDetailStdClass = new \stdClass();
    }

    // Get
    public function invoices()
    {
        // Lấy toàn bộ thông tin của toàn bộ invoice
        $endpoint = "invoice";
        $response = $this->call($endpoint, 'get');
        return $response->invoices;
    }
    public function invoiceIds()
    {
        // Lấy danh sách toàn bộ id invoice trong giỏ hàng
        $list = [];
        $invoiceIdList = $this->invoices();
        foreach ($invoiceIdList as $number => $invoiceId) {
            $list[] = $invoiceId->id;
        }
        return $list;
    }
    public function getInvoiceIdByOrderId(string|int|float $orderId)
    {
        $orderID = (string) $orderId;
        foreach ($this->invoiceIds() as $invoiceId) {
            $orderIdByInvoiceId = $this->getOrderIdByInvoiceId($invoiceId);
            if (!is_null($orderIdByInvoiceId)) {
                if ($orderIdByInvoiceId === $orderID) {
                    return $invoiceId;
                }
            }
        }
        return null;
    }
    public function getInvoiceByOrderId(string|int|float $orderId)
    {
        $orderID = (string) $orderId;
        $invoiceID = $this->getInvoiceIdByOrderId($orderId);
        $invoiceDetail = $this->getInvoiceById($invoiceID);
        return $invoiceDetail;
    }
    public function getInvoiceById(string|int|float $invoiceId)
    {
        $endpoint = "invoice/" . (int) $invoiceId;
        $response = $this->call($endpoint, "get");
        return $response->invoice;
    }
    public function getInvoiceHtmlById(string|int|float $id)
    {
        $endpoint = "invoice/" . (int) $id;
        $response = $this->call($endpoint, "get");
        return $response->invoicebody;
    }
    public function getOrderIdByInvoiceId(string|int|float $invoiceId)
    {
        $detail = $this->getInvoiceById($invoiceId);
        if ($detail) {
            return $detail->items[0]->item_id;
        }
        return null;
    }

    public function getHtml()
    {
        // Lấy toàn bộ html vẽ hoá đơn 
        return $this->invoiceDetailStdClass->invoicebody;
    }
    public function getQrCode()
    {
        // Lấy html của QR code ngân hàng
        $strLookup = '<img src="https://tino.vn/api/vietqr?';
        $strHtml = $this->getHtml();
        $strPosStart = strpos($strHtml, $strLookup);
        $strSub = substr($strHtml, $strPosStart);
        $strPosEnd = strpos($strSub, "</td>");
        $strQr = substr($strSub, 0, $strPosEnd);
        return $strQr;
    }
    public function getHtmlWithoutQrCode()
    {
        // Lấy html hoá đơn không bao gồm phần QR code
        $strHtml = $this->getHtml();
        $strLookup = '<p>Thông tin chuyển khoản ngân hàng</p>';
        $strPosStart = strpos($strHtml, $strLookup);
        $strQrCodeBackward = substr($strHtml, $strPosStart);
        $strLen = strlen($strHtml) - strlen($strQrCodeBackward);
        $strHtmlWithoutQrCode = substr($strHtml,  0, $strLen);
        return "String html: " . strlen($strHtml) . " và String Qr " . strlen($strQrCodeBackward) . $strHtmlWithoutQrCode;
    }
    public function getId()
    {
        // Lấy id của hoá đơn
        return $this->invoiceDetailStdClass->invoice->id;
    }

    // Set
    public function invoice(string|int|float $invoiceId)
    {
        // Nạp id hoá đơn để sử dụng
        $this->invoiceDetailStdClass = $this->call("invoice/" . (int) $invoiceId, "get");
        return $this;
    }
}
