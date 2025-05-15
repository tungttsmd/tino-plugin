<?php
# A. Hướng dẫn shortcode
/** 
 * Trang đăng ký đặt [webo_dang_ky]
 * Trang in hoá đơn đặt [webo_hoa_don]
 * Nơi đặt [webo_bang_gia] sẽ hiển thị iframe bảng giá
 */

# B. Cấu hình shortcode 
// Nhập url trang vẽ hoá đơn (trang đặt [webo_hoa_don]) (nếu để rỗng sẽ lấy [webo_dang_ky] để vẽ).
$config_invoiceDraw = 'http://localhost/etb/hoa-don';

# C. Cấu hình dữ liệu
// Nhập tài khoản tự đăng nhập Tino.org ở đây
$config_username = 'thanhtung.tran2k@gmail.com';
$config_password = '123123123';

// Nhập nameservers ở đây
$config_nameservers =  'dexter.ns.cloudflare.com, nelly.ns.cloudflare.com';

// Tuỳ chỉnh chiều cao theo số cột mong muốn (BẢNG GIÁ)
$config_rowTable = 8;
