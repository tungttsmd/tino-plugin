<?php
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