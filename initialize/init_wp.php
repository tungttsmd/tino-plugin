<?php
require(plugin_dir_path(__FILE__) . 'includes/enqueueWP.php');
require(plugin_dir_path(__FILE__) . 'includes/ajaxUnsyncCallback.php');
require(plugin_dir_path(__FILE__) . 'shortcodes/shortcodeRegister.php');

# Đăng ký một đống thứ shortcode cần thiết
add_shortcode('webo_bang_gia', 'shortcode_BangGia');
add_shortcode('webo_dang_ky', 'shortcode_DangKy');
add_shortcode('webo_hoa_don', 'shortcode_HoaDon');

# Đăng ký một đống thứ Ajax vớ vẩn
add_action('wp_ajax_ajaxRequest_invoiceRender', 'ajaxRequest_invoiceRender_callback');
add_action('wp_ajax_nopriv_ajaxRequest_invoiceRender', 'ajaxRequest_invoiceRender_callback'); // Dành cho người dùng không đăng nhập
add_action('wp_ajax_ajaxRequest_domainOrder', 'ajaxRequest_domainOrder_callback');
add_action('wp_ajax_nopriv_ajaxRequest_domainOrder', 'ajaxRequest_domainOrder_callback'); // Dành cho người dùng không đăng nhập
add_action('wp_ajax_ajaxRequest_domainInspect', 'ajaxRequest_domainInspect_callback');
add_action('wp_ajax_nopriv_ajaxRequest_domainInspect', 'ajaxRequest_domainInspect_callback'); // Dành cho người dùng không đăng nhập
add_action('wp_ajax_ajaxRequest_suggestionCell', 'ajaxRequest_suggestionCell_callback');
add_action('wp_ajax_nopriv_ajaxRequest_suggestionCell', 'ajaxRequest_suggestionCell_callback'); // Dành cho người dùng không đăng nhập
add_action('wp_ajax_ajaxRequest_suggestionGetSld', 'ajaxRequest_suggestionGetSld_callback');
add_action('wp_ajax_nopriv_ajaxRequest_suggestionGetSld', 'ajaxRequest_suggestionGetSld_callback'); // Dành cho người dùng không đăng nhập

# Đăng ký load các file javascript tự viết custom
add_action('wp_enqueue_scripts', 'enqueue_scripts');
add_action('wp_enqueue_scripts', 'enqueue_styles');
