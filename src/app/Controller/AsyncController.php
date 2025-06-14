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
    public function domainToOrder($domainName, $contactAccessId, $nameservers)
    {
        $domain = new Domain();
        /**
         * Có 3 loại contact id.
         * - Access id: dùng để lấy parent_id, client_id và fetch toàn bộ thông tin liên hệ
         * - Client id: dùng để thao tác đặt hàng và gắn vào đơn hàng
         *      + registrant: chủ thể sở hữu tên miền (liên quan tới sở hữu) ---> phải đặt theo khách hàng đăng ký
         *      + billing: thông tin người thanh toán ---> phải đặt theo khách hàng đăng ký
         *      + tech: thông tin kỹ thuật viên về tên miền (custom) ---> đặt theo webo.vn của bản thân mình (giúp khách kỹ thuật)
         *      + admin: thông tin người quản trị tên miền ---> đặt theo webo.vn của bản thân mình (giúp khách quản trị)
         * - Parent id: giống như client id nhưng là thông tin của chủ tài khoản đặt mua hộ tên miền
         */
        $orderInfo = $domain->domainToOrder($domainName, $contactAccessId, json_decode(stripslashes($nameservers)));
        $json = [
            'success' => true,
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
    public function invoiceStatusChecker($invoice_checker_id)
    {
        $invoice = new Invoice();
        $invoiceStatus = $invoice->getPaymentStatus($invoice_checker_id);
        $json = [
            'success' => true,
            'json' => ["status" => $invoiceStatus->status],
        ];
        return $json;
    }
}
