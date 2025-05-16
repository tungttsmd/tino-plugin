<?php
class OrderService extends DrawService
{
    use BaseService;

    public function get_order_invoice_id_by_comparing_scan(object $invoiceObject, $order_domain_id)
    {
        foreach ($invoiceObject->listId() as $value) {
            if ($order_domain_id === $invoiceObject->fetch($value)->invoice->items->{0}->item_id) {
                return $value;
            };
        };
        return null;
    }
    public function orderNew_form()
    {
        $widget = $this->widget();
        include(betterPath(__FILE__, 2) . 'views/widget_orderNew.php');
        if (isset($widget->msg) && !empty($widget->msg)) {
            alert($widget['msg'], $widget['color']);
        };
    }

    public function orderConfirm_form()
    {
        $widget = $this->widget();
        include(betterPath(__FILE__, 2) . 'views/widget_orderConfirm.php');
    }

    public function orderPayment_form()
    {
        $widget = $this->widget();
        include(betterPath(__FILE__, 2) . 'views/widget_orderPayment.php');
    }
    public function get_orderID_by_domainName(object $domainObject, $domainName)
    {
        return ($domainObject->fetchByName($domainName)->domains->{0}->id) ?? null;
    }

    public function orderDomain($nameservers, $auth)
    {
        # Đăng nhập
        $dangnhap = new Login($auth->username, $auth->password);
        # Import dữ liệu (tên domain người dùng nhập và nameservers config)
        $data = betterStd([
            'domain' => trim($_POST['domain'] ?? ''),
            'nameservers' => $nameservers,
        ]);
        # Tạo Object Domain
        $dangkytenmien = new Domain($dangnhap->getToken());


        # Đặt hàng
        $order_status = $dangkytenmien->order($data->domain, 70, betterExplode($data->nameservers));

        # Kiểm tra order có bị trễ do server không
        $flag = false;
        $msg = 'Lỗi server: timeout (order_status)';
        for ($i = 0; $i < 2; $i++) {
            # Dừng khoảng chừng là 0.3 giây ... :)) tránh spam request, server nghỉ chơi thì mệt
            sleep(0.15);
            # Nếu không tồn tại phản hồi thì $flag cứ false
            if (isset($order_status->response) && $order_status->response) {
                $flag = true;
                $msg = '';
                break;
            }
        }
        return [
            'order_response' => $order_status->response ?? '',
            'dangnhap' => $dangnhap,
            'dangkytenmien' => $dangkytenmien,
            'data' => $data,
            'flag' => $flag,
            'msg' => $msg
        ];
    }
    // public function get_orderID_by_invoice(object $invoiceObject, int $id)
    // {
    //     return $invoiceObject->fetch($id)->invoice->items->{0}->item_id;
    // }
}
