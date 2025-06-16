<?php

namespace Service;

use Helper\Maker;
use Model\Invoice;
use Model\Order;

class InvoiceService
{
    use Maker;

    /**
     * Kéo dữ liệu print invoice
     * 
     * @return mixed
     */
    public function invoice($request)
    {
        $data = Invoice::make()->getInvoiceById($request);
        if (isset($data->status) && $data->status === "Unpaid") {
            $orderModel = new Order();
            $orderDetail = $orderModel->fetchOrderDetail($data->items[0]->item_id)->details;
            $orderContact = $orderModel->getOrderContactById($data->items[0]->item_id);
            $data = std($data);
            $data->client = $orderContact->contact_info->registrant; // Không sử dụng thông tin liên hệ của hoá đơn, vì không phản ánh đúng
            $data->domain_id = $orderDetail->id;
            $data->domain_name = $orderDetail->name;
            unset($data->items);
            unset($data->discounts);
            return $data; // Mixed data
        } elseif (isset($data->status) && $data->status === "Cancelled") {
            return "Hoá đơn đã bị huỷ";
        } elseif (isset($data->status) && $data->status === "Paid") {
            return "Hoá đơn đã được thanh toán";
        } else {
            return "Đã xảy ra lỗi, vui lòng quay lại sau! Hoặc liên hệ bộ phận hỗ trợ để khắc phục sớm nhất!";
        }
    }
    /**
     * Kéo dữ liệu invoice panel
     * 
     * @return mixed HTML Invoice Panel
     */
    public function invoicePanel($request = null)
    {
        if (!$request) {
            $data = Invoice::make()->fetchInvoices();
            return $data;
        }
        // Lấy thông tin hóa đơn
        $invoice = Invoice::make()->fetchInvoiceById($request);

        // Lấy thông tin liên hệ từ đơn hàng
        $orderId = $invoice->invoice->items[0]->item_id;
        $contactInfo = Order::make()->getOrderContactById($orderId)->contact_info;

        // Tạo đối tượng $data để render view
        $data = new \stdClass();
        $data->client = $contactInfo;
        $data->invoice_id = $invoice->invoice->id;
        $data->invoice_status = $invoice->invoice->status;
        $data->invoice_paid_date = $invoice->invoice->datepaid;
        $data->invoice_payment = $invoice->transactions[0] ?? '';
        $data->order_id = $orderId;
        $data->invoice_total = $invoice->invoice->total;

        // Gộp pricing nhiều dòng giống nhau cho đủ 3 mục
        $data->pricing = new \stdClass();
        for ($i = 0; $i < 3; $i++) {
            $data->pricing->{$i} = [
                'description' => $invoice->invoice->items[0]->description,
                'amount' => $invoice->invoice->items[0]->amount
            ];
        }
        return $data;
    }
}
