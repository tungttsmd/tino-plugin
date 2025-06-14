<?php

namespace Includes\Assets;

use WordPressCS\WordPress\Helpers\WPDBTrait;

class EnqueueRegister
{
    private $sendPack;
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'my_enqueue_scripts']);
        add_action('wp_enqueue_scripts', [$this, 'my_enqueue_styles']);

        # Gửi kèm biến số cho từng script admin-ajax sử dụng
        $this->sendPack =  array(
            'adminAjaxUrl' => admin_url('admin-ajax.php'), // URL của admin-ajax.php
            'invoicePrintUrl' => CONFIG_INVOICE_PRINT_URL,
            'orderFormUrl' => CONFIG_ORDER_FORM_URL
        );
    }
    # Lấy url
    public function my_enqueue_scripts()
    {
        wp_enqueue_script('tino-plugin.js', plugins_url('src/public/js/tino-plugin.js', dirname(__FILE__, 3)), array('jquery'), time(), true);
        wp_localize_script('tino-plugin.js', 'scriptReceiver', $this->sendPack);
    }
    public function my_enqueue_styles()
    {
        wp_enqueue_style('tino-plugin', plugins_url('src/public/css/tino-plugin.css', dirname(__FILE__, 3)), array(), '1.0.0');
    }
}
