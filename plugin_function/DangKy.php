<?php
# Core 0: Load file cấu hình
require_once(dirname(plugin_dir_path(__FILE__)) . '/system/autoload.php');
require_once(dirname(plugin_dir_path(__FILE__)) . '/config.php');

# Core 1: Khởi tạo cờ (Mở debug = cách thêm query String ?debug ở thanh nhập URL)
$flag = true; # khởi tạo flag
$msg = ''; # khởi tạo flag
$color = 'warning';

# Core 2: Cấu hình đăng nhập & nameservers
$nameservers = $config_nameservers;
$auth = betterStd([
    'username' => $config_username,
    'password' => $config_password
]);
$widget_data = betterStd(['data' => ['domain' => trim($_POST['domain'] ?? ''), 'nameservers' => $nameservers,], 'login' => (array) $auth]);

# Core 3: Lưu trữ dữ liệu
$_POST['nameservers'] = betterStd(betterExplode($nameservers)); # Dữ liệu cấu hình nameservers
$_POST['auth'] = $auth; # Dữ liệu cấu hình đăng nhập
$_POST['widget'] = ''; # Lưu trữ dữ liệu dùng cho widget

# Core 4: Xử lí dữ liệu (debug trong này thoải mái) (chuẩn PRG (Post → Redirect → Get))
if ($_SERVER['REQUEST_METHOD'] !== 'POST' && !isset($_GET['invoice_id'])) {
    # Truyền dữ liệu cho widget xử lí (mỗi lần bấm submit là mất sạch $_POST, phải gán lại trước)
    $_POST['widget'] = $widget_data = betterStd(['data' => ['domain' => trim($_POST['domain'] ?? ''), 'nameservers' => $nameservers,], 'login' => (array) $auth]);

    # Nhúng form order
    orderNew_form();
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderOther')) {
    wp_redirect(esc_url(add_query_arg('reloaded', time(), $_SERVER['REQUEST_URI'])));
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['button'] === 'orderNew')) {
    debug_0();
    # Truyền dữ liệu cho widget xử lí (mỗi lần bấm submit là mất sạch $_POST, phải gán lại trước)
    $_POST['widget'] = $widget_data = betterStd(['data' => ['domain' => trim($_POST['domain'] ?? ''), 'nameservers' => $nameservers,], 'login' => (array) $auth]);

    # Kiểm tra tên miền có để trống không
    if (betterEmpty_list($_POST)) {
        $flag = false;
        $msg = 'Dữ liệu không được có giá trị rỗng hoặc để trống';
    }

    if ($flag) {
        # Import dữ liệu (tên domain người dùng nhập và nameservers config)
        $data = import_core_data($config_nameservers);

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
                $_POST['widget']->data->domain = $lookup->domain;
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
                    $_POST['domain'] = trim($lookup->name);
                    $_POST['widget']->data->domain = $lookup->name;

                    # Đưa lại biểu mẫu đặt hàng
                    orderConfirm_form();
                    # Lưu trữ dữ liệu cần thiết để thông báo
                    $domainInfo = betterStd([
                        'domain' => $lookup->name,
                        'sld' => $lookup->sld,
                        'tld' => $lookup->tld,
                        'isOwned?' => !$lookup->avaliable,
                        'tld_id' => $lookup->tld_id,
                        'years' => $lookup->periods->{0}->period,
                        # Tên miền .vn ở khi fetch từ tino ra giá 57K? -> cần fix lại 450.000 theo bảng giá Tino
                        'payment_total' => number_format($lookup->tld === '.vn' ? "450000" : $lookup->periods->{0}->register, 0, ',', '.'),
                    ]);
                    # Báo lỗi tên miền đã được ai đó sở hữu
                    alert("Tên miền $domainInfo->domain có thể đăng ký. Giá: $domainInfo->payment_total VND. Bấm [Tiến hành đặt hàng] để mua tên miền này", 'success');
                } else {
                    # Đưa lại biểu mẫu để sửa tên miền phù hựp
                    orderNew_form();
                    # Báo lỗi tên miền đã được ai đó sở hữu
                    alert($msg, $color);
                }
            } else {
                # Đưa biểu mẫu có nút thanh toán
                orderPayment_form();
                # Báo là đơn hàng chờ thanh toán
                alert($msg);
            }
        } else {
            # Đưa lại biểu mẫu (không dùng được vì đăng nhập không thành công)
            orderNew_form();
            # Báo lỗi Thông tin đăng nhập không đúng
            alert($msg, 'danger');
        }
    } else {
        # Đưa lại biểu mẫu để sửa tên miền
        orderNew_form();
        # Báo lỗi tên đang miền để trống hoặc giá trị rỗng
        alert($msg);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderConfirm') {
    # Chỉ khi nào không flag nào true, nút này mới được tạo
    # BUG tiềm ẩn: chưa fix lỗi @csrf, nghĩa là nếu tạo ở F12 Chrome nút value = orderConfirm vẫn có thể truy cập vào đây

    debug_0();
    # Truyền dữ liệu cho widget xử lí (mỗi lần bấm submit là mất sạch $_POST, phải gán lại trước)
    $_POST['widget'] = $widget_data = betterStd(['data' => ['domain' => trim($_POST['domain'] ?? ''), 'nameservers' => $nameservers,], 'login' => (array) $auth]);

    # Đăng nhập
    $dangnhap = new Login($auth->username, $auth->password);
    # Import dữ liệu (tên domain người dùng nhập và nameservers config)
    $data = import_core_data($config_nameservers);
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

    if ($flag) {
        # Tạo đối tượng hoá đơn
        $hoadon = new Invoice($dangnhap->getToken());

        # Lấy orderID (dùng domain name để lấy)
        $orderID_by_domain_name = get_orderID_by_domainName($dangkytenmien, $data->domain);

        # Kiểm tra invoice có bị trễ do server không (2 lần check thời gian dài đủ để đợi phản hồi api) ƯỚC CHỪNG THÔI ~ có thể sẽ lại Bug
        $flag = false;
        $msg = 'Lỗi server: timeout (invoice_id)';
        for ($i = 0; $i < 2; $i++) {
            # Dừng khoảng chừng là 0.3 giây ...  :)) tránh spam request, server nghỉ chơi thì mệt
            sleep(0.15);
            # Lấy $invoice_id với domain name để scan
            $order_invoice_id = get_order_invoice_id_by_comparing_scan($hoadon, $orderID_by_domain_name);
            # Nếu không dò được nó trả null. Nếu dò được trả invoice_id -> thì order thì lấy luôn hoá đơn. 
            if ($order_invoice_id) {
                $flag = true;
                $msg = '';
                break;
            };
        }

        if ($flag) {
            # Tới đây thì đã có $order_invoice_id => điều hướng GET tới trang xem hoá đơn thành công
            wp_redirect(add_query_arg('invoice_id', $order_invoice_id, esc_url($_SERVER['REQUEST_URI'])));
            exit;

            # Kết thúc luồng thành công
        } else {
            # Nhúng form order
            orderNew_form();
            # Đưa thông báo lỗi $invoice_id: server: timeout invoice có bị trễ do server
            alert($msg);
        }
    } else {
        # Nhúng form order
        orderNew_form();
        # Đưa thông báo lỗi $order_status: server: timeout order có bị trễ do server
        alert($msg);
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['button'] === 'orderPayment') {
    # Truyền dữ liệu cho widget xử lí (mỗi lần bấm submit là mất sạch $_POST, phải gán lại trước)
    $_POST['widget'] = $widget_data = betterStd(['data' => ['domain' => trim($_POST['domain'] ?? ''), 'nameservers' => $nameservers,], 'login' => (array) $auth]);

    # Import dữ liệu (tên domain người dùng nhập và nameservers config)
    $data = import_core_data($config_nameservers);

    # Tạo đối tượng
    $dangnhap = new Login($auth->username, $auth->password);
    $dangkytenmien = new Domain($dangnhap->getToken());
    $hoadon = new Invoice($dangnhap->getToken());

    # Tự động convert về .vn (phòng hờ khi người dùng không nhập đuôi)
    $lookup = $dangkytenmien->lookup($data->domain);

    # Lấy orderID (dùng domain name để lấy)
    $orderID_by_domain_name = get_orderID_by_domainName($dangkytenmien, $lookup->name);

    # Lấy $invoice_id
    $order_invoice_id = get_order_invoice_id_by_comparing_scan($hoadon, $orderID_by_domain_name);

    # Điều hướng trang với query string =  $invoice_id
    wp_redirect(add_query_arg('invoice_id', $order_invoice_id, esc_url($_SERVER['REQUEST_URI'])));
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['invoice_id'])) {
    # Truyền dữ liệu cho widget xử lí (mỗi lần bấm submit là mất sạch $_POST, phải gán lại trước)
    $_POST['widget'] = $widget_data = betterStd(['data' => ['domain' => trim($_POST['domain'] ?? ''), 'nameservers' => $nameservers,], 'login' => (array) $auth]);

    # Tạo đối tượng hoá đơn
    $dangnhap = new Login($auth->username, $auth->password);
    $hoadon = new Invoice($dangnhap->getToken());
    # Đưa dữ liệu cho GET (để người dùng reload thoải mái)
    draw_invoice($hoadon, $_GET['invoice_id']);
}
