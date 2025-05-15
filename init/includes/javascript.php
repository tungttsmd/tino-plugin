<?php
function javascript_include_wp_style()
{
    $plugin_js_path = dirname(dirname(plugin_dir_url(__FILE__))) . '/views/javascripts/app/';

    wp_enqueue_script('DataPackApp', $plugin_js_path . 'Models/DataPack.js', array('jquery'), null, true);
    wp_enqueue_script('DataPackBuilderApp', $plugin_js_path . 'Builders/DataPackBuilder.js', array('DataPackApp'), null, true);
    wp_enqueue_script('AjaxServiceApp', $plugin_js_path . 'Services/AjaxPack.js', array('jquery'), null, true);

    wp_enqueue_script('index_javascripts', dirname(dirname(plugin_dir_url(__FILE__))) . '/views/javascripts/index.js', array('DataPackApp', 'DataPackBuilderApp', 'AjaxServiceApp'), null, true);

    // Đưa URL wp-admin ajax vào JavaScript (Sử dụng wp_localize_script() để truyền biến PHP sang JS → chuẩn WordPress.)
    wp_localize_script('index_javascripts', 'ajaxPackages', array(
        'adminAjaxUrl' => admin_url('admin-ajax.php') // URL của admin-ajax.php
    ));
}
