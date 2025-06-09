<?php
// Nhập tài khoản tự đăng nhập Tino.org ở đây
$config_username = 'thanhtung.tran2k@gmail.com';
$config_password = '123123123';


// Trang đăng ký đặt [webo_dang_ky] -> Trang in hoá đơn đặt [webo_hoa_don]

// Nhập url trang vẽ hoá đơn (trang đặt [webo_hoa_don]) (nếu để rỗng sẽ lấy [webo_dang_ky] để vẽ).
$config_invoicePrintUrl = 'http://localhost/etb/hoa-don';


// Nhập nameservers ở đây
$config_nameservers =  [
    'dexter.ns.cloudflare.com',
    'nelly.ns.cloudflare.com'
];

// Tuỳ chỉnh chiều cao theo số cột mong muốn (BẢNG GIÁ)
$config_tableHeight = 8; // đơn vị hàng


define("CONFIG_USERNAME", $config_username);
define("CONFIG_PASSWORD", $config_password);
define("CONFIG_NAMESERVERS", $config_nameservers);
define("CONFIG_TABLE_HEIGHT", $config_tableHeight);
define("CONFIG_INVOICE_PRINT_URL", $config_invoicePrintUrl);
define("PLUGIN_PATH", rtrim(str_replace('\\', '/', __DIR__), '/') . '/');
define('PLUGIN_URI', rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/');
