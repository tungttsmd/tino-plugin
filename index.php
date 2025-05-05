<?php

/**
 * Plugin Name: Tino plugin
 * Description: Dùng shortcode [bang_gia] để lấy bảng giá tên miền; [dang_ky] để lấy form đăng ký tên miền
 * Version: 1.2
 * Author: Trần Thanh Tùng
 * Config: Cấu hình Đăng nhập, Nameserver và chiều cao của Bảng giá ở file config.php
 */

if (!defined('ABSPATH')) {
    exit; // Ngăn truy cập trực tiếp
}


add_action('init', function () {
    require_once plugin_dir_path(__FILE__) . 'plugin_function/function.php';
});

add_shortcode('webo_bang_gia', 'shortcode_BangGia');
add_shortcode('webo_dang_ky', 'shortcode_DangKy');
