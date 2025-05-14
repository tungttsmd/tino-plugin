<?php
class OrderAction
{
    use BaseService;
    public function orderPayment($domainNanme, $nameservers, $auth, $widget_data)
    {
        # Import dữ liệu (tên domain người dùng nhập và nameservers config)
        $data = DomainService::make()
            ->importCoreData($domainNanme, $nameservers);

        # Tạo đối tượng
        $dangnhap = new Login($auth->username, $auth->password);
        $dangkytenmien = new Domain($dangnhap->getToken());
        $hoadon = new Invoice($dangnhap->getToken());

        # Tự động convert về .vn (phòng hờ khi người dùng không nhập đuôi)
        $lookup = DomainService::make()
            ->lookup($dangkytenmien, $data);

        # Lấy orderID (dùng domain name để lấy)
        $orderID_by_domain_name = OrderService::make()
            ->get_orderID_by_domainName($dangkytenmien, $lookup->name);

        # Lấy $invoice_id
        $order_invoice_id = OrderService::make()
            ->get_order_invoice_id_by_comparing_scan($hoadon, $orderID_by_domain_name);

        # Vẽ hoá đơn
        $invoice_html = InvoiceService::make()
            ->data($widget_data)
            ->draw_invoice($hoadon, $order_invoice_id);
        echo $invoice_html;

        # Kết thúc luồng: orderPayment

    }
    public function orderConfirm($nameservers, $auth, $widget_data)
    {
        # Chỉ khi nào không flag nào true, nút này mới được tạo
        # DEBUG - SECURIY tiềm ẩn: chưa fix lỗi @csrf, nghĩa là nếu tạo ở F12 Chrome nút value = orderConfirm vẫn có thể truy cập vào đây

        $service = OrderService::make()
            ->orderDomain($nameservers, $auth); # DANG DEBUG

        $response = json_decode(betterStd($service)->order_response);
        
        return $response->invoice_id ?? '';
    }
    public function orderNew($domainName, $nameservers, $auth, $widget_data)
    {
        $flag = true;
        $color = 'warning';

        # Kiểm tra tên miền có để trống không
        if (betterEmpty_list([$domainName])) {
            $flag = false;
            $msg = 'Dữ liệu không được có giá trị rỗng hoặc để trống';
        }

        if ($flag) {
            # Import dữ liệu (tên domain người dùng nhập và nameservers config)
            $data = DomainService::make()
                ->importCoreData($domainName, $nameservers);

            # Xác minh đăng nhập (lấy token)
            $dangnhap = new Login($auth->username, $auth->password);

            # Kiểm tra đăng nhập 
            if (!$dangnhap->isLogin()) {
                $flag = false;
                $msg = 'Cấu hình thông tin đăng nhập không đúng, vui lòng sửa lại trong config.php!';
            }

            if ($flag) {
                # Tạo đối tượng Domain
                $dangkytenmien = new Domain($dangnhap->getToken());

                # Tạo đối tượng tra cứu
                $lookup = $dangkytenmien->lookup($data->domain);

                # Kiểm tra xem trong giỏ hàng có đơn hàng tên miền này chưa, nếu có rồi thì không khả dụng với khách hàng
                if (isset($lookup->domain) && $dangkytenmien->domainNameExist($lookup->domain)) {
                    $flag = false;
                    $msg = 'Tên miền không khả dụng. Tên miền này bạn đã đặt và đang chờ thanh toán. Bấm [Xem hoá đơn] để xem chi tiết';
                    $widget_data->data->domain = $lookup->domain;
                }
                # Phòng ngừa người dùng nhập tld rỗng, tự ghép .vn vào (lookup->domain sẽ không tồn tại nếu lookup không thành công)

                if ($flag) {
                    # Kiểm tra tld hợp lệ & có hỗ trợ hay không
                    if (isset($lookup->error->{0}) && ($lookup->error->{0} === 'incorrect_tld' || $lookup->error->{0} === 'invalid_name')) {
                        $flag = false;
                        $msg = 'Tên miền không khả dụng. Tên miền không hợp lệ hoặc đuôi tên miền không được hỗ trợ';
                        $color = 'danger';
                    }
                    # Kiểm tra liệu tên miền có ai sở hữu chưa hoặc lỗi ngoại lệ khiến nó không được hỗ trợ để đăng ký trên hệ thống tên miền chung
                    elseif (isset($lookup->avaliable) && $lookup->avaliable == false) {
                        $flag = false;
                        $msg = 'Tên miền không khả dụng. Tên miền không hợp lệ hoặc đã được người khác sở hữu';
                    }
                    # BUG tiềm ẩn: Làm sao kiểm tra một tên miền đã được đặt bởi người khác? (chưa tìm ra)
                    elseif (0 == 1) {
                        $flag = false;
                        $msg = 'Tên miền không khả dụng. Tên miền này đã được đặt bởi người khác';
                    }

                    # Dự phòng nếu người dùng không nhập đuôi, hệ thống mặc định convert về đuôi .vn

                    # Xác minh tên miền khả dụng
                    if ($flag) {
                        # Truyền thông tin khả dụng cho widget
                        $widget_data->data->domain = $lookup->name;

                        # Đưa lại biểu mẫu đặt hàng
                        OrderService::make()
                            ->data($widget_data)
                            ->orderConfirm_form();
                        # Lưu trữ dữ liệu cần thiết để thông báo
                        $domainInfo = WidgetService::make()
                            ->widgetAlert($lookup);
                        # Báo lỗi tên miền đã được ai đó sở hữu
                        alert("Tên miền $domainInfo->domain có thể đăng ký. Giá: $domainInfo->payment_total VND. Bấm [Tiến hành đặt hàng] để mua tên miền này", 'success');
                    } else {
                        # Đưa lại biểu mẫu để sửa tên miền phù hựp
                        OrderService::make()
                            ->data($widget_data)
                            ->orderNew_form();
                        # Báo lỗi tên miền đã được ai đó sở hữu
                        alert($msg, $color);
                    }
                } else {
                    # Đưa biểu mẫu có nút thanh toán
                    OrderService::make()
                        ->data($widget_data)
                        ->orderPayment_form();
                    # Báo là đơn hàng chờ thanh toán
                    alert($msg);
                }
            } else {
                # Đưa lại biểu mẫu (không dùng được vì đăng nhập không thành công)
                OrderService::make()
                    ->data($widget_data)
                    ->orderNew_form();
                # Báo lỗi Thông tin đăng nhập không đúng
                alert($msg, 'danger');
            }
        } else {
            # Đưa lại biểu mẫu để sửa tên miền
            OrderService::make()
                ->data($widget_data)
                ->orderNew_form();
            # Báo lỗi tên đang miền để trống hoặc giá trị rỗng
            alert($msg);
        }
    }
    public function orderFormDraw($widget_data, $msg, $color)
    {
        OrderService::make()
            ->data($widget_data)
            ->orderNew_form();
        if (isset($msg) && !empty($msg)) {
            alert($msg, $color);
        };
    }
    public function orderInvoiceDraw($invoice_id, $auth, $widget_data)
    {
        # Tạo đối tượng
        $dangnhap = new Login($auth->username, $auth->password);
        $hoadon = new Invoice($dangnhap->getToken());


        # Vẽ hoá đơn
        $invoice_html = InvoiceService::make()
            ->data($widget_data)
            ->draw_invoice($hoadon, $invoice_id);
        return $invoice_html;

        # Kết thúc luồng: orderPayment

    }
    public function orderInit($domainName, $nameservers, $username, $password)
    {
        # Core 1: Khởi tạo cờ (Mở debug = cách thêm query String ?debug ở thanh nhập URL)
        $flag = true; # khởi tạo flag
        $msg = ''; # khởi tạo flag
        $color = 'warning';

        if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['noload']) && $_POST['noload'] === "load") {
            $msg = "Đang đợi thanh toán...";
            $color = "success";
        }

        # Core 2: Cấu hình đăng nhập & nameservers
        $auth = betterStd([
            'username' => $username,
            'password' => $password
        ]);
        // $widget_data = betterStd(['data' => ['domain' => trim($_POST['domain'] ?? ''), 'nameservers' => $nameservers,], 'login' => (array) $auth]);

        # Core 3: Lưu trữ dữ liệu
        $_POST['nameservers'] = betterStd(betterExplode($nameservers)); # Dữ liệu cấu hình nameservers
        $_POST['auth'] = $auth; # Dữ liệu cấu hình đăng nhập
        $_POST['widget'] = ''; # Lưu trữ dữ liệu dùng cho widget

        # Import dữ liệu cho widget
        $widget_data = WidgetService::make()
            ->widgetImportData($domainName, $nameservers, $auth);

        return [
            'auth' => $auth,
            'nameservers' => $nameservers,
            'widget_data' => $widget_data,
            'flag' => $flag,
            'msg' => $msg,
            'color' => $color,

        ];
    }
}
