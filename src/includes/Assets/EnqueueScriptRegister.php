<?php

namespace Includes\Assets;

class EnqueueScriptRegister
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'my_enqueue_scripts']);
    }
    # Lấy url
    public function my_enqueue_scripts()
    {
        wp_enqueue_script('xem_hoa_don_script', plugins_url('src/app/Views/xem-hoa-don.js', dirname(__FILE__, 3)), array('jquery'), null, true);
        wp_enqueue_script('fetch_control_script', plugins_url('src/public/js/fetchControl.js', dirname(__FILE__, 3)), array('jquery'), null, true);
        wp_enqueue_script('binder_control_script', plugins_url('src/public/js/buttonBinder.js', dirname(__FILE__, 3)), array('jquery'), null, true);

        # Gửi kèm biến số cho từng script admin-ajax sử dụng
        $data =  array(
            'adminAjaxUrl' => admin_url('admin-ajax.php'), // URL của admin-ajax.php
            'invoicePrintUrl' => CONFIG_INVOICE_PRINT_URL
        );
        wp_localize_script('xem_hoa_don_script', 'scriptReceiver', $data);
        wp_localize_script('fetch_control_script', 'scriptReceiver', $data);
        wp_localize_script('binder_control_script', 'scriptReceiver', $data);
    }
}
