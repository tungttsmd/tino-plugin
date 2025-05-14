<?php
function shortcode_BangGia()
{
    ob_start();
    include 'BangGia.php';
    return ob_get_clean();
}
function shortcode_DangKy()
{
    ob_start();
    include 'DangKy.php';
    return ob_get_clean();
}