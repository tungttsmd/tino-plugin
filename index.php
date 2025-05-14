<?php

/**
 * Plugin Name: Tino plugin
 * Description: Dùng shortcode [webo_bang_gia] để lấy bảng giá tên miền; [webo_dang_ky] để lấy form đăng ký tên miền
 * Version: 1.3.0
 * Author: Trần Thanh Tùng
 * Config: Cấu hình Đăng nhập, Nameserver và chiều cao của Bảng giá ở file config.php
 * Vesion log: chi tiết cập nhật tại file version_log.txt
 */

if (!defined('ABSPATH')) {
    exit; // Ngăn truy cập trực tiếp
}

add_action('init', function () {
    require plugin_dir_path(__FILE__) . 'plugin_function/function.php';
});


add_shortcode('webo_bang_gia', 'shortcode_BangGia');
add_shortcode('webo_dang_ky', 'shortcode_DangKy');
add_shortcode('webo_hoa_don', 'shortcode_HoaDon');


# Lấy return
function MOTHERFUCKER_callback()
{
    // Xử lý yêu cầu AJAX ở đây
    //////////////////////////////////////////////////////////////////
    # Load file cấu hình
    require(plugin_dir_path(__FILE__) . 'system/autoload.php');

    # Lấy dữ liệu
    $configData = [
        $_POST['domainInput'] ?? '',
        $config_nameservers,
        $config_username,
        $config_password
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
    ////////////////////////////////////////////////////////////////

    // if (isset($_POST['ajaxConfirm']) && $_POST['ajaxConfirm'] == 'true') {
    // Gửi lại kết quả
    wp_send_json(array('invoiceID' => $invoiceID ?? '', 'hoadonUrl' => $config_invoiceDraw ?? ''));
    // }
}
function DOMAINORDER_callback()
{
    // Xử lý yêu cầu AJAX ở đây
    //////////////////////////////////////////////////////////////////
    # Load file cấu hình
    require(plugin_dir_path(__FILE__) . 'system/autoload.php');

    # Lấy dữ liệu
    $configData = [
        $_POST['domainInput'] ?? '',
        $config_nameservers,
        $config_username,
        $config_password
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

    // $something = OrderController::make()->run(...$programData)?? '';
    # Xử lý và thực thi chương trìnhs
    wp_send_json(array('invoiceID' => $response->invoice_id, 'hoadonUrl' => $config_invoiceDraw ?? ''));
}
# Lấy url
function my_enqueue_scripts()
{
    wp_enqueue_script('xem_hoa_don_script', plugin_dir_url(__FILE__) . 'views/xem-hoa-don.js', array('jquery'), null, true);
    wp_enqueue_script('dat_domain_script', plugin_dir_url(__FILE__) . 'views/dat-domain.js', array('jquery'), null, true);

    // Đưa URL wp-admin ajax vào JavaScript
    wp_localize_script('xem_hoa_don_script', 'MOTHERFUCKEROBJECTAJAX', array(
        'ajaxurl' => admin_url('admin-ajax.php') // URL của admin-ajax.php
    ));
    wp_localize_script('dat_domain_script', 'DOMAINORDEROBJECTAJAX', array(
        'ajaxurl' => admin_url('admin-ajax.php')
    ));
}

# Đăng ký một đống thứ vớ vẩn
add_action('wp_ajax_MOTHERFUCKER', 'MOTHERFUCKER_callback');
add_action('wp_ajax_nopriv_MOTHERFUCKER', 'MOTHERFUCKER_callback'); // Dành cho người dùng không đăng nhập
add_action('wp_ajax_DOMAINORDER', 'DOMAINORDER_callback');
add_action('wp_ajax_nopriv_DOMAINORDER', 'DOMAINORDER_callback'); // Dành cho người dùng không đăng nhập

add_action('wp_enqueue_scripts', 'my_enqueue_scripts');
