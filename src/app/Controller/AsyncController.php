<?php

namespace Controller;

use Helper\Maker;
use Helper\Request;
use Model\Contact;
use Model\Domain;
use Model\Invoice;
use Service\ContactService;
use Service\InvoiceService;
use Service\OrderService;

class AsyncController
{
    use Maker;
    private $request;
    public function __construct()
    {
        $this->request = Request::make();
    }
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
    public function fetchTabLoader()
    {
        $request = $this->request->post("tab");
        $query = $this->request->post("detail");

        // Nếu là tab, bật chế độ trang quản lý panel
        switch ($request) {
            case 'contact':
                // Nếu tab contact thì lấy panel contact ra
                if ($query) {
                    $data = ContactService::make()->contactPanel($query);
                    $html = view("panel/contactDetail", ["data" => $data], true);
                    break;
                }
                $data = ContactService::make()->contactPanel();
                $html = view("panel/contactList", ["data" => $data], true);
                break;
            case 'order':
                // Nếu tab order thì lấy panel order ra
                if ($query) {
                    $data = OrderService::make()->orderPanel($query);
                    $html = view("panel/orderDetail.php", ["data" => $data], true);
                    break;
                }
                $data = OrderService::make()->orderPanel();
                $html = view("panel/orderList.php", ["data" => $data], true);
                break;
            case 'invoice':
                // Nếu tab invoice thì lấy panel invoice ra
                if ($query) {
                    $data = InvoiceService::make()->invoicePanel($query);
                    $html = view("panel/invoiceDetail.php", ["data" => $data], true);
                    break;
                }
                $data = InvoiceService::make()->invoicePanel();
                $html = view("panel/invoiceList.php", ["data" => $data], true);
                break;
            default:
                // Nếu tab sai thì cứ lấy form kiểm tra domain ra
                $html = "Không tìm thấy dữ liệu phù hợp";
        }
        return [
            'success' => true,
            'html' => $html,
            'json' => $query
        ];
    }
}
