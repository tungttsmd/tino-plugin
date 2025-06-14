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
        // wp_enqueue_script('xem_hoa_don_script', plugins_url('src/app/Views/xem-hoa-don.js', dirname(__FILE__, 3)), array('jquery'), time(), true);
        wp_enqueue_script('fetch_control_script', plugins_url('src/public/js/tino-fetchControl.js', dirname(__FILE__, 3)), array('jquery'), time(), true);
        wp_enqueue_script('binder_control_script', plugins_url('src/public/js/tino-binder.js', dirname(__FILE__, 3)), array('jquery'), time(), true);
        wp_enqueue_script('utilityClass', plugins_url('src/public/js/tino-Utility.js', dirname(__FILE__, 3)), array('jquery'), time(), true);

        // wp_localize_script('xem_hoa_don_script', 'scriptReceiver', $data);
        wp_localize_script('fetch_control_script', 'scriptReceiver', $this->sendPack);
        wp_localize_script('binder_control_script', 'scriptReceiver', $this->sendPack);
    }
    public function my_enqueue_styles()
    {
        // wp_enqueue_style('enqSuggestionBar', plugins_url('src/public/css/SuggestionBar.css', dirname(__FILE__, 3)), array(), '1.0.0');
        wp_enqueue_style('enqWaitSpinner', plugins_url('src/public/css/tino-WaitSpinner.css', dirname(__FILE__, 3)), array(), '1.0.0');
        wp_enqueue_style('enqPaymentButton', plugins_url('src/public/css/tino-PaymentButton.css', dirname(__FILE__, 3)), array(), '1.0.0');
        wp_enqueue_style('enqInputUiBlock', plugins_url('src/public/css/tino-InputUiBlock.css', dirname(__FILE__, 3)), array(), '1.0.0');
        wp_enqueue_style('enqAlertBox', plugins_url('src/public/css/tino-alertBox.css', dirname(__FILE__, 3)), array(), '1.0.0');
    }
}
