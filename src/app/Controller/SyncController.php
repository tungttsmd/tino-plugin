<?php

namespace Controller;

use Helper\Maker;
use Model\Contact;
use Model\Domain;
use Model\Invoice;
use Model\Order;
use stdClass;

class SyncController
{
    use Maker;

    /** Tất cả các controller có chức năng xử lí logic kéo render và view() cơ bản */
    public function renderOrderControl()
    {
        if (!isset($_GET['tab'])) {
            return view('layout/layout1.php', [], true);
        }
        $tab = $_GET['tab'];

        switch ($tab) {
            case 'contact':
                return $this->contactPanelRender();
            case 'order':
                return $this->orderPanelRender();
            default:
                return "Vui lòng nhập đúng panel tab";
        }
    }
    public function renderInvoiceControl()
    {
        if (isset($_GET['invoice']) && !empty($_GET['invoice'])) {
            $invoice_html = $this->invoiceRender($_GET['invoice']);
            if (empty($invoice_html)) {
                return "Không tìm thấy ID hoá đơn này";
            } else {
                return $invoice_html;
            }
        } else {
            return "URL trang hoá đơn không đúng";
        }
    }
    public function renderConfirmControl()
    {
        // Xoá khi có thể (chỉ test) DASHBOARD
        $session_domain_name = session_get("tino_inspect_save._100_status_anti_csrf.domain_name") ?? null;
        $session_domain_total = session_get("tino_inspect_save._100_status_anti_csrf.domain_total") ?? null;
        if ($session_domain_name && $session_domain_total) {
            $data = [
                'domain_name' => $session_domain_name,
                'domain_total' => $session_domain_total,
            ];
            return view("form/contactConfirm.php", ["data" => std($data)], true);
        } else {
            return "Thông tin domain đặt hàng không hợp lệ";
        }
    }
    public function renderPricingControl()
    {
        // Trường hợp view là iframe đặc biệt, không thể dùng hàm view để kéo dữ liệu cho người dùng
        $tableHeight = 102 + 42 * CONFIG_TABLE_HEIGHT;
        $iframeSrc = plugins_url('src/resource/view/print/pricing.php', dirname(__FILE__, 3)); // Tạo URL đúng cho file widget_pricing.php
        return '<iframe id="myIframe" src="' . $iframeSrc . '" width="100%" style="height: ' . $tableHeight . 'px; border: none;"></iframe>';
    }

    /**
     * Kéo dữ liệu contact panel
     * 
     * @return string HTML Contact Panel
     */
    public function contactPanelRender()
    {
        if (isset($_GET['detail'])) {
            $getData = std(Contact::make()->fetchContactDetail($_GET['detail']));
            $data = $getData->contact;
            $data->client_id = Contact::make()->getClientIdByAccessId($data->id);
            return view("panel/contactDetail", ["data" => $data], true);
        };
        $getData = std(Contact::make()->fetchContactList());
        $data = $getData->contacts;
        return view("panel/contactList", ["data" => $data], true);
    }

    /**
     * Kéo dữ liệu order panel
     * 
     * @return string HTML Order Panel
     */
    public function orderPanelRender()
    {
        if (isset($_GET['detail'])) {
            $getData = std(Order::make()->fetchOrderDetail($_GET['detail']));
            $getContact = std(Order::make()->getOrderContactById($_GET['detail']));
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
            return view("panel/orderDetail.php", ["data" => $data], true);
        }
        $data = new stdClass;
        $getData = std(Order::make()->fetchOrderList());
        foreach ($getData->domains as $key => $item) {
            $data->{$key} = $item;
            $data->{$key}->tld = substr($item->name, strpos($item->name, "."));
        };
        return view("panel/orderList.php", ["data" => $data], true);
    }

    /**
     * Kéo dữ liệu print invoice
     * 
     * @return string
     */
    public function invoiceRender($invoice_id): string
    {
        $invoiceModel = new Invoice;
        $invoiceDetail = $invoiceModel->getInvoiceById($invoice_id);
        if (isset($invoiceDetail->status) && $invoiceDetail->status === "Unpaid") {
            $orderModel = new Order();
            $orderDetail = $orderModel->fetchOrderDetail($invoiceDetail->items[0]->item_id)->details;
            $orderContact = $orderModel->getOrderContactById($invoiceDetail->items[0]->item_id);
            $data = std($invoiceDetail);
            $data->client = $orderContact->contact_info->registrant; // Không sử dụng thông tin liên hệ của hoá đơn, vì không phản ánh đúng
            $data->domain_id = $orderDetail->id;
            $data->domain_name = $orderDetail->name;
            unset($data->items);
            unset($data->discounts);
            return view("print/invoice.php",   ["data" => $data], true);
        } elseif (isset($invoiceDetail->status) && $invoiceDetail->status === "Cancelled") {
            return "Hoá đơn đã bị huỷ";
        } elseif (isset($invoiceDetail->status) && $invoiceDetail->status === "Paid") {
            return "Hoá đơn đã được thanh toán";
        } else {
            return "Đã xảy ra lỗi, vui lòng quay lại sau! Hoặc liên hệ bộ phận hỗ trợ để khắc phục sớm nhất!";
        }
    }
}
