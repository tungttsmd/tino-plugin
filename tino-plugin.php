<?php

/**
 * Plugin Name: Tino plugin
 * Description: Dùng shortcode [webo_bang_gia] để lấy bảng giá tên miền; [webo_dang_ky] để lấy form đăng ký tên miền
 * Version: 1.3.3
 * Author: Trần Thanh Tùng
 * Config: Cấu hình Đăng nhập, Nameserver và chiều cao của Bảng giá ở file config.php
 * Vesion log: chi tiết cập nhật tại file version_log.txt
 */

if (!defined('ABSPATH')) {
    exit; // Ngăn truy cập trực tiếp
}

require plugin_dir_path(__FILE__) . "vendor/autoload.php";

$plugin = new Includes\Plugin();
