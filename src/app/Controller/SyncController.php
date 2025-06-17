<?php

namespace Controller;

use Helper\Maker;
use Helper\Request;
use Service\ConfirmService;
use Service\InvoiceService;

class SyncController
{
    use Maker;
    private $request;

    public function __construct()
    {
        $this->request = Request::make();
    }
    /** Tất cả các controller có chức năng xử lí logic kéo render và view() cơ bản */
    public function domainInspect()
    {
        return view('layout/layout_form.php', [], true);
    }
    public function invoice()
    {
        $request = $this->request->get("invoice");

        if (!$request) {
            return "URL trang hoá đơn không đúng";
        }

        $data = InvoiceService::make()->invoice($request);

        // Nếu service trả về thông báo lỗi dạng chuỗi
        if (is_string($data)) {
            return $data;
        }

        // Nếu service trả về data mixed, hợp lệ để truyền vào view để render HTML
        return view("print/invoice.php",   ["data" => $data], true);
    }
    public function confirm()
    {
        $data = ConfirmService::make()->confirm();

        if ($data) {
            return view("form/contactConfirm.php", ["data" => std($data)], true);
        } else {
            return "Thông tin domain đặt hàng không hợp lệ";
        }
    }
    public function pricing()
    {
        // Trường hợp view là iframe đặc biệt, không thể dùng hàm view để kéo dữ liệu cho người dùng
        $tableHeight = 122 + 42 * CONFIG_TABLE_HEIGHT;
        $iframeSrc = plugins_url('src/resource/view/print/pricing.php', dirname(__FILE__, 3)); // Tạo URL đúng cho file widget_pricing.php
        return '<iframe id="myIframe" src="' . $iframeSrc . '" width="100%" style="height: ' . $tableHeight . 'px; border: none;"></iframe>';
    }
}
