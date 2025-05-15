<?php
class AjaxController
{
    use BaseService;

    public function invoiceDraw($domainName, $nameservers, $username, $password)
    {
        # Lấy dữ liệu
        $configData = [
            $domainName,
            $nameservers,
            $username,
            $password
        ];

        # Khởi tạo, nén dữ liệu
        $action = OrderAction::make()
            ->orderInit(...$configData);

        # Giải nén dữ liệu
        extract($action); # $color, $widget, $nameserver, $auth, $msg, $flag đều nằm đây

        $programData = [
            $widget_data,
            $nameservers,
            $auth,
            $config_nameservers,
            $msg,
            $color
        ];
        # Xử lý và thực thi chương trình
        $invoiceID = OrderController::make()->run(...$programData);

        return [
            'invoiceID' => $invoiceID,
        ];
    }
    public function orderDomain($domainName, $nameservers, $username, $password)
    {
        # Lấy dữ liệu
        $configData = [
            $domainName,
            $nameservers,
            $username,
            $password
        ];

        # Khởi tạo, nén dữ liệu
        $action = OrderAction::make()
            ->orderInit(...$configData);

        # Giải nén dữ liệu
        extract($action); # $color, $widget, $nameserver, $auth, $msg, $flag đều nằm đây

        $programData = [
            $widget_data,
            $nameservers,
            $auth,
            $config_nameservers,
            $msg,
            $color
        ];

        $service = OrderService::make()
            ->orderDomain($nameservers, $auth); # DANG DEBUG

        $response = json_decode(betterStd($service)->order_response);

        return [
            'response' => $response
        ];
    }
}
