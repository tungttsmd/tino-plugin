<?php

namespace App\Controllers;

use App\Helper\BaseService;
use Model\Domain;
use Model\Invoice;

class AjaxController
{
    use BaseService;
    public function invoiceLookup($accessToken, $domainName)
    {
        $domain = new Domain($accessToken);
        $invoice = new Invoice($accessToken);
        $orderID = $domain->getOrderIdByName($domainName);

        // Phía server https://my.tino.vn/api nếu tìm kiếm hoá đơn lần đầu sẽ trả null -> kiểm tra thêm 2 lần để fix lỗi này
        $retry = 0;
        $invoiceId = null;
        while ($retry < 2) {
            $invoiceId = $invoice->getInvoiceIdByOrderId($orderID);
            if ($invoiceId !== null) {
                break;
            }
            $retry++;
        }
        return $invoiceId;
    }
    public function domainInspect($accessToken, $domainName, $nameservers)
    {
        $domain = new Domain($accessToken);
        $inspectInfo = $domain->domainInspect($domainName);
        return $inspectInfo; // session_inspect_save
    }
    public function domainToOrder($accessToken, $domainName, $nameservers)
    {
        $domain = new Domain($accessToken);
        $orderInfo = $domain->toOrder($domainName, $nameservers);
        return $orderInfo; // session_order_save
    }
}
