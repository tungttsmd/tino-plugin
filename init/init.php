<?php
require(plugin_dir_path(__FILE__) . 'includes/javascript.php');
require(plugin_dir_path(__FILE__) . 'includes/ajax.php');
require(plugin_dir_path(__FILE__) . 'shortcodes/init.php');

# Đăng ký một đống thứ shortcode cần thiết
add_shortcode('webo_bang_gia', 'shortcode_BangGia');
add_shortcode('webo_dang_ky', 'shortcode_DangKy');
add_shortcode('webo_hoa_don', 'shortcode_HoaDon');

# Đăng ký một đống thứ Ajax vớ vẩn
add_action('wp_ajax_DOMAINPAYMENT', 'DOMAINPAYMENT_callback');
add_action('wp_ajax_nopriv_DOMAINPAYMENT', 'DOMAINPAYMENT_callback'); // Dành cho người dùng không đăng nhập
add_action('wp_ajax_DOMAINORDER', 'DOMAINORDER_callback');
add_action('wp_ajax_nopriv_DOMAINORDER', 'DOMAINORDER_callback'); // Dành cho người dùng không đăng nhập

# Đăng ký tải javascript
add_action('wp_enqueue_scripts', 'javascript_include_wp_style');
