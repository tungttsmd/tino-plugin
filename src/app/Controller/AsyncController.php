<?php

namespace Controller;

use Helper\Maker;
use Model\Contact;
use Model\Domain;
use Model\Invoice;

class AsyncController
{
    use Maker;
    public function fetchDomainInspect()
    {
        $json = Domain::make()->domainInspect($_POST['domain']);
        $html = view("form/domainInspect.php", [], true);
        return [
            'success' => true,
            'html' => $html,
            'json' => $json
        ];
    }
    public function fetchDomainToOrder()
    {
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
        $data_nameservers = json_decode(stripslashes($_POST['nameservers']));
        $json = Domain::make()->domainToOrder($_POST['domain'], $_POST['contact_id'], $data_nameservers);
        return [
            'success' => true,
            'json' => $json
        ];
    }
    public function fetchContactCreate()
    {
        // Dữ liệu trả về là một json đã bị encode 2 lần, 1 submit form encode (URLparams...) và 1 json string (javascript) endcode
        $data_contact = json_decode(stripslashes($_POST['contactInfoPackage']), true);
        $json = Contact::make()->createNew($data_contact);
        return [
            'success' => true,
            'json' => $json,
        ];
    }
    public function fetchInvoiceInspect()
    {
        $data_invoice = Invoice::make()->getPaymentStatus($_POST['invoice_checker_id']);
        $json = [
            "status" => $data_invoice->status
        ];
        return [
            'success' => true,
            'json' => $json,
        ];
    }
}
