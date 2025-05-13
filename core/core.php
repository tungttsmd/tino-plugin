<?php
# CHỨC NĂNG ĐĂNG KY -> THANH TOÁN DOMAIN
function core_autoload()
{
    include_once(betterPath(__FILE__, 1) . 'system/ApiClient.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Login.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Domain.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Invoice.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Tld.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Pricing.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Ticket.php');
    include_once(betterPath(__FILE__, 1)  . 'models/Config.php');
}
function alert($content, $type = 'warning')
{
    $msg = $content;
    $color = '';
    switch ($type) {
        case 'warning':
            $color = '#fff3cd';
            $text = '#664d03';
            break;
        case 'success':
            $color = '#d4edda';
            $text = '#198754';
            break;
        case 'danger':
            $color = '#f8d7da';
            $text = 'dc3545';
            break;
        case 'info':
            $color = '#d1ecf1';
            $text = '664d03';
            break;
        default:
            $color = '#ffc107';
            $text = '664d03';
    }
    include(betterPath(__FILE__, 1) . 'views/widget_alert.php');
}