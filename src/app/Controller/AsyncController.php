<?php

namespace Controller;

use Action\RenderAction;
use Helper\Maker;
use Helper\Tool;
use Model\Contact;
use Model\Domain;
use Model\Invoice;

class AsyncController
{
    use Maker;
    public function invoiceIdLookup($domainName)
    {
        $domain = new Domain();
        $invoice = new Invoice();
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
    public function domainInspect($domainName)
    {
        $domain = new Domain();
        $inspectInfo = $domain->domainInspect($domainName);
        $html = RenderAction::make()->inspectFormRender();
        $json = [
            'success' => true,
            'html' => $html,
            'json' => $inspectInfo
        ];
        return $json;
    }
    public function domainToOrder($domainName, $nameservers)
    {
        $domain = new Domain();
        $orderInfo = $domain->domainToOrder($domainName, $nameservers);
        $html = RenderAction::make()->inspectFormRender();
        $json = [
            'success' => true,
            'html' => $html,
            'json' => $orderInfo
        ];
        return $json;
    }
    public function contactCreateNew($contactForm)
    {
        $contact = new Contact();
        $contactStatusPackage = $contact->createNew($contactForm);
        $json = [
            'success' => true,
            'json' => $contactStatusPackage,
        ];
        return $json;
    }
}
