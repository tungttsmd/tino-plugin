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
            $config_tlds,
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

    public function orderNewForm($domainName, $nameservers, $username, $password)
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
        $formData = OrderAction::make()
            ->ajaxNewForm($widget_data, $msg, $color);

        return $formData;
    }
    public function orderCheckForm($domainName, $nameservers, $config_tlds, $username, $password)
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
            $config_tlds,
            $widget_data,
            $nameservers,
            $auth,
            $config_nameservers,
            $msg,
            $color
        ];
        ob_flush();
        $formData = OrderAction::make()
            ->ajaxCheckForm($domainName ?? '', $nameservers, $auth, $widget_data);
        ob_end_clean();
        return $formData;
    }
}
