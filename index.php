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

// add_filter('the_content', 'wp_ajax_button', 1);
// function wp_ajax_button($content)
// {
?>
    <!-- <script type="text/javascript">
        jQuery(document).ready(function($) {
            jQuery(".wp-ajax-action").on("click", function(event) {
                var wp_ajax_url = '<?php // echo admin_url("admin-ajax.php"); ?>';

                jQuery.ajax({
                    url: wp_ajax_url,
                    type: "POST",
                    data: {
                        action: "wp_ajax_button",
                        button: "orderConfirm",
                        domain: "tunggvmdcsađá.vn"
                    },
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) {
                        console.log(data);
                        console.log(jQuery("#drawHere"));
                        jQuery("#drawHere").html(data.html);
                        jQuery("#drawHere").html(dang_ky_domain());
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });



                return false;
            })
        });
    </script> -->
<?php
//     $btn_html = '<div id="wp-ajax-button"><a class="wp-ajax-action" href="#">Bấm nút</a></div>';
//     $new_content = $content . $btn_html;
//     return $new_content;
// }


// function wp_ajax_button_display()
// {
//     header("Content-Type: application/json", true);
//     $arr_response = array();

//     # Load file cấu hình
//     require(plugin_dir_path(__FILE__) . '/system/autoload.php');
//     require(plugin_dir_path(__FILE__) . '/plugin_function/DangKy.php');

//     $html = dang_ky_domain();

//     $arr_response = array(
//         'res' => 'Ajax thành công!!!'
//     );
//     wp_send_json([
//         'response' => $arr_response,
//         'status' => 'ok',
//         'html' => $html
//     ]);
//     die();
// }




// add_action('wp_ajax_wp_ajax_button', 'wp_ajax_button_display');
// add_action('wp_ajax_nopriv_wp_ajax_button', 'wp_ajax_button_display');

add_shortcode('webo_bang_gia', 'shortcode_BangGia');
add_shortcode('webo_dang_ky', 'shortcode_DangKy');
