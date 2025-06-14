<?php

namespace Action;

use Service\InvoiceService;
use Helper\Maker;
use Helper\Tool;
use Model\Domain;
use Model\Invoice;
use Model\Order;
use Service\ContactService;

class RenderAction
{
    use Maker;
    public function layoutRender()
    {
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/layout.php';
        return ob_get_clean();
    }
    public function inspectFormRender()
    {
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/inspectForm.php';
        return ob_get_clean();
    }
    public function invoiceRender($invoice_id)
    {

        $invoiceModel = new Invoice;
        $invoiceDetail = $invoiceModel->getInvoiceById($invoice_id);
        if (isset($invoiceDetail->status) && $invoiceDetail->status === "Unpaid") {
            $orderModel = new Order();
            $orderDetail = $orderModel->fetchOrderDetail($invoiceDetail->items[0]->item_id)->details;
            $orderContact = $orderModel->getOrderContactById($invoiceDetail->items[0]->item_id);
            $data = Tool::make()->oopstd($invoiceDetail);
            // Không sử dụng thông tin liên hệ của hoá đơn, vì không phản ánh đúng
            $data->client = $orderContact->contact_info->registrant;
            $data->domain_id = $orderDetail->id;
            $data->domain_name = $orderDetail->name;
            unset($data->items);
            unset($data->discounts);
            ob_start();
            include dirname(__DIR__, 3) . '/src/app/Views/invoicePrint.php';
            return ob_get_clean();
        } elseif (isset($invoiceDetail->status) && $invoiceDetail->status === "Cancelled") {
            return "Hoá đơn đã bị huỷ";
        } elseif (isset($invoiceDetail->status) && $invoiceDetail->status === "Paid") {
            /**
             * @var * Test
             */
            $orderModel = new Order();
            $orderDetail = $orderModel->fetchOrderDetail($invoiceDetail->items[0]->item_id)->details;
            $orderContact = $orderModel->getOrderContactById($invoiceDetail->items[0]->item_id);
            $data = Tool::make()->oopstd($invoiceDetail);
            // Không sử dụng thông tin liên hệ của hoá đơn, vì không phản ánh đúng
            $data->client = $orderContact->contact_info->registrant;
            $data->domain_id = $orderDetail->id;
            $data->domain_name = $orderDetail->name;
            unset($data->items);
            unset($data->discounts);
            ob_start();
            include dirname(__DIR__, 3) . '/src/app/Views/invoicePrint.php';
            return ob_get_clean();
            /**
             * @var * Test
             */
            // return "Hoá đơn đã được thanh toán";
        } else {
            return "Đã xảy ra lỗi, vui lòng quay lại sau! Hoặc liên hệ bộ phận hỗ trợ để khắc phục sớm nhất!";
        }
    }
    public function confirmForm($data)
    {
        $data = Tool::make()->oopstd($data);
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/confirmForm.php';
        return ob_get_clean();
    }
    public function contactListRender($data)
    {
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/contactPanel.php';
        return ob_get_clean();
    }
    public function contactDetailRender($data)
    {
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/contactPanelItemDetail.php';
        return ob_get_clean();
    }
    public function orderListRender($data)
    {
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/orderPanel.php';
        return ob_get_clean();
    }
    public function orderDetailRender($data)
    {
        ob_start();
        include dirname(__DIR__, 3) . '/src/app/Views/orderPanelItemDetail.php';
        return ob_get_clean();
    }
}
