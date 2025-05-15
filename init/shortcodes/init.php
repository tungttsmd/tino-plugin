<?php
function shortcode_BangGia()
{
    ob_start();
    include plugin_dir_path(__FILE__) . '/BangGia.php';
    return ob_get_clean();
};
function shortcode_DangKy()
{
    ob_start();
    include plugin_dir_path(__FILE__) . '/DangKy.php';
    return ob_get_clean();
};
function shortcode_HoaDon()
{
    ob_start();
    include plugin_dir_path(__FILE__) . '/HoaDon.php';
    return ob_get_clean();
};
